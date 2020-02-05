<?php
namespace App\Http\Controllers\Produtos;

use App\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProdutosController extends Controller
{
    public function index()
    {
        $produtos = Produtos::all()->where('id_usuario', '=', Auth::user()->id);
        return response()->json($produtos);
    }

    public function store(Request $request)
    {
         $produtos = new Produtos();
         $produtos->id_usuario  = Auth::user()->id;
         $produtos->codigo  = $request->codigo;
         $produtos->nome  = $request->nome;
         $produtos->imagem  = $request->imagem;
         $produtos->descricao = $request->descricao;
         $produtos->valor = $request->valor;
         $produtos->save();

        return response()->json(['success' => 'Registro cadastrado com sucesso!']);
    }


    public function show($id)
    {
        $produtos = Produtos::find($id);
        return response()->json($produtos);
    }


    public function update(Request $request, $id)
    {

         $produtos = Produtos::find($id);
         $produtos->id_usuario  = Auth::user()->id;
         $produtos->codigo  = $request->codigo;
         $produtos->nome  = $request->nome;
         $produtos->imagem  = $request->imagem;
         $produtos->descricao = $request->descricao;
         $produtos->valor = $request->valor;
         $produtos->save();
        return response()->json(['success' => 'Registro atualizado com sucesso!']);
    }


    public function destroy($id)
    {
        $produtos = Produtos::destroy($id);
        return response()->json(['success' => 'Registro excluído com sucesso!']);
    }

}