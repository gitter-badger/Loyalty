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

class ContentModel extends Model
{
    private $page;

    function getContent(){
        $this->page = Registry::get('pageArray');

        $query = $this->db->prepare('SELECT id, lang, position, text FROM content WHERE smapId = ? ORDER BY position ASC');
        $query->execute([$this->page['id']]);

        return $query->fetchAll();
    }

    function editContent($position, $text){
        $this->page = Registry::get('pageArray');

        $query = $this->db->prepare('SELECT id FROM content WHERE smapId = ? AND position = ?');
        $query->execute([$this->page['id'], $position]);

        $result = $query->fetch();
        if($result) {
            $query = $this->db->prepare('UPDATE content SET text = ? WHERE id = ?');
            $query->execute([$text, $result['id']]);
        } else {
            $query = $this->db->prepare('INSERT INTO content (smapId, lang, position, text) VALUES (?, ?, ?, ?)');
            $query->execute([$this->page['id'], 1, 1, $text]);
        }
    }
}