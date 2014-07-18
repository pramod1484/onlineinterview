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
require_once $include_directory . 'utils-entity-teams.php';

global $db;

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array(
            'name' => array('required' => true),
            'assignToUserId' => array('required' => true)
        ),
        'messages' => array(
            'name' => array('required' => 'Name is required'),
            'assignToUserId' => array('required' => 'Assign User is required')
        ),
    );

    $response = Validation::_initialize($array, $_POST);

    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/email/template-create.php');
    } else {
        $fields = array();
        $fields['name'] = escapeString($_POST['name']);
        $fields['subject'] = escapeString($_POST['subject']);
        $fields['body'] = escapeString($_POST['body']);
        $fields['assigned_user_id'] = escapeString($_POST['assignToUserId']); 
        $fields['created_at'] = $fields['modified_at'] = getFormattedDate();
        $fields['modified_by_id'] = $fields['created_by_id'] = getSessionValue('user');
        
        $fields['is_html'] = (isset($_POST['isHtml'])) ? 1 : 0;
        
        try {
            $tempId = addMailDetails('email_template', $fields);
            
            if (isset($_POST['fileIds']) && $_POST['fileIds'] != '') {
                 $files = explode(',', $_POST['fileIds']);
                 foreach ($files as $file) {
                    if ($file != '') {
                        $sql = "UPDATE `attachment` SET savedName = '" . md5($file) . "',
                                created_by_id = " . getSessionValue('user') . ",
                                parent_id = '$tempId', parent_type = 'template'
                                WHERE id = :file";
                        $statement = $db->prepare($sql);
                        $statement->bindValue(":file", $file);
                        $statement->execute();
                    }
                }
                
            }
            // team-templates
            $teamIds = ($_POST['teamsIds'])? explode(",", $_POST['teamsIds']):0;
            if ($teamIds !== 0) {
                addTeams($teamIds, $tempId, 'Template');
            }
            
            // redirecting user to view page.
            redirect('administration/modules/email/template-view.php?id=' . $tempId);
        } catch (Exception $e) {
            setSessionValue('errorMessage', $e->getMessage());
            redirect('administration/modules/email/template-create.php');
        } 
        
    }
}
?>
