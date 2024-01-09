<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Penjualan;
use App\Models\Cicilan;
use App\Models\Barang;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {

        $tgl_awal = Request('tgl_awal');
        $tgl_akhir = Request('tgl_akhir');

        $penjualan = DB::table('penjualans as p')
            ->join('barangs as b', 'b.id', '=', 'p.id_barang')
            ->select(
                'b.nama_barang',
                'b.foto_barang',
                'p.*'
            );

        if ($tgl_awal && $tgl_akhir) {
            $penjualan = $penjualan
                ->whereBetween('p.tanggal_penjualan', [
                    $tgl_awal,
                    $tgl_akhir
                ])
                ->orderBy('p.id', 'DESC')
                ->get();

        } else {

            $penjualan = $penjualan->orderBy('p.id', 'DESC')->get();
        }

        // dd($penjualan);

        return view('backend.penjualan.index', [
            'penjualan' => $penjualan
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_penjualan' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //SIMPAN DATA PENJUALAN
            $data = Penjualan::create([
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'id_barang' => $request->id_barang,
                'harga_modal' => $request->harga_modal,
                'jumlah_penjualan' => $request->jumlah_penjualan,
                'harga_jual' => $request->harga_jual,
                'keterangan' => $request->keterangan,
                'nama_konsumen' => $request->nama_konsumen,
                'uang_konsumen' => $request->uang_konsumen,
                'id_user' => Auth::id()
            ]);

            //SIMPAN DATA KREDIT
            if(($request->harga_jual * $request->jumlah_penjualan) >= $request->uang_konsumen){
                Cicilan::create([
                    'id_penjualan' => $data->id, 
                    'total_cicilan' => ($request->harga_jual * $request->jumlah_penjualan) - $request->uang_konsumen,
                    'angsuran' => 0,
                    'tanggal_angsuran' => $request->tanggal_penjualan,
                    'id_user' => Auth::id()
                ]);
            }

            //KURANGI STOK BARANG
            $barang = Barang::find($request->id_barang);
            $barang->update([
                'stok' => $barang->stok - $request->jumlah_penjualan
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        //GET DATA PENJUALAN
        $data = Penjualan::find($request->id);

        //GET DATA BARANG
        $barang = Barang::find($data->id_barang);

        //EDIT STOK YANG SUDAH DITAMBAHKAN
        Barang::where('id', $data->id_barang)->update([
            'stok' => $barang->stok + $data->jumlah_penjualan
        ]);

        //HAPUS DATA KREDIT
        Cicilan::where('id_penjualan', $data->id_penjualan)->delete();

        //HAPUS DATA PENJUALAN
        $data->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
