<?php

class Menu {
    
    public function displayMenu($idPerfil) {
        // Solo mostrar menú completo si es superadmin (idPerfil = 1)
        if ($idPerfil == 1) {
            echo '
            <div class="file-grid">
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-star-fill file-icon"></i>
                        <a href="obtener_calificaciones.php">Calificaciones</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de calificaciones</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-person-lines-fill file-icon"></i>
                        <a href="obtener_info_estudiantes.php">Info de estudiantes</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Información general de estudiantes</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-people-fill file-icon"></i>
                        <a href="obtener_login_perfiles.php">Perfiles</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Administración de perfiles</span>
                    </div>
                </div>
                
                <div class="file-card">
                    <div class="file-name">
                        <i class="bi bi-wallet-fill file-icon"></i>
                        <a href="obtener_saldos.php">Saldos</a>
                    </div>
                    <div class="file-details">
                        <span class="file-count">Gestión de saldos</span>
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