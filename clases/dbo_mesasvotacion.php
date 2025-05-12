<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_mesasvotacion extends base {
    protected $idMesaVotacion;
    protected $nombreMesa;
    protected $idLugarVotacion;
    protected $idCoordinador;

    // Getters and Setters for each property
    public function getIdMesaVotacion() {
        return $this->idMesaVotacion;
    }

    public function setIdMesaVotacion($idMesaVotacion) {
        $this->idMesaVotacion = $idMesaVotacion;
    }

    public function getNombreMesa() {
        return $this->nombreMesa;
    }

    public function setNombreMesa($nombreMesa) {
        $this->nombreMesa = $nombreMesa;
    }

    public function getIdLugarVotacion() {
        return $this->idLugarVotacion;
    }

    public function setIdLugarVotacion($idLugarVotacion) {
        $this->idLugarVotacion = $idLugarVotacion;
    }

    public function getIdCoordinador() {
        return $this->idCoordinador;
    }

    public function setIdCoordinador($idCoordinador) {
        $this->idCoordinador = $idCoordinador;
    }
}