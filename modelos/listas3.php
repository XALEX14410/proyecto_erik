<?php
// Métodos para obtener datos de las tablas solicitadas
include_once realpath(dirname(__FILE__) . "/../modelos/basededatos.php");
// Método para obtener todas las alertas
class consulta_calendario extends BaseDatos // Heredar de listas_select
{
    public function obtener_eventos()
    {
        $con = $this->getBD();
        $sql = "SELECT `evento_id`, `calendario_id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `ubicacion`, `es_recurrente`, `regla_recurrencia`, `es_todo_el_dia`, `estado`, `visibilidad`, `fecha_creacion`, `fecha_actualizacion` FROM `eventos` WHERE 1";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead><tr>
                    <th>ID Evento</th>
                    <th>ID Calendario</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Ubicación</th>
                    <th>Es Recurrente</th>
                    <th>Regla Recurrencia</th>
                    <th>Es Todo el Día</th>
                    <th>Estado</th>
                    <th>Visibilidad</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                    <th>Acción</th>
                  </tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['evento_id'])."</td>";
                echo "<td>".htmlspecialchars($row['calendario_id'])."</td>";
                echo "<td>".htmlspecialchars($row['titulo'])."</td>";
                echo "<td>".htmlspecialchars($row['descripcion'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_inicio'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_fin'])."</td>";
                echo "<td>".htmlspecialchars($row['ubicacion'])."</td>";
                echo "<td>".htmlspecialchars($row['es_recurrente'])."</td>";
                echo "<td>".htmlspecialchars($row['regla_recurrencia'])."</td>";
                echo "<td>".htmlspecialchars($row['es_todo_el_dia'])."</td>";
                echo "<td>".htmlspecialchars($row['estado'])."</td>";
                echo "<td>".htmlspecialchars($row['visibilidad'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_creacion'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_actualizacion'])."</td>";
                echo "<td><a href='editar_evento.php?id=".urlencode($row['evento_id'])."'>Editar</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron eventos.</p>";
        }
    }
    public function obtener_tareas()
    {
        $con = $this->getBD();
        $sql = "SELECT `tarea_id`, `idUsuario`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento`, `prioridad`, `estado`, `porcentaje_completado`, `evento_id` FROM `tareas` WHERE 1";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead><tr>
                    <th>ID Tarea</th>
                    <th>ID Usuario</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Vencimiento</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Porcentaje Completado</th>
                    <th>ID Evento</th>
                    <th>Acción</th>
                </tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['tarea_id'])."</td>";
                echo "<td>".htmlspecialchars($row['idUsuario'])."</td>";
                echo "<td>".htmlspecialchars($row['titulo'])."</td>";
                echo "<td>".htmlspecialchars($row['descripcion'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_creacion'])."</td>";
                echo "<td>".htmlspecialchars($row['fecha_vencimiento'])."</td>";
                echo "<td>".htmlspecialchars($row['prioridad'])."</td>";
                echo "<td>".htmlspecialchars($row['estado'])."</td>";
                echo "<td>".htmlspecialchars($row['porcentaje_completado'])."</td>";
                echo "<td>".htmlspecialchars($row['evento_id'])."</td>";
                echo "<td><a href='editar_tarea.php?id=".urlencode($row['tarea_id'])."'>Editar</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron tareas.</p>";
        }
    }
    public function obtener_eventos_ajax()
    {
        $con = $this->getBD();
        $sql = "SELECT `evento_id`, `calendario_id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `ubicacion`, `es_recurrente`, `regla_recurrencia`, `es_todo_el_dia`, `estado`, `visibilidad`, `fecha_creacion`, `fecha_actualizacion` FROM `eventos` WHERE 1";
        $result = $con->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo "<div class='evento'>";
            foreach ($row as $key => $value) {
                echo "<p id='{$key}' style='display: none;'>" . htmlspecialchars($value) . "</p>";
            }
            echo "</div>";
            }
        } else {
            echo "<p>No se encontraron eventos.</p>";
        }
    }

    public function obtener_tareas_ajax()
    {
        $con = $this->getBD();
        $sql = "SELECT `tarea_id`, `idUsuario`, `titulo`, `descripcion`, `fecha_creacion`, `fecha_vencimiento`, `prioridad`, `estado`, `porcentaje_completado`, `evento_id` FROM `tareas` WHERE 1";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo "<div class='tarea'>";
            foreach ($row as $key => $value) {
                echo "<p id='{$key}' style='display: none;'>" . htmlspecialchars($value) . "</p>";
            }
            echo "</div>";
            }
        } else {
            echo "<p>No se encontraron tareas.</p>";
        }
    }

}
