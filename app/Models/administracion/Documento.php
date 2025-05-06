<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table='paciente_documento';

    protected $primaryKey='id';

    protected $fillable = [
        'paciente_id',
        'descripcion',
        'url',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
