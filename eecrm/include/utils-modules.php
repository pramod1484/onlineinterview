<?php

require_once 'database.php';

/**
 * Get all Module list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllModules() 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 `modules` 
                 WHERE deleted = '0'";
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Get module details according to the role id 
 * 
 * @global DB resource $db
 * @param integer $modId
 * @return mixed
 */
function getModuleDetails($modId) 
{
    global $db;
    
    $stmt = $db->prepare("SELECT * 
                          FROM `modules` 
                          WHERE moduleId = :moduleId");
    $stmt->bindParam(":moduleId", $modId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Updating Module details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateModuleDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `modules` SET ";
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
 * Adding new Module.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewModuleDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `modules` ( ";
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