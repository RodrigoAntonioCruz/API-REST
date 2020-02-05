<?php

namespace App\Http\Controllers\Auth\ServicosApi;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Esta função tranforma em array json e pega todos os dados do usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'dt_cadastro' => $this->dt_cadastro,
            'dt_atualizacao' => $this->dt_atualizacao,
        ];
        // return parent::toArray($request);
    }
}
