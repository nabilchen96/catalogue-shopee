<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $anggota = DB::table('anggotas')->count();
        $agenda = DB::table('agendas')->where('tanggal_selesai', '>', date('Y-m-d'))->count();
        $penjualan = DB::table('penjualans')
            ->whereMonth('tanggal_penjualan', Carbon::now()->month)
            ->whereYear('tanggal_penjualan', Carbon::now()->year)
            ->sum('uang_konsumen');

        $cicilan = DB::table('cicilans as c')
            ->join('penjualans as p', 'p.id', '=', 'c.id_penjualan')
            ->join('barangs as b', 'b.id', '=', 'p.id_barang')
            ->select('p.*', 'b.nama_barang', 'c.total_cicilan')
            ->whereIn('c.id', function ($query) {
                $query
                    ->select(DB::raw('MAX(id)'))
                    ->from('cicilans')
                    ->groupBy('id_penjualan');
            })
            ->whereNotIn('total_cicilan', [
                0
            ])
            ->orderBy('c.id', 'DESC')
            ->sum('total_cicilan');

        return view('backend.dashboard', [
            'anggota' => $anggota,
            'agenda' => $agenda,
            'penjualan' => $penjualan,
            'cicilan' => $cicilan
        ]);
    }
}