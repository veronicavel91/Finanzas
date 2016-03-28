<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<link rel="stylesheet" type="text/css" href="./css/conciliacion.css">
<div class="container cont-principal">
<div class="row">
  <section>
    <div class="col-lg-12">
      <div class="page-header">
          <h3 class="title">Conciliación bancaria</h3>
      </div>
      <form id="defaultForm" method="post" class="form-horizontal">
        <div class="form-group">
          <label class="col-lg-2 control-label">Plaza:</label>
          <div class="col-lg-3">
             <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="auto" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
                  <option value="">-- Seleccione plaza --</option>
                  <?php while($plaza= $plazas->fetch_assoc())
                  {?>
                     <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                  <?php } ?>
              </select>
          </div>
          <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
          <label class="control-label col-md-2">Sociedad:</label>
           <div class="col-lg-5" id="rowSoc">
           <div class="col-lg-10">
              <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad" onchange="busca_cuentas()"></select>
            </div>
          </div>
          <div class="col-lg-1" id="loader_cta" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
        </div>
        <div class="form-group">
             <label class="col-lg-2 control-label">Cuenta:</label>
            <div class="col-lg-5">
                    <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCuenta" id="cboCuenta"></select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Periodo a conciliar del:</label>
            <div class='col-lg-2'>
                <input type='date' placeholder="dd/mm/aaaa" id="periodo_del" name="periodo_del" class="form-control" />
            </div>
            <label  class="col-lg-1 control-label">al:</label>
            <div class="col-lg-2">
                <input type="date" class="form-control" name="periodo_al" id="periodo_al" placeholder="dd/mm/aaaa"/>
            </div>
             <div class="col-lg-2">
                <button class="btn btn-primary btn-sm" onclick="movimientos()"><i class="fa fa-check"></i>  Conciliar</button>
            </div>
        </div>
      </form>
    </section>
  </div><!--  /col-12 -->
</div><!--  /container-fluid -->
        
        <br><br>
        <div class="col-md-3 pull-right" style="margin-bottom:0px;" >
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary btn-blue btn-sm" data-title="Edit" data-toggle="modal" data-target="#new" style="margin-bottom:-8px!important;"><i class="fa fa-plus"></i>  Movimiento</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-success btn-green btn-sm" data-toggle="modal" data-target="#excel" style="margin-bottom:-8px!important;"><i class="fa fa-file-excel-o"></i>
              Importar</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-danger btn-red btn-sm" style="margin-bottom:-8px!important;" onclick="borrar_mov()"><i class="fa fa-trash"></i> Borrar</button>
              </div>
          </div>
        </div>




