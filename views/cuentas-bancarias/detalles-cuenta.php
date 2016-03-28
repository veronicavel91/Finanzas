    <?php

#incluye encabezado
?><link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container cont-principal">
<div class="row">
    <section>
        <div class="col-lg-12">
                <h3 class="title text-center" style="font-family: 'Open Sans', sans-serif;font-weight:400;"><i class="fa fa-credit-card"></i>  Detalles de la cuenta</h3>
                <a href="#" class="btn btn-warning pull-right btn-xs"><i class="fa fa-eye-slash" onclick="detalles()"></i></a>
             <?php while($dato= $datos->fetch_assoc())
            {?>
            <div class="col-lg-9 col-lg-offset-1" id="general" style="display:none;">
                 <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th> </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><i class="fa fa-credit-card"></i>  No.Cuenta:</strong></td>
                        <td><?php echo $dato['num_cuenta'] ?></td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-info-circle"></i>  Tipo de cuenta:</strong></td>
                        <td><?php echo $dato['tipo_cuenta'] ?></td>
                    </tr>
                      <tr>
                        <td><strong><i class="fa fa-gear"></i>  Operación:</strong></td>
                        <td><?php echo $dato['tipo_operacion'] ?></td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-key"></i>
  Clabe interbancaria:</strong></td>
                        <td><?php echo $dato['clabe'] ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-university"></i>
   Banco:</strong></td>
                        <td><?php echo $dato['banco'] ?></td>
                    </tr>
                     </tbody>
            </table>
            </div>
            <div class="col-lg-9 col-lg-offset-1" id="detalles-cuenta">
                <input type="hidden" id="id_cta" value="<?php echo $dato['idcuenta']?>">
                <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th> </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><i class="fa fa-credit-card"></i>  No.Cuenta:</strong></td>
                        <td><?php echo $dato['num_cuenta'] ?></td>
                    </tr>
                      <tr>
                        <td><strong><i class="fa fa-info-circle"></i>  Tipo de cuenta:</strong></td>
                        <td><?php echo $dato['tipo_cuenta'] ?></td>
                    </tr>
                      <tr>
                        <td><strong><i class="fa fa-gear"></i>  Operación:</strong></td>
                        <td><?php echo $dato['tipo_operacion'] ?></td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-key"></i>
  Clabe interbancaria:</strong></td>
                        <td><?php echo $dato['clabe'] ?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-university"></i>
   Banco:</strong></td>
                        <td><?php echo $dato['banco'] ?></td>
                    </tr>
                     <tr>
                     <input type="hidden" value="<?php echo $dato['idplaza'] ?>" id="plaza">
                     <input type="hidden" value="<?php echo $dato['idsociedad'] ?>" id="soc">
                        <td><strong><i class="fa fa-suitcase"></i>  Empresa:</strong></td>
                        <td><strong>Plaza:</strong> <?php echo $dato['Plaza'] ?><br><strong>Sociedad:</strong><?php echo $dato['razonsocial'] ?></td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-sitemap"></i>
  Sucursal:</strong></td>
                        <td><?php echo $dato['sucursal']." - ".$dato['suc_nombre'] ?></td><br>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-home"></i>  Domicilio actual:</strong></td>
                        <td><?php echo "<strong>".$dato['domicilio']."</strong><br><strong>Colonia:</strong>".$dato['colonia']."<br><strong>Municipio:</strong> ".$dato['delegacionmunicipio']."<br><strong>Estado:</strong> ".$dato['estado']."<br><strong>Ciudad:</strong> ".$dato['ciudad'] ?>
                         <button class="btn btn-info btn-xs pull-right" onclick="cambiarDom()"><i class="fa fa-home"></i>
  Cambiar domicilio</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-calendar"></i>  Fecha de apertura:</strong></td>
                        <td><?php $f_ap=date("d/m/Y", strtotime($dato['fecha_apertura'])); echo $f_ap;?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-user"></i>  Usuario cuenta:</strong></td>
                        <td><?php echo $dato['usuario_cta'];
                        if($dato['plaza_usuario'] != ""){?>
                        <br><strong>Plaza:</strong><?php echo $dato['plaza_usuario'];}?><br>
                        <?php if($dato['usuario_soc'] != ""){?>
                            <strong>Sociedad:</strong><?php echo $dato['usuario_soc'];}?>
                        <button class="btn btn-primary btn-xs pull-right" data-target="#modalUsuario" data-toggle="modal"><i class="fa fa-user"></i>
                            Cambiar usuario</button>
                        </td>
                    </tr>
                     <tr>
                     <?php if($dato['tipo_resp']==1) 
                        {
                            $tipo="Empleado";
                        }
                        elseif($dato['tipo_resp']==2)
                            {
                                $tipo="Cliente";
                            }
                            else {
                                {
                                    $tipo="";
                                }
                            }?>

                        <td><strong><i class="fa fa-male"></i>  Responsable actual:</strong></td>
                        <td><strong>Nombre: </strong><?php echo $dato['responsable']?><strong><br>Rol:</strong><?php echo $tipo ?><br><strong>Fecha alta:</strong><?php $f_resp=date("d/m/Y", strtotime($dato['fecha_resp'])); echo $f_resp;?><strong>  Captura:</strong><?php echo $dato['crea_resp']?>
                          <button class="btn btn-info btn-xs pull-right" data-target="#modalResp" data-toggle="modal"><i class="fa fa-male"></i>
  Cambiar responsable</button>
  </td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-file-text"></i>
  No.contrato:</strong></td>
                        <td><?php echo $dato['no_contrato']?><br>
                        <strong>No.cliente: </strong><?php echo $dato['no_cliente']?><br>
                        <strong>Contrato nomina: </strong><?php echo $dato['contrato_nomina']?></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-money"></i><strong>  Saldo inicial:</strong></td>
                        <td><?php echo $dato['saldo_inicial']."-".$dato['moneda']?></td>
                    </tr>
                    <tr>
                        <td><strong><i class="fa fa-bar-chart"></i>
   Estado actual:</strong></td>
                        <?php $f_his=date("d/m/Y", strtotime($dato['f_his']));
                        $mod = date('d/m/Y H:i:s', strtotime($dato['crea_his']));   ?>
                        <td><input type="hidden" id="id_edo" value="<?php echo $dato['idstatus_cuenta']?>">
                        <input type="hidden" id="status_nom" value="<?php echo $dato['status_cuenta']?>">
                        <?php echo "<h3><strong>".$dato['status_cuenta']."</strong></h3>
                        <strong>Folio:</strong>".$dato['folio']."<br><strong>Fecha status:</strong> ".$f_his."<br><strong>Modificación:</strong> ".$mod."<br><strong>Observaciones:</strong>".$dato['obs_his']?>
                        <button class="btn btn-primary btn-xs pull-right" onclick="cambiaEstado()"><i class="fa fa-cog"></i>
  Cambiar estado</button>
                        </td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-clock-o"></i>  Captura:</strong></td>
                        <td><?php $captura = date('d/m/Y H:i:s', strtotime($dato['created_at'])); 
                        echo $captura?></td>
                    </tr>
                     <tr>
                        <td><strong><i class="fa fa-pencil"></i>  Ult.modificación:</strong></td>
                        <td><?php $ult_mod = date('d/m/Y H:i:s', strtotime($dato['updated_at']));
                        echo $ult_mod?></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <!-- <td><a class="btn btn-primary btn-sm pull-right" href="#"><i class="fa fa-pencil"></i> Editar datos generales</a></td> -->
                    </tr>
                </tbody>
            </table>

                <?php } //fin de while datos ?>
            </div>
            <!-- tabs de datos de tablas-->
              <div class="col-lg-12">
                    <br>
                    <ul class="nav nav-tabs">
                        <li class="active tab-title"><a href="#responsable-tab" class="tab-title" data-toggle="tab">Responsable <i class="fa"></i></a></li>
                        <li><a href="#firmante-tab" class="tab-title" data-toggle="tab">Firmantes <i class="fa"></i></a></li>
                        <li><a href="#chequera-tab" class="tab-title" data-toggle="tab">Historial chequera <i class="fa"></i></a></li>
                      <li><a href="#token-tab" class="tab-title" data-toggle="tab">Token <i class="fa"></i></a></li>
                      <li><a href="#preguntas-tab" class="tab-title" data-toggle="tab">Preguntas secretas<i class="fa"></i></a></li>
                      <li><a href="#historial-tab" class="tab-title" data-toggle="tab">Historial de status<i class="fa"></i></a></li>
                       <li><a href="#domicilio-tab" class="tab-title" data-toggle="tab">Historial domicilio<i class="fa"></i></a></li>
                    </ul>
                        <div class="tab-content">
                        <br>
                         <div class="tab-pane active" id="responsable-tab">

                                <div class="col-lg-12">
                                    <table id="table-responsable"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- chequera-tab -->
                            <div class="tab-pane" id="chequera-tab">
                                <div class="col-lg-12">
                                       <button class="btn btn-info pull-left addButton" onclick="agrega_cheq()" data-template="textbox"><i class="fa fa-money"></i>  Agregar chequera</button>
                                    <table id="chequeras-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- token-tab -->
                            <div class="tab-pane" id="token-tab">
                                <div class="col-lg-12">
                                  <button class="btn btn-primary pull-left addButton" onclick="modalToken()" data-template="textbox"><i class="fa fa-plus"></i>  Agregar token</button>
                                    <table id="token-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- token-tab -->
                             <div class="tab-pane" id="preguntas-tab">
                               <button class="btn btn-success pull-left addButton" onclick="modalPreg()" data-template="textbox"><i class="fa fa-question-circle"></i>
  Agregar pregunta</button>

                                <div class="col-lg-12">
                                    <table id="preguntas-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- preguntas-tab -->
                              <div class="tab-pane" id="firmante-tab">
                               <button class="btn btn-warning pull-left addButton" onclick="modalFirm()" data-template="textbox"><i class="fa fa-male"></i>  Agregar firmante</button>

                                <div class="col-lg-12">
                                    <table id="firmantes-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- firmante-tab -->
                              <div class="tab-pane" id="historial-tab">
                                <div class="col-lg-12">
                                    <table id="historial-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- historial-tab -->
                             <div class="tab-pane" id="domicilio-tab">
                                <div class="col-lg-12">
                                    <table id="historial-domicilios"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                                </div>
                            </div> <!-- preguntas-tab -->
                        </div> <!-- tab-content -->
          
    </div>
