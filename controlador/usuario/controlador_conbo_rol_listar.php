<?php
    require '../../modelo/modelo_usuario.php';

    $MU = new Modelo_Usuario();

    $consulta = $MU->lista_conbo_rol();

    echo json_encode($consulta);


?>