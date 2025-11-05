@extends('layouts.alumno-auth')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-history me-2"></i>Historial de Asistencias
                        </h4>
                        <p class="text-muted mb-0 mt-1">
                            <i class="fas fa-user me-1"></i>{{ $alumno->full_name }}
                        </p>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="px-4">
                                        <i class="fas fa-calendar-alt me-2"></i>Fecha
                                    </th>
                                    <th>
                                        <i class="fas fa-sign-in-alt me-2"></i>Entrada
                                    </th>
                                    <th>
                                        <i class="fas fa-sign-out-alt me-2"></i>Salida
                                    </th>
                                    <th>
                                        <i class="fas fa-info-circle me-2"></i>Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($asistencias as $asistencia)
                                    <tr>
                                        <td class="px-4">
                                            {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <span class="fw-500">{{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-500">{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '-' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $completa = $asistencia->hora_entrada && $asistencia->hora_salida;
                                            @endphp
                                            <span class="badge {{ $completa ? 'bg-success' : 'bg-warning text-dark' }}">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                {{ $completa ? 'Completa' : 'Falta salida' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                <p class="mb-0">No hay registros de asistencia disponibles.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($asistencias->hasPages())
                        <div class="d-flex justify-content-center border-top p-4">
                            {{ $asistencias->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen de Asistencias -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Total de Asistencias</h5>
                                    <h2 class="display-4 mb-0 fw-bold">{{ $asistencias->count() }}</h2>
                                </div>
                                <i class="fas fa-calendar-check fa-4x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection