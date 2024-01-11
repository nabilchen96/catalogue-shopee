<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\NotulenRapat;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class NotulenRapatController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $data = DB::table('notulen_rapats');

        if ($q) {
            $data = $data->where('tanggal_rapat', $q)
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $data = $data->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.notulen_rapat.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_rapat' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = NotulenRapat::create([
                'tanggal_rapat' => $request->tanggal_rapat,
                'jenis_rapat' => $request->jenis_rapat,
                'tempat' => $request->tempat,
                'acara' => $request->acara,
                'hasil' => $request->hasil,
                'total_hadir' => $request->total_hadir,
                'pimpinan' => $request->pimpinan,
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

            $agenda = NotulenRapat::find($request->id);
            $data = $agenda->update([
                'tanggal_rapat' => $request->tanggal_rapat,
                'jenis_rapat' => $request->jenis_rapat,
                'tempat' => $request->tempat,
                'acara' => $request->acara,
                'hasil' => $request->hasil,
                'total_hadir' => $request->total_hadir,
                'pimpinan' => $request->pimpinan,
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

        $data = NotulenRapat::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
