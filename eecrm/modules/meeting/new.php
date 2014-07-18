<?php
require_once dirname(__DIR__).'/../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-meeting.php';
require_once $include_directory . 'utils-entity-teams.php';

if (!empty($_POST)) {
     
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('name' => array('required'=> true)),
                   'messages'  => array('name' => array('required'=> 'Name is required'))
             );
    
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage',showError($response));
        redirect('modules/meeting/create.php');
    } else {
 
        // check for optional values. 
        $oppId = ($_POST['opportunityIds']) ? escapeString($_POST['opportunityIds']) : NULL; 
        
        $date_start = $_POST['date_start'] . ' ' . $_POST['date_start-time'];
        $date_end = $_POST['date_end'] . ' ' . $_POST['date_end-time']; 
        
        if (strtotime($date_end) < strtotime($date_start)) {
           setSessionValue('errorMessage', 'Invalid Date Range'); 
           redirect('modules/meeting/create.php');
           exit;
        }
               
        $fields = array();
        $fields['name'] = trim($_POST['name']);
        $fields['status'] = escapeString($_POST['status']);
        $fields['date_start'] = getFormattedDate($date_start);
        $fields['date_end'] = getFormattedDate($date_end);
        $fields['duration'] = strtotime($date_end) - strtotime($date_start);
        $fields['description'] = escapeString($_POST['description']);
        $fields['created_at'] = getFormattedDate();
        $fields['modified_at'] = getFormattedDate();
        $fields['assigned_user_id'] = escapeString($_POST['assignedUserId']);
        $fields['modified_by_id'] = getSessionValue('user');
        $fields['created_by_id'] = getSessionValue('user');
        $fields['parent_id'] = $oppId;
        $fields['parent_type'] = 'Opportunity';
        
        
        try {
            // Adding lead details.
            $meetId = addNewMeetingDetails($fields);
            
            // If teams are selected then those teams will be added in different table
            $teamIds = ($_POST['teamsIds']) ? explode(",", $_POST['teamsIds']) : 0;
            if ($teamIds !== 0) {
                addTeams($teamIds, $meetId, 'Meeting');
            }
            
            // If users are selected then those users will be added meeting_entity
            $usersIds = ($_POST['usersIds'] && $_POST['usersIds'] != '') ? explode(",", $_POST['usersIds']) : 0;
            if ($usersIds !== 0) {
                addMeetingEntity($usersIds, $meetId, 'User');
            }
            
            // If leads are selected then those leads will be added meeting_entity
            $leadsIds = ($_POST['leadsIds'] && $_POST['leadsIds'] != '') ? explode(",", $_POST['leadsIds']) : 0;
            if ($leadsIds !== 0) {
                addMeetingEntity($leadsIds, $meetId, 'Lead');
            }
            
            // redirecting user to view page.
            redirect('modules/meeting/view.php?id=' . $meetId);            
        } catch (Exception $exc) {
            setSessionValue('errorMessage', $exc->getMessage());
            // redirecting user to view page.
            redirect('modules/meeting/create.php');            
        }
    }    
}