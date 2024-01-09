<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Pembelian;
use App\Models\Barang;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    public function index()
    {

        $tgl_awal = Request('tgl_awal');
        $tgl_akhir = Request('tgl_akhir');

        $pembelian = DB::table('pembelians as p')
                    ->join('barangs as b', 'b.id', '=', 'p.id_barang')
                    ->select(
                        'b.nama_barang', 
                        'b.foto_barang', 
                        'p.*'
                    );

        if ($tgl_awal && $tgl_akhir) {
            $pembelian = $pembelian
                ->whereBetween('p.tanggal_pembelian', [
                    $tgl_awal, $tgl_akhir
                ])
                ->orderBy('p.id', 'DESC')
                ->paginate(10);

        } else {
            
            $pembelian = $pembelian->orderBy('p.id', 'DESC')->paginate(10);
        }

        return view('backend.pembelian.index', [
            'pembelian' => $pembelian
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_pembelian' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //TAMBAH PEMBELIAN BARANG
            $data = Pembelian::create([
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'id_barang' => $request->id_barang, 
                'harga_beli_satuan' => $request->harga_beli_satuan, 
                'jumlah_pembelian' => $request->jumlah_pembelian,
                'keterangan' => $request->keterangan,
                'id_user' => Auth::id()
            ]);

            //TAMBAH STOK BARANG
            $barang = Barang::find($request->id_barang);
            $barang->update([
                'stok' => $barang->stok + $request->jumlah_pembelian
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

        //GET DATA PEMBELIAN
        $data = Pembelian::find($request->id);

        //GET DATA BARANG
        $barang = Barang::find($data->id_barang);

        //HAPUS STOK YANG SUDAH DITAMBAHKAN
        Barang::where('id', $data->id_barang)->update([
            'stok' => $data->jumlah_pembelian - $barang->stok
        ]);

        //HAPUS DATA PEMBELIAN
        $data->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
