<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\TipoVacuna;
use Illuminate\Http\Request;

class TipoVacunaController extends Controller
{

    public function index()
    {
        $tipos_vacuna = TipoVacuna::get();
        return view('catalogo.tipo_vacuna.index', compact('tipos_vacuna'));
    }

    public function store(Request $request)
    {
         // Validación del campo 'nombre'
         $request->validate([
            'nombre' => 'required|string|max:150',
        ]);

        try {

            $tipo_vacuna = new TipoVacuna();
            $tipo_vacuna->nombre = $request->nombre;
            $tipo_vacuna->activo = 1;
            $tipo_vacuna->save();

            return back()->with('success', 'Registro registrado correctamente.');
        } catch (\Exception $e) {

            return back()->with('error', 'Ocurrió un error al guardar el registro.');
        }
    }

    public function update(Request $request, string $id)
    {
        // Validación del campo 'nombre'
        $request->validate([
            'nombre' => 'required|string|max:150',
        ]);

        try {

            $tipo_vacuna = TipoVacuna::findOrFail($id);
            $tipo_vacuna->nombre = $request->nombre;
            $tipo_vacuna->save();

            return back()->with('success', 'Registro modificado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al guardar el registro.');
        }
    }


    public function destroy(string $id)
    {
        try {
            $tipo_vacuna = TipoVacuna::findOrFail($id);
            $tipo_vacuna->activo = ($tipo_vacuna->activo == 1) ? 0 : 1;
            $tipo_vacuna->save();

            return response()->json([
                'success' => true,
                'message' => 'registro cambiado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al desactivar al registro. Intenta nuevamente.',
                'error' => $e->getMessage() // Opcional: para incluir detalles del error
            ]);
        }
    }
}
