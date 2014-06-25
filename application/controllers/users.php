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
class Users extends Controller {
    function init(){
        if(!$this->auth->read) header("Location: ../error/403");

        $this->users_model = $this->loadModel('Users');
    }
    function index(){
        $this->render(['users' => $this->users_model->getUsers()]);
    }

    function add(){
        $$this->users_model->addUser('Supme','supmea@gmail.com', '1234');
    }
}