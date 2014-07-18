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
                'maxLength' => 100)
        ),
        'messages' => array('name' => array('required' => 'Please enter source name',
                'maxLength' => 'Source name must be less than 100 characters')
        ),
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/sources/create.php');
    } else {
        $fields = array();
        $fields['source_name'] = escapeString($_POST['name']);
        $fields['created_by_id'] = getSessionValue('user');
        $fields['created_at'] = getFormattedDate();

        // Adding Source details now
        $sourceId = addNewSourceDetails($fields);

        redirect('administration/modules/sources/view.php?id=' . $sourceId);
    }
}