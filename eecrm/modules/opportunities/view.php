<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-opportunities.php';
require_once $include_directory . 'utils-entity-teams.php';
require_once $include_directory . 'utils-history.php';
if (!empty($_GET['id'])) {
    try {
        $oppotunityDetails = getOpportunityDetails($_GET['id']);
        $teams = getTeamNames($_GET['id'],'Opportunity');
        if (count($teams) > 0) {
            $teamNames  = implode(",", array_map(function($arr){ return '<a href="'.ADMINPATH.'modules/teams/view.php?id='.$arr['team_id'].'">'.$arr['teamName'].'</a>';},$teams));
        }
        
        $oppPhones = getOpportunityPhones($_GET['id']);
        if (count($oppPhones) > 0) {
            $phones = implode(",", array_map(function($arr) { return '<a href="javascript:void(0);" class="makeacall" data-action="Opportunity" data-id="' . $_GET['id'] . '">'.$arr['phone'].'</a>'; }, $oppPhones));
        }
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
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

<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo BASEPATH;?>modules/opportunities/">Opportunities</a> &raquo; <?php echo sanitizeString($oppotunityDetails['contact_person']);?></h3>
                </div>
            </div>
        </div>
        <div class="body">
            <div id="lead-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo BASEPATH;?>modules/opportunities/edit.php?id=<?php echo $oppotunityDetails['id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a class="btn btn-danger delete-record" data-action="delete" data-value="<?php echo $oppotunityDetails['id']; ?>" data-field="id" data-isadmin="0" data-module="leads">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div style="height: 21px; display: none;">&nbsp;</div>
                <div class="row">
                    <div class=" col-md-8">
                        <div class="record">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-accountName  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="company_name" data-field-type="text"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-accountName control-label">
                                                Company Name
                                            </label>
                                            <div class="field field-accountName">
                                                <?php echo ucfirst(sanitizeString($oppotunityDetails['company_name']));?>
                                            </div>
                                        </div>
                                        <div class="cell cell-name  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="contact_person" data-field-type="text"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">
                                                Contact Person
                                            </label>
                                            <div class="field field-name">
                                                <?php echo sanitizeString($oppotunityDetails['contact_person']);?>
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-emailAddress  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="email_address" data-field-type="text"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-emailAddress control-label">
                                                Email
                                            </label>
                                            <div class="field field-emailAddress">
                                                <a data-action="mailTo" data-email-address="<?php echo $oppotunityDetails['email_address'];?>" href="javascript:"><?php echo $oppotunityDetails['email_address'];?></a>
                                            </div>
                                        </div>
                                        <div class="cell cell-phone  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="phone" data-field-type="phone" ><span class="glyphicon glyphicon-pencil"></span></a>
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
                                        <div class="cell cell-address  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="address" data-field-type=""><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-address control-label">
                                                Address
                                            </label>
                                            <div class="field field-address">
                                                <?php echo sanitizeString($oppotunityDetails['address_street']);?>  <br/> 
                                                <?php echo sanitizeString($oppotunityDetails['address_city']);?>, 
                                                <?php echo sanitizeString($oppotunityDetails['address_state']);?>  <?php echo sanitizeString($oppotunityDetails['address_postal_code']);?><br/> 
                                                <?php echo sanitizeString($oppotunityDetails['address_country']);?>
                                            </div>
                                        </div>



                                        <div class="cell cell-website  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="website" data-field-type="text"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-website control-label">
                                                Website
                                            </label>
                                            <div class="field field-website">
                                                <a href="<?php echo $oppotunityDetails['website'];?>"><?php echo $oppotunityDetails['website'];?></a>
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-description  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="description" data-field-type="textarea"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-description control-label">
                                                Description
                                            </label>
                                            <div class="field field-description">
                                                <?php echo sanitizeString($oppotunityDetails['description']);?>
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
                                        <div class="cell cell-emailAddress  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="stage" data-field-type=""><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-emailAddress control-label">
                                                Stage
                                            </label>
                                            <div class="field field-emailAddress">
                                                <?php echo sanitizeString($oppotunityDetails['stage_name']);?>
                                            </div>
                                        </div>
                                        <div class="cell cell-phone  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:" data-field="lead_source" data-field-type=""><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-phone control-label">
                                                Lead Source
                                            </label>
                                            <div class="field field-phone" id="generateCall">
                                                <?php echo sanitizeString($oppotunityDetails['source_name']);?>
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
                                                <span class="text-default"><?php echo sanitizeString($oppotunityDetails['call_status_name']);?></span>
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
                                    <div class="pull-right btn-group">
                                    </div>
                                    <h4 class="panel-title">Stream</h4>
                                </div>
                                <div class="panel-body panel-body-stream">
                                    <div class="form-group">
                                        <textarea placeholder="Write your comment here" cols="10" rows="1" class="note form-control"></textarea>
                                        <div class="buttons-panel margin hide floated-row clearfix">
                                            <div>
                                                <button class="btn btn-primary post">Post</button>
                                            </div>
                                            <div class="attachments-container"><div class="">
                                                    <div>
                                                        <label style="overflow: hidden; width: 50px; cursor: pointer;">
                                                            <span style="cursor: pointer;" class="btn btn-default"><span class="glyphicon glyphicon-paperclip"></span></span>
                                                            <input type="file" id="fileupload" name="files[]" style="opacity: 0; width: 1px;" multiple="" class="file pull-right">
                                                        </label>
                                                    </div>
                                                    <div class="attachments"></div>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>

                                    <div class="list-container">
                                       
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
                                        <a class="pull-right inline-edit-link hide" href="javascript:" data-field="assignedUser" data-field-type="replaceHtml">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <label class="control-label label-assignedUser">Assigned User</label>
                                        <div class="field field-assignedUser">
                                            <a href="<?php echo ADMINPATH; ?>modules/users/view.php?id=<?php echo $oppotunityDetails['assigned_user_id']; ?>">
                                                <?php echo sanitizeString($oppotunityDetails['firstName']) . " " . sanitizeString($oppotunityDetails['lastName']); ?>
                                            </a>
                                        </div>
                                        <div class="replaceHtml" style="display: none;">
                                            <div class="input-group">
                                                <input type="text" autocomplete="off" value="<?php echo $oppotunityDetails['firstName'] . " " . $oppotunityDetails['lastName']; ?>" name="assignedUserName" id="assignedUserName" class="main-element form-control">
                                                <span class="input-group-btn">        
                                                    <button tabindex="-1" type="button" class="btn btn-default selectuser" data-action="singleuser" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                    <button tabindex="-1" type="button" class="btn btn-default user-clear" data-action="singleuser"><i class="glyphicon glyphicon-remove"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $oppotunityDetails['assigned_user_id']; ?>" name="assignedUserId" class="updateField" id="assignedUserId">
                                    </div>

                                    <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" href="javascript:" data-field="assignedTeams" data-field-type="replaceHtml">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <?php if ($teamNames != ''): echo $teamNames; else: ?> None <?php endif;?>
                                        </div>
                                        <div class="replaceHtml" style="display: none;">
                                            <div class="link-container list-group team-group">
                                                    <?php if (count($teams) > 0): 
                                                              foreach ($teams as $team) : ?>
                                                                <div class="link-team-<?php echo $team['team_id'];?> list-group-item">
                                                                    <?php echo sanitizeString($team['teamName']);?>
                                                                    <a href="javascript:" class="team-clearLink pull-right" data-id="<?php echo $team['team_id'];?>">
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
                                        <input type="hidden" class="ids updateField" value="<?php echo implode(",", array_map(function($arr){ return $arr['team_id'];}, $teams));?>" name="teamsIds" id="teamsIds">
                                    </div>
                                </div>          


                                <div class="row">
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Created</label>
                                        <div class="field">
                                            <span class="field-createdAt"><?php  echo getFormattedDate($oppotunityDetails['created_at'],"m/d/Y H:i"); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $oppotunityDetails['created_by_id'];?>"><?php echo sanitizeString($oppotunityDetails['createdFirstName']) ." ". sanitizeString($oppotunityDetails['createdLastName']); ;?></a>
                                            </span>		
                                        </div>
                                    </div>
                                    <?php if ($oppotunityDetails['modified_at'] != NULL):?>
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Modified</label>
                                        <div class="field" id="modifiedAt">
                                            <span class="field-createdAt"><?php echo getFormattedDate($oppotunityDetails['modified_at'],"m/d/Y H:i"); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $oppotunityDetails['modified_by_id'];?>"><?php echo sanitizeString($oppotunityDetails['modifiedFirstName']) ." ". sanitizeString($oppotunityDetails['modifiedLastName']); ;?></a>
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

<input type="hidden" name="moduleDetail" id="moduleDetail" data-module="opportunities" data-id="<?php echo $_GET['id'] ?>">
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