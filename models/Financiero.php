<?php
require_once '../core/Conexion.php'; // Incluir la clase de conexión

class Financiero {
    private $conn;

    public function __construct() {
        // Usar la clase Conexion para obtener la conexión a la base de datos
        $this->conn = Conexion::getConexion();
    }

    public function obtenerEventos() {
        // Obtiene la lista de eventos disponibles para seleccionar
        $stmt = $this->conn->prepare("SELECT SECUENCIAL, TITULO FROM evento ORDER BY TITULO ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerTituloEvento($idEvento) {
        // Obtiene el título de un evento por su ID
        $stmt = $this->conn->prepare("SELECT TITULO FROM evento WHERE SECUENCIAL = :idEvento");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['TITULO'] : null;
    }

    public function obtenerReporteFinanciero($idEvento) {
        $reporte = [
            'montos' => [],
            'pendientes' => [],
            'comprobantes' => []
        ];

        // 1. Recaudación por Forma de Pago (solo pagos validados)
        $stmtMontos = $this->conn->prepare("
            SELECT
                fp.NOMBRE AS FORMA_PAGO,
                SUM(p.MONTO) AS TOTAL_RECAUDADO
            FROM
                pago p
            JOIN
                inscripcion i ON p.SECUENCIALINSCRIPCION = i.SECUENCIAL
            JOIN
                forma_pago fp ON p.CODIGOFORMADEPAGO = fp.CODIGO
            JOIN
                estado_pago ep ON p.CODIGOESTADOPAGO = ep.CODIGO
            WHERE
                i.SECUENCIALEVENTO = :idEvento
                AND ep.CODIGO = 'VAL' -- Solo pagos validados/aprobados
            GROUP BY
                fp.NOMBRE
            ORDER BY
                fp.NOMBRE
        ");
        $stmtMontos->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmtMontos->execute();
        $reporte['montos'] = $stmtMontos->fetchAll();

        // 2. Pagos Pendientes (pagos que no han sido validados)
        $stmtPendientes = $this->conn->prepare("
            SELECT
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                fp.NOMBRE AS FORMA_PAGO,
                p.MONTO,
                ep.NOMBRE AS ESTADO,
                p.FECHA_PAGO
            FROM
                pago p
            JOIN
                inscripcion i ON p.SECUENCIALINSCRIPCION = i.SECUENCIAL
            JOIN
                usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
            JOIN
                forma_pago fp ON p.CODIGOFORMADEPAGO = fp.CODIGO
            JOIN
                estado_pago ep ON p.CODIGOESTADOPAGO = ep.CODIGO
            WHERE
                i.SECUENCIALEVENTO = :idEvento
                AND ep.CODIGO != 'VAL' -- Excluir pagos validados
            ORDER BY
                p.FECHA_PAGO DESC, u.APELLIDOS, u.NOMBRES
        ");
        $stmtPendientes->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmtPendientes->execute();
        $pendientes = $stmtPendientes->fetchAll();

        foreach ($pendientes as $p) {
            $p['NOMBRE_COMPLETO'] = $p['NOMBRES'] . ' ' . $p['APELLIDOS'];
            unset($p['NOMBRES'], $p['APELLIDOS']);
            $p['FECHA_PAGO'] = $p['FECHA_PAGO'] ? new DateTime($p['FECHA_PAGO']) : null;
            $reporte['pendientes'][] = $p;
        }

        // 3. Comprobantes Subidos (cualquier pago con URL de comprobante)
        $stmtComprobantes = $this->conn->prepare("
            SELECT
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                p.MONTO,
                p.COMPROBANTE_URL,
                ep.NOMBRE AS ESTADO
            FROM
                pago p
            JOIN
                inscripcion i ON p.SECUENCIALINSCRIPCION = i.SECUENCIAL
            JOIN
                usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
            JOIN
                estado_pago ep ON p.CODIGOESTADOPAGO = ep.CODIGO
            WHERE
                i.SECUENCIALEVENTO = :idEvento
                AND p.COMPROBANTE_URL IS NOT NULL AND p.COMPROBANTE_URL != ''
            ORDER BY
                ep.NOMBRE, u.APELLIDOS, u.NOMBRES
        ");
        $stmtComprobantes->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmtComprobantes->execute();
        $comprobantes = $stmtComprobantes->fetchAll();

        foreach ($comprobantes as $c) {
            $c['NOMBRE_COMPLETO'] = $c['NOMBRES'] . ' ' . $c['APELLIDOS'];
            unset($c['NOMBRES'], $c['APELLIDOS']);
            $reporte['comprobantes'][] = $c;
        }

        return $reporte;
    }
}