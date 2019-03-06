<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    public function testExisteTabelaPessoas()
    {
        $response = \Schema::hasTable('pessoas');

        $this->assertTrue($response);
    }

    public function testExisteTabelaEnderecos()
    {
        $response = \Schema::hasTable('enderecos');

        $this->assertTrue($response);
    }
}
