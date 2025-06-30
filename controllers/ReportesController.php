<?php
require_once '../models/Reportes.php';
require_once '../public/lib/fpdf/fpdf.php';
session_start();

header('Content-Type: application/json');

class ReportesController {
    private $modelo;
    private $idUsuario;

    public function __construct() {
        $this->modelo = new ReporteEvento();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        $tipo   = $_GET['tipo'] ?? '';
        $evento = $_GET['evento'] ?? '';
        $formato = $_GET['formato'] ?? 'json';

        if ($option === 'eventosResponsable') {
            return $this->getEventosResponsable();
        }

        if (!empty($tipo) && !empty($evento)) {
            if ($formato === 'pdf') {
                $this->generarPDF($tipo, $evento);
            } else {
                $this->generarReporte($tipo, $evento);
            }
            return;
        }

        $this->json(['tipo' => 'error', 'mensaje' => 'Parámetros inválidos']);
    }

    private function getEventosResponsable() {
        try {
            $eventos = $this->modelo->getEventosPorResponsable($this->idUsuario);
            $this->json($eventos);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al obtener eventos: ' . $e->getMessage()]);
        }
    }

    private function generarReporte($tipo, $idEvento) {
        try {
            $datos = $this->obtenerDatos($tipo, $idEvento);

            // Obtener tipo_evento desde la base de datos
            $eventoInfo = $this->modelo->getEventoBasico($idEvento);
            $tipoEvento = $eventoInfo['TIPO_EVENTO'] ?? null;

            // Si el tipo es asistencia y el evento NO es curso, normaliza el campo porcentaje_asistencia
            if ($tipo === 'asistencia' && strtolower($tipoEvento) !== 'curso' && is_array($datos) && isset($datos[0])) {
                foreach ($datos as &$fila) {
                    // Si existe el campo PORCENTAJE_ASISTENCIA, lo renombramos a porcentaje_asistencia
                    if (isset($fila['PORCENTAJE_ASISTENCIA'])) {
                        $fila['porcentaje_asistencia'] = $fila['PORCENTAJE_ASISTENCIA'];
                    }
                    // Si el campo tiene otro nombre, puedes agregar más condiciones aquí
                }
                unset($fila); // buena práctica
            }

            if (in_array($tipo, ['financiero', 'general'])) {
                $this->json([
                    'detalle' => $datos['detalle'],
                    'totalRecaudado' => number_format($datos['totalRecaudado'], 2, '.', ''),
                    'tipo_evento' => $tipoEvento,
                    'eventoInfo' => $eventoInfo // aquí va ES_PAGADO
                ]);
            } else {
                // Si $datos es un array de detalle, lo envolvemos para agregar tipo_evento
                if (is_array($datos) && isset($datos[0])) {
                    $this->json([
                        'detalle' => $datos,
                        'tipo_evento' => $tipoEvento
                    ]);
                } else {
                    $this->json($datos);
                }
            }
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al generar el reporte: ' . $e->getMessage()]);
        }
    }

private function generarPDF($tipo, $idEvento) {
    try {
        $datos = $this->obtenerDatos($tipo, $idEvento);

        if (
            empty($datos) ||
            (in_array($tipo, ['financiero', 'general']) && empty($datos['detalle'])) ||
            (!in_array($tipo, ['financiero', 'general']) && empty($datos))
        ) {
            die("No hay datos para generar el PDF.");
        }

        $eventoInfo = $this->modelo->getEventoBasico($idEvento);
        $tituloEvento = $eventoInfo['TITULO'] ?? 'Evento';
        $tipoEvento   = $eventoInfo['TIPO_EVENTO'] ?? 'N/A';
        $fechaEvento  = $eventoInfo['FECHAINICIO'] ?? '---';

        $responsable  = $_SESSION['usuario']['NOMBRES'] . ' ' . $_SESSION['usuario']['APELLIDOS'];
        date_default_timezone_set('America/Guayaquil');
        $fechaHoy = date('d/m/Y H:i');
        $tituloPDF    = "Reporte de " . ucfirst($tipo);

        $detalle = in_array($tipo, ['financiero', 'general']) ? $datos['detalle'] : $datos;
        $totalRecaudado = in_array($tipo, ['financiero', 'general']) ? $datos['totalRecaudado'] : null;

        if (empty($detalle)) {
            die("No hay datos para generar el PDF.");
        }

        $columnas = array_keys($detalle[0]);
        if (in_array('CEDULA', $columnas)) {
            $columnas = array_merge(['CEDULA'], array_diff($columnas, ['CEDULA']));
        }

        $nombresAmigables = [
            'CEDULA' => 'Cédula',
            'NOMBRES' => 'Nombres',
            'APELLIDOS' => 'Apellidos',
            'CORREO' => 'Correo',
            'FECHAINSCRIPCION' => 'Inscripción',
            'ASISTIO' => 'Asistió',
            'NOTAFINAL' => 'Nota final',
            'FECHA_PAGO' => 'Fecha de pago',
            'METODO_PAGO' => 'Método de pago',
            'REFERENCIA' => 'Referencia',
            'MONTO_PAGADO' => 'Monto pagado',
            'COSTO' => 'Costo',
            'COMPROBANTE_URL' => 'Comprobante',
            'CERTIFICADO' => 'Certificado',
        ];

        $anchoCol = 190 / count($columnas);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);

        if (file_exists('../public/img/factura_logo.png')) {
            $pdf->Image('../public/img/factura_logo.png', 10, 10, 30);
        }

        $pdf->SetXY(50, 10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(0, 6, utf8_decode("EMPRESA PÚBLICA DE LA UNIVERSIDAD TÉCNICA DE AMBATO\nRUC: 1865042910001\nDirección: Ambato - Ecuador\nReporte emitido por: $responsable"), 0, 'L');

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 10, utf8_decode($tituloPDF), 0, 1, 'C');
        $pdf->Cell(0, 6, utf8_decode("Evento: $tituloEvento"), 0, 1);
        $pdf->Cell(0, 6, utf8_decode("Tipo de Evento: $tipoEvento"), 0, 1);
        $pdf->Cell(0, 6, utf8_decode("Fecha del Evento: $fechaEvento"), 0, 1);
        $pdf->Cell(0, 6, utf8_decode("Fecha de Emisión: $fechaHoy"), 0, 1);
        $pdf->Ln(5);

        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 10);
        foreach ($columnas as $col) {
            $textoCol = $nombresAmigables[strtoupper($col)] ?? ucfirst(strtolower(str_replace('_', ' ', $col)));
            $pdf->Cell($anchoCol, 8, utf8_decode($textoCol), 1, 0, 'C');
        }
        $pdf->Ln();

