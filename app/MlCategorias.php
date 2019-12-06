<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class MlCategorias extends Model
{
    use Notifiable, HasApiTokens;

    /**
     * Todos los atributos son modificables
     *
     * @var array
     */
    protected $guarded = [];
}
