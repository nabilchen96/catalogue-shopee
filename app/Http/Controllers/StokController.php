<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Agenda;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $barang = DB::table('barangs');

        if ($q) {
            $barang = $barang->where('nama_barang', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $barang = $barang->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.stok.index', [
            'barang' => $barang
        ]);
    }

    public function exportPdf(){

        ini_set('max_execution_time', 600);

        $q = Request('q');
        $barang = DB::table('barangs');

        if ($q) {
            $barang = $barang->where('nama_barang', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $barang = $barang->orderBy('id', 'DESC')->get();
        }

        $data = PDF::loadview('backend.stok.export_pdf', [
            'stok' => $barang, 
        ]);

    	return $data->download('laporan.pdf');
    }
}
