<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    protected $fillable = [
      'cep',
      'logradouro',
      'numero',
      'complemento',
      'bairro',
      'uf',
      'cidade',
      'pais',
    ];
}
