<?php
require_once dirname(__DIR__) . '/../../include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-roles.php';
require_once $include_directory . 'utils-role_permissions.php';
require_once $include_directory . 'utils-modules.php';

if (!empty($_POST)) {
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
        'rules' => array('name' => array('required' => true,
                'maxLength' => 100)
        ),
        'messages' => array('name' => array('required' => 'Please enter Role name',
                'maxLength' => 'Role name must be less than 100 characters')
        ),
    );

    $response = Validation::_initialize($array, $_POST);
    $roleId = (int) $_POST['roleId'];
    
    // if errors are there showing them to user
    if (!$response['valid']) {
        setSessionValue('errorMessage', showError($response));
        redirect('administration/modules/roles/edit.php?id=' . $roleId);
    } else {
        $fields = array();
        $fields['roleName'] = escapeString($_POST['name']);

        $where = array('roleId' => $roleId);
        // updating Source details now
        updateRoleDetails($fields, $where);

        $permissions = array();
        $moduleList = getAllModules();
        $cnt = 0;
        foreach ($moduleList as $module) {
            if ($_POST[$module['moduleName']] == 'enabled') {
                $permissions[$cnt]['moduleId'] = $module['moduleId'];
                $permissions[$cnt]['roleId'] = $roleId;
                $permissions[$cnt]['access'] = 1;
                $permissions[$cnt]['read'] = $_POST[$module['moduleName'] . '-read'];
                $permissions[$cnt]['edit'] = $_POST[$module['moduleName'] . '-edit'];
                $permissions[$cnt]['delete'] = $_POST[$module['moduleName'] . '-delete'];
                $cnt++;
            }
        }

        if (addRolePermissions($roleId, $permissions)) {
            redirect('administration/modules/roles/view.php?id=' . $roleId);
        }

        redirect('administration/modules/roles/view.php?id=' . $roleId);
    }
}