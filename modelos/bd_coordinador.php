<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_coordinador.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_coordinador extends BaseDatos {
    // Agrega nuevo coordinador
    public function agrega_coordinador($datos_dbo_coordinador) {
        $sql = "INSERT INTO `dbo_coordinadores`(`idCoordinador`, `idPersona`) VALUES (
                    '".$datos_dbo_coordinador->getIdCoordinador()."',
                    '".$datos_dbo_coordinador->getIdPersona()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de coordinadores
    public function lista_coordinadores() {
        $lista_dbo_coordinador = array(); // Inicializar la variable correctamente
        $sql = "SELECT `idCoordinador`, `idPersona` FROM `dbo_coordinadores` WHERE 1";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_coordinador($renglon);
                $dato_tabla->setIdCoordinador($dato_tabla->getIdCoordinador());
                $dato_tabla->setIdPersona($dato_tabla->getIdPersona());
                $lista_dbo_coordinador[$i] = $dato_tabla; // Almacena en el array
            }
        }
        $con->close();
        return $lista_dbo_coordinador;
    }

    // Busco un coordinador por ID
    public function busca_coordinador($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idCoordinador`, `idPersona` FROM `dbo_coordinadores` WHERE idCoordinador = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_coordinador($renglon);
                    $dato_elemento->setIdCoordinador($dato_elemento->getIdCoordinador());
                    $dato_elemento->setIdPersona($dato_elemento->getIdPersona());
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            // Si no hay un ID válido, inicializamos un objeto vacío
            $dato_elemento = new dbo_coordinador();
            $dato_elemento->setIdCoordinador(0);
            $dato_elemento->setIdPersona("Sin persona");
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_coordinador($eldato) {
        $sql = "UPDATE `dbo_coordinadores` SET ".
                    "idPersona='".$eldato->getIdPersona()."' ".
               "WHERE idCoordinador=".$eldato->getIdCoordinador();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino un coordinador
    public function elimina_coordinador($id) {
        $sql = "DELETE FROM `dbo_coordinadores` WHERE idCoordinador = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
