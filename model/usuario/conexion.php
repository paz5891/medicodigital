<?php

class conexion {
    private $servidor;
    private $usuario;
    private $constrasena;
    private $db;
    public $conexion;

    public function __construct()
    {
       $this->servidor = "68.178.222.14";
       $this->usuario ="leysimaricelpazreyes";
       $this->constrasena ="leysimaricelpazreyes";
       $this->db = "sys_genesis"; 
    }
    function conectar(){
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->constrasena, $this->db);
        $this->conexion->set_charset("utf8"); 
    }

    function cerrar(){
        $this->conexion->close();
    }
}


?>

