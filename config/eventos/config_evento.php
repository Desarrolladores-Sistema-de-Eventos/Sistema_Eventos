<?php include("partials/head_Admin.php"); ?>
<?php include("conexion.php"); ?>

<div id="page-wrapper">
    <div id="page-inner">
        <h2 style="color: red;">Configuración de Eventos</h2>
        <h5>Registrar y administrar eventos del sistema</h5>
        <hr />

        <!-- FORMULARIO DE REGISTRO -->
        <form method="POST" action="guardar_evento.php">
            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" name="TITULO" required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="DESCRIPCION" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Tipo de Evento</label>
                <select class="form-control" name="CODIGOTIPOEVENTO">
                    <?php
                    $tipos = $conn->query("SELECT * FROM TIPO_EVENTO");
                    while ($row = $tipos->fetch_assoc()) {
                        echo "<option value='{$row['id_tipo_evento']}'>{$row['nombre_tipo']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Categoría del Evento</label>
                <select class="form-control" name="SECUENCIALCATEGORIA">
                    <?php
                    $categorias = $conn->query("SELECT * FROM CATEGORIA_EVENTO");
                    while ($row = $categorias->fetch_assoc()) {
                        echo "<option value='{$row['id_categoria_evento']}'>{$row['nombre_categoria']}</option>";
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
                        echo "<option value='{$row['id_modalidad']}'>{$row['nombre_modalidad']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="FECHAINICIO" required>
            </div>

            <div class="form-group">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="FECHAFIN" required>
            </div>

            <div class="form-group">
                <label>Horas</label>
                <input type="number" class="form-control" name="HORAS">
            </div>

            <div class="form-group">
                <label>Nota de Aprobación</label>
                <input type="number" class="form-control" step="0.1" name="NOTAAPROBACION">
            </div>

            <div class="form-group">
                <label>¿Es de pago?</label>
                <select class="form-control" name="ES_PAGADO">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label>Costo (si aplica)</label>
                <input type="number" class="form-control" step="0.01" name="COSTO">
            </div>

            <div class="form-group">
                <label>Carrera Asociada</label>
                <select class="form-control" name="SECUENCIALCARRERA">
                    <?php
                    $carreras = $conn->query("SELECT * FROM CARRERA");
                    while ($row = $carreras->fetch_assoc()) {
                        echo "<option value='{$row['id_carrera']}'>{$row['nombre_carrera']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>¿Solo para internos?</label>
                <select class="form-control" name="ES_SOLO_INTERNOS">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Guardar Evento
            </button>
        </form>

        <hr>

        <!-- AQUÍ VA LA TABLA DE EVENTOS EXISTENTES -->
        <h4>Eventos Registrados</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Categoría</th>
                    <th>Modalidad</th>
                    <th>Fechas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT e.TITULO, e.FECHAINICIO, e.FECHAFIN,
                            t.nombre_tipo, c.nombre_categoria, m.nombre_modalidad
                        FROM EVENTO e
                        JOIN TIPO_EVENTO t ON e.CODIGOTIPOEVENTO = t.id_tipo_evento
                        JOIN CATEGORIA_EVENTO c ON e.SECUENCIALCATEGORIA = c.id_categoria_evento
                        JOIN MODALIDAD_EVENTO m ON e.CODIGOMODALIDAD = m.id_modalidad";
                $eventos = $conn->query($sql);
                while ($row = $eventos->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['TITULO']}</td>
                            <td>{$row['nombre_tipo']}</td>
                            <td>{$row['nombre_categoria']}</td>
                            <td>{$row['nombre_modalidad']}</td>
                            <td>{$row['FECHAINICIO']} - {$row['FECHAFIN']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm'>Editar</button>
                                <button class='btn btn-danger btn-sm'>Eliminar</button>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
