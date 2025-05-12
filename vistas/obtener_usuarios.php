<?php
include_once('../controladores/validar.php'); // Incluir el archivo de validación de sesión
include_once('../controladores/validar.php'); // Incluir el archivo de validación de sesión
include_once('../modelos/basededatos.php');
include_once('../modelos/listas2.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentaciones</title>

    <!-- Librerías de iconos -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" 
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
            crossorigin="anonymous"></script>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <h1 style="text-align: center; color: #333;">Listado de Presentaciones</h1>
    
            <?php 
            if (isset($consulta_observador)) {
                echo $consulta_observador->obtener_usuarios(); 
            } else {
                echo "<p style='text-align: center; color: red;'>Error: No se pudo inicializar la consulta.</p>";
            }
            ?>

</body>
</html>