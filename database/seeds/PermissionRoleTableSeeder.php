<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        //superadmin permission
        $superadmin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($superadmin_permissions->pluck('id'));
        //end superadmin permission
        
        //support staff permission
        $support_staff_permissions = $superadmin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 13) != 'company_user_' && substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 5) != 'role_';
        });
        Role::findOrFail(2)->permissions()->sync($support_staff_permissions->pluck('id'));
        //end support staff permission

        //company admin permissions
        $company_admin_permissions = $superadmin_permissions->filter(function ($permission) {
            return (substr($permission->title, 0, 5) != 'user_' || $permission->title === 'user_management_access' ) && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 4) != 'log_' && substr($permission->title, 0, 8) != 'refdata_' && substr($permission->title, 0, 13) != 'refdatafield_' && substr($permission->title, 0, 8) != 'doctype_' && substr($permission->title, 0, 18) != 'doctype_management';
        });
        //end company admin permissions
        Role::findOrFail(3)->permissions()->sync($company_admin_permissions->pluck('id'));
    }
}
