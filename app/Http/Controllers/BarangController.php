<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Barang;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
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

        return view('backend.barang.index', [
            'barang' => $barang
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //UPLOAD foto_barang
            if ($request->foto_barang) {
                $foto_barang = $request->foto_barang;
                $nama_foto_barang = '1' . date('YmdHis.') . $foto_barang->extension();
                $foto_barang->move('foto_barang', $nama_foto_barang);
            }

            $data = Barang::create([
                'nama_barang' => $request->nama_barang,
                'keterangan' => $request->keterangan,
                // 'harga_beli' => $request->harga_beli, 
                // 'harga_jual' => $request->harga_jual,
                'foto_barang' => $nama_foto_barang ?? '',
                'id_user' => Auth::id()
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //UPLOAD foto_barang
            if ($request->foto_barang) {
                $foto_barang = $request->foto_barang;
                $nama_foto_barang = '1' . date('YmdHis.') . $foto_barang->extension();
                $foto_barang->move('foto_barang', $nama_foto_barang);
            }

            $data = Barang::find($request->id);
            $data = $data->update([
                'nama_barang' => $request->nama_barang,
                'keterangan' => $request->keterangan,
                // 'harga_beli' => $request->harga_beli, 
                // 'harga_jual' => $request->harga_jual,
                'foto_barang' => $nama_foto_barang ?? $data->foto_barang,
                'id_user' => Auth::id(),
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Barang::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
