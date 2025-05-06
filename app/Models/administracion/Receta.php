<?php

namespace App\Models\administracion;

use App\Models\catalogo\DuracionTratamiento;
use App\Models\catalogo\FrecuenciaMedicamento;
use App\Models\catalogo\Producto;
use App\Models\catalogo\UnidadMedida;
use App\Models\catalogo\ViaAdministracion;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table='receta';

    protected $primaryKey='id';

    protected $fillable = [
        'consulta_medica_id',
        'producto_id',
        'cantidad',
        'unidad_medida_id',
        'frecuencia_medicamento_id',
        'via_administracion_id',
        'duracion',
        'duracion_tratamiento_id'
    ];

    // Relaciones
    public function consultaMedica()
    {
        return $this->belongsTo(ConsultaMedica::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }

    public function frecuenciaMedicamento()
    {
        return $this->belongsTo(FrecuenciaMedicamento::class, 'frecuencia_medicamento_id');
    }

    public function viaAdministracion()
    {
        return $this->belongsTo(ViaAdministracion::class, 'via_administracion_id');
    }

    public function duracionTratamiento()
    {
        return $this->belongsTo(DuracionTratamiento::class, 'duracion_tratamiento_id');
    }
}
