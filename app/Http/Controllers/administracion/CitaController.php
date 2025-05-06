<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Cita;
use App\Models\administracion\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CitaController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            'actividad' => 'nullable|string|max:500',
        ], [
            'paciente_id.required' => 'El paciente es obligatorio.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_final.required' => 'La hora final es obligatoria.',
            'hora_final.date_format' => 'La hora final debe tener el formato HH:MM.',
            'hora_final.after' => 'La hora final debe ser posterior a la hora de inicio.',
            'actividad.max' => 'La actividad no debe exceder 500 caracteres.',
        ]);

        try {

            $cita = new Cita();
            $cita->paciente_id = $request->paciente_id;
            $cita->fecha = $request->fecha;
            $cita->hora_inicio = $request->hora_inicio;
            $cita->hora_final = $request->hora_final;
            $cita->actividad = $request->actividad;
            $cita->users_id = auth()->id();
            $cita->save();

            return Redirect::to('paciente/' . $request->paciente_id . '?tab=5')
                ->with('success', 'Cita registrada correctamente.');
        } catch (\Exception $e) {

            Log::error('Error al guardar la cita: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al registrar la cita.');
        }
    }


    public function update(Request $request, string $id)
    {

        // Validación de los datos de entrada
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'fecha' => 'required|date',
            'hora_inicio' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'
            ],
            'hora_final' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/',
                'after:hora_inicio'
            ],
            'actividad' => 'nullable|string|max:500',
        ], [
            'paciente_id.required' => 'El paciente es obligatorio.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.regex' => 'La hora de inicio debe tener el formato HH:MM o HH:MM:SS.',
            'hora_final.required' => 'La hora final es obligatoria.',
            'hora_final.regex' => 'La hora final debe tener el formato HH:MM o HH:MM:SS.',
            'hora_final.after' => 'La hora final debe ser posterior a la hora de inicio.',
            'actividad.max' => 'La actividad no debe exceder 500 caracteres.',
        ]);

        try {

            $cita = Cita::findOrFail($id);
            $cita->paciente_id = $request->paciente_id;
            $cita->fecha = $request->fecha;
            $cita->hora_inicio = $request->hora_inicio;
            $cita->hora_final = $request->hora_final;
            $cita->actividad = $request->actividad;
            $cita->save();

            return Redirect::to('paciente/' . $request->paciente_id . '?tab=5')
                ->with('success', 'Cita registrada correctamente.');
        } catch (\Exception $e) {

            Log::error('Error al guardar la cita: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al registrar la cita.');
        }
    }

    public function destroy($id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();
            return Redirect::to('paciente/' . $cita->paciente_id . '?tab=5')->with('success', 'cita eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar cita: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar la cita.');
        }
    }


    public function calendario()
    {
        $pacientes = Paciente::get();
        return view('administracion.calendario.index',compact('pacientes'));
    }

    public function calendario_store_cita(Request $request)
    {
         // Validación de los datos de entrada
         $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            'actividad' => 'nullable|string|max:500',
        ], [
            'paciente_id.required' => 'El paciente es obligatorio.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_final.required' => 'La hora final es obligatoria.',
            'hora_final.date_format' => 'La hora final debe tener el formato HH:MM.',
            'hora_final.after' => 'La hora final debe ser posterior a la hora de inicio.',
            'actividad.max' => 'La actividad no debe exceder 500 caracteres.',
        ]);

        try {

            $cita = new Cita();
            $cita->paciente_id = $request->paciente_id;
            $cita->fecha = $request->fecha;
            $cita->hora_inicio = $request->hora_inicio;
            $cita->hora_final = $request->hora_final;
            $cita->actividad = $request->actividad;
            $cita->users_id = auth()->id();
            $cita->save();

            return back()->with('success', 'Cita registrada correctamente.');
        } catch (\Exception $e) {

            Log::error('Error al guardar la cita: ' . $e->getMessage());

            return back()->with('error', 'Ocurrió un error al registrar la cita.');
        }
    }

    public function get_eventos(string $mes, string $anio)
    {
        try {
            // Calculamos el primer día del mes
            $fecha_inicio = "$anio-$mes-01";

            // Usamos Carbon para obtener el último día del mes
            $fecha_final = Carbon::parse($fecha_inicio)->endOfMonth()->format('Y-m-d');

            // Realizamos la consulta para obtener los eventos
            $eventos = Cita::join('paciente', 'paciente.id', '=', 'paciente_cita.paciente_id')
                ->select(
                    'paciente_cita.id',
                    DB::raw('CONCAT(paciente.nombre, " ", paciente.apellido) as nombre_completo'),
                    DB::raw('CONCAT(paciente_cita.fecha, "T", paciente_cita.hora_inicio) as fecha_inicio'),
                    DB::raw('CONCAT(paciente_cita.fecha, "T", paciente_cita.hora_final) as fecha_final')
                )
                ->whereBetween('paciente_cita.fecha', [$fecha_inicio, $fecha_final])
                ->get();

            // Si todo va bien, retornamos el resultado (eventos)
            return response()->json([
                'success' => true,
                'eventos' => $eventos
            ]);
        } catch (\Exception $e) {
            // Si hay un error, devolvemos false y el mensaje de error
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function get_lista_eventos(string $mes, string $anio)
    {
        try {
            // Calculamos el primer día del mes
            $fecha_inicio = "$anio-$mes-01";

            // Usamos Carbon para obtener el último día del mes
            $fecha_final = Carbon::parse($fecha_inicio)->endOfMonth()->format('Y-m-d');

            // Realizamos la consulta para obtener los eventos
            $eventos = Cita::join('paciente', 'paciente.id', '=', 'paciente_cita.paciente_id')
                ->select(
                    'paciente_cita.id',
                    DB::raw('CONCAT(paciente.nombre, " ", paciente.apellido) as nombre_completo'),
                    DB::raw('CONCAT(paciente_cita.fecha, "T", paciente_cita.hora_inicio) as fecha_inicio'),
                    DB::raw('CONCAT(paciente_cita.fecha, "T", paciente_cita.hora_final) as fecha_final')
                )
                ->whereBetween('paciente_cita.fecha', [$fecha_inicio, $fecha_final])
                ->orderBy('paciente_cita.fecha')
                ->orderBy('paciente_cita.hora_inicio')
                ->get();

                return view('administracion.calendario.lista_eventos', compact('eventos'));


        } catch (\Exception $e) {
            // Si hay un error, devolvemos false y el mensaje de error
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


}
