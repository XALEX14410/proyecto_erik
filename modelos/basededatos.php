<?php
    class BaseDatos {
        private $bd;
        protected $mensajes = array();
        private $server     = 'localhost';
        /*Configuracion de la base de datos****************/
        private $user       = "nuevo_usuario";
        private $pass       = "contraseña";
        private $base_datos = "super_cyt";
        /**************************************************/
        protected $campos = array();
        protected $llaveprimaria;
        protected $existenelementos;
        protected $cuatoselementos;

        public function conectar() {
            mysql_connect($this->server,$this->user,$this->pass);
            mysql_select_db($this->base_datos);
        }

        public function getBD() {
            try {
                $this->bd = new mysqli(
                    $this->server,
                    $this->user,
                    $this->pass,
                    $this->base_datos
                );

                $this->bd->set_charset("utf8");
                
                if (mysqli_connect_errno()) {
                    throw new Exception("No es posible establecer una conexion con la base datos");
                }

                else {
                    return $this->bd;
                }
            }

            catch (Exception $e) {
                $this->mensajes['BD_conexion']=$e->getMessage();
            }
        }
    }
?>