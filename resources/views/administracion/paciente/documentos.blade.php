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
                        Procesar documentos
                    </div>
                    <div class="prism-toggle">
                        <a href="{{ url('paciente') }}"><button class="btn btn-primary"><i
                                    class="bi bi-arrow-90deg-left"></i></button></a>
                    </div>
                </div>

                <form method="POST" action="{{ url('paciente/carga_documento') }}" enctype="multipart/form-data">
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
                        <div class="row gy-4">

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Frente:</label>
                                <input type="file" class="form-control" name="frente" accept="image/*">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label class="form-label">Dorso:</label>
                                <input type="file" class="form-control" name="dorso" accept="image/*">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer" style="text-align: right">
                        <button class="btn btn-primary">Procesar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const maxFileSize = 2 * 1024 * 1024; // 2MB
            const inputs = ['frente', 'dorso'];
            const newFiles = {};

            for (const name of inputs) {
                const fileInput = document.querySelector(`input[name="${name}"]`);
                const file = fileInput.files[0];
                if (!file || !file.type.startsWith('image/')) continue;

                const img = new Image();
                const reader = new FileReader();

                reader.onload = function(event) {
                    img.onload = async function() {
                        const canvas = document.createElement('canvas');
                        const scaleFactor = Math.min(1024 / img.width,
                            1); // Scale down if wider than 1024px
                        canvas.width = img.width * scaleFactor;
                        canvas.height = img.height * scaleFactor;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        canvas.toBlob(async function(blob) {
                            if (blob.size <= maxFileSize) {
                                const newFile = new File([blob], file.name, {
                                    type: file.type
                                });
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(newFile);
                                fileInput.files = dataTransfer.files;

                                if (Object.keys(newFiles).length + 1 === inputs
                                    .length) {
                                    e.target
                                        .submit(); // Submit after processing all images
                                }
                            } else {
                                alert(
                                    `La imagen ${name} sigue pesando más de 2MB incluso comprimida.`
                                    );
                            }
                        }, file.type, 0.8); // Quality (0.0–1.0)
                    };
                    img.src = event.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
