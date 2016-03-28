<?php
#incluye encabezado
?><link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<script src="./js/registro-financiamiento.js"></script>
<script src="./js/comun.js"></script>
<script src="./js/viewModels/nota_model.js"></script>
<script src="./js/viewModels/notasCredito_model.js"></script>
<script src="./js/viewModels/descuento_model.js"></script>
<script src="./js/viewModels/descuentosPromotor_model.js"></script>
<script src="./js/viewModels/cheque_model.js"></script>
<script src="./js/viewModels/depositosCliente_model.js"></script>
<script src="./js/viewModels/datosGenerales_model.js"></script>
<script src="./js/viewModels/factura_model.js"></script>
<script src="./js/viewModels/abono_model.js"></script>
<script src="./js/viewModels/financiamiento_model.js"></script>
<script src="./js/nav-tabs.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout-validation/2.0.3/knockout.validation.js"></script>

<style>
    .dropdown-menu > li:hover
    {
      background-color: #8ED7C7;
    }
    .error
    {
        color: #A84747;
        font-size: 12px;
        font-weight: bold;
        border-color: #A84747; 
    }
</style>
<!-- contenedor-principal -->
<div class="container cont-principal">
    <div class="row">
        <section>
            <div class="col-lg-12">
                <div class="page-header">
                    <h2 class="title" data-bind="text: 'Financiamiento #'+ FinanciamientoModel.financiamientoID()"></h2>
                </div><!-- page-header  -->

                <form id="FormFinanciamiento" class="form-horizontal">
                 <ul id = "myTab" class = "nav nav-tabs">
                           <li class = "active">
                              <a href = "#general-fin" data-toggle = "tab">
                                 Datos generales   
                              </a>
                           </li>
                           
                           <li><a href = "#abonos-fin" data-toggle = "tab">Depositos financiamiento</a></li>   
                        </ul>
                    <div id = "myTabContent" class = "tab-content">

                       <div class = "tab-pane fade in active" id ="general-fin">
                       <br>
                        <div class="form-group">
                        <label for=""class="btn btn-warning btn-xs pull-right" data-bind="click: editaFinan"><i class=
                    "fa fa-pencil" ></i>  Editar datos</label><br>
                                <label class="col-lg-2 control-label">Plaza:</label>
                                <div class="col-lg-4">
                                    <select data-live-search="true" class="selectpicker show-menu-arrow"  data-size="10" data-width="100%" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" data-bind="value: plaza">
                                        <option value="00">-- Seleccione plaza --</option>
                                        <?php while($plaza= $plazas->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                        <?php } ?>
                                    </select>
                                </div> <!-- /col-lg-4 -->
                                <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                                <label class="control-label col-md-1">Sociedad:</label>
                                <div class="col-lg-4" id="rowSoc">
                                   <select data-live-search="true" class="selectpicker show-menu-arrow"  data-size="10" data-width="100%" name="sociedad" id="cboSociedad"  data-bind="value: sociedad"></select>
                                </div><!-- /row-soc -->
                        </div><!-- form-group  -->
                        <div class="form-group">
                            <div id="rowCliente">
                                <label class="col-lg-2 control-label">Cliente:</label>
                                <div class="col-lg-4">
                                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCliente" id="cboCliente" data-bv-notempty data-bv-notempty-message="el cliente es requerido" data-bind="value: cliente,attr : {'disabled' : isDisabled}">
                                    </select>
                                </div><!-- /col-lg-4  -->
                            </div><!-- /rowCliente  -->
                            <div class="col-lg-1" id="loader2" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                            <label class="col-lg-2 control-label">Autorizado por:</label>
                            <div class="col-lg-3">
                                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="autorizado" id="autorizado" data-bind="value: autorizador,attr : {'disabled' : isDisabled} ">
                                    </select>
                            </div><!-- col-lg-3 -->
                            <div class="col-lg-1" style="display:none;">
                                <label for="" class="btn btn-primary btn-xs" onclick="modal_autoriza()" data-bind="attr : {'disabled' : isDisabled}"><i class="fa fa-plus"></i></label>
                            </div><!-- col-lg-1  -->
                        </div> <!-- form-group  -->
                        <div class="form-group">
                            <label class="col-lg-2 col-lg-offset-1 control-label">Periodo financiado del:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="periodo_del" id="periodo_del" placeholder="aaaa-mm-dd" data-bind="value: periodoInicio,attr : {'disabled' : isDisabled}" required/>
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div><!--/date -->
                            <label  class="col-lg-1 control-label">al:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="periodo_al" id="periodo_al" placeholder="aaaa-mm-dd" data-bind="value: periodoFin,attr : {'disabled' : isDisabled}"/>
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div><!--/input-group -->
                            </div><!-- date  -->
                        </div> <!-- form-group  -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Estado:</label>
                            <div class="col-md-3">
                                <select name="edo_fin" id="edo_fin" class="form-control" data-bind="value: estado,attr : {'disabled' : isDisabled}">
                                    <option value=""> -- Seleccione estado -- </option>
                                      <?php while($s= $status->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $s['idstatus_financiado']?>"><?php echo $s['nombre']?></option>

                                        <?php } ?>
                                </select>
                            </div> <!-- col-md-3 -->
                              <label class="col-lg-1 control-label">Comentarios:</label>
                            <div class="col-lg-5">
                               <textarea name="obs_finan" id="obs_finan" class="form-control" data-bind="value: comentarios,attr : {'disabled' : isDisabled}"></textarea>
                             </div>
                    </div><!-- form-group  -->
                       </div>
                     <div class = "tab-pane fade" id = "abonos-fin">
                       <br>
                            <label class="btn btn-info pull-left addButton btn-sm" data-bind="click: agregarAbono" data-template="textbox"><i class="fa fa-plus"></i>  Deposito financiamiento</label>
                            <table id="abonos-table" ></table> <br><br>
                              <div class="panel panel-primary" id="panel_ab" style="height:240px;">
                                          <div class="panel-body" style="text-align:center;color:#797979">
                                            <span>Este financiamiento no cuenta con depositos registrados.</span>
                                          </div>
                                        </div>
                       </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 col-lg-offset-1 control-label">Facturas:</label>
                        <div class="col-lg-2">
                            <div class="btn-group">
                              <button type="button" class="btn btn-info dropdown-toggle" style="width:160%"
                                      data-toggle="dropdown" data-bind="text: facturaNombre">
                              </button>
                              <ul class="dropdown-menu" role="menu" data-bind="foreach: facturas ">
                                <li data-bind="click: $parent.seleccionarFactura"><label data-bind="text: nombre()"></label></li>
                              </ul>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="" class="btn btn-primary btn-xs" data-bind="click: nuevaFactura"><i class="fa fa-plus"></i>  Agregar factura</label>
                        </div><!-- col-lg-1 -->
                    </div><!-- form-group  -->

