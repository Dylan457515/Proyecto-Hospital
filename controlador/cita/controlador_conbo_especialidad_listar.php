<?php
    require '../../modelo/modelo_cita.php';

    $MC = new Modelo_Cita();

    $consulta = $MC->lista_conbo_especialidad();

    echo json_encode($consulta);


?>