<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_asistencia_personas.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_asistencia_personas extends BaseDatos {
    // Agrega nueva asistencia
    public function agrega_asistencia($datos_dbo_asistencia) {
        $sql = "INSERT INTO `dbo_asistencia_personas`(`idPersona`, `idMesaVotacion`, `fechaHoraRegistro`, `estatusAsistencia`, `observaciones`) VALUES (
                    '".$datos_dbo_asistencia->getIdPersona()."',
                    '".$datos_dbo_asistencia->getIdMesaVotacion()."',
                    '".$datos_dbo_asistencia->getFechaHoraRegistro()."',
                    '".$datos_dbo_asistencia->getEstatusAsistencia()."',
                    '".$datos_dbo_asistencia->getObservaciones()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de asistencias
    public function lista_asistencia() {
        $lista_dbo_asistencia = array();
        $sql = "SELECT `idAsistencia`, `idPersona`, `idMesaVotacion`, `fechaHoraRegistro`, `estatusAsistencia`, `observaciones` FROM `dbo_asistencia_personas` ORDER BY idAsistencia";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) {
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_asistencia_personas($renglon);
                $dato_tabla->setIdAsistencia($dato_tabla->getIdAsistencia());
                $dato_tabla->setIdPersona($dato_tabla->getIdPersona());
                $dato_tabla->setIdMesaVotacion($dato_tabla->getIdMesaVotacion());
                $dato_tabla->setFechaHoraRegistro($dato_tabla->getFechaHoraRegistro());
                $dato_tabla->setEstatusAsistencia($dato_tabla->getEstatusAsistencia());
                $dato_tabla->setObservaciones($dato_tabla->getObservaciones());
                $lista_dbo_asistencia[$i] = $dato_tabla;
            }
        }
        $con->close();
        return $lista_dbo_asistencia;
    }

    // Busco una asistencia por ID
    public function busca_asistencia($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idAsistencia`, `idPersona`, `idMesaVotacion`, `fechaHoraRegistro`, `estatusAsistencia`, `observaciones` FROM `dbo_asistencia_personas` WHERE idAsistencia = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) {
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_asistencia_personas($renglon);
                    $dato_elemento->setIdAsistencia($dato_elemento->getIdAsistencia());
                    $dato_elemento->setIdPersona($dato_elemento->getIdPersona());
                    $dato_elemento->setIdMesaVotacion($dato_elemento->getIdMesaVotacion());
                    $dato_elemento->setFechaHoraRegistro($dato_elemento->getFechaHoraRegistro());
                    $dato_elemento->setEstatusAsistencia($dato_elemento->getEstatusAsistencia());
                    $dato_elemento->setObservaciones($dato_elemento->getObservaciones());
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            $dato_elemento = new dbo_asistencia_personas();
            $dato_elemento->setIdAsistencia(0);
            $dato_elemento->setIdPersona(0);
            $dato_elemento->setIdMesaVotacion(0);
            $dato_elemento->setFechaHoraRegistro("Sin registro");
            $dato_elemento->setEstatusAsistencia("Sin estatus");
            $dato_elemento->setObservaciones("Sin observaciones");
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_asistencia($eldato) {
        $sql = "UPDATE `dbo_asistencia_personas` SET ".
                    "idPersona='".$eldato->getIdPersona()."', ".
                    "idMesaVotacion='".$eldato->getIdMesaVotacion()."', ".
                    "fechaHoraRegistro='".$eldato->getFechaHoraRegistro()."', ".
                    "estatusAsistencia='".$eldato->getEstatusAsistencia()."', ".
                    "observaciones='".$eldato->getObservaciones()."' ".
               "WHERE idAsistencia=".$eldato->getIdAsistencia();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino una asistencia
    public function elimina_asistencia($id) {
        $sql = "DELETE FROM `dbo_asistencia_personas` WHERE idAsistencia = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
