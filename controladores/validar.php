<?php
session_start();

include_once('../modelos/basededatos.php');
include_once('../modelos/listas2.php');

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario']) || !isset($_SESSION['idPerfil'])) {
    echo "<div style='text-align: center; margin-top: 20px;'>
            <p style='color: red; font-weight: bold;'>Acceso denegado.</p>
            <p style='color: #555;'>Por favor, inicia sesión para acceder al sistema.</p>
          </div>";
    exit;
}

// Obtener información del usuario actual
$consulta_observador = new consulta_observador();
$usuario_actual = $consulta_observador->obtener_usuario_por_id($_SESSION['idUsuario']);

// Función para mostrar información del usuario
function mostrar_info_usuario($usuario) {
    echo "<div style='width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;'>
            <h2 style='color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Información del Usuario</h2>
            <div style='display: flex; flex-wrap: wrap;'>
                <div style='flex: 1; min-width: 200px; margin: 10px;'>
                    <h3 style='color: #555;'>Datos Personales</h3>
                    <p><strong>Nombre:</strong> {$usuario['nombre']} {$usuario['primApellido']} {$usuario['segApellido']}</p>
                    
                </div>
                <div style='flex: 1; min-width: 200px; margin: 10px;'>
                    <h3 style='color: #555;'>Datos del Perfil</h3>
                    <p><strong>Perfil:</strong> {$usuario['perfil']} ({$usuario['alias']})</p>    
                    <p><strong>idPerfil:</strong> {$usuario['idPerfil']}</p>              
                </div>
            </div>";

    // Mostrar información adicional según el perfil
    switch ($usuario['idPerfil']) {
        case 1: // Super Administrador (SU)
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #e6f7ff; border-radius: 5px;'>
                <h3 style='color: #0066cc;'>Privilegios de Super Administrador (SU)</h3>
                <p>Tienes acceso completo al sistema, incluyendo la gestión de usuarios, perfiles, configuraciones y reportes globales.</p>
              </div>";
            break;
        case 2: // Administrador (ADM)
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #fff2e6; border-radius: 5px;'>
                <h3 style='color: #cc6600;'>Privilegios de Administrador (ADM)</h3>
                <p>Puedes gestionar usuarios, perfiles y configuraciones dentro de tu área asignada.</p>
              </div>";
            break;
        case 3: // Coordinador (COR)
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #e6ffe6; border-radius: 5px;'>
                <h3 style='color: #009933;'>Privilegios de Coordinador (COR)</h3>
                <p>Puedes gestionar testigos y visualizar reportes de tu área asignada.</p>
              </div>";
            break;
        case 4: // Testigo (TES)
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #f0fff0; border-radius: 5px;'>
                <h3 style='color: #33cc33;'>Privilegios de Testigo (TES)</h3>
                <p>Puedes registrar información en tu casilla asignada y ver tus reportes.</p>
              </div>";
            break;
        case 5: // Invitado (IVT)
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #ffe6e6; border-radius: 5px;'>
                <h3 style='color: #cc0000;'>Privilegios de Invitado (IVT)</h3>
                <p>Tu perfil tiene acceso restringido. Contacta al administrador si necesitas más permisos.</p>
              </div>";
            break;
        default:
            echo "<div style='margin-top: 20px; padding: 15px; background-color: #f8d7da; border-radius: 5px;'>
                <h3 style='color: #721c24;'>Privilegios No Definidos</h3>
                <p>Tu perfil no tiene privilegios asignados. Contacta al administrador para más información.</p>
              </div>";
    }

    echo "
    <a href='/coordinadores_y_testigos/controladores/cerrar_sesion.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color:rgb(255, 0, 0); color: white; text-decoration: none; border-radius: 5px;'>Cerrar Sesión</a>
    <a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Volver al Inicio</a>
    </div>
    ";
}

// Mostrar la información del usuario actual
if ($usuario_actual) {
    mostrar_info_usuario($usuario_actual);
    
    // // Si es administrador, mostrar también la lista de usuarios (como en tu ejemplo original)
    // if ($_SESSION['idPerfil'] == 1) {
    //     $resultado = $consulta_observador->obtener_usuarios_por_perfil(1);
        
    //     if (!empty($resultado)) {
    //         echo "<div style='width: 80%; margin: 30px auto;'>
    //                 <h2 style='text-align: center; color: #333;'>Usuarios Administradores</h2>
    //                 <table style='width: 100%; border-collapse: collapse;'>
    //                     <thead>
    //                         <tr style='background-color: #f2f2f2;'>
    //                             <th style='padding: 10px; border: 1px solid #ddd;'>ID</th>
    //                             <th style='padding: 10px; border: 1px solid #ddd;'>Nombre</th>
    //                             <th style='padding: 10px; border: 1px solid #ddd;'>Usuario</th>
    //                         </tr>
    //                     </thead>
    //                     <tbody>";
            
    //         foreach ($resultado as $usuario) {
    //             echo "<tr>
    //                     <td style='padding: 8px; border: 1px solid #ddd; text-align: center;'>{$usuario['idUsuario']}</td>
    //                     <td style='padding: 8px; border: 1px solid #ddd;'>{$usuario['nombre']} {$usuario['primApellido']} {$usuario['segApellido']}</td>
    //                     <td style='padding: 8px; border: 1px solid #ddd;'>{$usuario['usuario']}</td>
    //                   </tr>";
    //         }
            
    //         echo "</tbody>
    //               </table>
    //               </div>";
    //     }
    // }
} else {
    echo "<div style='text-align: center; margin-top: 20px;'>
            <p style='color: red; font-weight: bold;'>No se pudo obtener la información del usuario.</p>
            <p style='color: #555;'>Por favor, contacta al administrador del sistema.</p>
          </div>";
}


?>