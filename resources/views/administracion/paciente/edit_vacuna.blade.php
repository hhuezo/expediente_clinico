<div class="modal fade" id="edit-vacuna-{{ $vacuna->id }}" tabindex="-1" aria-labelledby="exampleModalLgLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLgLabel">Modificar vacuna</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('paciente.vacuna.update', $vacuna->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">


                    <div class="row gy-4">
                        <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Vacuna:</label>
                            <select class="form-select" name="tipo_vacuna_id" required>
                                @foreach ($tipos_vacuna as $tipo)
                                    <option value="{{ $tipo->id }}" {{$vacuna->tipo_vacuna_id == $tipo->id ? 'selected':''}}>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Fecha:</label>
                            <input type="date" class="form-control" name="fecha" value="{{$vacuna->fecha}}"
                                required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Comentario:</label>
                            <textarea class="form-control" name="comentario">{{$vacuna->comentario}}</textarea>
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
