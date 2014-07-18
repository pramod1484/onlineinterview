<?php

require_once dirname(__DIR__) . '/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-call_status.php';

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true,
                'maxLength' => 100)),
        'messages' => array('name' => array('required' => 'Please enter Status name',
                'maxLength' => 'Status name must be less than 100 characters')
        )
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/call_status/edit.php?id=' . $_POST['status_id']);
    } else {
        $fields = array();
        $fields['status_name'] = escapeString($_POST['name']);

        $where = array('status_id' => (int) $_POST['status_id']);
        // updating status details now
        updateCallStatusDetails($fields, $where);

        redirect('administration/modules/call_status/view.php?id=' . $_POST['status_id']);
    }
}