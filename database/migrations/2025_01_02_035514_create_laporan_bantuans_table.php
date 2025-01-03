<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_bantuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_bantuans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('wilayah_id')->constrained('wilayahs')->onDelete('cascade');
            $table->integer('jumlah_penerima');
            $table->date('tanggal_penyaluran');
            $table->string('bukti_penyaluran');
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bantuans');
    }
};
