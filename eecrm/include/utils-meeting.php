<?php

require_once 'database.php';

/**
 * Get all Meeting list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllMeetings($offset, $limit, $userId = NULL, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS assignedUser,
                    o.company_name AS oppName, o.id AS oppId
                 FROM meeting AS m
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
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($users)? $users : NULL;
}

/**
 * Get Meeting details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $meetId
 * @return mixed
 */
function getMeetingDetails($meetId) 
{
    global $db;
    
    try {
        $sql = "SELECT m.*,u.first_name AS firstName, u.last_name AS lastName,
                              u1.first_name AS createdFirstName, u1.last_name AS createdLastNamee,
                              o.company_name AS oppName, o.id AS oppId
                FROM meeting AS m 
                JOIN users AS u ON m.assigned_user_id = u.id
                LEFT JOIN users AS u1 ON m.created_by_id = u1.id
                LEFT JOIN opportunities o ON m.parent_id = o.id
                WHERE m.id = $meetId";
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
 * Updating Meeting details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateMeetingDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `meeting` SET ";
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
 * Adding new Meeting. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewMeetingDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `meeting` ( ";
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
 * Select Specific details of Meeting specified in arguments
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function selectMeetingDetails($meetId, $select = array('name')) 
{
    global $db;
    
    $strSelect = implode(', ', $select);
    
    try {
        $stmt = $db->prepare("SELECT $strSelect
                              FROM meeting l
                              WHERE l.id = :meetId");
        $stmt->bindParam(":meetId", $meetId);
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
 * Adding meeting Entities
 * 
 * @global DB Resource $db
 * @param array $entityIds
 * @param int $meetId Meeting Id
 * @param string $entityType Type of Entity
 * @return void
 */
function addMeetingEntity(Array $entityIds, $meetId, $entityType) {
    global $db;
    try {
        $stmt = $db->prepare("DELETE FROM `meeting_entity` 
                                     WHERE `meetingId` = $meetId AND `entityType` = '$entityType'");
        if ($stmt->execute()) {
            foreach ($entityIds as $entityId) {
                $sql = "INSERT INTO `meeting_entity` ( 
                            `id`, `meetingId`, `entityId`, `entityType`,`deleted`) 
                        VALUES (
                            NULL, '$meetId', '" . $entityId . "', '" . $entityType . "','0'
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
 * Get Meeting entities according to the meeting id 
 * 
 * @param int $meetId Meeting Id
 * @param string $entityType Entity Type
 * @global DB Resource $db
 */
function getMeetingEntities($meetId, $entityType) 
{
    global $db;
    switch ($entityType) {
        case 'User':
            $getTeams = "SELECT et.id, et.entityId, CONCAT(u.first_name, ' ', u.last_name) AS userName 
                         FROM meeting_entity AS et
                         LEFT JOIN users AS u ON et.entityId = u.id
                         WHERE et.meetingId = '" .$meetId."' 
                         AND et.entityType = 'User'
                         AND et.deleted = '0' ORDER BY userName ASC";
        break;
        case 'Lead':
            $getTeams = "SELECT et.id, et.entityId, CONCAT(l.first_name, ' ', l.last_name) AS leadName 
                         FROM meeting_entity AS et
                         LEFT JOIN leads AS l ON et.entityId = l.id
                         WHERE et.meetingId = '" .$meetId."' 
                         AND et.entityType = 'Lead'
                         AND et.deleted = '0' ORDER BY leadName ASC";
        break;    
    }
      
    try {
        $statement = $db->prepare($getTeams);
        $statement->execute();      
        $entities = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return (!empty($entities)) ? $entities : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}