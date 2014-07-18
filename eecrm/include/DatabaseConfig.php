<?php

/**
 * Databas configuration class to save database configuration and 
 * making connections.
 */

class DBConfig
{
    /**
     * DSN connection string
     * 
     * @var string 
     */
    private $dsn;
    
    /**
     *
     * @var type 
     */
    protected $db;
    
    /**
     *  Set Dsn name
     * 
     * @return string
     */
    private function setDsn($dbHost,$dbName)
    {
        $this->dsn = "mysql:dbname=".$dbName.";host=".$dbHost;
    }
    
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
        $this->setDsn($dbHost, $dbName);
        $this->connection($dbUser, $dbPass);
    }
    
    /**
     * Connecting to database 
     */
    private function connection($dbUser, $dbPass)
    {
        $conn = NULL;
        try{
            $conn = new PDO($this->dsn, $dbUser, $dbPass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo 'ERROR: ' . $e->getMessage();
        }   
            
        $this->db = $conn;        
    }
}