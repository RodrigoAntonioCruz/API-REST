<?php

namespace App\Http\Controllers\Auth\ServicosApi;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtenha as regras de validação que se aplicam à solicitação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'senha' => 'required',
            'nova_senha' => 'required|min:8',
            'confirmar_senha' => 'required|same:nova_senha'
        ];
    }
}
