<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table='estado_civil';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
