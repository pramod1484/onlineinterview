<?php
require_once 'database.php';
require_once 'utils-users.php';

/**
 * Check whether update value is same as DB
 * 
 * @global type $db 
 * @param string $key column name to update
 * @param string $value value to update
 * @param string $module table name
 * @param int $id id of row
 * @return boolean Return true if record is same
 */
function isChanged($key, $value, $module, $id) {
    global $db;
    $ret = false;
    $sqlQuery = "SELECT id 
                 FROM `$module`
                 WHERE id = $id AND `$key` = '$value'";
    //echo $sqlQuery; exit;
    $stmt = $db->prepare($sqlQuery);
    $stmt->execute();           
    if ($stmt->rowCount() > 0) {
       $ret = true;
    }
    
    return $ret;
}

/**
 * Update single column value
 * 
 * @global type $db 
 * @param string $key column name to update
 * @param string $value value to update
 * @param string $module table name
 * @param int $id id of row
 * @return boolean Return true if record is Updated
 */
function updateDbRecord($key, $value, $module, $id) {
    global $db;
    $ret = false;
    
    $sqlQuery = "UPDATE `$module` SET `$key` = '$value', ";
    $sqlQuery .= "modified_by_id = '" . getSessionValue('user') . "', "
                 . "modified_at = '" . getFormattedDate() . "'
                 WHERE id = $id";
    $stmt = $db->prepare($sqlQuery);
    if ($stmt->execute()) {
        $ret = true;
    }
    
    return $ret;
}

/**
 * Update multiple column values
 * 
 * @global type $db 
 * @param array $data data to update
 * @param string $module table name
 * @param int $id id of row
 * @return boolean Return true if record is Updated
 */
function updateMultipleColumn($data, $module, $id) {
    global $db;
    $ret = false;
    $updateArray = array();
    
    foreach ($data as $column => $value) {
        $updateArray[] = "$column = '$value'"; 
    }
    if (count($updateArray) >= 1) {
        $sqlQuery = "UPDATE `$module` SET " . implode(', ', $updateArray) . ", ";
        $sqlQuery .= "modified_by_id = '" . getSessionValue('user') . "', "
                    . "modified_at = '" . getFormattedDate() . "'";
        $sqlQuery .= "WHERE id = $id";
        $stmt = $db->prepare($sqlQuery);
        if ($stmt->execute()) {
            $ret = true;
        }
    }
    
    return $ret;
}

/**
 * Create html for returning it to View
 * 
 * @param array $data updation data
 * @param string $module table name
 * @param int $id id of row
 * @return string
 */
function createHtml($data, $module, $id) {
    $html = '';
    $address = '';
    foreach ($data as $column => $value) {
        switch ($column) {
            case 'email_address':
                    $html .= '<a data-action="mailTo" data-email-address="' . $value . '" href="javascript:">' . $value . '</a>';
                    break;
            case 'phone':
                    $phones = ($value) ? explode(",", $value) : 0;
                    if ($phones !== 0) {
                        foreach($phones as $phone) {
                            $html .= ($html != '') ? ',' : '';
                            $html .= '<a href="javascript:void(0);" class="makeacall" data-leadid="' . $id . '">' . $phone . '</a>';
                        }
                    }
                    break;
            case 'website':
                    $html .= '<a href="' . $value . '">' . $value . '</a>';
                    break;
            case 'address_street':
            case 'address_postal_code': 
            case 'address_state': 
            case 'address_city':
            case 'address_country':
                    if ($address == '') {
                        $address .= sanitizeString($data['address_street']) . ' <br/>
                                ' . sanitizeString($data['address_city']) . ', 
                                ' . sanitizeString($data['address_state']) . ' 
                                ' . sanitizeString($data['address_postal_code']) . '<br/>
                                ' . sanitizeString($data['address_country']);
                        $html = $address;
                    }
                    break;
            case 'assignedUserId':
                    $html .= '<a href="' . ADMINPATH . 'modules/users/view.php?id=' . $value . '"> ' . getUserName($value) . '</a>';
                    break;
            case 'teamsIds':
                    $html .= getTeamLinks($value);
                    break;
            case 'status':
                case 'call_status':
            case 'source':
            case 'lead_source':
            case 'stage':
                    $html .= getFieldName($column, $value);
                    break;
            case 'do_not_call': 
                    $checked = ($value) ? 'checked="checked"' : '';
                    $html = '<input onchange="setCheckBox(this, \'do_not_call\', 0, 1);" type="checkbox" ' . $checked . '>';    
                    break;
            default : $html .= "$value ";
                    break;
        }
    }
    
    return $html;
}


