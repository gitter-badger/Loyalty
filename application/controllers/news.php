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
    function index($params){
        $news_model = $this->loadModel('News');

        switch (count($params)){
            case 1:
                $this->render([
                    'news' => $news_model->getNews($params[0]),
                ]);
                break;

            case 2:
                $news = $news_model->getLast($params[0], $params[1]);
                $this->render([
                    'count' => count($news),
                    'news' => $news,
                ]);
                break;

            default:
                $news = $news_model->getLast();
                $this->render([
                    'count' => count($news),
                    'news' => $news,
                ]);
                break;

        }



    }
    function edit($params){

        $news_model = $this->loadModel('News');

        if($params[0] =='')
            if(!$this->auth->add) header('location: ' . URL . '403');
        else
            if(!$this->auth->edit) header('location: ' . URL . '403');



        if (isset($_POST["submit_add_news"])) {
            $news_model->addNews($_POST["title"], $_POST["text"]);
        }
    }
}