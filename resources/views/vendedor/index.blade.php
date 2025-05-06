@extends ('menu')
@section('content')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>



    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Listado de vendedores
                    </div>
                    <div class="prism-toggle">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">Nuevo</button>
                    </div>
                </div>
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

                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Distrito</th>
                                    <th>Metodo pago</th>
                                    <th>Activo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendedores as $item)
                                    <tr>
                                        <td>{{ $item->user->name ?? '' }}</td>
                                        <td>{{ $item->user->email ?? '' }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td>{{ $item->distrito->nombre ?? '' }}</td>
                                        <td>{{ $item->metodoPago->nombre ?? '' }}</td>
                                        <td><label class="switch">
                                                <input type="checkbox" {{ $item->activo == 1 ? 'checked' : '' }}
                                                    onChange="toggleVendedorActivo({{ $item->id }})">
                                                <span class="slider round"></span>
                                            </label></td>

                                        <td>
                                            <button class="btn btn-sm btn-warning btn-wave" data-bs-toggle="modal"
                                                data-bs-target="#modal-edit" onclick="getVendedor({{ $item->id }})">
                                                &nbsp;<i class="ri-edit-line align-middle me-2 d-inline-block"></i></button>


                                            <button class="btn btn-sm btn-success btn-wave" data-bs-toggle="modal"
                                                data-bs-target="#modal-change-password"
                                                onclick="changePassword({{ $item->id }})">
                                                &nbsp;<i class="ri-lock-line align-middle me-2 d-inline-block"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear vendedor</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('vendedor.store') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}"
                                    required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="email" required
                                    value="{{ old('email') }}">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Password:</label>
                                <input type="text" class="form-control" name="password" required
                                    value="{{ old('password') }}">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Departamento:</label>
                                <select class="form-select" id="departamento_id" onchange="getDistritos(this.value)">
                                    <option value="">Seleccione</option>
                                    @foreach ($departamentos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Distrito:</label>
                                <select class="form-select" name="distrito_id" id="distrito_id" required>

                                </select>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Método pago:</label>
                                <select class="form-select" name="metodo_pago_id" required>
                                    @foreach ($metodos_pago as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
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

    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Modificar vendedor</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('vendedor/update') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="id" id="edit_id"
                                value="{{ old('id') }}" required>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" id="edit_name"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" id="edit_telefono"
                                    value="{{ old('telefono') }}" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="email" id="edit_email" required
                                    value="{{ old('email') }}">
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Departamento:</label>
                                <select class="form-select" id="departamento_edit_id"
                                    onchange="getDistritosEdit(this.value)">
                                    @foreach ($departamentos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Distrito:</label>
                                <select class="form-select" name="distrito_id" id="distrito_edit_id" required>

                                </select>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Método pago:</label>
                                <select class="form-select" name="metodo_pago_id" id="metodo_pago_edit_id" required>
                                    @foreach ($metodos_pago as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
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

    <div class="modal fade" id="modal-change-password" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Modificar contraseña</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('user/update_password') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="id" id="edit_pass_id">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Password:</label>
                                <input type="text" class="form-control" name="password" id="edit_password"
                                    value="{{ old('password') }}" required>
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






    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Activar DataTable -->
    <script>
        $(document).ready(function() {
            expandMenuAndHighlightOption('administracionMenu', 'vendedor_Option');
            $('#datatable-basic').DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    },
                    buttons: {
                        copy: 'Copiar',
                        colvis: 'Visibilidad',
                        print: 'Imprimir',
                        excel: 'Exportar Excel',
                        pdf: 'Exportar PDF'
                    }
                }
            });


        });

        function getDistritos(id) {
            const url = "{{ url('vendedor/getDistritos') }}/" + id;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //console.log('Distritos:', data.data);

                        var _select = ''
                        for (var i = 0; i < data.data.length; i++)
                            _select += '<option value="' + data.data[i].id + '"  >' + data.data[i].nombre +
                            '</option>';

                        $("#distrito_id").html(_select);
                        // aquí podés trabajar con los datos
                    } else {
                        console.error('Error al obtener distritos:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                });
        }

        function getDistritosEdit(id) {
            const url = "{{ url('vendedor/getDistritos') }}/" + id;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //console.log('Distritos:', data.data);

                        var _select = ''
                        for (var i = 0; i < data.data.length; i++)
                            _select += '<option value="' + data.data[i].id + '"  >' + data.data[i].nombre +
                            '</option>';

                        $("#distrito_edit_id").html(_select);
                        // aquí podés trabajar con los datos
                    } else {
                        console.error('Error al obtener distritos:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                });
        }

        function getVendedor(id) {

            document.getElementById('edit_id').value = id;

            const url = "{{ url('vendedor') }}/" + id;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('vendedor:', data.data);


                        getDistritosEdit(data.data.departamento_id);

                        document.getElementById('edit_name').value = data.data.name;
                        document.getElementById('edit_telefono').value = data.data.telefono;
                        document.getElementById('edit_email').value = data.data.email;
                        document.getElementById('departamento_edit_id').value = data.data.departamento_id;
                        document.getElementById('distrito_edit_id').value = data.data.distrito_id;
                        document.getElementById('metodo_pago_edit_id').value = data.data.metodo_pago_id;

                    } else {
                        console.error('Error al obtener distritos:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                });
        }

        function changePassword(id) {
            document.getElementById('edit_pass_id').value = id;
        }

        function toggleVendedorActivo(id) {

            const url = `{{ url('/vendedor/${id}') }}`;

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Estado del vendedor actualizado');
                    } else {
                        toastr.error('Hubo un problema al actualizar el estado.');
                    }

                })
                .catch(error => {
                    console.error('Error al cambiar el estado del vendedor:', error);
                    alert('Error al cambiar el estado del vendedor.');
                });

        }
    </script>
    <!-- End:: row-1 -->
@endsection
