<?php
require_once '../core/Conexion.php';

class Factura {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function getDatosParticipante($idInscripcion) {
    $sql = "SELECT 
                u.NOMBRES, 
                u.APELLIDOS, 
                u.CORREO, 
                c.NOMBRE_CARRERA AS CARRERA, 
                u.CEDULA, 
                u.TELEFONO, 
                u.DIRECCION, 
                i.SECUENCIAL AS NUMERO_INSCRIPCION
            FROM inscripcion i
            INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
            LEFT JOIN usuario_carrera uc ON uc.SECUENCIALUSUARIO = u.SECUENCIAL
            LEFT JOIN carrera c ON c.SECUENCIAL = uc.SECUENCIALCARRERA
            WHERE i.SECUENCIAL = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getDatosEvento($idEvento) {
        $sql = "SELECT e.TITULO, e.FECHAINICIO, e.HORAS, e.COSTO, me.NOMBRE AS MODALIDAD, e.SECUENCIAL, e.DESCRIPCION
                FROM evento e
                LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
                WHERE e.SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function getDatosPago($idInscripcion) {
    $sql = "SELECT 
                f.NOMBRE AS FORMA_PAGO,
                p.COMPROBANTE_URL AS COMPROBANTE,
                p.FECHA_PAGO
            FROM pago p
            LEFT JOIN forma_pago f ON f.CODIGO = p.CODIGOFORMADEPAGO
            WHERE p.SECUENCIALINSCRIPCION = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getFacturaCompleta($idInscripcion) {
        // Verificar que la inscripción esté aceptada
        $stmtEstado = $this->pdo->prepare("SELECT CODIGOESTADOINSCRIPCION FROM inscripcion WHERE SECUENCIAL = ?");
        $stmtEstado->execute([$idInscripcion]);
        $estado = $stmtEstado->fetchColumn();
        if ($estado !== 'ACE') {
            return null; // Solo se genera factura si la inscripción está aceptada
        }

        // Obtener datos de participante
        $participante = $this->getDatosParticipante($idInscripcion);
        if (!$participante) return null;

        // Obtener datos de evento
        $sqlEvento = "SELECT SECUENCIALEVENTO FROM inscripcion WHERE SECUENCIAL = ?";
        $stmtEvento = $this->pdo->prepare($sqlEvento);
        $stmtEvento->execute([$idInscripcion]);
        $idEvento = $stmtEvento->fetchColumn();
        $evento = $this->getDatosEvento($idEvento);

        // Obtener datos de pago
        $pago = $this->getDatosPago($idInscripcion);

        // Datos adicionales
        $fecha_emision = date('Y-m-d');
        $numero_factura = '00000123'; // Puedes generar este número dinámicamente

        return [
            'participante' => $participante,
            'evento' => $evento,
            'pago' => $pago,
            'fecha_emision' => $fecha_emision,
            'numero_factura' => $numero_factura
        ];
    }
}
