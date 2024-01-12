<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Piket;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PiketController extends Controller
{

    public function index(){

        $q = Request('q');
        $j = Request('j');

        $piket = DB::table('pikets as p')
                    ->join('anggotas as a', 'a.id', '=', 'p.nama_pengurus');

        if ($q) {
            $piket = $piket->whereDate('p.created_at', "=", $q)
                ->select(
                    'p.*', 
                    'a.nama_lengkap', 
                    'a.jabatan'
                )
                ->orderBy('p.id', 'DESC')
                ->paginate(10);
        } else {
            $piket = $piket ->select(
                'p.*', 
                'a.nama_lengkap', 
                'a.jabatan'
            )->orderBy('p.id', 'DESC')->paginate(10);
        }

        return view('backend.piket.index', [
            'piket' => $piket
        ]);
    }

    public function frontPiket(){
        return view('frontend.front-piket');
    }

    public function store(Request $request){

        //MEMBUAT TTD MENJADI GAMBAR
        $encode_image = explode(",", $request->ttd)[1];
        $decoded_image = base64_decode($encode_image);
        $signature = date('YmdHis.').'png';
        file_put_contents("signature/".$signature, $decoded_image);

        if(DB::table('anggotas')->where('id', $request->nama_pengurus)->value('password') != $request->password){
            $data = [
                'responCode' => 0,
                'respon' => 'Password yang anda masukan salah!'
            ];
    
            return response()->json($data);
        }
        
        Piket::create([
            'nama_pengurus'    => $request->nama_pengurus, 
            'tanda_tangan'     => $signature, 
        ]);

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Ditambah'
        ];

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Piket::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
