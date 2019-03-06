<?php

use App\Endereco;
use Faker\Generator as Faker;

$factory->define(Endereco::class, function (Faker $faker) {

    $data = [
      'pais'        => "Brasil",
      'cep'         => $faker->postcode,
      'logradouro'  => $faker->streetAddress,
      'numero'      => $faker->buildingNumber,
      'complemento' => $faker->secondaryAddress,
      'bairro'      => $faker->streetName,
      'uf'          => $faker->stateAbbr,
      'cidade'      => $faker->city,
    ];
    return $data;
});
