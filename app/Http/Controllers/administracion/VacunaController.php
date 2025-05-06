<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Vacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class VacunaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'tipo_vacuna_id' => 'required|exists:tipo_vacuna,id',
            'fecha' => 'required|date',
            'comentario' => 'nullable|string|max:255',
        ], [
            'paciente_id.required' => 'El paciente es obligatorio.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',
            'tipo_vacuna_id.required' => 'Debe seleccionar una vacuna.',
            'tipo_vacuna_id.exists' => 'La vacuna seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'comentario.max' => 'El comentario no debe exceder 255 caracteres.',
        ]);

        try {
            $vacuna = new Vacuna();
            $vacuna->paciente_id = $request->paciente_id;
            $vacuna->tipo_vacuna_id = $request->tipo_vacuna_id;
            $vacuna->fecha = $request->fecha;
            $vacuna->comentario = $request->comentario;
            $vacuna->users_id = auth()->id();
            $vacuna->save();

            return Redirect::to('paciente/' . $request->paciente_id . '?tab=3')->with('success', 'Paciente registrado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar vacuna: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al registrar la vacuna.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'tipo_vacuna_id' => 'required|exists:tipo_vacuna,id',
            'fecha' => 'required|date',
            'comentario' => 'nullable|string|max:255',
        ], [
            'paciente_id.required' => 'El paciente es obligatorio.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',
            'tipo_vacuna_id.required' => 'Debe seleccionar una vacuna.',
            'tipo_vacuna_id.exists' => 'La vacuna seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'comentario.max' => 'El comentario no debe exceder 255 caracteres.',
        ]);

        try {
            $vacuna = Vacuna::findOrFail($id);
            $vacuna->tipo_vacuna_id = $request->tipo_vacuna_id;
            $vacuna->fecha = $request->fecha;
            $vacuna->comentario = $request->comentario;
            $vacuna->save();

            return Redirect::to('paciente/' . $request->paciente_id . '?tab=3')->with('success', 'Vacuna modificada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al modificar vacuna: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al modificar la vacuna.');
        }
    }

    public function destroy($id)
    {
        try {
            $vacuna = Vacuna::findOrFail($id);
            $vacuna->delete();
            return Redirect::to('paciente/' . $vacuna->paciente_id . '?tab=3')->with('success', 'Vacuna eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar vacuna: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar la vacuna.');
        }
    }
}
