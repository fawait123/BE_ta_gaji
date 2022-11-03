<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
   public function login(AuthRequest $request)
   {
    try {
        $dataRequst = [
            'email' => $request->username,
            'password' => $request->password
        ];

        $check = User::where('username',$request->username)->first();

        if(!$check){
            $data = [
                'message'=>'Username atau password tidak ditemukan',
                'data'=>[]
            ];
            return Response::send(404,$data);
        }

        if(!Hash::check($request->password,$check->password)){
            $data = [
                'message'=>'Username atau password tidak ditemukan',
                'data'=>[]
            ];
            return Response::send(404,$data);
        }
        auth()->login($check);
        $resultToken = auth()->user()->createToken('Access Token');
        $token = $resultToken->token;
            $data = [
                'message'=>'Login success',
                'data'=>[
                    "token"=>$resultToken->accessToken,
                    'exp'=>Carbon::parse($token->expires_at)->toDateTimeString()
                ]
            ];
        return Response::send(200,$data);
    } catch (Exception $error) {
        return Response::send(500,$error->getMessage());
    }
   }

   public function register(UserRequest $request)
   {
        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'username'=>$request->username,
                'role'=>$request->role,
                'password' => Hash::make($request->password)
            ]);
            $data = [
                'message'=>'Register success',
                'data'=>$user
            ];
            return Response::send(200,$data);
        } catch (Exception $error) {
            Response::send(500,$error->getMessage());
        }
   }
}
