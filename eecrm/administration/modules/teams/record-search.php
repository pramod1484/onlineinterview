<?php
/**
 * File to search record against the search query
 * 
 */
require_once dirname(__DIR__)."/../../include/database.php";
require_once dirname(__DIR__)."/../../include/define.php";
require_once dirname(__DIR__)."/../../include/utils-helpers.php";
require_once dirname(__DIR__)."/../../include/utils-teams.php";

if (!empty($_POST)) {
    global $db;
    $response = array();
    $response['valid'] = 0;
    
    $modules = $_POST['module'];
    $search  = escapeString($_POST['search']);
    $teams = getAllTeams(0,10,$search);
    
    if ($teams !== NULL) {
        foreach ($teams as $team) {
        $string .= '<tr class="search-res" data-id="'.$team['id'].'">
                        <td class="cell cell-checkbox">
                            <input type="checkbox" class="record-checkbox records-multiaction" data-id="'.$team['id'].'">
                        </td>	
                        <td class="cell cell-name">
                            <a href="'.ADMINPATH.'/modules/teams/view.php?id=1" class="link" data-id="'.$team['id'].'" title="'.sanitizeString($team['name']).'">
                                '.sanitizeString($team['name']).'
                            </a>
                        </td>	
                        <td width="7%" class="cell cell-buttons">
                            <div class="list-row-buttons btn-group pull-right">
                                <button type="button" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                 </button>
                                 <ul class="dropdown-menu pull-right">
                                    <li><a href="'.ADMINPATH.'/modules/teams/edit.php?id='.$team['id'].'" class="action" data-action="quickEdit" data-id="'.$team['id'].'">Edit</a></li>
                            </div>
                        </td>                                      
                        </tr>';                                
        }
        
        $response['valid'] = 1;
    }  else {
            $string .= '<tr data-id="'.$team['id'].'" class="search-res">
                        <td class="cell" colspan="3"> No Data </td>	
                     </tr>';        
    }
    
    $response['str'] = $string;
    @header("Content-type: text/json");
    $jsonResponse = json_encode($response);
    echo $jsonResponse;    
    exit;
}