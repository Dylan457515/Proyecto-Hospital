<?php
    require '../../modelo/modelo_medico.php';

    $MM = new Modelo_Medico();

    $consulta = $MM->lista_conbo_especialidad();

    echo json_encode($consulta);


?>