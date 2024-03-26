<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['role_name', 'role_description', 'businessID'];

    public function getAllRolesWithPermissions()
    {
        $roles = $this->findAll();
        $rolesWithPermissions = [];
        foreach ($roles as $role) {
            $permissions = $this->getRolePermissions($role['ID']);
            $role['permissions'] = $permissions;
            $rolesWithPermissions[] = $role;
        }

        return $rolesWithPermissions;
    }

    public function getRolePermissions($roleId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        $builder->select('*');
        $builder->where('roleID', $roleId);
        $permissions = $builder->get()->getResultArray();
        $moduleNames = $this->getModuleNames();
        foreach ($permissions as &$permission) {
            $permission['module_name'] = $moduleNames[$permission['moduleID']];
        }

        return $permissions;
    }
    protected function getModuleNames()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modules');
        $builder->select('id, module_name');
        $modules = $builder->get()->getResultArray();
        $moduleNames = [];
        foreach ($modules as $module) {
            $moduleNames[$module['id']] = $module['module_name'];
        }

        return $moduleNames;
    }

    public function deleteRolePermissions($roleID)
    {
        $db = db_connect();
        $db->transStart();

        try {
            $db->table('role_permissions')->where('roleID', $roleID)->delete();
            $db->transCommit();
        } catch (\Exception $e) {
            $db->transRollback();
            throw $e;
        }
    }

}
