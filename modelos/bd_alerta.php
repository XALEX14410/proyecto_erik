<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_alertas.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_alerta extends BaseDatos {
    // Agrega nueva alerta
    public function agrega_alerta($datos_dbo_alerta) {
        $sql = "INSERT INTO `dbo_alertas`(`titulo`, `mensaje`, `fechaHoraEnvio`, `idUsuarioEnvio`, `idMesaVotacion`, `idCoordinador`, `idPersona`) VALUES (
                    '".$datos_dbo_alerta->getTitulo()."',
                    '".$datos_dbo_alerta->getMensaje()."',
                    '".$datos_dbo_alerta->getFechaHoraEnvio()."',
                    '".$datos_dbo_alerta->getIdUsuarioEnvio()."',
                    '".$datos_dbo_alerta->getIdMesaVotacion()."',
                    '".$datos_dbo_alerta->getIdCoordinador()."',
                    '".$datos_dbo_alerta->getIdPersona()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de alertas
    public function lista_alerta() {
        $lista_dbo_alerta = array(); // Inicializar la variable correctamente
        $sql = "SELECT `idAlerta`, `titulo`, `mensaje`, `fechaHoraEnvio`, `idUsuarioEnvio`, `idMesaVotacion`, `idCoordinador`, `idPersona` FROM `dbo_alertas` ORDER BY idAlerta";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_alerta($renglon);
                $dato_tabla->setIdAlerta($dato_tabla->getIdAlerta());
                $dato_tabla->setTitulo($dato_tabla->getTitulo());
                $dato_tabla->setMensaje($dato_tabla->getMensaje());
                $dato_tabla->setFechaHoraEnvio($dato_tabla->getFechaHoraEnvio());
                $dato_tabla->setIdUsuarioEnvio($dato_tabla->getIdUsuarioEnvio());
                $dato_tabla->setIdMesaVotacion($dato_tabla->getIdMesaVotacion());
                $dato_tabla->setIdCoordinador($dato_tabla->getIdCoordinador());
                $dato_tabla->setIdPersona($dato_tabla->getIdPersona());
                $lista_dbo_alerta[$i] = $dato_tabla; // Almacena en el array
            }
        }
        $con->close();
        return $lista_dbo_alerta;
    }

    // Busco una alerta por ID
    public function busca_alerta($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idAlerta`, `titulo`, `mensaje`, `fechaHoraEnvio`, `idUsuarioEnvio`, `idMesaVotacion`, `idCoordinador`, `idPersona` FROM `dbo_alertas` WHERE idAlerta = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) { // Quiere decir que lo encontró
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_alerta($renglon);
                    $dato_elemento->setIdAlerta($dato_elemento->getIdAlerta());
                    $dato_elemento->setTitulo($dato_elemento->getTitulo());
                    $dato_elemento->setMensaje($dato_elemento->getMensaje());
                    $dato_elemento->setFechaHoraEnvio($dato_elemento->getFechaHoraEnvio());
                    $dato_elemento->setIdUsuarioEnvio($dato_elemento->getIdUsuarioEnvio());
                    $dato_elemento->setIdMesaVotacion($dato_elemento->getIdMesaVotacion());
                    $dato_elemento->setIdCoordinador($dato_elemento->getIdCoordinador());
                    $dato_elemento->setIdPersona($dato_elemento->getIdPersona());
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            // Si no hay un ID válido, inicializamos un objeto vacío
            $dato_elemento = new dbo_alerta();
            $dato_elemento->setIdAlerta(0);
            $dato_elemento->setTitulo("Sin título");
            $dato_elemento->setMensaje("Sin mensaje");
            $dato_elemento->setFechaHoraEnvio("0000-00-00 00:00:00");
            $dato_elemento->setIdUsuarioEnvio(0);
            $dato_elemento->setIdMesaVotacion(0);
            $dato_elemento->setIdCoordinador(0);
            $dato_elemento->setIdPersona(0);
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_alerta($eldato) {
        $sql = "UPDATE `dbo_alertas` SET ".
                    "titulo='".$eldato->getTitulo()."', ".
                    "mensaje='".$eldato->getMensaje()."', ".
                    "fechaHoraEnvio='".$eldato->getFechaHoraEnvio()."', ".
                    "idUsuarioEnvio='".$eldato->getIdUsuarioEnvio()."', ".
                    "idMesaVotacion='".$eldato->getIdMesaVotacion()."', ".
                    "idCoordinador='".$eldato->getIdCoordinador()."', ".
                    "idPersona='".$eldato->getIdPersona()."' ".
               "WHERE idAlerta=".$eldato->getIdAlerta();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino una alerta
    public function elimina_alerta($id) {
        $sql = "DELETE FROM `dbo_alertas` WHERE idAlerta = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
