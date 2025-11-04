@extends('layouts.alumno-auth')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Historial de Asistencias</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($asistencias as $asistencia)
                                    <tr>
                                        <td>{{ $asistencia->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $asistencia->created_at->format('h:i A') }}</td>
                                        <td>
                                            <span class="badge {{ $asistencia->tipo === 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($asistencia->tipo) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay registros de asistencia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $asistencias->links() }}
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('alumno.perfil') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Perfil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection