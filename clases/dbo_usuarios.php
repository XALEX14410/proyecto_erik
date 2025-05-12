<?php
include_once realpath(dirname(__FILE__)."/../clases/base.php");

class dbo_usuarios extends base {
    protected $idUsuario;
    protected $nombre;
    protected $primApellido;
    protected $segApellido;
    protected $usuario;
    protected $password;
    protected $idPerfil;
    protected $idPartido;
    protected $idPersona;
    protected $idCoordinador;
    protected $idTestigo;
    protected $estatus;

    // Getters and Setters for each property
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
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

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getIdPerfil() {
        return $this->idPerfil;
    }

    public function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    public function getIdPartido() {
        return $this->idPartido;
    }

    public function setIdPartido($idPartido) {
        $this->idPartido = $idPartido;
    }

    public function getIdPersona() {
        return $this->idPersona;
    }

    public function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    public function getIdCoordinador() {
        return $this->idCoordinador;
    }

    public function setIdCoordinador($idCoordinador) {
        $this->idCoordinador = $idCoordinador;
    }

    public function getIdTestigo() {
        return $this->idTestigo;
    }

    public function setIdTestigo($idTestigo) {
        $this->idTestigo = $idTestigo;
    }

    public function getEstatus() {
        return $this->estatus;
    }

    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    // Method to fetch data
    public function fetchAllUsuarios($connection) {
        $query = "SELECT `idUsuario`, `nombre`, `primApellido`, `segApellido`, `usuario`, `password`, `idPerfil`, `idPartido`, `idPersona`, `idCoordinador`, `idTestigo`, `estatus` FROM `dbo_usuarios` WHERE 1";
        $result = $connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
