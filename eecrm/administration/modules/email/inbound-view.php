<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-mail.php';
if (!empty($_GET['id'])) {
    try {
        $inboundDetails = getInboundDetails($_GET['id']);
    } catch (Exception $e) {
        setSessionValue('errorMessage', $e->getMessage());
    }
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') : ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php 
    removeSessionValue('errorMessage'); 
endif;
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <h3><a href="<?php echo ADMINPATH; ?>modules/email/inbound.php">Inbound Emails</a> &raquo; <?php echo sanitizeString($inboundDetails['name']); ?></h3>
        </div>
        
        <div class="body"><div class="detail" id="inbound-email-detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH; ?>modules/email/inbound-edit.php?id=<?php echo $inboundDetails['id']; ?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a class="btn btn-danger delete-record" data-action="delete" data-value="<?php echo $inboundDetails['id']; ?>" data-field="id" data-isadmin="1" data-module="email_inbound">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div class="detail-button-container button-container edit-buttons hidden" style="display: block;">
                    <button class="btn btn-primary" data-action="save" type="button">Save</button>
                    <button class="btn btn-default" data-action="cancelEdit" type="button">Cancel</button>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div class="row">
                    <div class=" col-md-8">
                        <div class="record">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Main</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-name  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">
                                                Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo sanitizeString($inboundDetails['name']); ?>
                                            </div>
                                        </div>
                                        <div class="cell cell-status  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-status control-label">
                                                Status
                                            </label>
                                            <div class="field field-status">
                                                <?php echo $inboundDetails['status']; ?>
                                            </div>
                                        </div>
                                    </div>			
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">IMAP</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-host  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-host control-label">
                                                Host
                                            </label>
                                            <div class="field field-host">
                                                <?php echo sanitizeString($inboundDetails['host']); ?>
                                            </div>
                                        </div>
                                        <div class="cell cell-username  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-username control-label">
                                                Username
                                            </label>
                                            <div class="field field-username">
                                                <?php echo sanitizeString($inboundDetails['username']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-port  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-port control-label">
                                                Port
                                            </label>
                                            <div class="field field-port">
                                                <?php echo sanitizeString($inboundDetails['port']); ?>
                                            </div>
                                        </div>
                                        <div class="cell cell-password  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-password control-label">
                                                Password
                                            </label>
                                            <div class="field field-password">
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-monitoredFolders  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-monitoredFolders control-label">
                                                Monitored Folders
                                            </label>
                                            <div class="field field-monitoredFolders">
                                                <?php echo sanitizeString($inboundDetails['monitored_folders']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-trashFolder  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-trashFolder control-label">
                                                Trash Folder
                                            </label>
                                            <div class="field field-trashFolder">
                                                <?php echo sanitizeString($inboundDetails['trash_folder']); ?>
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
                                    <div class="cell cell-assignedUser form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" data-field="assignedUser" data-field-type="replaceHtml" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-assignedUser">Assigned User</label>
                                        <div class="field field-assignedUser">
                                            <a href="<?php echo ADMINPATH; ?>modules/users/view.php?id=<?php echo $inboundDetails['assigned_user_id']; ?>">
                                                <?php echo sanitizeString($inboundDetails['assignedUser']); ?>
                                            </a>
                                        </div>
                                        
                                        <input type="hidden" value="<?php echo $inboundDetails['assigned_user_id']; ?>" name="assignedUserId" class="updateField" id="assignedUserId">
                                    </div>

                                    <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" data-field="assignedTeams" data-field-type="replaceHtml" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <a href="<?php echo ADMINPATH; ?>modules/teams/view.php?id=<?php echo $inboundDetails['team_id']; ?>">
                                                <?php echo sanitizeString($inboundDetails['teamName']); ?>
                                            </a>                                        </div>
                                        <input type="hidden" class="ids updateField" value="<?php echo $inboundDetails['team_id']; ?>" name="teamIds" id="teamsIds">
                                    </div>
                                </div>	
                                <div class="row">
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Created</label>
                                        <div class="field">
                                            <span class="field-createdAt"><?php echo getFormattedDate($inboundDetails['created_at'], 'm/d/Y H:i'); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH; ?>modules/users/view.php?id=<?php echo $inboundDetails['created_by_id']; ?>"><?php echo sanitizeString($inboundDetails['createdUser']); ?></a>
                                            </span>		
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- to create and open modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="userModalLable" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/modules/selectList.js"></script>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
