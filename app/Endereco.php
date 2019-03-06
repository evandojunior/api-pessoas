<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    protected $fillables = [
      'cep',
      'logradouro',
      'numero',
      'complemento',
      'bairro',
      'uf',
      'cidade',
      'pais'
    ];
}
