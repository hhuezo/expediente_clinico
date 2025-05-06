<div class="modal fade" id="modal-edit-{{$receta->id}}" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLgLabel">Modificar receta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('consulta.update_receta', $receta->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">


                    <div class="row gy-4">
                        <input type="hidden" class="form-control" name="consulta_medica_id"
                            value="{{ $consulta->id }}" required>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Producto:</label>
                            <select name="producto_id" class="form-select select2" required>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                        {{ $receta->producto_id == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Cantidad</label>
                            <input type="number" step="any" class="form-control" name="cantidad"
                                value="{{$receta->cantidad }}" required>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Unidad medida</label>
                            <select name="unidad_medida_id" class="form-select" required>
                                @foreach ($unidades_medida as $unidad)
                                    <option value="{{ $unidad->id }}"
                                        {{ $receta->unidad_medida_id == $unidad->id ? 'selected' : '' }}>
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
                                        {{ $receta->frecuencia_medicamento_id == $frecuencia->id ? 'selected' : '' }}>
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
                                        {{ $receta->via_administracion_id  == $via->id ? 'selected' : '' }}>
                                        {{ $via->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Duración</label>
                            <input type="number" step="any" class="form-control" name="duracion"
                                value="{{ $receta->duracion }}" required>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">&nbsp;</label>
                            <select name="duracion_tratamiento_id" class="form-select" required>
                                @foreach ($duraciones_tratamiento as $duracion)
                                    <option value="{{ $duracion->id }}"
                                        {{ $receta->duracion_tratamiento_id == $duracion->id ? 'selected' : '' }}>
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
