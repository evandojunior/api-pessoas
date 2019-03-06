<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    //
    protected $fillable = [
      'nome',
      'cpf',
      'nascionalidade',
      'data_nascimento',
      'sexo',
      'endereco_id',
    ];


    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}
