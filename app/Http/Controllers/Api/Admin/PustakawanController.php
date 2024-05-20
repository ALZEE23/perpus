<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pustakawan;
use Illuminate\Support\Facades\Validator;

class PustakawanController extends Controller
{
    //
    public function index(){
        $pustakawans = pustakawan::when(request()->search, function($pustakawans){
            $pustakawans = $pustakawans->where('nama_pustakawan','like'. request()->search.'%');
    })->latest()->get();

    // $pustakawans->appends(['search'=> request()->search]);

    return response()->json(['success' => true,'message'=> 'list data pustakawan', 'data' => $pustakawans]);
  }

  public function store(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:pustakawans',
        'email' => 'required|unique:pustakawans',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(),422);
    }

    $pustakawan = pustakawan::create([
        'name' => $request->name,
        'email' => $request->email,
        'password'=> bcrypt($request->password),
    ]);

    if($pustakawan){
        return response()->json(['success'=> true,'message'=> 'berhasil tambah pustakawan', 'data' => $pustakawan]);
    } 

    return response()->json(['success'=> false,'message'=> 'gagal tambah pustakawan', null]);
  }

  public function update(Request $request, $id){
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response_json($validator->errors(),422);
    }

    $pustakawan = pustakawan::find($id);
    $pustakawan->update([
        'name' => $request->name,
        'email' => $request->email,
        'password'=> bcrypt($request->password),
    ]);

    if($pustakawan){
        return response_json(['success'=> true,'message'=> 'berhasil update pustakawan', $pustakawan]);
    }

    return response_json(['success'=> false,'message'=> 'gagal update pustakawan', null]);

  }

  public function destroy($id){
    $pustakawan = pustakawan::find($id);
    $pustakawan->delete();

    if($pustakawan){
        return response_json(['success'=> true,'message'=> 'berhasil hapus pustakawan',null]);
    }

    return response_json(['success'=> false,'message'=> 'gagal hapus pustakawan', null]);
  }

}