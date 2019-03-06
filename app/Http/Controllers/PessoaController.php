<?php

namespace App\Http\Controllers;

use App\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PessoaController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Api Pessoas",
     *      description="Teste para a vaga de PHP Pleno"
     * )
     */

    /**
    * @OA\Get(
    *      path="/api/pessoas",
    *      operationId="index",
    *      tags={"Pessoas"},
    *      summary="Lista de pessoas",
    *      description="",
    *      @OA\Response(response=200, description="Success"),
    *      @OA\Response(response=400, description="Bad request")
    *     )
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (!$pessoas = Pessoa::with('endereco')->get()) {
                throw new \Exception("Nenhum registro encontrado");
            }
            return response()->json([
              'pessoas' => $pessoas
            ]);
        } catch (\Exception $e) {
            return response()->json([
              'error'   => 'Falha ao obter registros.'
            ]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withAddress(Request $request)
    {
        try {
            if (!$pessoas = Pessoa::with('endereco')->get()) {
                throw new \Exception("Nenhum registro encontrado");
            }
            return response()->json(['pessoas' => $pessoas]);
        } catch (\Exception $e) {
            return response()->json([
              'error'   => 'Falha ao obter registros.'
            ]);
        }
    }

    /**
    * @OA\Post(
    *      path="/api/pessoas",
    *      operationId="index",
    *      tags={"Pessoas"},
    *      summary="Cadastrar pessoa",
    *      description="",
    *       @OA\Parameter(
    *          name="nome",
    *          description="Nome completo",
    *          required=true,
    *          in="query",
    *          @OA\Schema(type="string")
    *       ),
    *       @OA\Parameter(
    *          name="data_nascimento",
    *          description="Data de nascimento",
    *          required=true,
    *          in="query",
    *          @OA\Schema(
    *              type="date"
    *          )
    *       ),
    *       @OA\Parameter(
    *          name="cpf",
    *          description="Numéro do CPF",
    *          required=true,
    *          in="query",
    *          @OA\Schema(type="string")
    *       ),
    *       @OA\Parameter(
    *          name="sexo",
    *          description="Genêro da pessoa, informe entre: ['Masculino', 'Feminino', 'Outros']",
    *          required=true,
    *          in="query",
    *          @OA\Schema(type="string")
    *       ),
    *       @OA\Response(response=200, description="Success"),
    *       @OA\Response(response=400, description="Bad request")
    *     )
    *
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      echo '<pre>';
      var_dump($request->all());
      exit;
      dd($request->all());
        try {
            $request->validate([
              'nome'            => 'required',
              'data_nascimento' => 'required|date',
              'cpf'             => 'required',
              'sexo'            => 'required'
            ]);
            Pessoa::create($request->all());
            return $this->respondCreated('Pessoa cadastrada com sucesso!');
        } catch (ValidationException $e) {
            return response()->json([
            'error' => $e->getMessage()
          ], 401);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/pessoas/{id}",
     *      operationId="show",
     *      tags={"Pessoas"},
     *      summary="Exibir informações sobre uma determinada pessoa",
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pessoa $pessoa)
    {
        try {
            return response()->json($pessoa);
        } catch (\Exception $e) {
            return response()->json([
            'message' => 'Falha ao exibir dados da pessoa'
          ]);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/pessoas/{id}",
     *      operationId="update",
     *      tags={"Pessoas"},
     *      summary="Método para atualizar",
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *       @OA\Parameter(
     *          name="nome",
     *          description="Nome completo",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *          name="data_nascimento",
     *          description="Data de nascimento formato:(YYYY-MM-DD)",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *          name="cpf",
     *          description="Número do CPF",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *          name="sexo",
     *          description="Genêro da pessoa, informe entre: [Masculino, Feminino, Outros]",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string")
     *       ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     *
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pessoa $pessoa)
    {
        //
        try {
            $request->validate([
              'nome',
              ''
            ]);

            if (!$updated = $pessoa->update($request->all())) {
                throw new \Exception("Falha ao atualizar o registro: {$pessoa->id}");
            }

            return response()->json([
              'message' => 'Registro excluido com sucesso!',
              $updated,
            ]);
        } catch (\Exception $e) {
            return response()->json([
            'error'   => $e->getMessage()
          ]);
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/pessoas/{id}",
     *      operationId="delete",
     *      tags={"Pessoas"},
     *      summary="Deleta uma pessoa",
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"  )
     *      ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     *
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pessoa $pessoa)
    {
        //
        try {
            if (!$deleted = $pessoa->delete()) {
                throw new \Exception("Não foi possível deletar o registro: {$pessoa->id}");
            }
            return response()->json([
            'message' => 'Registro excluido com sucesso!'
          ]);
        } catch (\Exception $e) {
            return response()->json([
            'error'   => $e->getMessage()
          ]);
        }
    }
}
