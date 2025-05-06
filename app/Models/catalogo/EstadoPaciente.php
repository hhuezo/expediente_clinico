<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class EstadoPaciente extends Model
{
    protected $table='estado_paciente';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
