<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-sources.php';
if (!empty($_GET['id'])) {
    $sourcesDetails = getSourceDetails($_GET['id']);
}
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH;?>modules/sources/">Sources</a> <?php if($sourcesDetails != NULL):?> &raquo; <?php echo $sourcesDetails['source_name']; endif;?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body"><div id="sources-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH?>modules/sources/edit.php?id=<?php echo $sourcesDetails['source_id'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='sources' data-isadmin ='1' data-field='source_id' data-value='<?php echo $sourcesDetails['source_id'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
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
                                                Source Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo ucfirst($sourcesDetails['source_name']); ?>
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