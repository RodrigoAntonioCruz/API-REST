<?php

namespace App\Http\Controllers\Auth\ServicosApi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $user = request()->user();

        return [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email,'.$user->id,
        ];
    }
}
