<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class LugarConsulta extends Model
{
    protected $table='lugar_consulta';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
