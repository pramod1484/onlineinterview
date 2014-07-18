<?php

require_once 'database.php';

/**
 * Get all stage list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getOpportunitiesStages($offset = 0, $limit = 10, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 stages 
                 WHERE deleted = '0'
                 ORDER BY stage_name";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($stages)? $stages: NULL;
}

/**
 * Get stage details according to the stage id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getStageDetails($fields = '*' , $stageId) 
{
    global $db;
    if(is_array($fields)) {
        $fields = implode (',', $fields);
    }
    $stmt = $db->prepare("SELECT  $fields
                          FROM `stages` 
                          WHERE stage_id = :stage_id");
    $stmt->bindParam(":stage_id", $stageId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(($fields == '*')?PDO::FETCH_ASSOC:PDO::FETCH_COLUMN);
    }
    
    return ($details)? $details : NULL;
}

/**
 * Updating stage details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateStageDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `stages` SET ";
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
 * Adding new Stage.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewStageDetails(Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `stages` ( ";
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