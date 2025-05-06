<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Model;

class ViaAdministracion extends Model
{
    protected $table='via_administracion';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo'
    ];
}
