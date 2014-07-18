<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-leads.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-history.php';
if (!empty($_GET['id'])) {
    try {
        $leadDetails = getLeadDetails($_GET['id']);
        $leadTeams = getTeamNames($_GET['id'],'Lead');
        if (count($leadTeams) > 0) {
            $teamNames  = implode(",", array_map(function($arr){ return '<a href="'.ADMINPATH.'modules/teams/view.php?id='.$arr['team_id'].'">'.$arr['teamName'].'</a>';}, $leadTeams));
        }
        
        $leadPhones = getLeadPhones($_GET['id']);
        if (count($leadPhones) > 0) {
            $phones = implode(",", array_map(function($arr) { return '<a href="javascript:void(0);" class="makeacall" data-action="Lead" data-id="' . $_GET['id'] . '">'.$arr['phone'].'</a>'; }, $leadPhones));
        }
        
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
    }
    
    if ($leadDetails['status'] == 7) {
        setSessionValue('errorMessage', 'Lead is converted');
        redirect('modules/leads/');
        exit;
    }
}

$errorMessage = getSessionValue('errorMessage');
if ($errorMessage == '') {
    $errorDisplay = 'display: none;';
} else {
    $errorDisplay = '';
    removeSessionValue('errorMessage');
}
?>
<div  style="position: fixed; top: 0px; z-index: 2000; left: 640px; <?php echo $errorDisplay; ?>" class="alert alert-danger notification" id="notification">
    <?php echo $errorMessage; ?>   
</div>
<div class="alert alert-success" style="position: fixed; top: 0px; z-index: 2000; left: 640px; display: none;" id="successMessage">
    
