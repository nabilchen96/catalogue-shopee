<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\FotoKegiatan;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FotoKegiatanController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $data = DB::table('foto_kegiatans');

        if ($q) {
            $data = $data->Where('nama_kegiatan', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $data = $data->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.foto_kegiatan.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //UPLOAD FOTO
            if ($request->foto_kegiatan) {
                $foto_kegiatan = $request->foto_kegiatan;
                $nama_foto_kegiatan = '1' . date('YmdHis.') . $foto_kegiatan->extension();
                $foto_kegiatan->move('foto_kegiatan', $nama_foto_kegiatan);
            }

            $data = FotoKegiatan::create([
                'nama_kegiatan' => $request->nama_kegiatan,
                'foto_kegiatan' => $nama_foto_kegiatan ?? '',
                'id_user' => Auth::id()
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

        $data = FotoKegiatan::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