/**
 * return Links of teams of entity
 * 
 * @param string $userId team ids separeted by coma
 * @return string
 */
function getTeamLinks($teamIds) {
    global $db;
    $teamLinks = '';
    $stmt = $db->prepare("SELECT t.id as teamId, t.name as teamName
                          FROM teams AS t 
                          WHERE t.id in ($teamIds) and t.deleted = '0' ORDER BY teamName ASC");
    
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetchAll(); 
        foreach ($details as $team) {
            $teamLinks .= ($teamLinks != '') ? ',' : '';
            $teamLinks .= '<a href="' . ADMINPATH . 'modules/teams/view.php?id=' . $team['teamId'] . '">
                         ' . $team['teamName'] . '</a>';
        }
    }
    
    return $teamLinks;
}

/**
 * return user name by id
 * 
 * @param int $userId id of user
 * @return string
 */
function getFieldName($field, $id) {
    global $db;
    $fieldName = '';
    $sqlQuery = '';
    switch ($field) {
        case 'call_status':
                $sqlQuery = "SELECT status_name FROM call_status WHERE status_id = $id";
                $fieldName = 'status_name';
                break;
        case 'status':
                $sqlQuery = "SELECT status_name FROM status WHERE status_id = $id";
                $fieldName = 'status_name';
                break;
        case 'source':
        case 'lead_source':
                $sqlQuery = "SELECT source_name FROM sources WHERE source_id = $id";
                $fieldName = 'source_name';
                break;
        case 'stage':
                $sqlQuery = "SELECT stage_name FROM stages WHERE stage_id = $id";
                $fieldName = 'stage_name';
                break;
    }
    $stmt = $db->prepare($sqlQuery);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_OBJ);
        $fieldName = $details->$fieldName;
    }
    
    return $fieldName;
}

/**
 * return Validation array according to validation class
 * 
 * @param array $data Data to apply validation
 * @param string $module Kept it for future reference
 * @return array
 */
function getValidationArray($data, $module) {
    $array = array('method' => 'POST');
    $rules = array();
    $messages = array();
    foreach ($data as $column => $value) {
        if ($column == 'email_address') {
            $rules[$column] = array('required'=> true, 'email' => true);
            $messages[$column] = array(
                                        'required' => 'Please Enter some value',
                                        'email'    => 'Please Enter Valid Email'
                                    );
        } else {
            $rules[$column] = array('required'=> true);
            $messages[$column] = array('required'=> 'Please Enter some value');
        }
    }
    $array['messages'] = $messages;
    $array['rules'] = $rules;
    
    return $array;
}


/**
 * Update Entity Phones to DB
 * 
 * @global Resource $db
 * @param int $entity_id Entity Id 
 * @param array $phones Phone numbers 
 * @return boolean True on success
 */
function updateEntityPhones($entity_id, $phones, $entity) {
    global $db;
    $return = FALSE;
    $delete = "DELETE FROM entity_phone 
                  WHERE entity_id = " . $entity_id . " AND entity_type = '$entity'";
    $statement = $db->prepare($delete);
    $statement->execute();
    foreach ($phones as $phone) {
        $sql = "INSERT INTO `entity_phone` (entity_id, entity_type, phone)
                VALUES ('$entity_id', '$entity', '$phone')";
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
?>
