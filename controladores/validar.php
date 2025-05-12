<?php
session_start();

// Configuración de errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclusión de archivos de modelo
require_once('../modelos/basededatos.php');
require_once('../modelos/listas2.php');

// Verificación de sesión activa
if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo '<div class="error-message">Acceso denegado. Por favor inicie sesión.</div>';
    exit;
}

try {
    // Conexión a base de datos
    $bd = new BaseDatos();
    $conexion = $bd->getBD();
    
    if (!$conexion) {
        throw new PDOException("No se pudo establecer conexión con la base de datos");
    }

    // Obtención de datos del usuario
    $consulta = new ConsultaObservador();
    $usuario_actual = $consulta->obtener_usuario_por_control($_SESSION['usuario']);
    
    if (!$usuario_actual) {
        throw new Exception("Usuario no registrado en el sistema. Contacte al administrador.");
    }

    // Presentación de la información
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel de Usuario</title>
        <style>
            body {
                font-family: "Segoe UI", Roboto, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 20px;
                color: #333;
            }
            .user-container {
                max-width: 800px;
                margin: 30px auto;
                padding: 30px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                text-align: center;
            }
            .user-greeting {
                color: #2c3e50;
                margin-bottom: 10px;
            }
            .user-profile {
                color: #7f8c8d;
                font-size: 1.1em;
                margin-bottom: 20px;
            }
            .logout-link {
                display: inline-block;
                padding: 8px 20px;
                background-color: #e74c3c;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s;
            }
            .logout-link:hover {
                background-color: #c0392b;
            }
            .error-message {
                color: #e74c3c;
                text-align: center;
                padding: 15px;
                margin: 20px auto;
                max-width: 500px;
                background: #fdecea;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <div class="user-container">
            <h1 class="user-greeting">Bienvenido, '.htmlspecialchars($usuario_actual['Nombre']).' '.htmlspecialchars($usuario_actual['Apellido']).'</h1>
            <p class="user-profile">Perfil: '.htmlspecialchars($usuario_actual['idPerfil']).'</p>
            <a href="/proyecto_erik/controladores/cerrar_sesion.php" class="logout-link">Cerrar Sesión</a>
        </div>
    </body>
    </html>';

} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo '<div class="error-message">Error de base de datos: '.htmlspecialchars($e->getMessage()).'</div>';
    error_log("Error en BD - Página de usuario: ".$e->getMessage());
    
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo '<div class="error-message">Error: '.htmlspecialchars($e->getMessage()).'</div>';
    error_log("Error general - Página de usuario: ".$e->getMessage());
}
?>