@extends ('menu')
@section('content')

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- JS de Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
        }

        .avatar.avatar-xxl {
            width: 8rem;
            height: 8rem;
        }
    </style>





    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Consulta
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ url('paciente') }}/{{$consulta->paciente_id}}?tab=2"><button class="btn btn-primary"><i
                                    class="bi bi-arrow-90deg-left"></i></button></a>
                    </div>
                </div>

                <form method="POST" action="{{ route('consulta.update', $consulta->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <script>
                                toastr.success("{{ session('success') }}");
                            </script>
                        @endif

                        @if (session('error'))
                            <script>
                                toastr.error("{{ session('error') }}");
                            </script>
                        @endif

                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <label class="form-label">Motivo de la Consulta:</label>
                                <textarea class="form-control" name="motivo" oninput="this.value = this.value.toUpperCase()">{{ $consulta->motivo }}</textarea>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Examen Físico:</label>
                                <textarea class="form-control" name="examen_fisico" oninput="this.value = this.value.toUpperCase()">{{ $consulta->examen_fisico }}</textarea>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Diagnóstico:</label>
                                <textarea class="form-control" name="diagnostico" oninput="this.value = this.value.toUpperCase()">{{ $consulta->diagnostico }}</textarea>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Recomendaciones:</label>
                                <textarea class="form-control" name="recomendaciones" oninput="this.value = this.value.toUpperCase()">{{ $consulta->recomendaciones }}</textarea>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Observaciones:</label>
                                <textarea class="form-control" name="observaciones" oninput="this.value = this.value.toUpperCase()">{{ $consulta->observaciones }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer" style="text-align: right">
                        <button class="btn btn-success">Aceptar</button>
                    </div>
                </form>


            </div>



            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Recetas
                    </div>
                    <div class="prism-toggle">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create"><i
                                class="bi bi-plus-circle"></i> Agregar</button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Unidad medida</th>
                                <th>Cantidad</th>
                                <th>Frecuencia</th>
                                <th>Via administración</th>
                                <th>Duración</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consulta->recetas as $receta)
                                <tr>
                                    <td>{{$receta->producto->nombre ?? ''}}</td>
                                    <td>{{$receta->unidadMedida->nombre ?? ''}}</td>
                                    <td>{{$receta->cantidad}}</td>
                                    <td>{{$receta->frecuenciaMedicamento->nombre ?? ''}}</td>
                                    <td>{{$receta->viaAdministracion->nombre ?? ''}}</td>
                                    <td>{{$receta->duracion}} {{$receta->duracionTratamiento->nombre ?? ''}}</td>
                                    <td>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-edit-{{$receta->id}}" class="btn btn-sm btn-primary">&nbsp;<i
                                            class="ri-edit-line align-middle me-2 d-inline-block"></i></button>

                                            &nbsp;&nbsp;
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{$receta->id}}">&nbsp;<i class="bi bi-trash-fill"></i>&nbsp;</button>



                                    </td>
                                </tr>

                                @include('administracion.consulta.edit_receta')
                                @include('administracion.consulta.delete_receta')
                            @endforeach


                        </tbody>
                    </table>


                </div>


            </div>
        </div>

    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear receta</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('consulta/store_receta') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="consulta_medica_id"
                                value="{{ $consulta->id }}" required>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Producto:</label>
                                <select name="producto_id" class="form-select select2" required>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                            {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Cantidad</label>
                                <input type="number" step="any" class="form-control" name="cantidad"
                                    value="{{ old('cantidad') }}" required>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Unidad medida</label>
                                <select name="unidad_medida_id" class="form-select" required>
                                    @foreach ($unidades_medida as $unidad)
                                        <option value="{{ $unidad->id }}"
                                            {{ old('unidad_medida_id') == $unidad->id ? 'selected' : '' }}>
                                            {{ $unidad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Frecuencia</label>
                                <select name="frecuencia_medicamento_id" class="form-select" required>
                                    @foreach ($frecuencias_medicamento as $frecuencia)
                                        <option value="{{ $frecuencia->id }}"
                                            {{ old('frecuencia_medicamento_id') == $frecuencia->id ? 'selected' : '' }}>
                                            {{ $frecuencia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Via</label>
                                <select name="via_administracion_id" class="form-select" required>
                                    @foreach ($vias_administracion as $via)
                                        <option value="{{ $via->id }}"
                                            {{ old('via_administracion_id') == $via->id ? 'selected' : '' }}>
                                            {{ $via->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Duración</label>
                                <input type="number" step="any" class="form-control" name="duracion"
                                    value="{{ old('duracion') }}" required>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">&nbsp;</label>
                                <select name="duracion_tratamiento_id" class="form-select" required>
                                    @foreach ($duraciones_tratamiento as $duracion)
                                        <option value="{{ $duracion->id }}"
                                            {{ old('duracion_tratamiento_id') == $duracion->id ? 'selected' : '' }}>
                                            {{ $duracion->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>

            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            $('.select2').select2({
                placeholder: "Seleccione una opción",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#modal-create')
            });

        });
    </script>



@endsection
