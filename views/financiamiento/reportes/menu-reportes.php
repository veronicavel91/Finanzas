<style>
  body { padding-top:20px; }
.panel-body .btn:not(.btn-block) { width:145px;margin-bottom:10px; }
</style>
<br>
<br>
<br>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> REPORTES FINANCIAMIENTO</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o"></span> <br/>Reporte x</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" style="background:#3C7850;" role="button" data-toggle="modal" data-target="#reporteGrupo"><span class="fa fa-file-excel-o"></span> <br/>Reporte por grupo</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" data-toggle="modal" data-target="#reporteFinan"><span class="fa fa-file-excel-o"></span> <br/>Financiamiento</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o" ></span> <br/>Reporte y</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o"></span> <br/>Reporte z</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" disabled="true"><span class="fa fa-file-excel-o"></span> <br/>Reporte w</a>

                        </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o"></span> <br/>Reporte z</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" disabled="true"><span class="fa fa-file-excel-o"></span> <br/>Reporte y</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" disabled="true"><span class="fa fa-file-excel-o"></span> <br/>Reporte x</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o"></span> <br/>Reporte y</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o"></span> <br/>Reporte z</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" disabled="true"><span class="fa fa-file-excel-o"></span> <br/>Reporte w</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal para generar reporte de ford y vamsa -->
<div class="modal fade" id="reporteGrupo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-header-verde">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Generar reporte por grupo</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
            <!-- content goes here -->
              <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:</label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboPlaza" id="cboPlaza" onchange="busqueda()">
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
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="sociedad" id="cboSociedad" onchange="combo_domicilio()"></select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Grupo:</label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboGrupo" name="cboGrupo" data-size="10" >
                      <option value="">-- Seleccione grupo --</option>
                         <option value="266">GRUPO FORD</option>
                         <option value="267">GRUPO VAMSA</option>
                      </select>
                  </div>
                    <label class="col-lg-1 control-label">Formato:</label>
                  <div class="col-lg-4">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboFormato" name="cboFormato" data-size="10" >
                      <option value="">-- Seleccione formato --</option>
                         <option value="1">Control interno</option>
                         <option value="2">Clientes</option>
                      </select>
                  </div>
                </div>
                 <div class="form-group row">
                        <label class="col-lg-2 control-label">Periodo reporte del:</label>
                        <div class="col-lg-3 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="periodo_del" id="periodo_del" placeholder="aaaa-mm-dd" data-bind="value: periodoInicio" required/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div><!--/date -->
                        <label  class="col-lg-1 control-label">al:</label>
                        <div class="col-lg-3 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="periodo_al" id="periodo_al" placeholder="aaaa-mm-dd" data-bind="value: periodoFin"/>
                                <span class="input-group-addon ad  d-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div><!--/input-group -->
                        </div><!-- date  -->
                    </div> <!-- form-group  -->
        </div>
        <div id="load3" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok3" style="display:none;" class="alert alert-success">
            <h3><i class="fa fa-check"></i>  Datos actualizados correctamente</h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons3" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-success btn-excel" data-action="save" onclick="reporte_grupo()" role="button"><i class="fa fa-file-excel-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- modal para generar reporte de ford y vamsa -->
<div class="modal fade" id="reporteFinan" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Reporte de financiamiento</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
            <!-- content goes here -->
              <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:</label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_rep" id="plaza_rep" onchange="busqueda()">
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
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_rep" id="soc_rep" onchange="combo_domicilio()"></select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Estado:</label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="edo_rep" name="edo_rep" data-size="10" >
                      <option value="">-- Seleccione estado --</option>
                         <option value="1">Activos</option>
                         <option value="3">Cancelados</option>
                         <option value="2">Pagados</option>
                         <option value="5">Vencidos</option>
                        <option value="5">Cualquier estado</option>
                      </select>
                  </div>
                </div>
                 <div class="form-group row">
                        <label class="col-lg-2 control-label">Periodo reporte del:</label>
                        <div class="col-lg-3 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="inicio_rep" id="inicio_rep" placeholder="aaaa-mm-dd" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div><!--/date -->
                        <label  class="col-lg-1 control-label">al:</label>
                        <div class="col-lg-3 date">
                            <div class="input-group input-append date" id="datePicker">
                                <input type="text" class="form-control" name="fin_rep" id="fin_rep" placeholder="aaaa-mm-dd"/>
                                <span class="input-group-addon ad  d-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div><!--/input-group -->
                        </div><!-- date  -->
                    </div> <!-- form-group  -->
        </div>
        <div id="load3" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok3" style="display:none;" class="alert alert-success">
            <h3><i class="fa fa-check"></i>  Datos actualizados correctamente</h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons3" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-success btn-excel" data-action="save" onclick="reporte_grupo()" role="button"><i class="fa fa-file-excel-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="./js/reportes/menu-reportes.js"></script>