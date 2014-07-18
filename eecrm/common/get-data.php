<?php
/**
 * This file will execute by the ajax call and user will recieve the HTML data 
 * which content the list of all data for selection of respective data.
 * 
 */
require_once dirname(__DIR__).'/include-locations.php';
require_once $include_directory . 'define.php';
require_once dirname(__DIR__)."/include/database.php";
require_once dirname(__DIR__)."/include/utils-helpers.php";

global $db;
$response = array();
$response['valid'] = 0;

if (isset($_POST['forData']) && $_POST['forData'] != ''):
    
    switch ($_POST['forData']) {
    case 'users': 
        require_once dirname(__DIR__)."/include/utils-users.php";
        $data = getUsersForAssigningMultiple();
        $title = 'Users';
        break;
    case 'leads':
        require_once dirname(__DIR__)."/include/utils-leads.php";
        $data = getLeadsForAssigning();
        $title = 'Leads';
        break;
    case 'opportunity':
        require_once dirname(__DIR__)."/include/utils-opportunities.php";
        $data = getOpportunityForAssigning();
        $title = 'Opportunities';
        break;
    case 'team':
        require_once dirname(__DIR__)."/include/utils-teams.php";
        $data = getTeamsForAssigning();
        $title = 'Teams';
        break;
    case 'roles':
        require_once dirname(__DIR__)."/include/utils-roles.php";
        $data = getRolesForAssigning();
        $title = 'Roles';
        break;
    }

    if (isset($data) && $data !== NULL) :
?>
<div class="modal-header">
    <h4 class="modal-title" id="userModalLable"><?php echo $title ?></h4>
</div>
<div class="modal-body">
<div class="list-container">
    <div class="list">
        <table class="table">
            <thead>
                <tr>
                    <th width="30%">Name</th>
                </tr>
            </thead>
            <tbody>
<?php
    
    if ($data !== NULL) {
        foreach ($data as $info) { ?>
            <tr data-id="<?php echo $info['id']; ?>">
                <td class="cell cell-name">
                    <a title="<?php echo ucfirst(sanitizeString($info['title'])); ?>" data-id="<?php echo $info['id']; ?>" class="link selectDataValue" href="javascript:;"><?php echo ucfirst(sanitizeString($info['title'])); ?></a>
                </td>	
            </tr>            
<?php   }
    }
?>
            </tbody>
        </table>
        <?php if (count($data) > MAX_ROWS): ?>
        <div class="show-more hide">
            <a data-action="showMore" class="btn btn-default btn-block" href="javascript:" type="button">Show more</a>
        </div>
        <?php endif; ?>
    </div> 
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>
<?php
    endif;  //$data
    
endif;  //$_POST
?>