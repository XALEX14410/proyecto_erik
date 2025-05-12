<?php
// Métodos para obtener datos de las tablas solicitadas
include_once realpath(dirname(__FILE__) . "/../modelos/basededatos.php");

class ConsultaObservador extends BaseDatos
{
    public function obtener_usuario_por_control($control)
    {
        try {
            $conexion = $this->getBD();
            if (!$conexion) {
                throw new Exception("Error al conectar con la base de datos");
            }

            $query = "SELECT * FROM Generales WHERE usuario = ?";
            $stmt = $conexion->prepare($query);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }

            $stmt->bind_param("s", $control);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows === 0) {
                return null;
            }

            return $resultado->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error en ConsultaObservador: " . $e->getMessage());
            return null;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}
?>