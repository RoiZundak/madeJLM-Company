<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/05/2016
 * Time: 23:08
 */

function connect_to_db(){
    //PDO connection :
    define('_HOST_NAME_', 'localhost');
    define('_USER_NAME_', 'jobmadeinjlm');
    define('_DB_PASSWORD', 'q1w2e3r4');
    define('_DATABASE_NAME_', 'jobmadei_db');
        //PDO Database Connection
    try {
        $databaseConnection = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_, _DB_PASSWORD);
        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$databaseConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $databaseConnection;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}