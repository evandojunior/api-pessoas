<?php

namespace App\Http\Controllers;

use App\Pessoa;
use App\Endereco;
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
    *      summary="Listar todos registros",
    *      description="",
    *      @OA\Response(response=200, description="Ok"),
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
        if (!$pessoas = Pessoa::with('endereco')->get()) {
            return response()->json([
              'message' => "Nenhum registro encontrado",
              'data' => []
            ]);
        }
        return response()->json([
          'data' => $pessoas
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/pessoas",
     *     description="",
     *     summary="Cadastrar uma pessoa",
     *     operationId="store",
     *     tags={"Pessoas"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nome",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data_nascimento",
     *                     type="string",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="cpf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="nascionalidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(property="sexo", enum={"Masculino", "Feminino", "Outros"}),
     *                 @OA\Property(
     *                     property="cep",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="logradouro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="complemento",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="numero",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="bairro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="uf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     required={"uf"},
     *                     property="cidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="pais",
     *                     type="string",
     *                 ),
     *            )
     *         ),
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nome",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data_nascimento",
     *                     type="string",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="cpf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="nascionalidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(property="sexo", enum={"Masculino", "Feminino", "Outros"}),
     *                 @OA\Property(
     *                     property="cep",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="logradouro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="complemento",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="numero",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="bairro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="uf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     required={"uf"},
     *                     property="cidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="pais",
     *                     type="string",
     *                 ),
     *                 example={
     *                  "nome": "Dr. Christopher Ricardo Ortega",
     *                  "data_nascimento": "1988-10-14",
     *                  "nascionalidade": "Brasileiro",
     *                  "cpf": "68204823533",
     *                  "sexo": "Outros",
     *                  "cep": "95873-377",
     *                  "logradouro": "Rua Sebastião Escobar, 17. Bc. 7 Ap. 50",
     *                  "numero": "4557",
     *                  "complemento": "Apto 89",
     *                  "bairro": "Rua Perez",
     *                  "uf": "AM",
     *                  "cidade": "Carrara do Leste",
     *                  "pais": "Brasil"
     *                 }
     *            )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\Schema(ref="#/components/schemas/Pessoa")
     *     )
     * )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          "nome"            => 'required',
          "data_nascimento" => 'required',
          "cpf"             => 'required|unique:pessoas',
          "sexo"            => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->all();
        if ($request->cep && ($endereco = Endereco::create($request->all()))) {
            $data['endereco_id'] = $endereco->id;
        }

        if (!$pessoa = Pessoa::create($data)) {
            return response()->json('Não foi possível realizar essa operação', 422);
        }
        return response()->json([
          'message' => 'Pessoa cadastrada com sucesso',
          'data' => $pessoa
        ]);
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
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            if (!$pessoa = Pessoa::with('endereco')->find($id)) {
                throw new \Exception("Não foi possível localizar o registro: {$id}");
            }
            return response()->json($pessoa);
        } catch (\Exception $e) {
            return response()->json([
            'message' => $e->getMessage()
          ]);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/pessoas/{id}",
     *      operationId="update",
     *      tags={"Pessoas"},
     *      summary="Atualizar registro da pessoa",
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID da pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nome",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data_nascimento",
     *                     type="string",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="cpf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="nascionalidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(property="sexo", enum={"Masculino", "Feminino", "Outros"}),
     *                 @OA\Property(
     *                     property="cep",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="logradouro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="complemento",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="numero",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="bairro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="uf",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     required={"uf"},
     *                     property="cidade",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="pais",
     *                     type="string",
     *                 ),
     *                 example={
     *                  "nome": "Dr. Christopher Ricardo Ortega",
     *                  "data_nascimento": "1988-10-14",
     *                  "nascionalidade": "Brasileiro",
     *                  "cpf": "68204823533",
     *                  "sexo": "Masculino",
     *                  "cep": "95873-377",
     *                  "logradouro": "Rua Sebastião Escobar, 17. Bc. 7 Ap. 50",
     *                  "numero": "4557",
     *                  "complemento": "Apto 89",
     *                  "bairro": "Rua Perez",
     *                  "pais": "Brasil",
     *                  "uf": "AM",
     *                  "cidade": "Carrara do Leste",
     *                  "pais": "Brasil"
     *                 }
     *            )
     *         )
     *     ),
     *      @OA\Response(response=200,
     *        description="Ok",
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = \Validator::make($request->all(), [
          "nome"            => 'required',
          "data_nascimento" => 'required',
          "cpf"             => 'required',
          "sexo"            => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['error' => "Não foi possível localizar o registro: {$id}"], 402);
        }
        $data = $request->all();

        if ($endereco = Endereco::find($pessoa->endereco_id)) {
            $endereco->update($data);
        } else {
            $endereco = Endereco::create($data);
            $data['endereco_id'] = $endereco->id;
        }

        if (!$pessoa->update($data)) {
            return response()->json('Não foi possível realizar essa operação', 422);
        }
        return response()->json([
          'message' => 'Pessoa atualizada com sucesso',
          'data' => $pessoa
        ]);
    }


    /**
     * @OA\Delete(
     *      path="/api/pessoas/{id}",
     *      operationId="delete",
     *      tags={"Pessoas"},
     *      summary="Deletar uma pessoa",
     *      description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID da pessoa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$pessoa = Pessoa::find($id)) {
            return response()->json(['error' => "Não foi possível localizar o registro: {$id}"], 402);
        }

        if (!$deleted = $pessoa->delete()) {
            return response()->json(['error' => "Não foi possível deletar o registro: {$id}"], 422);
        }
        return response()->json([
        'message' => 'Registro deletado com sucesso',
      ]);
    }
}
