<?php
/**
 * @package ly.
 * @author Supme
 * @copyright Supme 2014
 * @license http://opensource.org/licenses/MIT MIT License	
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
 *	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 *	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
 *	PURPOSE.
 *
 *	Please see the license.txt file for more information.
 *
 */
class UsersModel extends Model
{
    function getUsers($from = 0, $count = 10){

        $query = $this->db->prepare('
              SELECT t1.userName, t1.email, t2.name AS groupName
              FROM authUsers t1
              LEFT JOIN authGroups t2 ON t1.groupId = t2.id
              ');
        $query->execute();

        return $query->fetchAll();

    }

    function addUser($userName, $email, $password){
        $userName = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userName);

        $query = $this->db->prepare('SELECT userName, email FROM authUsers WHERE userName = ? OR email = ?');
        $query->execute([$userName, $email]);
        $result = $query->fetchAll;
        if(count($result) > 0){
            // User already exist
            return 'User already exist';
        } else {
            $salt = $this->saltGen();
            $password = hash('sha512', $password.$salt);
            $query = $this->db->prepare('INSERT INTO authUsers(groupId, userName, email, password, salt) VALUES (2, ?, ?, ?, ?)');
            $query->execute([$userName, $email, $password, $salt]);

            return $query->fetchAll();
        }
    }

    function editUser($userName, $groupId, $email, $password){

        $query = $this->db->prepare('SELECT id, title, announce, text, date FROM news WHERE smapId = ? ORDER BY date DESC LIMIT ?, ?');
        $query->execute();

        return $query->fetchAll();

    }

    private function saltGen($lenght = 128) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $num = 0;
        $salt = "";
        while ($num < $lenght) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $num++;
        }
        return $salt;
    }
}