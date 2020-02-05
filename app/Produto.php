<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
   protected $table = "produtos";
   protected $fillable = ['id_usuario','codigo','nome', 'descricao', 'imagem', 'valor'];
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
}
