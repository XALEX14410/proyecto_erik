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

        // Quitar BINARY para evitar comparación sensible a mayúsculas/minúsculas si no lo necesitas
        $stmt = $conn->prepare("SELECT idUsuario, nombre, primApellido, usuario, password, idPerfil, estatus FROM dbo_usuarios WHERE usuario = ?");
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

            if ($password === $user['password']) {
                if ($user['estatus'] == 1) {
                    $_SESSION['idUsuario'] = $user['idUsuario'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['apellido'] = $user['primApellido'];
                    $_SESSION['usuario'] = $user['usuario'];
                    $_SESSION['idPerfil'] = $user['idPerfil'];
                    $_SESSION['loggedin'] = true;

                    header("Location: ./vistas/index.php");
                    exit;
                } else {
                    $error = "Tu cuenta está desactivada. Contacta al administrador.";
                }
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


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .login-container { max-width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 25px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box;
            font-size: 16px;
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background-color: #28a745; 
            border: none; 
            color: white; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        button:hover { background-color: #218838; }
        .error { 
            color: #dc3545; 
            text-align: center; 
            margin-bottom: 20px; 
            padding: 10px;
            background-color: #f8d7da;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
        }
        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }
        .forgot-password a {
            color: #6c757d;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .debug-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>" autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            </div>
            
            <button type="submit">Ingresar</button>
            
            <div class="forgot-password">
                <a href="recuperar-contrasena.php">¿Olvidaste tu contraseña?</a>
            </div>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($error)): ?>
            <div class="debug-info">
                <strong>Información para depuración:</strong><br>
                Usuario ingresado: <?php echo htmlspecialchars($usuario); ?><br>
                Asegúrate de que este valor exista exactamente en la base de datos (campo `usuario`).
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
