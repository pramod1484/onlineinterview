<?php

require_once 'include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-login.php';

try {
    global $db;
    
    $loginId = getSessionValue('user');
    $signin = getSessionValue('signInTime');
    $singOutTime = getFormattedDate();
    
    //$result = getLoginDetailsOfUser($loginId,$signin);
    if ($signin != NULL) {
        // updating the users login record.
        $updateDetails = array();
        $updateDetails['signout_time'] = $singOutTime;
        $updateDetails['status'] = 0;
        
        $where = array ('login_id' => $loginId,'signin_time' => $signin,'status'=> 1);
        $isValid = updateLoginDetails($updateDetails,$where);
         
        if ($isValid !== NULL) {
            $details = getUsersLoginDetailsByDate($loginId, getFormattedDate(NULL,"Y-m-d"));
            $signinObject = new DateTime($details['first_singin_time']);
            $signOutObject = new DateTime($singOutTime);
            $diff = $signinObject->diff($signOutObject);
            $hours = $diff->format("%h.%i");
            
            $loginData = array();
            $loginData['last_sign_of_time'] = $singOutTime;
            $loginData['hours_worked'] = $hours;
            $where = array('login_id' => $loginId, 'login_date' => getFormattedDate(NULL,"Y-m-d"));

            $updated = updateLoginMasterDetails($loginData, $where);
            if ($updated !== NULL) {
                $db = null;
               removeSessionValue('', true);               
            }            
        }          
    } 
} catch (Exception $exception) {
    setSessionValue('errorMessage', $exception->getMessage());
    redirect("dashboard.php");
}
