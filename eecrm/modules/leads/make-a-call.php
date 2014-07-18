<?php
session_start();
require_once dirname(__DIR__).'/../include-locations.php';
require_once dirname(__DIR__)."/../include/define.php";
require_once dirname(__DIR__)."/../include/utils-helpers.php";
require_once dirname(__DIR__)."/../include/utils-calls.php";
require_once $include_directory . 'utils-users-efforts.php';

if (!empty($_POST)) {
    if (!empty($_POST['entityId'])) {
        $data = array();
        $data['user_id'] = getSessionValue('user');
        $data['entity_id'] = $_POST['entityId'];
        $data['entity_type'] = $_POST['entityType'];
        $data['created_at'] = getFormattedDate(NULL, "Y-m-d");
        $data['start_time'] = getFormattedDate();
        
       if(addNewCall($data)){
        // get the total count according to the users efforts
                    $effortDate = getFormattedDate(NULL, "Y-m-d");
                    $effortsCount = getCallsCountByDate($effortDate);
                    $updateData['calls_count'] = $effortsCount;
                    $where = array('id' => getSessionValue('effortId'));
                    updateUsersEfforts($updateData,$where);
       }
                    
       }
}
?>