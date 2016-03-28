<br><br>
<div class="container">
 <div class="page-header">
        <h3 class="title"><i class="fa fa-calendar-check-o"></i>  Estados de cuenta</h3>
    </div>
    <div class="col-lg-12">
        <div class="form-group row">
            <label class="col-lg-1 control-label">Plaza:</label>
	        <div class="col-lg-4">
	           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="auto" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
	                <option value="">-- Seleccione plaza --</option>
	                <?php while($plaza= $plazas->fetch_assoc())
	                {?>
	                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

	                <?php } ?>
	            </select>
	        </div>
	        <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
	        <label class="control-label col-md-1">Sociedad:</label>
           <div class="col-lg-4" id="rowSoc">
             <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_firm" id="soc_firm" bv-group=".group" >
                <option value=""> -- Seleccione sociedad --</option>
                <option value="00">SIN SOCIEDAD</option>
                <?php while($soc = $sociedades->fetch_assoc())
                {?>
                  <option value="<?php echo $s_fir['idempresa']?>"><?php echo $s_fir['razonsocial']?></option>
                <?php } ?>
             </select>
          </div>
	          
	        </div>
        </div>
      <div class="form-group row">
           <label class="col-lg-1 control-label">Banco:</label>
            <div class="col-lg-3">
               <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboBanco" name="cboBanco" data-size="10" onchange="filtra_cuentas()">
                <option value="">-- Seleccione banco --</option>
                     <?php while($banco= $bancos->fetch_assoc())
                        {?>
                           <option value="<?php echo $banco['idbancos']?>" data-subtext="<?php echo $banco['cve_transfer']?>"><?php echo $banco['nombre']?></option>

                        <?php } ?>
                </select>
            </div>
             <label class="col-lg-1 control-label">Cuenta:</label>
            <div class="col-lg-4">
                    <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCuenta" id="cboCuenta" onchange="asigna_cta()"></select>
            </div>
        </div>
        <div class="form-group row">
           <label class="col-lg-1 control-label">Año:</label>
            <div class="col-lg-3">
               <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboanio" name="cboanio" data-size="10" >
                <option value="">-- Seleccione año --</option>
                 <option value="2015">2015</option>
                 <option value="2015">2016</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary btn-sm" onclick="showTable()"><i class="fa fa-search"></i>  Listar</button>
            </div>
        </div>
        <div class="panel with-nav-tabs panel-primary">
            <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1primary" data-toggle="tab">Enero</a></li>
                        <li><a href="#tab2primary" data-toggle="tab">Febrero</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Marzo</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Abril</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Mayo</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Junio</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Julio</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Agosto</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Septiembre</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Octubre</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Noviembre</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">Diciembre</a></li>
                     
                    </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1primary">
                    	<button class="btn btn-success btn-xs btn-excel" data-toggle="modal" data-target="#excel"><i class="fa fa-file-excel-o"></i>  Subir estado de cuenta</button>
                    	<table id="table-enero" data-show-export="true"   data-checkbox="true" data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
                    </div>
                    <div class="tab-pane fade" id="tab2primary">	

                    </div>
                    <div class="tab-pane fade" id="tab3primary">Primary 3</div>
                    <div class="tab-pane fade" id="tab4primary">Primary 4</div>
                    <div class="tab-pane fade" id="tab5primary">Primary 5</div>
                </div>
            </div>
        </div>
	</div> <!-- div/lg-12	 -->
</div> <!-- container	 -->
<!-- MODALES -->
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
  Importar estado de cuenta </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="upload" action="ajax.php?c=cuentas&f=upload_estadoCta" id="upload" enctype="multipart/form-data">
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
<script src="./js/estados-cuenta.js"></script>