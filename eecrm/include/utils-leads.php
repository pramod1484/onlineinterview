<?php

require_once 'database.php';

/**
 * Get all users list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllLeads($offset, $limit, $userId = NULL, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT l.*,u.first_name AS firstName,u.last_name AS lastName,s.status_name
                 FROM leads AS l 
                 JOIN users AS u ON l.assigned_user_id = u.id
                 LEFT JOIN status AS s ON l.status = s.status_id
                 WHERE ";
    
    if($userId != NULL) {
        $sqlQuery .= " l.assigned_user_id = '".$userId."' AND ";
    }
    
    if (!empty($searchString)) {
        $sqlQuery .= " l.first_name LIKE '%" .$searchString. "%' OR 
                       l.last_name LIKE '%" .$searchString. "%'  
                       AND ";
    }
    
    $sqlQuery .= " l.deleted = '0' AND l.status != 7 LIMIT 0,50";
    
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
function getLeadDetails($leadId) 
{
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT l.*,u.first_name AS firstName, u.last_name AS lastName,
                              u1.first_name AS createdFirstName, u1.last_name AS createdLastName,
                              u2.first_name AS modifiedFirstName, u2.last_name AS modifiedLastName,
                              so.source_name,s.status_name,c.status_name AS call_status_name
                              FROM leads AS l 
                              JOIN users AS u ON l.assigned_user_id = u.id
                              LEFT JOIN users AS u1 ON l.created_by_id = u1.id
                              LEFT JOIN users AS u2 ON l.modified_by_id = u2.id  
                              LEFT JOIN status AS s ON l.status = s.status_id
                              LEFT JOIN call_status AS c ON l.call_status = c.status_id
                              LEFT JOIN sources AS so ON l.source = so.source_id                              
                              WHERE l.id = :leadid");
        $stmt->bindParam(":leadid", $leadId);
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
 * Updating user details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateLeadDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `leads` SET ";
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
 * Adding new user. Creating new user acccount
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewLeadDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `leads` ( ";
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
 * Adding new ooportunity
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function convertLeadToOpportunity (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `opportunities` ( ";
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
 * Select Specific details of lead specified in arguments
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function selectLeadDetails($leadId, $select = array('salutation_name', 'first_name', 'last_name')) 
{
    global $db;
    
    $strSelect = implode(', ', $select);
    
    try {
        $stmt = $db->prepare("SELECT $strSelect
                              FROM leads l
                              WHERE l.id = :leadid");
        $stmt->bindParam(":leadid", $leadId);
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
 * Get Lead list for selection of assingning Leads
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getLeadsForAssigning() 
{
    global $db;
    $sqlQuery = "SELECT id, CONCAT(first_name, ' ', last_name) as title
                 FROM leads 
                 WHERE deleted = '0' AND status = 7 ORDER BY title ASC";
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
 * Add Lead Phones to DB
 * 
 * @global Resource $db
 * @param int $leadId Lead Id 
 * @return boolean True on Success
 */
function addLeadPhones($leadId, $phones) {
    global $db;
    $return = FALSE;
    $delete = "DELETE FROM entity_phone 
                  WHERE entity_id = " . $leadId  . " AND entity_type = 'Lead'";
    $statement = $db->prepare($delete);
    $statement->execute();
    foreach ($phones as $phone) {
        $sql = "INSERT INTO `entity_phone` (entity_id, entity_type, phone)
                VALUES ('$leadId', 'Lead', '$phone')";
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $return = TRUE;
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
    
    return $return;
}

/**
 * Return Lead phones
 * 
 * @global Resource $db
 * @param int $leadId Lead Id 
 * @return array array of phones
 */
function getLeadPhones ($leadId) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT id, phone
                                  FROM entity_phone
                                  WHERE entity_id = :leadid  AND entity_type = 'Lead'");
        $stmt->bindParam(":leadid", $leadId);
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($details)? $details : NULL;
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }
}