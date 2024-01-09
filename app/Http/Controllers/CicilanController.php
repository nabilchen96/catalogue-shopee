<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Cicilan;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CicilanController extends Controller
{
    public function index()
    {

        $q = Request('q');

        $cicilan = DB::table('cicilans as c')
            ->join('penjualans as p', 'p.id', '=', 'c.id_penjualan')
            ->join('barangs as b', 'b.id', '=', 'p.id_barang')
            ->select(
                'b.nama_barang',
                'b.foto_barang',
                'p.nama_konsumen',
                'c.*'
            );

        if ($q) {

            $cicilan = $cicilan->where('p.nama_konsumen', 'like', '%' . $q . '%')
                    ->whereNotIn('c.angsuran', [
                        0,
                    ])
                    ->orderBy('c.tanggal_angsuran', 'DESC')
                    ->paginate(10);

        } else {

            $cicilan = $cicilan->orderBy('c.tanggal_angsuran', 'DESC')->whereNotIn('c.angsuran', [
                0,
            ])->paginate(10);
        }

        return view('backend.cicilan.index', [
            'cicilan' => $cicilan
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'angsuran' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Cicilan::create([
                'id_penjualan' => $request->id_penjualan, 
                'total_cicilan' => $request->sisa_cicilan - $request->angsuran,
                'angsuran' => $request->angsuran, 
                'tanggal_angsuran' => $request->tanggal_angsuran,
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

        $data = Cicilan::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
