<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    //
    public function index(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        $token = null;
        $user = null;

        // Coba autentikasi dengan guard 'api' untuk model User
        if ($token = auth()->guard('api')->attempt($credentials)) {
            
            $user = auth()->guard('api')->user();
        } elseif ($token = auth()->guard('api_pustakawan')->attempt($credentials)) {
            
            $user = auth()->guard('api_pustakawan')->user();
        } else {
            
            return response()->json([
                'success' => false,
                'message' => 'Email or Password incorrect'
            ], 400);
        }

        

        return response()->json([
            'success' => true,
            'user' => $user ? $user->only(['name', 'email', 'id']) : null,
            'permissions' => $user ? $user->getPermissionArray() : null,
            'token' => $token,
            'role' => $user == auth()->guard('api_pustakawan')->user() ? 'pustakawan' : 'user'
        ], 200);
    }

    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success'=> true,
            'message'=> 'Logout'
        ]);
    
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'password'  => 'required|confirmed',
            'kelas'     => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'kelas'     => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'    => $request->alamat,
        ]);

        //assign roles to user
        $user->assignRole(2);

        if($user) {
            //return success with Api Resource
            return new UserResource(true, 'Data User Berhasil Disimpan!', $user);
        }

        //return failed with Api Resource
        return new UserResource(false, 'Data User Gagal Disimpan!', null);
    }
    
}
