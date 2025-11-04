<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Alumno extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cedula',
        'nombres',
        'apellidos',
        'correo',
        'rol',
        'foto',
    ];

    // Agregar el accessor al array de appends para que aparezca en JSON
    protected $appends = ['qr', 'full_name'];

    public function asistencias(){
        return $this->hasMany(Asistencia::class);
    }

    // Método para buscar por QR
    public static function buscarPorQR($datos){
        \Log::info('Buscando alumno por datos QR - Datos recibidos:', ['datos' => $datos]);
        
        try {
            // Si los datos vienen como string JSON, intentar decodificar
            if (is_string($datos)) {
                // Si el string parece ser JSON escapado, desescaparlo
                if (strpos($datos, '\\"') !== false) {
                    $datos = stripslashes($datos);
                }
                $datos = json_decode($datos, true);
                \Log::info('Datos QR decodificados:', ['datos_decodificados' => $datos]);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Error decodificando JSON: ' . json_last_error_msg());
                }
            }
            
            // Si después de todo el procesamiento no tenemos un array, error
            if (!is_array($datos)) {
                throw new \Exception('Los datos no están en el formato esperado');
            }
            
            \Log::info('Intentando encontrar alumno con datos:', $datos);
            
            // Intentar buscar por ID primero (más preciso)
            if (!empty($datos['id'])) {
                $alumno = self::find($datos['id']);
                if ($alumno) {
                    \Log::info('Alumno encontrado por ID:', [
                        'id' => $datos['id'],
                        'cedula' => $alumno->cedula,
                        'nombre' => $alumno->full_name
                    ]);
                    return $alumno;
                }
            }
            
            // Si viene un código, intentar usarlo como ID
            if (!empty($datos['codigo'])) {
                $alumno = self::find($datos['codigo']);
                if ($alumno) {
                    \Log::info('Alumno encontrado por código:', [
                        'codigo' => $datos['codigo'],
                        'cedula' => $alumno->cedula,
                        'nombre' => $alumno->full_name
                    ]);
                    return $alumno;
                }
            }
            
            // Si no hay ID o código, o no se encontró, buscar por cédula
            if (!empty($datos['cedula'])) {
                $alumno = self::where('cedula', $datos['cedula'])->first();
                \Log::info('Resultado búsqueda por cédula:', [
                    'cedula' => $datos['cedula'],
                    'encontrado' => !is_null($alumno),
                    'nombre' => $alumno ? $alumno->full_name : null
                ]);
                return $alumno;
            }
            
            \Log::error('No se encontraron datos válidos en el QR:', [
                'datos_recibidos' => $datos
            ]);
            return null;
            
        } catch (\Exception $e) {
            \Log::error('Error procesando datos QR:', [
                'error' => $e->getMessage(),
                'datos_originales' => $datos
            ]);
            return null;
        }
    }
    
    // Obtener última asistencia
    public function ultimaAsistencia(){
        return $this->asistencias()->latest('fecha')->first();
    }

    // Accessor que genera el QR dinámicamente usando SVG
    public function getQrAttribute(){
        // Asegurarse de que los datos estén en el formato correcto
        $data = [
            'cedula' => $this->cedula,
            'nombre' => $this->full_name,
            'rol' => $this->rol,
            'id' => $this->id // Agregamos el ID para mayor seguridad
        ];
        
        // Generar QR con mejor formato y error correction
        return base64_encode(
            QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H') // Alto nivel de corrección de errores
                ->margin(1) // Margen mínimo para mejor escaneo
                ->generate(json_encode($data, JSON_UNESCAPED_UNICODE))
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

    // Verificar si es estudiante
    public function isEstudiante(){
        return $this->rol === 'estudiante';
    }

    // Verificar si es trabajador
    public function isTrabajador(){
        return $this->rol === 'trabajador';
    }
}