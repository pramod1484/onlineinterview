<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-mail.php';

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
            <h3><a href="<?php echo ADMINPATH; ?>modules/email/inbound.php">Inbound Emails</a> &raquo; Create Inbound Email</h3>
        </div>
        <div class="body"><div class="edit" id="settings-edit">
                <form id="form-settings-edit" method="post" action="<?php echo ADMINPATH; ?>modules/email/inbound-new.php">
                <div class="detail-button-container button-container record-buttons">
                    <button class="btn btn-primary" data-action="save" type="submit">Save</button>
                    <a type="button" href="<?php echo ADMINPATH; ?>modules/email/inbound.php" data-action="cancel" class="btn btn-default">Cancel</a>
                </div>
                
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Main</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Name
                                                    *</label>
                                                <div class="field field-name">
                                                    <input type="text" class="main-element form-control" name="name" value="">
                                                </div>
                                            </div>
                                            <div class="cell cell-status  col-sm-6  form-group">
                                                <label class="field-label-status control-label">
                                                    Status
                                                </label>
                                                <div class="field field-status">
                                                    <select name="status" class="form-control main-element"> 
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>		
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">IMAP</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-host  col-sm-6  form-group">
                                                <label class="field-label-host control-label">
                                                    Host
                                                    *</label>
                                                <div class="field field-host">
                                                    <input type="text" class="main-element form-control" name="host" value="">
                                                </div>
                                            </div>
                                            <div class="cell cell-username  col-sm-6  form-group">
                                                <label class="field-label-username control-label">
                                                    Username
                                                    *</label>
                                                <div class="field field-username">
                                                    <input type="text" class="main-element form-control" name="username" value="">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-port  col-sm-6  form-group">
                                                <label class="field-label-port control-label">
                                                    Port
                                                    *</label>
                                                <div class="field field-port">
                                                    <input type="text" class="main-element form-control" name="port" value="143">
                                                </div>
                                            </div>
                                            <div class="cell cell-password  col-sm-6  form-group">
                                                <label class="field-label-password control-label">
                                                    Password
                                                </label>
                                                <div class="field field-password">
                                                    <input type="password" class="main-element form-control" name="password" value="">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-monitoredFolders  col-sm-6  form-group">
                                                <label class="field-label-monitoredFolders control-label">
                                                    Monitored Folder
                                                    *</label>
                                                <div class="field field-monitoredFolders">
                                                    <input type="text" class="main-element form-control" name="monitoredFolders" value="INBOX">
                                                </div>
                                            </div>
                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-trashFolder  col-sm-6  form-group">
                                                <label class="field-label-trashFolder control-label">
                                                    Trash Folder
                                                    *</label>
                                                <div class="field field-trashFolder">
                                                    <input type="text" class="main-element form-control" name="trashFolder" value="INBOX.Trash">
                                                </div>
                                            </div>
                                            <div class="col-sm-6"></div>			
                                        </div>			
                                    </div>
                                </div>
                                
                            </div>
                            <div class="extra"></div>
                            <div class="bottom"></div>
                        </div>
                        <div class="side col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-default">
                                    <div class="row">
                                        <div class="cell cell-assignedUser form-group col-sm-6 col-md-12">
                                            <label class="field-label-assignToUser control-label">
                                                Assign to User
                                            </label>
                                            <div class="field field-assignToUser">
                                                <div class="input-group">
                                                    <input class="main-element form-control" type="text" name="users" id="users" value="" autocomplete="off">
                                                    <span class="input-group-btn">        
                                                        <button data-action="users" data-type="single" data-toggle="modal" data-target="#myModal" class="btn btn-default selectData" type="button" tabindex="-1"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button data-action="users" data-type="single" class="btn btn-default data-clearLink" type="button" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="assignToUserId" id="usersIds" value="">
                                        </div>
                                        
                                        <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                            <label class="field-label-team control-label">
                                                Team
                                            </label>
                                            <div class="field field-team">
                                                <div class="input-group">
                                                    <input class="main-element form-control" type="text" name="team" id="team" value="" autocomplete="off">
                                                    <span class="input-group-btn">        
                                                        <button data-action="team" data-type="single" data-toggle="modal" data-target="#myModal" class="btn btn-default selectData" type="button" tabindex="-1"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                        <button data-action="team" data-type="single" class="btn btn-default data-clearLink" type="button" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="teamIds" name="teamId" value=""> 
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>				
                    </div>
                    <input type="hidden" name="email_inbound" value="<?php echo $mailDetails['id']; ?>">
                </form>
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
