<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-teams.php';

$teamsList = getAllTeams(0, MAX_ROWS);
?>
<div class="container content">
    <div id="main"><div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH; ?>">Administration</a> &raquo; Teams</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                        <a class="btn btn-primary" href="<?php echo BASEPATH;?>administration/modules/teams/create.php">Create Team</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-container">
            <div class="row search-row">
                <div class="form-group col-sm-6">
                    <div class="input-group">
                        <input type="text" value="" name="filter" class="form-control filter searchfilter">
                        <div class="input-group-btn">
                            <button data-module="teams" data-isadmin ="1" data-action="search" class="btn btn-primary search btn-icon" type="button">
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
<!--                        <button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle add-filter-button" type="button">
                            Add Filter <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right filter-list">
                            <li class="" data-name="title"><a data-name="title" data-action="addFilter" class="add-filter" href="javascript:">Title</a></li>
                        </ul>-->
                    </div>	
                </div>
            </div>
            <div class="row advanced-filters">
            </div>

        </div>
        <div class="list-container">
            <?php if ($teamsList !== NULL) : ?>
            <div class="list-buttons-container clearfix">
                <div class="btn-group actions">
                    <button disabled="" data-toggle="dropdown" class="btn btn-default dropdown-toggle actions-button" type="button">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-action="delete" data-isadmin="1" data-module="teams" data-field="id" class="massremove" href="javascript:">Delete</a></li>
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
                    <?php if ($teamsList !== NULL) : ?>
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
                        <?php if ($teamsList !== NULL) :
                                foreach ($teamsList as $team) : ?>
                                    <tr data-id="<?php echo $team['id'];?>" class="initial">
                                        <td class="cell cell-checkbox">
                                            <input type="checkbox" data-id="<?php echo $team['id']; ?>" class="record-checkbox records-multiaction">
                                        </td>	
                                        <td class="cell cell-name">
                                            <a title="<?php echo ucfirst($team['name']);?>" data-id="<?php echo ucfirst($team['id']);?>" class="link" href="<?php echo ADMINPATH;?>modules/teams/view.php?id=<?php echo $team['id'];?>">
                                                <?php echo ucfirst($team['name']);?>
                                            </a>
                                        </td>	
                                        <td width="7%" class="cell cell-buttons">
                                            <div class="list-row-buttons btn-group pull-right">
                                                <button data-toggle="dropdown" class="btn btn-link btn-sm dropdown-toggle" type="button">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a data-id="<?php echo $team['id']; ?>" data-action="quickEdit" class="action" href="<?php echo ADMINPATH; ?>modules/teams/edit.php?id=<?php echo $team['id']; ?>">Edit</a></li>
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