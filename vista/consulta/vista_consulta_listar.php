<script type="text/javascript" src="../js/consulta.js?rev=<?php echo time(); ?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">MANTENIMIENTO DE CONSULTA MEDICA</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="col-lg-4">
                    <label for="">Fecha inicio</label>
                    <input type="date" name="" id="txt_fechainicio" class="form-control"><br><br>
                </div>
                <div class="col-lg-4">
                    <label for="">Fecha fin</label>
                    <input type="date" name="" id="txt_fechafin" class="form-control"><br><br>
                </div>
                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-success" style="width: 100%;" onclick="listar_consulta()"><i class="glyphicon glyphicon-search"></i>Buscar</button><br><br>
                </div>
                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-danger" style="width: 100%;" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>Nuevo registro</button><br><br>
                </div>
            </div><br><br>
            <table id="tabla_consulta_medica" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nro Documento</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Estatus</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nro Documento</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Estatus</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div class="modal fade" id="modal_registro" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center;">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" ><b>Registro de Consulta Medica</b></h4>
            </div>
            <div class="modal-body">
            <div class="col-lg-12">
                    <label for="">Paciente</label>
                    <select class="js-example-basic-single" name="state" id="cbm_paciente_consulta" style="width: 100%;">
                    </select><br>

                </div>
                <div class="row">

                    <div class="col-lg-12"><br>
                        <label for="">Descirpci&oacute;n</label>
                        <textarea id="txt_descripcion_consulta"  rows="3" class="form-control" style="resize:none"></textarea>
                    </div>

                    <div class="col-lg-12"><br>
                        <label for="">Diagnostico</label>
                        <textarea id="txt_diagnostico_consulta"  rows="3" class="form-control" style="resize:none"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Registrar_Consulta()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal_editar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center;">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" ><b>Editar Consulta Medica</b></h4>
            </div>
            <div class="modal-body">
            <div class="col-lg-12">
                    <input type="text" id="txt_consulta_id" hidden>

                    <label for="">Paciente</label>
                    <input type="text" id="txt_paciente_consulta_editar" disabled class="form-control"><br><br>

                </div>
                <div class="row">

                    <div class="col-lg-12"><br>
                        <label for="">Descirpci&oacute;n</label>
                        <textarea id="txt_descripcion_consulta_editar"  rows="3" class="form-control" style="resize:none"></textarea>
                    </div>

                    <div class="col-lg-12"><br>
                        <label for="">Diagnostico</label>
                        <textarea id="txt_diagnostico_consulta_editar"  rows="3" class="form-control" style="resize:none"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Editar_Consulta()"><i class="fa fa-check"><b>&nbsp;Editar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        var n = new Date();
        var y = n.getFullYear();
        var m = n.getMonth() + 1;
        var d = n.getDate();
        if(d<10){
            d = "0"+d;
        }
        if(m<10){
            m = "0"+m;
        }


        document.getElementById("txt_fechainicio").value = y+"-"+m+"-"+d;
        document.getElementById("txt_fechafin").value = y+"-"+m+"-"+d;


        $("#modal_registro").on('shown.bs.modal', function() {
            $("#txt_especialidad").focus();
        })
        listar_consulta();
        listar_paciente_conbo_consulta();
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