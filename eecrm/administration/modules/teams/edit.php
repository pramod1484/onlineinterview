<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-teams.php';
if (!empty($_GET['id'])) {
    $teamDetails = getTeamDetails($_GET['id']);
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; margin: 0 auto;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main">
        <div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3>
                        <a href="<?php echo ADMINPATH;?>modules/teams/">Teams</a>
                        <?php if ($teamDetails) :?>
                        &raquo; <a href="<?php echo ADMINPATH;?>modules/teams/view.php?id=<?php echo $teamDetails['id'];?>">
                            <?php echo $teamDetails['name']; ?>
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
                <form id="form-team-edit" name="teamEditForm" action="<?php echo ADMINPATH;?>modules/teams/save.php" method="POST">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH;?>modules/teams/view.php?id=<?php echo $teamDetails['id'];?>" data-action="cancel" class="btn btn-default">Cancel</a>		
                </div>
                    <div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <label class="field-label-name control-label">
                                                    Name
                                                </label>
                                                <div class="field field-name">
                                                    <input type="text" maxlength="100" value="<?php echo ucfirst(sanitizeString($teamDetails['name'])); ?>" name="name" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>
                            </div>
                            <div class="extra"></div>
                            <div class="bottom">
                                <div class="panel panel-default panel-users">
                                    <div class="panel-heading">
                                        <div class="pull-right btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a data-link="users" data-action="selectRelated" data-panel="users" class="action" href="javascript:">Select</a></li>
                                            </ul>
                                        </div>
                                        <h4 class="panel-title">Users</h4>
                                    </div>
                                    <div class="panel-body panel-body-users">
                                        <div class="list-container">
                                            No Data
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="side col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-default">
                                    <div class="row">
                                       <div class="cell cell-roles form-group col-sm-6 col-md-12"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <label class="control-label label-roles">Roles</label>
                                            <div class="field field-roles"><div class="link-container list-group">
                                                </div>
                                                <div class="input-group add-team">
                                                    <input type="text" placeholder="Select" autocomplete="off" value="" name="" class="main-element form-control">
                                                    <span class="input-group-btn">        
                                                        <button tabindex="-1" type="button" class="btn btn-default" data-action="selectLink"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="ids" value="" name="rolesIds">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="team" id="team" value="<?php echo $_GET['id'];?>" />
                </form>
            </div>
        </div>
    </div>
</div> 
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
