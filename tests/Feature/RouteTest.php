<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    public function testExisteRotaDocumentacao()
    {
        $response = $this->get('/api/documentation');

        $this->assertEquals(200, $response->status());
    }

    public function testExisteRotaPessoa()
    {
        $response = $this->get('/api/pessoas');

        $this->assertEquals(200, $response->status());
    }

    public function testExisteRotaEndereco()
    {
        $response = $this->get('/api/enderecos');

        $response->assertStatus(200);
    }
}
