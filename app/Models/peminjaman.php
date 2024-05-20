<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; 

    protected $fillable = [
        'id_anggota','id_buku','tgl_pinjam','tgl_kembali','status','denda'
    ];

    public function id_anggota(){
        return $this->hasMany(User::class);
    }

    public function id_buku(){
        return $this->hasMany(dataBuku::class);
    }

    public function denda(){
        return $this->belongsTo(denda::class);    
    }
}
