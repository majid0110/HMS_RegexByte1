<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'ID';

    // Function to fetch all roles with their corresponding module permissions
    public function getAllRolesWithPermissions()
    {
        // Fetch all roles
        $roles = $this->findAll();

        // Initialize an array to store roles with permissions
        $rolesWithPermissions = [];

        // Loop through each role
        foreach ($roles as $role) {
            // Fetch permissions for the current role
            $permissions = $this->getRolePermissions($role['ID']);
            // Add permissions to the role data
            $role['permissions'] = $permissions;
            // Add role with permissions to the array
            $rolesWithPermissions[] = $role;
        }

        return $rolesWithPermissions;
    }

    // Function to fetch permissions for a specific role
    public function getRolePermissions($roleId)
    {
        // Fetch permissions from role_permissions table based on role ID
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        $builder->select('*');
        $builder->where('roleID', $roleId);
        $permissions = $builder->get()->getResultArray();

        // Convert module IDs to module names
        $moduleNames = $this->getModuleNames();

        // Map module IDs to module names in permissions
        foreach ($permissions as &$permission) {
            $permission['module_name'] = $moduleNames[$permission['moduleID']];
        }

        return $permissions;
    }

    // Function to fetch module names
    protected function getModuleNames()
    {
        // Fetch module names from modules table
        $db = \Config\Database::connect();
        $builder = $db->table('modules');
        $builder->select('id, module_name');
        $modules = $builder->get()->getResultArray();

        // Initialize an empty array to store module names
        $moduleNames = [];

        // Map module IDs to module names
        foreach ($modules as $module) {
            $moduleNames[$module['id']] = $module['module_name'];
        }

        return $moduleNames;
    }
}
