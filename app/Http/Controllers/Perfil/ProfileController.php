<?php

namespace App\Http\Controllers\Perfil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\ServicosApi\UpdatePassword;
use App\Http\Controllers\Auth\ServicosApi\UpdateProfileRequest;
use App\Http\Controllers\Auth\ServicosApi\User as UserResource;

class ProfileController extends Controller
{
     /**
     * Get Login User
     * 
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        // Get data of Logged user
        $user = Auth::user();

        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));

    }


     /**
     * Update Profile
     * 
     * 
     * @param UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        // Get data of Logged user
        $user = Auth::user();

        // Update User
        $user->update($request->only('nome', 'email'));
        
        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));
        
    }

     /**
     * Update Profile
     * 
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        // Get Request User
        $user = $request->user();

        // Validate user Password and Request password
        if (!Hash::check($request->senha, $user->senha)) {
            // Validation failed return an error messsage
            return response()->json(['error' => 'Senha atual inválida.'], 422);

        }

        // Update User password
        $user->update([
            'senha' =>  Hash::make($request->nova_senha),
        ]);

        // transform user data
        $data = new UserResource($user);

        //return response()->json(compact('data'));
        return response()->json(['success' => 'Senha atualizada com sucesso!']);
    }
}
