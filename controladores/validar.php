<?php
session_start();

include_once('../modelos/basededatos.php');
include_once('../modelos/listas2.php');

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    echo "<p style='color: red; text-align: center;'>Acceso denegado. Inicia sesión.</p>";
    exit;
}

// Conectar a la base de datos
$bd = new BaseDatos();
$conexion = $bd->getBD();

if (!$conexion) {
    echo "<p style='color: red; text-align: center;'>Error al conectar con la base de datos.</p>";
    exit;
}

// Obtener información del usuario
$consulta_observador = new listas2();
$usuario_actual = $consulta_observador->obtener_usuario_por_control($_SESSION['usuario']);

if (!$usuario_actual) {
    echo "<p style='color: red; text-align: center;'>Usuario no encontrado. Contacta al administrador.</p>";
    exit;
}

// Mostrar información del usuario
echo "<h2 style='text-align: center;'>Bienvenido, {$usuario_actual['Nombre']} {$usuario_actual['Apellido']}</h2>";
echo "<p style='text-align: center;'>Perfil: {$usuario_actual['idPerfil']}</p>";
echo "<a href='/coordinadores_y_testigos/controladores/cerrar_sesion.php' style='display: block; text-align: center; color: red;'>Cerrar Sesión</a>";
?>
