<?php

require_once 'database.php';


/**
 * Get all opportunites which are added by the user
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllOpportunities($offset, $limit, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT opp.*,u.first_name AS firstName,u.last_name AS lastName,
                 s.stage_name
                 FROM opportunities AS opp 
                 JOIN users AS u ON opp.assigned_user_id = u.id
                 LEFT JOIN stages AS s ON opp.stage = s.stage_id
                 LEFT JOIN sources AS so ON opp.lead_source = so.source_id
                 WHERE ";
    
    if (!empty($searchString)) {
        $sqlQuery .= " opp.company_name LIKE '%" .$searchString. "%' 
                       AND ";
    }
    
    $sqlQuery .= " opp.deleted = '0' LIMIT 0,50";
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($opportunities)? $opportunities : NULL;
}

/**
 * Get Opportunity list for selection of assingning Opportunity
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getOpportunityForAssigning() 
{
    global $db;
    $sqlQuery = "SELECT id, company_name as title
                 FROM opportunities 
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
 * Get user details according to the user id 
 * 
 * @global DB resource $db
 * @param integer $userId
 * @return mixed
 */
function getOpportunityDetails($oppId) 
{
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT opp.*,u.first_name AS firstName, u.last_name AS lastName,
                              u1.first_name AS createdFirstName, u1.last_name AS createdLastName,
                              u2.first_name AS modifiedFirstName, u2.last_name AS modifiedLastName,
                              so.source_name,s.stage_name,c.status_name AS call_status_name
                              FROM opportunities AS opp
                              JOIN users AS u ON opp.assigned_user_id = u.id
                              LEFT JOIN users AS u1 ON opp.created_by_id = u1.id
                              LEFT JOIN users AS u2 ON opp.modified_by_id = u2.id  
                              LEFT JOIN stages AS s ON opp.stage = s.stage_id
                              LEFT JOIN call_status AS c ON opp.call_status = c.status_id
                              LEFT JOIN sources AS so ON opp.lead_source = so.source_id                              
                              WHERE opp.id = :opportunity");
        $stmt->bindParam(":opportunity", $oppId);
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
 * Updating opportunity details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateOpportunityDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `opportunities` SET ";
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
 * Select Specific details of opportunity specified in arguments
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function selectOpportunityDetails($oppId, $select = array('company_name')) 
{
    global $db;
    
    $strSelect = implode(', ', $select);
    
    try {
        $stmt = $db->prepare("SELECT $strSelect
                              FROM opportunities o
                              WHERE o.id = :oppid");
        $stmt->bindParam(":oppid", $oppId);
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
 * Add Opportunity Phones to DB
 * 
 * @global Resource $db
 * @param int $oppId Opportunity Id 
 * @param array $phones Phone numbers 
 * @return boolean True on success
 */
function addOpportunityPhones($oppId, $phones) {
    global $db;
    $return = FALSE;
    $delete = "DELETE FROM entity_phone 
                  WHERE entity_id = " . $oppId . " AND entity_type = 'Opportunity'";
    $statement = $db->prepare($delete);
    $statement->execute();
    foreach ($phones as $phone) {
        $sql = "INSERT INTO `entity_phone` (entity_id, entity_type, phone)
                VALUES ('$oppId', 'Opportunity', '$phone')";
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
 * Return Opportunity phones
 * 
 * @global Resource $db
 * @param int $leadId Lead Id 
 * @return array array of phones
 */
function getOpportunityPhones ($oppId) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT id, phone
                                  FROM entity_phone
                                  WHERE entity_id = :oppId  AND entity_type = 'Opportunity'");
        $stmt->bindParam(":oppId", $oppId);
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