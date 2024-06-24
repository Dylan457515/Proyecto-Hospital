<?php
class Modelo_Inicio
{
	private $conexion;

	function __construct()
	{
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function Grafica_Cita()
	{
		$sql = "call SP_GRAFICA_CITA()";
            $areglo = array();
            if($consulta = $this->conexion->conexion->query($sql)){
                while($consulta_VU = mysqli_fetch_array($consulta)){
                    $areglo[] = $consulta_VU;
                }
                return $areglo;
                $this->conexion->cerrar();
            }
	}

}
