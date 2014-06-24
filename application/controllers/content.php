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


class Content extends Controller {
    function index(){

        $content = $this->loadModel('Content');

        if (isset($_POST['save']) && $this->auth->is_login) {
            $content->editContent($_POST['position'], $_POST['text']);
            echo 'Ok';
        } else {
            $editable = $this->auth->right != NULL?true:false;
            $result = $content->getContent();
            if(!$result){
                $result = [0 => ['text' => 'No content', 'position' => 1]];
            }
            $this->render([
                'result' => $result,
            ]);
        }
    }
}