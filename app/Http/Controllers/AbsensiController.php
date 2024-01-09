<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Absensi;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function index(){

        $q = Request('q');
        $j = Request('j');

        $absensi = DB::table('absensis as a')
                    ->join('anggotas as an', 'an.id', '=', 'a.id_anggota');

        if ($q && $j) {
            $absensi = $absensi->whereDate('a.created_at', "=", $q)
                ->where('a.jenis_rapat', $j)
                ->select(
                    'a.*',
                    'an.nama_lengkap', 
                    'an.jabatan'
                )
                ->orderBy('a.id', 'DESC')
                ->paginate(10);
        } else {
            $absensi = $absensi->select(
                        'a.*',
                        'an.nama_lengkap', 
                        'an.jabatan'
                    )->orderBy('a.id', 'DESC')->paginate(10);
        }

        return view('backend.absensi.index', [
            'absensi' => $absensi
        ]);
    }

    public function frontAbsensi(){
        return view('frontend.front-absensi');
    }

    public function store(Request $request){

        //MEMBUAT TTD MENJADI GAMBAR
        $encode_image = explode(",", $request->ttd)[1];
        $decoded_image = base64_decode($encode_image);
        $signature = date('YmdHis.').'png';
        file_put_contents("signature/".$signature, $decoded_image);
        
        Absensi::create([
            'id_anggota'    => $request->id_anggota, 
            'signature'     => $signature, 
            'jenis_rapat'   => $request->jenis_rapat
        ]);

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah'
        ];

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Absensi::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function exportPdf(){

        ini_set('max_execution_time', 300);

        $q = Request('q');
        $absensi = DB::table('absensis as a')
                    ->join('anggotas as an', 'an.id', '=', 'a.id_anggota');

        if ($q) {
            $absensi = $absensi->whereDate('a.created_at', "=", $q)
                ->select(
                    'a.*',
                    'an.nama_lengkap', 
                    'an.jabatan'
                )
                ->orderBy('a.id', 'DESC')
                ->get();
        } else {
            $absensi = $absensi->select(
                        'a.*',
                        'an.nama_lengkap', 
                        'an.jabatan'
                    )->orderBy('a.id', 'DESC')->get();
        }

        $data = PDF::loadview('backend.absensi.export_pdf', [
            'absensi' => $absensi, 
            'q' => $q
        ]);

    	return $data->download('laporan.pdf');
    }
}
