<html>
    <head>
        <title>Login</title>
        <?php
        require_once 'include-locations.php';
        require_once $include_directory . 'define.php';
        require_once $include_directory . 'utils-helpers.php';
        ?>        
        <link rel="stylesheet" href="<?php echo BASEPATH; ?>css/style.css">
    </head>
    <body>
        <?php 
            $errorMessage = getSessionValue('errorMessage');
            if ($errorMessage != '') { ?>
                <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
                 <?php echo $errorMessage; ?>   
                </div>
        <?php 
             removeSessionValue('errorMessage');
            } ?>
        <div class="container content">
            <div class="col-md-4 col-md-offset-4">	
                <div class="panel panel-default" id="login">
                    <div style="background-color: #4A6492; padding: 3px 10px;" class="panel-heading">
                        <img src="<?php echo IMAGEPATH; ?>logo-small.png">
                    </div>
                    <div class="panel-body">
                        <div>
                            <form id="login-form" name="loginForm" method="POST" action="<?php echo BASEPATH; ?>login2.php">
                                <div class="form-group">
                                    <label for="field-username">Username</label>
                                    <input type="text" autocorrect="off" autocapitalize="off" class="form-control" id="field-userName" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="login">Password</label>
                                    <input type="password" class="form-control" id="field-password" name="password">
                                </div>
                                <div>
                                    <button id="btn-login" class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.onload = function () {
                document.getElementById("field-userName").focus();
            }
        </script>
    </body>
</html>