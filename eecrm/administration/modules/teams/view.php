<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-teams.php';
if (!empty($_GET['id'])) {
    $teamDetails = getTeamDetails($_GET['id']);
}
?>
<div class="container content">
    <div id="main">
        <div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH;?>modules/teams/">Teams</a> <?php if($teamDetails != NULL):?> &raquo; <?php echo $teamDetails['name']; endif;?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body"><div id="team-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH?>modules/teams/edit.php?id=<?php echo $teamDetails['id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='teams' data-isadmin ='1' data-field='id' data-value='<?php echo $$teamDetails['id'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
                </div><div style="height: 21px; display: none;">&nbsp;</div>

                <div class="detail-button-container button-container edit-buttons hidden" style="display: block;">
                    <button type="button" data-action="save" class="btn btn-primary">Save</button>
                    <button type="button" data-action="cancelEdit" class="btn btn-default">Cancel</button>
                </div><div style="height: 21px; display: none;">&nbsp;</div>

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
                                                <?php echo ucfirst($teamDetails['name']); ?>
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