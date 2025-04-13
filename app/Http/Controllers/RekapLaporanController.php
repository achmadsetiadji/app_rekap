<?php

namespace App\Http\Controllers;

use App\Models\RekapLaporan;
use App\Models\RekapLaporanDetail;
use Illuminate\Http\Request;

class RekapLaporanController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Count for statuses
    $tepat_waktu = RekapLaporan::where('status_submit_laporan', 'Tepat Waktu')->count();
    $terkirim = RekapLaporan::where('status_submit_laporan', 'Terkirim')->count();
    $terlambat = RekapLaporan::where('status_submit_laporan', 'Terlambat')->count();
    $tidak_lapor = RekapLaporan::where('status_submit_laporan', 'Tidak Lapor')->count();

    // Fetch "Hampir Terlambat" records
    $hampir_terlambat_data = RekapLaporan::where('status_submit_laporan', 'Tidak Lapor') // Only consider "Tidak Lapor"
      ->whereNotNull('tgl_batas_akhir') // Ensure tgl_batas_akhir is not null
      ->whereRaw('ABS(DATEDIFF(tgl_batas_akhir, CURDATE())) <= 5') // Difference <= 5 days (absolute value)
      ->get(); // Get all matching records

    return view('rekap_laporan.index', compact(
      'tepat_waktu',
      'terkirim',
      'terlambat',
      'tidak_lapor',
      'hampir_terlambat_data'
    ));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function data(Request $request)
  {
    $data = RekapLaporan::select('nama_ljk')->distinct();

    return datatables()->of($data)
      ->addIndexColumn()
      ->addColumn('action', function ($data) {
        $url = route('rekap_laporan.show', ['nama_ljk' => $data->nama_ljk]);

        $button = '
            <a href="' . $url . '" class="btn btn-warning text-white">
                <i class="fa-solid fa-pen"></i> Detail
            </a>
        ';

        return $button;
      })
      ->rawColumns(['action']) // <--- use rawColumns to render HTML
      ->make(true);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($nama_ljk)
  {
    $rekap_laporan = RekapLaporan::where('nama_ljk', $nama_ljk)->first();

    return view('rekap_laporan.show', compact('rekap_laporan'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function show_data(Request $request, $nama_ljk)
  {
    $data = RekapLaporan::where('nama_ljk', $nama_ljk);

    return datatables()->of($data)
      ->addIndexColumn()
      ->addColumn('status_submit_laporan', function ($data) {
        // Initialize status badges array
        $badges = [];

        // Get the current status from the database
        $status = $data->status_submit_laporan;

        // Add the initial badge based on the status
        $badgeClass = match ($status) {
          'Terlambat'     => 'danger',
          'Tidak Lapor'   => 'warning', // Bootstrap uses "warning" for orange
          'Tepat Waktu'   => 'success',
          'Terkirim'      => 'info',
          default         => 'secondary', // fallback
        };

        // Add the initial badge to the badges array
        $badges[] = '<span class="text-white font-weight-bold badge badge-' . $badgeClass . '">' . $status . '</span>';

        // Check if the report is "Hampir Terlambat"
        $currentDate = now(); // Current date and time
        $dueDate = \Carbon\Carbon::parse($data->tgl_batas_akhir); // Due date from the database

        if ($status === 'Tidak Lapor' && $currentDate->diffInDays($dueDate, false) <= 5 && $currentDate->lessThan($dueDate)) {
          // Add the "Hampir Terlambat" badge
          $badges[] = '<span class="text-white font-weight-bold badge" style="background-color: orange;">Hampir Terlambat</span>';
        }

        // Combine all badges into a single string
        return implode(' ', $badges);
      })
      ->addColumn('action', function ($data) {
        return '
            <button class="btn btn-warning text-white open-modal-btn" data-jenis_laporan="' . e($data->jenis_laporan) . '"
              data-status_submit_laporan="' . e($data->status_submit_laporan) . '">
                <i class="fa-solid fa-pen"></i> Detail
            </button>
        ';
      })
      ->rawColumns(['action', 'status_submit_laporan'])
      ->make(true);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show_detail($jenis_laporan)
  {
    $rekap_laporan_detail = RekapLaporanDetail::where('nama_laporan', $jenis_laporan)->first();

    return response()->json($rekap_laporan_detail);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show_hampir_terlambat()
  {
    return view('rekap_laporan.show_hampir_terlambat');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function show_hampir_terlambat_data(Request $request)
  {
    $data = RekapLaporan::join('rekap_laporan_details', 'rekap_laporans.jenis_laporan', '=', 'rekap_laporan_details.nama_laporan')
      ->where('rekap_laporans.status_submit_laporan', 'Tidak Lapor') // Only consider "Tidak Lapor"
      ->whereNotNull('rekap_laporans.tgl_batas_akhir') // Ensure tgl_batas_akhir is not null
      ->whereRaw('ABS(DATEDIFF(rekap_laporans.tgl_batas_akhir, CURDATE())) <= 5') // Difference <= 5 days (absolute value)
      ->select('rekap_laporans.*', 'rekap_laporan_details.*') // Select all columns from both tables
      ->get(); // Get all matching records

    return datatables()->of($data)
      ->addIndexColumn()
      ->addColumn('status_submit_laporan', function ($data) {
        // Initialize status badges array
        $badges = [];

        // Get the current status from the database
        $status = $data->status_submit_laporan;

        // Add the initial badge based on the status
        $badgeClass = match ($status) {
          'Terlambat'     => 'danger',
          'Tidak Lapor'   => 'warning', // Bootstrap uses "warning" for orange
          'Tepat Waktu'   => 'success',
          'Terkirim'      => 'info',
          default         => 'secondary', // fallback
        };

        // Add the initial badge to the badges array
        $badges[] = '<span class="text-white font-weight-bold badge badge-' . $badgeClass . '">' . $status . '</span>';

        // Check if the report is "Hampir Terlambat"
        $currentDate = now(); // Current date and time
        $dueDate = \Carbon\Carbon::parse($data->tgl_batas_akhir); // Due date from the database

        if ($status === 'Tidak Lapor' && $currentDate->diffInDays($dueDate, false) <= 5 && $currentDate->lessThan($dueDate)) {
          // Add the "Hampir Terlambat" badge
          $badges[] = '<span class="text-white font-weight-bold badge" style="background-color: orange;">Hampir Terlambat</span>';
        }

        // Combine all badges into a single string
        return implode(' ', $badges);
      })
      ->addColumn('action', function ($data) {
        return '
            <button class="btn btn-warning text-white open-modal-btn" data-jenis_laporan="' . e($data->jenis_laporan) . '"
              data-status_submit_laporan="' . e($data->status_submit_laporan) . '">
                <i class="fa-solid fa-pen"></i> Detail
            </button>
        ';
      })
      ->rawColumns(['action', 'status_submit_laporan'])
      ->make(true);
  }
}
