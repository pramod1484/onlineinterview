<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-mail.php';
require_once $include_directory . 'utils-entity-teams.php';
if (!empty($_GET['id'])) {
    try {
        $templateDetails = getTemplateDetails($_GET['id']);
        
        $templateTeams = getTeamNames($_GET['id'],'Template');
        if (count($templateTeams) > 0) {
            $teamNames  = implode(",", array_map(function($arr){ return '<a href="'.ADMINPATH.'modules/teams/view.php?id='.$arr['team_id'].'">'.$arr['teamName'].'</a>';}, $templateTeams));
        }
        
        $attachments = getMailAttachments($_GET['id'], 'template');
        if (count($attachments) > 0) {
            $mailAttachments  = implode(",", array_map(function($arr){ return '<span class="glyphicon glyphicon-paperclip small"></span>
                <a href="' . BASEPATH . 'download.php?file='.$arr['savedName'].'">'.$arr['name'].'</a>';}, $attachments));
        }
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
            <h3><a href="<?php echo ADMINPATH; ?>modules/email/template.php">Email Templates</a> &raquo; <?php echo sanitizeString($templateDetails['name']); ?></h3>
        </div>
        
        <div class="body"><div class="detail" id="template-email-detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH; ?>modules/email/template-edit.php?id=<?php echo $templateDetails['id']; ?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a class="btn btn-danger delete-record" data-action="delete" data-value="<?php echo $templateDetails['id']; ?>" data-field="id" data-isadmin="1" data-module="email_template">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div class="detail-button-container button-container edit-buttons hidden" style="display: block;">
                    <button class="btn btn-primary" data-action="save" type="button">Save</button>
                    <button class="btn btn-default" data-action="cancelEdit" type="button">Cancel</button>
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                <div class="row">
                    
                    <div class=" col-md-8">
                        <div class="record">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-name  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">
                                                Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo sanitizeString($templateDetails['name']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-subject col-sm-12 form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-subject control-label">
                                                Subject
                                            </label>
                                            <div class="field field-subject">
                                                <?php echo sanitizeString($templateDetails['subject']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-body col-sm-12 form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-body control-label">
                                                Body
                                            </label>
                                            <div class="field field-body">
                                                <?php echo sanitizeString($templateDetails['body']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-attachments  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-attachments control-label">
                                                Attachments
                                            </label>
                                            <div class="field field-attachments">
                                                <?php echo (isset($mailAttachments)) ? $mailAttachments : ''; ?>
                                            </div>
                                        </div>
                                        <div class="cell cell-isHtml  col-sm-6  form-group"><a href="javascript:" class="pull-right inline-edit-link hide"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-isHtml control-label">
                                                Is Html
                                            </label>
                                            <div class="field field-isHtml">
                                                <input type="checkbox" <?php if ($templateDetails['is_html']) : echo 'checked="checked"'; endif; ?> disabled="">
                                            </div>
                                        </div>
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
                                            <a href="<?php echo ADMINPATH; ?>modules/users/view.php?id=<?php echo $templateDetails['assigned_user_id']; ?>">
                                                <?php echo sanitizeString($templateDetails['assignedUser']); ?>
                                            </a>
                                        </div>
                                        
                                        <input type="hidden" value="<?php echo $templateDetails['assigned_user_id']; ?>" name="assignedUserId" class="updateField" id="assignedUserId">
                                    </div>
                                    <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                        <a class="pull-right inline-edit-link hide" data-field="assignedTeams" data-field-type="replaceHtml" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <?php echo (isset($teamNames)) ? $teamNames : ''; ?>                                        </div>
                                        <input type="hidden" class="ids updateField" value="<?php echo $templateDetails['team_id']; ?>" name="teamIds" id="teamsIds">
                                    </div>
                                </div>	
                                <div class="row">
                                    <div class="cell form-group col-sm-6 col-md-12">
                                        <label class="control-label">Created</label>
                                        <div class="field">
                                            <span class="field-createdAt"><?php echo getFormattedDate($templateDetails['created_at'], 'm/d/Y H:i'); ?>
                                            </span> by <span class="field-createdBy">
                                                <a href="<?php echo ADMINPATH; ?>modules/users/view.php?id=<?php echo $templateDetails['created_by_id']; ?>"><?php echo sanitizeString($templateDetails['createdUser']); ?></a>
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
