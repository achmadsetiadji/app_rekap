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
        Schema::create('rekap_laporan_details', function (Blueprint $table) {
            $table->id();
            $table->string('periodasi', 512);
            $table->string('kategori', 512);
            $table->string('nama_laporan', 512);
            $table->text('deadline_pengiriman');
            $table->string('ketentuan_pojk', 512);
            $table->string('ketentuan_pasal', 512);
            $table->text('sanksi');
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
        Schema::dropIfExists('rekap_laporan_details');
    }
};
