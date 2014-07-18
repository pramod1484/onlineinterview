<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-roles.php';
require_once $include_directory . 'utils-modules.php';
require_once $include_directory . 'utils-role_permissions.php';

if (!empty($_GET['id'])) {
    $rolesDetails = getRoleDetails($_GET['id']);
    $moduleList = getAllModules();
}
$errorMessage = getSessionValue('errorMessage');
if ($errorMessage != '') { ?>
    <div  style="position: fixed; top: 0px; z-index: 2000; margin: 0 auto;" class="alert alert-danger " id="notification">
     <?php echo $errorMessage; ?>   
    </div>
<?php removeSessionValue('errorMessage'); } ?>
<div class="container content">
    <div id="main">
        <div class="page-header"><div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3>
                        <a href="<?php echo ADMINPATH;?>modules/roles/">Roles</a>
                        <?php if ($rolesDetails) :?>
                         &raquo; <?php echo $rolesDetails['roleName']; ?>
                        <?php endif;?>
                    </h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div id="user-edit" class="edit">
                <form id="form-roles-edit" name="rolesEditForm" action="<?php echo ADMINPATH;?>modules/roles/save.php" method="POST">
                <div class="detail-button-container button-container record-buttons">
                    <button type="submit" data-action="save" class="btn btn-primary">Save</button>		
                    <a href="<?php echo ADMINPATH;?>modules/roles/view.php?id=<?php echo $rolesDetails['roleId']; ?>" data-action="cancel" class="btn btn-default">Cancel</a>		
                </div>
                    <div class="row">
                        <div class=" col-md-8">
                            <div class="record">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h4 class="panel-title">Overview</h4></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="cell cell-name  col-sm-6  form-group"><a class="pull-right inline-edit-link hide" href="javascript:"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <label class="field-label-name control-label">
                                                    Role Name
                                                </label>
                                                <div class="field field-name">
                                                    <input type="text" maxlength="100" value="<?php echo ucfirst(sanitizeString($rolesDetails['roleName'])); ?>" name="name" class="main-element form-control">
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
                                    <?php foreach ($moduleList as $module) : 
                                        $permissions = getModulePermissions($rolesDetails['roleId'], $module['moduleId']);
                                    
                                        if ($permissions != NULL) :
                                            if ($permissions['access'] == 1) :
                                                $accessDisabled = '';
                                                $accessEnabled = 'selected="selected"';
                                                $disabled = '';
                                            else :
                                                $accessDisabled = 'selected="selected"';
                                                $accessEnabled = '';
                                                $disabled = 'disabled=""';
                                            endif;
                                            
                                            $read = $permissions['read'];
                                            $edit = $permissions['edit'];
                                            $delete = $permissions['delete'];
                                        else:
                                            $accessDisabled = 'selected="selected"';
                                            $accessEnabled = '';
                                            $read = $edit = $delete = '';
                                            $disabled = 'disabled=""';
                                        endif;
                                        
                                    ?>
                                    <tr>
                                        <td><b><?php echo $module['moduleName']; ?></b></td>
                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>" class="form-control module-access" data-type="access">
                                                <option value="not-set">not-set</option>
                                                <option value="enabled" <?php echo $accessEnabled; ?>>enabled</option>
                                                <option value="disabled" <?php echo $accessDisabled; ?>>disabled</option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-read" class="form-control <?php echo $module['moduleName']; ?>-permission" <?php echo $disabled; ?>>
                                                <?php echo htmlSelectOptions(getPermissionOptions(), $read); ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-edit" class="form-control <?php echo $module['moduleName']; ?>-permission" <?php echo $disabled; ?>>
                                                <?php echo htmlSelectOptions(getPermissionOptions(), $edit); ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="<?php echo $module['moduleName']; ?>-delete" class="form-control <?php echo $module['moduleName']; ?>-permission" <?php echo $disabled; ?>>
                                                <?php echo htmlSelectOptions(getPermissionOptions(), $delete); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            
                            </div>
                            
                        </div>
                        
                    </div>
                    <input type="hidden" name="roleId" id="roleId" value="<?php echo $_GET['id'];?>" />
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
