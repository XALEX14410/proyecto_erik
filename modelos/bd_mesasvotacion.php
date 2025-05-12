<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_mesasvotacion.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_mesasvotacion extends BaseDatos {
    // Agrega nueva mesa de votación
    public function agrega_mesa($datos_dbo_mesasvotacion) {
        $sql = "INSERT INTO `dbo_mesasvotacion`(`nombreMesa`, `idLugarVotacion`, `idCoordinador`) VALUES (
                    '".$datos_dbo_mesasvotacion->getNombreMesa()."',
                    '".$datos_dbo_mesasvotacion->getIdLugarVotacion()."',
                    '".$datos_dbo_mesasvotacion->getIdCoordinador()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de mesas de votación
    public function lista_mesas() {
        $lista_dbo_mesasvotacion = array(); // Inicializar la variable correctamente
        $sql = "SELECT `idMesaVotacion`, `nombreMesa`, `idLugarVotacion`, `idCoordinador` FROM `dbo_mesasvotacion` ORDER BY idMesaVotacion";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_mesasvotacion($renglon);
                $dato_tabla->setIdMesaVotacion($dato_tabla->getIdMesaVotacion());
                $dato_tabla->setNombreMesa($dato_tabla->getNombreMesa());
                $dato_tabla->setIdLugarVotacion($dato_tabla->getIdLugarVotacion());
                $dato_tabla->setIdCoordinador($dato_tabla->getIdCoordinador());
                $lista_dbo_mesasvotacion[$i] = $dato_tabla; // Almacena en el array
            }
        }
        $con->close();
        return $lista_dbo_mesasvotacion;
    }

    // Busco una mesa de votación por ID
    public function busca_mesa($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idMesaVotacion`, `nombreMesa`, `idLugarVotacion`, `idCoordinador` FROM `dbo_mesasvotacion` WHERE idMesaVotacion = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_mesasvotacion($renglon);
                    $dato_elemento->setIdMesaVotacion($dato_elemento->getIdMesaVotacion());
                    $dato_elemento->setNombreMesa($dato_elemento->getNombreMesa());
                    $dato_elemento->setIdLugarVotacion($dato_elemento->getIdLugarVotacion());
                    $dato_elemento->setIdCoordinador($dato_elemento->getIdCoordinador());
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            // Si no hay un ID válido, inicializamos un objeto vacío
            $dato_elemento = new dbo_mesasvotacion();
            $dato_elemento->setIdMesaVotacion(0);
            $dato_elemento->setNombreMesa("Sin nombre");
            $dato_elemento->setIdLugarVotacion(0);
            $dato_elemento->setIdCoordinador(0);
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_mesa($eldato) {
        $sql = "UPDATE `dbo_mesasvotacion` SET ".
                    "nombreMesa='".$eldato->getNombreMesa()."', ".
                    "idLugarVotacion='".$eldato->getIdLugarVotacion()."', ".
                    "idCoordinador='".$eldato->getIdCoordinador()."' ".
               "WHERE idMesaVotacion=".$eldato->getIdMesaVotacion();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino una mesa de votación
    public function elimina_mesa($id) {
        $sql = "DELETE FROM `dbo_mesasvotacion` WHERE idMesaVotacion = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
