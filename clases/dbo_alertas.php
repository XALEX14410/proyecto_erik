<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_alertas extends base {
    protected $idAlerta;
    protected $titulo;
    protected $mensaje;
    protected $fechaHoraEnvio;
    protected $idUsuarioEnvio;
    protected $idMesaVotacion;
    protected $idCoordinador;
    protected $idPersona;

    // Getters and Setters for each property
    public function getIdAlerta() {
        return $this->idAlerta;
    }

    public function setIdAlerta($idAlerta) {
        $this->idAlerta = $idAlerta;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getFechaHoraEnvio() {
        return $this->fechaHoraEnvio;
    }

    public function setFechaHoraEnvio($fechaHoraEnvio) {
        $this->fechaHoraEnvio = $fechaHoraEnvio;
    }

    public function getIdUsuarioEnvio() {
        return $this->idUsuarioEnvio;
    }

    public function setIdUsuarioEnvio($idUsuarioEnvio) {
        $this->idUsuarioEnvio = $idUsuarioEnvio;
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

    public function getIdPersona() {
        return $this->idPersona;
    }

    public function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }
}