</div>

         <div class="modal fade" id="modalEdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-credit-card"></i>
 Cambiar estado de la cuenta </h4>
                    </div>
                    <div class="modal-body">
                    <form name="form-edo-cta" id="form-edo-cta" method="post" class="form-horizontal">
                        <div id="datos">
                          <div class="form-group hide">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger">
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors_edo_cta"></ul>
                            </div>
                        </div>
                        <div class="form-group row">
                            <h4 class="col-lg-4 control-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="text" class="form-control input-md" id="nom_edo" disabled="true">
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h5 class="col-lg-4 control-label"style="color:#277551;margin-top:-3px;font-weight:bold;">Nuevo estado:</h5>
                            <div class="col-lg-5">
                                <select name="Edo" id="Edo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                       <?php while($edo= $edos->fetch_assoc())
                                    {?>
                                       <option value="<?php echo $edo['idstatus_cuenta']?>"><?php echo $edo['nombre']?></option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row" >
                              <div class="col-md-12" >
                              <div class="group">
                                        <label class="col-lg-1 col-lg-offset-1 control-label">Folio:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="folio" id="folio">
                                            <span style="font-size:11px;color:#9F9F9F;">*Solo en el caso de bloqueo y cancelación*</span>
                                        </div>
                                        </div>
                                        <div class="group">
                                            <label class="col-md-2">Fecha:</label>
                                            <div class="col-md-4" >
                                                <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="fecha_bloq" id="fecha_bloq" >
                                            </div>
                                        </div>
                                </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-md-3 col-lg-offset-1">Observaciones:</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="obs_edo" id="obs_edo"></textarea>
                                </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <!-- <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="actualiza_estado()" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button> -->
  <button type="submit" class="btn btn-info btn-hover-green" data-action="save" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button>
                        </div>
                    </div>
                    <div id="btnok" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta()" role="button">Aceptar</button>
                    </div>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

 <div class="modal fade" id="modalDom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-home"></i>
 Cambiar domicilio </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_dom">
                        <div class="form-group row">
                           <label for="" class="col-lg-2 control-label">Domicilio:</label>
                            <div class="col-lg-8">

                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboDom" id="cboDom">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-lg-2 control-label">Periodo del:</label>
                    <div class="col-lg-4 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="periodo_del" id="periodo_del" placeholder="aaaa-mm-dd" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                    <label  class="col-lg-1 control-label">al:</label>
                    <div class="col-lg-4 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="periodo_al" id="periodo_al" placeholder="aaaa-mm-dd" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                        </div>
                            
                        </div> <!-- /datos -->
                         <div id="load_dom" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_dom" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El domicilio ha sido actualizado correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_dom" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="update_dom()" role="button"><i class="fa fa-refresh"></i>
  Actualizar domicilio</button>
                        </div>
                    </div>
                    <div id="btnok_dom" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_dom()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<div class="modal fade" id="modalCheq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form name="form-cheq" id="form-cheq" method="post" class="form-horizontal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>
 Cambiar chequera </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group hide" id="errores_chequera">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger" >
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors_cheq"></ul>
                            </div>
                        </div>
                        <div id="datos_cheq">
                        <div class="form-group row">
                        <div class="group">
                            <label for="" class="col-lg-1 control-label">Folio:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="folio_cheq" name="folio_cheq">
                            </div>
                        </div>
                        <div class="group">
                            <label for="" class="col-lg-2 control-label">Asignación:</label>
                             <div class="col-lg-5 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="fecha_cheq" id="fecha_cheq" placeholder="dd/mm/aaaa" data-bv-group=".group" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Responsable:</label>
                            <div class="col-lg-8">
                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboResp" id="cboResp">
                                  <option value="">-- Seleccione responsable --</option>
                                  <?php while($empleado= $empleados->fetch_assoc())
                                            {
                                                echo '<option  value="'.$empleado['Id_empleado'].' ">'.$empleado['nombre_emp'].'</option>'; 
                                             } ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-lg-3 control-label">No.cheques:</label>
                                <div class="col-lg-5">
                                    <input type="number" class="form-control" name="no_cheques" id="no_cheques" />
                                </div>
                        </div>
                          <div class="form-group row">
                          <div class="group">
                            <label class="col-lg-3 control-label">Cheque inicial:</label>
                            <div class="col-lg-3">
                                <input type="number" class="form-control" name="cheque_inicial" id="cheque_inicial"  />
                            </div>
                        </div>
                        <div class="group">
                            <label class="col-lg-2 control-label">Cheque final:</label>
                            <div class="col-lg-3">
                                <input type="number" class="form-control" name="cheque_final" id="cheque_final" bv-group=".group"  />
                            </div>
                        </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label">Observaciones:</label>
                            <div class="col-lg-8">
                                <textarea name="" id="obs_cheque" class="form-control"></textarea>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_cheq" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_cheq" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡La chequera se guardo correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_cheq" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" role="button"><i class="fa fa-save"></i>
  Guardar chequera</button>
                        </div>
                    </div>
                    <div id="btnok_cheq" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_cheq()" role="button">Aceptar</button>
                    </div>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modalResp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-male"></i>
 Cambiar responsable de cuenta </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_resp">
                         <div class="form-group row">
                                 <label class="col-lg-3 control-label">Tipo responsable:</label>
                                    <div class="col-lg-4">
                                        <select name="tipo_resp" id="tipo_resp" class="form-control" >
                                            <option value="">-- Seleccione tipo --</option>
                                            <option value="1">Empleado</option>
                                            <option value="2">Cliente</option>
                                        </select>
                                    </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 control-label">Plaza:</label>
                                <div class="col-lg-7">
                                   <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-default" data-size="10" data-width="100%" name="plazaResp" id="plazaResp" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda_soc_resp()">
                                        <option value="">-- Seleccione plaza --</option>
                                        <?php while($p_resp= $p_responsables->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $p_resp['idplaza']?>"><?php echo $p_resp['plaza']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-1" id="loader_resp" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 control-label">Sociedad:</label>
                                <div class="col-lg-7" id="rowSoc">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-default" data-size="10" data-width="100%" name="soc_resp" id="soc_resp" onChange="responsable()"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                             <label class="col-lg-3 control-label">Responsable:</label>
                                    <div class="col-lg-1" id="load" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                                    <div class="col-lg-7">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="resp_cta" id="resp_cta" class="form-control"></select>
                                    </div>
                                    <div class="col-lg-1" id="load_tipo" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>

                                </div>
                        <div class="form-group row">
                             <label class="col-lg-3 control-label">Asignación:</label>
                                   <div class="col-lg-4 date">
                                        <div class="input-group input-append date" id="fecha_asig">
                                            <input type="text" class="form-control" name="asg_resp" id="asg_resp" placeholder="dd-mm-aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_resp" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_resp" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El responsable se modifico correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_resp" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="actualiza_responsable()" role="button"><i class="fa fa-save"></i>
  Actualizar responsable</button>
                        </div>
                    </div>
                    <div id="btnok_resp" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_resp()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
                <div class="modal fade" id="modalFirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>
 Agregar firmante </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_fir">
                            <div class="form-group row">
                                <label class="col-lg-2 control-label">Plaza:</label>
                                <div class="col-lg-7">
                                   <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-default" data-size="10" data-width="100%" name="plazaFirm" id="plazaFirm" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda_soc_firm()">
                                        <option value="">-- Seleccione plaza --</option>
                                        <?php while($p_fir= $p_firms->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $p_fir['idplaza']?>"><?php echo $p_fir['plaza']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-1" id="loader_firm" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-2">Sociedad:</label>
                                <div class="col-lg-7" id="rowSoc">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-default" data-size="10" data-width="100%" name="sociedad_firm" id="sociedad_firm"></select>
                                </div>
                            </div>
                             <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Firmante:</label>
                            <div class="col-lg-7">
                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboFirm" id="cboFirm">
                                  <option value="">-- Seleccione responsable --</option>
                                  <?php while($emp= $firmantes_cta->fetch_assoc())
                                            {
                                                echo '<option  value="'.$emp['Id_empleado'].'">'.$emp['nombre_emp'].'</option>'; 
                                             } ?>

                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_fir" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_fir" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El firmante se agrego correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_fir" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_firm()" role="button"><i class="fa fa-save"></i>
  Guardar firmante</button>
                        </div>
                    </div>
                    <div id="btnok_firm" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_resp()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
          <div class="modal fade" id="modalPreg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-question-circle"></i>

 Agregar pregunta </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_preg">
                             <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Pregunta:</label>
                           <div class="col-lg-8">
                                                <textarea name="preg" id="preg" cols="1" rows="1" class="form-control"></textarea>
                                            </div>    
                        </div>
                        <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Respuesta:</label>
                           <div class="col-lg-8">
                                                <textarea name="resp_preg" id="resp_preg" cols="1" rows="1" class="form-control"></textarea>
                                            </div>    
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_preg" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_fir" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El firmante se agrego correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_fir" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_preg()" role="button"><i class="fa fa-save"></i>
  Guardar pregunta</button>
                        </div>
                    </div>
                    <div id="btnok_firm" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_resp()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
                <div class="modal fade" id="modalPreg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>
 Agregar firmante </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_preg">
                             <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Pregunta:</label>
                           <div class="col-lg-8">
                                                <textarea name="preg" id="preg" cols="1" rows="1" class="form-control"></textarea>
                                            </div>    
                        </div>
                        <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Respuesta:</label>
                           <div class="col-lg-8">
                                                <textarea name="resp_preg" id="resp_preg" cols="1" rows="1" class="form-control"></textarea>
                                            </div>    
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_preg" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_fir" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El firmante se agrego correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_fir" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_preg()" role="button"><i class="fa fa-save"></i>
  Guardar pregunta</button>
                        </div>
                    </div>
                    <div id="btnok_firm" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_resp()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modalEdita-chequera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i>
Editar chequera </h4>
                    </div>
                    <div class="modal-body">
                        <form name="form-edita-cheq" id="form-edita-cheq" method="post" class="form-horizontal">
                         <div class="form-group hide" id="errores_edita_cheque">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger" >
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors_edita_cheq"></ul>
                            </div>
                        </div>
                        <div id="datos_cheq">
                        <div class="form-group row">
                        <div class="group">
                            <label for="" class="col-lg-1 control-label">Folio:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cheq_folio" id="cheq_folio">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" disabled="true" id="cheq_id">
                        <div class="group">
                            <label for="" class="col-lg-2 control-label">Asignación:</label>
                             <div class="col-lg-5 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="cheq_fecha" id="cheq_fecha" data-bv-group=".group" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Responsable:</label>
                            <div class="col-lg-8">
                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cheq_resp" id="cheq_resp">
                                  <?php while($empleado= $responsables->fetch_assoc())
                                            {
                                                echo '<option  value="'.$empleado['Id_empleado'].'">'.$empleado['nombre_emp'].'</option>'; 
                                             } ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-lg-2 control-label">No.cheques:</label>
                                <div class="col-lg-4">
                                    <input type="number" class="form-control" name="cheq_num" id="cheq_num" />
                                </div>
                        </div>
                          <div class="form-group row">
                                    <label class="col-lg-3 control-label">Cheque inicial:</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" name="cheq_ini" id="cheq_ini"  />
                                    </div>
                                    <label class="col-lg-2 control-label">Cheque final:</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" name="cheq_fin" id="cheq_fin"  />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 control-label">Observaciones:</label>
                                    <div class="col-lg-8">
                                        <textarea name="cheq_obs" id="cheq_obs" class="form-control"></textarea>
                                    </div>
                                </div>
                       
                            
                        </div> <!-- /datos -->
                         <div id="load_edit_cheq" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_cheq" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡La chequera se guardo correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_cheq" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" role="button"><i class="fa fa-refresh"></i>
  Actualizar datos</button>
                        </div>
                    </div>
                    <div id="btnok_cheq" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_cheq()" role="button">Aceptar</button>
                    </div>
                    </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
                   <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-user"></i>  Cambiar usuario de la cuenta </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_us">
                                      <div class="form-group row">
                                <label class="col-lg-2 control-label">Plaza:</label>
                                <div class="col-lg-7">
                                   <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-default" data-size="10" data-width="100%" name="plazaUs" id="plazaUs" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda_soc_us()">
                                        <option value="">-- Seleccione plaza --</option>
                                        <?php while($p_us= $plaza_us->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $p_us['idplaza']?>"><?php echo $p_us['plaza']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-1" id="loader_plaza_us" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-2">Sociedad:</label>
                                <div class="col-lg-7" id="rowSoc">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-default" data-size="10" data-width="100%" name="sociedadUs" id="sociedadUs"></select>
                                </div>
                            </div>
                             <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Usuario:</label>
                            <div class="col-lg-7">
                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboUs" id="cboUs">
                                  <option value="">-- Seleccione responsable --</option>
                                  <?php while($user= $usuarios->fetch_assoc())
                                            {
                                                echo '<option  value="'.$user['Id_empleado'].'">'.$user['nombre_emp'].'</option>'; 
                                             } ?>

                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_us" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok_fir" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El usuario se agrego correctamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_us" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_usuario()" role="button"><i class="fa fa-save"></i>
  Guardar usuario</button>
                        </div>
                    </div>
                    <div id="btnok_us" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta_resp()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modalEdo-Chequera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>
 Cambiar estado de la chequera </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                        <input type="hidden" class="form-control" id="id_chequera" disabled="true">
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="text" class="form-control input-md" id="actual_cheq" disabled="true">
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-4 col-lg-offset-1" style="color:#277551">Nuevo estado:</h4>
                            <div class="col-lg-5" style="margin-left:-30px;">
                                <select name="nuevo_edo" id="nuevo_edo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                       <?php while($e= $edos_cheq->fetch_assoc())
                                    {?>
                                       <option value="<?php echo $e['idstatus_chequera']?>"><?php echo $e['nombre']?></option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="loading_edo" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoChequera()" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button>
                        </div>
                    </div>
                    <div id="btnok" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modalEdoFirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-male"></i>
 Cambiar estado del firmante </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <input type="hidden" id="firm_id">
                            <input type="text" style="display:none;" id="edo_firm_nombre">
                        <div class="form-group row">
                            <h4 class="col-lg-4 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                              <h3 id="edo_firm" style="margin-top:-2px;"></h3>
                            </div>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-4 col-lg-offset-1 contol-label" style="color:#19766E;margin-top:-3px;">Nuevo estado:</h4>
                            <div class="col-lg-6" style="margin-left:-30px;">
                                <select name="edo_firm_nvo" id="edo_firm_nvo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                <option value="1">Activar</option>
                                <option value="0">Cancelar</option>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_firm" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoFirmante()" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button>
                        </div>
                    </div>
                    <div id="btnok" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
           <div class="modal fade" id="modalEdoPreg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-male"></i>
 Cambiar estado de la pregunta </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <input type="hidden" id="preg_id">
                            <input type="text" style="display:none;" id="edo_id_preg">
                            <div class="col-lg-5">
                              <h3 id="edo_preg" style="margin-top:-2px;"></h3>
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-4 col-lg-offset-1" style="color:#277551;margin-top:-3px;">Nuevo estado:</h4>
                            <div class="col-lg-5" style="margin-left:-30px;">
                                <select name="edo_preg_nvo" id="edo_preg_nvo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                <option value="1">Activar</option>
                                <option value="0">Cancelar</option>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_preg" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoPregunta()" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button>
                        </div>
                    </div>
                    <div id="btnok" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modalToken" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>
 Registrar token </h4>
                    </div>
                    <div class="modal-body">
                        <form name="form-token" id="form-token" method="post" class="form-horizontal">
                         <div class="form-group hide" id="errores_token">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger" >
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors_token"></ul>
                            </div>
                        </div>
                        <div id="datos_token">
                       <div class="form-group row">
                                    <label class="col-lg-3 control-label">Codigo/no.serie:</label>
                                    <div class="col-lg-6">
                                       <input type="text" name="cod_token" id="cod_token" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 control-label">Asignación:</label>
                                   <div class="col-lg-5 date">
                                        <div class="input-group input-append date" id="fecha_token">
                                            <input type="text" class="form-control" name="f_token" id="f_token" placeholder="dd/mm/aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group row">
                               <label for="" class="col-lg-2 control-label">Responsable:</label>
                                    <div class="col-lg-7">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="resp_token" id="resp_token">
                                          <option value="">-- Seleccione responsable --</option>
                                          <?php while($p= $personal->fetch_assoc())
                                                    {
                                                        echo '<option  value="'.$p['Id_empleado'].'">'.$p['nombre_emp'].'</option>'; 
                                                     } ?>

                                        </select>
                                    </div>
                            </div>
                                 <div class="form-group row">
                                    <div class="group">
                                        <label class="col-lg-3 control-label">¿Tiene vencimiento?</label>
                                        <div class="col-lg-3">
                                            <select name="vence" id="vence" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label class="col-lg-2 control-label">Vencimiento aprox:</label>
                                          <div class="col-lg-4 date">
                                            <div class="input-group input-append date" id="fecha_vence">
                                                <input type="text" class="form-control" name="f_vence" id="f_vence" placeholder="dd/mm/aaaa" data-bv-group=".group"/>
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                   <div class="form-group row">
                                    <label class="col-lg-2 control-label">Comentarios:</label>
                                    <div class="col-lg-9">
                                       <textarea name="obs_token" id="obs_token" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">Estado:</label>
                                    <div class="col-lg-4">
                                      <select name="status_token" id="status_token" class="form-control">
                                          <?php while($s_tok= $status_token->fetch_assoc())
                                            {?>
                                               <option value="<?php echo $s_tok['idstatus_token']?>"><?php echo $s_tok['nombre']?></option>

                                            <?php } ?>
                                      </select>
                                      <br><br>
                                    </div>
                                </div>
                        </div> <!-- /datos -->
                          <div id="load_token" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons_token" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" role="button"><i class="fa fa-save"></i>
  Guardar token</button>
                        </div>
                    </div>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
          <div class="modal fade" id="modalEdoToken" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-male"></i>
 Cambiar estado al token </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <input type="hidden" id="token_id">
                            <input type="text" style="display:none;" id="edo_id_tok">
                            <div class="col-lg-5">
                              <h3 id="edo_token" style="margin-top:-2px;"></h3>
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-4 col-lg-offset-1" style="color:#277551;margin-top:-3px;">Nuevo estado:</h4>
                            <div class="col-lg-5" style="margin-left:-30px;">
                                <select name="edo_tok_nvo" id="edo_tok_nvo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                              <?php while($e_tok= $edo_tok->fetch_assoc())
                                            {?>
                                               <option value="<?php echo $e_tok['idstatus_token']?>"><?php echo $e_tok['nombre']?></option>

                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_preg" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoToken()" role="button"><i class="fa fa-refresh"></i>
  Actualizar estado</button>
                        </div>
                    </div>
                    <div id="btnok" style="display:none;">
                         <button type="button" class="btn btn-default" onclick="acepta()" role="button">Aceptar</button>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- Modal que muestra los correos -->
          <div class="modal fade" id="modalEmails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" 
   data-keyboard="false">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <h4 class="modal-title"><i class="fa fa-envelope"></i>  Envio de correo de cambio de estado cuenta</h4><span>(El correo se enviará a las personas seleccionadas, informandoles sobre el nuevo estado de la cuenta.)</span>
                    </div>
                    <div class="modal-body">
                    <div class="col-lg-12">
                          <div class="form-group row">
                        <label class="col-lg-1 control-label">Plaza:</label>
                        <div class="col-lg-4">
                           <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="auto" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
                                <option value="">-- Seleccione plaza --</option>
                                <?php while($plaza= $plazas->fetch_assoc())
                                {?>
                                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                        <label class="control-label col-md-1">Sociedad:</label>
                         <div class="col-lg-5" id="rowSoc">
                         <div class="col-lg-10">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad"></select>
                          </div>
                          <div class="col-lg-2">
                            <button class="btn btn-primary" onclick="muestra_emails()"><i class="fa fa-search"></i>  Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2">Texto adicional:</label>
                        <div class="col-lg-8">
                            <textarea name="correo_texto" class="form-control" id="correo_texto" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                          <div id="mail_loading" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/sendingMail.gif"><strong>Enviando correo de cambio de estado de la cuenta, espere un momento...</strong>
                            <br><br>
                        </div>
                    </div>
                    </div>

                    <br><br>
                        <table  id="emails-table"
                           data-toggle="table"
                           data-toolbar="#toolbar"
                           data-height="499" data-search="true"
                           data-click-to-select="true"
                           data-url='ajax.php?c=email&f=muestra_emails'>
                            <thead>
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id">Id</th>
                                <th data-field="nombre_emp">Empleado</th>
                                <th data-field="email">Email</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                         <div class="btn-group btn-group-justified" role="group" id="buttons-mail" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="envia_mail()" role="button"><i class="fa fa-paper-plane"></i>
  Enviar correo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        </div>
<script src="./js/detalle_cuenta.js"></script>
