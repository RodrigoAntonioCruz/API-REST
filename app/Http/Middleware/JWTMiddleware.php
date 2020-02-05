<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Authentication\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTMiddleware
{
    /**
     * Manipular solicitações recebidas.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (is_null($request->bearerToken())) {
            return response()->json(['error' => 'Token é obrigatório.'], 401);
        }
        
        try {
            // tenta verificar as credenciais e criar um token para o usuário
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
            
        } catch (TokenExpiredException $e) {

            return response()->json(['error' => 'Sessão expirada.', 'status_code' => 401], 401);

        } catch (TokenInvalidException $e) {

            return response()->json(['error' => 'Token inválido.', 'status_code' => 401], 401);

        } catch (JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 401);

        }

        return $next($request);
    }
}