        // Filas de la tabla
        $pdf->SetFont('Arial', '', 9);
        foreach ($detalle as $fila) {
            foreach ($columnas as $col) {
                $valor = $fila[$col] ?? '';
                if ($col === 'COMPROBANTE_URL' && !empty($valor)) {
                    $valor = basename($valor);  // Solo nombre del archivo
                }
                $pdf->Cell($anchoCol, 7, utf8_decode($valor), 1, 0, 'C');

            }
            $pdf->Ln();
        }

        // Total recaudado si aplica
        if (in_array($tipo, ['financiero', 'general'])) {
            $pdf->Ln(5);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(190, 10, utf8_decode("TOTAL RECAUDADO: $ " . number_format($totalRecaudado, 2)), 1, 1, 'R', true);
        }

        // Observación
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->MultiCell(0, 5, utf8_decode("> Observación: Este reporte fue generado automáticamente por el sistema institucional.\n> Contacto: soporte@uta.edu.ec"), 0, 'L');

        $pdf->SetY(-15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, utf8_decode("Página ") . $pdf->PageNo(), 0, 0, 'C');

        $nombreArchivo = "reporte_{$tipo}_" . date('Ymd_His') . ".pdf";
        $pdf->Output('I', $nombreArchivo);
    } catch (Exception $e) {
        die("Error al generar PDF: " . $e->getMessage());
    }
}


private function obtenerDatos($tipo, $idEvento) {
    switch ($tipo) {
        case 'inscritos':
            return $this->modelo->getInscritosAceptadosPorEvento($this->idUsuario, $idEvento);

        case 'asistencia':
            return $this->modelo->getAsistenciaYNotasPorEvento($this->idUsuario, $idEvento);

        case 'certificados':
            return $this->modelo->getCertificadosPorEvento($this->idUsuario, $idEvento);
        case 'general':
            $detalle = $this->modelo->getReporteGeneralPorEvento($this->idUsuario, $idEvento);
            $total = array_sum(array_column($detalle, 'MONTO_PAGADO'));
             return [
             'detalle' => $detalle,
            'totalRecaudado' => $total
            ];
        case 'financiero':
            $detalle = $this->modelo->getReporteFinancieroPorEvento($this->idUsuario, $idEvento);
            $total = array_sum(array_column($detalle, 'MONTO_PAGADO'));
            return [
                'detalle' => $detalle,
                'totalRecaudado' => $total
            ];

        default:
            throw new Exception("Tipo de reporte no válido.");
    }
}


    private function json($data) {
        echo json_encode($data);
        exit;
    }
}

$controller = new ReportesController();
$controller->handleRequest();
