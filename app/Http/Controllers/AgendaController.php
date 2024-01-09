<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Agenda;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $agenda = DB::table('agendas');

        if ($q) {
            $agenda = $agenda->where('tempat', 'like', '%' . $q . '%')
                ->orWhere('kegiatan', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $agenda = $agenda->orderBy('id', 'DESC')->get();
        }

        return view('backend.agenda.index', [
            'agenda' => $agenda
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_mulai' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Agenda::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'kegiatan' => $request->kegiatan,
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

            $agenda = Agenda::find($request->id);
            $data = $agenda->update([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'kegiatan' => $request->kegiatan,
                'keterangan' => $request->keterangan    
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

        $data = Agenda::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
