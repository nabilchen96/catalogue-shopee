<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Anggota;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $anggota = DB::table('anggotas');

        if ($q) {
            $anggota = $anggota->where('no_anggota', 'like', '%' . $q . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $q . '%')
                ->orWhere('jabatan', 'like', '%' . $q . '%')
                ->orWhere('tempat_lahir', 'like', '%' . $q . '%')
                ->orWhere('tanggal_lahir', 'like', '%' . $q . '%')
                ->orWhere('tanggal_lahir', 'like', '%' . $q . '%')
                ->orWhere('alamat', 'like', '%' . $q . '%')
                ->orWhere('no_telp', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orWhere('agama', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $anggota = $anggota->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.anggota.index', [
            'anggota' => $anggota
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Anggota::create([
                'no_anggota' => $request->no_anggota,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'tempat_lahir' => $request->tempat_lahir, 
                'tanggal_lahir' => $request->tanggal_lahir, 
                'agama' => $request->agama, 
                'alamat' => $request->alamat, 
                'no_telp' => $request->no_telp, 
                'foto' => 'foto', 
                'keterangan' => $request->keterangan, 
                'password' => $request->password,
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

            $anggota = Anggota::find($request->id);
            $data = $anggota->update([
                'no_anggota' => $request->no_anggota,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'tempat_lahir' => $request->tempat_lahir, 
                'tanggal_lahir' => $request->tanggal_lahir, 
                'agama' => $request->agama, 
                'alamat' => $request->alamat, 
                'no_telp' => $request->no_telp, 
                'foto' => 'foto', 
                'keterangan' => $request->keterangan, 
                'password' => $request->password
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

        $data = Anggota::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
