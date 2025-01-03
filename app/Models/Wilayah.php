<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = ['nama_wilayah', 'parent_id', 'level'];

    public function parent()
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function laporanBantuan()
    {
        return $this->hasMany(laporan_bantuan::class, 'wilayah_id', 'id'); 
    }

    public function getTotalPenerimaAttribute()
    {
        $total = $this->laporanBantuan()->where('status', 'disetujui')->sum('jumlah_penerima');
    
        foreach ($this->children as $child) {
            $total += $child->total_penerima; 
        }
    
        return $total;
    }
    
}
