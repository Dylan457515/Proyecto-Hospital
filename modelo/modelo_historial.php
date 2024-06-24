<?php
	class Modelo_Historial
	{
		private $conexion;
	
		function __construct()
		{
			require_once 'modelo_conexion.php';
			$this->conexion = new conexion();
			$this->conexion->conectar();
		}
	
		function lista_historial($fechainicio,$fechafin)
		{
			$sql = "call SP_LISTAR_HISTORIAL('$fechainicio','$fechafin')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}

		function lista_historial_consulta()
		{
			$sql = "call SP_LISTAR_CONSULTA_HISTORIAL()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}
        


		function lista_conbo_medicamento(){
            $sql = "call SP_LISTAR_COMBO_MEDICAMENTO()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

        function lista_conbo_procedimiento(){
            $sql = "call SP_LISTAR_COMBO_PROCEDIMIENTO()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

		function lista_conbo_insumo(){
            $sql = "call SP_LISTAR_COMBO_INSUMO()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

		function TraerStockMedicamento($id){
            $sql = "call SP_TRAER_STOCK_MEDICAMENTO_H($id);";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }


		function TraerStockInsumo($id){
            $sql = "call SP_TRAER_STOCK_INSUMO_H($id);";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }



		function Registrar_fua($idhistorial,$idconsulta)
		{
			$sql = "call SP_REGISTRAR_FUA('$idhistorial','$idconsulta');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				if ($row = mysqli_fetch_array($consulta)) {
					return trim($row[0]);
				}
				$this->conexion->cerrar();
			}
			$this->conexion->cerrar();
		}

		


		function Registrar_Detalle_Procedimiento($id,$areglo_procedimiento)
		{
			$sql = "call SP_REGISTRAR_DETALLE_PROCEDIMIENTO('$id','$areglo_procedimiento');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
			$this->conexion->cerrar();
		}


		function Registrar_Detalle_Medicamento($id,$areglo_medicamento,$areglo_cantidad)
		{
			$sql = "call SP_REGISTRAR_DETALLE_MEDICAMENTO('$id','$areglo_medicamento','$areglo_cantidad');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
			$this->conexion->cerrar();
		}

		function Registrar_Detalle_Insumo($id,$areglo_insumo,$areglo_cantidad)
		{
			$sql = "call SP_REGISTRAR_DETALLE_INSUMO('$id','$areglo_insumo','$areglo_cantidad');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
			$this->conexion->cerrar();
		}

		function lista_detalle_procedimiento($idfua)
		{
			$sql = "call SP_LISTAR_PROCEDIMIENTO_DETALLE('$idfua')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}


		function lista_detalle_insumo($idfua)
		{
			$sql = "call SP_LISTAR_INSUMO_DETALLE('$idfua')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}

		function lista_detalle_medicamento($idfua)
		{
			$sql = "call SP_LISTAR_MEDICAMENTO_DETALLE('$idfua')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}

	}
?>

