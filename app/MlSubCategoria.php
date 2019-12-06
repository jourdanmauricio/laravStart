<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class MlSubCategoria extends Model
{
    use Notifiable, HasApiTokens;

    /**
     * Todos los atributos son modificables
     *
     * @var array
     */
    protected $guarded = [];

    public function mlcategoriachildren()
    {
        return $this->hasMany(MlCategoriaChildren::class, 'ml_id', 'child');
        // return $this->hasMany(MlCategoriaChildren::class);
    }
}
