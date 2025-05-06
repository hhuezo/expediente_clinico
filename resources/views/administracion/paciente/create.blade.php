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

    <script src="{{ asset('assets/libs/cleave/cleave.min.js') }}"></script>

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
                        Nuevo paciente
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ url('paciente') }}"><button class="btn btn-primary"><i
                                    class="bi bi-arrow-90deg-left"></i></button></a>
                    </div>
                </div>

                <form method="POST" action="{{ route('paciente.store') }}"  enctype="multipart/form-data">
                    @csrf
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
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="card-body border-bottom border-block-end-dashed">
                                    <div class="text-center">
                                        <span class="avatar avatar-xxl avatar-rounded online mb-3" style="cursor: pointer;">
                                            <img id="previewImage" src="{{ asset('assets/images/faces/11.jpg') }}"
                                                alt="Foto de perfil">
                                        </span>
                                    </div>
                                </div>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*"
                                    style="display: none;">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="row gy-4">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label class="form-label">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.toUpperCase()"
                                        value="{{ $result['nombre'] ?? old('nombre') }}" required>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label class="form-label">Apellido:</label>
                                        <input type="text" class="form-control" name="apellido" oninput="this.value = this.value.toUpperCase()"
                                        value="{{ $result['apellido'] ?? old('apellido') }}" required>
                                    </div>
                                </div>
                            </div>



                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Sexo:</label>
                                <select class="form-select" name="sexo" required>
                                    <option value="">Seleccione</option>
                                    <option value="1" {{ old('sexo') == 1 ? 'selected' : '' }}>Masculino</option>
                                    <option value="2" {{ old('sexo') == 2 ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Correo:</label>
                                <input type="email" class="form-control" name="correo" value="{{ old('correo') }}">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Fecha de nacimiento:</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"
                                    value="{{ old('fecha_nacimiento') }}" required>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Adad:</label>
                                <input type="text" class="form-control" id="edad" value="{{ old('edad') }}"
                                    readonly>
                            </div>



                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Teléfono fijo:</label>
                                <input type="text" class="form-control" name="telefono_fijo" id="telefono_fijo"
                                    value="{{ old('telefono_fijo') }}">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Teléfono celular:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" value="{{ old('telefono') }}">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Observaciones:</label>
                                <textarea class="form-control" name="observaciones" rows="5">{{ old('observaciones') }}</textarea>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="row gy-4">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label class="form-label">Documento:</label>
                                        <input type="text" class="form-control" name="documento"
                                            value="{{ $result['documento'] ?? old('documento') }}">

                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <label class="form-label">Estado civil:</label>
                                        <select class="form-select" name="estado_civil_id" required>
                                            <option value="">Seleccione</option>
                                            @foreach ($estados_civiles as $estado)
                                                <option value="{{ $estado->id }}"
                                                    {{ old('estado_civil_id') == $estado->id ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">País:</label>
                                <select class="form-select select2" name="pais_id">
                                    @foreach ($paises as $pais)
                                        <option value="{{ $pais->id }}"
                                            {{ old('pais_id') == $pais->id ? 'selected' : '' }}>
                                            {{ $pais->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Departamento:</label>
                                <select class="form-select" name="departamento_id" onchange="getDistritos(this.value)">
                                    <option value="">Seleccione</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}"
                                            {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                            {{ $departamento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Distrito:</label>
                                <select class="form-select" name="distrito_id" id="distrito_id">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>



                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Dirección:</label>
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ old('direccion') }}">
                            </div>
                        </div>


                    </div>

                    <div class="card-footer" style="text-align: right">
                        <button class="btn btn-primary">Aceptar</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            $('.select2').select2({
                //placeholder: "Seleccione",
                allowClear: true,
                width: '100%'
            });


            //para formato de telefono
            new Cleave('#telefono', {
                delimiters: ['-'],
                blocks: [4, 4],
                numericOnly: true
            });

            new Cleave('#telefono_fijo', {
                delimiters: ['-'],
                blocks: [4, 4],
                numericOnly: true
            });


            const fileInput = document.getElementById('foto');
            const previewImage = document.getElementById('previewImage');

            // Al hacer clic en la imagen, abre el input file
            previewImage.addEventListener('click', () => {
                fileInput.click();
            });

            // Mostrar vista previa
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });


            //calcular edad
            const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
            const edadInput = document.getElementById('edad');

            function calcularEdad(fechaNacimiento) {
                const hoy = new Date();
                const nacimiento = new Date(fechaNacimiento);
                let edad = hoy.getFullYear() - nacimiento.getFullYear();
                const mes = hoy.getMonth() - nacimiento.getMonth();

                if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                    edad--;
                }

                return edad;
            }

            fechaNacimientoInput.addEventListener('change', function() {
                const fecha = this.value;
                if (fecha) {
                    const edad = calcularEdad(fecha);
                    edadInput.value = edad;
                } else {
                    edadInput.value = '';
                }
            });

            // Calcular edad si ya hay fecha cargada (ej. al recargar después de validación fallida)
            if (fechaNacimientoInput.value) {
                edadInput.value = calcularEdad(fechaNacimientoInput.value);
            }


        });

        function getDistritos(id) {
            const url = "{{ url('paciente/get_distritos') }}/" + id;

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
    </script>


@endsection
