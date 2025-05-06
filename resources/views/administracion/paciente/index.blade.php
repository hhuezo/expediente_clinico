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

    <script src="{{ asset('assets/libs/cleave/cleave.min.js') }}"></script>





    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Listado de pacientes
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ url('paciente/create') }}"> <button class="btn btn-primary">Nuevo</button></a>
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

                    @if (session('error'))
                        <script>
                            toastr.error("{{ session('error') }}");
                        </script>
                    @endif

                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                            <thead class="table-dark">
                                <tr>

                                    <th>Nombre</th>
                                    <th>Fecha nacimiento</th>
                                    <th>Teléfono</th>
                                    <th>Documento</th>
                                    <th>Sexo</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $item)
                                    <tr>
                                        <td>{{ $item->nombre }} {{ $item->apellido }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->fecha_nacimiento)) }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td>{{ $item->documento }}</td>
                                        <td>{{ $item->sexo == 1 ? 'Masculino' : 'Femenino' }}</td>
                                        <td>{{ $item->estadoPaciente->nombre }}</td>
                                        <td>
                                            <a href="{{ url('paciente') }}/{{ $item->id }}"> <button
                                                class="btn btn-sm btn-success btn-wave">
                                                &nbsp;<i class="ri-eye-line"></i>&nbsp;</button></a>
                                                &nbsp;
                                            <a href="{{ url('paciente') }}/{{ $item->id }}/edit"> <button
                                                    class="btn btn-sm btn-info btn-wave">
                                                    &nbsp;<i class="ri-edit-line"></i>&nbsp;</button></a>

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




    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Activar DataTable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('administracionMenu', 'pacienteOption');


            $('#datatable-basic').DataTable({
                //paging: false, // Quita paginación
                //searching: false, // Quita el cuadro de búsqueda
                info: false, // Quita el texto de "Mostrando registros..."
                //ordering: false,
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

            new Cleave('#nit', {
                delimiters: ['-', '-', '-', '-'],
                blocks: [4, 6, 3, 1],
                numericOnly: true
            });

            // new Cleave('#edit_nit', {
            //     delimiters: ['-', '-', '-', '-'],
            //     blocks: [4, 6, 3, 1],
            //     numericOnly: true
            // });

            new Cleave('#identification', {
                delimiters: ['-'],
                blocks: [8, 1],
                numericOnly: true
            });


        });

        function getpaciente(id) {
            const form = document.getElementById('formEditarpaciente');
            const currentAction = form.getAttribute('action');

            // Reemplaza el número al final de la URL (el ID)
            const newAction = currentAction.replace(/\/\d+$/, `/${id}`);
            form.setAttribute('action', newAction);

            fetch(`{{ url('paciente') }}/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en el servidor');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const paciente = data.data;
                        document.getElementById('edit_name').value = paciente.name || '';
                        document.getElementById('edit_lastname').value = paciente.lastname || '';
                        document.getElementById('edit_identification').value = paciente.identification || '';
                        document.getElementById('edit_nit').value = paciente.nit || '';
                        document.getElementById('edit_employee_code').value = paciente.employee_code || '';
                        document.getElementById('edit_phone').value = paciente.phone || '';
                        document.getElementById('edit_address').value = paciente.address || '';
                        document.getElementById('edit_company_id').value = paciente.company_id || '';
                        document.getElementById('edit_dependencia').value = paciente.dependencia || '';
                        document.getElementById('edit_statuses_id').value = paciente.statuses_id || '';
                    } else {
                        throw new Error(data.message || 'Acción fallida');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                });
        }
    </script>



    <!-- End:: row-1 -->
@endsection
