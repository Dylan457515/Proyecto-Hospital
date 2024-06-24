<script type="text/javascript" src="../js/historial.js?rev=<?php echo time(); ?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">MANTENIMIENTO DE REGISTRO DE HISTORIAL CLINICO</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-lg-2">
                <label for="">c&oacute;digo hisotrial</label>
                <input type="text" class="form-control" id="txt_codigo_historial" disabled>

            </div>
            <div class="col-lg-8">
                <label for="">Paciente</label>
                <input type="text" id="txt_paciente" class="form-control" disabled>
            </div>
            <div class="col-lg-2">
                <label for="">&nbsp;</label><br>
                <button class="btn btn-success" onclick="AbrirModalConsulta()"><i class="fa fa-search">Buscar Consulta</i></button>
            </div>
            <div class="col-lg-6"><br>
                <label for="">Descripci&oacute;n de la consulta</label>
                <textarea name="" id="txt_desconsulta" cols="30" rows="3" disabled class="form-control"></textarea>
            </div>
            <div class="col-lg-6"><br>
                <label for="">Diagnostico de la consulta</label>
                <textarea name="" id="txt_diagconsulta" cols="30" rows="3" disabled class="form-control"></textarea>
            </div>
            <input type="text" id="txt_idconsulta" hidden>



            <div class="col-md-12"><br>
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Procedimiento</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Insumo</a></li>
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Medicamento</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-lg-10">
                                    <label for="">Seleciona Procedimientos</label>
                                    <select class="js-example-basic-single" name="state" id="cbm_procedimiento" style="width: 100%;">

                                    </select>

                                </div>
                                <div class="col-lg-2">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-primary" style="width: 100%;" onclick="Agregar_Procedimiento()"><i class="fa fa-plus-square">&nbsp;Agregar</i></button>
                                </div>
                                <div class="col-lg-12 table-responsive"><br>
                                    <table id="tabla_procedimiento" style="width: 100%;" class="table">
                                        <thead bgcolor="black" style="color:#FFFFFF;">
                                            <th>ID</th>
                                            <th>Procedimiento</th>
                                            <th>Acci&oacute;n</th>
                                        </thead>
                                        <tbody id="tbody_tabla_procedimiento">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Seleciona Insumo</label>
                                    <select class="js-example-basic-single" name="state" id="cbm_insumos" style="width: 100%;">

                                    </select>

                                </div>
                                <div class="col-lg-2">
                                    <label for="">Stock Actual</label>
                                    <input type="text" class="form-control" id="stock_insumo" disabled>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Cantidad Agregar</label>
                                    <input type="text" class="form-control" id="txt_cantidad_agregar">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-primary" style="width: 100%;"><i class="fa fa-plus-square" onclick="Agregar_Insumo()">&nbsp;Agregar</i></button>
                                </div>

                                <div class="col-lg-12 table-responsive"><br>
                                    <table id="tabla_insumo" style="width: 100%;" class="table">
                                        <thead bgcolor="black" style="color:#FFFFFF;">
                                            <th>ID</th>
                                            <th>Insumo</th>
                                            <th>Cantidad</th>
                                            <th>Acci&oacute;n</th>
                                        </thead>
                                        <tbody id="tbody_tabla_insumo">

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Seleciona Medicamento</label>
                                    <select class="js-example-basic-single" name="state" id="cbm_medicamento" style="width: 100%;">

                                    </select>

                                </div>
                                <div class="col-lg-2">
                                    <label for="">Stock Actual</label>
                                    <input type="text" class="form-control" id="stock_medicamento" disabled>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Cantidad Agregar</label>
                                    <input type="text" class="form-control" id="txt_medicamento_cantidad_agregar">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-primary" style="width: 100%;"><i class="fa fa-plus-square" onclick="Agregar_Medicamento()">&nbsp;Agregar</i></button>
                                </div>

                                <div class="col-lg-12 table-responsive"><br>
                                    <table id="tabla_medicamento" style="width: 100%;" class="table">
                                        <thead bgcolor="black" style="color:#FFFFFF;">
                                            <th>ID</th>
                                            <th>Medicamento</th>
                                            <th>Cantidad</th>
                                            <th>Acci&oacute;n</th>
                                        </thead>
                                        <tbody id="tbody_tabla_medicamento">

                                        </tbody>
                                    </table>
                                </div>



                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>

            <div class="col-lg-12" style="text-align:center">
                <button class="btn btn-success btn-lg" onclick="Registrar_Historial()">REGISTRAR</button>
            </div>



        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div class="modal fade" id="modal_consulta" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Listados de Consultas Medicas</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table id="tabla_consulta_historial" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>C&oacute;digo Historial</th>
                                    <th>Paciente</th>
                                    <th>Acci&oacute;n</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        listar_insumo();
        listar_procedimiento();
        listar_medicamento();
    });

    $("#cbm_medicamento").on("change", function() {
        var id = $("#cbm_medicamento").val();
        TraerStockMedicamento(id);
    });

    $("#cbm_insumos").on("change", function() {
        var idIN = $("#cbm_insumos").val();
        TraerStockInsumo(idIN);
    });



    $('.box').boxWidget({
        Animation: 500,
        collapseTrigger: '[data-widget="collapse"]',
        removeTrigger: '[data-widget="remove"]',
        collapseIcon: 'fa-minus',
        expandIcon: 'fa-plus',
        removeIcon: 'fa-times'
    })
</script>