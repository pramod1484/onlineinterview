<?php
/*
 * Mail details and Mail settings Operations
 * 
 */
require_once dirname(__DIR__).'/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-mail.php';

if (!empty($_POST) && !empty($_POST['email_inbound'])) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array(
            'name' => array('required' => true),
            'host' => array('required' => true),
            'username' => array('required' => true),
            'port' => array('required' => true),
            'monitoredFolders' => array('required' => true),
            'trashFolder' => array('required' => true)
        ),
        'messages' => array(
            'name' => array('required' => 'Name is required'),
            'host' => array('required' => 'Host is required'),
            'username' => array('required' => 'Username is required'),
            'port' => array('required' => 'Port is required'),
            'monitoredFolders' => array('required' => 'Monitored Folder is required'),
            'trashFolder' => array('required' => 'Trash Folder is required')
        ),
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/email/inbound-create.php');
    } else {
        $fields = array();
        $fields['name'] = escapeString($_POST['name']);
        $fields['status'] = escapeString($_POST['status']);
        $fields['host'] = escapeString($_POST['host']);
        $fields['port'] = escapeString($_POST['port']);
        $fields['username'] = escapeString($_POST['username']); 
        $fields['password'] = escapeString($_POST['password']);
        $fields['monitored_folders'] = escapeString($_POST['monitoredFolders']);
        $fields['trash_folder'] = escapeString($_POST['trashFolder']);
        $fields['assigned_user_id'] = escapeString($_POST['assignToUserId']);
        $fields['team_id'] = escapeString($_POST['teamId']);
        $fields['modified_at'] = getFormattedDate();
        $fields['modified_by_id'] = getSessionValue('user');
        
        $where = array('id' => (int) $_POST['email_inbound']);
        
        try {
            updateMailDetails('email_inbound', $fields, $where);
            
            // redirecting user to view page.
            redirect('administration/modules/email/inbound-view.php?id=' . $_POST['email_inbound']);
        } catch (Exception $e) {
            setSessionValue('errorMessage', $e->getMessage());
            redirect('administration/modules/email/inbound-create.php');
        } 
        
    }
}
?>
