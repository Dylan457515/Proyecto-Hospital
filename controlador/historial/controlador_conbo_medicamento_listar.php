<?php
    require '../../modelo/modelo_historial.php';

    $MH = new Modelo_Historial();

    $consulta = $MH->lista_conbo_medicamento();
    

    echo json_encode($consulta);


?>