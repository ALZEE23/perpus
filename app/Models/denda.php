<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class denda extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_peminjaman','harga_denda','status','tgl_pinjam','tgl_kembali'
    ];

    public function id_peminjaman(){
        return $this->hasMany(peminjaman::class);
    }
}
