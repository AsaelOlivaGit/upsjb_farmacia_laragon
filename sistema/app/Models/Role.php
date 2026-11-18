<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description'])]
class Role extends Model
{
    // Relación: Rol 1 -- 0..* Usuario (la FK en users se llama rol_id)
    public function users(): HasMany
    {
    return $this->hasMany(User::class, 'rol_id');

    }
}
