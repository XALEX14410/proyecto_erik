<?php
// Métodos para obtener datos de las tablas solicitadas
include_once realpath(dirname(__FILE__) . "/../modelos/basededatos.php");
// Método para obtener todas las alertas
class consulta_observador extends BaseDatos // Heredar de listas_select
{
    public function obtener_alertas()
    {
        $con = $this->getBD();
        $sql = "SELECT idAlerta, titulo, mensaje, fechaHoraEnvio, idUsuarioEnvio, idMesaVotacion, idCoordinador, idPersona FROM dbo_alertas WHERE 1";
        $result = $con->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $output = "<table border='1'>";
            $output .= "<thead><tr>
                    <th>ID Alerta</th>
                    <th>Título</th>
                    <th>Mensaje</th>
                    <th>Fecha y Hora de Envío</th>
                    <th>ID Usuario Envío</th>
                    <th>ID Mesa Votación</th>
                    <th>ID Coordinador</th>
                    <th>ID Persona</th>
                    <th>Acción</th>
                  </tr></thead>";
            $output .= "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $output .= "<tr>";
                $output .= "<td>".htmlspecialchars($row['idAlerta'])."</td>";
                $output .= "<td>".htmlspecialchars($row['titulo'])."</td>";
                $output .= "<td>".htmlspecialchars($row['mensaje'])."</td>";
                $output .= "<td>".htmlspecialchars($row['fechaHoraEnvio'])."</td>";
                $output .= "<td>".htmlspecialchars($row['idUsuarioEnvio'])."</td>";
                $output .= "<td>".htmlspecialchars($row['idMesaVotacion'])."</td>";
                $output .= "<td>".htmlspecialchars($row['idCoordinador'])."</td>";
                $output .= "<td>".htmlspecialchars($row['idPersona'])."</td>";
                $output .= "<td><a href='editar_alerta.php?id=".urlencode($row['idAlerta'])."'>Editar</a></td>";
                $output .= "</tr>";
            }
            $output .= "</tbody></table>";
            echo $output;
        } else {
            echo "<p>No se encontraron alertas.</p>";
        }
    }

