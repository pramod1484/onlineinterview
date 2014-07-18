<?php
require_once dirname(__DIR__).'/../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-task.php';
require_once $include_directory . 'utils-entity-teams.php';
//echo '<pre>';print_r($_POST); echo '</pre>'; exit; 
if (!empty($_POST)) {

    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true), 'assignedUserId' => array('required'=> true)),
        'messages' => array('name' => array('required' => 'Name is required'), 'assignedUserId' => array('required'=> 'Assign User Required'))
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('modules/task/edit.php?id=' . $_POST['task']);
    } else {
        $taskId = escapeString($_POST['task']);
        // check for optional values. 
        $oppId = ($_POST['opportunityIds']) ? escapeString($_POST['opportunityIds']) : NULL;

        $date_start = $_POST['date_start'] . ' ' . $_POST['date_start-time'];
        $date_end = $_POST['date_end'] . ' ' . $_POST['date_end-time'];

        if (strtotime($date_end) < strtotime($date_start)) {
            setSessionValue('errorMessage', 'Invalid Date Range');
            redirect('modules/task/edit.php?id=' . $taskId);
            exit;
        }

        //$taskPrevDetails = getTaskDetails($taskId);

        $fields = array();
        $fields['name'] = trim($_POST['name']);
        $fields['status'] = escapeString($_POST['status']);
        $fields['date_start'] = getFormattedDate($date_start);
        $fields['date_end'] = getFormattedDate($date_end);
        $fields['priority'] = escapeString($_POST['priority']);
        $fields['description'] = escapeString($_POST['description']);
        $fields['modified_at'] = getFormattedDate();
        $fields['assigned_user_id'] = escapeString($_POST['assignedUserId']);
        $fields['modified_by_id'] = getSessionValue('user');
        $fields['parent_id'] = $oppId;
        $fields['parent_type'] = 'Opportunity';

        $where = array('id' => (int) $taskId);

        try {
            // Adding lead details.
            updateTaskDetails($fields, $where);

            // If teams are selected then those teams will be added in different table
            $teamIds = ($_POST['teamsIds']) ? explode(",", $_POST['teamsIds']) : 0;
            if ($teamIds !== 0) {
                updateTeam($teamIds, $taskId, 'Task');
            }
            
            // redirecting user to view page.
            redirect('modules/task/view.php?id=' . $taskId);
        } catch (Exception $exc) {
            setSessionValue('errorMessage', $exc->getMessage());
            // redirecting user to Edit page.
            redirect('modules/task/edit.php?id=' . $taskId);
        }
    }
}