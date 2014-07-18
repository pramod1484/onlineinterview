<?php

require_once 'database.php';

/**
 * Get all users list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllSources($offset = 0, $limit = 10, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 sources 
                 WHERE deleted = '0'";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($sources)? $sources: NULL;
}


/**
 * Get source details according to the source id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getSourceDetails($sourceId) 
{
    global $db;
    
    $stmt = $db->prepare("SELECT * 
                          FROM `sources` 
                          WHERE source_id = :source_id");
    $stmt->bindParam(":source_id", $sourceId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details)? $details : NULL;
}

/**
 * Updating source details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateSourceDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `sources` SET ";
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
 * Adding new Source.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewSourceDetails(Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `sources` ( ";
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