<?php

/*
 * This file will containt the code related to maintain the record of any users
 * related to the login and logout during thier sessions for the day.
 */

/**
 * Checking is user is login today
 * 
 * @param integer $userId
 * @param date $date
 * @return mixed (array | NULL)
 */
function getUsersLoginDetailsByDate($userId,$date) 
{
    global $db;
    $sql = "SELECT id,login_id,login_date,first_singin_time,last_sign_of_time
            ,number_of_breaks 
            FROM login_master
            WHERE login_id = '".$userId."' 
            AND login_date = '".$date."'";
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();    
        $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($userRecord)? $userRecord : NULL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

/**
 * Allowing users to make first signin in system
 * 
 * @global DB Resourcre $db
 * @param array $data
 * @return mixed (array | null)
 * @throws Exception
 */
function makeUserLogin($data)
{
    global $db;

    $sql = "INSERT INTO `login_master` ( ";
    $couter = 1;
    $totalFields = count($data);
    foreach ($data as $key => $value) {
        $sql.= $key;        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    
    $sql .= ") VALUES (";
    $iterator = 1;
    foreach ($data as $keyVar => $value) {
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
 * Adding users login details according to sign in and sing out.
 * 
 * @global DB Resource $db
 * @param array $data
 * @return mixed (array | NULL)
 * @throws Exception
 */
function addUsersLoginDetails($data)
{
    global $db;

    $sql = "INSERT INTO `login` ( ";
    $couter = 1;
    $totalFields = count($data);
    foreach ($data as $key => $value) {
        $sql.= $key;        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    
    $sql .= ") VALUES (";
    $iterator = 1;
    foreach ($data as $keyVar => $value) {
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
 * 
 * @global DB resource $db
 * @param array $fields
 * @param array $where
 * @return mixed (integer | NULL)
 * @throws Exception
 */
function updateLoginMasterDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `login_master` SET ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= "`".$key."` = '".$value."'";        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    $sql .= " WHERE ";
    $iterator = 1;
    $totalConditions = count($where);
    if ($where) {
        foreach ($where as $keyVar => $value) {
            $sql.= " $keyVar = '$value'";
            if ($iterator !== $totalConditions) {
                $sql.= " AND ";
            }
            
            $iterator++;            
        }
    }
    
    try {
        $statement = $db->prepare($sql);
        
        $statement->execute();
        $rowCount = $statement->rowCount();

        return ($rowCount)? $rowCount: NULL;
        
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    } 
}



/**
 * 
 * @global DB resource $db
 * @param array $fields
 * @param array $where
 * @return mixed (integer | NULL)
 * @throws Exception
 */
function updateLoginDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `login` SET ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= "`".$key."` = '".$value."'";        
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
            $sql.= " $keyVar = '$value'";
            if ($iterator !== $totalConditions) {
                $sql.= " AND ";
            }
            
            $iterator++;            
        }
    }
     
    try {
        $statement = $db->prepare($sql);
        $statement->execute();
        $rowCount = $statement->rowCount();

        return ($rowCount)? $rowCount: NULL;
        
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    } 
}

/**
 * 
 * @global DB resource $db
 * @param integer $userId
 * @param detetime $signInTime
 * @return mixed (array | NULL)
 */
function getLoginDetailsOfUser($userId,$signInTime)
{
    global $db;
    
    $sql = "SELECT * FROM login
            WHERE login_id = '".$userId."'
            AND signin_time = '".$signInTime."'
            ORDER BY DESC";
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();    
        $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($userRecord)? $userRecord : NULL;
        
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }    
}


function getUsersWorkedHours($users,$fromDate,$toDate)
{
    global $db;
    
    $sql = "SELECT login_id,login_date,hours_worked 
            FROM login_master
            WHERE login_id IN (" .$users. ")
            AND (login_date >= '".$fromDate."' AND login_date <= '".$toDate."')
            GROUP BY login_id,login_date";
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();    
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return ($usersData)? $usersData : NULL;
        
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }           
}
function getUsersData($users, $date)
{
    global $db;
    
    $sql = "SELECT * FROM login_master
            WHERE login_id IN (" .$users. ")
                AND login_date = '".$date."'";
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();    
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return ($usersData)? $usersData : NULL;
        
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }       
}