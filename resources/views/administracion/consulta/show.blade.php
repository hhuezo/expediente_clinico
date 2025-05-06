@extends ('menu')
@section('content')
    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Consulta
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ url('paciente') }}/{{ $consulta->paciente_id }}?tab=2"><button class="btn btn-primary"><i
                                    class="bi bi-arrow-90deg-left"></i></button></a>
                    </div>
                </div>


                <div class="card-body">
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

            </div>


        </div>



        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Recetas
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consulta->recetas as $receta)
                            <tr>
                                <td>{{ $receta->producto->nombre ?? '' }}</td>
                                <td>{{ $receta->unidadMedida->nombre ?? '' }}</td>
                                <td>{{ $receta->cantidad }}</td>
                                <td>{{ $receta->frecuenciaMedicamento->nombre ?? '' }}</td>
                                <td>{{ $receta->viaAdministracion->nombre ?? '' }}</td>
                                <td>{{ $receta->duracion }} {{ $receta->duracionTratamiento->nombre ?? '' }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>


            </div>


        </div>
    </div>
@endsection
