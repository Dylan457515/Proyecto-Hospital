<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $consulta = $MH->lista_conbo_insumo();

    echo json_encode($consulta);


?>