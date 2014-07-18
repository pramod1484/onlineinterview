<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-leads.php';

try {
    $leadsList = getAllLeads(0, MAX_ROWS);
} catch (Exception $exc) {
    setSessionValue('errorMessage', $exc->getMessage());
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') {
    ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
    <?php echo $errorMessage; ?>   
    </div>
    <?php removeSessionValue('errorMessage');
} ?>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3>Leads</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                        <a class="btn btn-primary" href="<?php echo BASEPATH;?>modules/leads/create.php">Create Lead</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="search-container">
            <div class="row search-row">
                <div class="form-group col-sm-6">
                    <div class="input-group" >
                        <div class="input-group-btn">
                            <button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-left basic-filter-menu">					
                                <li class="checkbox"><label>
                                        <input type="checkbox" id="onlyMy" name="onlyMy"> Only My</label></li>
                            </ul>				
                        </div>

                        <input type="text" value="" name="filter" class="form-control filter">
                        <div class="input-group-btn">
                            <button data-module="leads" data-isadmin ="0" data-action="search" class="btn btn-primary search btn-icon" type="button" />
                                <span class="glyphicon glyphicon-search"></span>
                            </button>		
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-6">
<!--                    <button data-action="refresh" class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh
                    </button>-->

                    <div class="btn-group">
                        <button data-action="reset" class="btn btn-default resetrecord" type="button">
                            <span class="glyphicon glyphicon-repeat"></span>&nbsp;Reset
                        </button>
                    <!--    <button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle add-filter-button" type="button">
                            Add Filter <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right filter-list">
                            <li class="" data-name="status"><a data-name="status" data-action="addFilter" class="add-filter" href="javascript:">Status</a></li>
                            <li class="" data-name="source"><a data-name="source" data-action="addFilter" class="add-filter" href="javascript:">Source</a></li>
                            <li class="" data-name="opportunityAmount"><a data-name="opportunityAmount" data-action="addFilter" class="add-filter" href="javascript:">Opportunity Amount</a></li>
                            <li class="" data-name="teams"><a data-name="teams" data-action="addFilter" class="add-filter" href="javascript:">Teams</a></li>
                            <li class="" data-name="address"><a data-name="address" data-action="addFilter" class="add-filter" href="javascript:">Address</a></li>
                        </ul>
                    </div>	-->
                </div>
            </div>
            <div class="row advanced-filters">
            </div>

        </div>
        <div class="list-container">
            <?php if ($leadsList !== NULL):  ?>
            <div class="list-buttons-container clearfix">
                <div class="btn-group actions">
                    <button disabled="" data-toggle="dropdown" class="btn btn-default dropdown-toggle actions-button" type="button">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-action="delete" data-isadmin="0" data-module="leads" data-field="id" class="massremove" href="javascript:">Delete</a></li>
<!--                        <li><a data-action="merge" href="javascript:">Merge</a></li>
                        <li><a data-action="massUpdate" href="javascript:">Mass Update</a></li>
                        <li><a data-action="export" href="javascript:">Export</a></li>-->
                    </ul>
                </div>
            </div>

            <div class="list">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%"><input type="checkbox" class="selectAll"></th>
                            <th width="25%"> 
                                <a data-name="name" class="sort" href="javascript:">Name</a>
                            </th>
                            <th> 
                                <a data-name="status" class="sort" href="javascript:">Status</a>
                            </th>
                            <th> 
                                <a data-name="emailAddress" class="sort" href="javascript:">Email</a>
                            </th>
                            <th> 
                                <a data-name="assignedUser" class="sort" href="javascript:">Assigned User</a>
                            </th>
                            <th> 
                                <a data-name="createdAt" class="sort" href="javascript:">Created At</a>
                                <span class="caret-up"></span>								
                            </th>
                            <th width="7%%"> 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($leadsList as $lead): ?>
                                <tr data-id="<?php echo $lead['id'];?>" class="initial">
                                    <td class="cell cell-checkbox">
                                        <input type="checkbox" data-id="<?php echo $lead['id']; ?>" class="record-checkbox da">
                                    </td>	
                                    <td class="cell cell-name">
                                        <a title="<?php echo sanitizeString($lead['first_name'])." ".sanitizeString($lead['last_name']); ?>" data-id="<?php echo $lead['id']; ?>" class="link" href="<?php echo BASEPATH;?>modules/leads/view.php?id=<?php echo $lead['id']; ?>"><?php echo sanitizeString($lead['first_name'])." ".sanitizeString($lead['last_name']); ?></a>
                                    </td>	
                                    <td class="cell cell-status">
                                        <span class="text-default <?php if($lead['status'] == 7):?>text-success<?php endif;?>"><?php echo sanitizeString($lead['status_name']);?></span>
                                    </td>	
                                    <td class="cell cell-emailAddress">
                                        <a data-action="mailTo" data-email-address="<?php echo $lead['email_address'];?>" href="javascript:"><?php echo $lead['email_address'];?></a>
                                    </td>	
                                    <td class="cell cell-assignedUser">
                                        <a href="<?php echo BASEPATH;?>modules/leads/view.php?id=<?php echo $lead['id'];?>">
                                            <?php echo sanitizeString($lead['firstName']). " ".sanitizeString($lead['lastName']);?>
                                        </a>
                                    </td>	
                                    <td class="cell cell-createdAt">
                                        <?php echo getFormattedDate($lead['created_at'],"m/d/Y h:i")?>
                                    </td>	
                                    <td width="7%" class="cell cell-buttons">
                                        <div class="list-row-buttons btn-group pull-right">
                                            <button data-toggle="dropdown" class="btn btn-link btn-sm dropdown-toggle" type="button">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a data-id="<?php echo $lead['id'];?>" data-action="quickEdit" class="action" href="<?php echo BASEPATH;?>modules/leads/edit.php?id=<?php echo $lead['id'];?>">Edit</a></li>
                                                <li><a data-id="<?php echo $lead['id'];?>" data-action="quickRemove" class="action" href="javascript:">Remove</a></li>	
                                            </ul>
                                        </div>
                                    </td>	
                            </tr>                        
                            <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="show-more hide">
                    <a data-action="showMore" class="btn btn-default btn-block" href="javascript:" type="button">Show more</a>
                </div>
           </div>
            <?php else: ?>
                No data.
           <?php endif;?>            
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/../common/footer.php';
?>
