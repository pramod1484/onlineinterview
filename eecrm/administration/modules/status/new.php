<?php

require_once dirname(__DIR__) . '/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-status.php';

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true,
                'maxLength' => 100)
        ),
        'messages' => array('name' => array('required' => 'Please enter status name',
                'maxLength' => 'Status name must be less than 100 characters')
        ),
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/status/create.php');
    } else {
        $fields = array();
        $fields['status_name'] = escapeString($_POST['name']);
        $fields['created_by_id'] = getSessionValue('user');
        $fields['created_at'] = getFormattedDate();

        // Adding Status details now
        $statusId = addNewStatusDetails($fields);

        redirect('administration/modules/status/view.php?id=' . $statusId);
    }
}