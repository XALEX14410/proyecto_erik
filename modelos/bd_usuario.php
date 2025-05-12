<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_usuario.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_usuario extends BaseDatos {
    // Agrega nuevo usuario
    public function agrega_usuario($datos_dbo_usuario) {
        $sql = "INSERT INTO `dbo_usuarios`(`nombre`, `primApellido`, `segApellido`, `usuario`, `password`, `idPerfil`, `idPartido`, `idPersona`, `idCoordinador`, `idTestigo`, `estatus`) VALUES (
                    '".$datos_dbo_usuario->getNombre()."',
                    '".$datos_dbo_usuario->getPrimApellido()."',
                    '".$datos_dbo_usuario->getSegApellido()."',
                    '".$datos_dbo_usuario->getUsuario()."',
                    '".$datos_dbo_usuario->getPassword()."',
                    '".$datos_dbo_usuario->getIdPerfil()."',
                    '".$datos_dbo_usuario->getIdPartido()."',
                    '".$datos_dbo_usuario->getIdPersona()."',
                    '".$datos_dbo_usuario->getIdCoordinador()."',
                    '".$datos_dbo_usuario->getIdTestigo()."',
                    '".$datos_dbo_usuario->getEstatus()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de usuarios
    public function lista_usuario() {
        $lista_dbo_usuario = array();
        $sql = "SELECT `idUsuario`, `nombre`, `primApellido`, `segApellido`, `usuario`, `password`, `idPerfil`, `idPartido`, `idPersona`, `idCoordinador`, `idTestigo`, `estatus` FROM `dbo_usuarios` ORDER BY idUsuario";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) {
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_usuario($renglon);
                $lista_dbo_usuario[$i] = $dato_tabla;
            }
        }
        $con->close();
        return $lista_dbo_usuario;
    }

    // Busco un usuario por ID
    public function busca_usuario($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idUsuario`, `nombre`, `primApellido`, `segApellido`, `usuario`, `password`, `idPerfil`, `idPartido`, `idPersona`, `idCoordinador`, `idTestigo`, `estatus` FROM `dbo_usuarios` WHERE idUsuario = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) {
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_usuario($renglon);
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            $dato_elemento = new dbo_usuario();
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_usuario($eldato) {
        $sql = "UPDATE `dbo_usuarios` SET ".
                    "nombre='".$eldato->getNombre()."', ".
                    "primApellido='".$eldato->getPrimApellido()."', ".
                    "segApellido='".$eldato->getSegApellido()."', ".
                    "usuario='".$eldato->getUsuario()."', ".
                    "password='".$eldato->getPassword()."', ".
                    "idPerfil='".$eldato->getIdPerfil()."', ".
                    "idPartido='".$eldato->getIdPartido()."', ".
                    "idPersona='".$eldato->getIdPersona()."', ".
                    "idCoordinador='".$eldato->getIdCoordinador()."', ".
                    "idTestigo='".$eldato->getIdTestigo()."', ".
                    "estatus='".$eldato->getEstatus()."' ".
               "WHERE idUsuario=".$eldato->getIdUsuario();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino un usuario
    public function elimina_usuario($id) {
        $sql = "DELETE FROM `dbo_usuarios` WHERE idUsuario = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
