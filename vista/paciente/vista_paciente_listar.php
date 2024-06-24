<script type="text/javascript" src="../js/paciente.js?rev=<?php echo time(); ?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">MANTENIMIENTO DE PACIENTES</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-danger" style="width: 100%;" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>Nuevo registro</button>
                </div>
            </div>
            <table id="tabla_paciente" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nro Doc</th>
                        <th>Paciente</th>
                        <th>Direcci&oacute;n</th>
                        <th>sexo</th>
                        <th>Celular</th>
                        <th>Estatus</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nro Doc</th>
                        <th>Paciente</th>
                        <th>Direcci&oacute;n</th>
                        <th>sexo</th>
                        <th>Celular</th>
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
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Registro de Paciente</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="">Nro Documento</label>
                        <input type="text" class="form-control" id="txt_ndoc" placeholder="Ingrese Nro Documento" onkeypress="return soloNumeros(event)" maxlength="8"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" id="txt_nombres" placeholder="Ingrese nombre" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Apellido Paterno</label>
                        <input type="text" class="form-control" id="txt_apepat" placeholder="Ingrese Apellido Paterno" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Apellido Materno</label>
                        <input type="text" class="form-control" id="txt_apemat" placeholder="Ingrese Apellido Materno" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Direcci&oacute;n</label>
                        <input type="text" class="form-control" id="txt_direccion" placeholder="Ingrese direccion"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Movil</label>
                        <input type="text" class="form-control" id="txt_movil" placeholder="Ingrese direccion" onkeypress="return soloNumeros(event)" maxlength="8"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">sexo</label>
                        <select class="js-example-basic-single" name="state" id="cbm_sexo" style="width: 100%;">
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select><br><br>
                    </div>

                    <div class="col-lg-12"></div>

                    



                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Registrar_Paciente()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_editar" role="dialog">
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Editar Paciente</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" id="txt_idpaciente" hidden>
                    <div class="col-lg-6">
                        <label for="">Nro Documento</label>
                        <input type="text" id="txt_ndoc_actual_editar" placeholder="Ingrese Nro Documento" onkeypress="return soloNumeros(event)" hidden><br>
                        <input type="text" class="form-control" id="txt_ndoc_nuevo_editar" placeholder="Ingrese Nro Documento" onkeypress="return soloNumeros(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" id="txt_nombres_editar" placeholder="Ingrese nombre" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Apellido Paterno</label>
                        <input type="text" class="form-control" id="txt_apepat_editar" placeholder="Ingrese Apellido Paterno" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Apellido Materno</label>
                        <input type="text" class="form-control" id="txt_apemat_editar" placeholder="Ingrese Apellido Materno" maxlength="50" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Direcci&oacute;n</label>
                        <input type="text" class="form-control" id="txt_direccion_editar" placeholder="Ingrese direccion" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Movil</label>
                        <input type="text" class="form-control" id="txt_movil_editar" placeholder="Ingrese direccion" onkeypress="return soloNumeros(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">sexo</label>
                        <select class="js-example-basic-single" name="state" id="cbm_sexo_editar" style="width: 100%;">
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select><br><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="">Estatus</label>
                        <select class="js-example-basic-single" name="state" id="cbm_estatus" style="width: 100%;">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select><br><br>
                    </div>

                    <div class="col-lg-12"></div>

                    



                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Modificar_Paciente()"><i class="fa fa-check"><b>&nbsp;Modificar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        listar_paciente();
        $('.js-example-basic-single').select2();
        $("#modal_registro").on('shown.bs.modal', function() {
            $("#txt_ndoc").focus();
        })

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