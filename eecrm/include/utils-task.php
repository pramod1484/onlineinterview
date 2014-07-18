<?php

require_once 'database.php';

/**
 * Get all Task list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllTasks($offset, $limit, $userId = NULL, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS assignedUser,
                    o.company_name AS oppName, o.id AS oppId
                 FROM `task` AS m
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
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($tasks) ? $tasks : NULL;
}

/**
 * Get task details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $meetId
 * @return mixed
 */
function getTaskDetails($taskId) 
{
    global $db;
    
    try {
        $sql = "SELECT m.*,u.first_name AS firstName, u.last_name AS lastName,
                              u1.first_name AS createdFirstName, u1.last_name AS createdLastNamee,
                              o.company_name AS oppName, o.id AS oppId
                FROM `task` AS m 
                JOIN users AS u ON m.assigned_user_id = u.id
                LEFT JOIN users AS u1 ON m.created_by_id = u1.id
                LEFT JOIN opportunities o ON m.parent_id = o.id
                WHERE m.id = $taskId";
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
 * Updating task details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateTaskDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `task` SET ";
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
 * Adding new task. 
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewTaskDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `task` ( ";
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
 * Select Specific details of task specified in arguments
 * 
 * @global DB Resource $db
 * @param int $taskId Task Id
 * @param array $fields
 * @return mixed
 */
function selectTaskDetails($taskId, $select = array('name')) 
{
    global $db;
    
    $strSelect = implode(', ', $select);
    
    try {
        $stmt = $db->prepare("SELECT $strSelect
                              FROM `task` l
                              WHERE l.id = :taskId");
        $stmt->bindParam(":taskId", $taskId);
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
