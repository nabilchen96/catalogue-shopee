<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Barang;
use Auth;

class BarangController extends Controller
{
    public function index()
    {
        $q = explode(' ', Request('q'));
        $barang = DB::table('barangs')->where('status', 'Aktif');


        foreach ($q as $keyword) {
            $barang = $barang->where('nama_barang', 'like', '%' . $keyword . '%');
        }

        // Append query parameters to pagination links
        $barang = $barang->orderBy('id', 'DESC')->get();

        return response()->json($barang);
    }
}
