<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class EstadoConsulta extends Model
{
    protected $table='estado_consulta';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
