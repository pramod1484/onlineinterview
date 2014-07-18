<?php
/**
 * This file save the details of the lead into opportunity table when it is 
 * going to converted to the opportunity.
 * 
 */
require_once dirname(__DIR__).'/../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-opportunities.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-history.php';
require_once $include_directory . 'utils-users-efforts.php';

if (!empty($_POST)) {
     
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('company_name' => array('required'=> true),
                                     'name' => array('required'=> true),
                                     'stage' => array('required'=> true),
                                     'source' => array('required'=> true),
                                     'assignedUserId' => array('required'=> true),
                                     'emailAddress' => array('email' => true)),
                   'messages'  => array(
                                     'company_name' => array('required'=> 'Enter company name'),
                                     'name' => array('required'=> 'Enter name.'),
                                     'stage' => array('required'=> 'Select Stage'),
                                     'source' => array('required'=> 'Select Source'),
                                     'assignedUserId' => array('required'=> 'Select Assinged To'),
                                     'emailAddress' => array('email' => 'Enter valid email address')),
             );
    
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage',showError($response));
        redirect('modules/opportunities/edit.php?id='.$_POST['opportunity_id']);            
    } else {
 
        // check for optional values.
        $phone = ($_POST['phone'])? $_POST['phone']:0; 
        
        $fields = array();
        $fields['lead_id'] = $_POST['lead_id'];
        $fields['company_name'] = escapeString($_POST['company_name']);
        $fields['contact_person'] = escapeString($_POST['name']);
        $fields['stage'] = escapeString($_POST['stage']);
        $fields['lead_source'] = escapeString($_POST['source']);
        $fields['call_status'] = escapeString($_POST['call_status']);
        $fields['email_address'] = $_POST['emailAddress'];
        //$fields['phone'] = $phone;
        $fields['website'] = escapeString($_POST['website']);
        $fields['address_street'] = escapeString($_POST['addressStreet']);
        $fields['address_city'] = escapeString($_POST['addressCity']);
        $fields['address_state'] = escapeString($_POST['addressState']);
        $fields['address_country'] = escapeString($_POST['addressCountry']);
        $fields['address_postal_code'] = escapeString($_POST['addressPostalCode']);
        $fields['assigned_user_id'] = $_POST['assignedUserId'];
        $fields['modified_by_id'] = getSessionValue('user');
        $fields['modified_at'] = getFormattedDate();
        $fields['description'] = escapeString($_POST['description']);
        $prevStage = getSessionValue('opportunity_stage');
        
        try {
            $where = array ("id" => $_POST['opportunity_id']);
            // Updating the opportunity details
            updateOpportunityDetails($fields, $where);
            
            // adding entry into the history table If stage is changed
            if ($_POST['stage'] != $prevStage) {
                $data = array();
                $data['entity_id'] = $_POST['opportunity_id'];
                $data['user_id'] = getSessionValue('user');
                $data['change_param'] = $_POST['stage'];
                $data['changeType'] = 'Stage';
                $data['action_date'] = getFormattedDate();
                $data['entity_type'] = 'Opportunity';
                // add entry in the history table.
                addHistory($data);

                if ($_POST['stage'] == 2 || $_POST['stage'] == 3) {
                    // get the total count according to the users efforts
                    $effortDate = getFormattedDate(NULL, "Y-m-d");
                    $effortsCount = getUsersEffortsCount(getSessionValue('user'), $effortDate, $_POST['stage'], 'Opportunity');

                    // updating the users efforts according to the user id 
                    $updateData = array();
                    if ($_POST['stage'] == 2)
                        $updateData['appointments_count'] = $effortsCount;

                    if ($_POST['stage'] == 3)
                        $updateData['specs_count'] = $effortsCount;

                    $where = array('id' => getSessionValue('effortId'));
                    updateUsersEfforts($updateData, $where);
                }
            }
             // add entry in history table if call status is changed
            if (getSessionValue('opportunity_call_status') != $_POST['call_status']) {
                $data = array();
                $data['entity_id'] = $_POST['opportunity_id'];
                $data['user_id'] = getSessionValue('user');
                $data['change_param'] = $_POST['call_status'];
                $data['changeType'] = 'Call Status';
                $data['action_date'] = getFormattedDate();
                $data['entity_type'] = 'Opportunity';
                // add entry in the history table.
                addHistory($data);
            }
            // add entry in history table if assigned user is changed
            if (getSessionValue('opportunity_assigned_user') != $_POST['assignedUserId']) {
            	$data = array();
            	$data['entity_id'] = $_POST['opportunity_id'];
            	$data['user_id'] = getSessionValue('user');
            	$data['change_param'] = $_POST['assignedUserId'];
            	$data['changeType'] = 'Assign';
            	$data['action_date'] = getFormattedDate();
            	$data['entity_type'] = 'Opportunity';
            	// add entry in the history table. 
            	addHistory($data);
            }
            
            // If teams are selected then those teams will be added in different table
            // team-leads.
            $teamIds = ($_POST['teamsIds'])? explode(",", $_POST['teamsIds']):0;
            if ($teamIds !== 0) {
                updateTeam($teamIds,$_POST['opportunity_id'], 'Opportunity');
            }
            
            //Update Phones
            $phones = array();
            if ($phone !== 0) {
                $phones = explode(',', $phone);
            }
            if (isset($_POST['phoneVal']) && $_POST['phoneVal'] != '' && !in_array($_POST['phoneVal'], $phones)) {
                $phones[] = escapeString($_POST['phoneVal']);
            }
            addOpportunityPhones($_POST['opportunity_id'], $phones);
            
            // redirecting user to view page.
            redirect('modules/opportunities/view.php?id='.$_POST['opportunity_id']);            
        } catch (Exception $exc) {
            setSessionValue('errorMessage', $exc->getMessage());
            // redirecting user to view page.
            redirect('modules/opportunities/edit.php?id='.$_POST['opportunity_id']);            
        }
    }    
}