<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_laporans', function (Blueprint $table) {
            $table->id();
            $table->integer('sandi_ljk')->nullable();
            $table->string('nama_ljk', 512)->nullable();
            $table->string('sandi_laporan', 512)->nullable();
            $table->string('jenis_laporan', 512)->nullable();
            $table->string('bulan', 512)->nullable();
            $table->string('kuartal', 512)->nullable();
            $table->string('semester', 512)->nullable();
            $table->integer('tahun')->nullable();
            $table->date('tgl_kejadian')->nullable();
            $table->string('status_submit_laporan', 512)->nullable();
            $table->date('tgl_upload')->nullable();
            $table->date('tgl_batas_akhir')->nullable();
            $table->string('versi_upload', 512)->nullable();
            $table->string('bukti_kirim', 512)->nullable();
            $table->integer('sisa_hari_pengumpulan')->nullable();
            $table->string('hampir_terlambat', 512)->nullable();
            $table->string('terlambat', 512)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_laporans');
    }
};
