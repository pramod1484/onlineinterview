<?php
require_once dirname(__DIR__).'/../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-call.php';
require_once $include_directory . 'utils-entity-teams.php';
//echo '<pre>';print_r($_POST); echo '</pre>'; exit; 
if (!empty($_POST)) {

    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true), 'assignedUserId' => array('required' => true)),
        'messages' => array('name' => array('required' => 'Name is required'), 'assignedUserId' => array('required' => 'Assign User is empty'))
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('modules/call/edit.php?id=' . $_POST['call']);
    } else {
        $callId = escapeString($_POST['call']);
        // check for optional values. 
        $oppId = ($_POST['opportunityIds']) ? escapeString($_POST['opportunityIds']) : NULL;

        $date_start = $_POST['date_start'] . ' ' . $_POST['date_start-time'];
        $date_end = date("Y-m-d H:i:s", strtotime($date_start) + (int) escapeString($_POST['duration']));

        if (strtotime($date_end) < strtotime($date_start)) {
            setSessionValue('errorMessage', 'Invalid Date Range');
            redirect('modules/call/edit.php?id=' . $callId);
            exit;
        }

        //$callPrevDetails = getCallDetails($callId);

        $fields = array();
        $fields['name'] = trim($_POST['name']);
        $fields['status'] = escapeString($_POST['status']);
        $fields['date_start'] = getFormattedDate($date_start);
        $fields['date_end'] = getFormattedDate($date_end);
        $fields['duration'] = escapeString($_POST['duration']);
        $fields['direction'] = escapeString($_POST['direction']);
        $fields['description'] = escapeString($_POST['description']);
        $fields['modified_at'] = getFormattedDate();
        $fields['assigned_user_id'] = escapeString($_POST['assignedUserId']);
        $fields['modified_by_id'] = getSessionValue('user');
        $fields['parent_id'] = $oppId;
        $fields['parent_type'] = 'Opportunity';

        $where = array('id' => (int) $callId);

        try {
            // Update Call details.
            updateCallDetails($fields, $where);

            // If teams are selected then those teams will be added in different table
            $teamIds = ($_POST['teamsIds']) ? explode(",", $_POST['teamsIds']) : 0;
            if ($teamIds !== 0) {
                updateTeam($teamIds, $callId, 'Call');
            }

            // If users are selected then those users will be added call_entity
            $usersIds = ($_POST['usersIds'] && $_POST['usersIds'] != '') ? explode(",", $_POST['usersIds']) : 0;
            if ($usersIds !== 0) {
                addCallEntity($usersIds, $callId, 'User');
            }

            // If leads are selected then those leads will be added call_entity
            $leadsIds = ($_POST['leadsIds'] && $_POST['leadsIds'] != '') ? explode(",", $_POST['leadsIds']) : 0;
            if ($leadsIds !== 0) {
                addCallEntity($leadsIds, $callId, 'Lead');
            }

            // redirecting user to view page.
            redirect('modules/call/view.php?id=' . $callId);
        } catch (Exception $exc) {
            setSessionValue('errorMessage', $exc->getMessage());
            // redirecting user to Edit page.
            redirect('modules/call/edit.php?id=' . $callId);
        }
    }
}