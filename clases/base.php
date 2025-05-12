<?php
    class base {
        public function __construct($datos = null) {
            if($datos != null) {
                foreach($datos as $llave=>$valor) {
                    $this->$llave = $valor;
                }
            }
        }
    }
?>