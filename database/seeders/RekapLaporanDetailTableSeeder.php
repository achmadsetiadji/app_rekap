<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RekapLaporanDetailTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Schema::disableForeignKeyConstraints();

    DB::table('rekap_laporan_details')->truncate();    

    $rekap_laporan_detail   = 'database/seeders/sql/rekap_laporan_detail.sql';
    $rekap_laporan_detail_insidental  = 'database/seeders/sql/rekap_laporan_detail_insidental.sql';    

    DB::unprepared(file_get_contents($rekap_laporan_detail));
    DB::unprepared(file_get_contents($rekap_laporan_detail_insidental));
  }
}
