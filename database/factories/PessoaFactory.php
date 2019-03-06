<?php

use App\Pessoa;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;

$factory->define(Pessoa::class, function (Faker $faker) {
    $data = [
        'nome'            => $faker->name,
        'data_nascimento' => $faker->date,
        'cpf'             => $faker->cpf(false),
        'sexo'            => Arr::random(['Masculino' ,'Feminino', 'Outros']),
        'endereco_id'     => ((factory(App\Endereco::class)->create())->id)
    ];
    return $data;
});
