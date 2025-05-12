<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_testigos extends base {
    protected $idTestigo;
    protected $idPersona;
    protected $idMesaVotacion;
    protected $idCoordinador;

    // Getters and Setters
    public function getIdTestigo() {
        return $this->idTestigo;
    }

    public function setIdTestigo($idTestigo) {
        $this->idTestigo = $idTestigo;
    }

    public function getIdPersona() {
        return $this->idPersona;
    }

    public function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    public function getIdMesaVotacion() {
        return $this->idMesaVotacion;
    }

    public function setIdMesaVotacion($idMesaVotacion) {
        $this->idMesaVotacion = $idMesaVotacion;
    }

    public function getIdCoordinador() {
        return $this->idCoordinador;
    }

    public function setIdCoordinador($idCoordinador) {
        $this->idCoordinador = $idCoordinador;
    }

    // Method to fetch data
    public function fetchTestigos() {
        $query = "SELECT `idTestigo`, `idPersona`, `idMesaVotacion`, `idCoordinador` FROM `dbo_testigos` WHERE 1";
        return $this->executeQuery($query);
    }
}
