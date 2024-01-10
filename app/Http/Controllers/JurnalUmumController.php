<?php

namespace App\Http\Controllers;

use DB;
use App\Models\JurnalUmum;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class JurnalUmumController extends Controller
{
    public function index()
    {

        $tgl_awal = Request('tgl_awal');
        $tgl_akhir = Request('tgl_akhir');

        $jurnal = DB::table('jurnal_umums as p');

        if ($tgl_awal && $tgl_akhir) {
            $jurnal = $jurnal
                ->whereBetween(DB::raw('DATE(p.waktu_transaksi)'), [
                    $tgl_awal,
                    $tgl_akhir
                ])
                ->orderBy('p.id', 'DESC')
                ->paginate(10);

        } else {

            $jurnal = $jurnal->orderBy('p.id', 'DESC')->paginate(10);
        }

        return view('backend.jurnal_umum.index', [
            'jurnal' => $jurnal
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'keterangan' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = JurnalUmum::create([
                'debet' => $request->debet,
                'kredit' => $request->kredit,
                'waktu_transaksi' => $request->tanggal_transaksi,
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


    public function delete(Request $request)
    {

        $data = JurnalUmum::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
