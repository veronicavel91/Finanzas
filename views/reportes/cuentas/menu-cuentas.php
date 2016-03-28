<style>
  body { 
    padding-top:20px; 
  }
.panel-body .btn:not(.btn-block) { width:145px;margin-bottom:10px; }
.fileinput-upload-button
{
  display: none;
}
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
                        <span class="glyphicon glyphicon-bookmark"></span> REPORTES Y FORMATOS</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-md" role="button" data-toggle="modal" data-target="#entregaCta"><span class="fa fa-file-pdf-o"></span> <br/>Entrega de cuenta</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" role="button" data-toggle="modal" data-target="#modalEntregaCheq"><span class="fa fa-file-pdf-o"></span> <br/>Formato chequera</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" data-toggle="modal" data-target="#modalActDatos"><span class="fa fa-file-pdf-o"></span> <br/>Formato datos</a>
                          <a href="#" class="btn btn-danger btn-md" role="button" data-toggle="modal" data-target="#modalFormatoEdo"><span class="fa fa-file-pdf-o"></span> <br/>Cambio estado</a>
                          <a href="#" class="btn btn-success btn-excel btn-md" role="button" disabled="true"><span class="fa fa-file-excel-o"></span> <br/>Reporte w</a>

                        </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-md" role="button" disabled="true"><span class="fa fa-file-pdf-o" ></span> <br/>Reporte z</a>
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
<!-- modal para generar el formato de entrega de cuenta -->
<div class="modal fade" id="entregaCta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Generar formato de entrega</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
    <form name="entrega_cta" id="entrega_cta" method="POST" action="ajax.php?c=reportes&f=genera_reporte">
            <!-- content goes here -->
              <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:</label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboPlaza" id="cboPlaza">
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
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="sociedad" id="cboSociedad" onchange="combo_domicilio()">
                        <option value=""> -- Seleccione sociedad --</option>
                          <option value="00">SIN SOCIEDAD</option>
                          <?php while($soc = $sociedades->fetch_assoc())
                          {?>
                            <option value="<?php echo $soc['idempresa']?>"><?php echo $soc['razonsocial']?></option>
                          <?php } ?>
                     </select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Banco:</label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboBanco" name="cboBanco" data-size="10" onchange="filtra_cuentas()">
                      <option value="">-- Seleccione banco --</option>
                           <?php while($banco= $bancos->fetch_assoc())
                              {?>
                                 <option value="<?php echo $banco['idbancos']?>" data-subtext="<?php echo $banco['cve_transfer']?>"><?php echo $banco['nombre']?></option>

                              <?php } ?>
                      </select>
                  </div>
                   <label class="col-lg-1 control-label">Cuenta:</label>
                  <div class="col-lg-5">
                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCuenta" id="cboCuenta"></select>
                  </div>
                </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Solicitante:</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="solicitante" id="solicitante">
                    <span style="font-size:14px;color:#515151;">* Escriba el nombre de la persona quien solicita la cuenta*</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-4 col-md-offset-1">Se entregarán los documentos:</label>
                <div class="col-md-5">
                  <input name="entrega[]" id="entrega" type="checkbox" value="rbChequera" /><span>Chequera inicial del folio</span>:<input type="text" id="folio_del" name="folio_del" class="form-control">al <input type="text" class="form-control" id="folio_al" name="folio_al"><br>
                  <input name="entrega[]" id="entrega" type="checkbox" value="rbToken" /><span>Token Administrador y operador</span><br>
                  <input name="entrega[]" id="entrega" type="checkbox" value="rbClaves" /><span>Claves de acceso</span><br>
                  <input name="entrega[]" id="entrega" type="checkbox" value="rbDep" /><span>Deposito por la cantidad de:</span><input type="text" id="imp_dep" name="imp_dep" class="form-control"><br>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Comentarios:</label>
                <div class="col-md-9">
                  <textarea name="info" class="form-control" id="info">Aprovecho para solicitar se realice una operación de pago nomina (1 peso), terceros y/o interbancaria así como las que consideren importantes para la función que realizara la presente cuenta, esto se solicita en un plazo no mayor a 7 días, con la finalidad de corregir cualquier contingencia.</textarea>
                </div>
              </div>
            <!--   <div class="form-group row">
                <label for="" class="col-md-2">Logotipo:</label>
               <div class="col-lg-6">
                  <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                </div>
              </div> -->
              <div id="resultados"></div>
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
                    <button type="submit" id="saveImage" class="btn btn-danger" data-action="save" role="button"><i class="fa fa-file-pdf-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
        </form>
    </div>
  </div>
