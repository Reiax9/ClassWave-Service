<?php
    require 'const.php';
    function getDBConnection($dbConn=DB_CONN,$user=DB_USER,$pass=DB_PASS){
        $db = null;
        try{
            $db = new PDO($dbConn,$user,$pass,[PDO::ATTR_PERSISTENT => true]);
        }catch(PDOException $e){
            echo 'ERROR: ' . $e->getMessage();
        }finally{
            return $db;
        }
    }