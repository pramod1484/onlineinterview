<?php

require_once dirname(__DIR__).'/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-team-users.php';
require_once $include_directory . 'utils-roles.php';

if (!empty($_POST)) {
     
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('userName' => array('required'=> true), 
                                     'salutationName' => array('required'=> true),
                                     'firstName' => array('required'=> true),
                                     'lastName' => array('required'=> true),
                                     'emailAddress' => array('email'=> true),
                                     'password' => array('required'=> true),
                                     'passwordConfirm' => array('required'=> true)
                       ),
                   'messages'  => array('userName' => array('required'=> 'Enter Username'), 
                                     'salutationName' => array('required'=> 'Select Salutation Name'),
                                     'firstName' => array('required'=> 'Enter First Name'),
                                     'lastName' => array('required'=> 'Enter Last Name'),
                                     'emailAddress' => array('email'=> 'Enter Valid Email Address'),
                                     'password' => array('required'=> 'Enter Password'),
                                     'passwordConfirm' => array('required'=> 'Enter Confirm Password')
                       ),
             );
    
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage',showError($response));
        redirect('administration/modules/users/create.php');
    } else if ($_POST['password'] != $_POST['passwordConfirm']) {
        $response[0] = 'Passwords do not matches';
        setSessionValue('errorMessage',showError($response));
        redirect('administration/modules/users/create.php');
    } else {
        // check for optional values.
        $defaultTeamId = ($_POST['defaultTeamId'])? $_POST['defaultTeamId']:0;
        $title = ($_POST['title'])? $_POST['title']:''; 
        $phone = ($_POST['phone'])? $_POST['phone']:0; 
        
        $fields = array();
        $fields['salutation_name'] = trim($_POST['salutationName']);
        $fields['user_name'] = trim($_POST['userName']);
        $fields['first_name'] = escapeString($_POST['firstName']);
        $fields['last_name'] = escapeString($_POST['lastName']);
        $fields['email_address'] = trim($_POST['emailAddress']);
        $fields['title'] = escapeString($title);
        $fields['phone'] = $phone;
        $fields['default_team_id'] = $defaultTeamId;
        $fields['password'] = md5($_POST['password']);
        
        // Adding user details.
        $userId = addNewUserDetails($fields);
        // If teams are selected then those teams will be added in different table
        // team-users.
        $teamIds = ($_POST['teamsIds'])? explode(",", $_POST['teamsIds']):0;
        if ($teamIds !== 0) {
            addUsersTeams($teamIds, $userId);
        }
        
        $roleIds = ($_POST['rolesIds']) ? explode(",", $_POST['rolesIds']):0;
        if ($roleIds !== 0) {
            addRoleEntity($roleIds, $userId, 'User');
        }
        // redirecting user to view page.
        redirect('administration/modules/users/view.php?id='.$userId);
    }    
}