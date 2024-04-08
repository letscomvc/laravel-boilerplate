<?php

namespace App\Domain\Shared\Services\LaravelPermissions;

use Database\Factories\Domain\Shared\Services\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $guarded = [];

    public static function newFactory()
    {
        return RoleFactory::new();
    }
}
