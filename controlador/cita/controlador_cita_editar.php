<?php
    require '../../modelo/modelo_cita.php';

    $MC = new Modelo_Cita();

    $idcita = htmlspecialchars($_POST['idcita'],ENT_QUOTES,'UTF-8');
    $idpaciente = htmlspecialchars($_POST['idpa'],ENT_QUOTES,'UTF-8');
    $iddoctor = htmlspecialchars($_POST['iddoc'], ENT_QUOTES,'UTF-8');
    $descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES,'UTF-8');
    $idespecialidad = htmlspecialchars($_POST['idespecialidad'], ENT_QUOTES,'UTF-8');
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES,'UTF-8');

    $consulta = $MC->Editar_Cita($idcita,$idespecialidad,$idpaciente,$iddoctor,$descripcion,$status);

    echo $consulta;

?>