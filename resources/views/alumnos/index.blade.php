@extends('layouts.app')
@section('titulo')
    Alumnos
@endsection
@section('menu_select')
    {{$select = 'alumnos'}}
@endsection
@section('content')
   
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <button type="button" class="btn btn-primary btn-sm"
                        onclick="accionAlumno('agregar','-','{{ route('alumnos.store') }}')" title="registrar alumno">
                        <i class="fas fa-user-plus ml-2"></i> Registrar Alumno
                    </button>

                    <div class="table-responsive my-4">
                        <table id="tableAlumnos" class="table table-striped display" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Codigo</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Carrera</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal agregar Alumno --}}
    <div class="modal fade" id="modalAddAlumno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlumnoTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="form_save" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="_method">
                    <input type="hidden" id="input_accion">

                    <div class="modal-body">
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="codigo" class="input-group-text col-sm-4">Código *</label>
                                <input type="text" class="form-control col-sm-8" name="codigo" id="codigo" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="documento_identidad" class="input-group-text col-sm-4">Documento ID</label>
                                <input type="text" class="form-control col-sm-8" name="documento_identidad" id="documento_identidad">
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
                                <label for="carrera" class="input-group-text col-sm-4">Carrera</label>
                                <input type="text" class="form-control col-sm-8" name="carrera" id="carrera">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="semestre" class="input-group-text col-sm-4">Semestre</label>
                                <input type="text" class="form-control col-sm-8" name="semestre" id="semestre">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group my-2">
                                <label for="fecha_expiracion" class="input-group-text col-sm-4">Válido hasta</label>
                                <input type="date" class="form-control col-sm-8" name="fecha_expiracion" id="fecha_expiracion">
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

    {{-- Modal show Alumno --}}
    <div class="modal fade" id="modalShowAlumno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carnet Digital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="s_foto" src="" class="img-fluid img-thumbnail" alt="Foto del estudiante" style="max-width: 200px;">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="input-group my-2 col-md-12">
                                    <label for="s_codigo" class="input-group-text col-sm-4">Código</label>
                                    <input type="text" class="form-control col-sm-8" id="s_codigo" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group my-2 col-md-12">
                                    <label for="s_nombres" class="input-group-text col-sm-4">Nombres</label>
                                    <input type="text" class="form-control col-sm-8" id="s_nombres" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group my-2 col-md-12">
                                    <label for="s_apellidos" class="input-group-text col-sm-4">Apellidos</label>
                                    <input type="text" class="form-control col-sm-8" id="s_apellidos" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group my-2 col-md-12">
                                    <label for="s_carrera" class="input-group-text col-sm-4">Carrera</label>
                                    <input type="text" class="form-control col-sm-8" id="s_carrera" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group my-2 col-md-12">
                                    <label for="s_estado" class="input-group-text col-sm-4">Estado</label>
                                    <input type="text" class="form-control col-sm-8" id="s_estado" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mt-3">
                        <div class="col-md-12 text-center">
                            <h6>Código QR de Acceso</h6>
                            <img id="qr_alumno" class="img-fluid" alt="Código QR del estudiante" width="300">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="imprimirCarnet()">
                        <i class="fas fa-print"></i> Imprimir Carnet
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    let codigo = document.getElementById('codigo');
    let documento_identidad = document.getElementById('documento_identidad');
    let nombres = document.getElementById('nombres');
    let apellidos = document.getElementById('apellidos');
    let carrera = document.getElementById('carrera');
    let semestre = document.getElementById('semestre');
    let fecha_expiracion = document.getElementById('fecha_expiracion');
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

    /* ✅ nuevo nombre: antes era "alumno" */
    const accionAlumno = (accion, url_show, url) => {
        input_accion.value = accion;
        if (accion == 'agregar') {
            codigo.value = '';
            documento_identidad.value = '';
            nombres.value = '';
            apellidos.value = '';
            carrera.value = '';
            semestre.value = '';
            fecha_expiracion.value = '';
            foto.value = '';
            $('#preview_foto').hide();
            $('#modalAlumnoTitle').html('Registrar Estudiante');
            $('#_method').val('POST');
        } else if (accion == 'editar') {
            show_alumno('edit', url_show);
            $('#modalAlumnoTitle').html('Editar estudiante');
            $('#_method').val('PUT');
        } else {
            show_alumno('show', url_show);
        }
        $('#form_save').attr('action', url);
        $('#modalAddAlumno').modal('show');
    }

    const save_alumno = () => {
        let formData = new FormData();
        formData.append('codigo', codigo.value);
        formData.append('documento_identidad', documento_identidad.value);
        formData.append('nombres', nombres.value);
        formData.append('apellidos', apellidos.value);
        formData.append('carrera', carrera.value);
        formData.append('semestre', semestre.value);
        formData.append('fecha_expiracion', fecha_expiracion.value);

        if (foto.files[0]) {
            formData.append('foto', foto.files[0]);
        }

        let url = $('#form_save').attr('action');
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(res => res.json())
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al guardar el estudiante',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        })
        .then(response => {
            if (response && response.res == 'ok') {
                $('#modalAddAlumno').modal('hide');
                limpiarFormulario();

                Swal.fire({
                    title: 'Registro Guardado',
                    text: 'El estudiante fue registrado exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                });

                loadTable(response.alumnos);
            }
        });
    }

    const update_alumno = () => {
        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('codigo', codigo.value);
        formData.append('documento_identidad', documento_identidad.value);
        formData.append('nombres', nombres.value);
        formData.append('apellidos', apellidos.value);
        formData.append('carrera', carrera.value);
        formData.append('semestre', semestre.value);
        formData.append('fecha_expiracion', fecha_expiracion.value);

        if (foto.files[0]) {
            formData.append('foto', foto.files[0]);
        }

        let url = $('#form_save').attr('action');

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(res => res.json())
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al actualizar el estudiante',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        })
        .then(response => {
            if (response && response.res == 'ok') {
                $('#modalAddAlumno').modal('hide');
                limpiarFormulario();

                Swal.fire({
                    title: 'Registro Actualizado',
                    text: 'Los datos del estudiante fueron actualizados',
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                });

                loadTable(response.alumnos);
            }
        });
    }

    const limpiarFormulario = () => {
        codigo.value = '';
        documento_identidad.value = '';
        nombres.value = '';
        apellidos.value = '';
        carrera.value = '';
        semestre.value = '';
        fecha_expiracion.value = '';
        foto.value = '';
        $('#preview_foto').hide();
    }

    const guardar = () => {
        if (codigo.value == '' || nombres.value == '' || apellidos.value == '') {
            Swal.fire({
                title: 'Campos obligatorios vacíos',
                text: 'Código, nombres y apellidos son obligatorios',
                icon: 'warning',
                confirmButtonText: 'Cerrar'
            })
        } else {
            if (input_accion.value == 'agregar') {
                save_alumno();
            } else if (input_accion.value == 'editar') {
                update_alumno();
            }
        }
    }

    /* ✅ corregido: ahora no se llama igual que la función principal */
    const show_alumno = async (act, url) => {
        try {
            let dataAlumno = await fetch(url)
                .then(response => response.json());

            if (act == 'show') {
                $('#s_codigo').val(dataAlumno.codigo);
                $('#s_nombres').val(dataAlumno.nombres);
                $('#s_apellidos').val(dataAlumno.apellidos);
                $('#s_carrera').val(dataAlumno.carrera || 'No especificada');
                $('#s_estado').val(dataAlumno.estado ? dataAlumno.estado.toUpperCase() : 'ACTIVO');

                if (dataAlumno.foto) {
                    $('#s_foto').attr('src', `/storage/${dataAlumno.foto}`);
                } else {
                    $('#s_foto').attr('src', '/admin/img/default-avatar.png');
                }

                $('#qr_alumno').attr('src', `data:image/svg+xml;base64,${dataAlumno.qr}`);

                $('#modalShowAlumno').modal('show');
            } else {
                codigo.value = dataAlumno.codigo;
                documento_identidad.value = dataAlumno.documento_identidad || '';
                nombres.value = dataAlumno.nombres;
                apellidos.value = dataAlumno.apellidos;
                carrera.value = dataAlumno.carrera || '';
                semestre.value = dataAlumno.semestre || '';
                fecha_expiracion.value = dataAlumno.fecha_expiracion || '';

                if (dataAlumno.foto) {
                    $('#imagen_preview').attr('src', `/storage/${dataAlumno.foto}`);
                    $('#preview_foto').show();
                } else {
                    $('#preview_foto').hide();
                }
            }
        } catch (error) {
            console.error('Error al cargar alumno:', error);
            Swal.fire({
                title: 'Error',
                text: 'No se pudo cargar la información del estudiante',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    }

    const imprimirCarnet = () => {
        window.print();
    }

    const delete_alumno = url_delete => {
        Swal.fire({
            title: '¿Estas seguro de eliminar este alumno?',
            text: "Esta acción no se podrá revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url_delete, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(res => res.json())
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo eliminar el alumno',
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                })
                .then(response => {
                    if (response && response.res == 'ok') {
                        Swal.fire(
                            'Eliminado!',
                            'El Alumno fue eliminado.',
                            'success'
                        )
                        loadTable(response.alumnos);
                    }
                });
            }
        });
    }

    const loadTable = alumnos => {
        resetTable();
        alumnos.forEach(alumno => {
            let ruta_show = `/alumnos/${alumno.id}/show`;
            let ruta_update = `/alumnos/${alumno.id}`;
            let ruta_destroy = `/alumnos/${alumno.id}/destroy`;

            let fotoHtml = alumno.foto 
                ? `<img src="/storage/${alumno.foto}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">`
                : `<img src="/admin/img/default-avatar.png" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">`;

            table.row.add([
                fotoHtml,
                alumno.codigo,
                alumno.nombres,
                alumno.apellidos,
                alumno.carrera || 'N/A',
                `   
                <div class="btn-group">
                    <button type="button" onclick="show_alumno('show','${ruta_show}')" class="btn btn-primary btn-sm" title="Ver QR"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="accionAlumno('editar','${ruta_show}','${ruta_update}')" title="Editar"><i class="fas fa-user-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_alumno('${ruta_destroy}')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </div>
                `,
            ]).draw(false);
        });
    }

    const resetTable = () => {
        table.clear().draw();
    }
</script>

@endsection