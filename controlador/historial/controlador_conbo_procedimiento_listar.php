<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $consulta = $MH->lista_conbo_procedimiento();

    echo json_encode($consulta);


?>