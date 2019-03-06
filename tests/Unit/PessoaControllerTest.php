<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Pessoa;

class PessoaControllerTest extends TestCase
{
    public function testListarTodasPessoas()
    {
        $response = $this->get('api/pessoas');
        $response->assertStatus(200);
    }

    public function testVerificarEstruturaPessoa()
    {
        $response = $this->get('api/pessoas/1');
        $response->assertStatus(200);
        $response->assertJsonStructure(
         [
             "id",
             "endereco_id",
             "nome",
             "data_nascimento",
             "nascionalidade",
             "cpf",
             "sexo",
             "created_at",
             "updated_at",
             "endereco",
         ]
      );
    }

    public function testPostPessoa()
    {
        $data = factory(Pessoa::class)->raw();
        $response = $this->post('/api/pessoas', $data);
        $response->assertStatus(200);
    }
}
