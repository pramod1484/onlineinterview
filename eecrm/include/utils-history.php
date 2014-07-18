<?php
require_once 'database.php';

/**
 * Add data to history table
 * 
 * @param array $data
 * @return void
 */
function addHistory($data)
{
    global $db;
    $id = NULL;
    $sql = "INSERT INTO `history` ( ";
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
        $id = $db->lastInsertId('history_id');
    } catch (Exception $exc) {
        throw new Exception($exc->getMessage());
    }
    
    return $id;
}

/**
 * 
 * @param integr $userId
 * @param date $date
 * @param change_param $param
 * @param typeOf entity $entityType
 * @return mixed
 */
function getUsersEffortsCount($userId, $date, $param, $entityType)
{
     try {
    global $db;
    $sqlQuery = "SELECT COUNT(history_id) AS total_count
                 FROM history
                 WHERE 
                 user_id = '" . $userId . "' AND 
                 action_date = '" . $date . "' AND
                 change_param = '" . $param . "' AND
                 entity_type = '" . $entityType . "' AND
                 changeType != 'Assign'";
   
        $statement = $db->prepare($sqlQuery);
        $statement->execute();
        $details = $statement->fetch(PDO::FETCH_ASSOC);

        return ($details) ? $details['total_count'] : NULL;
    } catch (Exception $exc) {
        return $exc->getMessage();
    }
}

/**
 * Get all info sents according to users.
 * 
 * @param string $date
 * @return mixed (Array | NULL)
 */
function getAllInfoSentsByDate($date)
{
    global $db;
    try {
        $sql = "SELECT COUNT(h.`history_id`) AS infoCount,h.history_id,
                h.action_date,h.user_id,l.first_name AS lFirstName,
                l.last_name AS lLastName,u.first_name,u.last_name 
                FROM `history` AS h
                JOIN leads AS l ON h.entity_id = l.id
                JOIN users AS u ON h.user_id = u.id
                AND h.`change_param` = '4'
                GROUP BY h.`user_id`";

        $statement = $db->prepare($sql);
        $statement->execute();
        $infoSents = $statement->fetchAll(PDO::FETCH_ASSOC);

        return ($infoSents) ? $infoSents : NULL;
    } catch (Exception $exc) {
        return $exc->getMessage();
    }
}

/**
 * Get calls by user on respective date 
 * 
 * @global DBResource  $db
 * @param date $date
 * @return mixed (array | NULL)
 */
function getAllCallsByDate($fromDate, $toDate)
{
    global $db;

    try {
        $sql = "SELECT count(DISTINCT c.lead_id) AS callcount,c.created_at,c.user_id,
                u.first_name,u.last_name FROM `calls` AS c
                JOIN users AS u ON c.user_id  = u.id
                WHERE  c.`created_at` >= '" . $fromDate . "' 
                AND c.`created_at` <= '" . $toDate . "'
                GROUP BY c.user_id,c.`created_at`";

        $statement = $db->prepare($sql);
        $statement->execute();
        $calls = $statement->fetchAll(PDO::FETCH_ASSOC);

        return ($calls) ? $calls : NULL;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}

/**
 * Return history of entity in recent first order
 * @global DBResource $db
 * @param int $entityId
 * @param string $entityType
 * @param int $start
 * @param int $limit
 * @return mixed (array | NULL)
 */
function getHistory($entityId, $entityType, $start = 0, $limit = 5) {
    global $db;
    try {
        if ($entityType == 'Opportunity') {
            $sql = "SELECT h.*, u.first_name, u.last_name
                FROM `history` h
                JOIN users AS u ON u.id = h.user_id
                LEFT JOIN `opportunities` o on o.id = h.entity_id
                WHERE (h.`entity_id` = '$entityId' and h.entity_type = 'Opportunity')
                    OR (h.`entity_id` = (select o.lead_id from opportunities o where o.id = '$entityId') 
                    AND h.entity_type = 'Lead')";
        } else {
            $sql = "SELECT h.*, u.first_name, u.last_name
                FROM history AS h
                JOIN users AS u ON u.id = h.user_id 
                WHERE h.entity_id = '$entityId'
                    AND entity_type = '$entityType'";
        }
        
        $sql .= "ORDER BY history_id DESC
                LIMIT $start, $limit";
        //echo $sql;

        $statement = $db->prepare($sql);
        $statement->execute();
        $details = $statement->fetchAll(PDO::FETCH_ASSOC);

        return ($details) ? $details : NULL;
    } catch (Exception $exc) {
        return $exc->getMessage();
    }
}
