<?php

require_once dirname(__DIR__) . '/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-sources.php';

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true,
                'maxLength' => 100)),
        'messages' => array('name' => array('required' => 'Please enter Source name',
                'maxLength' => 'Source name must be less than 100 characters')
        )
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/sources/edit.php?id=' . $_POST['source_id']);
    } else {
        $fields = array();
        $fields['source_name'] = escapeString($_POST['name']);

        $where = array('source_id' => (int) $_POST['source_id']);
        // updating Source details now
        updateSourceDetails($fields, $where);

        redirect('administration/modules/sources/view.php?id=' . $_POST['source_id']);
    }
}