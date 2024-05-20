<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\denda;

class DendaController extends Controller
{
    //
    public function index(){
        $dendas = denda::when(request()->search, function($dendas){
            $dendas = $dendas->where("id_peminjaman","LIKE", "%".request()->search."%");
        })->latest()->get();

        $dendas = appends(['search' => request()->search]);
        return response()->json(['success' => true, 'message' => 'list data ']);
    }

    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'id_peminjaman' => 'required',
            'harga_denda'   => 'required',
            'status'    => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali'=> 'required',
            'denda'=> 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $denda = denda::create([
            'id_peminjaman' => $request->id_peminjaman,
            'harga_denda'   => $request->harga_denda,
            'status'        => $request->status,
            'tgl_pinjam'=> $request->tgl_pinjam,
            'tgl_kembali'   => $request->tgl_kembali,
            'denda' => $request->denda,
        ]);
        
        if ($denda){
            return response()->json(['success'=> true,'message' => 'berhasil tambah denda', $denda]);
        }

        return response()->json(['success'=> false,'message'=> 'gagal tambah denda', null]);


    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'id_peminjaman' => 'required',
            'harga_denda'   => 'required',
            'status'    => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali'=> 'required',
            'denda'=> 'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $denda = Denda::find($id);
        
    }

}
