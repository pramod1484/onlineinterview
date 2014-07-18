<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-roles.php';
require_once $include_directory . 'utils-modules.php';
$moduleList = getAllModules();
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; left: 640px;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH; ?>modules/roles/">Roles</a> &raquo; create</h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>

        </div>
        <div class="body">
            <div id="roles-edit" class="edit">
                <form id="form-roles-edit" name="frmRole" method="POST" action="<?php echo ADMINPATH; ?>modules/roles/new.php">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH; ?>modules/roles/" data-action="cancel" class="btn btn-default">Cancel</a>		
                </div>
                <div style="height: 21px; display: none;">&nbsp;</div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group">
                                                <label class="field-label-name control-label">
                                                    Role Name &ast;
                                                </label>
                                                <div class="field field-name">
                                                    <input type="text" maxlength="100" value="" name="name" class="main-element form-control">
                                                </div>
                                            </div>
                                        </div>			
                                    </div>
                                </div>

                            </div>
                            <div class="extra">	
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>Access</th>
                                        <th>Read</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    <?php foreach ($moduleList as $module): ?>
                                    <tr>
                                        <td><b><?php echo $module['moduleName']; ?></b></td>
                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>" class="form-control module-access" data-type="access">
                                                <option value="not-set" selected="">not-set</option>
                                                <option value="enabled">enabled</option>
                                                <option value="disabled">disabled</option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-read" class="form-control <?php echo $module['moduleName']; ?>-permission" disabled="">
                                                <?php echo htmlSelectOptions(getPermissionOptions()); ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-edit" class="form-control <?php echo $module['moduleName']; ?>-permission" disabled="">
                                                <?php echo htmlSelectOptions(getPermissionOptions()); ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-delete" class="form-control <?php echo $module['moduleName']; ?>-permission" disabled="">
                                                <?php echo htmlSelectOptions(getPermissionOptions()); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            
                            </div>
                            <div class="bottom"></div>
                        </div>
                        				
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.module-access').change(function () {
           var moduleClass = '.' + $(this).attr('name') + '-permission';
           if ($(this).val() == 'enabled') {
               $(moduleClass).prop('disabled', false);
           } else {
               $(moduleClass).prop('disabled', true);
           }
        });
    });
</script>
<?php
require_once dirname(__DIR__) . '/../../common/footer.php';
?>
