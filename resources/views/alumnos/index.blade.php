@extends('layouts.app')

@section('titulo')
    Alumnos
@endsection

@section('menu_select')
    @php $select = 'alumnos'; @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm"
                        onclick="alumno('agregar','-','{{ route('alumnos.store') }}')" title="Registrar alumno">
                        <i class="fas fa-user-plus ml-2"></i> Registrar Alumno
                    </button>

                    <div class="table-responsive my-4">
                        <table id="tableAlumnos" class="table table-striped display" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Cédula</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal agregar/editar Alumno --}}
    <div class="modal fade" id="modalAddAlumno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnoTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form method="post" id="form_save" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="_method">
                    <input type="hidden" id="input_accion">

                    <div class="modal-body">
                        <!-- QR Code Section -->
                        <div class="row mb-3" id="qr_section" style="display:none;">
                            <div class="col-12 text-center">
                                <h5>Código QR</h5>
                                <div id="qr_container"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group my-2">
                                <label for="cedula" class="input-group-text col-sm-4">Cédula *</label>
                                <input type="text" class="form-control col-sm-8" name="cedula" id="cedula" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="nombres" class="input-group-text col-sm-4">Nombres *</label>
                                <input type="text" class="form-control col-sm-8" name="nombres" id="nombres" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="apellidos" class="input-group-text col-sm-4">Apellidos *</label>
                                <input type="text" class="form-control col-sm-8" name="apellidos" id="apellidos" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="correo" class="input-group-text col-sm-4">Correo</label>
                                <input type="email" class="form-control col-sm-8" name="correo" id="correo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="rol" class="input-group-text col-sm-4">Rol *</label>
                                <select class="form-control col-sm-8" name="rol" id="rol" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="trabajador">Trabajador</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="foto" class="input-group-text col-sm-4">Foto</label>
                                <input type="file" class="form-control col-sm-8" name="foto" id="foto" accept="image/*">
                            </div>
                        </div>
                        <div class="row" id="preview_foto" style="display:none;">
                            <div class="col-12 text-center my-2">
                                <img id="imagen_preview" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardar()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let cedula = document.getElementById('cedula');
    let nombres = document.getElementById('nombres');
    let apellidos = document.getElementById('apellidos');
    let correo = document.getElementById('correo');
    let rol = document.getElementById('rol');
    let foto = document.getElementById('foto');
    let input_accion = document.getElementById('input_accion');

    let alumnos = Object.values(@json($alumnos));
    let table = $('#tableAlumnos').DataTable({
        "language": {!! ConfigHelper::languageDataTable() !!},
    });

    $(document).ready(function() {
        loadTable(alumnos);

        $('#foto').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen_preview').attr('src', e.target.result);
                    $('#preview_foto').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#preview_foto').hide();
            }
        });
    });

    const alumno = (accion, url_show, url) => {
        input_accion.value = accion;
        
        // Limpiar formulario al inicio
        limpiarFormulario();
        $('#qr_section').hide();

        if(accion == 'agregar') {
            // Configurar para agregar nuevo alumno
            $('#modalAlumnoTitle').html('Registrar Estudiante');
            $('#_method').val('POST');
            habilitarCampos(true);
            mostrarBotonGuardar(true);
        } else if(accion == 'editar') {
            // Configurar para editar alumno
            $('#modalAlumnoTitle').html('Editar estudiante');
            $('#_method').val('PUT');
            cargarDatosAlumno(url_show, true); // true para modo edición
            habilitarCampos(true);
            mostrarBotonGuardar(true);
        } else {
            // Configurar para mostrar alumno
            $('#modalAlumnoTitle').html('Detalles del Estudiante');
            cargarDatosAlumno(url_show, false); // false para modo visualización
            habilitarCampos(false);
            mostrarBotonGuardar(false);
        }

        $('#form_save').attr('action', url);
        $('#modalAddAlumno').modal('show');
    }

    // Función para habilitar/deshabilitar campos
    const habilitarCampos = (habilitar) => {
        $('#cedula, #nombres, #apellidos, #correo, #rol, #foto').prop('disabled', !habilitar);
    }

    // Función para mostrar/ocultar botón guardar
    const mostrarBotonGuardar = (mostrar) => {
        $('.modal-footer button.btn-primary').toggle(mostrar);
    }

    // Función para cargar datos del alumno
    const cargarDatosAlumno = async (url, esEdicion) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const alumno = await response.json();
            console.log('Datos del alumno:', alumno);

            // Llenar los campos del formulario
            cedula.value = alumno.cedula;
            nombres.value = alumno.nombres;
            apellidos.value = alumno.apellidos;
            correo.value = alumno.correo || '';
            rol.value = alumno.rol;

            // Manejar la foto
            if(alumno.foto){
                $('#imagen_preview').attr('src', alumno.foto_url);
                $('#preview_foto').show();
            } else {
                $('#preview_foto').hide();
            }

            // Mostrar QR solo en modo visualización
            if(!esEdicion && alumno.qr) {
                const qrHtml = atob(alumno.qr);
                $('#qr_container').html(qrHtml);
                $('#qr_section').show();
            } else {
                $('#qr_section').hide();
            }

        } catch (err) {
            console.error('Error al cargar datos:', err);
            Swal.fire('Error', 'No se pudo cargar la información del estudiante', 'error');
        }
    }

    const save_alumno = () => {
        let formData = new FormData();
        formData.append('cedula', cedula.value);
        formData.append('nombres', nombres.value);
        formData.append('apellidos', apellidos.value);
        formData.append('correo', correo.value);
        formData.append('rol', rol.value);

        if(foto.files[0]) formData.append('foto', foto.files[0]);

        fetch($('#form_save').attr('action'), {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        })
        .then(res => res.json())
        .then(response => {
            if(response && response.res == 'ok'){
                $('#modalAddAlumno').modal('hide');
                limpiarFormulario();
                Swal.fire('Registro Guardado', 'El estudiante fue registrado exitosamente', 'success');
                loadTable(response.alumnos);
            }
        }).catch(err => console.error(err));
    }

    const update_alumno = () => {
        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('cedula', cedula.value);
        formData.append('nombres', nombres.value);
        formData.append('apellidos', apellidos.value);
        formData.append('correo', correo.value);
        formData.append('rol', rol.value);
        if(foto.files[0]) formData.append('foto', foto.files[0]);

        fetch($('#form_save').attr('action'), {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        })
        .then(res => res.json())
        .then(response => {
            if(response && response.res == 'ok'){
                $('#modalAddAlumno').modal('hide');
                limpiarFormulario();
                Swal.fire('Registro Actualizado', 'Los datos del estudiante fueron actualizados', 'success');
                loadTable(response.alumnos);
            }
        }).catch(err => console.error(err));
    }

    const limpiarFormulario = () => {
        cedula.value = '';
        nombres.value = '';
        apellidos.value = '';
        correo.value = '';
        rol.value = '';
        foto.value = '';
        $('#preview_foto').hide();
    }

    const guardar = () => {
        if(!cedula.value || !nombres.value || !apellidos.value) {
            Swal.fire('Campos obligatorios vacíos', 'Cédula, nombres y apellidos son obligatorios', 'warning');
        } else {
            input_accion.value == 'agregar' ? save_alumno() : update_alumno();
        }
    }

    const show_alumno = async (act, url) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const alumno = await response.json();
            console.log('Datos del alumno:', alumno); // Debug

            // Llenar los campos del formulario
            cedula.value = alumno.cedula;
            nombres.value = alumno.nombres;
            apellidos.value = alumno.apellidos;
            correo.value = alumno.correo || '';
            rol.value = alumno.rol;

            // Manejar la foto
            if(alumno.foto){
                $('#imagen_preview').attr('src', alumno.foto_url);
                $('#preview_foto').show();
            } else {
                $('#preview_foto').hide();
            }

            // Manejar el QR
            if(act === 'show' && alumno.qr) {
                // Decodificar el QR (viene en base64)
                const qrHtml = atob(alumno.qr);
                $('#qr_container').html(qrHtml);
                $('#qr_section').show();
            } else {
                $('#qr_section').hide();
            }

            // Desactivar campos si es modo visualización
            if(act === 'show') {
                $('#cedula, #nombres, #apellidos, #correo, #rol, #foto').prop('disabled', true);
                $('.modal-footer button.btn-primary').hide(); // Ocultar botón de guardar
            } else {
                $('#cedula, #nombres, #apellidos, #correo, #rol, #foto').prop('disabled', false);
                $('.modal-footer button.btn-primary').show(); // Mostrar botón de guardar
            }

        } catch (err) {
            console.error('Error al cargar datos:', err);
            Swal.fire('Error', 'No se pudo cargar la información del estudiante', 'error');
        }
    }

    const delete_alumno = url_delete => {
        Swal.fire({
            title: '¿Estas seguro de eliminar este alumno?',
            text: "Esta acción no se podrá revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if(result.isConfirmed){
                fetch(url_delete, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if(response && response.res == 'ok'){
                        Swal.fire('Eliminado!', 'El alumno fue eliminado.', 'success');
                        loadTable(response.alumnos);
                    }
                }).catch(err => console.error(err));
            }
        });
    }

    const loadTable = alumnos => {
        table.clear().draw();
        alumnos.forEach(alumno => {
            let ruta_show = `/alumnos/${alumno.id}/show`;
            let ruta_update = `/alumnos/${alumno.id}`;
            let ruta_destroy = `/alumnos/${alumno.id}`;

            let fotoHtml = alumno.foto 
                ? `<img src="/storage/${alumno.foto}" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;">`
                : `<img src="/admin/images/default-avatar.png" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;">`;

            table.row.add([
                fotoHtml,
                alumno.cedula,
                alumno.nombres,
                alumno.apellidos,
                alumno.rol,
                `
                <div class="btn-group">
                    <button onclick="alumno('ver','${ruta_show}','${ruta_update}')" class="btn btn-info btn-sm" title="Ver Detalles y QR">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="alumno('editar','${ruta_show}','${ruta_update}')" class="btn btn-secondary btn-sm" title="Editar Alumno">
                        <i class="fas fa-user-edit"></i>
                    </button>
                    <button onclick="delete_alumno('${ruta_destroy}')" class="btn btn-danger btn-sm" title="Eliminar Alumno">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                `
            ]).draw(false);
        });
    }
</script>
@endsection
