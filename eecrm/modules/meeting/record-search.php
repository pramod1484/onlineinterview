<?php
/**
 * File to search record against the search query
 * 
 */
require_once dirname(__DIR__)."/../../include_locations.php";
require_once dirname(__DIR__)."/../include/database.php";
require_once dirname(__DIR__)."/../include/define.php";
require_once dirname(__DIR__)."/../include/utils-helpers.php";
require_once dirname(__DIR__)."/../include/utils-opportunities.php";

if (!empty($_POST)) {
    global $db;
    $response = array();
    $response['valid'] = 0;
 
    $modules = $_POST['module'];
    $search  = escapeString($_POST['search']);
    $opportunities = getAllOpportunities(0,10,$search);

    if ($opportunities !== NULL) {
        foreach ($opportunities as $opportunity) {
        $string .= '<tr data-id="'.$opportunity['id'].'" class="search-res">
                         <td class="cell cell-checkbox">
                             <input type="checkbox" data-id="'.$opportunity['id'].'" class="record-checkbox records-multiaction">
                         </td>	
                         <td class="cell cell-name">
                                <a title='.sanitizeString($opportunity['company_name']).' data-id="'.$opportunity['id'].'" class="link" href="'.BASEPATH.'modules/opportunities/view.php?id="'.$opportunity['id'].'">'.sanitizeString($opportunity['company_name']).'</a>
                         </td>	
                         <td class="cell cell-status">
                                <span class="text-default">'.sanitizeString($opportunity['stage_name']).'</span>
                         </td>	
                         <td class="cell cell-emailAddress">
                                <a data-action="mailTo" data-email-address="'.$opportunity['email_address'].'" href="javascript:">'.$opportunity['email_address'].'</a>
                         </td>	
                         <td class="cell cell-assignedUser">
                                '.sanitizeString($opportunity['firstName']). " ".sanitizeString($opportunity['lastName']).'
                         </td>	
                         <td class="cell cell-createdAt">
                                '.getFormattedDate($opportunity['created_at'],"m/d/Y h:i").'
                         </td>	
                         <td width="7%" class="cell cell-buttons">
                                <div class="list-row-buttons btn-group pull-right">
                                    <button data-toggle="dropdown" class="btn btn-link btn-sm dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a data-id="'.$opportunity['id'].'" data-action="quickEdit" class="action" href="'.BASEPATH.'modules/opportunities/edit.php?id='.$opportunity['id'].'">Edit</a></li>
                                        <li><a data-id="'.$opportunity['id'].'" data-action="quickRemove" class="action" href="javascript:">Remove</a></li>	
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