<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class TipoVacuna extends Model
{
    protected $table='tipo_vacuna';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
