<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_personas extends base {
    protected $idPersona;
    protected $nombre;
    protected $primApellido;
    protected $segApellido;
    protected $curp;
    protected $claveElector;
    protected $telefonoCelular;
    protected $telefonoCasa;
    protected $correo;
    protected $fecNacimiento;
    protected $calle;
    protected $noExterior;
    protected $noInterior;
    protected $codigoPostal;
    protected $idEstado;
    protected $idMunicipio;
    protected $idColonia;
    protected $idPersonaTipoSangre;
    protected $idPersonaOcupacion;
    protected $idPersonaGradoAcademico;
    protected $idPersonaPoblacion;
    protected $idPersonaEstadoApoyo;
    protected $idLugarVotacion;
    protected $idMesaVotacion;
    protected $disponibilidad;
    protected $observaciones;
    protected $id_distrito_federal;
    protected $id_distrito_local;
    protected $idPersonaGenero;
    protected $estatus;

    // Getters and Setters for each property
    public function getIdPersona() {
        return $this->idPersona;
    }

    public function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getPrimApellido() {
        return $this->primApellido;
    }

    public function setPrimApellido($primApellido) {
        $this->primApellido = $primApellido;
    }

    public function getSegApellido() {
        return $this->segApellido;
    }

    public function setSegApellido($segApellido) {
        $this->segApellido = $segApellido;
    }

    public function getCurp() {
        return $this->curp;
    }

    public function setCurp($curp) {
        $this->curp = $curp;
    }

    public function getClaveElector() {
        return $this->claveElector;
    }

    public function setClaveElector($claveElector) {
        $this->claveElector = $claveElector;
    }

    public function getTelefonoCelular() {
        return $this->telefonoCelular;
    }

    public function setTelefonoCelular($telefonoCelular) {
        $this->telefonoCelular = $telefonoCelular;
    }

    public function getTelefonoCasa() {
        return $this->telefonoCasa;
    }

    public function setTelefonoCasa($telefonoCasa) {
        $this->telefonoCasa = $telefonoCasa;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getFecNacimiento() {
        return $this->fecNacimiento;
    }

    public function setFecNacimiento($fecNacimiento) {
        $this->fecNacimiento = $fecNacimiento;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function setCalle($calle) {
        $this->calle = $calle;
    }

    public function getNoExterior() {
        return $this->noExterior;
    }

    public function setNoExterior($noExterior) {
        $this->noExterior = $noExterior;
    }

    public function getNoInterior() {
        return $this->noInterior;
    }

    public function setNoInterior($noInterior) {
        $this->noInterior = $noInterior;
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }

    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    public function getIdMunicipio() {
        return $this->idMunicipio;
    }

    public function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

    public function getIdColonia() {
        return $this->idColonia;
    }

    public function setIdColonia($idColonia) {
        $this->idColonia = $idColonia;
    }

    public function getIdPersonaTipoSangre() {
        return $this->idPersonaTipoSangre;
    }

    public function setIdPersonaTipoSangre($idPersonaTipoSangre) {
        $this->idPersonaTipoSangre = $idPersonaTipoSangre;
    }

    public function getIdPersonaOcupacion() {
        return $this->idPersonaOcupacion;
    }

    public function setIdPersonaOcupacion($idPersonaOcupacion) {
        $this->idPersonaOcupacion = $idPersonaOcupacion;
    }

    public function getIdPersonaGradoAcademico() {
        return $this->idPersonaGradoAcademico;
    }

    public function setIdPersonaGradoAcademico($idPersonaGradoAcademico) {
        $this->idPersonaGradoAcademico = $idPersonaGradoAcademico;
    }

    public function getIdPersonaPoblacion() {
        return $this->idPersonaPoblacion;
    }

    public function setIdPersonaPoblacion($idPersonaPoblacion) {
        $this->idPersonaPoblacion = $idPersonaPoblacion;
    }

    public function getIdPersonaEstadoApoyo() {
        return $this->idPersonaEstadoApoyo;
    }

    public function setIdPersonaEstadoApoyo($idPersonaEstadoApoyo) {
        $this->idPersonaEstadoApoyo = $idPersonaEstadoApoyo;
    }

    public function getIdLugarVotacion() {
        return $this->idLugarVotacion;
    }

    public function setIdLugarVotacion($idLugarVotacion) {
        $this->idLugarVotacion = $idLugarVotacion;
    }

    public function getIdMesaVotacion() {
        return $this->idMesaVotacion;
    }

    public function setIdMesaVotacion($idMesaVotacion) {
        $this->idMesaVotacion = $idMesaVotacion;
    }

    public function getDisponibilidad() {
        return $this->disponibilidad;
    }

    public function setDisponibilidad($disponibilidad) {
        $this->disponibilidad = $disponibilidad;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getIdDistritoFederal() {
        return $this->id_distrito_federal;
    }

    public function setIdDistritoFederal($id_distrito_federal) {
        $this->id_distrito_federal = $id_distrito_federal;
    }

    public function getIdDistritoLocal() {
        return $this->id_distrito_local;
    }

    public function setIdDistritoLocal($id_distrito_local) {
        $this->id_distrito_local = $id_distrito_local;
    }

    public function getIdPersonaGenero() {
        return $this->idPersonaGenero;
    }

    public function setIdPersonaGenero($idPersonaGenero) {
        $this->idPersonaGenero = $idPersonaGenero;
    }

    public function getEstatus() {
        return $this->estatus;
    }

    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
}