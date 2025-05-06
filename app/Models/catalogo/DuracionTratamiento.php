<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class DuracionTratamiento extends Model
{
    protected $table='duracion_tratamiento';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
