<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Permission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'umur',
        'jenis_kelamin',
        'alamat',
        'gambar_profil',
        'email_verified_at', // Tambahkan ini
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke model Role.
     */

    public function transactions()
    {
        return $this->hasMany(Transaction::class); // Sesuaikan dengan nama model transaksi
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isCustomer(): bool
    {
        return $this->role_id === 2;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function rolePermissions()
    {
        return $this->role->permissions();
    }

    public function hasPermission($permissionName)
    {
        // Cek izin langsung
        if ($this->permissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        // Cek izin melalui role
        if ($this->role && $this->role->permissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        return false;
    }
}
