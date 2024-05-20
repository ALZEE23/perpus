<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\peminjaman;
use App\Models\dataBuku;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    //
    public function index(){
        $peminjamans = peminjaman::when(request()->search, function($peminjamans){
            $peminjamans = $peminjamans->where("id_buku","LIKE","%".request()->search."%");
        })->latest()->get();

        // $peminjaans = appends(['search' => request()->search]);

        return response()->json(['success' => true,'message' => 'list data peminjaman','data' => $peminjamans]);
    }

    public function store(Request $request){    
        $validator = Validator::make($request->all(), [
            'id_anggota'=> 'required',
            'id_buku'=> 'required',
            'tgl_pinjam'=> 'required',
            'tgl_kembali'=> 'required',
            'status'=> 'required',
            'denda'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->erors(),422);
        }

        $peminjaman = peminjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_buku'   => $request->id_buku,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status' => $request->status,
            'denda' => $request->denda,
        ]);

        if ($peminjaman) {
            $buku = dataBuku::find($request->id_buku);
            $buku->jumlah_buku -= 1;
            if ($buku->jumlah_buku < 0) {
                return response()->json(['success'=> false,'message'=> 'buku sedang dipinjam semua']);
            }
            $buku->save();
            return response()->json(['success'=> true,'message'=> 'berhasil tambah peminjaman','data'=> $peminjaman]);
        }
    }
}
