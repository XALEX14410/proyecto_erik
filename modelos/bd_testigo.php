<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_testigo.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_testigo extends BaseDatos {
    // Agrega nuevo testigo
    public function agrega_testigo($datos_dbo_testigo) {
        $sql = "INSERT INTO `dbo_testigos`(`idPersona`, `idMesaVotacion`, `idCoordinador`) VALUES (
                    '".$datos_dbo_testigo->getIdPersona()."',
                    '".$datos_dbo_testigo->getIdMesaVotacion()."',
                    '".$datos_dbo_testigo->getIdCoordinador()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de testigos
    public function lista_testigo() {
        $lista_dbo_testigo = array(); // Inicializar la variable correctamente
        $sql = "SELECT `idTestigo`, `idPersona`, `idMesaVotacion`, `idCoordinador` FROM `dbo_testigos` ORDER BY idTestigo";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_testigo($renglon);
                $dato_tabla->setIdTestigo($dato_tabla->getIdTestigo());
                $dato_tabla->setIdPersona($dato_tabla->getIdPersona());
                $dato_tabla->setIdMesaVotacion($dato_tabla->getIdMesaVotacion());
                $dato_tabla->setIdCoordinador($dato_tabla->getIdCoordinador());
                $lista_dbo_testigo[$i] = $dato_tabla; // Almacena en el array
            }
        }
        $con->close();
        return $lista_dbo_testigo;
    }

    // Busco un testigo por ID
    public function busca_testigo($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idTestigo`, `idPersona`, `idMesaVotacion`, `idCoordinador` FROM `dbo_testigos` WHERE idTestigo = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_testigo($renglon);
                    $dato_elemento->setIdTestigo($dato_elemento->getIdTestigo());
                    $dato_elemento->setIdPersona($dato_elemento->getIdPersona());
                    $dato_elemento->setIdMesaVotacion($dato_elemento->getIdMesaVotacion());
                    $dato_elemento->setIdCoordinador($dato_elemento->getIdCoordinador());
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            // Si no hay un ID válido, inicializamos un objeto vacío
            $dato_elemento = new dbo_testigo();
            $dato_elemento->setIdTestigo(0);
            $dato_elemento->setIdPersona("Sin persona");
            $dato_elemento->setIdMesaVotacion("Sin mesa");
            $dato_elemento->setIdCoordinador("Sin coordinador");
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_testigo($eldato) {
        $sql = "UPDATE `dbo_testigos` SET ".
                    "idPersona='".$eldato->getIdPersona()."', ".
                    "idMesaVotacion='".$eldato->getIdMesaVotacion()."', ".
                    "idCoordinador='".$eldato->getIdCoordinador()."' ".
               "WHERE idTestigo=".$eldato->getIdTestigo();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino un testigo
    public function elimina_testigo($id) {
        $sql = "DELETE FROM `dbo_testigos` WHERE idTestigo = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
