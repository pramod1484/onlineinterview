<?php

/**
 * Database class to execute different sql queries.
 * 
 */


if (ENV == 'demo') {require 'config-demo.php';} else {require 'config-local.php';} 
require 'DatabaseConfig.php';

class Database extends DBConfig
{
    /**
     * Initializing database details.
     * 
     * @param String $dbHost
     * @param String $dbUser
     * @param String $dbPass
     * @param String $dbName
     * @param Integer $dbPort
     */
     public function __construct($dbHost, $dbUser, $dbPass, $dbName)
     {
         parent::__construct($dbHost, $dbUser, $dbPass, $dbName);
     }
     
     public function getDBO() 
     {
         return $this->db;
     }
}

$dbObj = new Database(DBHOST, DBUSER, DBPASS, DBNAME);
$db =  $dbObj->getDBO();

