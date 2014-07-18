<?php
require_once "common/header.php";
require_once $include_directory.'/utils-history.php';
?>
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/highcharts/js/highcharts.js"></script>        
<script type="text/javascript" src="<?php echo BASEPATH; ?>js/highcharts/js/modules/exporting.js"></script>
<script>
    $(function() {
        exporting: {
                 enabled: false
        }        
    });
</script>
<?php 

    require_once $include_directory.'/charts/chart-helpers.php'; 
    require_once $include_directory.'/charts/calls-per-day-per-fte.php';
    require_once $include_directory.'/charts/info-per-day-per-fte.php'; 
    require_once $include_directory.'/charts/appointments-per-week-per-fte.php'; 
    require_once $include_directory.'/charts/specification-per-week-per-fte.php'; 
?>
<div class="container content">
    <div id="main">
        <div class="dashboard">
<!--            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <button class="btn btn-default add-dashlet">Add Dashlet</button>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="row" id="dashlets">	

                <div class="col-sm-6 ui-sortable" style="min-height: 100px;" >
                    <div class="" id="dashlet-container">
                        <div data-id="d265276" data-name="Infosent/Day/FTE" class="panel panel-default dashlet" id="dashlet-d265276">
                            <div class="panel-heading">
<!--                                <div class="dropdown pull-right menu-container">
                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-link btn-sm menu-button"><span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:" data-action="refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li>
                                        <li><a href="javascript:" data-action="options"><span class="glyphicon glyphicon-pencil"></span> Options</a></li>				
                                        <li><a href="javascript:" data-action="remove"><span class="glyphicon glyphicon-remove"></span> Remove</a></li>
                                    </ul>
                                </div>-->
                                <h4 class="panel-title">Infosent/Day/FTE</h4>
                            </div>
                            <div class="dashlet-body panel-body"><div class="chart-container" id="container" style="height: 215px;"></div><div class="legend-container"></div></div>
                        </div>
                    </div>			
                </div>	

                <div class="col-sm-6 ui-sortable" style="min-height: 100px;" >
                    <div class="" id="dashlet-callcontainer">
                        <div data-id="d265276d" data-name="Calls/Day/FTE" class="panel panel-default dashlet" id="dashlet-d265276">
                            <div class="panel-heading">
<!--                                <div class="dropdown pull-right menu-container">
                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-link btn-sm menu-button"><span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:" data-action="refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li>
                                        <li><a href="javascript:" data-action="options"><span class="glyphicon glyphicon-pencil"></span> Options</a></li>				
                                        <li><a href="javascript:" data-action="remove"><span class="glyphicon glyphicon-remove"></span> Remove</a></li>
                                    </ul>
                                </div>-->
                                <h4 class="panel-title">Calls/Hour/Day/FTE</h4>
                            </div>
                            <div class="dashlet-body panel-body"><div class="chart-container" id="callcontainer" style="height: 215px;"></div><div class="legend-container"></div></div>
                        </div>
                    </div>			
                </div>	   
                
                <div class="col-sm-6 ui-sortable" style="min-height: 100px;" >
                    <div class="" id="dashlet-appointmentcontainer">
                        <div data-id="d265276d" data-name="Appointments/Week/FTE" class="panel panel-default dashlet" id="dashlet-d265276">
                            <div class="panel-heading">
<!--                                <div class="dropdown pull-right menu-container">
                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-link btn-sm menu-button"><span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:" data-action="refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li>
                                        <li><a href="javascript:" data-action="options"><span class="glyphicon glyphicon-pencil"></span> Options</a></li>				
                                        <li><a href="javascript:" data-action="remove"><span class="glyphicon glyphicon-remove"></span> Remove</a></li>
                                    </ul>
                                </div>-->
                                <h4 class="panel-title">Appointments/Week/FTE</h4>
                            </div>
                            <div class="dashlet-body panel-body"><div class="chart-container" id="appointmentcontainer" style="height: 215px;"></div><div class="legend-container"></div></div>
                        </div>
                    </div>			
                </div>	                
 
            <div class="col-sm-6 ui-sortable" style="min-height: 100px;" >
                    <div class="" id="dashlet-specificationcontainer">
                        <div data-id="d265276d" data-name="Specification/Week/FTE" class="panel panel-default dashlet" id="dashlet-d265276">
                            <div class="panel-heading">
<!--                                <div class="dropdown pull-right menu-container">
                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-link btn-sm menu-button"><span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="javascript:" data-action="refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li>
                                        <li><a href="javascript:" data-action="options"><span class="glyphicon glyphicon-pencil"></span> Options</a></li>				
                                        <li><a href="javascript:" data-action="remove"><span class="glyphicon glyphicon-remove"></span> Remove</a></li>
                                    </ul>
                                </div>-->
                                <h4 class="panel-title">Specification/Week/FTE</h4>
                            </div>
                            <div class="dashlet-body panel-body"><div class="chart-container" id="sepecificationcontainer" style="height: 215px;"></div><div class="legend-container"></div></div>
                        </div>
                    </div>			
                </div>	
                
            </div>
        </div>
    </div>
</div>    
<?php
require_once "common/footer.php";
?>