<!-- ko if: facturas().length > 0 -->  
   <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading clearfix">
                    <div class="pull-left">
                        <h1 class="panel-title"><h4 data-bind="text: facturaNombre"></h4></h1> <label class="btn btn-danger btn-xs" data-bind="click: borrarFactura" for=""><i class="fa fa-trash confirm"></i></label>
                         <label class="btn btn-warning btn-xs" data-bind="click: editaFactura" for=""><i class="fa fa-pencil"></i></label>
                    </div>
                    <div class="pull-right">         
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#general-tab" data-toggle="tab">Datos generales <i class="fa"></i></a></li>
                            <li><a href="#cheques-tab" data-toggle="tab">Abonos a factura <i class="fa"></i></a></li>
                            <li><a href="#descuentos-tab" data-toggle="tab">Descuentos promotor <i class="fa"></i></a></li>
                            <li><a href="#notas-tab" data-toggle="tab">Notas de credito <i class="fa"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <br>
                        <!-- ko with: facturaSeleccionada  -->
                        <!-- ko with: datosGenerales  -->
                        <div class="tab-pane active" id="general-tab">
                            <div class="form-group">
                                <label class="control-label col-lg-3">Folio de la factura:</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="folio_fact" id="folio_fact" data-bind="value: folioFactura,attr : {'disabled' : isDisabled}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Fecha factura:</label>
                              <div class="col-lg-3 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_factura" id="fecha_factura" placeholder="aaaa-mm-dd" data-bind="value: fechaFactura,attr : {'disabled' : isDisabled}" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-lg-3">Folio KID:</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="folio_kid" id="folio_kid" data-bind="value: folioKid,attr : {'disabled' : isDisabled}">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-lg-3">Sociedad factura:</label>
                                <div class="col-lg-3">
                                    <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="socFactura" id="socFactura" data-bind="value: socFactura,attr : {'disabled' : isDisabled}">
                                        <option value="">-- Seleccione sociedad --</option>
                                       <?php while($s= $sociedades_fact->fetch_assoc())
                                        {?> 
                                           <option value="<?php echo $s['idempresa']?>"><?php echo $s['razonsocial']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">Importe factura:</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" name="importe_factura" id="importe_factura" data-bind="value: importeFactura,attr : {'disabled' : isDisabled}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Estado:</label>
                                <div class="col-lg-2">
                                   <select name="" class="form-control" id="" data-bind="value: estadoFactura,attr : {'disabled' : isDisabled}">
                                    <?php while($s= $status_fact->fetch_assoc())
                                {?> 
                                   <option value="<?php echo $s['idstatus_factura']?>"><?php echo $s['nombre']?></option>

                                <?php } ?>
                                   </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-lg-3">Motivo factura:</label>
                                <div class="col-lg-7">
                                    <textarea name="" class="form-control" id="" data-bind="value: nombreFactura,attr : {'disabled' : isDisabled}"></textarea>
                                </div>
                                <span style="color:#696969;font-size:12px;">*Nombre con el que se va a referenciar la factura(opcional)</span>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-lg-3">Observaciones:</label>
                                <div class="col-lg-7">
                                    <textarea name="" class="form-control" id="" data-bind="value: observaciones,attr : {'disabled' : isDisabled}"></textarea>
                                </div>
                            </div>
                        </div> <!-- /general-tab -->
                        <!-- /ko -->
                        <!-- ko with: depositosCliente  -->
                        <div class="tab-pane" id="cheques-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="btn btn-info pull-left addButton btn-sm" data-bind="click: agregarCheque" data-template="textbox"><i class="fa fa-money"></i>  Agregar cheque/deposito</label>
                                         <!-- Tabla cheques del cliente -->
                                        <table id="cheques-table" ></table>
                                        <br>
                                        <br><br>
                                       <div class="panel panel-info" id="panel_depositos">
                                          <div class="panel-body"  style="text-align:center;color:#797979">
                                            <span>Factura sin depositos</span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /cheques-tab -->
                        <!-- /ko -->
                        <!-- ko with: descuentosPromotor  -->
                        <div class="tab-pane" id="descuentos-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="btn btn-primary pull-left addButton btn-sm" data-bind="click: agregarDescuento" data-template="textbox"><i class="fa fa-money"></i>  Agregar descuento a promotor</label>
                                        <!-- Tabla cheques del cliente -->
                                        <table id="promotor-table" ></table>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                     <div class="panel panel-primary" id="panel_descuentos">
                                          <div class="panel-body" style="text-align:center;color:#797979">
                                            <span>Factura sin depositos</span>
                                          </div>
                                        </div>
                                </div>
                            </div>
                        </div> <!-- /descuentos-tab -->
                        <!-- /ko -->
                        <!-- ko with: notasCredito  -->
                          <div class="tab-pane" id="notas-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <label class="btn btn-success pull-left addButton btn-sm" data-template="textbox" data-bind="click: agregarNota"><i class="fa fa-sticky-note"></i>  Agregar nota de credito</label>
                                        <!-- Tabla cheques del cliente -->
                                    </div>
                                    <table id="notas-table" ></table>
                                    <br>
                                    <br>
                                    <br>
                                     <div class="panel panel-success" id="panel_notas">
                                          <div class="panel-body" style="text-align:center;color:#797979">
                                            <span>Factura sin notas de credito</span>
                                          </div>
                                        </div>
                                </div>
                            </div>
                        </div> <!-- /cheques-tab -->
                        <!-- /ko -->
                        <!-- /ko -->
                        <div class="col-lg-12">
                         <div class="panel panel-default">
                          <!-- Default panel contents -->
                          <div class="panel-body">
                                <div class="form-group">
                                    <br>
                                     <span class="col-lg-2 col-lg-offset-1" style="font-weight:bold;">Depositos factura:</span>
                                    <!-- ko with: facturaSeleccionada  -->
                                    <div class="col-lg-3">
                                    
                                        <input type="text" class="form-control" name="importe_dep" id="importe_dep" value="0" disabled="true" data-bind="value: importeDepositados"/>
                                    
                                    </div>
                                    <span class="col-lg-2" style="font-weight:bold;">Importe factura:</span>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="importe_fin" id="importe_fin" value="0" disabled="true" data-bind="value: totalImporte"/>
                                    </div>
                                    <!-- /ko -->
                                </div> <!-- /form-group -->
                                 <!-- ko with: facturaSeleccionada  -->
                               <div class="form-group">
                                     <span class="col-lg-2 col-lg-offset-1" style="font-weight:bold;">Descuento factura:</span>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="tot_desc" id="tot_desc" value="0" disabled="true" data-bind="value: importeDescuentosPromotor" />
                                    </div>
                                     <span class="col-lg-2" style="font-weight:bold;">Notas credito:</span>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="saldo_nota" id="saldo_nota" value="0" disabled="true" data-bind="value: totalNotas" />
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <span class="col-lg-2 col-lg-offset-6" style="font-weight:bold;color:#1F557A;">SALDO FACTURA:</span>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="saldo_fact" id="saldo_fact" value="0" disabled="true" data-bind="value: saldoFactura"/>
                                    </div>
                                </div><!-- /form-group -->
                        <!-- /ko -->
                        </div>
                    </div>
                    </div> 
                    </div> <!-- /tab-content -->
                     </div>
            </div>
                        <div class="panel panel-primary">
                        <div class="panel-heading"><i class="fa fa-money"></i>Totales del financiamiento</div>
                          <!-- Default panel contents -->
                          <div class="panel-body">
                             <div class="form-group">
                            <br>
                            <h4 class="col-lg-2 col-lg-offset-1"><span class="label label-success">TOTAL ABONOS:</span></h4>
                            <div class="col-lg-3">
                            
                                <input type="text" class="form-control input-lg" name="finan_deposito" id="finan_deposito" value="0" disabled="true" data-bind="value: totalDeposito"/>
                            
                            </div>

                            <h4 class="col-lg-2 "><span class="label label-danger">TOTAL FACTURAS:</span></h4>
                            <div class="col-lg-3">
                                <input type="text" class="form-control input-lg" name="finan_facturas" id="finan_facturas" value="0" disabled="true" data-bind="value: totalFacturas"/>
                            </div>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                                <h4 class="col-lg-2 col-lg-offset-1"><span class="label label-default">TOTAL DESCUENTO:</span></h4>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control input-lg" name="finan_descuento" id="finan_descuento" value="0" disabled="true" data-bind="value: totalDescuento"/>
                                </div>
                                 <h4 class="col-lg-2"><span class="label label-success">TOTAL DEPOSITOS:</span></h4>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control input-lg" name="finan_depCliente" id="finan_depCliente" value="0" disabled="true" data-bind="value: totalAbonos"/>
                                </div>
                        </div><!-- /form-group -->
                        <div class="form-group">
                            <h4 class="col-lg-2 col-lg-offset-1"><span class="label label-info">SALDO FINAL:</span></h4>
                            <div class="col-lg-3">
                                <input type="text" class="form-control input-lg" name="finan_saldo" id="finan_saldo" value="0" disabled="true"  data-bind="value: saldoFinal" />
                            </div>
                        </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <br>
                            <div class="col-lg-5 col-lg-offset-5">
                                <br>
                                <button type="button" data-bind="click: guardarFinanciamiento"class="btn btn-primary"><i class="fa fa-check-circle"></i>  Guardar financiamiento</button><br><br><br>
                            </div>
                        </div><!-- /form-group -->
                    </div>
                    <!-- /ko --> 
                </form>
            </div><!-- /col-lg-12 -->
        </section>
    </div><!-- /row -->
</div><!-- /cont-principal --><!-- fin Registro.php -->
<!-- modal agregar un cheque -->
<!-- ko with: facturaSeleccionada  -->
<!-- ko with: depositosCliente  -->

<div class="modal fade" id="agregar_cheque" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i>  deposito/cheque/pago</h3>
            </div>
            <div class="modal-body">
                <div id="datos-cheque">
                    <!-- content goes here -->
                   <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Tipo movimiento:</label>
                        <div class="col-lg-5">
                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="tipo_pago" id="tipo_pago" data-bind="value: chequeSeleccionado().tipo_pago">
                                <option value="">-- Seleccione tipo --</option>
                               <?php while($tipo= $tipos_mov->fetch_assoc())
                                {?>
                                   <option value="<?php echo $tipo['idtipo_pago']?>"><?php echo $tipo['nombre']?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                      <div class="form-group row"> 
                        <label class="col-lg-3 control-label">Sociedad del pago:</label>
                        <div class="col-lg-7">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_cheque" id="soc_cheque" data-bind="value: chequeSeleccionado().sociedad">
                                <option value="">-- Seleccione sociedad --</option>
                               <?php while($sociedad= $sociedades->fetch_assoc())
                                {?> 
                                   <option value="<?php echo $sociedad['idempresa']?>"><?php echo $sociedad['razonsocial']?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" data-bind="visible: chequeSeleccionado().tipo_pago() == 2">
                        <label class="col-lg-3 control-label">Folio cheque:</label>
                        <div class="col-lg-5">
                          <input type="text" class="form-control" id="no_cheque" name="no_cheque" data-bind="value: chequeSeleccionado().folioCheque">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Estado deposito:</label>
                        <div class="col-lg-5">
                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="edo_abono" id="edo_abono" data-bind="value: chequeSeleccionado().estado">
                                <option value="">-- Seleccione estado --</option>
                               <?php while($edo_abono= $edos_abonos->fetch_assoc())
                                {?>
                                   <option value="<?php echo $edo_abono['idstatus_abono']?>"><?php echo $edo_abono['nombre']?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                         <label class="col-lg-3 control-label">Fecha movimiento:</label>
                          <div class="col-lg-4 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_cheque" id="fecha_cheque" placeholder="aaaa-mm-dd" data-bind="value: chequeSeleccionado().fecha" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Importe:$</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" id="imp_cheque" name="imp_cheque" value="0.00" data-bind="value: chequeSeleccionado().importe">
                        </div>
                    </div>
                    <div class="form-group row pop">
                        <label class="col-lg-3 control-label">Observaciones:</label>
                        <div class="col-lg-8" id="cont-textarea">
                        <textarea name="obs_cheque" id="obs_cheque" class="form-control" cols="3" rows="3" data-bind="value: chequeSeleccionado().observaciones"></textarea>
                            <br>
                        </div>
                    </div>
                    <div id="load3" style="display:none;" class="col-md-10 col-md-offset-2">
                        <img src="./images/loader.gif">
                        <br><br>
                    </div>
                    <div id="ok3" style="display:none;" class="alert alert-success">
                        <h3><i class="fa fa-check"></i>  El cheque ha sido agregado correctamente</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons_agrega_cheq" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton"  data-template="textbox" id="guarda_cheque" data-bind="click: nuevoCheque"><i class="fa fa-save"></i>  Guardar cheque</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
                <div id="act" style="display:none">
                        <button class="btn btn-info btn-block"  data-template="textbox" data-dismiss="modal"><i class="fa fa-refresh"></i>  Actualizar datos</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- /ko -->
<!-- /ko -->
<!-- Modal agregar abonos -->
<div class="modal fade" id="agregar_abonos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-usd"></i>  Agregar deposito/abonos</h3>
            </div>
            <div class="modal-body">
                <div id="datos-cheque">
                    <!-- content goes here -->
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">No. cheque:</label>
                        <div class="col-lg-5">
                          <input type="text" class="form-control" id="no_cheque" name="no_cheque" >
                        </div>
                    </div>
                    <div class="form-group row">
                         <label class="col-lg-3 control-label">Fecha del cheque:</label>
                          <div class="col-lg-4 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_cheque" id="fecha_cheque" placeholder="aaaa-mm-dd"  />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Sociedad del cheche:</label>
                        <div class="col-lg-7">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_cheque" id="soc_cheque" >
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
                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="edo_cheque" id="edo_cheque" >
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
                            <input type="text" class="form-control" id="imp_cheque" name="imp_cheque" value="0.00" >
                        </div>
                    </div>
                    <div class="form-group row pop">
                        <label class="col-lg-3 control-label">Observaciones:</label>
                        <div class="col-lg-8" id="cont-textarea">
                        <textarea name="obs_cheque" id="obs_cheque" class="form-control" cols="3" rows="3" ></textarea>
                            <br>
                        </div>
                    </div>
                    <div id="load3" style="display:none;" class="col-md-10 col-md-offset-2">
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
                        <button class="btn btn-info pull-right addButton"  data-template="textbox"><i class="fa fa-save"></i>  Guardar cheque</button>
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
<!-- ko with: facturaSeleccionada  -->
<!-- ko with: descuentosPromotor  -->
<div class="modal fade" id="agregar_descuento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-minus"></i>  Descuento a promotor</h3>
            </div>
            <div class="modal-body">
            <div class="datos-desc">
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Promotor:</label>
                    <div class="col-lg-7">
                        <select data-live-search="true" class="selectpicker show-menu-arrow"  data-size="10" data-width="100%" name="promotor" id="promotor" data-bind="value: descuentoSeleccionado().promotor" />
                            <option value="">-- Seleccione persona --</option>
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
                        <input type="text" class="form-control" name="importe_desc" id="importe_desc" placeholder="$0" data-bind="value: descuentoSeleccionado().importe_desc"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Estado:</label>
                    <div class="col-lg-5">
                        <select name="edo_desc" class="form-control" id="edo_desc" data-bind="value: descuentoSeleccionado().edo_desc">
                        <option value="">-- Selecione el estado --</option>
                            <?php while($edo = $status_desc->fetch_assoc())
                                {?>
                                   <option value="<?php echo $edo['idstatus_descuento']?>"><?php echo $edo['nombre']?></option>

                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Fecha descuento:</label>
                    <div class="col-lg-4">
                        <div class="input-group input-append date" id="datePicker">
                            <input type="text" class="form-control" name="fecha_desc" id="fecha_desc" placeholder="aaaa-mm-dd" data-bind="value: descuentoSeleccionado().fecha_desc" />
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Observaciones:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" name="obs_desc" id="obs_desc" data-bind="value: descuentoSeleccionado().observable"></textarea>
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
                        <button class="btn btn-info pull-right addButton" data-bind="click: nuevoDescuento" data-template="textbox"><i class="fa fa-save"></i>  Guardar descuento</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
                <div id="act_desc" style="display:none">
                    <button class="btn btn-info btn-block"  data-template="textbox" data-dismiss="modal"><i class="fa fa-refresh"></i>  Actualizar datos</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /ko -->
<!-- /ko -->
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
<!-- modal esperar -->
<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-save"></i>  Guardando financiamiento...</h3>
            </div>
            <div class="modal-body">
                    <!-- content goes here -->
                <div id="load" class="col-md-10 col-md-offset-2">
                <img src="./images/loader.gif">
                <br><br>
                </div>
                <div id="exito" class="alert alert-success" style="display:none;">
                    <strong><i class="fa fa-info-circle"></i>  El financiamiento ha sido guardado exitosamente.</strong>
                </div>
                <div id="fail" class="alert alert-danger" style="display:none;">
                    <strong><i class="fa fa-info-circle"></i>  Lo sentimos ha ocurrido un error al guardar el financiamiento, por favor intentelo de nuevo.</strong>
                    <span id="msg-error"></span>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-male"></i>  Empleados autorizados</h4>
            </div>
            <div class="modal-body">
            <label for="" class="col-lg-2">Empleado:</label>
            <div class="col-lg-6">
                <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboEmp" id="cboEmp">
                    </select>
            </div>
            <div class="col-lg-1">
            <button class="btn btn-info btn-sm" id="nuevo_aut" onclick="nuevo_autoriza()"><i class="fa fa-plus"></i>  Agregar</button>
                <br><br>
            </div>
            <div class="col-lg-1" id="loader-modal" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>

                <table id="table-autoriza"
                       data-toggle="table"
                       data-height="299" 
                       data-url="ajax.php?c=financiamiento&f=autorizados">
                    <thead>
                    <tr>
                        <th data-field="Id">Id</th>
                        <th data-field="nombre">Nombre</th>
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
<!-- ko with: facturaSeleccionada  -->
<!-- ko with: notasCredito  -->
<div class="modal fade" id="agregar_nota" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-sticky-note"></i>  Nota de credito</h3>
            </div>
            <div class="modal-body">
                <div class="datos-desc">
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Folio:</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="folio_nota" id="folio_nota" data-bind="value: notaSeleccionada().folio" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Importe:</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="importe_nota" id="importe_nota" placeholder="$0" data-bind="value: notaSeleccionada().importe_nota" />
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-lg-3 control-label">Fecha nota:</label>
                    <div class="col-lg-4">
                        <div class="input-group input-append date" id="datePicker">
                            <input type="text" class="form-control" name="fecha_nota" id="fecha_nota" placeholder="aaaa-mm-dd" data-bind="value: notaSeleccionada().fecha_nota" />
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 control-label">Pagadora:</label>
                    <div class="col-lg-5">
                        <select name="pagadora" class="form-control" id="pagadora" data-bind="value: notaSeleccionada().pagadora">
                             <option value="">-- Seleccione pagadora--</option>
                             <option  value="5380">RORY CROWN SA DE CV</option>
                             <option  value="5382">SIMARIK SA DE CV</option>
                        </select>
                    </div>
                </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Estado:</label>
                        <div class="col-lg-5">
                            <select name="estado_nota" class="form-control" id="estado_nota" data-bind="value: notaSeleccionada().estado_nota">
                                 <option value="">-- Estado de la nota--</option>
                                   <?php while($sn= $status_nota->fetch_assoc())
                                    {?>
                                       <option value="<?php echo $sn['idstatus_nota']?>"><?php echo $sn['nombre']?></option>

                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Observaciones:</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="obs_nota" id="obs_nota" data-bind="value: notaSeleccionada().obs_nota" ></textarea>
                            <br>
                        </div>
                    </div>
                </div>
                <div id="load-nota" style="display:none;" class="col-md-10 col-md-offset-2">
                    <img src="./images/loader.gif">
                    <br><br>
                </div>
            </div> <!-- modal-body -->
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons-nota" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton" data-template="textbox" data-bind="click: nuevaNota"><i class="fa fa-save"></i>  Guardar nota</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
                <div id="act_nota" style="display:none">
                    <button class="btn btn-info btn-block"  data-template="textbox" data-dismiss="modal"><i class="fa fa-refresh"></i>  Actualizar datos</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /ko -->
<!-- /ko -->
<!-- ko with: abonoSeleccionado  -->
<div class="modal fade" id="agregar_abono" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i>  Depositos a financiamiento</h3>
            </div>
            <div class="modal-body">
                <div id="datos-cheque">
                    <!-- content goes here -->
                   <div class="form-group row">
                        <label for="" class="col-lg-3 control-label">Fecha:</label>
                        <div class="col-lg-4 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fecha_abono" id="fecha_abono" placeholder="aaaa-mm-dd"  data-bind="value: fecha"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                      <div class="form-group row"> 
                        <label class="col-lg-3 control-label">Importe:</label>
                        <div class="col-lg-5">
                           <input type="text" class="form-control" name="importe_abono" id="importe_abono" data-bind="value: importe">
                        </div>
                    </div>
                    <div class="form-group row pop">
                        <label class="col-lg-3 control-label">Observaciones:</label>
                        <div class="col-lg-8" id="cont-textarea">
                        <textarea name="obs_cheque" id="obs_cheque" class="form-control" data-bind="value: observaciones" ></textarea>
                            <br>
                        </div>
                    </div>
                    <div id="load3" style="display:none;" class="col-md-10 col-md-offset-2">
                        <img src="./images/loader.gif">
                        <br><br>
                    </div>
                    <div id="ok3" style="display:none;" class="alert alert-success">
                        <h3><i class="fa fa-check"></i>  El abono ha sido agregado correctamente</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" id="buttons_nvo_dep" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info pull-right addButton"  data-template="textbox" id="nvo_deposito" data-bind ="click:$parent.nuevoAbono"><i class="fa fa-save"></i>  Guardar deposito</button>
                    </div>
                </div>
                <div id="btnok3" style="display:none;">
                     <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
                </div>
                <div id="act_dep" style="display:none">
                        <button class="btn btn-info btn-block"  data-template="textbox" data-dismiss="modal"><i class="fa fa-refresh"></i>  Actualizar datos</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- /ko -->
<!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1"
    role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-time">
                    </span>  Por favor espere...
                 </h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info
                    progress-bar-striped active"
                    style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal ends Here -->




