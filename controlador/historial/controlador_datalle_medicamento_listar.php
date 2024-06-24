<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $idfua = htmlspecialchars($_POST['idfua'],ENT_QUOTES,'UTF-8');

    $consulta = $MH->lista_detalle_medicamento($idfua);

    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';

    }

?>