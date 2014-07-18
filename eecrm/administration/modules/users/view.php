<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-team-users.php';
if (!empty($_GET['id'])) {
    try {
        $userDetails = getUserDetails($_GET['id']);
        $usersTeams  = getUsersTeamNames($_GET['id']);
    } catch (Exception $exception) {
        setSessionValue('errorMessage', $exception->getMessage());
    }
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH?>modules/users/">Users</a><?php if ($userDetails != NULL) : ?> &raquo; <?php echo ucfirst($userDetails['first_name']) ." ". ucfirst($userDetails['last_name']);?> <?php else:?><?php endif; ?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div id="user-detail" class="detail">
                <?php if ($userDetails != NULL) : ?>
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH?>modules/users/edit.php?id=<?php echo $userDetails['id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='users' data-isadmin ='1' data-field='id' data-value='<?php echo $userDetails['id'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
                </div>
                <?php endif; ?>
                <div style="height: 21px; display: none;">&nbsp;</div>

                <div class="detail-button-container button-container edit-buttons hidden">
                    <button type="button" data-action="save" class="btn btn-primary">Save</button>
                    <button type="button" data-action="cancelEdit" class="btn btn-default">Cancel</button>
                </div>
                <div style="height: 21px; display: none;">&nbsp;</div>

                <div class="row">
                    <div class=" col-md-8">
                        <div class="record">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                <?php if ($userDetails != NULL) : ?>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="cell cell-userName  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-userName control-label">
                                                User Name
                                            </label>
                                            <div class="field field-userName">
                                                <?php echo $userDetails['user_name'];?>
                                            </div>
                                        </div>
                                        <div class="cell cell-isAdmin  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-isAdmin control-label">
                                                Is Admin
                                            </label>
                                            <div class="field field-isAdmin">
                                                <input type="checkbox" <?php if($userDetails['is_admin']) : ?> checked="checked" <?php else: ?> disabled="" <?php endif;?> />
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-name  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-name control-label">
                                                Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo $userDetails['salutation_name']." ".ucfirst($userDetails['first_name']) ." ". ucfirst($userDetails['last_name']);?>
                                            </div>
                                        </div>
                                        <div class="cell cell-title  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-title control-label">
                                                Title
                                            </label>
                                            <div class="field field-title">
                                                <?php echo ucfirst($userDetails['title']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                    <div class="row">
                                        <div class="cell cell-defaultTeam  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-defaultTeam control-label">
                                                Default Team
                                            </label>
                                            <div class="field field-defaultTeam">
                                                <?php echo ucfirst(sanitizeString($userDetails['teamName'])); ?>
                                            </div>
                                        </div>
                                    </div>			

                                    <div class="row">
                                        <div class="cell cell-emailAddress  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-emailAddress control-label">
                                                Email
                                            </label>
                                            <div class="field field-emailAddress">
                                                <a data-action="mailTo" data-email-address="<?php echo $userDetails['email_address']; ?>" href="javascript:"><?php echo $userDetails['email_address']; ?></a>
                                            </div>
                                        </div>

                                        <div class="cell cell-phone  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="field-label-phone control-label">
                                                Phone
                                            </label>
                                            <div class="field field-phone">
                                                <?php echo ucfirst($userDetails['phone']);?>
                                            </div>
                                        </div>
                                    </div>			
                                </div>                                    
                                <?php else:
                                     echo 'No details found for this user';
                                    endif; ?>
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
                                    <div class="cell cell-teams form-group col-sm-6 col-md-12"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-teams">Teams</label>
                                        <div class="field field-teams">
                                            <?php if ($usersTeams !== NULL): 
                                                    foreach ($usersTeams as $team) : ?>
                                                        <a href="<?php echo ADMINPATH;?>modules/teams/view.php?id=<?php echo $team['team_id'];?>">
                                                             <?php echo ucfirst(sanitizeString($team['teamName'])); ?>.
                                                        </a>
                                                    <?php endforeach; ?> 
                                            <?php else:?>
                                                None
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="cell cell-roles form-group col-sm-6 col-md-12"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <label class="control-label label-roles">Roles</label>
                                        <div class="field field-roles">
                                            None
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
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>