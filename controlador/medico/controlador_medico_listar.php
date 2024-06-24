<?php
    require '../../modelo/modelo_medico.php';

    $MM = new Modelo_Medico();

    $consulta = $MM->lista_medico();

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