<div class="modal fade" id="edit-cita-{{ $cita->id }}" tabindex="-1" aria-labelledby="exampleModalLgLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLgLabel">Modificar cita</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('paciente.cita.update', $cita->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">


                    <div class="row gy-4">
                        <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}"
                            required>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Fecha:</label>
                            <input type="date" class="form-control" name="fecha" value="{{ $cita->fecha}}"
                                required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Hora inicio:</label>
                            <input type="time" class="form-control" name="hora_inicio"
                                value="{{ $cita->hora_inicio }}" required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Hora final:</label>
                            <input type="time" class="form-control" name="hora_final"
                                value="{{ $cita->hora_final }}" required>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <label for="input-label" class="form-label">Actividad:</label>
                            <textarea name="actividad" class="form-control">{{ $cita->actividad }}</textarea>
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
