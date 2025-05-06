<?php

namespace App\Models\administracion;

use App\Models\catalogo\EstadoConsulta;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ConsultaMedica extends Model
{
    protected $table='consulta_medica';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable = [
        'paciente_id',
        'fecha',
        'hora_inicio',
        'hora_final',
        'estado_consulta_id',
        'motivo',
        'examen_fisico',
        'diagnostico',
        'recomendaciones',
        'users_id',
        'created_at',
        'updated_at',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function estadoConsulta()
    {
        return $this->belongsTo(EstadoConsulta::class, 'estado_consulta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'consulta_medica_id');
    }

}
