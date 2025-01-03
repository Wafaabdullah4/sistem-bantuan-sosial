<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifikasi extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'laporan_id', 'pesan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporan()
    {
        return $this->belongsTo(laporan_bantuan::class);
    }
}
