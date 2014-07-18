<?php
/*
 * Update Inline from View page of leads/opportunities etc.
 */
require_once dirname(__DIR__).'/include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-history.php';
require_once $include_directory . 'utils-users-efforts.php';
require_once $include_directory . 'utils-inline-form.php';

$data = json_decode(sanitizeString($_POST['info']), true);
//print_r($data); exit;
$module = sanitizeString($_POST['module']);
$id = sanitizeString($_POST['id']);
global $db;

$isUpdate = 1;
$response = array('valid' => 0, 'message' => '', 'html' => '', 'error' => 0, 'errorMessage' => '');

//Check Validation
$validationArray = getValidationArray($data, $module);
$validationResponse = Validation::_initialize($validationArray, $data);

if (!$validationResponse['valid']) {
    $response['error'] = 1;
    $response['errorMessage'] = showError($validationResponse);
    @header("Content-type: text/json");
    $jsonResponse = json_encode($response);
    echo $jsonResponse;
    exit;
}

// If multiple columns are updating
if (count($data) > 1) {
    try {
        // Update Records
        if (updateMultipleColumn($data, $module, $id)) {
            $response['valid'] = 1;
            $response['message'] = "Updated";
        }
    } catch (Exception $exception) {
        $response['error'] = 1;
        $response['errorMessage'] = 'Error Occured 1';
    }
} else {
    //Single column updating
    try {
        $value = reset($data);
        $key = key($data);
        $entityType = ''; 
        switch ($module) {
            case 'opportunities' : $entityType = 'Opportunity'; break;
            case 'leads' : $entityType = 'Lead'; break;
        }
        if ($key == 'assignedUserId' || $key == 'call_status'  || $key == 'status' || $key == 'stage') {
            $key = ($key == 'assignedUserId') ? 'assigned_user_id' : $key;
            // Check whether previous record is same
            if (isChanged($key, $value, $module, $id)) {
                $isUpdate = 0;
                $response['error'] = 1;
                $response['errorMessage'] = 'Same Value';
            } else {
                //Create history Data
                $historyData = array();
                switch ($module) {
                    case 'opportunities' : $historyData['entity_type'] = 'Opportunity'; 
                        break;
                    case 'leads' : $historyData['entity_type'] = 'Lead'; 
                        break;
                }
                switch ($key) {
                    case 'stage' : $historyData['changeType'] = 'Stage'; 
                        break;
                    case 'status' : $historyData['changeType'] = 'Status'; 
                        break;
                    case 'call_status' : $historyData['changeType'] = 'Call Status'; 
                        break;
                    case 'assigned_user_id' : $historyData['changeType'] = 'Assign'; 
                        break;
                }
                
                $historyData['entity_id'] = $id; 
                $historyData['user_id'] = getSessionValue('user'); 
                $historyData['change_param'] = $value; 
                $historyData['action_date'] = getFormattedDate();
                $historyData['entity_type'] = $entityType;
            }
        }
       
        //If db record is not same
        if ($isUpdate == 1 && $key != 'teamsIds' && $key != 'phone') {
            //Update DB record
            if (updateDbRecord($key, $value, $module, $id)) {
                
                // add entry in the history table.
                if (isset($historyData)) {
                    try {
                        addHistory($historyData);
                        $response['stream'] = 1;
                        if (($entityType == 'Lead' && $key == 'status' && $value == 4) 
                                || ($entityType == 'Opportunity' && $key == 'stage' && ($value == 3 || $value == 2))) {
                            // get the total count according to the users efforts
                            $effortDate = getFormattedDate(NULL, "Y-m-d");
                            $effortsCount = getUsersEffortsCount(getSessionValue('user'),
                                                                 $effortDate,
                                                                 $value,
                                                                 $entityType);
                            if (($entityType == 'Lead' && $value == 4)) {
                                $updateData['info_sent_count'] = $effortsCount;
                            } elseif ($entityType == 'Opportunity') {
                                if ($value == 2) {
                                    $updateData['appointments_count'] = $effortsCount;
                                } elseif ($value == 3) {
                                    $updateData['specs_count'] = $effortsCount;
                                }
                            }
                            $where = array('id' => getSessionValue('effortId'));
                            updateUsersEfforts($updateData, $where);
                        }
                    } catch (Exception $e) {
                        $isUpdate = 0;
                        $response['valid'] = 0;
                        $response['error'] = 1;
                        $response['errorMessage'] = 'Error Occured3';
                    }
                }
                if ($isUpdate) {
                    $response['valid'] = 1;
                    $response['message'] = "Updated";
                }
            } else {
                $response['error'] = 1;
                $response['errorMessage'] = 'Error Occured4';
                $isUpdate = 0;
            }
        }
       
        // If teams are updated then those teams will be added in different table
        if ($key == 'teamsIds') {
            $teamIds = ($value) ? explode(",", $value) : 0;
            if ($teamIds !== 0) {
                updateTeam($teamIds, $id, $entityType);
                $isUpdate = 1;
                $response['valid'] = 1;
                $response['message'] = "Updated";
            } else {
                $isUpdate = 0;
            }
        } elseif ($key == 'phone') {
            $phones = ($value) ? explode(",", $value) : 0;
            if ($phones !== 0) {
                updateEntityPhones($id, $phones, $entityType);
                $isUpdate = 1;
                $response['valid'] = 1;
                $response['message'] = "Updated";
            } else {
                $isUpdate = 0;
            }
        }
        
    } catch (Exception $exception) {
        $response['error'] = 1;
        $response['errorMessage'] = 'Error Occured5';
        $isUpdate = 0;
    }
}

$response['modifiedAt']= '<span class="field-createdAt">' . getFormattedDate(NULL, "m/d/Y H:i") . ' </span> by <span class="field-createdBy">
    <a href="' . ADMINPATH . 'modules/users/view.php?id=' . getSessionValue('user') . '">' . getSessionValue('firstName') . ' ' . getSessionValue('lastName')  . '</a>
        </span>';



//create return html according to field
if ($isUpdate) {
    $response['html'] = createHtml($data, $module, $id);
}

@header("Content-type: text/json");
$jsonResponse = json_encode($response);
echo $jsonResponse;
?>
