<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wilayah;
class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $provinsi = Wilayah::create(['nama_wilayah' => 'Jawa Barat', 'level' => 'provinsi']);
        $kabupaten = Wilayah::create(['nama_wilayah' => 'Bandung', 'parent_id' => $provinsi->id, 'level' => 'kabupaten']);
        Wilayah::create(['nama_wilayah' => 'Cibiru', 'parent_id' => $kabupaten->id, 'level' => 'kecamatan']);
    }
}
