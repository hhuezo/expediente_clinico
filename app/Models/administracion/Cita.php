<?php

namespace App\Models\administracion;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table='paciente_cita';

    protected $primaryKey='id';

    protected $fillable = [
        'paciente_id',
        'fecha',
        'hora_inicio',
        'hora_final',
        'users_id',
        'actividad',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class,'users_id');
    }
}
