<?php

/*
 * Class userPermissions to get user permissions 
 * and check permissions for module by user id or role id.
 */
class userPermissions {

    var $userId;
    var $roles;
    var $roleNames;
    var $db;

    public function __construct($userId) {
        global $db;
        $this->userId = $userId;
        $this->db = $db;
        $this->getUserRoles();
    }

    private function getUserRoles() {
        $stmt = $this->db->prepare("SELECT re.roleId, r.roleName
                              FROM `role_entity` AS re
                              JOIN `roles` r ON r.roleId = re.roleId
                              WHERE re.entityId = $this->userId 
                                  AND re.entityType = 'User'");
        $stmt->execute();
        $rows = $stmt->columnCount();
        if ($rows > 0) {
            while($role = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->roles[] = $role['roleId'];
                $this->roleNames[$role['roleId']] = $role['roleName'];
            }
        }
    }
    
    public function getRoleName($roleId) {
        return $this->roleNames[$roleId];
    }

}
?>
