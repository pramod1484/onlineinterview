<?php
    require_once dirname(__DIR__).'/include-locations.php';
    require_once $include_directory . 'define.php';
    require_once $include_directory . 'utils-helpers.php';
    // check is user is valid
    isValidUser();
    //echo MODULE;
?>
<html>
    <head>
        <title>EECRM</title>
        <link rel="stylesheet" href="<?php echo BASEPATH; ?>css/style.css"> 
        <link rel="stylesheet" href="<?php echo BASEPATH; ?>css/datepicker.css">
        <script type="text/javascript" src="<?php echo BASEPATH; ?>js/jquery-1.8.2.min.js"></script>        
        <script type="text/javascript" src="<?php echo BASEPATH; ?>js/bootstrap.min.js"></script>
    </head>
    <body>
        <header id="header"><div id="navbar"><div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
                    <div class="navbar-header">
                        <a href="<?php echo BASEPATH;?>dashboard.php" class="navbar-brand"><img src="<?php echo BASEPATH;?>images/logo-small.png"></a>
                        <button data-target=".navbar-body" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse navbar-body">
                        <ul class="nav navbar-nav tabs">			
                            <li data-name="Lead" <?php if (MODULE == 'leads') : echo 'class="active"'; endif; ?>><a href="<?php echo BASEPATH?>modules/leads/">Leads</a></li>
                            <li data-name="Opportunity" <?php if (MODULE == 'opportunities') : echo 'class="active"'; endif; ?>><a href="<?php echo BASEPATH?>modules/opportunities">Opportunities</a></li>
                            <li data-name="Meeting" <?php if (MODULE == 'meeting') : echo 'class="active"'; endif; ?>><a href="<?php echo BASEPATH?>modules/meeting">Meetings</a></li>
                            <li data-name="Call" <?php if (MODULE == 'call') : echo 'class="active"'; endif; ?>><a href="<?php echo BASEPATH?>modules/call">Calls</a></li>
                            <li data-name="Task" <?php if (MODULE == 'task') : echo 'class="active"'; endif; ?>><a href="<?php echo BASEPATH?>modules/task">Tasks</a></li>
                            <li class="dropdown hide">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="nav-more-tabs-dropdown">More <b class="caret"></b></a>				
                                <ul aria-labelledby="nav-more-tabs-dropdown" role="menu" class="dropdown-menu">					
                                </ul>				
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php /* HTML Commented Code ?>
 <!--                    <li class="nav navbar-nav navbar-form global-search-container hidden-xs">
                                <input type="text" placeholder="Search" class="form-control input-sm" id="global-search-input">
                                <div class="global-search-panel-container"></div>

                            </li>		
                            <li class="dropdown hidden-xs notifications-badge-container">
                                <a data-action="showNotifications" class="notifications-button" href="javascript:" title="">
                                    <span class="glyphicon glyphicon-bell icon"></span>
                                </a>
                                <div class="notifications-panel-container"></div>

                            </li>			

                      <li class="dropdown hidden-xs">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="nav-quick-create-dropdown"><i class="glyphicon glyphicon-plus"></i></a>
                                <ul aria-labelledby="nav-quick-create-dropdown" role="menu" class="dropdown-menu">
                                    <li class="dropdown-header">Create</li>
                                    <li><a data-action="quick-create" data-name="Lead" href="#Lead/create">Lead</a></li>
                                    <li><a data-action="quick-create" data-name="Meeting" href="#Meeting/create">Meeting</a></li>
                                    <li><a data-action="quick-create" data-name="Call" href="#Call/create">Call</a></li>
                                    <li><a data-action="quick-create" data-name="Task" href="#Task/create">Task</a></li>
                                </ul>
                            </li>-->
                            <?php Commented Code Ends */ ?>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="nav-menu-dropdown">Menu <b class="caret"></b></a>
                                <ul aria-labelledby="nav-menu-dropdown" role="menu" class="dropdown-menu">
                                    <?php /*if (getSessionValue('user') == 1): ?>
                                        <li><a href="<?php echo BASEPATH?>administration">Admin</a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo BASEPATH?>dashboard"><?php echo getSessionValue('username');?></a></li>
                                    <?php endif;*/ ?>
                                    <li>
                                        <a href="<?php echo BASEPATH?>administration/modules/users/view.php?id=<?php echo getSessionValue('user');?>">
                                        <?php echo getSessionValue('username');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo BASEPATH?>administration">Administration</a></li>
<!--                                    <li><a href="#Preferences">Preferences</a></li>
                                    <li><a href="#About">About</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#clearCache">Clear Local Cache</a></li>-->
                                    <li><a href="<?php echo BASEPATH?>logout.php">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>	
                </div>
            </div>
        </header>
       