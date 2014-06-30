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

class Application
{
    /** @var null The controller part of the URL */
    private $siteArray =[];
    private $_category_arr = [];
    private $db;
    /**
     * Starts the Application
     * Takes the parts of the URL and loads the according controller & method and passes the parameter arguments to it
     */
    public function __construct()
    {
        // create database connection
        try {
            $this->db = new Database();
        } catch (PDOException $e) {
            die('Database connection could not be established.');
        }
        Registry::set('db', $this->db);

        // authorize and session
        $auth = new Auth($this->db);
        Registry::set('auth', $auth);

        //Main page
        $query = $this->db->prepare('SELECT * FROM siteMap WHERE pid = 0');
        $query->execute();
        $main = $query->fetch();

        $query = $this->db->prepare("
          SELECT t1.id, t1.pid, t1.segment, t1.view, t1.layout, t1.controller, t1.action, t1.title, t1.visible
          FROM siteMap t1
          LEFT JOIN authAccess t2 ON t1.id = t2.smapId AND (t2.userId = ? OR t2.groupId = ?)
          WHERE t2.smapId IS NULL OR (NOT t2.smapId IS NULL AND t2.right <> '0')
              ");
        $query->execute([$auth->userId, $auth->groupId]);
        $siteMap = $query->fetchAll();

        $tree = new Tree($siteMap);
        $tree->each();
        $siteTree = $tree->get();
        Registry::set('siteTree', $siteTree);

        // Create site map tree
        $this->_category_arr = $this->_getCategory($siteMap);
        //get root level menu
        $this->_getTree(0, 0);

        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        } else {

            $url = $main['segment'];
        }
        $segments = explode('/', $url);


// ToDo Использовать siteTree, а не siteMap
        $now = '';
        $run = false;
        $level = false;
        $params = [];
        $i = 1;
        foreach($segments as $segment){
            if(@is_array($this->siteArray[$i][$segment])){
                $now .= $segment.'/';
                $level = $i;
                $run = $segment;
            } else {
                $params[] = $segment;
            }
            $i++;
        }

        $page = $run?$this->siteArray[$level][$run]:$main;

        Registry::set('pageArray', $page);
        //Registry::set('siteArray', $this->siteArray);

        // Run application
        if (file_exists(CONTROLLER_PATH .$page['controller'].'.php')){
            require CONTROLLER_PATH .$page['controller']. '.php';
            $controller = new $page['controller']();
            if (method_exists($controller, 'init')) {
                $controller->{'init'}($params);
            }
            if (method_exists($controller, $page['action'])) {
                $controller->{$page['action']}($params);
            } else {
                $controller->index($params);
            }
            if (method_exists($controller, '__close')) {
                $controller->{'_close'}($params);
            }
        } else {
            // redirect user to error page (there's a controller for that)
            header('location: ' . URL . 'error/502');
        }
    }

    private function _getCategory($siteMap) {

        //Перелапачиваем массим (делаем из одномерного массива - двумерный, в котором первый ключ - parent_id)
        $return = array();
        foreach ($siteMap as $value) {
            $return[$value['pid']][] = $value;
        }
        return $return;
    }

    private function _getTree($parent_id, $level) {
        if (isset($this->_category_arr[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->_category_arr[$parent_id] as $value) { //Обходим ее
                $this->siteArray[$level][$value['segment']] = $value;
                $level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->_getTree($value['id'], $level);
                $level--; //Уменьшаем уровень вложености
            }
        }
    }
 }