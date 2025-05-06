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


    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-0">Agenda</h1>
        </div>
        <div class="btn-list">
            {{-- <button class="btn btn-white btn-wave">
                <i class="ri-filter-3-line align-middle me-1 lh-1"></i> Filter
            </button> --}}
            <button class="btn btn-primary btn-wave me-0" data-bs-toggle="modal" data-bs-target="#modal-create-cita">
                <i class="ri-add-line align-middle me-1 fw-medium d-inline-block"></i> Crear cita
            </button>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-9">
            <div class="card custom-card">

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

                <div class="card-body">
                    <div id='calendar2'></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">

            <div class="card custom-card">
                {{-- <div class="card-header justify-content-between">
                    <div class="card-title">Citas</div>
                    <button class="btn btn-primary btn-wave"><i
                            class="ri-add-line align-middle me-1 fw-medium d-inline-block"></i>Crear cita</button>
                </div> --}}
                <div class="card-body p-0">
                    <ul id="external-events" class="mb-0 p-3 list-unstyled column-list">
                        {{--   <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-primary-transparent">
                            <div class="fc-event-main text-primary">Calendar Events</div>
                        </li>
                      <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-primary1-transparent"
                            data-class="bg-primary1-transparent">
                            <div class="fc-event-main text-primary1">Birthday Events</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-primary2-transparent"
                            data-class="bg-primary2-transparent text-primary2">
                            <div class="fc-event-main text-primary2">Holiday Calendar</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-primary3-transparent"
                            data-class="bg-primary3-transparent text-primary3">
                            <div class="fc-event-main text-primary3">Office Events</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-secondary-transparent"
                            data-class="bg-secondary">
                            <div class="fc-event-main text-secondary">Other Events</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-danger-transparent"
                            data-class="bg-danger">
                            <div class="fc-event-main text-danger">Festival Events</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-success-transparent"
                            data-class="bg-success">
                            <div class="fc-event-main text-success">Timeline Events</div>
                        </li>
                        <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-info-transparent"
                            data-class="bg-info">
                            <div class="fc-event-main text-info">Others Events</div>
                        </li> --}}
                    </ul>
                </div>
            </div>
            {{-- <div class="card custom-card">
                <div class="card-header justify-content-between pb-1">
                    <div class="card-title">
                        Activity :
                    </div>
                    <button class="btn btn-primary-light btn-sm btn-wave">View All</button>
                </div>
                <div class="card-body p-0">
                    <div class="p-3 border-bottom" id="full-calendar-activity">
                        <ul class="list-unstyled mb-0 fullcalendar-events-activity">
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-medium">Tuesday, Feb 5, 2024</p>
                                    <span class="badge bg-light text-default mb-1">10:00AM - 11:00AM</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">Discussion with team on project updates.</p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-medium">Monday, Jan 2, 2023</p>
                                    <span class="badge bg-success mb-1">Completed</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">Review and finalize budget proposal.</p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-medium">Thursday, Mar 8, 2024</p>
                                    <span class="badge bg-warning-transparent mb-1">Reminder</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">Prepare presentation slides for client meeting.</p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-medium">Friday, Apr 12, 2024</p>
                                    <span class="badge bg-light text-default mb-1">2:00PM - 4:00PM</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">Training session on new software tools.</p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-medium">Saturday, Mar 16, 2024</p>
                                    <span class="badge bg-danger-transparent mb-1">Due Date</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">Submit quarterly report to management.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!--End::row-1 -->

    </div>


    <div class="modal fade" id="modal-create-cita" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">Crear cita</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('cita/store_cita') }}">
                    @csrf
                    <div class="modal-body">


                        <div class="row gy-4">


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="input-label" class="form-label">Paciente:</label>
                                <select name="paciente_id" class="form-control select2">
                                    @foreach ($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->documento }} -
                                            {{ $paciente->nombre }}
                                            {{ $paciente->apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
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


    <!-- Fullcalendar JS -->
    <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script>
        $(document).ready(function() {


            $('.select2').select2({
                placeholder: "Seleccione una opción",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#modal-create-cita')
            });



            const hoy = new Date();
            const mes = String(hoy.getMonth() + 1).padStart(2, '0');
            const anio = hoy.getFullYear();
            cargarEventosCalendario(mes, anio);
            getListaEventos(mes, anio);
        });


        async function getListaEventos(mes, anio) {
            const url = `{{ url('cita/calendario/get_lista_eventos/${mes}/${anio}') }}`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                });

                const data = await response.text(); // 👈 CORRECTO para HTML

                // console.log("eventos lista: ", data);

                $("#external-events").html(data);

            } catch (error) {
                console.error('Error al obtener los eventos:', error);
                alert('Error al obtener los eventos.');
            }
        }




        let calendar;
        let yaInicializado = false;

        async function cargarEventosCalendario(mes, anio) {
            const eventosApi = await getEventos(mes, anio);
            console.log("eventos: ", eventosApi);

            const eventosFormateados = eventosApi.map(e => ({
                id: e.id,
                title: e.nombre_completo,
                start: e.fecha_inicio,
                end: e.fecha_final,
                className: "bg-primary-transparent"
            }));

            const calendarEl = document.getElementById('calendar2');

            if (calendar) {
                calendar.getEventSources().forEach(source => source.remove());
                calendar.addEventSource({
                    id: 1,
                    events: eventosFormateados
                });
                return;
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'dayGridMonth',
                locale: 'es',
                locales: [{
                    code: 'es',
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día',
                        list: 'Agenda'
                    },
                    week: {
                        dow: 1,
                        doy: 4
                    },
                    allDayText: 'Todo el día',
                    moreLinkText: n => `+ ver ${n} más`,
                    noEventsText: 'No hay eventos para mostrar'
                }],
                editable: false,
                selectable: false,
                dayMaxEvents: true,
                eventSources: [{
                    id: 1,
                    events: eventosFormateados
                }],
                datesSet: async function(info) {
                    if (yaInicializado) {
                        const vistaFecha = calendar.getDate(); // <-- aquí está la clave
                        const nuevoMes = String(vistaFecha.getMonth() + 1).padStart(2, '0');
                        const nuevoAnio = vistaFecha.getFullYear();
                        await cargarEventosCalendario(nuevoMes, nuevoAnio);
                        await getListaEventos(nuevoMes, nuevoAnio);
                    } else {
                        yaInicializado = true;
                    }
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

            });

            calendar.render();
        }



        async function getEventos(mes, anio) {
            const url = `{{ url('cita/calendario/get_eventos/${mes}/${anio}') }}`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                });

                const data = await response.json();

                if (data.success) {

                    return data.eventos || [];
                } else {
                    toastr.error('Hubo un problema al obtener los eventos.');
                    return [];
                }

            } catch (error) {
                console.error('Error al obtener los eventos:', error);
                alert('Error al obtener los eventos.');
                return [];
            }
        }
    </script>
@endsection
