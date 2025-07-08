
<?php
require_once '../core/Conexion.php';

class Estadisticas {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    // Total de usuarios activos
    public function totalUsuariosActivos() {
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE CODIGOESTADO = 'ACTIVO'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
        // Total de todos los eventos (sin importar estado)
    public function totalEventos() {
        $sql = "SELECT COUNT(*) as total FROM evento";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Total de usuarios inactivos
    public function totalUsuariosInactivos() {
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE CODIGOESTADO = 'INACTIVO'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Total de eventos disponibles
    public function totalEventosDisponibles() {
        $sql = "SELECT COUNT(*) as total FROM evento WHERE ESTADO = 'DISPONIBLE'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Total de eventos cancelados o cerrados
    public function totalEventosCanceladosCerrados() {
        $sql = "SELECT COUNT(*) as total FROM evento WHERE ESTADO IN ('CANCELADO', 'CERRADO')";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Inscripciones activas y completadas por evento (para gráfico de barras)
public function inscripcionesActivasCompletadasPorEvento() {
    $sql = "SELECT e.TITULO as y, 
                   COUNT(i.SECUENCIAL) as total
            FROM evento e
            LEFT JOIN inscripcion i 
                ON i.SECUENCIALEVENTO = e.SECUENCIAL
                AND i.CODIGOESTADOINSCRIPCION IN ('PEN','COM','ACE')
            GROUP BY e.TITULO";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Total de usuarios por tipo (docente, estudiante, invitado) para gráfico de pastel
    public function totalUsuariosPorTipo() {
        $sql = "SELECT CODIGOROL, COUNT(*) as total FROM usuario WHERE CODIGOROL IN ('DOC', 'EST', 'INV') GROUP BY CODIGOROL";
        $stmt = $this->pdo->query($sql);
        $tipos = [
            'EST' => 'Estudiantes',
            'DOC' => 'Docentes',
            'INV' => 'Invitados'
        ];
        $result = [
            'EST' => 0,
            'DOC' => 0,
            'INV' => 0
        ];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tipo = strtoupper($row['CODIGOROL']);
            if (isset($result[$tipo])) {
                $result[$tipo] = (int)$row['total'];
            }
        }
        // Devuelve en formato para Morris.js Donut
        $donut = [];
        foreach ($tipos as $key => $label) {
            $donut[] = ['label' => $label, 'value' => $result[$key]];
        }
        return $donut;
    }
}
?>