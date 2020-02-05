<?php

namespace App;

use App\Notifications\resetarSenhaEmail;
use App\Notifications\verificarContaEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * Este método muda o nome da tabela padrão users para usuarios
     *
     * @var array
     */
    protected $table = 'usuarios';

    /**
     * Este método muda o nome do campo password para senha
     *
     * @var array
     */
    public function getAuthPassword()
    {
        return $this->attributes['senha'];
    }

    /**
     * Este método muda o nome dos campos gerais da tabela (users)=>usuarios
     *
     * @var array
     */
    protected $fillable  = [
        'nome', 'email', 'senha', 'permissao_usuario',
    ];

    /**
     * Este método muda o nome do campo remember_token para lembrar_senha
     *
     * @var array
     */
    protected $rememberTokenName = 'lembrar_senha';

    /**
     * Métodos protegidos em hidden
     *
     * @var array
     */
    protected $hidden = [
        'senha', 'lembrar_senha',
    ];

    /**
     * Este método determine se o usuário verificou o endereço de email.
     * @var array
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verificado_em);
    }

    /**
     * Este método marque o email do usuário fornecido como verificado.
     *
     * @var array
     */

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verificado_em' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Este método muda o nome do campo CREATED_AT para dt_cadastro
     *
     * @var array
     */
     const CREATED_AT = 'dt_cadastro';
     
     /**
     * Este método muda o nome do campo UPDATED_AT para dt_atualizacao
     *
     * @var array
     */
     const UPDATED_AT = 'dt_atualizacao';

    /**
     * Este método manda uma notificação para email usuario resetar a senha quando esquecida
     *
     * @var array
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new resetarSenhaEmail($token));
    }


    /**
     * Este método manda email de verificação de conta de email quando usuário é cadastrado
     * @var array
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new verificarContaEmail());
    }

         /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

?>
