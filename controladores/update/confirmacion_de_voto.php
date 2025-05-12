<?php
// Evitar que se muestren errores como HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Establecer el tipo de contenido como JSON primero
header('Content-Type: application/json');

// Incluir archivo de base de datos
$basededatos_path = realpath(dirname(__FILE__)."/../../modelos/basededatos.php");
if (!file_exists($basededatos_path)) {
    echo json_encode(['success' => false, 'message' => 'Archivo basededatos.php no encontrado']);
    exit();
}

include_once($basededatos_path);

try {
    // Verificar método HTTP
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Método no permitido", 405);
    }

    // Verificar datos POST
    if (!isset($_POST['idAsistencia']) || !isset($_POST['nuevoEstatus'])) {
        throw new Exception("Datos incompletos", 400);
    }

    // Validar ID
    $idAsistencia = filter_var($_POST['idAsistencia'], FILTER_VALIDATE_INT);
    if ($idAsistencia === false || $idAsistencia < 1) {
        throw new Exception("ID de asistencia inválido", 400);
    }

    // Validar nuevo estatus
    $nuevoEstatus = $_POST['nuevoEstatus'];
    if (!in_array($nuevoEstatus, ['Votó', 'Sin votar'])) {
        throw new Exception("Estatus no válido", 400);
    }

    // Crear instancia de BaseDatos
    $db = new BaseDatos();
    $conn = $db->getBd();
    
    if (!$conn) {
        throw new Exception("Error de conexión: " . ($db->mensajes['BD_conexion'] ?? 'Desconocido'), 500);
    }

    // Preparar consulta de actualización
    $sql = "UPDATE dbo_asistencia_personas SET estatusAsistencia = ? WHERE idAsistencia = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error al preparar consulta: " . $conn->error, 500);
    }
    
    $stmt->bind_param("si", $nuevoEstatus, $idAsistencia);
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar consulta: " . $stmt->error, 500);
    }
    
    // Verificar si se actualizó algún registro
    if ($stmt->affected_rows === 0) {
        throw new Exception("No se encontró el registro o no se realizaron cambios", 404);
    }
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Estatus actualizado correctamente',
        'nuevoEstatus' => $nuevoEstatus
    ]);

} catch (Exception $e) {
    // Respuesta de error
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    
} finally {
    // Cerrar conexiones
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>