<?php
session_start();
require dirname(__FILE__) . '/modelos/basededatos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Limpiar y validar entradas
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    
    if (empty($usuario) || empty($password)) {
        $error = "Usuario y contraseña son requeridos";
    } else {
        // Crear instancia de tu clase BaseDatos
        $db = new BaseDatos();
        $conn = $db->getBD();
        
        if (isset($db->mensajes['BD_conexion'])) {
            die("Error de conexión: " . $db->mensajes['BD_conexion']);
        }

        $conn->set_charset("utf8mb4");

        // Actualizar consulta para la nueva tabla y columnas
        $stmt = $conn->prepare("SELECT Control, Nombre, Apellido, usuario, contrasena, idPerfil FROM Generales WHERE usuario = ?");
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['contrasena']) {
                $_SESSION['Control'] = $user['Control'];
                $_SESSION['Nombre'] = $user['Nombre'];
                $_SESSION['Apellido'] = $user['Apellido'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['idPerfil'] = $user['idPerfil'];
                $_SESSION['loggedin'] = true;

                header("Location: ./vistas/index.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado. Verifica tus datos.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
