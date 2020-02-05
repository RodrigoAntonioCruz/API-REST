<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Hashing\BcryptHasher;

use App\Http\Controllers\Auth\ServicosApi\LoginRequest;
use App\Http\Controllers\Auth\ServicosApi\User as UserResource;

class AuthController extends Controller
{
    /**
     * Login
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        // Get User by email
        $user = User::where('email', $request->email)->first();

        // Return error message if user not found.
        if(!$user) return response()->json(['error' => 'Usuário não encontrado.'], 404);

        // Account Validation
        if (!(new BcryptHasher)->check($request->input('senha'), $user->senha)) {
            // Return Error message if password is incorrect
            return response()->json(['error' => 'E-mail ou senha está incorreto. A autenticação falhou.'], 401);
        }

        $credentials = 
            [
               'email'    =>  $request->email,
               'password' =>  $request->senha
            ];   

        try {
            // Login Attempt
            if (! $token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addDays(28)->timestamp])) {
                // Return error message if validation failed
                return response()->json(['error' => 'Credenciais inválidas.'], 401);

            }
        } catch (JWTException $e) {
            // Return Error message if cannot create token. 
            return response()->json(['error' => 'Não foi possível criar o token!'], 500);

        }
        
        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('token', 'data'));
    }
}
