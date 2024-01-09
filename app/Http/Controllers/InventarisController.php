<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Inventaris;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InventarisController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $inventaris = DB::table('inventaris');

        if ($q) {
            $inventaris = $inventaris->where('kode_inventaris', 'like', '%' . $q . '%')
                ->orWhere('nama_barang', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orWhere('tempat', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $inventaris = $inventaris->orderBy('id', 'DESC')->get();
        }

        return view('backend.inventaris.index', [
            'inventaris' => $inventaris
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

            //UPLOAD FOTO
            if ($request->foto) {
                $foto = $request->foto;
                $nama_foto = '1' . date('YmdHis.') . $foto->extension();
                $foto->move('foto', $nama_foto);
            }

            $data = Inventaris::create([
                'kode_inventaris' => $request->kode_inventaris,
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tempat' => $request->tempat,
                'foto' => $nama_foto ?? '',
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

            //UPLOAD FOTO
            if ($request->foto) {
                $foto = $request->foto;
                $nama_foto = '1' . date('YmdHis.') . $foto->extension();
                $foto->move('foto', $nama_foto);
            }

            $surat_masuk = Inventaris::find($request->id);
            $data = $surat_masuk->update([
                'kode_inventaris' => $request->kode_inventaris,
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tempat' => $request->tempat,
                'foto' => $nama_foto ?? $surat_masuk->foto,
                'id_user' => Auth::id()
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

        $data = Inventaris::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
