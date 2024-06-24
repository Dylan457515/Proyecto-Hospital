var tablemedicamento;
function listar_medicamento() {
    tablemedicamento = $("#tabla_medicamento").DataTable({
        "ordering": false,
        "paging": false,
        "searching": { "regex": true },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/medicamento/controlador_medicamento_listar.php",
            type: 'POST'
        },
        "order":[[1,'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "medicamento_nombre" },
            { "data": "medicamento_alias" },
            { "data": "medicamento_stock" },
            { "data": "medicamento_fregistro" },

            { "data": "medicamento_estatus",
            render: function (data, type, row) {
                if (data == 'ACTIVO') {
                    return "<span class='label label-success'>" + data + "</span>";
                }
                if(data == 'INACTIVO') {
                return "<span class='label label-danger'>" + data + "</span>";
                }
                if(data == 'AGOTADO') {
                    return "<span class='label label-black' style = 'background:black'>" + data + "</span>";
                }
        }},
            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_medicamento_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    tablemedicamento.on( 'draw.dt', function () {
        var PageInfo = $('#tabla_medicamento').DataTable().page.info();
        tablemedicamento.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            } );
        } );

}

function AbrirModalRegistro(){
    $('#modal_registro').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_registro').modal('show');
}

function Registro_Medicamentos(){
    var medicamento = $("#txt_medicamento").val();
    var alias = $("#txt_Alias").val();
    var stock = $("#txt_Stock").val();
    var estatus = $("#cbm_estatus").val();
    if(stock < 0 ){
        return Swal.fire("Mensaje de advertencia","El stock no puede ser negativo","warning");
    }

    if(medicamento.length == 0 || alias.length == 0 || stock.length == 0 || estatus.length == 0){
        Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/medicamento/controlador_medicamento_registro.php",
        type: "POST",
        data: {
            med: medicamento,
            al: alias,
            st: stock,
            es: estatus,
        }
    }).done(function(resp){

        if(resp > 0){
            if(resp == 1){
                $('#modal_registro').modal('hide');
                listar_medicamento();
                LimpiarCompos();
                return Swal.fire("Mensaje de Confirmación","Datos guardados correctamente, medicamento registrado","success");
            }else{
                LimpiarCompos();
                return Swal.fire("Mensaje de Advertencia","El medicamento ya existe en nuestra data","warning");
            }

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar el medicamento","warning");
        }
    })
}

function filterGlobal() {
    $('#tabla_medicamento').DataTable().search(
        $('#global_filter').val(),
    ).draw();
}

function LimpiarCompos(){
    $("#txt_medicamento").val("");
    $("#txt_Alias").val("");
    $("#txt_Stock").val("");
}

$('#tabla_medicamento').on('click', '.editar', function () {
    var data = tablemedicamento.row($(this).parents('tr')).data();
    if (tablemedicamento.row(this).child.isShown()) {
        var data = tablemedicamento.row(this).data();
    }

    $('#modal_editar').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_editar').modal('show');

    $('#txtidmedicamento').val(data.medicamento_id);
    $('#txt_medicamento_actual_editar').val(data.medicamento_nombre);
    $('#txt_medicamento_nuevo_editar').val(data.medicamento_nombre);
    $('#txt_Alias_editar').val(data.medicamento_alias);
    $('#txt_Stock_editar').val(data.medicamento_stock);
    $('#cbm_estatus_editar').val(data.medicamento_estatus).trigger("change");

})

function Modificar_Medicamento(){
    var id = $("#txtidmedicamento").val();
    var medicamentoactual = $("#txt_medicamento_actual_editar").val();
    var medicamentonuevo = $("#txt_medicamento_nuevo_editar").val();
    var alias = $("#txt_Alias_editar").val();
    var stock = $("#txt_Stock_editar").val();
    var estatus = $("#cbm_estatus_editar").val();
    if(stock < 0 ){
        return Swal.fire("Mensaje de advertencia","El stock no puede ser negativo","warning");
    }

    if(stock.length == 0 || medicamentoactual.length == 0 || medicamentonuevo.length == 0|| estatus.length == 0 || alias.length == 0){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/medicamento/controlador_medicamento_modificar.php",
        type: "POST",
        data: {
            id: id,
            medac: medicamentoactual,
            mednu: medicamentonuevo,
            al: alias,
            st: stock,
            es: estatus,
        }
    }).done(function(resp){

        if(resp > 0){
            if(resp == 1){
                $('#modal_editar').modal('hide');
                listar_medicamento();
                return Swal.fire("Mensaje de Confirmación","Datos actualizados correctamente, medicamento registrado","success");
            }else{
                LimpiarCompos();
                return Swal.fire("Mensaje de Advertencia","El medicamento ya existe en nuestra data","warning");
            }

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar el medicamento","warning");
        }
    })

}






function Cargar_Gafico_Medicamento() {
    $.ajax({
        url: "../controlador/medicamento/controlador_grafica_medicamento.php",
        type: "POST"
    }).done(function(resp) {
      if (resp.length > 0) {
            var titulo = [];
            var cantidad = [];
            var colores = [];
            var data = JSON.parse(resp);
            for (var i = 0; i < data.length; i++) {
                titulo.push(data[i][0]);
                cantidad.push(data[i][1]);
                colores.push(colorRGB());
            }
            CrearGrafico(titulo, cantidad, colores, 'pie', 'Grafico de medicamento', 'StadisticasMedicamentos');
        }

    })
}


function CrearGrafico(titulo, cantidad, colores, tipo, encabezado, id) {
    var ctx = document.getElementById(id);
    var myChart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: titulo,
            datasets: [{
                label: encabezado,
                data: cantidad,
                backgroundColor: colores,
                borderColor: colores,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}


function generarNumero(numero) {
    return (Math.random() * numero).toFixed(0);
}

function colorRGB() {
    var coolor = "(" + generarNumero(255) + "," + generarNumero(255) + "," + generarNumero(255) + ")";
    return "rgb" + coolor;
}