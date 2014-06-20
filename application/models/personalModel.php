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



class PersonalModel extends Model{

    function getDepartment(){

        $result = array();
        $query = $this->db->prepare('SELECT * FROM personalCity');
        $query->execute();
        $cities = $query->fetchAll();
        foreach($cities as $city){
            $query = $this->db->prepare('SELECT * FROM personalDepartment WHERE city_id = ?');
            $query->execute([$city['id']]);
            $departments = $query->fetchAll();
            foreach($departments as $department){
                $result[$department['id']] = $city['name'].' '.$department['name'];
            }
        }

       // echo "<pre>"; print_r($result);echo "</pre>";

        return $result;
    }

    function getAll(){
        $result = array();
        $queryc = $this->db->prepare('SELECT * FROM personalCity');
        $queryc->execute();
        $city = $queryc->fetchAll();

        $queryd = $this->db->prepare('SELECT * FROM personalDepartment WHERE city_id=?');
        foreach($city as $kc => $c){
            $queryd->bindParam(1,$c['id']);
            $queryd->execute();
            $departament = $queryd->fetchAll();
            $queryp = $this->db->prepare('SELECT * FROM personalPeople WHERE department_id=?');
            foreach($departament as $kd => $d){
                $queryp->bindParam(1,$d['id']);
                $queryp->execute();
                $people = $queryp->fetchAll();
                foreach($people as $kp => $p){
                    $result[$c['name']][$d['name']][$p['name']] = $p;
                }
            }
        }

        return $result;
    }
}