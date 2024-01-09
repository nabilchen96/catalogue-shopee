<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\SuratKeluar;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $tgl = Request('tgl');
        $surat_keluar = DB::table('surat_keluars');

        if ($q == '' && $tgl) {
            $surat_keluar = $surat_keluar
                ->orderBy('id', 'DESC')
                ->where('tanggal_surat', $tgl)->get();

        } elseif ($tgl == '' && $q) {
            $surat_keluar = $surat_keluar
                ->orderBy('id', 'DESC')
                ->where('nomor_surat', 'like', '%' . $q . '%')
                ->orWhere('tujuan_pengiriman', 'like', '%' . $q . '%')
                ->orWhere('perihal', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orWhere('nomor_agenda', 'like', '%' . $q . '%')->get();

        } elseif ($q && $tgl) {
            $surat_keluar = $surat_keluar
                ->where(function ($query) use ($tgl, $q) {
                    $query->where('tanggal_surat', $tgl);
                })
                ->Where(function ($query) use ($q) {
                    $query->where('nomor_surat', 'like', '%' . $q . '%')
                        ->orWhere('tujuan_pengiriman', 'like', '%' . $q . '%')
                        ->orWhere('perihal', 'like', '%' . $q . '%')
                        ->orWhere('keterangan', 'like', '%' . $q . '%')
                        ->orWhere('nomor_agenda', 'like', '%' . $q . '%');
                })
                ->orderBy('id', 'DESC')
                ->get();

        } else {
            $surat_keluar = $surat_keluar->orderBy('id', 'DESC')->get();

        }

        return view('backend.surat_keluar.index', [
            'surat_keluar' => $surat_keluar
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //UPLOAD LAMPIRAN
            if ($request->lampiran) {
                $lampiran = $request->lampiran;
                $nama_lampiran = '1' . date('YmdHis.') . $lampiran->extension();
                $lampiran->move('lampiran', $nama_lampiran);
            }

            $data = SuratKeluar::create([
                'nomor_agenda' => $request->nomor_agenda,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'lampiran' => $nama_lampiran ?? '',
                'tujuan_pengiriman' => $request->tujuan_pengiriman,
                'perihal' => $request->perihal,
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

             //UPLOAD LAMPIRAN
             if ($request->lampiran) {
                $lampiran = $request->lampiran;
                $nama_lampiran = '1' . date('YmdHis.') . $lampiran->extension();
                $lampiran->move('lampiran', $nama_lampiran);
            }

            $surat_keluar = SuratKeluar::find($request->id);
            $data = $surat_keluar->update([
                'nomor_agenda' => $request->nomor_agenda,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'lampiran' => $nama_lampiran ?? $surat_keluar->lampiran,
                'tujuan_pengiriman' => $request->tujuan_pengiriman,
                'perihal' => $request->perihal,
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

        $data = SuratKeluar::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
