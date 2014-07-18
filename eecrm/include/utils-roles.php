<?php

require_once 'database.php';

/**
 * Get all Role list those who are not deleted from the system
 * 
 * @global DB Object $db
 * @return mixed
 */
function getAllRoles($offset = 0, $limit = 10, $searchString = '') 
{
    global $db;
    $sqlQuery = "SELECT * FROM  
                 `roles` 
                 WHERE deleted = '0'";
    $stmt = $db->prepare($sqlQuery);
    
    $stmt->execute();
    $columns = $stmt->columnCount();
    if ($columns > 0) {
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return ($details) ? $details : NULL;
}

/**
 * Get role details according to the role id 
 * 
 * @global DB resource $db
 * @param integer $roleId
 * @return mixed
 */
function getRoleDetails($roleId) 
{
    global $db;
    
    $stmt = $db->prepare("SELECT * 
                          FROM `roles` 
                          WHERE roleId = :roleId");
    $stmt->bindParam(":roleId", $roleId);
    $stmt->execute();
    $rows = $stmt->columnCount();
    if ($rows > 0) {
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return ($details)? $details : NULL;
}

/**
 * Updating Role details according to the fields and where condition send 
 * by the script
 * 
 * @global DB Resource $db
 * @param array $fields
 * @param array $where
 * @return mixed
 */
function updateRoleDetails (Array $fields, Array $where) 
{
    global  $db;
    $sql = "UPDATE `roles` SET ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= "`".$key."` = :".$key;        
        if ($couter != $totalFields) {
            $sql.= ",";
        }
        
        $couter++;
    }
    $sql.= " WHERE ";
    $iterator = 1;
    $totalConditions = count($where);
    if ($where) {
        foreach ($where as $keyVar => $value) {
            $sql.= "  $keyVar = :$keyVar";
            if ($iterator !== $totalConditions) {
                $sql.= ",";
            }
            
            $iterator++;            
        }
    }
    
    $statement = $db->prepare($sql);
    foreach ($fields as $key => $fieldValue) {
        $statement->bindValue(":$key", $fieldValue);
    }
    
    foreach ($where as $condition => $conditionValue) {
        $statement->bindValue(":$condition", $conditionValue);
    }

    $statement->execute();
    $rowCount = $statement->rowCount();
    
    return ($rowCount)? $rowCount: NULL;
}

/**
 * Adding new Role.
 * 
 * @global DB Resource $db
 * @param array $fields
 * @return mixed
 */
function addNewRoleDetails (Array $fields) 
{
    global  $db;
    $sql = "INSERT INTO `roles` ( ";
    $couter = 1;
    $totalFields = count($fields);
    foreach ($fields as $key => $value) {
        $sql.= $key;        
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
    
    $statement = $db->prepare($sql);
    $statement->execute();
    $id  = $db->lastInsertId();
    
    return ($id)? $id : NULL;
}

/**
 * Get role list for selection of assingning Roles
 * 
 * @global DB Resource $db
 * @return mixed
 * @throws Exception
 */
function getRolesForAssigning() 
{
    global $db;
    $sqlQuery = "SELECT roleId as id, roleName as title
                 FROM `roles` 
                 WHERE `deleted` = '0' ORDER BY title ASC";
    try {
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute();
        $columns = $stmt->columnCount();
        if ($columns > 0) {
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($details)? $details : NULL;    
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}

/**
 * Adding Role Entities
 * 
 * @global DB Resource $db
 * @param array $roleIds
 * @param int $entityId Entity Id
 * @param string $entityType Type of Entity (User/Team)
 * @return void
 */
function addRoleEntity(Array $roleIds, $entityId, $entityType) {
    global $db;
    try {
        $stmt = $db->prepare("DELETE FROM `role_entity` 
                                     WHERE `entityId` = $entityId AND `entityType` = '$entityType'");
        if ($stmt->execute()) {
            foreach ($roleIds as $roleId) {
                $sql = "INSERT INTO `role_entity` ( 
                            `id`, `roleId`, `entityId`, `entityType`,`deleted`) 
                        VALUES (
                            NULL, '$roleId', '" . $entityId . "', '" . $entityType . "','0'
                        )";
                //echo $sql; exit;
                $statement = $db->prepare($sql);
                $statement->execute();
            }
        }
    } catch (Exception $exception) {
        //echo $sql; exit;
        throw new Exception($exception->getMessage());
    }
}


function getUserRoles($userId) {
    global $db;
    $sqlQuery = "SELECT r.`roleId`, r.`roleName`
                 FROM `roles` r
                 JOIN `role_entity` re ON re.`roleId` = r.`roleId`
                 WHERE re.`entityId` = '$userId' AND re.`entityType` = 'User' AND r.`deleted` = '0' 
                 ORDER BY r.roleName ASC";
    try {
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute();
        $columns = $stmt->columnCount();
        if ($columns > 0) {
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ($details)? $details : NULL;    
    } catch (Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}