<?php
require_once dirname(__DIR__).'/../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-leads.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-history.php';
require_once $include_directory . 'utils-users-efforts.php';

if (!empty($_POST)) {
     
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('salutationName' => array('required'=> true),
                                     'firstName' => array('required'=> true),
                                     'lastName' => array('required'=> true),
                                     'assignedUserId' => array('required'=> true),
                                     'emailAddress' => array('email' => true)),
                   'messages'  => array(
                                     'salutationName' => array('required'=> 'Select Salutation Name'),
                                     'firstName' => array('required'=> 'Enter First Name'),
                                     'lastName' => array('required'=> 'Enter Last Name'),
                                     'assignedUserId' => array('required'=> 'Select Assinged To'),
                                     'emailAddress' => array('email' => 'Enter valid email address')),
             );
    
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage',showError($response));
        redirect('modules/leads/create.php');
    } else {
 
        // check for optional values.
        $title = ($_POST['title'])? $_POST['title']:''; 
        $phone = ($_POST['phone'])? $_POST['phone']:0; 
        
        
        $fields = array();
        $fields['salutation_name'] = trim($_POST['salutationName']);
        $fields['first_name'] = escapeString($_POST['firstName']);
        $fields['last_name'] = escapeString($_POST['lastName']);
        $fields['title'] = escapeString($title);
        $fields['account_name'] = escapeString($_POST['accountName']);
        $fields['assigned_user_id'] = $_POST['assignedUserId'];
        $fields['address_street'] = escapeString($_POST['addressStreet']);
        $fields['address_city'] = escapeString($_POST['addressCity']);
        $fields['address_state'] = escapeString($_POST['addressState']);
        $fields['address_country'] = escapeString($_POST['addressCountry']);
        $fields['address_postal_code'] = escapeString($_POST['addressPostalCode']);
        $fields['website'] = escapeString($_POST['website']);
        $fields['email_address'] = $_POST['emailAddress'];
        $fields['status'] = escapeString($_POST['status']);
        $fields['call_status'] = escapeString($_POST['call_status']);
        $fields['source'] = escapeString($_POST['source']);
        //$fields['opportunity_amount_currency'] = escapeString($_POST['opportunityAmountCurrency']);
        //$fields['opportunity_amount'] = $_POST['opportunityAmount'];
        $fields['do_not_call'] = 0;
        $fields['description'] = escapeString($_POST['description']);
        $fields['created_by_id'] = getSessionValue('user');
        $fields['created_at'] = getFormattedDate();
        
        try {
            // Adding lead details.
            $leadId = addNewLeadDetails($fields);
            
            // add entry in history table 
            $data = array();
            $data['entity_id'] = $leadId; 
            $data['user_id'] = getSessionValue('user'); 
            $data['change_param'] = $_POST['status']; 
            $data['changeType'] = 'Create';
            $data['action_date'] = getFormattedDate();
            $data['entity_type'] = 'Lead';
            // add entry in the history table.
            addHistory($data);
                    
            //Update user efforts if status is Info sent
            if ($_POST['status'] == 4) {
                // get the total count according to the users efforts
                $effortDate = getFormattedDate(NULL, "Y-m-d");
                $effortsCount = getUsersEffortsCount(getSessionValue('user'), $effortDate, $_POST['status'], 'Lead');
                $updateData['info_sent_count'] = $effortsCount;
                $where = array('id' => getSessionValue('effortId'));
                updateUsersEfforts($updateData, $where);
            }
            
            // If teams are selected then those teams will be added in different table
            // team-leads.
            $teamIds = ($_POST['teamsIds'])? explode(",", $_POST['teamsIds']):0;
            if ($teamIds !== 0) {
                addTeams($teamIds, $leadId, 'Lead');
            }
            
            //Add Phones
            if ($phone !== 0 || isset($_POST['phoneVal'])) {
                $phones = array();
                if ($phone !== 0) {
                    $phones = explode(',', $phone);
                }
                if (isset($_POST['phoneVal']) && $_POST['phoneVal'] != '' && !in_array($_POST['phoneVal'], $phones)) {
                    $phones[] = escapeString($_POST['phoneVal']);
                }
                addLeadPhones($leadId, $phones);
            }
            
            // redirecting user to view page.
            redirect('modules/leads/view.php?id='.$leadId);            
        } catch (Exception $exc) {
            setSessionValue('errorMessage', $exc->getMessage());
            // redirecting user to view page.
            redirect('modules/leads/create.php');            
        }
    }    
}