<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataBuku extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn','judul','penulis','penerbit','tahun','jumlah_buku','kategori','id_pustakawan',
    ];

    public function id_pustakawan(){
        return $this->hasMany(pustakawan::class);
    }
}
