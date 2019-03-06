<?php

namespace App\Http\Controllers;

use App\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{

    /**
    * @OA\Get(
    *      path="/api/enderecos",
    *      operationId="index",
    *      tags={"Endereços"},
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
    public function index()
    {
        if (!$enderecos = Endereco::all()) {
            return response()->json([
              'message' => 'Nenhum registro encontrado',
              'data' => []
            ]);
        }
        return response()->json(['data' => $enderecos]);
    }


    /**
     * @OA\Post(
     *     path="/api/enderecos",
     *     description="",
     *     summary="Cadastrar endereço",
     *     operationId="store",
     *     tags={"Endereços"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="logradouro",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="complemento",
     *                     type="string"
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
     *                     property="numero",
     *                     type="integer",
     *                 ),
     *                 example={
     *                     "cep": "95873-377",
     *                     "logradouro": "Rua Sebastião Escobar, 17. Bc. 7 Ap. 50",
     *                     "numero": "4557",
     *                     "complemento": "Apto 89",
     *                     "bairro": "Rua Perez",
     *                     "pais": "Brasil",
     *                     "uf": "AM",
     *                     "cidade": "Carrara do Leste"
     *                  }
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\Schema(ref="#/components/schemas/Pessoa")
     *     )
     * )
     **/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'cep' => 'required',
          'logradouro' => 'required',
          'numero' => 'required',
          'bairro' => 'required',
          'uf' => 'required',
          'cidade' => 'required',
          'pais' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!$endereco = Endereco::create($request->all())) {
            return response()->json('Falha ao cadastrar o endereço', 422);
        }

        return response()->json([
          'message' => 'Endereço cadastrado com sucesso',
          'data' => $endereco
        ]);
    }


    /**
    * @OA\Get(
    *      path="/api/enderecos/{id}",
    *      operationId="show",
    *      tags={"Endereços"},
    *      summary="Exibir dados de um endereço",
    *      description="",
    *      @OA\Parameter(
    *          name="id",
    *          description="ID do endereço",
    *          required=true,
    *          in="path",
    *          @OA\Schema(type="integer")
    *      ),
    *      @OA\Response(response=200, description="Ok"),
    *      @OA\Response(response=400, description="Bad request")
    *     )
    */

    /**
     * Display the specified resource.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$endereco = Endereco::find($id)) {
            return response()->json(["message" => "Não foi possível localizar o registro: {$id}", 402]);
        }
        return response()->json($endereco);
    }

    /**
     * @OA\Put(
     *     path="/api/enderecos/{id}",
     *     description="",
     *     summary="Atualizar um endereço",
     *     operationId="update",
     *     tags={"Endereços"},
     *      @OA\Parameter(
     *          name="id",
     *          description="ID do endereço",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="logradouro",
     *                     type="string",
     *
     *                 ),
     *                 @OA\Property(
     *                     property="complemento",
     *                     type="string"
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
     *                     property="numero",
     *                     type="integer",
     *                 ),
     *                 example={
     *                     "cep": "95873-377",
     *                     "logradouro": "Rua Sebastião Escobar, 17. Bc. 7 Ap. 50",
     *                     "numero": "4557",
     *                     "complemento": "Apto 89",
     *                     "bairro": "Rua Perez",
     *                     "pais": "Brasil",
     *                     "uf": "AM",
     *                     "cidade": "Carrara do Leste"
     *                  }
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\Schema(ref="#/components/schemas/Pessoa")
     *     ),
     *
     * )
     * */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
          'cep' => 'required',
          'logradouro' => 'required',
          'numero' => 'required',
          'bairro' => 'required',
          'uf' => 'required',
          'cidade' => 'required',
          'pais' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!$endereco = Endereco::find($id)) {
            return response()->json(['error' => "Não foi possível localizar o registro: {$id}"], 402);
        }

        if (!$updated = $endereco->update($request->all())) {
            return response()->json(['error' => "Não foi possível atualizar o registro: {$id}"], 422);
        }
        return response()->json([
          'message' => 'Registro atualizado com sucesso',
          'data' => $endereco
        ]);
    }

    /**
    * @OA\Delete(
    *      path="/api/enderecos/{id}",
    *      operationId="delete",
    *      tags={"Endereços"},
    *      summary="Deletar um endereço",
    *      description="",
    *      @OA\Parameter(
    *          name="id",
    *          description="ID do endereço",
    *          required=true,
    *          in="path",
    *          @OA\Schema(type="integer")
    *      ),
    *      @OA\Response(response=200, description="Ok"),
    *      @OA\Response(response=400, description="Bad request")
    *     )
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$endereco = Endereco::find($id)) {
            return response()->json(['error' => "Não foi possível localizar o registro: {$id}"], 402);
        }

        if (!$deleted = $endereco->delete()) {
            return response()->json(['error' => "Não foi possível deletar o registro: {$id}"], 422);
        }
        return response()->json([
          'message' => 'Registro deletado com sucesso',
        ]);
    }
}
