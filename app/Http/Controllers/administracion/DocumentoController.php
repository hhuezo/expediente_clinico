<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'paciente_id' => 'required|exists:paciente,id',
        'descripcion' => 'required|string|max:255',
        'archivo' => 'required|file|max:2048', // 2MB = 2048 KB
    ], [
        'paciente_id.required' => 'El paciente es obligatorio.',
        'paciente_id.exists' => 'El paciente seleccionado no existe.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.max' => 'La descripción no debe exceder 255 caracteres.',
        'archivo.required' => 'Debe seleccionar un archivo.',
        'archivo.file' => 'El archivo no es válido.',
        'archivo.max' => 'El archivo no debe pesar más de 2MB.',
    ]);

    try {
        $documento = new Documento();
        $documento->paciente_id = $request->paciente_id;
        $documento->descripcion = $request->descripcion;
        $documento->users_id = auth()->id();
        $documento->save();

        // Luego se procesa el archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = 'documento_' . $documento->id . '.' . $extension;
            $ruta = $archivo->storeAs('documentos', $nombreArchivo, 'public');
            $documento->archivo = $nombreArchivo;
            $documento->save(); // Actualiza con la ruta del archivo
        }

        return Redirect::to('paciente/' . $request->paciente_id . '?tab=4')
            ->with('success', 'Documento registrado correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al guardar documento: ' . $e->getMessage());
        return back()->with('error', 'Ocurrió un error al registrar el documento.');
    }
}


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'paciente_id' => 'required|exists:paciente,id',
    //         'tipo_vacuna_id' => 'required|exists:tipo_vacuna,id',
    //         'fecha' => 'required|date',
    //         'comentario' => 'nullable|string|max:255',
    //     ], [
    //         'paciente_id.required' => 'El paciente es obligatorio.',
    //         'paciente_id.exists' => 'El paciente seleccionado no existe.',
    //         'tipo_vacuna_id.required' => 'Debe seleccionar una vacuna.',
    //         'tipo_vacuna_id.exists' => 'La vacuna seleccionada no es válida.',
    //         'fecha.required' => 'La fecha es obligatoria.',
    //         'fecha.date' => 'La fecha no tiene un formato válido.',
    //         'comentario.max' => 'El comentario no debe exceder 255 caracteres.',
    //     ]);

    //     try {
    //         $vacuna = Vacuna::findOrFail($id);
    //         $vacuna->tipo_vacuna_id = $request->tipo_vacuna_id;
    //         $vacuna->fecha = $request->fecha;
    //         $vacuna->comentario = $request->comentario;
    //         $vacuna->save();

    //         return Redirect::to('paciente/' . $request->paciente_id . '?tab=3')->with('success', 'Vacuna modificada correctamente.');
    //     } catch (\Exception $e) {
    //         Log::error('Error al modificar vacuna: ' . $e->getMessage());
    //         return back()->with('error', 'Ocurrió un error al modificar la vacuna.');
    //     }
    // }

    public function destroy($id)
    {
        try {
            $documento = Documento::findOrFail($id);

            $rutaArchivo = 'documentos/' . $documento->archivo;
            // Eliminar el archivo si existe en public/documentos/
            if (Storage::disk('public')->exists($rutaArchivo)) {
                // Eliminar el archivo
                Storage::disk('public')->delete($rutaArchivo);
            } else {
                Log::warning('El archivo no existe en la ruta especificada: ' . $rutaArchivo);
            }

            $documento->delete();
            return Redirect::to('paciente/' . $documento->paciente_id . '?tab=4')->with('success', 'documento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar la documento.');
        }
    }
}
