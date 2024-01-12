<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Harian;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HarianController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $harian = DB::table('harians');

        if ($q) {
            $harian = $harian->where('nama_pengurus', 'like', '%' . $q . '%')
                ->orWhere('masalah', 'like', '%' . $q . '%')
                ->orWhere('tindakan', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $harian = $harian->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.harian.index', [
            'harian' => $harian
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_harian' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Harian::create([
                'tanggal' => $request->tanggal, 
                'nama_pengurus' => $request->nama_pengurus, 
                'masalah' => $request->masalah, 
                'tindakan' => $request->tindakan, 
                'keterangan' => $request->keterangan,
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

            $agenda = Harian::find($request->id);
            $data = $agenda->update([
                'tanggal' => $request->tanggal, 
                'nama_pengurus' => $request->nama_pengurus, 
                'masalah' => $request->masalah, 
                'tindakan' => $request->tindakan, 
                'keterangan' => $request->keterangan,
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

        $data = Harian::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
