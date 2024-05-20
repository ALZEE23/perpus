<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\model\tentang;

class TentangController extends Controller
{
    //
    public function index(){
        $tentangs = tentang::when(request()->search, function($tentangs){
            $tentangs = $tentangs->where("nama_aplikasi","LIKE","%". request()->search.'%');
        })->latest()->get();

        $tentangs = appends(['search' => request()->search]);
        return response()->json(['success'=> true,'message' => 'list data',$tentangs]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required',
            'alamat'  => 'required',
            'email' => 'required',
            'telp'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $tentang = tentang::create([
            'nama_aplikasi' => $request->nama_aplikasi,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'telp'          => $request->telp,
        ]);

        if ($tentang){
            return response()->json(['success'=> true,'message'=> 'berhasil tambahkan tentang', $tentang]);
        }

        return response()->json(['success'=> false,'message'=> 'gagal tambahkan tentang', null]);
       
    }

     public function update(Request $request,$id){
            $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required',
            'alamat'  => 'required',
            'email' => 'required',
            'telp'  => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(),422);
            }

            $tentang = tentang::find($id);
            $tentang->update([
            'nama_aplikasi' => $request->nama_aplikasi,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'telp'          => $request->telp,
            ]);

            if( $tentang ){
                return response()->json(['success' => true,'message' => 'berhasil update tentang', $tentang]);
            }

            return response()->json(['success'=> false,'message'=> 'gagal update tentang', null]);
    }

    public function destroy($id){
        $tentang = tentang::find($id);
        $tentang->delete();

        if( $tentang ){
                return response()->json(['success'=> true,'message'=> 'berhasil hapus tentang', null]);
        }

        return response()->json(['success'=> false,'message'=> 'gagal hapus', null]);
    }
}
