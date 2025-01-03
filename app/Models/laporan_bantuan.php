<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporan_bantuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'user_id',
        'wilayah_id',
        'jumlah_penerima',
        'tanggal_penyaluran',
        'bukti_penyaluran',
        'catatan',
        'status',
        'alasan_penolakan'
    ];

    public function program()
    {
        return $this->belongsTo(program_bantuan::class, 'program_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
