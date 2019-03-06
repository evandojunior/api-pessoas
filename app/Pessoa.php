<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    //
    protected $fillables = [
      'nome',
      'endereco_id',
      'data_nascimento',
      'cpf',
      'sexo'
    ];


    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}
