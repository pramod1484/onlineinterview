<?php

require_once 'database.php';

/**
 * Saving all efforts done by the user according to the date
 * 
 * @global DB Object $db
 * @return mixed
 */

function addUsersEfforts($fields) 
{
    global  $db;
    $sql = "INSERT INTO `users_efforts` ( ";
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
 * Get users efforts according to the user id and date
 * 
 * @param integer $userId
 * @param date $date
 */
function getUsersEffortsId($userId,$date)
{
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT * FROM 
                              `users_efforts` AS uf
                              WHERE uf.user_id = :userid  
                              AND uf.efforts_date = :efforts_date");
        
        $stmt->bindParam(":userid", $userId);
        $stmt->bindParam(":efforts_date", $date,PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return ($details)? $details['id'] : NULL;
        
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }    
}

/**
 * Updating the users efforts according to the id
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed (integer | NULL)
 * @throws Exception
 */
function updateUsersEfforts($fields,$where)
{
     try {
    global  $db;
    $sql = "UPDATE `users_efforts` SET ";
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
        echo 'error';
        print($exception->getMessage());
    }     
}

/**
 * Get all efforts of user according to the dates.
 * 
 * @global DB Resource $db
 * @param date $fromDate
 * @param date $toDate
 * @return mixed (array | null)
 * @throws Exception
 */
function getAllEffortsOfUserByDates($fromDate,$toDate)
{
    global $db;
      try {
    $sql = "SELECT uf.*, u.first_name, u.last_name FROM 
            `users_efforts`  AS uf
            JOIN users AS u ON uf.user_id = u.id
            WHERE efforts_date >= '".$fromDate."'
            AND efforts_date <= '".$toDate."'";
    
  
        $statement = $db->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        return ($records)? $records: NULL;
        
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }     
}