</div>
<!-- modal para generar el formato de entrega de cuenta -->
<div class="modal fade" id="modalFormatoEdo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Generar formato de cambio de estado</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
    <form name="cancela_act" id="cancela_act" method="POST" action="ajax.php?c=reportes&f=formatoEstado" onsubmit="return false;">
            <!-- content goes here -->
              <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:</label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_form" id="plaza_form">
                        <option value="">-- Seleccione plaza --</option>
                        <?php while($pl_ca= $plazas_can->fetch_assoc())
                        {?>
                           <option value="<?php echo $pl_ca['idplaza']?>"><?php echo $pl_ca['plaza']?></option>

                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                  <label class="control-label col-md-1">Sociedad:</label>
                   <div class="col-lg-5" id="rowSoc">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_form" id="soc_form" onchange="combo_domicilio()">
                        <option value=""> -- Seleccione sociedad --</option>
                          <option value="00">SIN SOCIEDAD</option>
                          <?php while($s_c = $sociedades_can->fetch_assoc())
                          {?>
                            <option value="<?php echo $s_c['idempresa']?>"><?php echo $s_c['razonsocial']?></option>
                          <?php } ?>
                     </select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Banco:</label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="banco_form" name="banco_form" data-size="10" onchange="busca_cta()">
                      <option value="">-- Seleccione banco --</option>
                           <?php while($b_f= $bancos_form->fetch_assoc())
                              {?>
                                 <option value="<?php echo $b_f['idbancos']?>" data-subtext="<?php echo $b_f['cve_transfer']?>"><?php echo $b_f['nombre']?></option>

                              <?php } ?>
                      </select>
                  </div>
                   <label class="col-lg-1 control-label">Cuenta:</label>
                  <div class="col-lg-5">
                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cuenta_form" id="cuenta_form"></select>
                  </div>
                </div>
                 <div class="form-group row">
                 <label class="col-lg-1 control-label">Formato:</label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboFormato" name="cboFormato" data-size="10" >
                      <option value="">-- Seleccione formato --</option>
                      <option value="1">ACTIVACION</option> 
                      <option value="0">CANCELACION</option> 
                      <option value="2">BLOQUEO</option> 
                      </select>
                  </div>
                  <span style="color:#0F364D;">*Seleccione el formato a generar*</span>
                </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Comentarios:</label>
                <div class="col-md-9">
                  <textarea name="comentarios_form" class="form-control" id="comentarios_form" placeholder="Comentarios adicionales"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Logotipo:</label>
               <div class="col-lg-6">
                  <input id="logo_format" type="file" name="logo_format" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                </div>
                <span style="color:#0F364D;">*Logotipo opcional para el formato*</span>
              </div>
              <div id="resultados"></div>
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
                    <button type="submit" id="saveImage" class="btn btn-danger" data-action="save" role="button"><i class="fa fa-file-pdf-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal actualizacion de datos -->
<div class="modal fade" id="modalActDatos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Formato de actualización de datos</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
          <form name="formatoDatos" id="formatoDatos" method="POST" action="ajax.php?c=reportes&f=formatoDatos" onsubmit="return false;">
            <!-- content goes here -->
             <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:<span style="color:#A21B1B">*</span></label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_dat" id="plaza_dat">
                        <option value="">-- Seleccione plaza --</option>
                        <?php while($p_d = $plazas_datos->fetch_assoc())
                        {?>
                           <option value="<?php echo $p_d['idplaza']?>"><?php echo $p_d['plaza']?></option>

                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                  <label class="control-label col-md-1">Sociedad:<span style="color:#A21B1B">*</span></label>
                   <div class="col-lg-5" id="rowSoc">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_dat" id="soc_dat" >
                        <option value=""> -- Seleccione sociedad --</option>
                          <option value="00">SIN SOCIEDAD</option>
                          <?php while($s_d = $sociedades_datos->fetch_assoc())
                          {?>
                            <option value="<?php echo $s_d['idempresa']?>"><?php echo $s_d['razonsocial']?></option>
                          <?php } ?>
                     </select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Banco:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="banco_dat" name="banco_dat" data-size="10" onchange="busca_cta_dat()">
                      <option value="">-- Seleccione banco --</option>
                           <?php while($b_d= $bancos_datos->fetch_assoc())
                              {?>
                                 <option value="<?php echo $b_d['idbancos']?>" data-subtext="<?php echo $b_d['cve_transfer']?>"><?php echo $b_d['nombre']?></option>

                              <?php } ?>
                      </select>
                  </div>
                   <label class="col-lg-1 control-label">Cuenta:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-5">
                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cuenta_dat" id="cuenta_dat"></select>
                  </div>
                </div>
                 <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-2">Tipo de formato:</label>
                  <div class="col-md-5">
                  <select class="form-control" name="fto_datos" id="fto_datos">
                    <option value="">-- Seleccione un formato --</option>
                    <option value ="1">Actualización firmantes </option>
                    <option value ="2">Actualización domicilio </option>
                  </select>
                  </div>
              </div>
               <div class="form-group row">
                 <label class="col-lg-2 control-label">Firmante #2:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-6">
                     <input class="form-control" id="firm_dat" name="firm_dat"></input>
                  </div>
                </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Comentarios:</label>
                <div class="col-md-9">
                  <textarea name="comentarios_dat" class="form-control" id="comentarios_dat" placeholder="Comentarios adicionales"></textarea>
                </div>
              </div>
        <div id="load_cheq" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons3" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" id="saveImage" class="btn btn-danger" data-action="save" role="button"><i class="fa fa-file-pdf-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- modal para generar el formato de entrega de cuenta -->
<div class="modal fade" id="modalEntregaCheq" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-file-pdf-o"></i>  Formato de entrega de chequera</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
          <form name="FormChequera" id="FormChequera" method="POST" action="ajax.php?c=reportes&f=entregaChequera" onsubmit="return false;">
            <!-- content goes here -->
             <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-1">Plaza:<span style="color:#A21B1B">*</span></label>
                  <div class="col-md-5">
                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_cheq" id="plaza_cheq">
                        <option value="">-- Seleccione plaza --</option>
                        <?php while($pl_ca= $plazas_cheq->fetch_assoc())
                        {?>
                           <option value="<?php echo $pl_ca['idplaza']?>"><?php echo $pl_ca['plaza']?></option>

                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                  <label class="control-label col-md-1">Sociedad:<span style="color:#A21B1B">*</span></label>
                   <div class="col-lg-5" id="rowSoc">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_cheq" id="soc_cheq" >
                        <option value=""> -- Seleccione sociedad --</option>
                          <option value="00">SIN SOCIEDAD</option>
                          <?php while($soc_cheq = $sociedades_cheq->fetch_assoc())
                          {?>
                            <option value="<?php echo $soc_cheq['idempresa']?>"><?php echo $soc_cheq['razonsocial']?></option>
                          <?php } ?>
                     </select>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-1 control-label">Banco:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-5">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="banco_cheq" name="banco_cheq" data-size="10" onchange="busca_cta_cheq()">
                      <option value="">-- Seleccione banco --</option>
                           <?php while($ban_cheq= $bancos_cheq->fetch_assoc())
                              {?>
                                 <option value="<?php echo $ban_cheq['idbancos']?>" data-subtext="<?php echo $ban_cheq['cve_transfer']?>"><?php echo $ban_cheq['nombre']?></option>

                              <?php } ?>
                      </select>
                  </div>
                   <label class="col-lg-1 control-label">Cuenta:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-5">
                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cuenta_cheq" id="cuenta_cheq"></select>
                  </div>
                </div>
              <div class="form-group row">
                  <label for="exampleInputEmail1" class="col-md-2">Entregar chequera a:<span style="color:#A21B1B">*</span></label>
                  <div class="col-md-7">
                     <input class="form-control" id="entregar_cheq" name="entregar_cheq"></input>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-lg-1" id="loader_cheq" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                  <label class="control-label col-md-2">Numero de IFE:<span style="color:#A21B1B">*</span></label>
                   <div class="col-lg-6" id="rowSoc">
                     <input class="form-control" id="ife_cheq" name="ife_cheq"></input>
                  </div>
                </div>
                 <div class="form-group row">
                 <label class="col-lg-2 control-label">Representante legal:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-6">
                     <input class="form-control" id="rep_legal" name="rep_legal"></input>
                  </div>
                </div>
               <div class="form-group row">
                 <label class="col-lg-2 control-label">Firmante #2:<span style="color:#A21B1B">*</span></label>
                  <div class="col-lg-6">
                     <input class="form-control" id="firmante2" name="firmante2"></input>
                  </div>
                </div>
              <div class="form-group row">
                <label for="" class="col-md-2">Comentarios:</label>
                <div class="col-md-9">
                  <textarea name="comentarios_cheq" class="form-control" id="comentarios_cheq" placeholder="Comentarios adicionales"></textarea>
                </div>
              </div>
        <div id="load_cheq" style="display:none;" class="col-md-10 col-md-offset-2">
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
                    <button type="submit" id="saveImage" class="btn btn-danger" data-action="save" role="button"><i class="fa fa-file-pdf-o"></i>  Generar archivo</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

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
<script src="./js/menu-cuentas.js"></script>