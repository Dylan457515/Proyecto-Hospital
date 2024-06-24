<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $idinsumo = htmlspecialchars($_POST['idinsumo'],ENT_QUOTES,'UTF-8');
    $cantidad = htmlspecialchars($_POST['cantidad'],ENT_QUOTES,'UTF-8');

    $areglo_insumo = explode(",",$idinsumo);//se separan los datos del string
    $areglo_cantidad = explode(",",$cantidad);//se separan los datos del string

    for($i = 0;$i < count($areglo_insumo);$i++) {
        $consulta = $MH->Registrar_Detalle_Insumo($id,$areglo_insumo[$i],$areglo_cantidad[$i]);
    }

   

    echo ($consulta);


?>