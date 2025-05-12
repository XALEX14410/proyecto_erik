<?php
// Métodos para obtener datos de las tablas solicitadas
include_once realpath(dirname(__FILE__) . "/../modelos/basededatos.php");
// Método para obtener todas las alertas
class consulta_observador extends BaseDatos // Heredar de listas_select
{
public function obtener_usuario_por_control($control)
{
    try {
        $conexion = $this->getBD();
        if (!$conexion) {
            throw new Exception("Error al conectar con la base de datos");
        }

        $query = "SELECT * FROM General WHERE usuario = ?";
        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("s", $control);
        $stmt->execute();

        $resultado = $stmt->get_result();
        if (!$resultado) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        return $resultado->fetch_assoc();
    } catch (Exception $e) {
        $this->mensajes['consulta_error'] = $e->getMessage();
        return null;
    }
}
}
?>