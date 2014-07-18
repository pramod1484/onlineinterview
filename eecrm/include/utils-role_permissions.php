<?php

require_once 'database.php';

/**
 * Get all Role Permission list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllRolePermissions($roleId, $offset = 0, $limit = 10) 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 `role_permissions` 
                 WHERE roleId = :roleId";
    $stmt->bindParam(":roleId", $roleId);
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Get module permissions of role to the role id and module id
 * 
 * @global DB resource $db
 * @param integer $roleId
 * @param integer $modId
 * @return mixed
 */
function getModulePermissions($roleId, $modId) {
    global $db;
    
    $stmt = $db->prepare("SELECT * 
                          FROM `role_permissions` 
                          WHERE moduleId = :moduleId 
                          AND roleId = :roleId");
    $stmt->bindParam(":moduleId", $modId);
    $stmt->bindParam(":roleId", $roleId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Add Module Permissions for a role
 * 
 * @global DB resource $db
 * @param int $roleId Role Id
 * @param array $modulePermissions Array of Module Permissions 
 * @return boolean Returns true
 */
function addRolePermissions($roleId, Array $modulePermissions) {
    global $db;

    $stmt = $db->prepare("DELETE 
                          FROM `role_permissions` 
                          WHERE roleId = :roleId");
    $stmt->bindParam(":roleId", $roleId);
    $stmt->execute();
    foreach ($modulePermissions as $permissions) {
        $fields = array();
        $fields['moduleId'] = $permissions['moduleId'];
        $fields['roleId'] = $permissions['roleId'];
        $fields['access'] = $permissions['access'];
        $fields['read'] = $permissions['read'];
        $fields['edit'] = $permissions['edit'];
        $fields['delete'] = $permissions['delete'];
        addNewPermissions($fields);
    }
    
    return true;
}

/**
 * Adding new Role Permissions.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewPermissions (Array $fields) {
    global  $db;
    $sql = "INSERT INTO `role_permissions` ( ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= "`$key`";        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    
    $sql .= ") VALUES (";
    $iterator = 1;
    foreach ($fields as $keyVar => $value) {
        $sql.= "'$value'";
        if ($iterator !== $totalFields) {
            $sql.= ",";
        }

        $iterator++;            
    }
    $sql .= ")";
    //echo $sql; exit;
    $statement = $db->prepare($sql);
    $statement->execute();
    $id  = $db->lastInsertId();
    
    return ($id)? $id : NULL;
}