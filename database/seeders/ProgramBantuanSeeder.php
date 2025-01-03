<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\program_bantuan;
use Illuminate\Database\Seeder;

class ProgramBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        program_bantuan::create(['nama_program' => 'PKH']);
        program_bantuan::create(['nama_program' => 'BLT']);
        program_bantuan::create(['nama_program' => 'Bansos']);
    }
}
