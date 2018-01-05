<?php

    $dsn = 'mysql:host=localhost;dbname=profiler';
    $user = '';
    $pass = '+(S_IN]AT1t3';
    $options = array (
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' , 
    );
    
    try {
        $con = new PDO($dsn, $user, $pass, $options);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Failed to connect ' . $e->getMessage();
    }
