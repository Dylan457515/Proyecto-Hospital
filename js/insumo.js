var tableinsumo;
function listar_insumo() {
    tableinsumo = $("#tabla_insumo").DataTable({
        "ordering": false,
        "paging": false,
        "searching": { "regex": true },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/insumo/controlador_insumo_listar.php",
            type: 'POST'
        },
        "order":[[1,'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "insumo_nombre" },
            { "data": "insumo_stock" },
            { "data": "insumo_feregistro" },
            { "data": "insumo_estatus",
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
    document.getElementById("tabla_insumo_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    tableinsumo.on( 'draw.dt', function () {
        var PageInfo = $('#tabla_insumo').DataTable().page.info();
        tableinsumo.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            } );
        } );

}

$('#tabla_insumo').on('click', '.editar', function () {
    var data = tableinsumo.row($(this).parents('tr')).data(); //detecta a que fila ho click y me captura los datos en la variable data
    if (tableinsumo.row(this).child.isShown()) { //cuando esta en tamaño de celualar ase funciar el codigo anterior
        var data = tableinsumo.row(this).data();
    }

    $('#modal_editar').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_editar').modal('show');
    $("#txt_idinsumo").val(data.insumo_id);
    $("#txt_insumo_actual_editar").val(data.insumo_nombre);
    $("#txt_insumo_nuevo_editar").val(data.insumo_nombre);
    $("#txt_Stock_editar").val(data.insumo_stock);
    $("#cbm_estatus_editar").val(data.insumo_estatus).trigger("change");

})

function AbrirModalRegistro(){
    $('#modal_registro').modal({ backdrop: 'static', Keyboard: false });
    $('#modal_registro').modal('show');
}

function filterGlobal() {
    $('#tabla_insumo').DataTable().search(
        $('#global_filter').val(),
    ).draw();
}

function Registro_Insumo(){
    var insumo = $("#txt_insumo").val();
    var stock = $("#txt_Stock").val();
    var estatus = $("#cbm_estatus").val();
    if(stock < 0 ){
        return Swal.fire("Mensaje de advertencia","El stock no puede ser negativo","warning");
    }

    if(insumo.length == 0 || insumo.length == 0 || estatus.length == 0){
        return Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/insumo/controlador_insumo_registro.php",
        type: "POST",
        data: {
            in: insumo,
            st: stock,
            es: estatus,
        }
    }).done(function(resp){
        if(resp > 0){
            if(resp == 1){
                $('#modal_registro').modal('hide');
                listar_insumo();
                LimpiarCompos();
                return Swal.fire("Mensaje de Confirmación","Datos guardados correctamente, insumo registrado","success");
            }else{
                LimpiarCompos();
                return Swal.fire("Mensaje de Advertencia","El insumo ya existe en nuestra data","warning");
            }

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar el insumo","warning");
        }
    })
}

function LimpiarCompos(){
    $("#txt_insumo").val("");
    $("#txt_Stock").val("");
}


function ModificarInsumo(){
    var id = $("#txt_idinsumo").val();
    var insumoactual = $("#txt_insumo_actual_editar").val();
    var insumonuevo = $("#txt_insumo_nuevo_editar").val();
    var stock = $("#txt_Stock_editar").val();
    var estatus = $("#cbm_estatus_editar").val();
    if(stock < 0 ){
        Swal.fire("Mensaje de advertencia","El stock no puede ser negativo","warning");
    }

    if(stock.length == 0 || insumoactual.length == 0 || insumonuevo.length == 0|| estatus.length == 0){
        Swal.fire("Mensaje de advertencia","Todos los campos son obligatorios","warning");
    }
    $.ajax({
        "url": "../controlador/insumo/controlador_insumo_modificar.php",
        type: "POST",
        data: {
            id: id,
            inac: insumoactual,
            innu: insumonuevo,
            st: stock,
            es: estatus,
        }
    }).done(function(resp){
        if(resp > 0){
            if(resp == 1){
                $('#modal_editar').modal('hide');
                listar_insumo();
                return Swal.fire("Mensaje de Confirmación","Datos actualizados correctamente, insumo registrado","success");
            }else{
                LimpiarCompos();
                return Swal.fire("Mensaje de Advertencia","El insumo ya existe en nuestra data","warning");
            }

        }else{
            return Swal.fire("Mensaje de advertencia","No se pudo registrar el insumo","warning");
        }
    })
}





function Cargar_Gafico_Insumos() {
    $.ajax({
        url: "../controlador/insumo/controlador_grafica_insumo.php",
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
            CrearGrafico(titulo, cantidad, colores, 'pie', 'Grafico en baras horisontal', 'StadisticasInsumos');
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