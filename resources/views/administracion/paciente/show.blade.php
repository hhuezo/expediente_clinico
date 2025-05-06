@extends ('menu')
@section('content')
    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

    {{-- <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- JS de Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script> --}}

    <script src="{{ asset('assets/libs/cleave/cleave.min.js') }}"></script>

    <style>
        .avatar.avatar-xxl {
            width: 8rem;
            height: 8rem;
        }

        @media (min-width: 1200px) {
            .profile-content {
                margin-block-start: -18rem;
            }
        }

        .tab-pane {
            min-height: 535px;
        }
    </style>



    <!-- Start:: row-1 -->
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
        <div>

            <h1 class="page-title fw-medium fs-18 mb-0">Paciente</h1>
        </div>
        {{-- <div class="btn-list">
            <button class="btn btn-white btn-wave">
                <i class="ri-filter-3-line align-middle me-1 lh-1"></i> Filter
            </button> --}}
        <a href="{{ url('paciente') }}"> <button class="btn btn-primary btn-wave me-0">
                <i class="bi bi-arrow-90deg-left"></i>
            </button></a>
    </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card profile-card">
                <div class="profile-banner-img">
                    <img src="{{ asset('assets/images/media/media-3.jpg')}}" class="card-img-top" alt="...">
                </div>
                <div class="card-body pb-0 position-relative">
                    <div class="row profile-content">
                        <div class="col-xl-3">
                            <div class="card custom-card overflow-hidden border">
                                <div class="card-body border-bottom border-block-end-dashed">
                                    <div class="text-center">
                                        <span class="avatar avatar-xxl avatar-rounded online mb-3">
                                            <img src="{{ asset('imagenes')}}/{{$paciente->foto}}" alt="">
                                        </span>
                                        <h5 class="fw-semibold mb-1">{{ $paciente->nombre }} {{ $paciente->apellido }}</h5>
                                        <span class="d-block fw-medium text-muted mb-2">{{ $paciente->ocupacion }}</span>
                                        <p class="fs-12 mb-0 text-muted"> <span class="me-3"><i
                                                    class="ri-building-line me-1 align-middle"></i>
                                                {{ $paciente->distrito->nombre ?? ($paciente->pais->nombre ?? '') }}
                                            </span> <span><i
                                                    class="ri-map-pin-line me-1 align-middle"></i>{{ $paciente->distrito->municipio->departamento->nombre ?? '' }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3 pb-1 d-flex flex-wrap justify-content-between">
                                    <div class="fw-medium fs-15 text-primary1">
                                        Información Básica :
                                    </div>
                                </div>
                                <div class="card-body border-bottom border-block-end-dashed p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Documento :</span><span class="text-muted">
                                                    {{ $paciente->documento }}</span></div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Fecha nacimiento :</span><span
                                                    class="text-muted">
                                                    {{ date('d/m/Y', strtotime($paciente->fecha_nacimiento ?? '')) }}</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Edad :</span><span
                                                    class="text-muted">{{ $edad }} Años</span></div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Email :</span><span
                                                    class="text-muted">{{ $paciente->correo }}</span></div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Teléfono :</span><span
                                                    class="text-muted">{{ $paciente->telefono }}</span></div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Teléfono fijo :</span><span
                                                    class="text-muted">{{ $paciente->telefono_fijo }}</span></div>
                                        </li>
                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Estado civil :</span><span
                                                    class="text-muted">{{ $paciente->estadoCivil->nombre }}</span>
                                            </div>
                                        </li>

                                        <li class="list-group-item pt-2 border-0">
                                            <div><span class="fw-medium me-2">Dirección :</span><span
                                                    class="text-muted">{{ $paciente->direccion }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-9">


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


                            <div class="card custom-card overflow-hidden border">
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


                                    <ul class="nav nav-tabs tab-style-6 mb-3 p-0" id="myTab" role="tablist">

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-start {{ $tab == 1 ? 'active' : '' }}"
                                                id="antecedentes-tab" data-bs-toggle="tab"
                                                data-bs-target="#antecedentes-tab-pane" type="button" role="tab"
                                                aria-controls="antecedentes-tab-pane"
                                                aria-selected="true">Antecedentes</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-start {{ $tab == 2 ? 'active' : '' }}"
                                                id="consultas-tab" data-bs-toggle="tab" data-bs-target="#consultas-tab-pane"
                                                type="button" role="tab" aria-controls="consultas-tab-pane"
                                                aria-selected="true">Consultas Médicas</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-start {{ $tab == 3 ? 'active' : '' }}"
                                                id="vacunas-tab" data-bs-toggle="tab" data-bs-target="#vacunas-tab-pane"
                                                type="button" role="tab" aria-controls="vacunas-tab-pane"
                                                aria-selected="false">Vacunas</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-start {{ $tab == 4 ? 'active' : '' }}"
                                                id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-tab-pane"
                                                type="button" role="tab" aria-controls="gallery-tab-pane"
                                                aria-selected="false">Documentos</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-start {{ $tab == 5 ? 'active' : '' }}"
                                                id="citas-tab" data-bs-toggle="tab" data-bs-target="#citas-tab-pane"
                                                type="button" role="tab" aria-controls="citas-tab-pane"
                                                aria-selected="false">Citas</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="profile-tabs">
                                        <div class="tab-pane {{ $tab == 1 ? 'show active' : '' }} p-0 border-0"
                                            id="antecedentes-tab-pane" role="tabpanel" aria-labelledby="antecedentes-tab"
                                            tabindex="0">
                                            <ul class="list-group list-group-flush border rounded-3">
                                                <li class="list-group-item p-3">
                                                    <form method="POST"
                                                        action="{{ url('paciente/update_antecedentes', $paciente->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <span class="fw-medium fs-15 d-block mb-3">General :</span>
                                                        <div class="row gy-3 align-items-center">
                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">Patológicos :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="patologicos" rows="3" class="form-control">{{ $paciente->patologicos }}</textarea>
                                                            </div>
                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">No Patológicos :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="no_patologicos" rows="3" class="form-control">{{ $paciente->no_patologicos }}</textarea>
                                                            </div>
                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">Familiares :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="familiares" rows="3" class="form-control">{{ $paciente->familiares }}</textarea>
                                                            </div>
                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">Quirúrgicos :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="quirurgicos" rows="3" class="form-control">{{ $paciente->quirurgicos }}</textarea>
                                                            </div>

                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">Alergias :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="alergias" rows="3" class="form-control">{{ $paciente->alergias }}</textarea>
                                                            </div>

                                                            <div class="col-xl-3">
                                                                <div class="lh-1">
                                                                    <span class="fw-medium">Medicamentos :</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <textarea name="medicamentos" rows="3" class="form-control">{{ $paciente->medicamentos }}</textarea>
                                                            </div>

                                                            <div class="col-xl-12" style="text-align: right">
                                                                <button class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="tab-pane {{ $tab == 2 ? 'show active' : '' }} p-0 border-0"
                                            id="consultas-tab-pane" role="tabpanel" aria-labelledby="consultas-tab"
                                            tabindex="0">

                                            <div style="text-align: right">
                                                <button class="btn btn-white btn-wave" data-bs-toggle="modal"
                                                    data-bs-target="#modal-create-consulta">
                                                    <i class="bi bi-calendar-date"></i>&nbsp; Regitrar consulta
                                                </button>
                                            </div>

                                            <div
                                                class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">


                                                <table class="table table-bordered table-striped">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Horario</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php($i = 1)
                                                        @foreach ($paciente->consultas as $consulta)
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $consulta->fecha ? \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') : '' }}
                                                                </td>
                                                                <td>{{ $consulta->hora_inicio ? \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') : '' }}
                                                                    -
                                                                    {{ $consulta->hora_final ? \Carbon\Carbon::parse($consulta->hora_final)->format('H:i') : '' }}
                                                                </td>
                                                                <td>{{ $consulta->estadoConsulta->nombre ?? '' }}</td>
                                                                <td>
                                                                    <a href="{{ url('consulta') }}/{{ $consulta->id }}">
                                                                        <button class="btn btn-sm btn-success btn-wave">
                                                                            &nbsp;<i
                                                                                class="ri-eye-line"></i>&nbsp;</button></a>
                                                                    &nbsp;
                                                                    <a
                                                                        href="{{ url('consulta') }}/{{ $consulta->id }}/edit">
                                                                        <button class="btn btn-sm btn-info btn-wave">
                                                                            &nbsp;<i
                                                                                class="ri-edit-line"></i>&nbsp;</button></a>
                                                                </td>
                                                            </tr>
                                                            @php($i++)
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="tab-pane {{ $tab == 3 ? 'show active' : '' }} p-0 border-0"
                                            id="vacunas-tab-pane" role="tabpanel" aria-labelledby="vacunas-tab"
                                            tabindex="0">

                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Vacunas
                                                </div>
                                                <div class="prism-toggle">
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modal-create-vacuna"><i
                                                            class="bi bi-plus-circle"></i> Agregar</button>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-striped">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Vacuna</th>
                                                        <th>Comentario</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($i = 1)
                                                    @foreach ($paciente->vacunas as $vacuna)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $vacuna->fecha ? \Carbon\Carbon::parse($vacuna->fecha)->format('d/m/Y') : '' }}
                                                            </td>
                                                            <td>{{ $vacuna->tipoVacuna->nombre ?? '' }}</td>
                                                            <td>{{ $vacuna->comentario }}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-info btn-wave"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-vacuna-{{ $vacuna->id }}">
                                                                    &nbsp;<i class="ri-edit-line"></i>&nbsp;</button>
                                                                &nbsp;
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-vacuna-{{ $vacuna->id }}">&nbsp;<i
                                                                        class="bi bi-trash-fill"></i>&nbsp;</button>


                                                            </td>
                                                        </tr>
                                                        @include('administracion.paciente.edit_vacuna')
                                                        @include('administracion.paciente.delete_vacuna')
                                                        @php($i++)
                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="tab-pane {{ $tab == 4 ? 'show active' : '' }} p-0 border-0"
                                            id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab"
                                            tabindex="0">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Documentos
                                                </div>
                                                <div class="prism-toggle">
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modal-create-documento"><i
                                                            class="bi bi-plus-circle"></i> Agregar</button>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-striped">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Descripción</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($i = 1)
                                                    @foreach ($paciente->documentos as $documento)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $documento->created_at ? \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') : '' }}
                                                            </td>
                                                            <td>{{ $documento->descripcion }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/documentos') }}/{{ $documento->archivo }}"
                                                                    target="_blank">
                                                                    <button class="btn btn-sm btn-info btn-wave">
                                                                        &nbsp;<i class="ri-eye-line"></i>&nbsp;
                                                                    </button>
                                                                </a>


                                                                &nbsp;
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-documento-{{ $documento->id }}">&nbsp;<i
                                                                        class="bi bi-trash-fill"></i>&nbsp;</button>


                                                            </td>
                                                        </tr>
                                                        @include('administracion.paciente.delete_documento')
                                                        @php($i++)
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane {{ $tab == 5 ? 'show active' : '' }} p-0 border-0"
                                            id="citas-tab-pane" role="tabpanel" aria-labelledby="citas-tab"
                                            tabindex="0">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Citas
                                                </div>
                                                <div class="prism-toggle">
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modal-create-cita"><i
                                                            class="bi bi-plus-circle"></i> Agregar</button>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-striped">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Horario</th>
                                                        <th>Comentario</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($i = 1)
                                                    @foreach ($paciente->citas as $cita)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $cita->fecha ? \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '' }}
                                                            </td>
                                                            <td>{{ $cita->hora_inicio ? \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') : '' }}
                                                                -
                                                                {{ $cita->hora_final ? \Carbon\Carbon::parse($cita->hora_final)->format('H:i') : '' }}
                                                            </td>
                                                            <td>{{ $cita->actividad }}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-info btn-wave"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-cita-{{ $cita->id }}">
                                                                    &nbsp;<i class="ri-edit-line"></i>&nbsp;</button>
                                                                &nbsp;
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-cita-{{ $cita->id }}">&nbsp;<i
                                                                        class="bi bi-trash-fill"></i>&nbsp;</button>


                                                            </td>
                                                        </tr>
                                                        @include('administracion.paciente.edit_cita')
                                                        @include('administracion.paciente.delete_cita')
                                                        @php($i++)
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create-consulta" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear consulta</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('consulta.store') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}"
                                required>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Hora inicio:</label>
                                <input type="time" class="form-control" name="hora_inicio"
                                    value="{{ old('hora_inicio') }}" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Hora final:</label>
                                <input type="time" class="form-control" name="hora_final"
                                    value="{{ old('hora_final') }}" required>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Lugar:</label>
                                <select class="form-select" name="metodo_pago_id" required>
                                    @foreach ($lugares_consulta as $lugar)
                                        <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
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

    <div class="modal fade" id="modal-create-vacuna" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear vacuna</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('paciente.vacuna') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Vacuna:</label>
                                <select class="form-select" name="tipo_vacuna_id" required>
                                    @foreach ($tipos_vacuna as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Comentario:</label>
                                <textarea class="form-control" name="comentario"></textarea>
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

    <div class="modal fade" id="modal-create-documento" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear documento</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('paciente.documento') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}">



                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Descripción:</label>
                                <input type="text" class="form-control" name="descripcion" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Archivo:</label>
                                <input type="file" class="form-control" name="archivo" id="archivo" required>
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


    <div class="modal fade" id="modal-create-cita" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear cita</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('paciente.cita') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">
                            <input type="hidden" class="form-control" name="paciente_id" value="{{ $paciente->id }}"
                                required>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Hora inicio:</label>
                                <input type="time" class="form-control" name="hora_inicio"
                                    value="{{ old('hora_inicio') }}" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Hora final:</label>
                                <input type="time" class="form-control" name="hora_final"
                                    value="{{ old('hora_final') }}" required>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Actividad:</label>
                                <textarea name="actividad" class="form-control">{{ old('actividad') }}</textarea>
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
            const inputArchivo = document.getElementById('archivo');

            inputArchivo.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > 2 * 1024 * 1024) { // 2MB
                    toastr.error('El archivo no debe pesar más de 2MB');
                    this.value = ''; // Limpia el campo
                }
            });
        });
    </script>




    <!-- End:: row-1 -->
@endsection
