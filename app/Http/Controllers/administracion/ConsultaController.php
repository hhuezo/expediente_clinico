<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\ConsultaMedica;
use App\Models\administracion\Receta;
use App\Models\catalogo\DuracionTratamiento;
use App\Models\catalogo\FrecuenciaMedicamento;
use App\Models\catalogo\Producto;
use App\Models\catalogo\UnidadMedida;
use App\Models\catalogo\ViaAdministracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultaController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            'metodo_pago_id' => 'required|integer|exists:lugar_consulta,id',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',

            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',

            'hora_final.required' => 'La hora final es obligatoria.',
            'hora_final.date_format' => 'La hora final debe tener el formato HH:MM.',
            'hora_final.after' => 'La hora final debe ser posterior a la hora de inicio.',

            'metodo_pago_id.required' => 'El método de pago es obligatorio.',
            'metodo_pago_id.integer' => 'El método de pago debe ser un número entero.',
            'metodo_pago_id.exists' => 'El método de pago seleccionado no es válido.',
        ]);


        try {

            $consulta = new ConsultaMedica();
            $consulta->paciente_id = $request->paciente_id;
            $consulta->fecha = $request->fecha;
            $consulta->hora_inicio = $request->hora_inicio;
            $consulta->hora_final = $request->hora_final;
            $consulta->estado_consulta_id = 1;
            $consulta->users_id = auth()->id();
            $consulta->created_at = now();
            $consulta->updated_at = now();
            $consulta->save();

            return back()->with('success', 'Consulta médica registrada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar la consulta médica: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return back()->with('error', 'Ocurrió un error al guardar la consulta médica. Intente nuevamente.');
        }
    }

    public function show(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        return view('administracion.consulta.show', compact('consulta'));
    }


    public function edit(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        $productos = Producto::where('activo', 1)->get();
        $unidades_medida = UnidadMedida::where('activo', 1)->get();
        $frecuencias_medicamento = FrecuenciaMedicamento::where('activo', 1)->get();
        $vias_administracion = ViaAdministracion::where('activo', 1)->get();
        $duraciones_tratamiento = DuracionTratamiento::where('activo', 1)->get();
        return view('administracion.consulta.edit', compact('consulta', 'productos', 'unidades_medida', 'frecuencias_medicamento', 'vias_administracion', 'duraciones_tratamiento'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'motivo' => 'nullable|string|max:500',
            'examen_fisico' => 'nullable|string|max:500',
            'diagnostico' => 'nullable|string|max:500',
            'recomendaciones' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'motivo.max' => 'El motivo no debe exceder los 500 caracteres.',
            'examen_fisico.max' => 'El examen físico no debe exceder los 500 caracteres.',
            'diagnostico.max' => 'El diagnóstico no debe exceder los 500 caracteres.',
            'recomendaciones.max' => 'Las recomendaciones no deben exceder los 500 caracteres.',
            'observaciones.max' => 'Las observaciones no deben exceder los 500 caracteres.',
        ]);

        try {
            $consulta = ConsultaMedica::findOrFail($id);

            $consulta->motivo = $request->motivo;
            $consulta->examen_fisico = $request->examen_fisico;
            $consulta->diagnostico = $request->diagnostico;
            $consulta->recomendaciones = $request->recomendaciones;
            $consulta->observaciones = $request->observaciones;
            $consulta->updated_at = now();
            $consulta->save();

            return redirect()->back()->with('success', 'Consulta actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar consulta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la consulta.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function store_receta(Request $request)
    {
        // Validaciones de los campos del formulario
        $request->validate([
            'consulta_medica_id' => 'required|integer|exists:consulta_medica,id',
            'producto_id' => 'required|integer|exists:producto,id',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad_medida_id' => 'required|integer|exists:unidad_medida,id',
            'frecuencia_medicamento_id' => 'required|integer|exists:frecuencia_medicamento,id',
            'via_administracion_id' => 'required|integer|exists:via_administracion,id',
            'duracion' => 'required|numeric|min:1',
            'duracion_tratamiento_id' => 'required|integer|exists:duracion_tratamiento,id',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número entero válido.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'exists' => 'El valor seleccionado en :attribute no es válido.',
        ]);

        try {


            $receta = new Receta();
            $receta->consulta_medica_id = $request->consulta_medica_id;
            $receta->producto_id = $request->producto_id;
            $receta->cantidad = $request->cantidad;
            $receta->unidad_medida_id = $request->unidad_medida_id;
            $receta->frecuencia_medicamento_id = $request->frecuencia_medicamento_id;
            $receta->via_administracion_id = $request->via_administracion_id;
            $receta->duracion = $request->duracion;
            $receta->duracion_tratamiento_id = $request->duracion_tratamiento_id;

            // Guardar el modelo Receta
            $receta->save();

            return back()->with('success', 'Receta registrada correctamente.');
        } catch (\Exception $e) {
            // Capturar el error y registrar en log
            Log::error('Error al guardar receta: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al guardar la receta.');
        }
    }

    public function update_receta(Request $request, $id)
    {
        $request->validate([
            'consulta_medica_id' => 'required|integer|exists:consulta_medica,id',
            'producto_id' => 'required|integer|exists:producto,id',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad_medida_id' => 'required|integer|exists:unidad_medida,id',
            'frecuencia_medicamento_id' => 'required|integer|exists:frecuencia_medicamento,id',
            'via_administracion_id' => 'required|integer|exists:via_administracion,id',
            'duracion' => 'required|numeric|min:1',
            'duracion_tratamiento_id' => 'required|integer|exists:duracion_tratamiento,id',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número entero válido.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'exists' => 'El valor seleccionado en :attribute no es válido.',
        ]);

        try {


            $receta = Receta::findOrFail($id);
            $receta->consulta_medica_id = $request->consulta_medica_id;
            $receta->producto_id = $request->producto_id;
            $receta->cantidad = $request->cantidad;
            $receta->unidad_medida_id = $request->unidad_medida_id;
            $receta->frecuencia_medicamento_id = $request->frecuencia_medicamento_id;
            $receta->via_administracion_id = $request->via_administracion_id;
            $receta->duracion = $request->duracion;
            $receta->duracion_tratamiento_id = $request->duracion_tratamiento_id;

            // Guardar el modelo Receta
            $receta->save();

            return back()->with('success', 'Receta registrada correctamente.');
        } catch (\Exception $e) {
            // Capturar el error y registrar en log
            Log::error('Error al guardar receta: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al guardar la receta.');
        }
    }

    public function delete_receta($id)
    {
        try {
            // Validación del ID
            if (!is_numeric($id) || $id <= 0) {
                return back()->with('error', 'ID de receta inválido.');
            }

            $receta = Receta::findOrFail($id);
            $receta->delete();

            return back()->with('success', 'Receta eliminada correctamente.');
        } catch (\Exception $e) {
            // Capturar el error y registrar en log
            Log::error('Error al eliminar receta: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al eliminar la receta.');
        }
    }
}
