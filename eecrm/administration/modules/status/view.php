<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-status.php';
if (!empty($_GET['id'])) {
    $statusDetails = getStatusDetails($_GET['id']);
}
?>
<div class="container content">
    <div id="main">
        <div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH;?>modules/status/">Status</a> <?php if($statusDetails != NULL):?> &raquo; <?php echo $statusDetails['status_name']; endif;?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body"><div id="status-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH?>modules/status/edit.php?id=<?php echo $statusDetails['status_id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='status' data-isadmin ='1' data-field='status_id' data-value='<?php echo $statusDetails['status_id'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
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
                                                Status Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo ucfirst($statusDetails['status_name']); ?>
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