<?php

use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('se instancia una receta con sus ingredientes, cantidad y unidad', function () {
    $receta = Receta::create([
        'titulo'        => 'Gallo pinto',
        'porciones'     => 4,
        'instrucciones' => 'Sofreír la cebolla, agregar el arroz y los frijoles y mezclar.',
    ]);

    $arroz    = Ingrediente::create(['nombre' => 'Arroz']);
    $frijoles = Ingrediente::create(['nombre' => 'Frijoles']);
    $cebolla  = Ingrediente::create(['nombre' => 'Cebolla']);

    // attach() llena la tabla intermedia con los datos de la clase asociación
    $receta->ingredientes()->attach([
        $arroz->id    => ['cantidad' => 2,   'unidad_medida' => 'tazas'],
        $frijoles->id => ['cantidad' => 1.5, 'unidad_medida' => 'tazas'],
        $cebolla->id  => ['cantidad' => 1,   'unidad_medida' => 'unidad'],
    ]);

    $receta->load('ingredientes');
    $arrozEnReceta = $receta->ingredientes->firstWhere('nombre', 'Arroz');

    expect($receta->titulo)->toBe('Gallo pinto')
        ->and($receta->porciones)->toBe(4)
        ->and($receta->ingredientes)->toHaveCount(3)          // 1..*
        ->and($arrozEnReceta->pivot->cantidad)->toBe(2.0)
        ->and($arrozEnReceta->pivot->unidad_medida)->toBe('tazas')
        ->and($arroz->recetas()->first()->id)->toBe($receta->id); // navegable desde el ingrediente
});