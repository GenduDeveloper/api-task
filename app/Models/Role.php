<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const USER_ROLE_ID = 1;
    const ADMIN_ROLE_ID = 2;
    const MANAGER_ROLE_ID = 3;

    protected $table = 'roles';

    protected $fillable = [
        'role'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
