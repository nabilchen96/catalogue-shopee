<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Barang;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel; //library excel
use App\Imports\BarangImport;

class BarangController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $barang = DB::table('barangs');

        if ($q) {
            $barang = $barang->where('nama_barang', 'like', '%' . $q . '%')
                ->orWhere('kategori', 'like', '%' . $q . '%')
                // ->orderBy('id', 'DESC')
                ->orderBy('status', 'ASC')
                ->paginate(10);
        } else {
            $barang = $barang->orderBy('status', 'ASC')->paginate(10);
        }

        return view('backend.barang.index', [
            'barang' => $barang
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //UPLOAD foto_barang

            if ($request->foto_pertama) {
                $foto_pertama = $request->foto_pertama;
                $nama_foto_pertama = '1' . date('YmdHis.') . $foto_pertama->extension();
                $foto_pertama->move('foto_pertama', $nama_foto_pertama);
            }

            if ($request->foto_kedua) {
                $foto_kedua = $request->foto_kedua;
                $nama_foto_kedua = '1' . date('YmdHis.') . $foto_kedua->extension();
                $foto_kedua->move('foto_kedua', $nama_foto_kedua);
            }

            if ($request->foto_ketiga) {
                $foto_ketiga = $request->foto_ketiga;
                $nama_foto_ketiga = '1' . date('YmdHis.') . $foto_ketiga->extension();
                $foto_ketiga->move('foto_ketiga', $nama_foto_ketiga);
            }

            if ($request->foto_keempat) {
                $foto_keempat = $request->foto_keempat;
                $nama_foto_keempat = '1' . date('YmdHis.') . $foto_keempat->extension();
                $foto_keempat->move('foto_keempat', $nama_foto_keempat);
            }

            if ($request->foto_kelima) {
                $foto_kelima = $request->foto_kelima;
                $nama_foto_kelima = '1' . date('YmdHis.') . $foto_kelima->extension();
                $foto_kelima->move('foto_kelima', $nama_foto_kelima);
            }

            $data = Barang::create([
                'nama_barang' => $request->nama_barang,

                'foto_pertama' => $nama_foto_pertama ?? '',
                'foto_kedua' => $nama_foto_kedua ?? '',
                'foto_ketiga' => $nama_foto_ketiga ?? '',
                'foto_keempat' => $nama_foto_keempat ?? '',
                'foto_kelima' => $nama_foto_kelima ?? '',
                'kategori' => $request->kategori,

                'harga_start' => $request->harga_start,
                'harga_end' => $request->harga_end,
                'rating' => $request->rating,
                'terjual' => $request->terjual,
                'afiliasi_url' => $request->afiliasi_url,
                'status'    => $request->status,

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

            //UPLOAD foto_barang
            if ($request->foto_barang) {
                $foto_barang = $request->foto_barang;
                $nama_foto_barang = '1' . date('YmdHis.') . $foto_barang->extension();
                $foto_barang->move('foto_barang', $nama_foto_barang);
            }

            if ($request->foto_pertama) {
                $foto_pertama = $request->foto_pertama;
                $nama_foto_pertama = '1' . date('YmdHis.') . $foto_pertama->extension();
                $foto_pertama->move('foto_pertama', $nama_foto_pertama);
            }

            if ($request->foto_kedua) {
                $foto_kedua = $request->foto_kedua;
                $nama_foto_kedua = '1' . date('YmdHis.') . $foto_kedua->extension();
                $foto_kedua->move('foto_kedua', $nama_foto_kedua);
            }

            if ($request->foto_ketiga) {
                $foto_ketiga = $request->foto_ketiga;
                $nama_foto_ketiga = '1' . date('YmdHis.') . $foto_ketiga->extension();
                $foto_ketiga->move('foto_ketiga', $nama_foto_ketiga);
            }

            if ($request->foto_keempat) {
                $foto_keempat = $request->foto_keempat;
                $nama_foto_keempat = '1' . date('YmdHis.') . $foto_keempat->extension();
                $foto_keempat->move('foto_keempat', $nama_foto_keempat);
            }

            if ($request->foto_kelima) {
                $foto_kelima = $request->foto_kelima;
                $nama_foto_kelima = '1' . date('YmdHis.') . $foto_kelima->extension();
                $foto_kelima->move('foto_kelima', $nama_foto_kelima);
            }

            $data = Barang::find($request->id);
            $data = $data->update([
                'nama_barang' => $request->nama_barang,

                'foto_pertama' => $nama_foto_pertama ?? $data->foto_pertama,
                'foto_kedua' => $nama_foto_kedua ?? $data->foto_kedua,
                'foto_ketiga' => $nama_foto_ketiga ?? $data->foto_ketiga,
                'foto_keempat' => $nama_foto_keempat ?? $data->foto_keempat,
                'foto_kelima' => $nama_foto_kelima ?? $data->foto_kelima,
                'kategori' => $request->kategori,

                'harga_start' => $request->harga_start,
                'harga_end' => $request->harga_end,
                'rating' => $request->rating,
                'terjual' => $request->terjual,
                'afiliasi_url' => $request->afiliasi_url,
                'status'    => $request->status,


                'id_user' => Auth::id()
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

        $data = Barang::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function uploadGambar(Request $request)
    {

        // dd($request->images[1]);

        if (@$request->images[0]) {
            $foto_pertama = $request->images[0];
            $nama_foto_pertama = '1' . date('YmdHis.') . $foto_pertama->extension();
            $foto_pertama->move('foto_pertama', $nama_foto_pertama);
        }

        if (@$request->images[1]) {
            $foto_kedua = $request->images[1];
            $nama_foto_kedua = '1' . date('YmdHis.') . $foto_kedua->extension();
            $foto_kedua->move('foto_kedua', $nama_foto_kedua);
        }

        if (@$request->images[2]) {
            $foto_ketiga = $request->images[2];
            $nama_foto_ketiga = '1' . date('YmdHis.') . $foto_ketiga->extension();
            $foto_ketiga->move('foto_ketiga', $nama_foto_ketiga);
        }

        if (@$request->images[3]) {
            $foto_keempat = $request->images[3];
            $nama_foto_keempat = '1' . date('YmdHis.') . $foto_keempat->extension();
            $foto_keempat->move('foto_keempat', $nama_foto_keempat);
        }

        if (@$request->images[4]) {
            $foto_kelima = $request->images[4];
            $nama_foto_kelima = '1' . date('YmdHis.') . $foto_kelima->extension();
            $foto_kelima->move('foto_kelima', $nama_foto_kelima);
        }

        // dd($nama_foto_pertama);


        $data = Barang::find($request->id_barang);
        $data->update([
            'foto_pertama' => $nama_foto_pertama ?? '',
            'foto_kedua' => $nama_foto_kedua ?? '',
            'foto_ketiga' => $nama_foto_ketiga ?? '',
            'foto_keempat' => $nama_foto_keempat ?? '',
            'foto_kelima' => $nama_foto_kelima ?? '',
            'id_user' => Auth::id()
        ]);

        return back();

    }

    public function front($id)
    {
        $q = explode(' ', Request('q'));
        $barang = DB::table('barangs')->where('status', 'Aktif');

        if ($q && $id != 'all') {
            foreach ($q as $keyword) {
                $barang = $barang->where('nama_barang', 'like', '%' . $keyword . '%');
            }

            if ($id) {
                $barang = $barang->where('kategori', 'like', '%' . $id . '%');
            }

            // Append query parameters to pagination links
            $barang = $barang->orderBy('id', 'DESC')->paginate(30)->appends(['q' => Request('q')]);

        } else {

            foreach ($q as $keyword) {
                $barang = $barang->where('nama_barang', 'like', '%' . $keyword . '%');
            }

            // Append query parameters to pagination links
            $barang = $barang->orderBy('id', 'DESC')->paginate(30)->appends(['q' => Request('q')]);
        }

        return view('frontend.barang', [
            'barang' => $barang
        ]);

    }

    public function detailBarang($id)
    {
        $barang = DB::table('barangs')->where('slug', $id)->first();

        return view('frontend.detail_barang', [
            'barang' => $barang
        ]);
    }

    public function reverseSlug($slug)
    {
        $text = str_replace('-', ' ', $slug);
        $text = ucwords($text);
        return $text;
    }

    public function import(Request $request)
    {

        //melakukan import file
        Excel::import(new BarangImport, request()->file('file'));
        //jika berhasil kembali ke halaman sebelumnya
        return back();
    }
}
