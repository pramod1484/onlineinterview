<?php
require_once 'database.php';
/**
 * Adding new call record. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewCall (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `calls` ( ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= $key;        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    
    $sql .= ") VALUES (";
    $iterator = 1;
    foreach ($fields as $keyVar => $value) {
        $sql.= "'$value'";
        if ($iterator !== $totalFields) {
            $sql.= ",";
        }

        $iterator++;            
    }
    $sql .= ")";
    try {
        $statement = $db->prepare($sql);
        $statement->execute();
        $id  = $db->lastInsertId();
        
        return ($id)? $id : NULL;
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage()) ;
    }
}
function getCallsByDate($date)
{
    global $db;
    $sql = "SELECT * FROM `calls` WHERE `created_at` = '$date'";
    $statement = $db->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        return ($records)? $records: NULL;
}
function getCallsCountByDate($date)
{
    return count(getCallsByDate($date));
}