<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table='departamento';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
    ];

    protected $guarded =[

    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'departamento_id');
    }
}
