<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API REST PT-BR 
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return [
        'app' => 'API Desenvolvida por Rodrigo da Cruz',
        'version' => '1.0.0',
    ];
});

//Rotas de Autenticação/Cadastro/Redefinir Senha de Usuário
Route::group(['namespace' => 'Auth'], function () {
    //Rota de Login do usuário
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    //Rota de Cadastro de usuários
    Route::post('cadastro', ['as' => 'cadastro', 'uses' => 'RegisterController@register']);
    // Rota para Enviar email de redefinição de senha
    Route::post('redefinicao/email', 'ForgotPasswordController@sendPasswordResetLink');
    // Rota de validação de token e redefinição de senha
    Route::post('redefinicao/senha', 'ResetPasswordController@callResetPassword')->name('redefinicao.senha');
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    //Rotas do Perfil/Edição dos dados e senha de Usuário Logado 
    Route::group(['namespace' => 'Perfil'], function () {
        //Rota que busca todos os dados do Usuário Logado
        Route::get('perfil', ['as' => 'perfil', 'uses' => 'ProfileController@me']);
        //Rota que faz edição dos dados do Usuário Logado
        Route::put('perfil', ['as' => 'perfil', 'uses' => 'ProfileController@update']);
        //Rota que faz redefinição de senha do Usuário Logado
        Route::put('perfil/senha', ['as' => 'perfil', 'uses' => 'ProfileController@updatePassword']);
    });
    //Rota de Logout
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);
    });
    //Rotas de Produtos do Usuário
    Route::group(['namespace' => 'Produtos'], function () {
        Route::apiResource('/produtos', 'ProdutosController');
    });

});


    
