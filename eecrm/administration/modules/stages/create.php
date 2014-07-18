<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-stages.php';
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH; ?>modules/stages/">Stages</a> &raquo; create</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>

        </div>
        <div class="body">
            <div id="stages-edit" class="edit">
                <form id="form-stages-edit" name="frmStage" method="POST" action="<?php echo ADMINPATH; ?>modules/stages/new.php">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH; ?>modules/stages/" data-action="cancel" class="btn btn-default">Cancel</a>		
                </div>
                <div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Stage Name
                                                </label>
                                                <div class="field field-name">
                                                    <input type="text" maxlength="100" value="" name="name" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>

                            </div>
                            <div class="extra"></div>
                            <div class="bottom"></div>
                        </div>
                        				
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
