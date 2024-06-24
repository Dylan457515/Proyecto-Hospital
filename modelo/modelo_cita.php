<?php
	class Modelo_Cita
	{
		private $conexion;
	
		function __construct()
		{
			require_once 'modelo_conexion.php';
			$this->conexion = new conexion();
			$this->conexion->conectar();
		}
	
		function lista_cita()
		{
			$sql = "call SP_LISTAR_CITA()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
					$arreglo["data"][] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}


        function lista_conbo_paciente(){
            $sql = "call SP_LISTAR_COMBO_PACIENTE()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

        function lista_conbo_especialidad(){
            $sql = "call SP_LISTAR_ESPECIALIDAD_COMBO()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }


        function lista_conbo_doctor($id){
            $sql = "call SP_LISTAR_DOCTOR_COMBO('$id')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }


		function Registrar_Cita($idpaciente,$idespecialidad,$iddoctor,$descripcion,$idusuario)
		{
			$sql = "call SP_REGISTRAR_CITA('$idpaciente', '$idespecialidad', '$iddoctor', '$descripcion', '$idusuario');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				if ($row = mysqli_fetch_array($consulta)) {
					return trim($row[0]);
				}
				$this->conexion->cerrar();
			}
		}

	
		function Editar_Cita($idcita,$idespecialidad,$idpaciente,$iddoctor,$descripcion,$status)
		{
			$sql = "call SP_EDITAR_CITA('$idcita','$idpaciente', '$idespecialidad', '$iddoctor', '$descripcion', '$status');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
				
			}else{
				return 0;
			}
			$this->conexion->cerrar();
		}

	}
?>

