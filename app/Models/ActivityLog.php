<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika berbeda dengan nama model
    protected $table = 'activity_logs';

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'tabel_referensi',
        'id_referensi',
        'deskripsi',
    ];

    // Mengatur agar created_at dan updated_at otomatis dikelola oleh Carbon
    protected $dates = ['created_at', 'updated_at'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
