<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    //
    public function index(){
        $users = User::when(request()->search, function($users){
            $users = $users ->where('name', 'like', '%'. request()->search . '%');
        })->with('roles')->latest()->get();

        // $users->appends(['search' => request()->search]);

        return response()->json(['succes' => true, 'message' => 'list data user', $users]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users|unique:pustakawans',
            'password'  => 'required',
            'kelas'     => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'kelas'     => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'    => $request->alamat,
        ]);

        $user->assignRole($request->role);

        if($user) {
            return response()->json(['success'=> true,'message'=> 'Berhasil Tambah User', $user]);
        }

        return response()->json(['success'=> false,'message'=> 'Gagal Tambah User', null]);
    }

    public function update(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'kelas'     => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'    => $request->alamat,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'kelas'     => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'    => $request->alamat,
        ]);

        $user->syncRoles($request->role);

        if($user) {
            return response()->json(['success'=> true,'message'=> 'Berhasil update User', $user]);
        }

        return response()->json(['success'=> false,'message'=> 'Gagal update User', null]);
    }

    public function destroy(User $user)
    {
        if($user->delete()) {
         
            return response()->json(['success'=> true,'message'=> 'Berhasil hapus User', null]);
        }

        return response()->json(['success'=> false,'message'=> 'Gagal hapus User', null]);
    }
    
}
