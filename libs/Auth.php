<?php
/**
 * @package Loyality Portal
 * @author Supme
 * @copyright Supme 2014
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
 *	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 *	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
 *	PURPOSE.
 *
 *	Please see the license.txt file for more information.
 *
 */

class Auth
{
    public $userName = 'Guest';
    public $is_login = false;
    public $groupName;
    public $right = false;
    private $db, $userId, $groupId;

    function __construct($db) {
        try {
            $this->db = Registry::get('db');
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }

        $this->sec_session_start();

        if($this->login_check()){
            $this->access_check(Registry::get('pageArray')['id']);
        }

    }

    private function sec_session_start() {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = SECURE;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === false) {
            header("Location: ../error/403");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"],
            $cookieParams["domain"],
            $secure,
            $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        session_regenerate_id();    // regenerated the session, delete the old one.
    }

    public function login($email, $password) {
        $user_id = '';
        $username = '';
        $db_password = '';
        $salt = '';
        // Using prepared statements means that SQL injection is not possible.
        if ($query = $this->db->prepare(
            "SELECT id, username, password, salt
              FROM authUsers
              WHERE email = ?
              LIMIT 1")
        ) {
            $result = $query->execute([$email]);    // Execute the prepared query.

            // get variables from result.
            $query->bindColumn('id',$this->userId);
            $query->bindColumn('username', $this->userName);
            $query->bindColumn('password', $db_password);
            $query->bindColumn('salt', $salt);
            $query->fetch();

            // hash the password with the unique salt.
            $password = hash('sha512', $password . $salt);
            if ($result) {
                // If the user exists we check if the account is locked
                // from too many login attempts

                if ($this->checkbrute($this->userId) == true) {
                    // Account is locked
                    // Send an email to user saying their account is locked
                    $this->is_login = false;
                } else {
                    // Check if the password in the database matches
                    // the password the user submitted.
                    if (trim($db_password) === $password) {
                        // Password is correct!
                        // Get the user-agent string of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // XSS protection as we might print this value
                        $this->userId = preg_replace("/[^0-9]+/", "", $this->userId);
                        $_SESSION['user_id'] = $this->userId;
                        // XSS protection as we might print this value
                        $this->userName = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $this->userName);
                        $_SESSION['username'] = $this->userName;
                        $_SESSION['login_string'] = hash('sha512',$password.$user_browser);
                        // Login successful.
                        $this->is_login = true;
                    } else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $this->db->exec("INSERT INTO authLogins(userId, time) VALUES ('$this->userId', '$now')");
                        $this->is_login = false;
                    }
                }
            } else {
                // No user exists.
                $this->is_login = false;
            }
        }

        return $this->is_login;
    }

    public function logout() {
        // Unset all session values
        $_SESSION = array();

        // get session parameters
        $params = session_get_cookie_params();

        // Delete the actual cookie.
        setcookie(session_name(),
            '', time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]);

        // Destroy session
        session_destroy();

        $this->userName = 'Guest';
        $this->is_login = false;
    }

    private function checkbrute() {
        // Get timestamp of current time
        $now = time();

        // All login attempts are counted from the past 2 hours.
        $valid_attempts = $now - (2 * 60 * 60);

        if ($query = $this->db->prepare("SELECT COUNT(*) FROM authLogins WHERE userId = ? AND time > ?")
        ) {
            // Execute the prepared query.
            $query->execute([$this->userId, $valid_attempts]);

            // If there have been more than 5 failed logins
            if ($query->fetch()[0] > 5) {
                $this->is_login = true;
            } else {
                $this->is_login = false;
            }
        }

        return $this->is_login;
    }

    private function login_check() {
        $db_password = '';
        $this->is_login = false;

        // Check if all session variables are set
        if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

            $this->userId = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];

            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            if ($query = $this->db->prepare("
            SELECT t1.username AS userName, t1.password AS password, t1.groupId AS groupId, t2.name AS groupName
              FROM authUsers t1
              LEFT JOIN authGroups t2 ON t1.groupId = t2.id
              WHERE t1.id = ?
              ")
            ) {
                $query->execute([$this->userId]);
                $query->bindColumn('userName', $this->userName);
                $query->bindColumn('password', $db_password);
                $query->bindColumn('groupId', $this->groupId);
                $query->bindColumn('groupName', $this->groupName);
                $query->fetch();

                $password = trim($db_password);
                if ($this->userName == $_SESSION['username']) {
                    $login_check = hash('sha512', $password.$user_browser);
                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        $this->is_login = true;

                    }
                }
            }
        }
        return $this->is_login;
    }

    public function access_check($smapId){

        if ($query = $this->db->prepare("
          SELECT right
          FROM authAccess
          WHERE (userId = ? OR groupId = ?) AND smapId = ?
              ")
        ) {
            $query->execute([$this->userId, $this->groupId, $smapId]);
            $query->bindColumn('right', $this->right);
            $query->fetch();
        }
        return $this->right;
    }
    private function esc_url($url) {

        if ('' == $url) {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string) $url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }
}