// Método para obtener todas las asistencias
public function obtener_asistencias()
{
    $idPerfilSesion = $_SESSION['idPerfil'] ?? null;
    $idUsuarioSesion = $_SESSION['idUsuario'] ?? null;
    
    if ($idPerfilSesion !== null) {
        $con = $this->getBD();
        
        switch ($idPerfilSesion) {
            case 1:
            case 2: // Administrador, puede ver todas las asistencias
                $sql = "SELECT idAsistencia, idPersona, idMesaVotacion, fechaHoraRegistro, estatusAsistencia, observaciones 
                        FROM dbo_asistencia_personas 
                        WHERE 1";
                break;

            case 3: // Coordinador, puede ver asistencias de sus mesas de votación
                // Obtener el idCoordinador del usuario en sesión
                $stmt = $con->prepare("SELECT idCoordinador FROM dbo_usuarios WHERE idUsuario = ?");
                $stmt->bind_param("i", $idUsuarioSesion);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $idCoordinador = $row['idCoordinador'] ?? null;
                $stmt->close();
            
                if ($idCoordinador !== null) {
                    // Obtener las mesas de votación asignadas al coordinador
                    $stmt = $con->prepare("SELECT idMesaVotacion FROM dbo_mesasvotacion WHERE idCoordinador = ?");
                    $stmt->bind_param("i", $idCoordinador);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $mesasVotacion = [];
                    while ($row = $result->fetch_assoc()) {
                        $mesasVotacion[] = $row['idMesaVotacion'];
                    }
                    $stmt->close();
            
                    if (!empty($mesasVotacion)) {
                        $mesasVotacionList = implode(',', $mesasVotacion);
                        $sql = "SELECT idAsistencia, idPersona, idMesaVotacion, fechaHoraRegistro, estatusAsistencia, observaciones 
                                FROM dbo_asistencia_personas 
                                WHERE idMesaVotacion IN ($mesasVotacionList)";
                    } else {
                        echo "<p>No se encontraron mesas de votación asignadas a este coordinador.</p>";
                        return;
                    }
                } else {
                    echo "<p>No se encontró un idCoordinador asociado al usuario en sesión.</p>";
                    return;
                }
                break;
            
            case 4: // Testigo, puede ver solo las asistencias de su mesa de votación
                $stmt = $con->prepare("SELECT idMesaVotacion FROM dbo_testigos WHERE idPersona = ?");
                $stmt->bind_param("i", $idUsuarioSesion);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $idMesaVotacion = $row['idMesaVotacion'] ?? null;
                $stmt->close();

                if ($idMesaVotacion !== null) {
                    $sql = "SELECT idAsistencia, idPersona, idMesaVotacion, fechaHoraRegistro, estatusAsistencia, observaciones 
                            FROM dbo_asistencia_personas 
                            WHERE idMesaVotacion = $idMesaVotacion";
                } else {
                    echo "<p>No se encontraron resultados para su mesa de votación.</p>";
                    return;
                }
                break;

            default: // Otros perfiles no tienen acceso
                echo "<p>No tiene permisos para ver esta información.</p>";
                return;
        }

        // Ejecutar la consulta y mostrar los resultados
        $result = $con->query($sql);
        
        if ($result && $result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead><tr>
                    <th>ID Asistencia</th>
                    <th>ID Persona</th>
                    <th>ID Mesa Votación</th>
                    <th>Fecha y Hora de Registro</th>
                    <th>Estatus</th>
                    <th>Observaciones</th>
                    <th>Acción</th>
                  </tr></thead>";
            echo "<tbody>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['idAsistencia'])."</td>";
                echo "<td>".htmlspecialchars($row['idPersona'])."</td>";
                echo "<td>".htmlspecialchars($row['idMesaVotacion'])."</td>";
                echo "<td>".htmlspecialchars($row['fechaHoraRegistro'])."</td>";
                echo "<td><button id='btnEstatusAsistencia-".$row['idAsistencia']."' 
                        class='btn-estatus ".($row['estatusAsistencia'] == 'Votó' ? 'btn-activo' : 'btn-inactivo')."'
                        data-id='".$row['idAsistencia']."'
                        data-estado='".$row['estatusAsistencia']."'>";
                echo htmlspecialchars($row['estatusAsistencia'] == 'Votó' ? 'Votó' : 'Sin votar');
                echo "</button></td>";
                echo "<td>".htmlspecialchars($row['observaciones'])."</td>";
                echo "<td><a href='editar_asistencia.php?id=".urlencode($row['idAsistencia'])."'>Editar</a></td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
}

// Método para obtener todos los coordinadores con idPersona y username si es perfil coordinador
public function obtener_coordinadores()
{
    $idPerfilSesion = $_SESSION['idPerfil'] ?? null;
    
    if ($idPerfilSesion !== null) {
        switch ($idPerfilSesion) {
            case 1: // Perfil 1 (ej. Superadmin)
            case 2: // Perfil 2 (ej. Administrador)
                $sql = "SELECT 
                        c.idCoordinador,
                        c.idPersona,
                        CASE 
                            WHEN u.idPerfil = 3 THEN u.usuario
                            ELSE 'Sin asignar'
                        END AS usuario
                    FROM dbo_coordinadores c
                    LEFT JOIN dbo_usuarios u ON c.idPersona = u.idPersona";
                break;
    
            default:
                echo "<p>No tiene permisos para ver esta información.</p>";
                return;
        }
    } else {
        echo "<p>No se encontró información de perfil en la sesión.</p>";
        return;
    }
    
    if (!empty($sql)) {
        $con = $this->getBD();
        $result = $con->query($sql);
        
        if ($result && $result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead><tr>
                    <th>ID Coordinador</th>
                    <th>ID Persona</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                  </tr></thead>";
            echo "<tbody>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['idCoordinador'])."</td>";
                echo "<td>".htmlspecialchars($row['idPersona'])."</td>";
                echo "<td>".htmlspecialchars($row['usuario'])."</td>";
                echo "<td><a href='editar_coordinador.php?id=".urlencode($row['idCoordinador'])."'>Editar</a></td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron coordinadores registrados.</p>";
        }
    }
}

// Método para obtener todas las mesas de votación
public function obtener_mesas_votacion($idCoordinador)
{
    $idPerfilSesion = $_SESSION['idPerfil'] ?? null;
    
    if ($idPerfilSesion === null) {
        echo "<p>No se encontró información de perfil en la sesión.</p>";
        return;
    }

    $con = $this->getBD();
    $sql = "";
    
    switch ($idPerfilSesion) {
        case 1: // Super Administrador
        case 2: // Administrador
            $sql = "SELECT idMesaVotacion, nombreMesa, idLugarVotacion, idCoordinador 
                    FROM dbo_mesasvotacion where 1";
            break;

        case 3: // Coordinador
            // Usar parámetros preparados para seguridad
            $sql = "SELECT idMesaVotacion, nombreMesa, idLugarVotacion, idCoordinador 
                    FROM dbo_mesasvotacion 
                    WHERE idCoordinador = ?";
            break;

        default:
            echo "<p>No tiene permisos para ver esta información.</p>";
            return;
    }

    if (empty($sql)) {
        echo "<p>No se pudo generar la consulta.</p>";
        return;
    }

    // Ejecutar consulta según el tipo de perfil
    if ($idPerfilSesion == 3) {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idCoordinador);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $con->query($sql);
    }

    if ($result && $result->num_rows > 0) {
        
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID Mesa Votación</th>";
        echo "<th>Nombre Mesa</th>";
        echo "<th>ID Lugar Votación</th>";
        echo "<th>ID Coordinador</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".htmlspecialchars($row['idMesaVotacion'])."</td>";
            echo "<td>".htmlspecialchars($row['nombreMesa'])."</td>";
            echo "<td>".htmlspecialchars($row['idLugarVotacion'])."</td>";
            echo "<td>".htmlspecialchars($row['idCoordinador'])."</td>";
            echo "<td>";
            echo "<a href='editar_mesa_votacion.php?id=".urlencode($row['idMesaVotacion'])."' >Editar</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
       
    } else {
        echo "<div class='alert alert-info'>No se encontraron mesas de votación registradas.</div>";
    }

    // Cerrar statement si existe
    if (isset($stmt)) {
        $stmt->close();
    }
}


// Método para obtener todas las personas
public function obtener_personas()
{
    $con = $this->getBD();
    $sql = "SELECT idPersona, nombre, primApellido, segApellido, curp, claveElector, telefonoCelular, 
                   telefonoCasa, correo, fecNacimiento, calle, noExterior, noInterior, codigoPostal, 
                   idEstado, idMunicipio, idColonia, idPersonaTipoSangre, idPersonaOcupacion, 
                   idPersonaGradoAcademico, idPersonaPoblacion, idPersonaEstadoApoyo, idLugarVotacion, 
                   idMesaVotacion, disponibilidad, observaciones, id_distrito_federal, id_distrito_local, 
                   idPersonaGenero, estatus 
            FROM dbo_personas 
            WHERE 1";

    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<div class="table-responsive" style="overflow-x: auto;">';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Apellidos</th>';
        echo '<th>CURP</th>';
        echo '<th>Contacto</th>';
        echo '<th>Dirección</th>';
        echo '<th>Detalles</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.htmlspecialchars($row['idPersona']).'</td>';
            
            // Columna Nombre
            echo '<td>'.htmlspecialchars($row['nombre']).'</td>';
            
            // Columna Apellidos
            echo '<td>'.htmlspecialchars($row['primApellido'].' '.$row['segApellido']).'</td>';
            
            // Columna CURP/Clave Elector
            echo '<td>';
            echo '<strong>CURP:</strong> '.htmlspecialchars($row['curp']).'<br>';
            echo '<strong>Clave:</strong> '.htmlspecialchars($row['claveElector']);
            echo '</td>';
            
            // Columna Contacto
            echo '<td>';
            echo '<strong>Celular:</strong> '.htmlspecialchars($row['telefonoCelular']).'<br>';
            echo '<strong>Casa:</strong> '.htmlspecialchars($row['telefonoCasa']).'<br>';
            echo '<strong>Email:</strong> '.htmlspecialchars($row['correo']);
            echo '</td>';
            
            // Columna Dirección
            echo '<td>';
            echo htmlspecialchars($row['calle'].' '.$row['noExterior']);
            if (!empty($row['noInterior'])) {
                echo ' Int. '.htmlspecialchars($row['noInterior']);
            }
            echo '<br>';
            echo 'CP: '.htmlspecialchars($row['codigoPostal']);
            echo '</td>';
            
            // Columna Detalles
            echo '<td>';
            echo '<strong>Nacimiento:</strong> '.htmlspecialchars($row['fecNacimiento']).'<br>';
            echo '<strong>Género:</strong> '.htmlspecialchars($row['idPersonaGenero']).'<br>';
            echo '<strong>Estatus:</strong> '.htmlspecialchars($row['estatus']);
            echo '</td>';
            
            // Columna Acciones
            echo '<td>';
            echo '<a href="editar_persona.php?id='.urlencode($row['idPersona']).'" class="btn btn-sm btn-primary mb-1">Editar</a>';
            echo '<button class="btn btn-sm btn-info mb-1 btn-ver-detalles" data-id="'.htmlspecialchars($row['idPersona']).'">Detalles</button>';
            echo '</td>';
            
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        // Script para manejar el botón de detalles
        echo '<script>
        document.querySelectorAll(".btn-ver-detalles").forEach(btn => {
            btn.addEventListener("click", function() {
                const idPersona = this.getAttribute("data-id");
                // Aquí puedes implementar la lógica para mostrar más detalles
                alert("Mostrar detalles completos de persona ID: " + idPersona);
                // O podrías implementar un modal con AJAX
            });
        });
        </script>';
    } else {
        echo '<div class="alert alert-info">No se encontraron personas registradas.</div>';
    }
}
// Método para obtener todos los testigos con datos de usuario y coordinador
public function obtener_testigos()
{
    $con = $this->getBD();
    $sql = "SELECT 
                t.idTestigo,
                t.idPersona,
                t.idMesaVotacion,
                CASE 
                    WHEN t.idCoordinador IS NOT NULL THEN t.idCoordinador
                    ELSE 'Sin asignar'
                END AS idCoordinador,
                CASE 
                    WHEN u.idPerfil = 4 THEN u.usuario
                    ELSE 'Sin asignar'
                END AS usuario_testigo,
                p.nombre,
                p.primApellido,
                p.segApellido,
                m.nombreMesa
            FROM dbo_testigos t
            LEFT JOIN dbo_usuarios u ON t.idPersona = u.idPersona
            LEFT JOIN dbo_personas p ON t.idPersona = p.idPersona
            LEFT JOIN dbo_mesasvotacion m ON t.idMesaVotacion = m.idMesaVotacion";
    
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        
        echo '<table border="1" >';
        echo '<thead >';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Testigo</th>';
        echo '<th>Mesa de Votación</th>';
        echo '<th>Coordinador</th>';
        echo '<th>Usuario</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.htmlspecialchars($row['idTestigo']).'</td>';
            
            // Columna Testigo
            echo '<td>';
            echo '<strong>'.htmlspecialchars($row['nombre'].' '.htmlspecialchars($row['primApellido'])).'</strong>';
            if (!empty($row['segApellido'])) {
                echo ' '.htmlspecialchars($row['segApellido']);
            }
            echo '<br><small>ID Persona: '.htmlspecialchars($row['idPersona']).'</small>';
            echo '</td>';
            
            // Columna Mesa de Votación
            echo '<td>';
            if (!empty($row['nombreMesa'])) {
                echo htmlspecialchars($row['nombreMesa']);
            } else {
                echo 'No asignada';
            }
            echo '<br><small>ID Mesa: '.htmlspecialchars($row['idMesaVotacion']).'</small>';
            echo '</td>';
            
            // Columna Coordinador
            echo '<td>'.htmlspecialchars($row['idCoordinador']).'</td>';
            
            // Columna Usuario
            echo '<td>'.htmlspecialchars($row['usuario_testigo']).'</td>';
            
            // Columna Acciones
            echo '<td>';
            echo '<a href="editar_testigo.php?id='.urlencode($row['idTestigo']).'" class="btn btn-sm btn-primary mr-2">Editar</a>';
            echo '<button class="btn btn-sm btn-info btn-detalles" data-id="'.htmlspecialchars($row['idTestigo']).'">Detalles</button>';
            echo '</td>';
            
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';


        // Script para manejar detalles
        echo '<script>
        document.querySelectorAll(".btn-detalles").forEach(btn => {
            btn.addEventListener("click", function() {
                const idTestigo = this.getAttribute("data-id");
                // Aquí puedes implementar AJAX para mostrar más detalles
                alert("Mostrando detalles completos del testigo ID: " + idTestigo);
                // O implementar un modal con: $("#modalDetalles").modal("show");
            });
        });
        </script>';
    } else {
        echo '<div class="alert alert-warning">No se encontraron testigos registrados.</div>';
    }
}