<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog" style="width:60%">
    <div class="modal-content">
          <div class="modal-header modal-header-danger">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-pencil"></i>  Editar conciliacion</h4>
      </div>
          <div class="modal-body">
           <form id="defaultForm" method="post" class="form-horizontal">
                <div class="form-group row">
                    <label class="col-lg-1 control-label">Numero de cuenta:</label>
                    <div class="col-lg-4">
                     <input type="text" class="form-control" disabled="true">
                    </div>
                    <label class="col-lg-1 col-lg-offset-1 control-label">Movimiento:</label>
                    <div class="col-lg-3">
                        <select name="tipo" class="form-control">
                            <option value="1">Deposito</option>
                            <option value="1">Retiro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Concepto:</label>
                    <div class="col-lg-4">
                       <select class="form-control">
                           <option value="1">01-deposito para nomina</option>
                       </select>
                    </div>
                     <label class="col-lg-2 control-label">Motivo:</label>
                    <div class="col-lg-3">
                      <input type="text" class="form-control" value="anticipo para el pago de nomina de septiembres">
                    </div> 
                   
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">No.cheque:</label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="fecha_fact" value="896562" />
                    </div>
                    <label  class="col-lg-1 control-label">Fecha:</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="folio_fact" value="01/09/2015" />
                    </div>
                </div>
                <div class="form-group">
                     <label  class="col-lg-2 control-label">Factura:</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="importe_fact" value="852555"/>
                    </div>
                </div>

                    
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-primary" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>  Actualizar</button>
                </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
    
    <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog" style="width:50%">
    <div class="modal-content">
          <div class="modal-header modal-header-danger">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-plus"></i>  Agregar movimiento </h4>
      </div>
          <div class="modal-body">
           <form id="defaultForm" method="post" class="form-horizontal">
               <!--  <div class="form-group row">
                    <label class="col-lg-2 control-label col-lg-offset-1">Cuenta:</label>
                    <div class="col-lg-6">
                     <input type="text" name="numero_cta" id="numero_cta" disabled="true" class="form-control">
                    </div>
                </div> -->
                <div class="form-group row">
                <label class="col-lg-2 col-lg-offset-1 control-label">Tipo movimiento:</label>
                    <div class="col-lg-3">
                        <select name="tipo_mov" id="tipo_mov" class="form-control">
                            <option value="1">INGRESO</option>
                            <option value="2">EGRESO</option>
                        </select>
                    </div> 
                     <label class="col-lg-2 control-label">Importe:</label>
                    <div class="col-lg-4">
                      <input type="text" class="form-control" id="importe_mov">
                    </div>                   
                </div>
                <div class="form-group row">
                      <label class="col-lg-3 col-lg-offset-1 control-label">Folio/Consecutivo:</label>
                    <div class="col-lg-4">
                      <input type="text" class="form-control" id="folio_mov" name="folio_mov">
                    </div> 
                </div>
                 <div class="form-group row">
                      <label class="col-lg-3 col-lg-offset-1 control-label">Fecha movimiento:</label>
                    <div class="col-lg-4 date">
                        <div class="input-group input-append date" id="datePicker">
                            <input type="text" class="form-control" name="f_mvto" id="f_mvto" placeholder="dd-mm-aaaa" />
                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                    </div>
                </div>
                 <div class="form-group row">
                      <label class="col-lg-2 col-lg-offset-1 control-label">Referencia:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="ref_mov" id="ref_mov" />

                    </div> 
                </div>
               <div class="form-group row">
                      <label class="col-lg-2 col-lg-offset-1 control-label">Concepto:</label>
                    <div class="col-lg-8">
                        <textarea name="concepto_mvto" id="concepto_mvto" class="form-control"></textarea>
                    </div> 
                </div>

                    
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-success" style="width: 100%;" onclick="guarda_movimiento()"><span class="glyphicon glyphicon-ok-sign"></span>  guardar registro</button>
                </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
   <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-verde">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-file-excel-o"></i>
  Importar datos desde excel </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="upload" action="ajax.php?c=conciliacion&f=upload_file" id="upload" enctype="multipart/form-data">
                <div class="col-lg-12">
                  <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                </div>
            </form>
<!--           </div>
 -->          <span style="color:#808080">*Seleccione el archivo que desea subir, solo se permiten extenciones(.csv,.xlsx,xlsm,xls)*</span>
              <div id="resultados"></div>
          </div>
                <div class="modal-footer ">
<!--                     <button type="button" class="btn btn-success" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>  subir archivo</button>
 -->                </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
    <div class="col-lg-12">
        <table id="table-movimientos" data-show-export="true"   data-checkbox="true" data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
    </div>
     <div class="form-group">
                            <br>
                            <h4 class="col-lg-2 col-lg-offset-2"><span class="label label-success">ABONOS:</span></h4>
                            <div class="col-lg-3">
                             <div class="input-group">
                                  <span class="input-group-addon">$</span>
                               <input type="text" class="form-control input-lg" name="importe_abono" id="importe_abono" value="0" disabled="true" />
                            </div>
                            </div>
                             <h4 class="col-lg-1 "><span class="label label-danger">CARGOS:</span></h4>
                             <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="text" class="form-control input-lg" name="importe_cargo" id="importe_cargo" value="0" disabled="true">
                                </div>
                            </div>
                        </div>
                          <div class="form-group">
                            <br><br>
                            <h4 class="col-lg-1 col-lg-offset-7"><span class="label label-info">SALDO:</span></h4>
                            <div class="col-lg-3">
                             <div class="input-group">
                                  <span class="input-group-addon">$</span>
                               <input type="text" class="form-control input-lg" name="saldo" id="saldo" value="0" disabled="true" />
                            </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
<script src="./js/conciliacion.js"></script>
<script src="./js/upload-file.js"></script>

