<?php

include_once realpath(dirname(__FILE__)."/../clases/dbo_personas.php");
include_once realpath(dirname(__FILE__)."/../modelos/basededatos.php");

class bd_personas extends BaseDatos {
    // Agrega nueva persona
    public function agrega_persona($datos_dbo_personas) {
        $sql = "INSERT INTO `dbo_personas`(`nombre`, `primApellido`, `segApellido`, `curp`, `claveElector`, `telefonoCelular`, `telefonoCasa`, `correo`, `fecNacimiento`, `calle`, `noExterior`, `noInterior`, `codigoPostal`, `idEstado`, `idMunicipio`, `idColonia`, `idPersonaTipoSangre`, `idPersonaOcupacion`, `idPersonaGradoAcademico`, `idPersonaPoblacion`, `idPersonaEstadoApoyo`, `idLugarVotacion`, `idMesaVotacion`, `disponibilidad`, `observaciones`, `id_distrito_federal`, `id_distrito_local`, `idPersonaGenero`, `estatus`) VALUES (
                    '".$datos_dbo_personas->getNombre()."',
                    '".$datos_dbo_personas->getPrimApellido()."',
                    '".$datos_dbo_personas->getSegApellido()."',
                    '".$datos_dbo_personas->getCurp()."',
                    '".$datos_dbo_personas->getClaveElector()."',
                    '".$datos_dbo_personas->getTelefonoCelular()."',
                    '".$datos_dbo_personas->getTelefonoCasa()."',
                    '".$datos_dbo_personas->getCorreo()."',
                    '".$datos_dbo_personas->getFecNacimiento()."',
                    '".$datos_dbo_personas->getCalle()."',
                    '".$datos_dbo_personas->getNoExterior()."',
                    '".$datos_dbo_personas->getNoInterior()."',
                    '".$datos_dbo_personas->getCodigoPostal()."',
                    '".$datos_dbo_personas->getIdEstado()."',
                    '".$datos_dbo_personas->getIdMunicipio()."',
                    '".$datos_dbo_personas->getIdColonia()."',
                    '".$datos_dbo_personas->getIdPersonaTipoSangre()."',
                    '".$datos_dbo_personas->getIdPersonaOcupacion()."',
                    '".$datos_dbo_personas->getIdPersonaGradoAcademico()."',
                    '".$datos_dbo_personas->getIdPersonaPoblacion()."',
                    '".$datos_dbo_personas->getIdPersonaEstadoApoyo()."',
                    '".$datos_dbo_personas->getIdLugarVotacion()."',
                    '".$datos_dbo_personas->getIdMesaVotacion()."',
                    '".$datos_dbo_personas->getDisponibilidad()."',
                    '".$datos_dbo_personas->getObservaciones()."',
                    '".$datos_dbo_personas->getIdDistritoFederal()."',
                    '".$datos_dbo_personas->getIdDistritoLocal()."',
                    '".$datos_dbo_personas->getIdPersonaGenero()."',
                    '".$datos_dbo_personas->getEstatus()."'
                )";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Genero mi lista de personas
    public function lista_personas() {
        $lista_dbo_personas = array();
        $sql = "SELECT `idPersona`, `nombre`, `primApellido`, `segApellido`, `curp`, `claveElector`, `telefonoCelular`, `telefonoCasa`, `correo`, `fecNacimiento`, `calle`, `noExterior`, `noInterior`, `codigoPostal`, `idEstado`, `idMunicipio`, `idColonia`, `idPersonaTipoSangre`, `idPersonaOcupacion`, `idPersonaGradoAcademico`, `idPersonaPoblacion`, `idPersonaEstadoApoyo`, `idLugarVotacion`, `idMesaVotacion`, `disponibilidad`, `observaciones`, `id_distrito_federal`, `id_distrito_local`, `idPersonaGenero`, `estatus` FROM `dbo_personas` WHERE 1";
        $con = $this->getBD();
        $resultado = $con->query($sql);
        if ($resultado->num_rows > 0) {
            for ($i = 0; $i < $resultado->num_rows; $i++) {
                $renglon = $resultado->fetch_assoc();
                $dato_tabla = new dbo_personas($renglon);
                $lista_dbo_personas[$i] = $dato_tabla;
            }
        }
        $con->close();
        return $lista_dbo_personas;
    }

