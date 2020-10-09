<?php

class Manager
{
    protected function dbConnect() {
        $db = new \PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public function isGet($data) {
        if(isset($_GET[$data])){
            return $_GET[$data];
        }
        return false;
    }

    public function isPost($data=NULL) {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data)){
            return $data;
        } elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
            return true;
        }
        return false;
    }

    public function  writeUserInfo($userInfo) {
        if (isset($userInfo)) {
            return htmlspecialchars($userInfo);
        } 
    }

    /*public function methodIsPost() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            return true;
        }
        return false;
    }*/
}