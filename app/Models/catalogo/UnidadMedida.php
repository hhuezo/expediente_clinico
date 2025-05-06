<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table='unidad_medida';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
