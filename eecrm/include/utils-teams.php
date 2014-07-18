<?php
require_once 'database.php';

/**
 * Get all team list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllTeams($offset, $limit, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT id,name
                 FROM teams 
                 WHERE ";
    
    if (!empty($searchString)) {
        $sqlQuery .= " name LIKE '%" .$searchString. "%' AND ";
    }
    
    $sqlQuery .= " deleted = '0' LIMIT $offset, $limit";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($teams)? $teams : NULL;
}

/**
 * Get Team list for selection of assingning Team
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getTeamsForAssigning() 
{
    global $db;
    $sqlQuery = "SELECT id, name as title
                 FROM `teams`
                 WHERE deleted = '0' ORDER BY title ASC";
    try {
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute();
        $columns = $stmt->columnCount();
        if ($columns > 0) {
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($details)? $details : NULL;    
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Get team details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getTeamDetails($teamId) 
{
    global $db;
    
    $stmt = $db->prepare("SELECT * 
                          FROM teams 
                          WHERE id = :teamId");
    $stmt->bindParam(":teamId", $teamId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details)? $details : NULL;
}

/**
 * Updating team details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateTeamDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `teams` SET ";
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
 * Adding new team.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewTeamDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `teams` ( ";
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
