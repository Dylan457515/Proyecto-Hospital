<?php
    require '../../modelo/modelo_especialidad.php';

    $ME = new Modelo_Especialidad();

    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $especialidadactual = htmlspecialchars($_POST['espact'], ENT_QUOTES,'UTF-8');
    $especialidadnuevo = htmlspecialchars($_POST['espnue'], ENT_QUOTES,'UTF-8');
    $estatus = htmlspecialchars($_POST['es'], ENT_QUOTES,'UTF-8');

    $consulta = $ME->Modificar_Insumo($id,$especialidadactual,$especialidadnuevo,$estatus);

    echo $consulta;

?>