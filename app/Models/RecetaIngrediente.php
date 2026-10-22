<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class RecetaIngrediente extends Pivot
{
    protected $table = 'receta_ingrediente';

    public $incrementing = true;

    protected $fillable = ['receta_id', 'ingrediente_id', 'cantidad', 'unidad_medida'];

    protected $casts = [
        'cantidad' => 'float',
    ];
}