@extends('layouts.app')
@section('menu_select')
    {{$select = 'asistencias'}}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Control Asistencia</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    <div class="container-fluid">
                        <video id="preview" width="100%"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    let scanner = new Instascan.Scanner(
        {
            video: document.getElementById('preview')
        }
    );
    scanner.addListener('scan', function(content) {
        let codigo = null;

        // Intentar parsear el contenido como JSON (si el QR contiene JSON)
        try {
            const qrData = JSON.parse(content);
            // Si tiene la propiedad 'id', usar ese valor como código
            if (qrData.id) {
                codigo = qrData.id;
            } else {
                // Si no tiene 'id', usar el contenido completo como código
                codigo = content;
            }
        } catch (e) {
            // Si no es JSON válido, usar el contenido directamente como código
            codigo = content;
        }

        // Enviar el código al servidor
        fetch("{!!route('save.record')!!}", {
                method: 'POST',
                body: JSON.stringify({codigo: codigo}),
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(res => {
                // Verificar si la respuesta es exitosa
                if (!res.ok) {
                    return res.json().then(data => {
                        throw new Error(data.msg || 'Error en la solicitud');
                    });
                }
                return res.json();
            })
            .then(response => {
                if (response) {
                    Swal.fire({
                        title: response.msg,
                        text: '',
                        icon: response.level || 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Hubo un problema al procesar el código QR',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
            });

    });

    Instascan.Camera.getCameras().then(cameras =>
    {
        if(cameras.length > 0){
            scanner.start(cameras[0]);
        } else {
            console.error("No hay cámara en el dispositivo.");
        }
    });
</script>
@endsection
