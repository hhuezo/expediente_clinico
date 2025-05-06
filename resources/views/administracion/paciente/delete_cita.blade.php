<div class="modal fade" id="delete-cita-{{ $cita->id }}" tabindex="-1" aria-labelledby="exampleModalLgLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLgLabel">Eliminar cita</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('paciente.cita.destroy', $cita->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Confirme si desea eliminar el registro</p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>

            </form>
        </div>

        </form>
    </div>
</div>