    // Busco una persona por ID
    public function busca_persona($id) {
        $datos_del_elemento = array();
        if ($id > 0) {
            $sql = "SELECT `idPersona`, `nombre`, `primApellido`, `segApellido`, `curp`, `claveElector`, `telefonoCelular`, `telefonoCasa`, `correo`, `fecNacimiento`, `calle`, `noExterior`, `noInterior`, `codigoPostal`, `idEstado`, `idMunicipio`, `idColonia`, `idPersonaTipoSangre`, `idPersonaOcupacion`, `idPersonaGradoAcademico`, `idPersonaPoblacion`, `idPersonaEstadoApoyo`, `idLugarVotacion`, `idMesaVotacion`, `disponibilidad`, `observaciones`, `id_distrito_federal`, `id_distrito_local`, `idPersonaGenero`, `estatus` FROM `dbo_personas` WHERE idPersona = ".$id;
            $con = $this->getBD();
            $resultado = $con->query($sql);
            if ($resultado->num_rows > 0) {
                for ($i = 0; $i < $resultado->num_rows; $i++) {
                    $renglon = $resultado->fetch_assoc();
                    $dato_elemento = new dbo_personas($renglon);
                    $datos_del_elemento[$i] = $dato_elemento;
                }
            }
            $con->close();
        } else {
            $dato_elemento = new dbo_personas();
            $datos_del_elemento[0] = $dato_elemento;
        }
        return $datos_del_elemento;
    }

    // Modifico los registros en la base de datos
    public function actualiza_persona($eldato) {
        $sql = "UPDATE `dbo_personas` SET ".
                    "nombre='".$eldato->getNombre()."', ".
                    "primApellido='".$eldato->getPrimApellido()."', ".
                    "segApellido='".$eldato->getSegApellido()."', ".
                    "curp='".$eldato->getCurp()."', ".
                    "claveElector='".$eldato->getClaveElector()."', ".
                    "telefonoCelular='".$eldato->getTelefonoCelular()."', ".
                    "telefonoCasa='".$eldato->getTelefonoCasa()."', ".
                    "correo='".$eldato->getCorreo()."', ".
                    "fecNacimiento='".$eldato->getFecNacimiento()."', ".
                    "calle='".$eldato->getCalle()."', ".
                    "noExterior='".$eldato->getNoExterior()."', ".
                    "noInterior='".$eldato->getNoInterior()."', ".
                    "codigoPostal='".$eldato->getCodigoPostal()."', ".
                    "idEstado='".$eldato->getIdEstado()."', ".
                    "idMunicipio='".$eldato->getIdMunicipio()."', ".
                    "idColonia='".$eldato->getIdColonia()."', ".
                    "idPersonaTipoSangre='".$eldato->getIdPersonaTipoSangre()."', ".
                    "idPersonaOcupacion='".$eldato->getIdPersonaOcupacion()."', ".
                    "idPersonaGradoAcademico='".$eldato->getIdPersonaGradoAcademico()."', ".
                    "idPersonaPoblacion='".$eldato->getIdPersonaPoblacion()."', ".
                    "idPersonaEstadoApoyo='".$eldato->getIdPersonaEstadoApoyo()."', ".
                    "idLugarVotacion='".$eldato->getIdLugarVotacion()."', ".
                    "idMesaVotacion='".$eldato->getIdMesaVotacion()."', ".
                    "disponibilidad='".$eldato->getDisponibilidad()."', ".
                    "observaciones='".$eldato->getObservaciones()."', ".
                    "id_distrito_federal='".$eldato->getIdDistritoFederal()."', ".
                    "id_distrito_local='".$eldato->getIdDistritoLocal()."', ".
                    "idPersonaGenero='".$eldato->getIdPersonaGenero()."', ".
                    "estatus='".$eldato->getEstatus()."' ".
               "WHERE idPersona=".$eldato->getIdPersona();
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }

    // Elimino una persona
    public function elimina_persona($id) {
        $sql = "DELETE FROM `dbo_personas` WHERE idPersona = ".$id;
        $con = $this->getBD();
        $resultado = $con->query($sql);
        $con->close();
    }
}
?>
