<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-stages.php';
if (!empty($_GET['id'])) {
    $stagesDetails = getStageDetails($_GET['id']);
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
                        <a href="<?php echo ADMINPATH;?>modules/stages/">Stage</a>
                        <?php if ($stagesDetails) :?>
                         &raquo; <?php echo $stagesDetails['stage_name']; ?>
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
                <form id="form-stages-edit" name="stagesEditForm" action="<?php echo ADMINPATH;?>modules/stages/save.php" method="POST">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH;?>modules/stages/view.php?id=<?php echo $stagesDetails['stage_id']; ?>" data-action="cancel" class="btn btn-default">Cancel</a>		
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
                                                    Stage Name
                                                </label>
                                                <div class="field field-name">
                                                    <input type="text" maxlength="100" value="<?php echo ucfirst(sanitizeString($stagesDetails['stage_name'])); ?>" name="name" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>
                            </div>
                            <div class="extra"></div>
                        </div>
                        
                    </div>
                    <input type="hidden" name="stage_id" id="stage_id" value="<?php echo $_GET['id'];?>" />
                </form>
            </div>
        </div>
    </div>
</div> 
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
