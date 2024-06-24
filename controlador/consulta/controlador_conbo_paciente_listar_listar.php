<?php
    require '../../modelo/modelo_consulta.php';

    $MC = new Modelo_Consulta();

    $consulta = $MC->lista_conbo_paciente();

    echo json_encode($consulta);


?>