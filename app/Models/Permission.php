<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';  // Pastikan ini sesuai dengan nama tabel

    protected $fillable = ['name'];

    /**
     * Relasi ke tabel roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
    
}
