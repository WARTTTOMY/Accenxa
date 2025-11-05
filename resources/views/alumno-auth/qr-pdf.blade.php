<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Código QR - {{ $alumno->full_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            margin: 0;
        }
        
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            background: white;
            position: relative;
            overflow: hidden;
            page-break-after: avoid;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 26px;
            margin-bottom: 5px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .header p {
            font-size: 13px;
            font-weight: 300;
            opacity: 0.95;
        }
        
        .content {
            padding: 25px 35px;
        }
        
        .qr-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .qr-container {
            display: inline-block;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            margin-bottom: 12px;
        }
        
        .qr-container img {
            display: block;
            width: 220px;
            height: 220px;
        }
        
        .qr-label {
            font-size: 12px;
            color: #6c757d;
            margin-top: 8px;
            font-weight: 400;
        }
        
        .info-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .info-title {
            font-size: 15px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-item {
            display: table-cell;
            background: white;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 3px solid #667eea;
            width: 48%;
            vertical-align: top;
        }
        
        .info-row .info-item:first-child {
            padding-right: 8px;
        }
        
        .info-row .info-item:last-child {
            padding-left: 8px;
        }
        
        .info-item label {
            display: block;
            font-size: 10px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-item span {
            font-size: 13px;
            color: #212529;
            font-weight: 500;
        }
        
        .spacer {
            height: 10px;
        }
        
        .instructions {
            background: #e7f3ff;
            border-left: 3px solid #0d6efd;
            padding: 15px 18px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .instructions h3 {
            font-size: 13px;
            color: #0d6efd;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .instructions ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        
        .instructions li {
            padding: 5px 0;
            color: #495057;
            font-size: 11px;
            position: relative;
            padding-left: 20px;
            line-height: 1.4;
        }
        
        .instructions li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #0d6efd;
            font-weight: bold;
            font-size: 13px;
        }
        
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 10px;
            border-top: 1px solid #e9ecef;
        }
        
        .footer strong {
            display: block;
            margin-bottom: 3px;
            font-size: 11px;
            color: #495057;
            font-weight: 600;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #667eea;
            color: white;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>Mi Código QR de Asistencia</h1>
            <p>Sistema de Control de Asistencia</p>
        </div>
        
        <!-- Contenido -->
        <div class="content">
            <!-- Sección QR -->
            <div class="qr-section">
                <div class="qr-container">
                    <img src="data:image/svg+xml;base64,{{ $alumno->qr }}" alt="Código QR">
                </div>
                <p class="qr-label">Escanea este código para registrar tu asistencia</p>
            </div>
            
            <!-- Información Personal -->
            <div class="info-section">
                <div class="info-title">👤 Información Personal</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-item">
                            <label>Nombre Completo</label>
                            <span>{{ $alumno->full_name }}</span>
                        </div>
                        <div class="info-item">
                            <label>Documento</label>
                            <span>{{ $alumno->cedula }}</span>
                        </div>
                    </div>
                    <div class="spacer"></div>
                    <div class="info-row">
                        <div class="info-item">
                            <label>Correo Electrónico</label>
                            <span>{{ $alumno->correo ?: 'No registrado' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Tipo de Usuario</label>
                            <span class="badge">{{ ucfirst($alumno->rol) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Instrucciones -->
            <div class="instructions">
                <h3>📋 Instrucciones de Uso</h3>
                <ul>
                    <li>Presenta este código QR al llegar a la institución</li>
                    <li>El sistema registrará automáticamente tu hora de entrada</li>
                    <li>Vuelve a escanear al salir para registrar tu hora de salida</li>
                    <li>Puedes consultar tu historial en el portal de asistencia</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <strong>Sistema de Control de Asistencia</strong>
            Documento generado el {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
