<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Pessoa;

class PessoaControllerTest extends TestCase
{
    use WithFaker, DatabaseMigrations, DatabaseTransactions;

    public function testListarTodasPessoas()
    {
        $response = $this->get('api/pessoas');
        $response->assertStatus(200);
    }

    public function testBuscarUmaPessoa()
    {
        $pessoa = factory(Pessoa::class)->create();
        $response = $this->get("api/pessoas/{$pessoa->id}");
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

    public function testCadastrarPessoa()
    {
        $data = factory(Pessoa::class)->raw();
        $response = $this->post('/api/pessoas', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('pessoas', ['nome' => $data['nome']]);
    }

    public function testAtualizarPessoa()
    {
        $pessoa = factory(Pessoa::class)->create();
        $response = $this->get("api/pessoas/{$pessoa->id}");
        $data = $response->getData();
        $data->nome = $this->faker->name;
        $response = $this->put("api/pessoas/{$pessoa->id}", (array)$data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('pessoas', [
          'nome' => $data->nome,
        ]);
    }

    public function testDeletarPessoa()
    {
        $pessoa = factory(Pessoa::class)->create();

        $response = $this->delete("api/pessoas/{$pessoa->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message'
        ]);

        $this->assertDatabaseMissing('pessoas', ['id' => $pessoa->id]);
    }
}
