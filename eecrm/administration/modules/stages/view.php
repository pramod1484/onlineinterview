<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-stages.php';
if (!empty($_GET['id'])) {
    $stagesDetails = getStageDetails($_GET['id']);
}
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH; ?>modules/stages/">Stages</a> <?php if ($stagesDetails != NULL) : ?> &raquo; <?php echo $stagesDetails['stage_name']; endif;?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body"><div id="stages-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH; ?>modules/stages/edit.php?id=<?php echo $stagesDetails['stage_id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='stages' data-isadmin ='1' data-field='stage_id' data-value='<?php echo $stagesDetails['stage_id'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
                </div>

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
                                                <?php echo ucfirst($stagesDetails['stage_name']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                </div>
                            </div>
                        </div>
                        <div class="extra"></div>
                        
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