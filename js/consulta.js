
var tableconsulta;

function listar_consulta() {
    var fechainicio = $("#txt_fechainicio").val();
    var fechafin = $("#txt_fechafin").val();
    tableconsulta = $("#tabla_consulta_medica").DataTable({
        "ordering": false,
        "paging": true,
        "searching": { "regex": true },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/consulta/controlador_consulta_listar.php",
            type: 'POST',
            data:{
                fechainicio : fechainicio,
                fechafin : fechafin
            }
        },
        "order":[[1,'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "paciente_nrodocumento" },
            { "data": "paciente" },
            { "data": "consulta_feregistro" },
            { "data": "medico" },
            { "data": "especialidad_nombre" },
            { "data": "consulta_estatus",
            render: function (data, type, row) {
                if (data == 'PENDIENTE') {
                    return "<span class='label label-primary'>" + data + "</span>";
                }else if(data == 'CANCELADA') {
                return "<span class='label label-danger'>" + data + "</span>";
                }else {
                    return "<span class='label label-success'>" + data + "</span>";
                }
        }},
            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary' title='ed&iacute;tar'><i class='fa fa-edit'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });


    tableconsulta.on( 'draw.dt', function () {
        var PageInfo = $('#tabla_consulta_medica').DataTable().page.info();
        tableconsulta.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            } );
        } );

}


$('#tabla_consulta_medica').on('click', '.editar', function () {
    var data = tableconsulta.row($(this).parents('tr')).data(); //detecta a que fila ho click y me captura los datos en la variable data
    if (tableconsulta.row(this).child.isShown()) { //cuando esta en tamaño de celualar ase funciar el codigo anterior
        var data = tableconsulta.row(this).data();
    }

    $('#modal_editar').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_editar').modal('show');

    $("#txt_consulta_id").val(data.consulta_id);
    $("#txt_paciente_consulta_editar").val(data.paciente);
    $("#txt_descripcion_consulta_editar").val(data.consulta_descripcion);
    $("#txt_diagnostico_consulta_editar").val(data.consulta_diagnostico);



})


function listar_paciente_conbo_consulta() {
    $.ajax({
        "url": "../controlador/consulta/controlador_conbo_paciente_listar_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>Nro de atencio: " + data[i][1] + " - Paciente: "+ data[i][2] +"</option>";

            }
            $("#cbm_paciente_consulta").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_paciente_consulta").html(cadena);

        }
    })
}


function Registrar_Consulta(){
    var idpaciente = $("#cbm_paciente_consulta").val();
    var descripcion = $("#txt_descripcion_consulta").val();
    var diagnostico = $("#txt_diagnostico_consulta").val();



    if(idpaciente.length == 0 || descripcion.length == 0 || diagnostico.length == 0 ){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/consulta/controlador_consulta_registro.php",
        type: "POST",
        data: {
            idpa: idpaciente,
            descripcion: descripcion,
            diagnostico: diagnostico,

        }
    }).done(function(resp){
        if(resp > 0){
            $('#modal_registro').modal('hide');
            listar_consulta();
            return Swal.fire("Mensaje de Confirmaci\u00F3n","Consulta registrada","success");

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar la cita","warning");
        }
    })
}


function Editar_Consulta(){
    var idconsulta = $("#txt_consulta_id").val();
    var descripcion = $("#txt_descripcion_consulta_editar").val();
    var diagnostico = $("#txt_diagnostico_consulta_editar").val();



    if(idconsulta.length == 0 || descripcion.length == 0 || diagnostico.length == 0 ){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/consulta/controlador_consulta_editar.php",
        type: "POST",
        data: {
            idco: idconsulta,
            descripcion: descripcion,
            diagnostico: diagnostico,

        }
    }).done(function(resp){
        alert(resp);
        if(resp > 0){
            $('#modal_editar').modal('hide');
            listar_consulta();
            return Swal.fire("Mensaje de Confirmaci\u00F3n","Datos actualizados","success");

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar la cita","warning");
        }
    })
}


