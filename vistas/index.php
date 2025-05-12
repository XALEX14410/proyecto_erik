<?php
session_start();



// include_once('../controladores/validar.php');
include_once('../controladores/menu.php');

// Verificación EXTRA segura
if (!isset($_SESSION['idPerfil']) || empty($_SESSION['idPerfil'])) {
    die('<div class="alert alert-danger">Error: Perfil de usuario no definido. Vuelve a iniciar sesión.</div>');
}

try {
    $menu = new Menu();
    
} catch (Error $e) {
    die('<div class="alert alert-danger">Error al cargar el menú: ' . $e->getMessage() . '</div>');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinadores y Testigos</title>
    <link rel="stylesheet" href="./css/panel.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">

        
    <?php $menu->displayMenu((int)$_SESSION['idPerfil']); ?>

        

    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>