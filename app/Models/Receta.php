<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receta extends Model
{
    protected $table = 'recetas';

    protected $fillable = ['titulo', 'porciones', 'instrucciones'];

    protected $casts = [
        'porciones' => 'integer',
    ];

    public function ingredientes(): BelongsToMany
    {
        return $this->belongsToMany(Ingrediente::class, 'receta_ingrediente')
            ->using(RecetaIngrediente::class)
            ->withPivot('cantidad', 'unidad_medida')
            ->withTimestamps();
    }
}