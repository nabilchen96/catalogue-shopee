<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {

        $q = Request('q');
        $user = DB::table('users');

        if ($q) {
            $user = $user->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orWhere('no_telp', 'like', '%' . $q . '%')
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $user = $user->orderBy('id', 'DESC')->get();
        }

        return view('backend.users.index', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'unique:users'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = User::create([
                'name' => $request->name,
                'role' => $request->role,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password)
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

            $user = User::find($request->id);
            $data = $user->update([
                'name' => $request->name,
                'role' => $request->role,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'password' => $request->password ? Hash::make($request->password) : $user->password
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

        $data = User::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
