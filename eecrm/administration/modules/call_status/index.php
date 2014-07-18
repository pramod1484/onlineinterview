<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-call_status.php';

$statusList = getAllCallStatus(0, MAX_ROWS);
?>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH; ?>">Administration</a> &raquo; Call Status</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                        <a class="btn btn-primary" href="<?php echo BASEPATH;?>administration/modules/call_status/create.php">Create Call Status</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="list-container">
            <?php if ($statusList !== NULL) : ?>
            <div class="list-buttons-container clearfix">
                <div class="btn-group actions">
                    <button disabled="" data-toggle="dropdown" class="btn btn-default dropdown-toggle actions-button" type="button">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-action="delete" data-isadmin="1" data-module="call_status" data-field="status_id" class="massremove" href="javascript:">Delete</a></li>
                        <?php 
                            /*<li><a data-action="merge" href="javascript:">Merge</a></li>
                            <li><a data-action="massUpdate" href="javascript:">Mass Update</a></li>
                            <li><a data-action="export" href="javascript:">Export</a></li> */ 
                        ?>
                    </ul>
                </div>
            </div>
            <?php endif;?>
            <div class="list">
                <table class="table">
                    <?php if ($statusList !== NULL) : ?>
                    <thead>
                        <tr>
                            <th width="5%"><input type="checkbox" class="selectAll"></th>
                            <th> 
                                <a data-name="name" class="sort" href="javascript:">Name</a>
                            </th>
                            <th width="7%"></th>
                        </tr>
                        
                    </thead>
                    <?php endif; ?>
                    <tbody>
                        <?php if ($statusList !== NULL) :
                                foreach ($statusList as $status) : ?>
                                    <tr data-id="<?php echo $status['status_id'];?>" class="initial">
                                        <td class="cell cell-checkbox">
                                            <input type="checkbox" data-id="<?php echo $status['status_id']; ?>" class="record-checkbox records-multiaction">
                                        </td>	
                                        <td class="cell cell-name">
                                            <a title="<?php echo ucfirst($status['status_name']);?>" data-id="<?php echo ucfirst($status['status_id']);?>" class="link" href="<?php echo ADMINPATH;?>modules/call_status/view.php?id=<?php echo $status['status_id'];?>">
                                                <?php echo ucfirst($status['status_name']);?>
                                            </a>
                                        </td>	
                                        <td width="7%" class="cell cell-buttons">
                                            <div class="list-row-buttons btn-group pull-right">
                                                <button data-toggle="dropdown" class="btn btn-link btn-sm dropdown-toggle" type="button">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a data-id="<?php echo $status['status_id']; ?>" data-action="quickEdit" class="action" href="<?php echo ADMINPATH; ?>modules/call_status/edit.php?id=<?php echo $status['status_id']; ?>">Edit</a></li>
                                                    <?php /*<li><a data-id="<?php echo $user['id']; ?>" data-action="quickRemove" class="action" href="javascript:">Remove</a></li>	 */ ?>
                                                 </ul>
                                             </div>
                                        </td>                                      
                                    </tr>                                
                           <?php endforeach; ?>
                    </tbody>
                </table>                                    
                        <?php else:  ?>
                            No Data
                        <?php endif; ?>

                <div class="show-more hide">
                    <a data-action="showMore" class="btn btn-default btn-block" href="javascript:" type="button">Show more</a>
                </div>
            </div> 
        </div>
    </div>
</div>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>