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
                    <h3>
                        <a href="<?php echo ADMINPATH;?>modules/users/">Users</a>
                        <?php if ($userDetails) :?>
                        &raquo; <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $userDetails['id'];?>">
                            <?php echo $userDetails['first_name'] ." ". $userDetails['last_name']; ?>
                        </a>
                        <?php endif;?>
                    </h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div id="user-edit" class="edit">
                <form id="form-user-edit" name="userEditForm" action="<?php echo ADMINPATH;?>modules/users/save.php" method="POST">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $userDetails['id'];?>" data-action="cancel" class="btn btn-default">Cancel</a>		
                </div><div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-userName  col-sm-6  form-group">
                                                <label class="field-label-userName control-label">
                                                    User Name
                                                    *</label>
                                                <div class="field field-userName">
                                                    <input type="text" maxlength="50" value="<?php echo $userDetails['user_name']; ?>" name="userName" class="main-element form-control">
                                                </div>
                                            </div>
                                            <div class="cell cell-isAdmin  col-sm-6  form-group">
                                                <label class="field-label-isAdmin control-label">
                                                    Is Admin
                                                </label>
                                                <div class="field field-isAdmin">
                                                    <input type="checkbox" <?php if($userDetails['is_admin']) : ?> checked="checked" <?php else: ?> disabled="" <?php endif;?> />
                                                </div>
                                            </div>


                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Name
                                                    *</label>
                                                <div class="field field-name">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="salutationName">
                                                                <option value=""></option>
                                                                <option <?php if ($userDetails['salutation_name'] == 'Mr.') : ?> selected="selected" <?php endif; ?>  value="Mr.">Mr.</option>
                                                                <option <?php if ($userDetails['salutation_name'] == 'Mrs.') : ?> selected="selected" <?php endif; ?> value="Mrs.">Mrs.</option>
                                                                <option <?php if ($userDetails['salutation_name'] == 'Dr.') : ?> selected="selected" <?php endif; ?>  value="Dr.">Dr.</option>
                                                                <option <?php if ($userDetails['salutation_name'] == 'Drs.') : ?> selected="selected" <?php endif; ?> value="Drs.">Drs.</option>
                                                            </select>		
                                                        </div>
                                                        <div class="col-sm-4">	
                                                            <input type="text" placeholder="First Name" value="<?php echo $userDetails['first_name']; ?>" name="firstName" class="form-control">
                                                        </div>
                                                        <div class="col-sm-5">	
                                                            <input type="text" placeholder="Last Name" value="<?php echo $userDetails['last_name']; ?>" name="lastName" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="cell cell-title  col-sm-6  form-group">
                                                <label class="field-label-title control-label">
                                                    Title
                                                </label>
                                                <div class="field field-title">
                                                    <input type="text" maxlength="100" value="<?php echo $userDetails['title']; ?>" name="title" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-defaultTeam  col-sm-6  form-group">
                                                <label class="field-label-defaultTeam control-label">
                                                    Default Team
                                                </label>
                                                <div class="field field-defaultTeam">
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="off" value="<?php echo ucfirst(sanitizeString($userDetails['teamName'])); ?>" name="defaultTeamName" id="defaultTeamName" class="main-element form-control">
                                                        <span class="input-group-btn">        
                                                            <button tabindex="-1" type="button" class="btn btn-default selectteam" data-action="defaultTeam" data-action="defaultTeam" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                            <button tabindex="-1" type="button" class="btn btn-default team-clearLink" data-action="defaultTeamClear"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </span>
                                                    </div>
                                                    <input type="hidden" value="<?php echo $userDetails['default_team_id']; ?>" name="defaultTeamId" id="defaultTeamId">
                                                </div>
                                            </div>


                                        </div>			
                                        <div class="row">
                                            <div class="cell cell-emailAddress  col-sm-6  form-group">
                                                <label class="field-label-emailAddress control-label">
                                                    Email
                                                </label>
                                                <div class="field field-emailAddress">
                                                    <input type="email" value="<?php echo $userDetails['email_address']; ?>" name="emailAddress" class="main-element form-control"> 
                                                </div>
                                            </div>

                                            <div class="cell cell-phone  col-sm-6  form-group">
                                                <label class="field-label-phone control-label">
                                                    Phone
                                                </label>
                                                <div class="field field-phone">
                                                    <input type="text" maxlength="50" value="<?php echo $userDetails['phone']; ?>" name="phone" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>



                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Password</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-password  col-sm-6  form-group">
                                                <label class="field-label-password control-label">
                                                    Password
                                                </label>
                                                <div class="field field-password">
                                                    <input type="password" value="" name="password" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			

                                        <div class="row">
                                            <div class="cell cell-passwordConfirm  col-sm-6  form-group">
                                                <label class="field-label-passwordConfirm control-label">
                                                    Confirm Password
                                                </label>
                                                <div class="field field-passwordConfirm">
                                                    <input type="password" value="" name="passwordConfirm" class="main-element form-control">
                                                </div>
                                            </div>
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
                                        <div class="cell cell-teams form-group col-sm-6 col-md-12">
                                            <label class="control-label label-teams">Teams</label>
                                            <div class="field field-teams">
                                                <div class="link-container list-group team-group">
                                                    <?php if ($usersTeams !== NULL): 
                                                            $ids = implode(',', array_map(function($entry){ return $entry['team_id']; }, $usersTeams));                                                        
                                                            foreach ($usersTeams as $team) : ?>
                                                                <div class="link-team-<?php echo $team['team_id'];?> list-group-item">
                                                                    <?php echo ucfirst(sanitizeString($team['teamName'])); ?>
                                                                    <a href="javascript:" class="team-clearLink pull-right" data-id="<?php echo ucfirst(sanitizeString($team['team_id'])); ?>">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </a>
                                                                </div>                                                       
                                                            <?php endforeach; ?> 
                                                    <?php endif; ?>                                                    
                                                </div>

                                                <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default selectteam" data-module="teams" data-action="selectLink" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="ids" value="<?php echo $ids;?>" name="teamsIds" id="teamsIds">
                                            </div>
                                        </div>

                                        <div class="cell cell-roles form-group col-sm-6 col-md-12">
                                            <label class="control-label label-roles">Roles</label>
                                            <div class="field field-roles">
                                                <div class="link-container list-group list-roles">
                                                </div>

                                                <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" data-action="roles" data-type="multiple" type="button" class="btn btn-default selectData" data-toggle="modal" data-target="#myModal">
                                                            <span class="glyphicon glyphicon-arrow-up"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                                <input type="hidden" id="rolesIds" class="ids" value="" name="rolesIds">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>				
                    </div>
                    <input type="hidden" name="user" id="user" value="<?php echo $_GET['id'];?>" />
                </form>
            </div>
        </div>
    </div>
</div> 

<!-- to create and open modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
<script src="<?php echo BASEPATH;?>js/private/users/selectteams.js"></script>
<script type="text/javascript" src="<?php echo BASEPATH;?>js/modules/selectList.js"></script>
