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
        'nombres',
        'apellidos',
    ];

    // Agregar el accessor al array de appends para que aparezca en JSON
    protected $appends = ['qr'];

    public function asistencias(){
        return $this->hasMany(Asistencia::class);
    }

    // Accessor que genera el QR dinámicamente usando SVG (no requiere extensiones)
    public function getQrAttribute(){
        return base64_encode(
            QrCode::format('svg')
                ->size(200)
                ->generate($this->codigo)
        );
    }

    public function getFullNameAttribute(){
        return $this->nombres.' '.$this->apellidos;
    }
}