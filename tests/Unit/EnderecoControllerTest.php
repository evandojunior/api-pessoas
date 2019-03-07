<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Endereco;

class EnderecoControllerTest extends TestCase
{
    use WithFaker, DatabaseMigrations, DatabaseTransactions;

    public function testListarTodosEnderecos()
    {
        $response = $this->get('api/enderecos');
        $response->assertStatus(200);
    }

    public function testVerificarEndereco()
    {
        $endereco = factory(Endereco::class)->create();
        $response = $this->get("api/enderecos/{$endereco->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(
         [
           "id",
           "cep",
           "logradouro",
           "numero",
           "complemento",
           "bairro",
           "pais",
           "uf",
           "cidade",
           "created_at",
           "updated_at",
         ]
      );
    }

    public function testCadastrarEndereco()
    {
        $data = factory(Endereco::class)->raw();
        $response = $this->post('/api/enderecos', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('enderecos', ['cep' => $data['cep']]);
    }

    public function testAtualizarEndereco()
    {
        $endereco = factory(Endereco::class)->create();
        $response = $this->get("api/enderecos/{$endereco->id}");
        $data = $response->getData();
        $data->cep = $this->faker->postcode();
        $data->logradouro = $this->faker->streetAddress();
        $data->cidade = $this->faker->city();
        $data->uf = $this->faker->stateAbbr();
        $response = $this->put("api/enderecos/{$endereco->id}", (array)$data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('enderecos', [
          'cep'        => $data->cep,
          'logradouro' => $data->logradouro,
          'cidade'     => $data->cidade,
          'uf'         => $data->uf
        ]);
    }

    public function testDeletarEndereco()
    {
        $endereco = factory(Endereco::class)->create();

        $response = $this->delete("api/enderecos/{$endereco->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseMissing('enderecos', ['id' => $endereco->id]);
    }
}
