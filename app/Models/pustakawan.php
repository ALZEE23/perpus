<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class pustakawan extends Authenticatable implements JWTSubject
{
    use HasFactory,HasApiTokens,HasRoles;
    protected $fillable = [
        'nama_pustakawan','email','password',
    ];

    public function dataBuku(){
        return $this->belongsTo(dataBuku::class);
    }

    public function getPermissionArray(){
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr->id => $pr->permission];
        });
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
}
