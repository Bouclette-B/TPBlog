<?php

class Manager
{
    protected function dbConnect() {
        $db = new \PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}