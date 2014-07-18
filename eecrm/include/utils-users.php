<?php

require_once 'database.php';

/**
 * Get all users list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllUsers($offset, $limit, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT id,user_name,first_name,last_name,email_address 
                 FROM users 
                 WHERE ";
    
    if (!empty($searchString)) {
        $sqlQuery .= " user_name LIKE '%" .$searchString. "%' OR 
                       first_name LIKE '%" .$searchString. "%' OR
                       last_name LIKE '%" .$searchString. "%' AND ";
    }
    
    $sqlQuery .= " deleted = '0' LIMIT $offset, $limit";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($users)? $users : NULL;
}

/**
 * Get user details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getUserDetails($userId) 
{
    global $db;
    
    $stmt = $db->prepare("SELECT u.*,t.name as teamName 
                          FROM users AS u 
                          LEFT JOIN teams AS t ON u.default_team_id = t.id
                          WHERE u.id = :userid");
    $stmt->bindParam(":userid", $userId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details)? $details : NULL;
}

/**
 * Updating user details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateUserDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `users` SET ";
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
                $sql.= ",";
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
 * Adding new user. Creating new user acccount
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewUserDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `users` ( ";
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

/**
 * Get Users list for selection of assingning users
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getUsersForAssigning() 
{
    global $db;
    $sqlQuery = "SELECT id,user_name,first_name,last_name
                 FROM users 
                 WHERE deleted = '0'";
    try {
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute();
        $columns = $stmt->columnCount();
        if ($columns > 0) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($users)? $users : NULL;    
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Get Users list for selection of assingning users
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getUsersForAssigningMultiple($dataType = '') 
{
    global $db;
    $sqlQuery = "SELECT id, CONCAT(first_name, ' ', last_name) as title
                 FROM users 
                 WHERE deleted = '0' ORDER BY title ASC";
    try {
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute();
        $columns = $stmt->columnCount();
        if ($columns > 0) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($users)? $users : NULL;    
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * return user name by id
 * 
 * @param int $userId id of user
 * @return string
 */
function getUserName($userId) {
    global $db;
    $userName = '';
    $stmt = $db->prepare("SELECT first_name, last_name 
                          FROM users AS u 
                          WHERE u.id = $userId");
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_OBJ);
        $userName = $details->first_name . ' ' . $details->last_name;
    }
    
    return $userName;
}