<?php

namespace App\Support;

class PermissionsHelper
{
    public static function getFlattenPermissions(iterable $arrayOfPermissions, ?string $globalPrefix = null)
    {
        $handledPermissions = [];

        foreach ($arrayOfPermissions as $prefix => $permission) {
            $newPrefix = (! is_int($prefix))
                ? $globalPrefix.' '.$prefix
                : $globalPrefix;

            $implodedPermission = static::getImplodedPermissions($permission, $newPrefix);
            array_push($handledPermissions, ...$implodedPermission);
        }

        return $handledPermissions;
    }

    private static function getImplodedPermissions($permission, ?string $prefix)
    {
        if (is_iterable($permission)) {
            return static::getFlattenPermissions($permission, $prefix);
        }

        return [trim(trim((string) $prefix).' '.trim($permission))];
    }

    public static function getPermissionsByGroup(array $permissions): array
    {
        $formattedPermissions = [];

        foreach ($permissions as $permission) {
            $explodedPermission = explode(' ', $permission['name'], 2);

            if (count($explodedPermission) >= 2) {
                [$group, $permissionValue] = $explodedPermission;

                $formattedPermissions[$group][] = [
                    'id' => $permission['id'],
                    'name' => $permissionValue,
                ];
            }
        }

        return $formattedPermissions;
    }
}
