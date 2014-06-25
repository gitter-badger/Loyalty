<?php
/**
 * @package Loyality Portal
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

class Login extends Controller {
    function index(){

        $notification=[];

        // Login user
        if (isset($_POST["login"])) {
            if($this->auth->login($_POST['email'], $_POST['password'])){
                $notification = [
                    'success' => [
                        'You are login as '.$this->auth->userName,
                    ]
                ];
            } else {
                $notification = [
                    'danger' => [
                        'Error login',
                    ]
                ];
            }

        }

        // Logout user
        if (isset($_POST["logout"])) {
            $this->auth->logout();
            $notification = [
                'info' => [
                    'Success logout',
                    'Thanks for using service',
                ],
            ];
        }

        $this->render(['notifications' => $notification]);
    }

}