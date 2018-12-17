<?php

namespace App\Support;

class PermissionsHelper
{
    private static function getImplodedPermissions($prefix, $permission)
    {
        if (is_int($prefix)) {
            return [$permission];
        }

        if (is_array($permission)) {
            $implodedPermissions = [];
            foreach ($permission as $index => $action) {
                $implodedPermissions[] = "{$prefix} {$action}";
            }
            return $implodedPermissions;
        }

        return ["{$prefix} {$permission}"];
    }

    public static function getFlattenPermissions($arrayOfPermissions)
    {
        $handled_permissions = [];
        foreach ($arrayOfPermissions as $prefix => $permission) {
            $imploded_permission = static::getImplodedPermissions($prefix, $permission);
            $handled_permissions = array_merge($handled_permissions, $imploded_permission);
        }
        return $handled_permissions;
    }
}
