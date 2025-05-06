<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Paciente;
use App\Models\catalogo\EstadoCivil;
use App\Models\catalogo\LugarConsulta;
use App\Models\catalogo\Pais;
use App\Models\catalogo\TipoVacuna;
use App\Models\Departamento;
use App\Models\Distrito;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::get();

        return view('administracion.paciente.index', compact('pacientes'));
    }

    public function create()
    {
        $paises = Pais::where('activo', 1)->get();
        $estados_civiles = EstadoCivil::get();
        $departamentos = Departamento::get();
        return view('administracion.paciente.create', compact('paises', 'estados_civiles', 'departamentos'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'sexo' => 'required|in:1,2',
            'correo' => 'nullable|email|max:50',
            'fecha_nacimiento' => 'required|date',
            'telefono_fijo' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string|max:500',
            'documento' => 'nullable|string|max:20',
            'pais_id' => 'nullable|integer|exists:pais,id',
            'distrito_id' => 'required_if:pais_id,1|nullable|integer|exists:distrito,id',
            'estado_civil_id' => 'nullable|integer|exists:estado_civil,id',
            'direccion' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'sexo.required' => 'Debe seleccionar el sexo.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
            'distrito_id.required_if' => 'Debe seleccionar un distrito.',
        ]);


        try {
            DB::beginTransaction();

            $paciente = new Paciente();
            $paciente->nombre = $validatedData['nombre'];
            $paciente->apellido = $validatedData['apellido'];
            $paciente->sexo = $validatedData['sexo'];
            $paciente->correo = $validatedData['correo'] ?? null;
            $paciente->fecha_nacimiento = $validatedData['fecha_nacimiento'];
            $paciente->telefono_fijo = $validatedData['telefono_fijo'] ?? null;
            $paciente->telefono = $validatedData['telefono'] ?? null;
            $paciente->observaciones = $validatedData['observaciones'] ?? null;
            $paciente->documento = $validatedData['documento'] ?? null;
            $paciente->pais_id = $validatedData['pais_id'] ?? null;
            $paciente->distrito_id = $validatedData['distrito_id'] ?? null;
            $paciente->estado_civil_id = $validatedData['estado_civil_id'] ?? null;
            $paciente->direccion = $validatedData['direccion'] ?? null;

            $paciente->save();

            // Procesar la imagen si se subió
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();
                $filename = "paciente_" . $paciente->id . '.' . $extension;
                $file->move(public_path('imagenes'), $filename);

                // Guardar la ruta del archivo en el modelo
                $paciente->foto = $filename;
                $paciente->save();
            }

            DB::commit();

            return Redirect::to('paciente')->with('success', 'Paciente registrado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Ocurrió un error al guardar:');
            //return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }


    public function show(Request $request, string $id)
    {
        $tab = $request->tab ?? 1;

        $paciente = Paciente::findOrFail($id);
        $edad = Carbon::parse($paciente->fecha_nacimiento)->age ?? '';

        $lugares_consulta = LugarConsulta::get();

        $tipos_vacuna = TipoVacuna::get();

        return view('administracion.paciente.show', compact('paciente', 'edad', 'tab','lugares_consulta','tipos_vacuna'));
    }


    public function edit(string $id)
    {

        $paises = Pais::where('activo', 1)->get();
        $estados_civiles = EstadoCivil::get();
        $departamentos = Departamento::get();

        $paciente = Paciente::findOrFail($id);
        $distritos = Distrito::whereHas('municipio', function ($query) use ($paciente) {
            $query->where('departamento_id', $paciente->distrito->municipio->departamento_id);
        })->orderBy('nombre')->get();
        return view('administracion.paciente.edit', compact('paciente', 'paises', 'estados_civiles', 'departamentos', 'distritos'));
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'sexo' => 'required|in:1,2',
            'correo' => 'nullable|email|max:50',
            'fecha_nacimiento' => 'required|date',
            'telefono_fijo' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string|max:500',
            'documento' => 'nullable|string|max:20',
            'pais_id' => 'nullable|integer|exists:pais,id',
            'distrito_id' => 'required_if:pais_id,1|nullable|integer|exists:distrito,id',
            'estado_civil_id' => 'nullable|integer|exists:estado_civil,id',
            'direccion' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'sexo.required' => 'Debe seleccionar el sexo.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
            'distrito_id.required_if' => 'Debe seleccionar un distrito.',
        ]);


        try {
            DB::beginTransaction();

            $paciente = Paciente::findOrFail($id);
            $paciente->nombre = $validatedData['nombre'];
            $paciente->apellido = $validatedData['apellido'];
            $paciente->sexo = $validatedData['sexo'];
            $paciente->correo = $validatedData['correo'] ?? null;
            $paciente->fecha_nacimiento = $validatedData['fecha_nacimiento'];
            $paciente->telefono_fijo = $validatedData['telefono_fijo'] ?? null;
            $paciente->telefono = $validatedData['telefono'] ?? null;
            $paciente->observaciones = $validatedData['observaciones'] ?? null;
            $paciente->documento = $validatedData['documento'] ?? null;
            $paciente->pais_id = $validatedData['pais_id'] ?? null;
            $paciente->distrito_id = $validatedData['distrito_id'] ?? null;
            $paciente->estado_civil_id = $validatedData['estado_civil_id'] ?? null;
            $paciente->direccion = $validatedData['direccion'] ?? null;

            $paciente->save();

            // Procesar la imagen si se subió
            if ($request->hasFile('foto')) {
                // Eliminar imagen anterior si existe
                if ($paciente->foto && file_exists(public_path('imagenes/' . $paciente->foto))) {
                    unlink(public_path('imagenes/' . $paciente->foto));
                }

                // Subir nueva imagen
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();
                $filename = "paciente_" . $paciente->id . '.' . $extension;
                $file->move(public_path('imagenes'), $filename);

                // Guardar nueva ruta en el modelo
                $paciente->foto = $filename;
                $paciente->save();
            }


            DB::commit();

            return Redirect::to('paciente')->with('success', 'Paciente modificado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Ocurrió un error al modificar:');
            //return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }


    public function update_antecedentes(Request $request, string $id)
    {
        // Validar que los campos no tengan más de 500 caracteres
        $validatedData = $request->validate([
            'patologicos' => 'nullable|string|max:500',
            'no_patologicos' => 'nullable|string|max:500',
            'familiares' => 'nullable|string|max:500',
            'quirurgicos' => 'nullable|string|max:500',
            'alergias' => 'nullable|string|max:500',
            'medicamentos' => 'nullable|string|max:500',
        ], [
            'patologicos.max' => 'El campo Patológicos no puede tener más de 500 caracteres.',
            'no_patologicos.max' => 'El campo No Patológicos no puede tener más de 500 caracteres.',
            'familiares.max' => 'El campo Familiares no puede tener más de 500 caracteres.',
            'quirurgicos.max' => 'El campo Quirúrgicos no puede tener más de 500 caracteres.',
            'alergias.max' => 'El campo Alergias no puede tener más de 500 caracteres.',
            'medicamentos.max' => 'El campo Medicamentos no puede tener más de 500 caracteres.',
        ]);

        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->patologicos = $request->patologicos;
            $paciente->no_patologicos = $request->no_patologicos;
            $paciente->familiares = $request->familiares;
            $paciente->quirurgicos = $request->quirurgicos;
            $paciente->alergias = $request->alergias;
            $paciente->medicamentos = $request->medicamentos;
            $paciente->save();


            return Redirect::to('paciente/' . $id . '?tab=1')->with('success', 'Paciente modificado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar paciente con ID: ' . $id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Redirect::to('paciente/' . $id . '?tab=1')->with('error', 'Ocurrió un error al actualizar los datos del paciente: ');
        }
    }




    public function destroy(string $id)
    {
        //
    }



    public function get_distritos(string $id)
    {
        try {
            $distritos = Distrito::join('municipio', 'distrito.municipio_id', '=', 'municipio.id')
                ->where('municipio.departamento_id', $id)
                ->select('distrito.*')->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $distritos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los distritos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
