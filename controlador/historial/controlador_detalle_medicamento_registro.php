<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $idmedicamento = htmlspecialchars($_POST['idmedicamento'],ENT_QUOTES,'UTF-8');
    $cantidad = htmlspecialchars($_POST['cantidad'],ENT_QUOTES,'UTF-8');

    $areglo_medicamento = explode(",",$idmedicamento);//se separan los datos del string
    $areglo_cantidad = explode(",",$cantidad);//se separan los datos del string

    for($i = 0;$i < count($areglo_medicamento);$i++) {
        $consulta = $MH->Registrar_Detalle_Medicamento($id,$areglo_medicamento[$i],$areglo_cantidad[$i]);
    }

   

    echo ($consulta);


?>