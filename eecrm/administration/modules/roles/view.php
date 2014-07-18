<?php
require_once dirname(__DIR__) . '/../../common/header.php';
require_once $include_directory . 'utils-roles.php';
require_once $include_directory . 'utils-modules.php';
require_once $include_directory . 'utils-role_permissions.php';

if (!empty($_GET['id'])) {
    $rolesDetails = getRoleDetails($_GET['id']);
    $moduleList = getAllModules();
}
?>
<div class="container content">
    <div id="main">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-sm-7">
                    <h3><a href="<?php echo ADMINPATH;?>modules/roles/">Roles</a> <?php if($rolesDetails != NULL):?> &raquo; <?php echo $rolesDetails['roleName']; endif;?></h3>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <div class="header-buttons btn-group pull-right">
                    </div>
                </div>
            </div>
        </div>
        <div class="body"><div id="roles-detail" class="detail">
                <div class="detail-button-container button-container record-buttons">
                    <a href="<?php echo ADMINPATH?>modules/roles/edit.php?id=<?php echo $rolesDetails['roleId'];?>" data-action="edit" class="btn btn-primary">Edit</a>
                    <a data-module='roles' data-isadmin ='1' data-field='roleId' data-value='<?php echo $rolesDetails['roleId'];?>' data-action="delete" class="btn btn-danger delete-record">Delete</a>
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
                                                Role Name
                                            </label>
                                            <div class="field field-name">
                                                <?php echo ucfirst($rolesDetails['roleName']); ?>
                                            </div>
                                        </div>
                                    </div>			
                                </div>
                            </div>
                        </div>
                        <?php if (isset($moduleList)) : ?>
                        <div class="extra">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th>Access</th>
                                        <th>Read</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    <?php foreach ($moduleList as $module) :  
                                        $permissions = getModulePermissions($rolesDetails['roleId'], $module['moduleId']);
                                        ?>
                                    <tr>
                                        <td><b><?php echo $module['moduleName']; ?></b></td>
                                        <?php 
                                        $access = ($permissions != NULL && $permissions['access'] == 1) ? '<span style="color: #00CC00;">enabled</span>' : '<span style="color: #FF0000;">disabled</span>';
                                        ?>
                                        <td><?php echo $access; ?></td>
                                        <td><?php echo ($permissions['read']) ? getPermissionText($permissions['read']) : getPermissionText('no'); ?></td>
                                        <td><?php echo ($permissions['edit']) ? getPermissionText($permissions['edit']) : getPermissionText('no'); ?></td>
                                        <td><?php echo ($permissions['delete']) ? getPermissionText($permissions['delete']) : getPermissionText('no'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
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