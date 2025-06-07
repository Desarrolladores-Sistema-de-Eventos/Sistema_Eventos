<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción al Curso - UTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .form-card {
            border-radius: 15px;
            border: 1px solid #8B0000;
        }
        .form-title {
            color: #8B0000;
            font-weight: bold;
            border-bottom: 2px solid #8B0000;
            padding-bottom: 10px;
        }
        .section-title {
            color: #8B0000;
            font-weight: bold;
        }
        .requirements-box {
            background-color: #f8f9fa;
        }
        .payment-info-title {
            color: #8B0000;
            font-weight: bold;
        }
        .btn-uta {
            background-color: #8B0000;
            border-color: #600000;
            color: white;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-uta:hover {
            background-color: #A30000;
            border-color: #800000;
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card shadow-lg form-card">
            <div class="card-body p-4 p-md-5">
                <h2 class="card-title text-center mb-4 pb-2 form-title">
                    <i class="fas fa-edit me-2"></i> Inscripción al Curso
                </h2>

                <form action="procesar_inscripcion.php" method="POST" enctype="multipart/form-data">
                    <h4 class="section-title mb-3"><i class="fas fa-user me-2"></i> Información del Participante</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Juan Pérez García" required>
                        </div>
                        <div class="col-md-6">
                            <label for="matricula" class="form-label">Matrícula <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="matricula" name="matricula" placeholder="202012345" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg" id="correo" name="correo" placeholder="juan.perez@uta.edu.ec" required>
                    </div>

                    <div class="mb-4">
                        <label for="carrera" class="form-label">Carrera <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="carrera" name="carrera" placeholder="Software" required>
                    </div>

                    <h4 class="section-title mb-3"><i class="fas fa-clipboard-list me-2"></i> Requisitos de Inscripción</h4>
                    <div class="mb-4 p-3 border rounded requirements-box">
                        <p>Para completar su inscripción, debe presentar:</p>
                        <ul>
                            <li>Copia de cédula de identidad</li>
                            <li>Carnet estudiantil vigente</li>
                            <li>Certificado de votación (opcional)</li>
                        </ul>
                    </div>

                    <!-- Campo para subir requisitos -->
                    <div class="mb-4">
                        <label for="requisitos" class="form-label">Subir Requisitos <span class="text-danger">*</span></label>
                        <input class="form-control form-control-lg" type="file" id="requisitos" name="requisitos[]" multiple accept="image/*, application/pdf" required>
                        <div class="form-text">Formatos: JPG, PNG, PDF. Máx 5MB por archivo.</div>
                    </div>

                    <h4 class="section-title mb-3"><i class="fas fa-money-check-alt me-2"></i> Información de Pago</h4>
                    <div class="mb-4">
                        <label for="tipoPago" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="tipoPago" name="tipoPago" required>
                            <option value="">Selecciona un método de pago</option>
                            <option value="deposito">Depósito Bancario</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                        </select>
                    </div>

                    <div id="paymentDetails" class="mb-4 p-3 border rounded bg-light" style="display: none;">
                        <h5 class="text-center mb-3 payment-info-title"><i class="fas fa-university me-2"></i> Datos para Depósito/Transferencia</h5>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-landmark me-2"></i> Bancos en Ecuador:</h6>
                            <p><strong>Banco Pichincha</strong></p>
                            <p><strong>Cuenta Corriente:</strong> 210987654321</p>
                            <p><strong>Beneficiario:</strong> Universidad Técnica de Ambato</p>
                            <p><strong>RUC:</strong> 1234567890001</p>
                            
                            <p class="mt-3"><strong>Produbanco</strong></p>
                            <p><strong>Cuenta de Ahorros:</strong> 1234567890123456</p>
                            <p><strong>Beneficiario:</strong> Universidad Técnica de Ambato</p>
                        </div>
                        
                        <div class="mt-3">
                            <h6><i class="fas fa-globe-americas me-2"></i> Pagos Internacionales:</h6>
                            <p><strong>Banco:</strong> Banco del Pacífico</p>
                            <p><strong>SWIFT/BIC:</strong> BCPOECEQ</p>
                            <p><strong>IBAN:</strong> EC0212345678901234567890</p>
                            <p><strong>Beneficiario:</strong> Universidad Técnica de Ambato</p>
                        </div>
                        
                        <p class="text-muted small mt-3">
                            <i class="fas fa-info-circle me-1"></i> 
                            Subir comprobante con nombre completo y matrícula
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="comprobantePago" class="form-label">Subir Comprobante de Pago <span class="text-danger">*</span></label>
                        <input class="form-control form-control-lg" type="file" id="comprobantePago" name="comprobantePago" accept="image/*, application/pdf" required>
                        <div class="form-text">Formatos aceptados: JPG, PNG, PDF. Tamaño máximo: 5MB.</div>
                    </div>

                    <div class="mb-4">
                        <label for="comentarios" class="form-label">Comentarios adicionales (opcional):</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="4" placeholder="Escribe aquí tus comentarios o necesidades especiales..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3">
                        <button type="submit" class="btn btn-uta btn-lg">
                            <i class="fas fa-check-circle me-2"></i> Confirmar Inscripción
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times-circle me-2"></i> Limpiar Formulario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar detalles de pago
        document.addEventListener('DOMContentLoaded', function() {
            const tipoPagoSelect = document.getElementById('tipoPago');
            const paymentDetailsDiv = document.getElementById('paymentDetails');

            tipoPagoSelect.addEventListener('change', function() {
                if (this.value === 'deposito' || this.value === 'transferencia') {
                    paymentDetailsDiv.style.display = 'block';
                } else {
                    paymentDetailsDiv.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>