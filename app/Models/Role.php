<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name'];

    /**
     * Users that belong to this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Human-friendly label for UI display in Spanish
     * without changing the technical value stored in the database.
     */
    public function getDisplayNameAttribute(): string
    {
        return match ($this->name) {
            'superadmin' => 'Super Administrador',
            'admin' => 'Administrador',
            'client' => 'Cliente',
            default => ucfirst(str_replace('_', ' ', $this->name)),
        };
    }
}