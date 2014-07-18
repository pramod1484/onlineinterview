<?php
/**
 * File to search record against the search query
 * 
 */
require_once dirname(__DIR__)."/../../include/database.php";
require_once dirname(__DIR__)."/../../include/define.php";
require_once dirname(__DIR__)."/../../include/utils-helpers.php";
require_once dirname(__DIR__)."/../../include/utils-users.php";

if (!empty($_POST)) {
    global $db;
    $response = array();
    $response['valid'] = 0;
    
    $modules = $_POST['module'];
    $search  = escapeString($_POST['search']);
    $users = getAllUsers(0,10,$search);
    
    if ($users !== NULL) {
        foreach ($users as $user) {
        $string .= '<tr data-id="'.$user['id'].'" class="search-res">
                <td class="cell cell-checkbox">
                    <input type="checkbox" data-id="'.$user['id'].'" class="record-checkbox records-multiaction">
                </td>	
                <td class="cell cell-userName">
                    <a title="'.$user['user_name'].'" data-id="'.$user['id'].'" class="link" href="'.ADMINPATH.'modules/users/view.php?id='.$user['id'].'">'.$user['user_name'].'</a>
                </td>	
                <td class="cell cell-name">'.ucfirst($user['first_name']).' '. ucfirst($user['last_name']).'</td>	
                <td class="cell cell-emailAddress">
                    <a data-action="mailTo" data-email-address="'.ucfirst($user['email_address']).'" href="javascript:">'.$user['email_address'].'</a>
                </td>	
                <td width="7%" class="cell cell-buttons">
                    <div class="list-row-buttons btn-group pull-right">
                        <button data-toggle="dropdown" class="btn btn-link btn-sm dropdown-toggle" type="button">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-id="'.$user['id'].'" data-action="quickEdit" class="action" href="'.ADMINPATH.'modules/users/edit.php?id='.$user['id'].'">Edit</a></li>
                         </ul>
                     </div>
                </td>	
            </tr>';                                
        }
        
        $response['valid'] = 1;
    }  else {
            $string .= '<tr data-id="'.$user['id'].'" class="search-res">
                        <td class="cell" colspan="3"> No Data </td>	
                     </tr>';        
    }
    
    $response['str'] = $string;
    @header("Content-type: text/json");
    $jsonResponse = json_encode($response);
    echo $jsonResponse;    
    exit;
}