<?php
#incluye encabezado
include '../includes/top.php';?>
<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container cont-principal">
        <div class="row">
            <!-- form: -->
            <section>
                <div class="page-header">
                     <h2 class="title">Asignación de chequera</h1>
                </div>
                 <div class="form-group hide">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger">
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors"></ul>
                            </div>
                        </div>
                <div class="col-lg-8 col-lg-offset-2">
                    <form id="defaultForm" method="post" class="form-horizontal" action="target.php">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Plaza:</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="Seleccione plaza y sociedad" onchange="busqueda()">
                                    <option value="">-- Seleccione plaza --</option>
                                     <?php while($plaza= $plazas->fetch_assoc())
                                {?>
                                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                <?php } ?>
                                </select>
                            </div>
                             <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                        </div>

                        <div class="form-group" id="rowSoc" style="display:none;">
                            <label class="col-lg-3 control-label">Sociedad:</label>
                             <div class="col-lg-5">
                                <select class="form-control" name="sociedad" id="cboSociedad">
                                    <option value="">-- Seleccione sociedad --</option>
                                    <option value="fr">Sociedad x</option>
                                    <option value="de">Sociedad y</option>
                                    <option value="it">Sociedad z</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Banco:</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="banco" data-bv-notempty data-bv-notempty-message="Seleccione el banco">
                                    <option value="">-- Seleccione banco --</option>
                                        <?php while($banco= $bancos->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $banco['idbancos']?>"><?php echo $banco['nombre']?> -- <?php echo $banco['cve_transfer']?></option>

                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-lg-3 control-label">Cuenta:</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="cuenta" id="cuenta" data-bv-notempty data-bv-notempty-message="La cuenta es requerida">
                                    <option value="">-- Seleccione cuenta --</option>
                                    <option value="fr">**** **** ***** 8595</option>
                                    <option value="de">**** **** ***** 6655</option>
                                    <option value="it">**** **** ***** 6932</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Responsable de la chequera:</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="responsable" id="responsable"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Puesto responsable:</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="resp_puesto" id="resp_puesto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Fecha asignación:</label>
                            <div class="col-lg-5">
                                <input type="date" class="form-control" placeholder="click para ver calendario" name="fecha_asig" id="fecha_asig"  data-bv-notempty data-bv-notempty-message="La fecha es requerida" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">No.chequera:</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="website" placeholder="folio" />
                            </div>
                            <label class="col-lg-1 control-label">cheques:</label>
                            <div class="col-lg-2">
                                <input type="number" class="form-control" name="no_cheques" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Cheque inicial:</label>
                            <div class="col-lg-2">
                                <input type="number" class="form-control" name="cheque_ini" />
                            </div>
                            <label class="col-lg-1 control-label">final:</label>
                            <div class="col-lg-2">
                                <input type="number" class="form-control" name="cheque_fin" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Estado</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="estado" id="estado" data-bv-notempty data-bv-notempty-message="Seleccione el estado de la chequera">
                                    <option value="">-- Seleccione estado --</option>
                                    <option value="1">Activa</option>
                                    <option value="2">Cancelada</option>
                                    <option value="3">Bloqueada</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-4">
                            <br>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>  Guardar chequera</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- :form -->
        </div>
    </div>
<script type="text/javascript">

    function busqueda(){ 
       $("#rowSoc").hide('fast');
       $('#loader').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboSociedad").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader').hide();
               $("#rowSoc").show('fast');
               $("#cboSociedad").html($databack);
        
            }
        })
    }; 
    //validador de formulario
$(document).ready(function() {
    $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                responsable: {
                    validators: {
                        notEmpty: {
                            message: 'El responsable es requerido'
                        }
                    }
                }
                ,
                resp_puesto: {
                    validators: {
                        notEmpty: {
                            message: 'El puesto del responsable es requerido'
                        }
                    }
                }
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors');
            }
            $('#errors').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors').find('li[data-bv-for="' + data.field + '"]').remove();
        })
        .on('success.form.bv', function(e) {
            $('#errors')
                .html('')
                .parents('.form-group').addClass('hide');
        });


                
        $('#fecha_asig').datepicker({
            format: "dd/mm/yyyy"
        });  
    
    });
</script>
<?php
#incluye pie
include '../includes/footer.php';
?>