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
    $tepat_waktu = RekapLaporan::where('status_submit_laporan', 'Tepat Waktu')->count();
    $terkirim = RekapLaporan::where('status_submit_laporan', 'Terkirim')->count();
    $terlambat = RekapLaporan::where('status_submit_laporan', 'Terlambat')->count();
    $tidak_lapor = RekapLaporan::where('status_submit_laporan', 'Tidak Lapor')->count();

    return view('rekap_laporan.index', compact('tepat_waktu', 'terkirim', 'terlambat', 'tidak_lapor'));
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
        $status = $data->status_submit_laporan;

        $badgeClass = match ($status) {
          'Terlambat'     => 'danger',
          'Tidak Lapor'   => 'warning', // Bootstrap uses "warning" instead of "orange"
          'Tepat Waktu'   => 'success',
          'Terkirim'      => 'info',
          default         => 'secondary', // fallback
        };

        return '<span class="text-white font-weight-bold badge badge-' . $badgeClass . '">' . $status . '</span>';
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
}
