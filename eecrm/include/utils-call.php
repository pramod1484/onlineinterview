<?php

require_once 'database.php';

/**
 * Get all Call list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllCalls($offset, $limit, $userId = NULL, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS assignedUser,
                    o.company_name AS oppName, o.id AS oppId
                 FROM `call` AS m
                 JOIN users AS u ON m.assigned_user_id = u.id
                 LEFT JOIN opportunities o ON m.parent_id = o.id
                 WHERE ";
    
    if($userId != NULL) {
        $sqlQuery .= " m.assigned_user_id = '".$userId."' AND ";
    }
    
    if (!empty($searchString)) {
        $sqlQuery .= " m.name LIKE '%" .$searchString. "%' 
                       AND ";
    }
    $sqlQuery .= " m.deleted = '0' LIMIT 0,50";
    
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $calls = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($calls) ? $calls : NULL;
}

/**
 * Get Call details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $meetId
 * @return mixed
 */
function getCallDetails($callId) 
{
    global $db;
    
    try {
        $sql = "SELECT m.*,u.first_name AS firstName, u.last_name AS lastName,
                              u1.first_name AS createdFirstName, u1.last_name AS createdLastNamee,
                              o.company_name AS oppName, o.id AS oppId
                FROM `call` AS m 
                JOIN users AS u ON m.assigned_user_id = u.id
                LEFT JOIN users AS u1 ON m.created_by_id = u1.id
                LEFT JOIN opportunities o ON m.parent_id = o.id
                WHERE m.id = $callId";
        $stmt = $db->prepare($sql);
        
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return ($details)? $details : NULL;
        
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }
}

/**
 * Updating Call details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateCallDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `call` SET ";
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
            $sql.= " $keyVar = :$keyVar";
            if ($iterator !== $totalConditions) {
                $sql.= " AND ";
            }
            
            $iterator++;            
        }
    }
    
    try {
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
        
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    } 
}

/**
 * Adding new Call. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewCallDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `call` ( ";
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


/**
 * Select Specific details of call specified in arguments
 * 
 * @global DB Resource $db
 * @param int $callId Call Id
 * @param array $fields
 * @return mixed
 */
function selectCallDetails($callId, $select = array('name')) 
{
    global $db;
    
    $strSelect = implode(', ', $select);
    
    try {
        $stmt = $db->prepare("SELECT $strSelect
                              FROM `call` l
                              WHERE l.id = :callId");
        $stmt->bindParam(":callId", $callId);
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return ($details)? $details : NULL;
        
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }
}

/**
 * Adding Call Entities
 * 
 * @global DB Resource $db
 * @param array $entityIds
 * @param int $callId Call Id
 * @param string $entityType Type of Entity
 * @return void
 */
function addCallEntity(Array $entityIds, $callId, $entityType) {
    global $db;
    try {
        $stmt = $db->prepare("DELETE FROM `call_entity` 
                                     WHERE `callId` = $callId AND `entityType` = '$entityType'");
        if ($stmt->execute()) {
            foreach ($entityIds as $entityId) {
                $sql = "INSERT INTO `call_entity` ( 
                            `id`, `callId`, `entityId`, `entityType`,`deleted`) 
                        VALUES (
                            NULL, '$callId', '" . $entityId . "', '" . $entityType . "','0'
                        )";
                //echo $sql; exit;
                $statement = $db->prepare($sql);
                $statement->execute();
            }
        }
    } catch (Exception $exception) {
        //echo $sql; exit;
        throw new Exception($exception->getMessage());
    }
}

/**
 * Get Call entities according to the call id 
 * 
 * @param int $callId Call Id
 * @param string $entityType Entity Type
 * @global DB Resource $db
 */
function getCallEntities($callId, $entityType) 
{
    global $db;
    switch ($entityType) {
        case 'User':
            $getCalls = "SELECT et.id, et.entityId, CONCAT(u.first_name, ' ', u.last_name) AS userName 
                         FROM call_entity AS et
                         LEFT JOIN users AS u ON et.entityId = u.id
                         WHERE et.callId = '" .$callId."' 
                         AND et.entityType = 'User'
                         AND et.deleted = '0' ORDER BY userName ASC";
        break;
        case 'Lead':
            $getCalls = "SELECT et.id, et.entityId, CONCAT(l.first_name, ' ', l.last_name) AS leadName 
                         FROM call_entity AS et
                         LEFT JOIN leads AS l ON et.entityId = l.id
                         WHERE et.callId = '" .$callId."' 
                         AND et.entityType = 'Lead'
                         AND et.deleted = '0' ORDER BY leadName ASC";
        break;    
    }
      
    try {
        $statement = $db->prepare($getCalls);
        $statement->execute();      
        $entities = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return (!empty($entities)) ? $entities : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}