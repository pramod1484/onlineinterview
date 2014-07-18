<?php
/**
 * File to search record against the search query
 * 
 */

require_once dirname(__DIR__)."/../include-locations.php";
require_once dirname(__DIR__)."/../include/database.php";
require_once dirname(__DIR__)."/../include/define.php";
require_once dirname(__DIR__)."/../include/utils-helpers.php";
require_once dirname(__DIR__)."/../include/utils-leads.php";

if (!empty($_POST)) {
    global $db;
    $response = array();
    $response['valid'] = 0;
 
    $modules = $_POST['module'];
    $search  = escapeString($_POST['search']);
    $ownFlag = $_POST['mine'];
    if ($ownFlag == 'true') $user = getSessionValue ('user');
    $leads = getAllLeads(0,10,$user,$search);

    if ($leads !== NULL) {
        foreach ($leads as $lead) {
            $className = 'text-default';
            if ($lead['status'] == 7) {
                $className .= ' text-success';
            }
        $string .= '<tr data-id="'.$lead['id'].'" class="search-res">
                            <td class="cell cell-checkbox">
                                <input type="checkbox" class="record-checkbox records-multiaction" data-id="'.$lead['id'].'">
                            </td>	
                            <td class="cell cell-name">
                                <a href="'.BASEPATH.'modules/leads/view.php?id='.$lead['id'].'" class="link" data-id="'.$lead['id'].'" title="'.sanitizeString($lead['first_name']). " ".sanitizeString($lead['last_name']).'">'.sanitizeString($lead['first_name']). " ".sanitizeString($lead['last_name']).'</a>
                            </td>	
                            <td class="cell cell-status">
                                <span class="'.$className.'">'.sanitizeString($lead['status_name']).'</span>
                            </td>	
                            <td class="cell cell-emailAddress">
                                <a href="javascript:" data-email-address="'.$lead['email_address'].'" data-action="mailTo">'.$lead['email_address'].'</a>
                            </td>	
                            <td class="cell cell-assignedUser">
                                <a href="'.BASEPATH.'/modules/leads/view/'.$lead['id'].'">
                                    '.sanitizeString($lead['firstName']). " ".sanitizeString($lead['lastName']).'
                                </a>
                            </td>	
                            <td class="cell cell-createdAt">
                                '.  getFormattedDate($lead['created_at'],"m/d/Y h:i").'
                            </td>	
                            <td width="7%" class="cell cell-buttons">
                                <div class="list-row-buttons btn-group pull-right">
                                    <button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="'.BASEPATH.'modules/leads/edit.php?id='.$lead['id'].'" class="action" data-action="quickEdit" data-id="'.$lead['id'].'">Edit</a></li>
                                    </ul>
                                </div>
                            </td>	
                        </tr>';                                
        }
        
        $response['valid'] = 1;
    }  else {
            $string .= '<tr class="search-res">
                        <td class="cell" colspan="3"> No Data </td>	
                     </tr>';        
    }
    
    $response['str'] = $string;
    @header("Content-type: text/json");
    $jsonResponse = json_encode($response);
    echo $jsonResponse;    
    exit;
}