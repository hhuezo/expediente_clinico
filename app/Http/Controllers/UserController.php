<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePassword(Request $request)
{
    // Validaciones de la contraseña
    $validated = $request->validate([
        'id' => 'required|exists:users,id',
        'password' => 'required|string|min:6',
    ], [
        'id.required' => 'El usuario no es válido.',
        'id.exists' => 'El usuario no existe en la base de datos.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ]);

    try {
        // Buscar al usuario
        $user = User::findOrFail($request->id);

        // Actualizar la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        // Retornar con mensaje de éxito
        return back()->with('success', 'La contraseña se ha actualizado correctamente.');
    } catch (\Exception $e) {
        // Si ocurre un error, retornamos con mensaje de error
        return back()->with('error', 'Hubo un error al actualizar la contraseña. Intenta nuevamente.');
    }
}

}
