<?php
// Métodos para obtener datos de las tablas solicitadas
include_once realpath(dirname(__FILE__) . "/../modelos/basededatos.php");
// Método para obtener todas las alertas
class consulta_observador extends BaseDatos // Heredar de listas_select
{
public function obtener_usuario_por_control($control)
{
    $query = "SELECT * FROM General WHERE Control = ?";
    $stmt = $this->getBD()->prepare($query);
    $stmt->bind_param("s", $control);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}
}