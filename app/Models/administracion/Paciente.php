<?php

namespace App\Models\administracion;

use App\Models\catalogo\EstadoCivil;
use App\Models\catalogo\EstadoPaciente;
use App\Models\catalogo\Pais;
use App\Models\Distrito;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table='paciente';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable = [
        'nombre',
        'apellido',
        'sexo',
        'correo',
        'fecha_nacimiento',
        'foto',
        'telefono_fijo',
        'telefono',
        'observaciones',
        'documento',
        'pais_id',
        'distrito_id',
        'estado_civil_id',
        'direccion',
        'estado_paciente_id',
        'patologicos',
        'no_patologicos',
        'familiares',
        'quirurgicos',
        'alergias',
        'medicamentos',
    ];



    protected $guarded =[

    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    public function estadoPaciente()
    {
        return $this->belongsTo(EstadoPaciente::class, 'estado_paciente_id');
    }

    public function consultas()
    {
        return $this->hasMany(ConsultaMedica::class, 'paciente_id');
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class, 'paciente_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'paciente_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }
}
