<?php
    require '../../modelo/modelo_especialidad.php';

    $ME = new Modelo_Especialidad();

    $especialidad = htmlspecialchars($_POST['espe'],ENT_QUOTES,'UTF-8');
    $estatus = htmlspecialchars($_POST['es'], ENT_QUOTES,'UTF-8');

    $consulta = $ME->Registrar_Especialidad($especialidad,$estatus);

    echo $consulta;

?>