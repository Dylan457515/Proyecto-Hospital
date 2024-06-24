<?php
class Modelo_Insumo
{
	private $conexion;

	function __construct()
	{
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function lista_insumo()
	{
		$sql = "call SP_LISTAR_INSUMO()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function Registrar_Insumo($procedimiento, $stock, $estatus)
	{
		$sql = "call SP_REGISTRAR_INSUMO('$procedimiento','$stock','$estatus');";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {

				return $id = trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}

	function Modificar_Procedimiento($id, $procedimientoactual, $procedimientonuevo, $estatus)
	{
		$sql = "call SP_MODIFICAR_PROCEDIMIENTO('$id','$procedimientoactual','$procedimientonuevo','$estatus');";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {

				return $id = trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}

	function Modificar_Insumo($id, $insumoactual, $insumonuevo, $stock, $estatus)
	{
		$sql = "call SP_MODIFICAR_INSUMO('$id','$insumoactual','$insumonuevo','$stock','$estatus');";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {
				return $id = trim($row[0]);
			}
		}
	}


	function Grafica_Insumo()
	{
		$sql = "call SP_GRAFICA_INSUMO()";
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