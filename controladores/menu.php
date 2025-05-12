<?php

class Menu {
    
    public function displayMenu($idPerfil) {
        // Solo mostrar menú completo si es superadmin (idPerfil = 1)
        if ($idPerfil == 1) {
            echo '
            <div class="file-grid">
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-people-fill file-icon"></i>
                        <a href="obtener_coordinadores.php">Coordinadores electorales</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Administración de coordinadores</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-eye-fill file-icon"></i>
                        <a href="obtener_testigos.php">Representantes de casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de testigos</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-table file-icon"></i>
                        <a href="obtener_mesas_votacion.php">Casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de mesas</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-vcard-fill file-icon"></i>
                        <a href="obtener_personas.php">Personas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Registro de personas</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-fill-gear file-icon"></i>
                        <a href="obtener_usuarios.php">Usuarios</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Administración de usuarios</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-calendar-check-fill file-icon"></i>
                        <a href="obtener_asistencias.php">Votacion</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de votación</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-exclamation-triangle-fill file-icon"></i>
                        <a href="obtener_alertas.php">Alertas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de alertas</span>
                    </div>
                </div>
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-calendar-event-fill file-icon"></i>
                        <a href="agenda.html">Agenda / Calendario</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de eventos y actividades</span>
                    </div>
                </div>
            </div>';

        } elseif ($idPerfil == 2) {
            // Solo mostrar menú completo si es administrador (idPerfil = 2)
       
            echo '
            <div class="file-grid">
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-people-fill file-icon"></i>
                        <a href="obtener_coordinadores.php">Coordinadores electorales</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Administración de coordinadores</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-eye-fill file-icon"></i>
                        <a href="obtener_testigos.php">Representantes de casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de testigos</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-table file-icon"></i>
                        <a href="obtener_mesas_votacion.php">Casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de mesas</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-vcard-fill file-icon"></i>
                        <a href="obtener_personas.php">Personas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Registro de personas</span>
                    </div>
                </div>
                

                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-calendar-check-fill file-icon"></i>
                        <a href="obtener_asistencias.php">Votacion</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de votación</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-exclamation-triangle-fill file-icon"></i>
                        <a href="obtener_alertas.php">Alertas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de alertas</span>
                    </div>
                </div>
            </div>'; 
        } 
        elseif ($idPerfil == 3) {
            // Solo mostrar menú completo si es coordinador (idPerfil = 3)
       
            echo '
            <div class="file-grid">

                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-eye-fill file-icon"></i>
                        <a href="obtener_testigos.php">Representantes de casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de testigos</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-table file-icon"></i>
                        <a href="obtener_mesas_votacion.php">Casillas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de mesas</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-vcard-fill file-icon"></i>
                        <a href="obtener_personas.php">Personas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Registro de personas</span>
                    </div>
                </div>
                
               
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-calendar-check-fill file-icon"></i>
                        <a href="obtener_asistencias.php">Votacion</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de votación</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-exclamation-triangle-fill file-icon"></i>
                        <a href="obtener_alertas.php">Alertas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de alertas</span>
                    </div>
                </div>
            </div>'; 
        }
        elseif ($idPerfil == 4) {
            // Solo mostrar menú completo si es representante de casilla (idPerfil = 4)
       
            echo '
            <div class="file-grid">

                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-vcard-fill file-icon"></i>
                        <a href="obtener_personas.php">Personas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Registro de personas</span>
                    </div>
                </div>
                
      
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-calendar-check-fill file-icon"></i>
                        <a href="obtener_asistencias.php">Votacion</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Control de votación</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-exclamation-triangle-fill file-icon"></i>
                        <a href="obtener_alertas.php">Alertas</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de alertas</span>
                    </div>
                </div>
            </div>'; 
        }  
        else {
            // Mensaje para otros perfiles (estructura preparada para futuras implementaciones)
            echo '<div class="alert alert-info" style="margin: 20px;">
                    <p>No hay opciones de menú disponibles para tu perfil actual.</p>
                    <p>Contacta al administrador si necesitas acceso a alguna función.</p>
                  </div>';
        }
    }
    
    // Método auxiliar para obtener el nombre del perfil y alias (puede ser útil después)
    private function getNombrePerfil($idPerfil) {
        // Suponiendo que ya tienes una conexión a la base de datos
        $conexion = $this->db; // Ajusta esto según tu clase (PDO o MySQLi)
    
        $query = "SELECT idPerfil, perfil, alias FROM login_perfiles";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
    
        $perfiles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $perfiles[$row['idPerfil']] = [
                'perfil' => $row['perfil'],
                'alias' => $row['alias']
            ];
        }
    
        return $perfiles[$idPerfil] ?? ['perfil' => 'Perfil Desconocido', 'alias' => 'Alias Desconocido'];
    }
}
?>