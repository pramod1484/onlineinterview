<?php

require_once dirname(__DIR__).'/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-team-users.php';

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('userName' => array('required'=> true), 
                                     'salutationName' => array('required'=> true),
                                     'firstName' => array('required'=> true),
                                     'lastName' => array('required'=> true),
                                     'emailAddress' => array('email'=> true)
                       ),
                   'messages'  => array('userName' => array('required'=> 'Enter Username'), 
                                     'salutationName' => array('required'=> 'Select Salutation Name'),
                                     'firstName' => array('required'=> 'Enter First Name'),
                                     'lastName' => array('required'=> 'Enter Last Name'),
                                     'emailAddress' => array('email'=> 'Enter Valid Email Address')
                       ),
             );
    
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage',showError($response));
        redirect('administration/modules/users/edit.php?id='.$_POST['user']);
    } else {
        $defaultTeamId = ($_POST['defaultTeamId'])? $_POST['defaultTeamId']:0;
        
        $fields = array();
        $fields['salutation_name'] = trim($_POST['salutationName']);
        $fields['user_name'] = trim($_POST['userName']);
        $fields['first_name'] = escapeString($_POST['firstName']);
        $fields['last_name'] = escapeString($_POST['lastName']);
        $fields['email_address'] = trim($_POST['emailAddress']);
        $fields['title'] = escapeString($_POST['title']);
        $fields['phone'] = trim($_POST['phone']);
        $fields['default_team_id'] = $defaultTeamId;
        
        if (trim($_POST['password']) != '' && 
            trim($_POST['passwordConfirm']) != '' &&
            (trim($_POST['password']) == trim($_POST['passwordConfirm']))) {
               $fields['password'] = trim(md5($_POST['password'])); 
        }
        
        $where = array('id' => (int) $_POST['user']);
        
        try {
            // updating user details now
            updateUserDetails($fields, $where);

            // If teams are selected then those teams will be added in different table
            // team-users.
            $teamIds = ($_POST['teamsIds'])? explode(",", $_POST['teamsIds']):0;
            if ($teamIds !== 0) {
                updateUsersTeam($teamIds, $_POST['user']);
            }
            redirect('administration/modules/users/view.php?id='.$_POST['user']);
        } catch (Exception $exception) {
            setSessionValue('errorMessage', $exception->getMessage());
            redirect('administration/modules/users/edit.php?id='.$_POST['user']);
        }
    }    
}