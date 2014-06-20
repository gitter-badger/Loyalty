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


class News extends Controller {
    function index(){
        // load model, perform an action on the model
        $news_model = $this->loadModel('News');
        // if we have POST data to create a news
        if (isset($_POST["submit_add_news"]) && $this->auth->is_login) {
            $news_model->addNews($_POST["title"], $_POST["text"]);
        }
        $this->render([
            'result' => $news_model->getLast(),
        ]);
    }
}