<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\ServicosApi\RegisterRequest;
use App\Http\Controllers\Auth\ServicosApi\User as UserResource;


class RegisterController extends Controller
{
    use RegistersUsers;
    
    /**
     * Register
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request)
    {
        // Create user data
        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'permissao_usuario' => 'admin',
        ]);
        
        //  Generate token
        $token = JWTAuth::fromUser($user);

        // Transform user data
        $data = new UserResource($user);

        return response()->json(compact('token', 'data'));

    }
}
