<?php
require_once 'database.php';
require_once $include_directory . 'classes/PHPMailer/PHPMailerAutoload.php';

function getOutboundMailDetails($outboundId) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT * 
                              FROM `email_outbound`
                              WHERE deleted = 0 AND id = :outboundId");
        $stmt->bindParam(":outboundId", $outboundId);
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return ($details) ? $details : NULL;
        
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }
}

/**
 * Updating Outbound mail details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateOutboundMailDetails (Array $fields, Array $where) {
    global  $db;
    $sql = "UPDATE `email_outbound` SET ";
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
 * Get all inbound mail list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @param int $offset Offset to start
 * @param int $limit Number of records
 * @return mixed
 */
function getAllInboundMails ($offset, $limit, $searchString = '') {
    global $db;
    $sqlQuery = "SELECT e.`id`, e.`name`, e.`assigned_user_id`, e.`created_by_id`,
                        CONCAT(u.first_name, ' ', u.last_name) as createdUser,
                        CONCAT(u1.first_name, ' ', u1.last_name) as assignedUser,
                        t.name as teamName,
                        IF(e.`status` = 1,'Active','Inactive') status
                 FROM `email_inbound` e
                 JOIN `users` AS u ON e.created_by_id = u.id
                 LEFT JOIN `users` AS u1 ON e.assigned_user_id = u1.id
                 LEFT JOIN `teams` as t ON e.team_id = t.id
                 WHERE ";
    
    if (!empty($searchString)) {
        $sqlQuery .= " e.`name` LIKE '%" .$searchString. "%' AND ";
    }
    
    $sqlQuery .= " e.deleted = '0' LIMIT $offset, $limit";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}


/**
 * Get Inbound Mail details according to the inbound Id
 * 
 * @global DB resource $db
 * @param integer $inboundId
 * @return mixed
 */
function getInboundDetails($inboundId) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT e.*, CONCAT(u.first_name, ' ', u.last_name) AS assignedUser,
                                CONCAT(u1.first_name, ' ', u1.last_name) as createdUser,
                                CONCAT(u2.first_name, ' ', u2.last_name) as modifiedUser,
                                t.name as teamName,
                                IF(e.`status` = 1,'Active','Inactive') status
                              FROM email_inbound AS e 
                              JOIN users AS u ON e.assigned_user_id = u.id
                              LEFT JOIN users AS u1 ON e.created_by_id = u1.id
                              LEFT JOIN users AS u2 ON e.modified_by_id = u2.id   
                              LEFT JOIN `teams` as t ON e.team_id = t.id
                              WHERE e.id = :inboundId");
        $stmt->bindParam(":inboundId", $inboundId);
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
 * Adding new Inbound Mail.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewInboundDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `email_inbound` ( ";
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

/**************** Email Templates ****************/

/**
 * Get all Email Template list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @param int $offset Offset to start
 * @param int $limit Number of records
 * @return mixed
 */
function getAllTemplates($offset, $limit, $searchString = '') {
    global $db;
    $sqlQuery = "SELECT e.*,
                        CONCAT(u.first_name, ' ', u.last_name) as createdUser,
                        CONCAT(u1.first_name, ' ', u1.last_name) as assignedUser,
                        CONCAT(u2.first_name, ' ', u2.last_name) as modifiedUser
                 FROM `email_template` e
                 JOIN `users` AS u ON e.created_by_id = u.id
                 LEFT JOIN `users` AS u1 ON e.assigned_user_id = u1.id
                 LEFT JOIN `users` AS u2 ON e.modified_by_id = u2.id
                 WHERE ";
    
    if (!empty($searchString)) {
        $sqlQuery .= " e.`name` LIKE '%" .$searchString. "%' AND ";
    }
    
    $sqlQuery .= " e.deleted = '0' LIMIT $offset, $limit";
     
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Get Template details according to the template Id
 * 
 * @global DB resource $db
 * @param integer $inboundId
 * @return mixed
 */
function getTemplateDetails($tempId) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT e.*, CONCAT(u.first_name, ' ', u.last_name) AS assignedUser,
                                CONCAT(u1.first_name, ' ', u1.last_name) as createdUser,
                                CONCAT(u2.first_name, ' ', u2.last_name) as modifiedUser
                              FROM email_template AS e 
                              JOIN users AS u ON e.assigned_user_id = u.id
                              LEFT JOIN users AS u1 ON e.created_by_id = u1.id
                              LEFT JOIN users AS u2 ON e.modified_by_id = u2.id
                              WHERE e.id = :tempId");
        $stmt->bindParam(":tempId", $tempId);
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
 * Updating DB Table details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param string $table DB table Name
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateMailDetails($table, Array $fields, Array $where) {
    global  $db;
    $sql = "UPDATE `$table` SET ";
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
 * Add DB Table details according to the fields
 * 
 * @global DB Resource $db
 * @param string $table DB table Name
 * @param array $fields
 * @return mixed
 */
function addMailDetails($table, Array $fields) {
    global  $db;
    $sql = "INSERT INTO `$table` (";
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

function getMailAttachments($parentId, $parentType) {
    global  $db;
    
    $getFiles = "SELECT et.id, et.savedName, et.name
                         FROM attachment AS et
                         WHERE et.parent_id = '" . $parentId . "' 
                         AND et.parent_type = '$parentType'
                         AND et.deleted = '0' ORDER BY name ASC";

    try {
        $statement = $db->prepare($getFiles);
        $statement->execute();
        $attachments = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (!empty($attachments)) ? $attachments : NULL;
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

    

/**
 * Return PHPMailer Object from outbound mail details
 * @param int $outboundId Oubound mail detail id
 * @param string $from Use this From in email if provided 
 * @param string $fromName Use this From Name in email if from provided 
 * @return object PHPMailer Object
 */
function getMailObject($outboundId, $from = '', $fromName = '') {

    $mailDetails = getOutboundMailDetails($outboundId);
    if ($mailDetails != NULL) {
        $mail = new PHPMailer;
        $mail->isSMTP();

        $mail->Host = $mailDetails['server'];
        $mail->SMTPAuth = ($mailDetails['auth']) ? true : false;
        $mail->Username = $mailDetails['username'];
        $mail->Password = $mailDetails['password']; 
        $mail->SMTPSecure = $mailDetails['security']; 

        if ($from == '') {
            $mail->From = $mailDetails['from_address'];
            $mail->FromName = ($mailDetails['from_name'] == '') ? $mailDetails['from_name'] : $mailDetails['from_address'];
        } else {
            $mail->From = $from;
            $mail->FromName = ($fromName == '') ? $fromName : $from;
        }

        $mail->addReplyTo($mail->From, $mail->FromName);

        $mail->isHTML(true);
    }

    return (isset($mail)) ? $mail : NULL;
}

/**
 * Send Mail from default settings if $from not provided
 * @param string $subject
 * @param string $body
 * @param string $from
 * @param string $fromName
 * @param int $outboundId
 * @return mixed true on success, error message on faillure
 */
function sendMail($subject, $body, $from = '', $fromName = '', $outboundId = 1) {
    $return = true;
    try {
        $mailObj = getMailObject($outboundId, $from, $fromName);
        if ($mailObj != NULL) {
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                $return = 'Message could not be sent. Error: ' . $mail->ErrorInfo;
            }
        }
    } catch (Exception $e) {
        $return = 'Error: ' . $exc->getMessage();
    }
    
    return $return;
}
?>
