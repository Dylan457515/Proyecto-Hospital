<?php
class Modelo_Usuario {
    private $conexion;

        function __construct(){
            require_once 'modelo_conexion.php';
            $this->conexion = new conexion();
            $this->conexion->conectar();
        }

        function VerificarUsuario($usuario,$contra){
            $sql = "call SP_VERIFICAR_USUARIO('$usuario')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {
					if(password_verify($contra, $consulta_VU["usu_contrasena"]))
                    {
                        $arreglo[] = $consulta_VU;
                    }
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

        function lista_usuario(){
            $sql = "call SP_LISTA_USUARIO()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                    $arreglo["data"][]=$consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

        function lista_conbo_rol(){
            $sql = "call SP_LISTA_COMBO_ROL()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {

                    $arreglo[] = $consulta_VU;

				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

		function Registrar_Usuario($usuario,$contra,$sexo,$rol,$email){
			$sql = "call SP_REGISTRAR_USUAIO('$usuario','$contra','$sexo','$rol','$email');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				if ($row = mysqli_fetch_array($consulta)) {

					return $id = trim($row[0]);
				}
				$this->conexion->cerrar();
			}
		}

		function Modificar_Estatus_Usuario($idusuario,$estatus){
			$sql = "call SP_MODIFICAR_ESTATUS_USUARIO('$idusuario','$estatus')";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
		}

		function Modificar_Contra_Usuario( $idusuario ,$contranu ){
			$sql = "call SP_MODIFICAR_CONTRA_USUARIO('$idusuario','$contranu')";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
		}

		function Modificar_Datos_Usuario($idusuario,$sexo,$rol,$email){
			$sql = "call SP_MODIFICAR_DATOS_USUARIO('$idusuario','$sexo','$rol','$email');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
			}else{
				return 0;
			}
		}

		function TraerDatos($usuario){
            $sql = "call SP_VERIFICAR_USUARIO('$usuario')";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {
					$arreglo[]=$consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
        }

		function Restableser_Contra($email,$contra){
			$sql = "call PS_RESTABLECER_CONTRA('$email','$contra');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				if ($row = mysqli_fetch_array($consulta)) {

					return $id = trim($row[0]);
				}
				$this->conexion->cerrar();
			}
		}

		function Modificar_Intento_Usuario($idusuario){
			$sql = "call PS_INTENTO_USUARIO('$idusuario');";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				if ($row = mysqli_fetch_array($consulta)) {

					return $id = trim($row[0]);
				}
				$this->conexion->cerrar();
			}
		}


	}
?>
