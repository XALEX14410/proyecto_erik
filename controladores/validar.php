<?php
session_start();

// Habilitar visualización de errores (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir archivos necesarios
include_once('../modelos/basededatos.php');
include_once('../modelos/consulta_observador.php');

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo "<p style='color: red; text-align: center;'>Acceso denegado. Inicia sesión.</p>";
    exit;
}

try {
    // Conectar a la base de datos
    $bd = new BaseDatos();
    $conexion = $bd->getBD();

    if (!$conexion) {
        throw new Exception("Error al conectar con la base de datos");
    }

    // Obtener información del usuario
    $consulta = new ConsultaObservador();
    $usuario_actual = $consulta->obtener_usuario_por_control($_SESSION['usuario']);

    if (!$usuario_actual) {
        throw new Exception("Usuario no encontrado. Contacta al administrador.");
    }

    // Mostrar información del usuario
    echo "<h2 style='text-align: center;'>Bienvenido, {$usuario_actual['Nombre']} {$usuario_actual['Apellido']}</h2>";
    echo "<p style='text-align: center;'>Perfil: {$usuario_actual['idPerfil']}</p>";
    echo "<a href='/coordinadores_y_testigos/controladores/cerrar_sesion.php' style='display: block; text-align: center; color: red;'>Cerrar Sesión</a>";

} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "<p style='color: red; text-align: center;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    error_log("Error en página de usuario: " . $e->getMessage());
}
?>