<?php

namespace App\Models\administracion;

use App\Models\catalogo\TipoVacuna;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    protected $table='paciente_vacuna';

    protected $primaryKey='id';

    protected $fillable = [
        'paciente_id',
        'fecha',
        'tipo_vacuna_id',
        'users_id',
        'comentario',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tipoVacuna()
    {
        return $this->belongsTo(TipoVacuna::class);
    }



    public function usuario()
    {
        return $this->belongsTo(User::class,'users_id');
    }
}
