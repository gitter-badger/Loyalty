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


class Personal extends Controller {
    function index(){
        $personal_model = $this->loadModel('Personal');
        $this->render([
                'result' => $personal_model->getAll(),

        ]);
    }

    function add() {

        if(isset($_POST['submit_add_personal']) && $this->auth->is_login){

            //ToDo save data
            header('location: ' . URL . 'personal');
        }

        $personal_model = $this->loadModel('Personal');
        $this->render([
                'departments' => $personal_model->getDepartment(),
        ]);
    }
}