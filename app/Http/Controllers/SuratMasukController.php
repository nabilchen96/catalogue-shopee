<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\SuratMasuk;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuratMasukController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $tgl = Request('tgl');
        $surat_masuk = DB::table('surat_masuks');

        if ($q == '' && $tgl) {
            $surat_masuk = $surat_masuk
                ->orderBy('id', 'DESC')
                ->where('tanggal_surat', $tgl)->paginate(10);

        } elseif ($tgl == '' && $q) {
            $surat_masuk = $surat_masuk
                ->orderBy('id', 'DESC')
                ->where('nomor_surat', 'like', '%' . $q . '%')
                ->orWhere('alamat_pengirim', 'like', '%' . $q . '%')
                ->orWhere('perihal', 'like', '%' . $q . '%')
                ->orWhere('keterangan', 'like', '%' . $q . '%')
                ->orWhere('nomor_agenda', 'like', '%' . $q . '%')->paginate(10);

        } elseif ($q && $tgl) {
            $surat_masuk = $surat_masuk
                ->where(function ($query) use ($tgl, $q) {
                    $query->where('tanggal_surat', $tgl);
                })
                ->Where(function ($query) use ($q) {
                    $query->where('nomor_surat', 'like', '%' . $q . '%')
                        ->orWhere('alamat_pengirim', 'like', '%' . $q . '%')
                        ->orWhere('perihal', 'like', '%' . $q . '%')
                        ->orWhere('keterangan', 'like', '%' . $q . '%')
                        ->orWhere('nomor_agenda', 'like', '%' . $q . '%');
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);

        } else {
            $surat_masuk = $surat_masuk->orderBy('id', 'DESC')->paginate(10);

        }

        return view('backend.surat_masuk.index', [
            'surat_masuk' => $surat_masuk
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

            $data = SuratMasuk::create([
                'nomor_agenda' => $request->nomor_agenda,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'lampiran' => $nama_lampiran ?? '',
                'alamat_pengirim' => $request->alamat_pengirim,
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

            $surat_masuk = SuratMasuk::find($request->id);
            $data = $surat_masuk->update([
                'nomor_agenda' => $request->nomor_agenda,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'lampiran' => $nama_lampiran ?? $surat_masuk->lampiran,
                'alamat_pengirim' => $request->alamat_pengirim,
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

        $data = SuratMasuk::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
