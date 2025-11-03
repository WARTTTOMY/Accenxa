<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Alumno extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'codigo',
        'documento_identidad',
        'nombres',
        'apellidos',
        'foto',
        'carrera',
        'semestre',
        'estado',
        'fecha_expiracion',
    ];

    // Agregar el accessor al array de appends para que aparezca en JSON
    protected $appends = ['qr', 'full_name'];

    // Cast de campos
    protected $casts = [
        'fecha_expiracion' => 'date',
    ];

    public function asistencias(){
        return $this->hasMany(Asistencia::class);
    }

    // Accessor que genera el QR dinámicamente usando SVG (no requiere extensiones)
    public function getQrAttribute(){
        // Datos que contendrá el QR
        $data = [
            'id' => $this->codigo,
            'nombre' => $this->full_name,
            'documento' => $this->documento_identidad,
            'carrera' => $this->carrera,
            'valido_hasta' => $this->fecha_expiracion ? $this->fecha_expiracion->format('Y-m-d') : null,
            'hash' => hash('sha256', $this->codigo . config('app.key'))
        ];
        
        return base64_encode(
            QrCode::format('svg')
                ->size(300)
                ->generate(json_encode($data))
        );
    }

    public function getFullNameAttribute(){
        return $this->nombres.' '.$this->apellidos;
    }

    // Accessor para obtener la URL completa de la foto
    public function getFotoUrlAttribute(){
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        // Imagen por defecto si no tiene foto
        return asset('admin/images/default-avatar.png');
    }

    // Verificar si el carnet está activo
    public function isActivo(){
        if ($this->estado !== 'activo') {
            return false;
        }
        
        if ($this->fecha_expiracion && $this->fecha_expiracion->isPast()) {
            return false;
        }
        
        return true;
    }
}