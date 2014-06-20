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

class NewsModel extends Model
{

    function getLast($count = 10){

        $query = $this->db->prepare('SELECT * FROM news ORDER BY date DESC LIMIT ?');
        $query->bindParam(1, $count);
        $query->execute();

        return $query->fetchAll();

    }

    function getNews($id){

        $query = $this->db->prepare('SELECT * FROM news WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch();

    }

    function addNews($title, $text, $date = FALSE){

        if(!$date) $date = time();
        $query = $this->db->prepare('INSERT INTO news (title, text, date) VALUES (?, ?, ?)');
        $query->execute([$title, $text, $date]);

        //echo "<pre>"; print_r($lastNews);echo "</pre>";
    }
}