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

if (!empty($_POST) && !empty($_POST['email_outbound'])) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('smtpServer' => array('required' => true),
            'smtpPort' => array('required' => true, 'number' => true),
            'outboundFromName' => array('required' => true),
            'outboundFromAddress' => array('required' => true)
        ),
        'messages' => array('smtpServer' => array('required' => 'Enter Server Name'),
            'smtpPort' => array('required' => 'Enter Port Number', 'number' => 'Port Number should be Number'),
            'outboundFromName' => array('required' => 'Enter From Name'),
            'outboundFromAddress' => array('required' => 'Enter From Address')
        ),
    );

    if (isset($_POST['smtpAuth'])) {
        $array['rules']['smtpUsername'] = array('required' => true);
        $array['messages']['smtpUsername'] = array('required' => 'Enter Username');
    }

    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/email/');
    } else {
        $fields = array();
        $fields['server'] = escapeString($_POST['smtpServer']);
        $fields['port'] = escapeString($_POST['smtpPort']);
        $fields['security'] = escapeString($_POST['smtpSecurity']);
        if (isset($_POST['smtpAuth'])) {
            $fields['auth'] = 1;
            $fields['username'] = escapeString($_POST['smtpUsername']);
            $fields['password'] = escapeString($_POST['smtpPassword']);
        } else {
            $fields['auth'] = 0;
        }
        $fields['from_name'] = escapeString($_POST['outboundFromName']);
        $fields['from_address'] = escapeString($_POST['outboundFromAddress']);
        
        $where = array('deleted' => 0, 'id' => (int)$_POST['email_outbound']);
        updateOutboundMailDetails($fields, $where);
        
        // redirecting user to view page.
        redirect('administration/modules/email/');
    }
}
?>
