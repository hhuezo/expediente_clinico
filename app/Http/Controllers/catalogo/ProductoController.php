<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::get();
        return view('catalogo.producto.index', compact('productos'));
    }


    public function store(Request $request)
    {
        // Validación del campo 'nombre'
        $request->validate([
            'nombre' => 'required|string|max:150',
        ]);

        try {

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->activo = 1;
            $producto->save();

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

            $producto = Producto::findOrFail($id);
            $producto->nombre = $request->nombre;
            $producto->save();

            return back()->with('success', 'Registro modificado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al guardar el registro.');
        }
    }


    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->activo = ($producto->activo == 1) ? 0 : 1;
            $producto->save();

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
