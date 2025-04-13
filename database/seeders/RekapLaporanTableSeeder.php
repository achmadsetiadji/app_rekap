<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RekapLaporanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Schema::disableForeignKeyConstraints();

      DB::table('rekap_laporans')->truncate();

      $rekap_laporan   = 'database/seeders/sql/rekap_laporan.sql';

      DB::unprepared(file_get_contents($rekap_laporan));
    }
}
