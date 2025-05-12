<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_asistencia_personas extends base {
    protected $idAsistencia;
    protected $idPersona;
    protected $idMesaVotacion;
    protected $fechaHoraRegistro;
    protected $estatusAsistencia;
    protected $observaciones;

    // Getters and Setters for each property
    public function getIdAsistencia() {
        return $this->idAsistencia;
    }

    public function setIdAsistencia($idAsistencia) {
        $this->idAsistencia = $idAsistencia;
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

    public function getFechaHoraRegistro() {
        return $this->fechaHoraRegistro;
    }

    public function setFechaHoraRegistro($fechaHoraRegistro) {
        $this->fechaHoraRegistro = $fechaHoraRegistro;
    }

    public function getEstatusAsistencia() {
        return $this->estatusAsistencia;
    }

    public function setEstatusAsistencia($estatusAsistencia) {
        $this->estatusAsistencia = $estatusAsistencia;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
}