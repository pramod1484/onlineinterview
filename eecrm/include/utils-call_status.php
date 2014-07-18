<?php

require_once 'database.php';

/**
 * Get all Call Status List which are not deleted
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllCallStatus($offset = 0, $limit = 10, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 `call_status` 
                 WHERE deleted = '0'";
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $status = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($status)? $status: NULL;
}

/**
 * Get Call status details according to the status id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getCallStatusDetails($fields = '*',$statusId) 
{
    global $db;
    if(is_array($fields))
        $fields = implode (',', $fields);
    $stmt = $db->prepare("SELECT $fields 
                          FROM `call_status` 
                          WHERE status_id = :status_id");
    $stmt->bindParam(":status_id", $statusId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(($fields == '*')?PDO::FETCH_ASSOC:PDO::FETCH_COLUMN);
    }
    return ($details)? $details : NULL;
}

/**
 * Updating status details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateCallStatusDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `call_status` SET ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= "`".$key."` = :".$key;        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    $sql.= " WHERE ";
    $iterator = 1;
    $totalConditions = count($where);
    if ($where) {
        foreach ($where as $keyVar => $value) {
            $sql.= "  $keyVar = :$keyVar";
            if ($iterator !== $totalConditions) {
                $sql.= ",";
            }
            
            $iterator++;            
        }
    }
    
    $statement = $db->prepare($sql);
    foreach ($fields as $key => $fieldValue) {
        $statement->bindValue(":$key", $fieldValue);
    }
    
    foreach ($where as $condition => $conditionValue) {
        $statement->bindValue(":$condition", $conditionValue);
    }

    $statement->execute();
    $rowCount = $statement->rowCount();
    
    return ($rowCount)? $rowCount: NULL;
}

/**
 * Adding new Status.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewCallStatusDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `call_status` ( ";
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
    
    $statement = $db->prepare($sql);
    $statement->execute();
    $id  = $db->lastInsertId();
    
    return ($id)? $id : NULL;
}