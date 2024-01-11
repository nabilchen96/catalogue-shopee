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
        $bidang = Request('bidang');

        $jurnal = DB::table('jurnal_umums as p');

        $jurnal = $jurnal
            ->whereBetween(DB::raw('DATE(p.waktu_transaksi)'), [
                $tgl_awal,
                $tgl_akhir
            ])
            ->where('bidang', $bidang ?? 'Ekonomi')
            ->orderBy('p.id', 'DESC')
            ->paginate(10);

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
                'bidang' => $request->bidang,
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

    public function exportPdf(){

        ini_set('max_execution_time', 300);

        $tgl_awal = Request('tgl_awal');
        $tgl_akhir = Request('tgl_akhir');
        $bidang = Request('bidang');

        $jurnal = DB::table('jurnal_umums as p');

        $jurnal = $jurnal
            ->whereBetween(DB::raw('DATE(p.waktu_transaksi)'), [
                $tgl_awal,
                $tgl_akhir
            ])
            ->where('bidang', $bidang ?? 'Ekonomi')
            ->orderBy('p.id', 'DESC')
            ->paginate(10);

        $data = PDF::loadview('backend.jurnal_umum.export_pdf', [
            'jurnal' => $jurnal, 
            'bidang' => $bidang, 
            'tgl_awal' => $tgl_awal, 
            'tgl_akhir' => $tgl_akhir
        ]);

    	return $data->download('laporan.pdf');
    }
}
