<?php
include("../conexion.php");

if (!isset($_GET['id'])) {
    echo "ID de evento no especificado.";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM EVENTO WHERE SECUENCIAL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$evento = $result->fetch_assoc();

if (!$evento) {
    echo "Evento no encontrado.";
    exit;
}
?>

<?php include("../partials/head_Admin.php"); ?>
<div id="page-wrapper">
    <div id="page-inner">
        <h2 style="color: red;">Editar Evento</h2>
        <hr />

        <form method="POST" action="actualizar_evento.php">
            <input type="hidden" name="SECUENCIAL" value="<?= $evento['SECUENCIAL'] ?>">

            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" name="TITULO" value="<?= $evento['TITULO'] ?>" required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="DESCRIPCION"><?= $evento['DESCRIPCION'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Tipo de Evento</label>
                <select class="form-control" name="CODIGOTIPOEVENTO">
                    <?php
                    $tipos = $conn->query("SELECT * FROM TIPO_EVENTO");
                    while ($row = $tipos->fetch_assoc()) {
                        $selected = ($row['id_tipo_evento'] == $evento['CODIGOTIPOEVENTO']) ? 'selected' : '';
                        echo "<option value='{$row['id_tipo_evento']}' $selected>{$row['nombre_tipo']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <select class="form-control" name="SECUENCIALCATEGORIA">
                    <?php
                    $categorias = $conn->query("SELECT * FROM CATEGORIA_EVENTO");
                    while ($row = $categorias->fetch_assoc()) {
                        $selected = ($row['id_categoria_evento'] == $evento['SECUENCIALCATEGORIA']) ? 'selected' : '';
                        echo "<option value='{$row['id_categoria_evento']}' $selected>{$row['nombre_categoria']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Modalidad</label>
                <select class="form-control" name="CODIGOMODALIDAD">
                    <?php
                    $modalidades = $conn->query("SELECT * FROM MODALIDAD_EVENTO");
                    while ($row = $modalidades->fetch_assoc()) {
                        $selected = ($row['id_modalidad'] == $evento['CODIGOMODALIDAD']) ? 'selected' : '';
                        echo "<option value='{$row['id_modalidad']}' $selected>{$row['nombre_modalidad']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="FECHAINICIO" value="<?= $evento['FECHAINICIO'] ?>" required>
            </div>

            <div class="form-group">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="FECHAFIN" value="<?= $evento['FECHAFIN'] ?>" required>
            </div>

            <div class="form-group">
                <label>Horas</label>
                <input type="number" class="form-control" name="HORAS" value="<?= $evento['HORAS'] ?>">
            </div>

            <div class="form-group">
                <label>Nota de Aprobación</label>
                <input type="number" class="form-control" name="NOTAAPROBACION" value="<?= $evento['NOTAAPROBACION'] ?>">
            </div>

            <div class="form-group">
                <label>¿Es de pago?</label>
                <select class="form-control" name="ES_PAGADO">
                    <option value="0" <?= $evento['ES_PAGADO'] == 0 ? 'selected' : '' ?>>No</option>
                    <option value="1" <?= $evento['ES_PAGADO'] == 1 ? 'selected' : '' ?>>Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label>Costo</label>
                <input type="number" class="form-control" name="COSTO" value="<?= $evento['COSTO'] ?>">
            </div>

            <div class="form-group">
                <label>Carrera Asociada</label>
                <select class="form-control" name="SECUENCIALCARRERA">
                    <?php
                    $carreras = $conn->query("SELECT * FROM CARRERA");
                    while ($row = $carreras->fetch_assoc()) {
                        $selected = ($row['id_carrera'] == $evento['SECUENCIALCARRERA']) ? 'selected' : '';
                        echo "<option value='{$row['id_carrera']}' $selected>{$row['nombre_carrera']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>¿Solo internos?</label>
                <select class="form-control" name="ES_SOLO_INTERNOS">
                    <option value="0" <?= $evento['ES_SOLO_INTERNOS'] == 0 ? 'selected' : '' ?>>No</option>
                    <option value="1" <?= $evento['ES_SOLO_INTERNOS'] == 1 ? 'selected' : '' ?>>Sí</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Actualizar Evento
            </button>
            <a href="config_eventos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php include("../partials/footer_Admin.php"); ?>
