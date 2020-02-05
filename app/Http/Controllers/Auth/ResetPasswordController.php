<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class ResetPasswordController extends Controller
{
    
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }
    
    /**
     * Função que faz o reset de senha usando o token enviado no email redefinir senha! 
     */
    public function callResetPassword(Request $request)
    {
        //Validação da senha
        $request->validate([
            'email' => 'required',
            'token' => 'required',
            'senha' => 'required|min:8',
            'confirmar_senha' => 'required|same:senha'
        ]);

        //Pega as credenciais vindas no request
        $credentials =  $request->only('email', 'token');
        //Verifica se o usuário é válido
        if (is_null($user = $this->broker()->getUser($credentials))) {
            return response()->json(['error' => 'Falha, usuário inválido.'], 401);
        }
        //Verifica se o token é válido
        if (! $this->broker()->tokenExists($user, $credentials['token'])) {
            return response()->json(['error' => 'Falha, token inválido.'], 401);
        }
        else{
            // Cria um novo Hash com a nova senha do usuário
            $user->senha = Hash::make($request->input('senha'));
            // Realiza Update da nova senha no banco de dados
            $user->update();
            // efetua login no usuário imediatamente
            Auth::login($user);
            //Realiza a exclusão do token usado no processo de redefinição de senha
            DB::table('redefinir_senha')->where('email', $user->email)->delete(); 

            return response()->json(['message' => 'Redefinição de senha realizada com sucesso.']); 
        }

    }

}
