<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_coordinadores extends base {
    protected $idCoordinador;
    protected $idPersona;

    // Getters and Setters for each property
    public function getIdCoordinador() {
        return $this->idCoordinador;
    }

    public function setIdCoordinador($idCoordinador) {
        $this->idCoordinador = $idCoordinador;
    }

    public function getIdPersona() {
        return $this->idPersona;
    }

    public function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }
}