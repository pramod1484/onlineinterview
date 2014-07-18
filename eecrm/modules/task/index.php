<?php
require_once dirname(__DIR__) . '/../common/header.php';
require_once $include_directory . 'utils-task.php';

try {
    $tasks = getAllTasks(0, MAX_ROWS);
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
                    <h3>Tasks</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                        <a class="btn btn-primary" href="<?php echo BASEPATH;?>modules/task/create.php">Create Task</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="search-container">
            <div class="row search-row">
                <div class="form-group col-sm-6">
                    <div class="input-group">
                        <input type="text" value="" name="filter" class="form-control filter">
                        <div class="input-group-btn">
                            <button data-module="task" data-isadmin ="0" data-action="search" class="btn btn-primary search btn-icon" type="button" />
                                <span class="glyphicon glyphicon-search"></span>
                            </button>		
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-6">

                    <div class="btn-group">
                        <button data-action="reset" class="btn btn-default resetrecord" type="button">
                            <span class="glyphicon glyphicon-repeat"></span>&nbsp;Reset
                        </button>
                    </div>
                </div>
            <div class="row advanced-filters">
            </div>

        </div>
        <div class="list-container">
            <?php if ($tasks !== NULL):  ?>
            <div class="list-buttons-container clearfix">
                <div class="btn-group actions">
                    <button disabled="" data-toggle="dropdown" class="btn btn-default dropdown-toggle actions-button" type="button">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-action="delete" data-isadmin="0" data-module="task" data-field="id" class="massremove" href="javascript:">Delete</a></li>
                    </ul>
                </div>
            </div>

            <div class="list">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" class="selectAll"></th>
                            <th width="25%"> 
                                <a data-name="name" class="sort" href="javascript:">Name</a>
                            </th>
                            <th> 
                                <a data-name="Opportunity" class="sort" href="javascript:">Opportunity</a>
                            </th>
                            <th> 
                                <a data-name="Status" class="sort" href="javascript:">Status</a>
                            </th>
                            <th> 
                                <a data-name="Date Start" class="sort" href="javascript:">Date Start</a>
                                <span class="caret-up"></span>								
                            </th>
                            <th> 
                                <a data-name="assigned user" class="sort" href="javascript:">Assigned User</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr data-id="<?php echo $task['id'];?>" class="initial">
                                    <td class="cell cell-checkbox">
                                        <input type="checkbox" data-id="<?php echo $task['id']; ?>" class="record-checkbox records-multiaction">
                                    </td>	
                                    <td class="cell cell-name">
                                        <a title="<?php echo sanitizeString($task['name']); ?>" data-id="<?php echo $task['id']; ?>" class="link" href="<?php echo BASEPATH;?>modules/task/view.php?id=<?php echo $task['id']; ?>"><?php echo sanitizeString($task['name']); ?></a>
                                    </td>	
                                    <td class="cell cell-status">
                                        <?php echo ($task['parent_id']) ? '<a data-id="' . $task['parent_id'] . '" class="link" href="' . BASEPATH . 'modules/opportunities/view.php?id=' . $task['parent_id'] . '">' . $task['oppName'] . '</a>' : ''?>
                                    </td>	
                                    <td class="cell cell-emailAddress">
                                        <span class="text-default"><?php echo sanitizeString($task['status']);?></span>
                                    </td>	
                                    <td class="cell cell-createdAt">
                                        <?php echo getFormattedDate($tasks['date_start'], "m/d/Y h:i")?>
                                    </td>	
                                    <td width="7%" class="cell cell-buttons">
                                        <a data-id="<?php echo $task['assigned_user_id']; ?>" class="link" href="<?php echo ADMINPATH;?>modules/users/view.php?id=<?php echo $task['assigned_user_id']; ?>"><?php echo sanitizeString($task['assignedUser']); ?></a>
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