public function obtener_usuarios()
{
    $idPerfilSesion = $_SESSION['idPerfil'] ?? null;

    // Consulta SQL base
    $sql = "SELECT idUsuario, nombre, primApellido, segApellido, usuario, idPerfil, idPartido, idPersona, idCoordinador, idTestigo, estatus 
            FROM dbo_usuarios 
            WHERE 1";

    // Aplicar filtros según el perfil en sesión
    if ($idPerfilSesion !== null) {
        switch ($idPerfilSesion) {
            case 2: // Administrador
                $sql .= " AND idPerfil > 1";
                break;
            case 3: // Coordinador
                $sql .= " AND idPerfil > 2";
                break;
            case 4: // Testigo
                $sql .= " AND idPerfil > 3";
                break;
            case 5: // Perfil sin permisos
                echo "<p>No tiene permisos para ver esta información.</p>";
                return;
            default:
                // Perfil 1 (Superadmin) u otros no restringidos, sin filtro adicional
                break;
        }
    }

    // Ejecutar la consulta
    $con = $this->getBD();
    $result = $con->query($sql);

    // Verificar si hay resultados
    if ($result && $result->num_rows > 0) {
        // Crear la tabla HTML
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID Usuario</th>';
        echo '<th>Nombre</th>';
        echo '<th>Primer Apellido</th>';
        echo '<th>Segundo Apellido</th>';
        echo '<th>Usuario</th>';
        echo '<th>ID Perfil</th>';
        echo '<th>ID Partido</th>';
        echo '<th>ID Persona</th>';
        echo '<th>ID Coordinador</th>';
        echo '<th>ID Testigo</th>';
        echo '<th>Estatus</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Iterar sobre los resultados y mostrarlos en la tabla
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['idUsuario']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($row['primApellido']) . '</td>';
            echo '<td>' . htmlspecialchars($row['segApellido']) . '</td>';
            echo '<td>' . htmlspecialchars($row['usuario']) . '</td>';
            echo '<td>' . htmlspecialchars($row['idPerfil']) . '</td>';
            echo '<td>' . htmlspecialchars($row['idPartido']) . '</td>';
            echo '<td>' . htmlspecialchars($row['idPersona']) . '</td>';
            echo '<td>' . htmlspecialchars($row['idCoordinador']) . '</td>';
            echo '<td>' . htmlspecialchars($row['idTestigo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['estatus']) . '</td>';
            echo '<td><a href="editar_usuario.php?id=' . urlencode($row['idUsuario']) . '">Editar</a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No se encontraron resultados.</p>';
    }
}

private function generar_tabla($sql, $columnas, $url_editar, $id_campo)
{
    $con = $this->getBD();
    $resultado = $con->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        echo "<table class='tabla' border='1'><thead><tr class='tabla__fila1'>";
        // Mostrar encabezados
        foreach ($columnas as $columna) {
            echo "<th>" . htmlspecialchars($columna) . "</th>";
        }
        echo "<th>Acciones</th></tr></thead><tbody>";
        
        // Mostrar filas de datos
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            // Mostrar cada valor en la fila
            foreach ($fila as $clave => $valor) {
                // Solo mostrar las columnas que corresponden a los campos de la fila
                if ($clave !== $id_campo || in_array($clave, array_keys($fila))) {
                    echo "<td>" . htmlspecialchars($valor) . "</td>";
                }
            }
            echo "<td><a href='" . htmlspecialchars($url_editar) . "?id=" . urlencode($fila[$id_campo]) . "'>Editar</a></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
}
public function obtener_usuario_por_id($idUsuario)
{
    $sql = "SELECT 
                u.idUsuario, 
                u.nombre, 
                u.primApellido, 
                u.segApellido, 
                u.usuario, 
                u.password, 
                u.idPerfil, 
                lp.perfil, 
                lp.alias, 
                u.idPartido, 
                u.idPersona, 
                c.idCoordinador AS idCoordinador, 
                u.idTestigo, 
                u.estatus 
            FROM dbo_usuarios u 
            INNER JOIN dbo_login_perfiles lp ON u.idPerfil = lp.idPerfil 
            LEFT JOIN dbo_coordinadores c ON u.idPersona = c.idPersona 
            WHERE u.idUsuario = ?";
    $con = $this->getBD();
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    return $resultado->fetch_assoc();
}
public function obtener_usuarios_por_perfil($idPerfil)
{
    $sql = "SELECT 
                u.idUsuario, 
                u.nombre, 
                u.primApellido, 
                u.segApellido, 
                u.usuario, 
                u.password, 
                u.idPerfil, 
                lp.perfil AS perfil, 
                lp.alias AS alias, 
                u.idPartido, 
                u.idPersona, 
                c.idCoordinador AS idCoordinador, 
                u.idTestigo, 
                u.estatus 
            FROM dbo_usuarios u 
            INNER JOIN dbo_login_perfiles lp ON u.idPerfil = lp.idPerfil 
            LEFT JOIN dbo_coordinadores c ON u.idPersona = c.idPersona 
            WHERE u.idPerfil = ?";

    $con = $this->getBD();
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idPerfil);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuarios = [];
    
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila;
    }

    $stmt->close();
    return $usuarios;
}

}