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

    function getLast($from = 0, $count = 10){

        $query = $this->db->prepare('SELECT id, title, announce, text, date FROM news WHERE smapId = ? ORDER BY date DESC LIMIT ?, ?');
        $query->execute([Registry::get('pageArray')['id'], $from, $count]);

        return $query->fetchAll();

    }

    function getNews($id){

        $query = $this->db->prepare('SELECT title, announce, text, date FROM news WHERE id = ? AND smapId = ?');
        $query->execute([$id, Registry::get('pageArray')['id']]);
        return $query->fetch();

    }

    function addNews($title, $text, $date = FALSE){

        if(!$date) $date = time();
        $query = $this->db->prepare('INSERT INTO news (smapId, title, announce, text, date) VALUES (?, ?, ?, ?)');
        $query->execute([Registry::get('pageArray')['id'], $title, $text, $date]);

    }
}