<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class FrecuenciaMedicamento extends Model
{
    protected $table='frecuencia_medicamento';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
