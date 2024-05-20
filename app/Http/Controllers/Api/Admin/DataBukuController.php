<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\dataBuku;

class DataBukuController extends Controller
{
    //
    public function index(){
        $dataBukus = dataBuku::when(request()->search, function($dataBukus){
            $dataBukus = $dataBukus->where('judul', 'like', '%'. request()->search.'%');
        })->latest()->get();

        // $dataBukus->appends(['search' => request()->search]);

        return response()->json(['succes' => true, 'message' => 'list data user', $dataBukus]);
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'isbn' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'jumlah_buku' => 'required',
            'kategori' => 'required',
            'id_pustakawan' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataBuku = dataBuku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'jumlah_buku' => $request->jumlah_buku,
            'kategori' => $request->kategori,
            'id_pustakawan' => $request->id_pustakawan,
        ]);

        if($dataBuku){
            return response()->json(['succes'=> true,'message'=> 'berhasil tambah buku', $dataBuku] );
        }   
        return response()->json(['succes'=> true,'message'=> 'gagal tambah buku', null]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'isbn' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'jumlah_buku' => 'required',
            'kategori' => 'required',
            'id_pustakawan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataBuku = dataBuku::find($id);

        $dataBuku->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'jumlah_buku' => $request->jumlah_buku,
            'kategori' => $request->kategori,
            'id_pustakawan' => $request->id_pustakawan,
        ]);

        if($dataBuku){
            return response()->json(['success'=> true,'message'=> 'berhasil update data buku',$dataBuku]);
        }

        return response()->json(['success'=> false,'message'=> 'gagal update data buku', null]);

    }

    public function destroy($id){
        $dataBuku = dataBuku::find($id);
        $dataBuku->delete();
        if ($dataBuku){
            return response()->json(['success'=> true,'message'=> 'berhasil hapus buku', null]);
        }

        return response()->json(['success'=> false,'message'=> 'gagal hapus buku', null]);
    }

}
