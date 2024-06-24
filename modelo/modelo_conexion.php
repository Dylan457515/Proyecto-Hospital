<?php
class conexion{
    private $servidor;
    private $usuario;
    private $contrasena;
    private $basedatos;
    private $puerto; // Agregar variable para el puerto
    public $conexion;

    public function __construct(){
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->contrasena = "";
        $this->basedatos = "bd_sistema";
        $this->puerto = 3306; // Especificar el puerto aquí
    }

    function conectar(){
        // Agregar el puerto como quinto parámetro
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->basedatos, $this->puerto);

        // Establecer el juego de caracteres
        $this->conexion->set_charset("utf8");
    }

    function cerrar(){
        $this->conexion->close();
    }
}
?>
