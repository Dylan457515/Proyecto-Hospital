<?php
session_start();
if (!isset($_SESSION['S_IDUSUARIO'])) {
  header('Location: ../../../Login/index.php');
}
?>

<?php

require_once __DIR__ . '/../vendor/autoload.php';


require_once '../../../conexion_reportes/r_conexion.php';

$consulta = "SELECT
	consulta.consulta_descripcion, 
	consulta.consulta_diagnostico, 
	paciente.paciente_nombre, 
	paciente.paciente_apepat, 
	paciente.paciente_apemat, 
	paciente.paciente_direccion, 
	paciente.paciente_movil, 
	paciente.paciente_sexo, 
	paciente.paciente_nrodocumento, 
	especialidad.especialidad_nombre, 
	fua.fua_id, 
	cita.cita_descripcion, 
	cita.cita_id, 
	medico.medico_nombre, 
	medico.medico_apepat, 
	medico.medico_apemat
FROM
	fua
	INNER JOIN
	consulta
	ON 
		fua.consulta_id = consulta.consulta_id
	INNER JOIN
	cita
	ON 
		consulta.cita_id = cita.cita_id
	INNER JOIN
	paciente
	ON 
		cita.paciente_id = paciente.paciente_id
	INNER JOIN
	especialidad
	ON 
		cita.especialidad_id = especialidad.especialidad_id
	INNER JOIN
	medico
	ON 
		cita.medico_id = medico.medico_id
        
    WHERE fua.fua_id = '".$_GET['id']."'";

    $resultado = $mysqli -> query($consulta);
    while($row = $resultado -> fetch_assoc()){
        $html = '<html lang="es"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <div style="text-align:center"><h1><u>REPORTE DEL HISTORIAL MEDICO</u></h1></div>
        <div style="float:left;width:120px">
            <span><b>DNI: </b>'.$row['paciente_nrodocumento'].'</span>
        </div>
        
        <div style="float:left;width:400px">
            <span><b>PACIENTE: </b>'.html_entity_decode($row['paciente_nombre']).' '.html_entity_decode($row['paciente_apepat']).' '.html_entity_decode($row['paciente_apemat']).'</span>
        </div>

        <div style="float:right;width:100px">
            <span><b>SEXO: </b>'.$row['paciente_sexo'].'</span>
        </div><br><br>
        <div style="width:600px">
            <span><b>Direcci&oacute;n: </b>'.html_entity_decode($row['paciente_direccion']).'</span>
        </div>

        <div style="width:700px; text-align:center">
            <h2><u>DATOS DE LA CITA:</u></h2>
        </div>
        <div style="float:left;width:120px">
            <span><b>Nro cita: </b></span> '.$row['cita_id'].'
        </div>
        <div style="float:left;width:280">
            <span><b>MEDICO: </b>'.html_entity_decode($row['medico_nombre']).' '.html_entity_decode($row['medico_apepat']).' '.html_entity_decode($row['medico_apemat']).'</span>
        </div>

        <div style="float:right;width:250px">
            <span><b>Especialidad: </b>'.html_entity_decode($row['especialidad_nombre']).'</span>
        </div><br>

        <div style="width:600px"><br>
            <span><b>Descripcion de la Cita: </b><br>'.html_entity_decode($row['cita_descripcion']).'</span>
        </div>

        

        <div style="width:700px; text-align:center">
            <h2><u>DATOS DE LA CONSULTA MEDICA:</u></h2>
        </div>

        <div style="width:600px"><br>
            <span><b>Descripcion de la Consulta: </b><br>'.html_entity_decode($row['consulta_descripcion']).'</span>
        </div>
        <div style="width:600px"><br>
            <span><b>Diagnostico de la Consulta: </b><br>'.html_entity_decode($row['consulta_diagnostico']).'</span>
        </div>


        <div style="width:700px; text-align:center">
            <h2><u>MEDICAMENTOS</u></h2>
        </div>
        <table style="width:100%; border-collapse:collapse" border="1">
            <thead>
                <tr bgcolor="#C0C0C0">
                    <th>#</th>
                    <th>Medicamento</th>
                    <th>Cantidad</th>
                </tr>
            </thead>';
            

            $consultaMedicamento = " SELECT
                                        medicamento.medicamento_nombre,
                                        detalle_medicamento.detame_catidad
                                    FROM
                                        detalle_medicamento
                                    INNER JOIN
                                        medicamento
                                        ON 
		                                detalle_medicamento.medicamento_id = medicamento.medicamento_id where detalle_medicamento.fua_id = '".$_GET['id']."'";

            $resultadoMedicamento = $mysqli -> query($consultaMedicamento);
            $contadorMedicamento = 0;
            while($rowMedicamento = $resultadoMedicamento -> fetch_assoc()){
                $contadorMedicamento++;

                $html.= '<tr>
                            <td style="text-align:center">'.$contadorMedicamento.'</td>
                            <td style="text-align:center">'.html_entity_decode($rowMedicamento['medicamento_nombre']).'</td>
                            <td style="text-align:center">'.html_entity_decode($rowMedicamento['detame_catidad']).'</td>
                        ';
            }
            $html.='</tr>
                <tbody>

            </tbody>
        </table>


        <div style="width:700px; text-align:center">
            <h2><u>INSUMOS</u></h2>
        </div>
        <table style="width:100%; border-collapse:collapse" border="1">
            <thead>
                <tr bgcolor="#C0C0C0">
                    <th>#</th>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>

        ';

            $consultaInsumo = " SELECT
                                        insumo.insumo_nombre,
                                        detalle_insumo.detain_cantidad
                                    FROM
                                        detalle_insumo
                                        INNER JOIN
                                        insumo
                                        ON 
                                            detalle_insumo.insumo_id = insumo.insumo_id
                                            where detalle_insumo.fua_id = '".$_GET['id']."'";

            $resultadoInsumo = $mysqli -> query($consultaInsumo);
            $contadorInsumo = 0;
            while($rowInsumo = $resultadoInsumo -> fetch_assoc()){
                $contadorInsumo++;

                $html.= '<tr>
                            <td style="text-align:center">'.$contadorInsumo.'</td>
                            <td style="text-align:center">'.html_entity_decode($rowInsumo['insumo_nombre']).'</td>
                            <td style="text-align:center">'.html_entity_decode($rowInsumo['detain_cantidad']).'</td>
                        ';
            }
            $html.='</tr>
                <tbody>

            </tbody>
        </table>
        <div style="width:700px; text-align:center">
            <h2><u>PROCEDIMIENTOS</u></h2>
        </div>
        <table style="width:100%; border-collapse:collapse" border="1">
            <thead>
                <tr bgcolor="#C0C0C0">
                    <th>#</th>
                    <th>Procedimietno</th>
                </tr>
            </thead>

        ';
        $consultaProcedimiento = " SELECT
                                procedimiento.procedimiento_nombre
                            FROM
                                detalle_procedimiento
                                INNER JOIN
                                procedimiento
                                ON 
                                    detalle_procedimiento.procedimiento_id = procedimiento.procedimiento_id
                                            where detalle_procedimiento.fua_id = '".$_GET['id']."'";

            $resultadoProcedimiento = $mysqli -> query($consultaProcedimiento);
            $contadorProcedimiento = 0;
            while($rowProcedimiento = $resultadoProcedimiento -> fetch_assoc()){
                $contadorProcedimiento++;

                $html.= '<tr>
                            <td style="text-align:center">'.$contadorProcedimiento.'</td>
                            <td style="text-align:center">'.html_entity_decode($rowProcedimiento['procedimiento_nombre']).'</td>
                        ';
            }
            $html.='</tr>
                <tbody>

            </tbody>
        </table>';


    }

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();