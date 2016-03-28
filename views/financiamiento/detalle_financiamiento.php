    <?php
#incluye encabezado
include '../includes/top.php';?>
<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container cont-principal">
<div class="row">
    <section>
        <div class="col-lg-12">
        <br>
                <h3 class="title text-center">Detalles financiamiento</h3>
            <div class="col-lg-10 col-lg-offset-1">
             
             <!-- datos generales del financiamiento -->
                <?php while($dato= $datos->fetch_assoc())
                {?>
                <input type="hidden" id="id_fin" value="<?php echo $dato['idfinanciamiento']?>">
                <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th> </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>No.financiamiento:</strong></td>
                        <td><?php echo $dato['idfinanciamiento'] ?></td>
                    </tr>
                    <tr>
                     </tr>
                    <tr>
                        <td><strong>Sociedad:</strong></td>
                        <td><?php echo $dato['razonsocial'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Cliente:</strong></td>
                        <td><?php echo $dato['cte'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Autorizador:</strong></td>
                        <td><?php echo $dato['nombre_aut']?></td>
                    </tr>
                    <tr>
                        <td><strong>Fecha Inicio:</strong></td>
                        <td><?php echo $dato['periodo_inicio']?></td>
                    </tr>
                     <tr>
                        <td><strong>Vencimiento:</strong></td>
                        <td><?php echo $dato['periodo_inicio']?></td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de captura:</strong></td>
                        <td><?php echo $dato['created_at']?></td>
                    </tr>
                     <tr>
                        <td><strong>Ultima modificación:</strong></td>
                        <td><?php echo $dato['updated_at']?></td>
                    </tr>
                    <tr>
                        <td><strong>Estado:</strong></td>
                        <td><?php $status=$dato['idstatus_financiado'];?>
                        <input type="hidden" id="id_edo" value="<?php echo $status?>">
                        <?php
                        switch ($status) {
                        case 1:
                            echo "<h3><span  class='label label-info label-lg'>".$dato['st_fin']."</label></h3>";
                        break;
                        case 2:
                            echo"<h3><span  class='label label-success'>".$dato['st_fin']."</span></h3>";
                        break;
                         case 3:
                            echo"<h3><span class='label label-danger'>".$dato['st_fin']."</span></h3>";
                        break;
                        case 4:
                            echo"<h3><span class='label label-warning'>".$dato['st_fin']."</span></h3>";
                        break;
                        case 5:
                            echo"<h3><span  class='label label-danger'>".$dato['st_fin']."</span></h3>";
                        break;
                        }
                        ?>
                        <input type="hidden" id="status_nom" value="<?php echo $dato['st_fin']?>">
                           <button class="btn btn-info btn-xs pull-right" onclick="cambiaEstado()"><i class="fa fa-cog"></i>
  Cambiar estado</button>
                        </td>

                    </tr>
                    <tr>
                        <td><strong>Observaciones:</strong></td>
                        <td><?php echo $dato['observaciones']?></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <!-- <td><a class="btn btn-primary btn-sm pull-right" href="#"><i class="fa fa-pencil"></i> Editar datos generales</a></td> -->
                    </tr>
                </tbody>
            </table>
                <?php } //fin de while datos ?>
            </div>
            <!-- tabla de los cheques del financiamiento -->
            <div class="col-lg-12">
             <br>
            <ul class="nav nav-tabs">
             <li class="active"><a href="#factura-tab" data-toggle="tab">Facturas <i class="fa"></i></a></li>
                <li><a href="#cheques-tab" data-toggle="tab">Cheques del cliente <i class="fa"></i></a></li>
                <li><a href="#promotor-tab" data-toggle="tab">Descuentos promotor <i class="fa"></i></a></li>
                <!--  <li><a href="#abono-tab" data-toggle="tab">  Abonos <i class="fa"></i></a></li> -->
            </ul>
                <div class="tab-content">
                <br>
                     <div class="tab-pane active" id="factura-tab">
                        <button class="btn btn-primary pull-left addButton" onclick="modalFactura()" data-template="textbox"><i class="fa fa-plus"></i>  Agregar factura</button>

    
                    <table id="facturas-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table>
                       
                        </div>
                    <div class="tab-pane" id="cheques-tab">
                    <label class="btn btn-info pull-left addButton" onclick="modalCheque()" data-template="textbox"><i class="fa fa-money"></i>  Agregar cheque</label>
            <table id="cheques-table" data-show-export="true"  data-locale="es-MX" data-show-toggle="true" ></table>
             </div>
                        <div class="tab-pane" id="promotor-tab">
                            <button class="btn btn-warning pull-left addButton" onclick="modalPromotor()" data-template="textbox"><i class="fa fa-male"></i>  Agregar descuento</button>
                            <!-- Tabla cheques del cliente -->
                          <table id="descuento-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true" data-row-style="rowStyle"></table> 
                        </div>
                        <div class="tab-pane" id="abono-tab">
                            <button class="btn btn-success pull-left addButton" onclick="modalAbono()" data-template="textbox"><i class="fa fa-male"></i>  Agregar abono</button>
                            <!-- Tabla cheques del cliente -->
                          <table id="abonos-table"  data-locale="es-MX" data-show-toggle="true" data-pagination="true"></table> 
                        </div>
                        <div class="form-group">
                            <br>
                            <h4 class="col-lg-2 col-lg-offset-2"><span class="label label-success">Importe depositado:</span></h4>
                            <div class="col-lg-3">
                             <div class="input-group">
                                  <span class="input-group-addon">$</span>
                               <input type="text" class="form-control input-lg" name="importe_dep" id="importe_dep" value="0" disabled="true" />
                            </div>
                            </div>
                             <h4 class="col-lg-2 "><span class="label label-danger">Importe financiado:</span></h4>
                             <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="text" class="form-control input-lg" name="importe_fin" id="importe_fin" value="0" disabled="true">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <br><br>
                            <h4 class="col-lg-2 col-lg-offset-2"><span class="label label-default">Descuento promotor:</span></h4>
                            <div class="col-lg-3">
                            <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                    <input type="text" class="form-control input-lg" name="tot_desc" id="tot_desc" value="0" disabled="true" />
                                </div>
                            </div>
                             <h4 class="col-lg-2"><span class="label label-info">Saldo final:</span></h4>
                            <div class="col-lg-3">
                            <div class="input-group">
                                  <span class="input-group-addon">$</span>
                               <input type="text" class="form-control input-lg" name="saldo_fact" id="saldo_fact" value="0" disabled="true" />
                            </div>
                            </div>
                        </div>
                        <br>
                    <div class="form-group">
                            <br>
                            <div class="col-lg-5 col-lg-offset-5">
                              <br><br><br>
                            </div>
                        </div>
                                    </form>
                </div>
            <br><br><br>
            </div>

        </div>
    </section>
<!-- modal agregar facturas -->
<div class="modal fade" id="agregar_factura" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-plus"></i>  Agregar factura</h3>
            </div>
            <div class="modal-body">
                <div id="datos-fact">
                    <!-- content goes here -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-lg-offset-1">Folio:</label>
                        <div class="col-lg-5">
                           <input type="text" class="form-control" name="folio_fact" id="folio_fact" placeholder="folio de la factura"/>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-lg-3 col-lg-offset-1">Fecha:</label>
                        <div class="col-lg-5">
                           <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_fact" id="fecha_fact" placeholder="aaaa-mm-dd" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-lg-offset-1">Importe:</label>
                        <div class="col-lg-5">
                           <input type="text" class="form-control" name="imp_fact" id="imp_fact" placeholder="$0"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-lg-offset-1">Estado:</label>
                        <div class="col-lg-5">
                          <select name="edo_fact" id="edo_fact" class="form-control">
                              <option value="">-- Estado de la factura --</option>
                               <?php while($st= $status_fact->fetch_assoc())
                                {?>
                                   <option value="<?php echo $st['idstatus_factura']?>"><?php echo $st['nombre']?></option>

                                <?php } ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-lg-offset-1">Observaciones:</label>
                        <div class="col-lg-7">
                           <textarea name="obser_fact" class="form-control" id="obser_fact"></textarea>
                        </div>
                    </div>
                </div>
                <div id="load-fact" style="display:none" class="col-md-10 col-md-offset-2">
                    <img src="./images/loader.gif">
                    <br><br>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons-fact" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton" onclick="guardarFactura()" data-template="textbox"><i class="fa fa-save"></i>  Guardar factura</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- modal agregar un cheque -->
<div class="modal fade" id="agregar_cheque" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-plus"></i>  Agregar cheque</h3>
            </div>
            <div class="modal-body">
                <div id="datos-cheque">
                    <!-- content goes here -->
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">No. cheque:</label>
                        <div class="col-lg-5">
                          <input type="text" class="form-control" id="no_cheque" name="no_cheque">
                        </div>
                    </div>
                    <div class="form-group row">
                         <label class="col-lg-3 control-label">Fecha del cheque:</label>
                          <div class="col-lg-4 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_cheque" id="fecha_cheque" placeholder="aaaa-mm-dd" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Sociedad del cheche:</label>
                        <div class="col-lg-7">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_cheque" id="soc_cheque">
                                <option value="">-- Seleccione sociedad --</option>
                               <?php while($sociedad= $sociedades->fetch_assoc())
                                {?>
                                   <option value="<?php echo $sociedad['idempresa']?>"><?php echo $sociedad['razonsocial']?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Estado:</label>
                        <div class="col-lg-5">
                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="edo_cheque" id="edo_cheque">
                                <option value="">-- Seleccione estado --</option>
                               <?php while($edo_cheque= $estados_cheque->fetch_assoc())
                                {?>
                                   <option value="<?php echo $edo_cheque['idstatus_cheque']?>"><?php echo $edo_cheque['nombre']?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Importe:$</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" id="imp_cheque" name="imp_cheque" value="0">
                        </div>
                    </div>
                    <div class="form-group row pop">
                        <label class="col-lg-3 control-label">Observaciones:</label>
                        <div class="col-lg-8" id="cont-textarea">
                        <textarea name="obs_cheque" id="obs_cheque" class="form-control" cols="3" rows="3"></textarea>
                            <br>
                        </div>
                    </div>
                    <div id="carga_cheque" style="display:none;" class="col-md-10 col-md-offset-2">
                        <img src="./images/loader.gif">
                        <br><br>
                    </div>
                    <div id="ok3" style="display:none;" class="alert alert-success">
                        <h3><i class="fa fa-check"></i>  El cheque ha sido agregado correctamente</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons3" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton" onclick="guardarCheque()" data-template="textbox"><i class="fa fa-save"></i>  Guardar cheque</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal descuento a promotor-->
<div class="modal fade" id="agregar_descuento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-minus"></i>  Agregar descuento</h3>
            </div>
            <div class="modal-body">
            <div class="datos-desc">
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Factura descuento:</label>
                    <div class="col-lg-6">
                        <!-- <input type="text" class="form-control" name="fact_desc" id="fact_desc" > -->
                      <select class="form-control" name="folio_desc" id="folio_desc">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Promotor:</label>
                    <div class="col-lg-7">
                        <select data-live-search="true" class="selectpicker show-menu-arrow"  data-size="10" data-width="100%" name="promotor" id="promotor" />
                            <option value="">-- seleccione persona --</option>
                            <?php while($per= $promotores->fetch_assoc())
                            {?>
                                <option value="<?php echo $per['Id_empleado']?>"><?php echo $per['nombre_emp']?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Descuento:</label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="importe_desc" id="importe_desc" placeholder="$0"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Estado:</label>
                    <div class="col-lg-5">
                        <select name="edo_desc" class="form-control" id="edo_desc">
                        <option value="">-- Selecione el estado --</option>
                            <?php while($edo = $status_desc->fetch_assoc())
                                {?>
                                   <option value="<?php echo $edo['idstatus_descuento']?>"><?php echo $edo['nombre']?></option>

                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Observaciones:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" name="obs_desc" id="obs_desc"></textarea>
                        <br>
                    </div>
                </div>
                </div>
                <div id="load-desc" style="display:none;" class="col-md-10 col-md-offset-2">
                    <img src="./images/loader.gif">
                    <br><br>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons-desc" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton" onclick="guardarDescuento()" data-template="textbox"><i class="fa fa-save"></i>  Guardar descuento</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="modal fade" id="modalRegresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-male"></i>  Pago de descuentos</h4>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" id="id_desc" name="id_desc">
                        <div class="form-group row">
                            <label for="" class="col-lg-2">Fecha:</label>
                             <div class="col-lg-4 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_reg" id="fecha_reg" placeholder="aaaa-mm-dd" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <label for="" class="col-lg-2">Importe:</label>
                        <div class="col-lg-4">
                            <input type="text" id="imp_reg" name="imp_reg" class="form-control">
                        </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-3">Observaciones:</label>
                            <div class="col-lg-6">
                                <textarea name="obs_reg" id="obs_reg" class="form-control" cols="3" rows="3"></textarea>
                            </div>
                            <div class="col-lg-1">
                                <br><br>
                                <button class="btn btn-success btn-sm" id="regresa" onclick="regresar()"><i class="fa fa-money"></i> Pagar</button>
                            </div>
                                <div class="col-lg-1" id="loader-modal" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>

                        </div>
                        <table id="table-regresa"
                               data-toggle="table"
                               data-height="399" 
                               data-url="ajax.php?c=financiamiento&f=consulta_regresos">
                            <thead>
                            <tr>
                                <th data-field="id">Id</th>
                                <th data-field="imp">Importe</th>
                                <th data-field="fecha">Fecha</th>
                                <th data-field="obs">Observaciones</th>
                                <th data-field="Acciones" data-formatter="FormatterAccionesRegreso" data-events="tablaRegresoEvents" >Borrar</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
            <div class="modal fade" id="modalEdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">  Cambiar estado </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="text" class="form-control input-md" id="nom_edo" disabled="true">
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-3 col-lg-offset-1" style="color:#277551">Nuevo estado:</h4>
                            <div class="col-lg-5">
                                <select name="Edo" id="Edo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                     <?php while($edo_fin= $status_fin->fetch_assoc())
                                {?>
                                   <option value="<?php echo $edo_fin['idstatus_financiado']?>"><?php echo $edo_fin['nombre']?></option>

                                <?php } ?>
                                </select>
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
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="actualiza_estado()" role="button"><i class="fa fa-refresh"></i>
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
         <div class="modal fade" id="modalEdo-Factura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>
 Cambiar estado de la factura </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                        <input type="hidden" class="form-control" id="id_factura">
                        <input type="hidden" class="form-control" id="importe_edo_fact" >
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="text" class="form-control input-md" id="actual_fact" disabled="true">
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                        <input type="hidden" id="id_edo_fact">
                           <h4 class="col-lg-3 col-lg-offset-1" style="color:#277551">Nuevo estado:</h4>
                            <div class="col-lg-5">
                                <select name="nuevo_edo_fact" id="nuevo_edo_fact" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                       <?php while($e= $edos_fact->fetch_assoc())
                                    {?>
                                       <option value="<?php echo $e['idstatus_factura']?>"><?php echo $e['nombre']?></option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="loading_edo_fact" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                         <div id="falla_fact" class="alert alert-danger" style="display:none;">
                    <strong><i class="fa fa-warning"></i>  ¡No se puede cambiar el estado a esta factura debido a que tiene descuentos de promotor aplicados, favor de revisar los descuentos primero, gracias!</strong>
                    <span id="msg-error"></span>
                </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoFactura()" role="button"><i class="fa fa-refresh"></i>
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
           <div class="modal fade" id="modalEdo-Cheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>
 Cambiar estado del cheque </h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                        <input type="hidden" class="form-control" id="cheque_id">
                        <input type="hidden" class="form-control" id="importe_edo_cheque" >
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="text" class="form-control input-md" id="actual_cheque" disabled="true">
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                        <input type="hidden" id="id_edo_cheque">
                           <h4 class="col-lg-3 col-lg-offset-1" style="color:#277551">Nuevo estado:</h4>
                            <div class="col-lg-5">
                                <select name="nuevo_cheque_edo" id="nuevo_cheque_edo" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                       <?php while($e= $edos_cheque->fetch_assoc())
                                    {?>
                                       <option value="<?php echo $e['idstatus_cheque']?>"><?php echo $e['nombre']?></option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_cheque_edo" style="display:none;" class="col-md-10 col-md-offset-2">
                            <img src="./images/loader.gif">
                            <br><br>
                        </div>
                        <div id="ok" style="display:none;" class="alert alert-success">
                            <h3><i class="fa fa-info-circle"></i>¡El estado de la cuenta ha sido cambiado exitosamente!</h3>
                        </div>
                         <div id="falla_fact" class="alert alert-danger" style="display:none;">
                    <strong><i class="fa fa-warning"></i>  ¡No se puede cambiar el estado a esta factura debido a que tiene descuentos de promotor aplicados, favor de revisar los descuentos primero, gracias!</strong>
                    <span id="msg-error"></span>
                </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="updateEdoCheque()" role="button"><i class="fa fa-refresh"></i>
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
         <div class="modal fade" id="modalEdoDescuento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">  Cambiar estado al descuento</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos">
                        <div class="form-group row">
                            <h4 class="col-lg-3 col-lg-offset-1 contol-label" style="color:#185F76;">Estado actual:</h4>
                            <div class="col-lg-5">
                                <input type="hidden" id="id_desc_edo">
                                <input type="hidden" id="edo_id_desc">
                                <input type="hidden" id="importe_edo_desc">
                                 <h3 id="actual_desc"></h3>
                            </div>
                            <br><br>
                        </div>
                        <div class="form-group row">
                           <h4 class="col-lg-3 col-lg-offset-1" style="color:#277551">Nuevo estado:</h4>
                            <div class="col-lg-5">
                                <select name="Edo_desc" id="Edo_desc" class="form-control">
                                <option value="">-- Seleccione estado --</option>
                                     <?php while($ed= $edos_desc->fetch_assoc())
                                {?>
                                   <option value="<?php echo $ed['idstatus_descuento']?>"><?php echo $ed['nombre']?></option>

                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div> <!-- /datos -->
                         <div id="load_descuento" style="display:none;" class="col-md-10 col-md-offset-2">
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
                            <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="update_estado_desc()" role="button"><i class="fa fa-refresh"></i>
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

    </div>
</div>


<script src="./js/detalle_financiamiento.js"></script>