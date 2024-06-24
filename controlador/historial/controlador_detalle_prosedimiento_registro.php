<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $idprocedimiento = htmlspecialchars($_POST['idprocedimiento'],ENT_QUOTES,'UTF-8');

    $areglo_procedimiento = explode(",",$idprocedimiento);//se separan los datos del string

    for($i = 0;$i < count($areglo_procedimiento);$i++) {
        $consulta = $MH->Registrar_Detalle_Procedimiento($id,$areglo_procedimiento[$i]);
    }

   

    echo ($consulta);


?>