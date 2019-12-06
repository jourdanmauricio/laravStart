<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class MlCategoriaChildren extends Model
{
    use Notifiable, HasApiTokens;

    /**
     * Todos los atributos son modificables
     *
     * @var array
     */
    protected $guarded = [];

    public function mlsubcategoria()
    {
        return $this->belongsTo(MlSubCategoria::class, 'child', 'ml_id');
        // return $this->belongsTo(MlSubCategoria::class);
    }
}
