var tablecita;

function listar_cita() {
    tablecita = $("#tabla_cita").DataTable({
        "ordering": false,
        "paging": false,
        "searching": { "regex": true },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/cita/controlador_cita_listar.php",
            type: 'POST'
        },
        "order":[[1,'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "cita_nroatencion" },
            { "data": "cita_feregistro" },
            { "data": "paciente" },
            { "data": "medico" },
            { "data": "cita_estatus",
            render: function (data, type, row) {
                if (data == 'PENDIENTE') {
                    return "<span class='label label-primary'>" + data + "</span>";
                }else if(data == 'CANCELADA') {
                return "<span class='label label-danger'>" + data + "</span>";
                }else {
                    return "<span class='label label-success'>" + data + "</span>";
                }
        }},
            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary' title='ed&iacute;tar'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='imprimir btn btn-success' title='imprimir'><i class='fa fa-print'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_cita_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    tablecita.on( 'draw.dt', function () {
        var PageInfo = $('#tabla_cita').DataTable().page.info();
        tablecita.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            } );
        } );

}


function listar_paciente_conbo() {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_paciente_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_paciente").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_paciente").html(cadena);

        }
    })
}

function listar_especialidad_conbo() {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_especialidad_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_especialidad").html(cadena);

            var id = $("#cbm_especialidad").val();
            listar_doctor_conbo(id);
        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_especialidad").html(cadena);
        }
    })
}

function listar_doctor_conbo(id) {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_doctor_listar.php",
        type: 'POST',
        data: {
            id: id
        }
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_doctor").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_doctor").html(cadena);
        }
    })
}

function Registrar_Cita(){
    var idpaciente = $("#cbm_paciente").val();
    var iddoctor = $("#cbm_doctor").val();
    var descripcion = $("#txt_descripcion").val();
    var idusuario = $("#txtidprincipal").val();
    var idespecialidad = $("#cbm_especialidad").val();


    if(idpaciente.length == 0 || iddoctor.length == 0 || descripcion.length == 0 || idespecialidad.length == 0){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/cita/controlador_cita_registro.php",
        type: "POST",
        data: {
            idpa: idpaciente,
            iddoc: iddoctor,
            descripcion: descripcion,
            idusuario: idusuario,
            idespecialidad: idespecialidad
        }
    }).done(function(resp){
        if(resp > 0){

            Swal.fire({
                title: "Datos correctamente, nueva cita registrada",
                text: "Datos de Confirmaci\u00F3n",
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Imprimir Ticket"
              }).then((result) => {
                if (result.isConfirmed) {
                  window.open("../vista/libreporte/reportes/generar_ticket.php?id="+parseInt(resp)+"#zoom=100%","Ticket","scrollbars=NO");
                }else{
                    $('#modal_registro').modal('hide');
                    listar_cita();
                }
              });

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar la cita","warning");
        }
    })
}

function filterGlobal() {
    $('#tabla_cita').DataTable().search(
        $('#global_filter').val(),
    ).draw();
}

$('#tabla_cita').on('click', '.editar', function () {
    var data = tablecita.row($(this).parents('tr')).data(); //detecta a que fila ho click y me captura los datos en la variable data
    if (tablecita.row(this).child.isShown()) { //cuando esta en tamaño de celualar ase funciar el codigo anterior
        var data = tablecita.row(this).data();
    }

    $('#modal_editar').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_editar').modal('show');

    $("#txt_cita_id").val(data.cita_id);
    $("#cbm_paciente_editar").val(data.paciente_id).trigger("change");
    $("#cbm_especialidad_editar").val(data.especialidad_id).trigger("change");
    listar_doctor_conbo_editar(data.especialidad_id,data.medico_id);

    $("#txt_descripcion_editar").val(data.cita_descripcion);


})


$('#tabla_cita').on('click', '.imprimir', function () {
    var data = tablecita.row($(this).parents('tr')).data(); //detecta a que fila ho click y me captura los datos en la variable data
    if (tablecita.row(this).child.isShown()) { //cuando esta en tamaño de celualar ase funciar el codigo anterior
        var data = tablecita.row(this).data();
    }

    window.open("../vista/libreporte/reportes/generar_ticket.php?id="+parseInt(data.cita_id)+"#zoom=100%","Ticket","scrollbars=NO");
})


function AbrirModalRegistro(){
    $('#modal_registro').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_registro').modal('show');
}


function Editar_cita(){
    var idcita = $("#txt_cita_id").val();
    var idpaciente = $("#cbm_paciente_editar").val();
    var iddoctor = $("#cbm_doctor_editar").val();
    var descripcion = $("#txt_descripcion_editar").val();
    var idespecialidad = $("#cbm_especialidad_editar").val();
    var status = $("#cbm_status").val();


    if(idcita.length == 0||idpaciente.length == 0 || iddoctor.length == 0 || descripcion.length == 0||idespecialidad.length == 0){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/cita/controlador_cita_editar.php",
        type: "POST",
        data: {
            idcita:idcita,
            idpa: idpaciente,
            iddoc: iddoctor,
            descripcion: descripcion,
            idespecialidad:idespecialidad,
            status:status
        }
    }).done(function(resp){
        if(resp > 0){

            Swal.fire({
                title: "Datos correctamente editado",
                text: "Datos de Confirmaci\u00F3n",
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Imprimir Ticket"
              }).then((result) => {
                tablecita.ajax.reload();
                if (result.isConfirmed) {
                  window.open("../vista/libreporte/reportes/generar_ticket.php?id="+parseInt(idcita)+"#zoom=100%","Ticket","scrollbars=NO");
                }else{
                    $('#modal_registro').modal('hide');
                    listar_cita();
                }
              });

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo editar la cita","warning");
        }
    })
}


function listar_paciente_conbo_editar() {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_paciente_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_paciente_editar").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_paciente_editar").html(cadena);

        }
    })
}

function listar_especialidad_conbo_editar() {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_especialidad_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_especialidad_editar").html(cadena);

            var id = $("#cbm_especialidad_editar").val();
            listar_doctor_conbo_editar(id);
        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_especialidad_editar").html(cadena);
        }
    })
}


function listar_doctor_conbo_editar(id,idmedico) {
    $.ajax({
        "url": "../controlador/cita/controlador_conbo_doctor_listar.php",
        type: 'POST',
        data: {
            id: id
        }
    }).done(function (resp) {
        var data = JSON.parse(resp)
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {

                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";

            }
            $("#cbm_doctor_editar").html(cadena);
            if(idmedico != ''){
                $("#cbm_doctor_editar").val(idmedico).trigger("change");
            }


        } else {
            cadena += "<option value=''>NO SE ENCONTRATON REGISTROS</option>";
            $("#cbm_doctor_editar").html(cadena);
        }
    })
}



