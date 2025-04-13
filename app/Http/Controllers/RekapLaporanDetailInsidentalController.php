<?php

namespace App\Http\Controllers;

use App\Models\RekapLaporanDetail;
use Illuminate\Http\Request;

class RekapLaporanDetailInsidentalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('rekap_laporan.detail.insidental.index');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function data(Request $request)
  {
    $data = RekapLaporanDetail::whereIn('periodasi', ['Insidental']);

    return datatables()->of($data)
      ->addIndexColumn()
      ->rawColumns([])
      ->make(true);
  }
}