</div>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo BASEPATH;?>modules/leads/">Leads</a> &raquo; <?php echo sanitizeString($leadDetails['first_name']). " ". sanitizeString($leadDetails['last_name']);?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
<!--                        <button class="btn btn-default action btn-success" data-action="unfollow">Followed</button>-->
                        <?php if ($leadDetails['assigned_user_id'] == getSessionValue('user') || getSessionValue('user') == 1) : ?>
                        <button data-action="convert" class="btn btn-default action" type="button" onclick="convertLead(<?php echo $leadDetails['id'];?>)">
                            Convert
                        </button>
                            <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div id="lead-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo BASEPATH;?>modules/leads/edit.php?id=<?php echo $leadDetails['id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a class="btn btn-danger delete-record" data-action="delete" data-value="<?php echo $leadDetails['id']; ?>" data-field="id" data-isadmin="0" data-module="leads">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div style="height: 21px; display: none;">&nbsp;</div>
                <div class="row">
                    <div class=" col-md-8">
                        <div class="record">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-name  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="name" data-field-type="" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">
                                                Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo sanitizeString($leadDetails['salutation_name']) . " " . sanitizeString($leadDetails['first_name']). " ". sanitizeString($leadDetails['last_name']); ?>
                                            </div>
                                        </div>
                                        <div class="cell cell-accountName  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="account_name" data-field-type="text" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-accountName control-label">
                                                Company Name
                                            </label>
                                            <div class="field field-accountName">
                                                <?php echo ucfirst(sanitizeString($leadDetails['account_name']));?>
                                            </div>
                                        </div>


                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-emailAddress  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="email_address" data-field-type="text" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-emailAddress control-label">
                                                Email
                                            </label>
                                            <div class="field field-emailAddress">
                                                <a data-action="mailTo" data-email-address="<?php echo $leadDetails['email_address'];?>" href="javascript:"><?php echo $leadDetails['email_address'];?></a>
                                            </div>
                                        </div>
                                        
                                        <div class="cell cell-website  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="website" data-field-type="text" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-website control-label">
                                                Website
                                            </label>
                                            <div class="field field-website">
                                                <a href="<?php echo $leadDetails['website'];?>"><?php echo $leadDetails['website'];?></a>
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-title  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="title" data-field-type="text" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-title control-label">
                                                Title
                                            </label>
                                            <div class="field field-title">
                                                <?php echo sanitizeString($leadDetails['title']) ;?>
                                            </div>
                                        </div>

                                        <div class="cell cell-doNotCall  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="do_not_call" data-field-type="enable" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-doNotCall control-label">
                                                Do Not Call
                                            </label>
                                            <div class="field field-doNotCall">
                                                <input data-field="do_not_call" data-check="1" data-uncheck="0" type="checkbox" <?php if($leadDetails['do_not_call']): ?> checked="checked" <?php endif;?> disabled="disabled" />
                                            </div>
                                            <input type="hidden" class="updateField" name="do_not_call" id="do_not_call" value="<?php echo ($leadDetails['do_not_call']) ? '1' : '0'; ?>">
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-address  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="address" data-field-type="" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-address control-label">
                                                Address
                                            </label>
                                            <div class="field field-address">
                                                <?php echo sanitizeString($leadDetails['address_street']);?>  <br/> 
                                                <?php echo sanitizeString($leadDetails['address_city']);?>, 
                                                <?php echo sanitizeString($leadDetails['address_state']);?>  <?php echo sanitizeString($leadDetails['address_postal_code']);?><br/> 
                                                <?php echo sanitizeString($leadDetails['address_country']);?>
                                            </div>
                                        </div>
                                        
                                        <div class="cell cell-phone  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="phone" data-field-type="phone" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-phone control-label">
                                                Phone
                                            </label>
                                            <div class="field field-phone" id="generateCall">
                                                <?php echo isset($phones) ? $phones : ''; ?>
                                            </div>
                                            <input type="hidden" class="updateField" name="phone" id="phoneCount" value="<?php echo isset($phones) ? strip_tags($phones) : ''; ?>">
                                        </div>
                                        
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-description  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="description" data-field-type="textarea" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-description control-label">
                                                Description
                                            </label>
                                            <div class="field field-description">
                                                <?php echo sanitizeString($leadDetails['description']);?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6"></div>			
                                    </div>			
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Details</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-status  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="status" data-field-type="" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-status control-label">
                                                Status
                                            </label>
                                            <div class="field field-status">
                                                <span class="text-default"><?php echo sanitizeString($leadDetails['status_name']);?></span>
                                            </div>
                                        </div>

                                        <div class="cell cell-source  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="source" data-field-type="" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-source control-label">
                                                Source
                                            </label>
                                            <div class="field field-source">
                                                <?php echo sanitizeString($leadDetails['source_name']);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="cell cell-status  col-sm-6  form-group">
                                            <a class="pull-right inline-edit-link hide" data-field="call_status" data-field-type="" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-status control-label">
                                                Call Status
                                            </label>
                                            <div class="field field-status">
                                                <span class="text-default"><?php echo sanitizeString($leadDetails['call_status_name']);?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="extra"></div>
                        <div class="bottom">
                            <div class="panel panel-default panel-stream">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Stream</h4>
                                </div>
                                <div class="panel-body panel-body-stream">
                                    <div class="form-group">
                                        <textarea class="note form-control" rows="1" cols="10" placeholder="Write your comment here"></textarea>
                                        <div class="buttons-panel margin hide floated-row clearfix">
                                            <div>
                                                <button class="btn btn-primary post">Post</button>
                                            </div>
                                            <div class="attachments-container">
                                                <div class="">
                                                    <div>
                                                        <label style="overflow: hidden; width: 50px; cursor: pointer;">
                                                            <span class="btn btn-default" style="cursor: pointer;"><span class="glyphicon glyphicon-paperclip"></span></span>
                                                            <input type="file" id="fileupload" name="files[]" class="file pull-right" multiple="" style="opacity: 0; width: 1px;">
                                                        </label>
                                                    </div>
                                                    <div class="attachments"></div>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>

                                    <div class="list-container">


                                        <!-- Stream Data will be here -->
                                    
                                    </div>
                                    

                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="side col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-default">
                                <div class="row">
                                    <div class="cell cell-assignedUser form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" data-field="assignedUser" data-field-type="replaceHtml" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-assignedUser">Assigned User</label>
                                        <div class="field field-assignedUser">
                                            <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $leadDetails['assigned_user_id']; ?>">
                                                <?php echo sanitizeString($leadDetails['firstName'])." ".sanitizeString($leadDetails['lastName']); ?>
                                             </a>
                                        </div>
                                        <div class="replaceHtml" style="display: none;">
                                            <div class="input-group">
                                                <input type="text" autocomplete="off" value="<?php echo $leadDetails['firstName'] ." ".$leadDetails['lastName'];?>" name="assignedUserName" id="assignedUserName" class="main-element form-control">
                                                <span class="input-group-btn">        
                                                    <button tabindex="-1" type="button" class="btn btn-default selectuser" data-action="singleuser" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                    <button tabindex="-1" type="button" class="btn btn-default user-clear" data-action="singleuser"><i class="glyphicon glyphicon-remove"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $leadDetails['assigned_user_id']; ?>" name="assignedUserId" class="updateField" id="assignedUserId">
                                    </div>

                                    <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" data-field="assignedTeams" data-field-type="replaceHtml" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <?php if ($teamNames != ''): echo $teamNames; else: ?> None <?php endif; ?>
                                        </div>
                                        <div class="replaceHtml" style="display: none;">
                                            <div class="link-container list-group team-group">
                                                    <?php if (count($leadTeams) > 0): 
                                                              foreach ($leadTeams as $leadTeam) : ?>
                                                                <div class="link-team-<?php echo $leadTeam['team_id'];?> list-group-item">
                                                                    <?php echo sanitizeString($leadTeam['teamName']);?>
                                                                    <a href="javascript:" class="team-clearLink pull-right" data-id="<?php echo $leadTeam['team_id'];?>">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </a>
                                                                </div>
                                                    <?php endforeach; 
                                                    endif; ?>
                                            </div>
                                            <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectteam" data-action="selectLink" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="ids updateField" value="<?php echo implode(",", array_map(function($arr){ return $arr['team_id'];}, $leadTeams));?>" name="teamsIds" id="teamsIds">
                                    </div>
                                </div>	


                                <div class="row">
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Created</label>
                                        <div class="field">
                                            <span class="field-createdAt"><?php  echo getFormattedDate($leadDetails['created_at'],"m/d/Y H:i"); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $leadDetails['created_by_id'];?>"><?php echo sanitizeString($leadDetails['createdFirstName']) ." ". sanitizeString($leadDetails['createdLastName']); ;?></a>
                                            </span>		
                                        </div>
                                    </div>
                                    <?php if ($leadDetails['modified_at'] != NULL):?>
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Modified</label>
                                        <div class="field" id="modifiedAt">
                                            <span class="field-createdAt"><?php echo getFormattedDate($leadDetails['modified_at'],"m/d/Y H:i"); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $leadDetails['modified_by_id'];?>"><?php echo sanitizeString($leadDetails['modifiedFirstName']) ." ". sanitizeString($leadDetails['modifiedLastName']); ;?></a>
                                            </span>		
                                        </div>
                                    </div>                                    
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="pull-right btn-group">

                                    <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li><a data-status="Planned" data-link="meetings" data-action="createActivity" data-panel="activities" class="action" href="javascript:">Schedule Meeting</a></li>

                                        <li><a data-status="Planned" data-link="calls" data-action="createActivity" data-panel="activities" class="action" href="javascript:">Schedule Call</a></li>

                                        <li><a data-action="composeEmail" data-panel="activities" class="action" href="javascript:">Compose Email</a></li>

                                    </ul>

                                </div>
                                <h4 class="panel-title">Activities</h4>
                            </div>

                            <div class="panel-body panel-body-activities">
                                <div class="btn-group button-container">
                                    <button data-scope="" class="btn btn-default all active scope-switcher">All</button>

                                    <button data-scope="Meeting" class="btn btn-default all scope-switcher">Meetings</button>

                                    <button data-scope="Call" class="btn btn-default all scope-switcher">Calls</button>

                                </div>

                                <div class="list-container">
                                    No Data

                                </div>


                            </div>
                        </div>

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="pull-right btn-group">

                                    <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li><a data-status="Held" data-link="meetings" data-action="createActivity" data-panel="history" class="action" href="javascript:">Log Meeting</a></li>

                                        <li><a data-status="Held" data-link="calls" data-action="createActivity" data-panel="history" class="action" href="javascript:">Log Call</a></li>

                                        <li><a data-action="archiveEmail" data-panel="history" class="action" href="javascript:">Archive Email</a></li>

                                    </ul>

                                </div>
                                <h4 class="panel-title">History</h4>
                            </div>

                            <div class="panel-body panel-body-history">
                                <div class="btn-group button-container">
                                    <button data-scope="" class="btn btn-default all scope-switcher">All</button>
                                    <button data-scope="Meeting" class="btn btn-default all active scope-switcher">Meetings</button>
                                    <button data-scope="Call" class="btn btn-default all scope-switcher">Calls</button>
                                    <button data-scope="Email" class="btn btn-default all scope-switcher">Emails</button>
                                </div>
                                <div class="list-container">
                                    No Data
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right btn-group">

                                    <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li><a data-action="createTask" data-panel="tasks" class="action" href="javascript:">Create Task</a></li>

                                    </ul>

                                </div>
                                <h4 class="panel-title">Tasks</h4>
                            </div>

                            <div class="panel-body panel-body-tasks">
                                <div class="btn-group button-container">

                                    <button data-tab="Active" class="btn btn-default all active tab-switcher">Active</button>

                                    <button data-tab="Inactive" class="btn btn-default all tab-switcher">Inactive</button>

                                </div>

                                <div class="list-container">
                                    No Data

                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>
        <div class="bottom"></div>
    </div>
</div>

<!-- to create and open modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="userModalLable" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        
    </div>
  </div>
</div>

<input type="hidden" name="moduleDetail" id="moduleDetail" data-module="leads" data-id="<?php echo $_GET['id'] ?>">
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectuser.js"></script>        
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectteams.js"></script>
<script src="<?php echo BASEPATH?>js/modules/leads/view.js"></script>
<script src="<?php echo BASEPATH?>js/modules/inlineEdit.js"></script>
<script src="<?php echo BASEPATH; ?>js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo BASEPATH; ?>js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo BASEPATH; ?>js/jquery.fileupload.js"></script>
<?php
require_once dirname(__DIR__) . '/../common/footer.php';
?>