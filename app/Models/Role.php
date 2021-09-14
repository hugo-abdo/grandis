<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function canSee()
    {
        return $this->belongsToMany(role::class, null, null, 'can_see_role');
    }
}
