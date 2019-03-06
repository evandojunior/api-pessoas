<?php

use Illuminate\Database\Seeder;
use App\Endereco;

class EnderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Endereco::class, 10)->create();
    }
}
