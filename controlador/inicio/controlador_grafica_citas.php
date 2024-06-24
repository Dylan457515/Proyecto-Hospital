<?php
    require '../../modelo/modelo_inicio.php';

    $MI = new Modelo_Inicio();

    $consulta = $MI->Grafica_Cita();

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