<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-call.php';
require_once $include_directory . 'utils-entity-teams.php';
if (!empty($_GET['id'])) {
    try {
        $callDetails = getCallDetails($_GET['id']);
        
        //Get Teams
        $teams = getTeamNames($_GET['id'],'Call');
        if (count($teams) > 0) {
            $teamNames  = implode(",", array_map(function($arr){ return '<a href="'.ADMINPATH.'modules/teams/view.php?id='.$arr['team_id'].'">'.$arr['teamName'].'</a>';}, $teams));
        }
        
        //Get Attendees Users
        $users = getCallEntities($_GET['id'], 'User');
        if (count($users) > 0) {
            $callUsers  = implode(", ", array_map(function($arr){ return '<a href="'.ADMINPATH.'modules/users/view.php?id='.$arr['entityId'].'">'.$arr['userName'].'</a>';}, $users));
        }
        
        //Get Attendees Leads
        $leads = getCallEntities($_GET['id'], 'Lead');
        if (count($leads) > 0) {
            $callLeads  = implode(", ", array_map(function($arr){ return '<a href="'. BASEPATH .'modules/leads/view.php?id='.$arr['entityId'].'">'.$arr['leadName'].'</a>';}, $leads));
        }
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
    }
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') {
    ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
    <?php echo $errorMessage; ?>   
    </div>
    <?php removeSessionValue('errorMessage');
} ?>

<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo BASEPATH;?>modules/call/">Calls</a>  &raquo; <?php echo sanitizeString($callDetails['name']);?></h3>
                </div>
            </div>
        </div>
        <div class="body">
            
            <div class="detail" id="call-detail">

                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo BASEPATH;?>modules/call/edit.php?id=<?php echo $callDetails['id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a class="btn btn-danger delete-record" data-action="delete" data-value="<?php echo $callDetails['id']; ?>" data-field="id" data-isadmin="0" data-module="call">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>

                <div class="row">
                    <div class=" col-md-8">
                        <div class="record">

                            <div class="panel panel-default">

                                <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-name  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">Name</label>
                                            <div class="field field-name"><?php echo sanitizeString($callDetails['name']); ?></div>
                                        </div>
                                        
                                        <div class="cell cell-parent  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-parent control-label">Opportunity</label>
                                            <div class="field field-parent">
                                                <?php echo ($callDetails['parent_id']) ? '<a href="' . BASEPATH . 'modules/opportunities/view.php?id=' . $callDetails['oppId'] . '">' . $callDetails['oppName'] . '</a>' : 'None'; ?>
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-status  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-status control-label">Status</label>
                                            <div class="field field-status">
                                                <span class="text-default"><?php echo sanitizeString($callDetails['status']); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="cell cell-direction  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-direction control-label">
                                                Direction
                                            </label>
                                            <div class="field field-direction"><?php echo sanitizeString($callDetails['direction']); ?></div>
                                        </div>
                                        
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-dateStart  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-dateStart control-label">Date Start</label>
                                            <div class="field field-dateStart"><?php echo getFormattedDate($callDetails['date_start'], 'm/d/Y H:i'); ?></div>
                                        </div>
                                        
                                        <div class="cell cell-duration  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
						<label class="field-label-duration control-label">
						Duration
						</label>
                                            <div class="field field-duration"><?php echo getDurationText($callDetails['duration']); ?></div>
					</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="cell cell-description  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-description control-label">
                                                Description
                                            </label>
                                            <div class="field field-description">
                                                <?php echo sanitizeString($callDetails['description']); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6"></div>
                                        
                                    </div>			

                                </div>
                            </div>


                        </div>
                        <div class="extra"></div>
                        <div class="bottom">

                        </div>
                    </div>
                    <div class="side col-md-4">

                        <div class="panel panel-default">

                            <div class="panel-body panel-body-default">
                                <div class="row">
                                    <div class="cell cell-assignedUser form-group col-sm-6 col-md-12"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-assignedUser">Assigned User</label>
                                        <div class="field field-assignedUser">
                                            <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $callDetails['assigned_user_id']; ?>">
                                                <?php echo sanitizeString($callDetails['firstName'])." ".sanitizeString($callDetails['lastName']); ?>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="cell cell-teams form-group col-sm-6 col-md-12"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <?php if ($teamNames != ''): echo $teamNames; else: ?> None <?php endif; ?>
                                        </div>
                                    </div>
                                </div>	


                                <div class="row">
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Created</label>
                                        <div class="field">
                                            <span class="field-createdAt"><?php  echo getFormattedDate($callDetails['created_at'],"m/d/Y H:i"); ?></span> 
                                            by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $callDetails['created_by_id'];?>"><?php echo sanitizeString($callDetails['createdFirstName']) ." ". sanitizeString($callDetails['createdLastName']); ;?></a>
                                            </span>		
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="pull-right btn-group">

                                </div>
                                <h4 class="panel-title">Attendees</h4>
                            </div>

                            <div class="panel-body panel-body-attendees">
                                <div class="row">

                                    <div class="cell cell-users form-group col-sm-6 col-md-12"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-users">Users</label>
                                        <div class="field field-users">
                                            <?php if ($callUsers != ''): echo $callUsers; else: ?> None <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="cell cell-leads form-group col-sm-6 col-md-12"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-leads">Leads</label>
                                        <div class="field field-leads">
                                            <?php if ($callLeads != ''): echo $callLeads; else: ?> None <?php endif; ?>
                                        </div>
                                    </div>

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

<input type="hidden" name="moduleDetail" id="moduleDetail" data-module="call" data-id="<?php echo $_GET['id'] ?>">
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectuser.js"></script>        
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectteams.js"></script>
<!--script src="<?php echo BASEPATH?>js/modules/leads/view.js"></script-->
<!--script src="<?php echo BASEPATH?>js/modules/inlineEdit.js"></script-->
<?php
require_once dirname(__DIR__) . '/../common/footer.php';
?>