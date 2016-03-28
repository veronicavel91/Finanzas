<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<script src="./js/alta-cuenta.js"></script>
<div class="container cont-principal">
<div class="row">
            <section>
            <div class="col-lg-12">
                    <div class="page-header">
                        <h2 class="title">Alta de cuentas</h2>
                    </div>

                    <form id="defaultForm" method="post" class="form-horizontal">
                     <div class="form-group hide">
                            <div class="col-lg-9 col-lg-offset-2 alert alert-danger">
                                <strong><i class="fa fa-exclamation-triangle"></i>  Corrija los siguientes errores:</strong>
                                <ul id="errors"></ul>
                            </div>
                        </div>
                    	 <div class="form-group">
                        <label class="col-lg-2 control-label">Plaza:<span style="color:#960C0C">*</span></label>
                        <div class="col-lg-4">
                            <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="100%" name="cboPlaza" id="cboPlaza" >
                                <option value="">-- Seleccione plaza --</option>
                                <?php while($plaza= $plazas->fetch_assoc())
                                {?>
                                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                        <label class="control-label col-md-1">Sociedad:<span style="color:#960C0C">*</span></label>
                         <div class="col-lg-4" id="rowSoc">
                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad">
                             <option value=""> -- Seleccione sociedad --</option>
                             
                             <?php while($s_cta= $sociedades_cta->fetch_assoc())
                                {?>
                                   <option value="<?php echo $s_cta['idempresa']?>"><?php echo $s_cta['razonsocial']?></option>

                                <?php } ?>
                           </select>
                        </div>
                    </div>
                <div class="col-lg-12">
                    <br>
                    <ul class="nav nav-tabs">
                        <li class="active tab-title"><a href="#cuenta-tab" data-toggle="tab"> Datos de la cuenta <i class="fa"></i></a></li>
                        <li><a href="#domicilio-tab" class="tab-title" data-toggle="tab">Domicilio <i class="fa"></i></a></li>
                        <li><a href="#usuario-tab" class="tab-title" data-toggle="tab">Usuario cuenta <i class="fa"></i></a></li>
                        <li><a href="#responsable-tab" class="tab-title" data-toggle="tab">Responsable <i class="fa"></i></a></li>
                        <li><a href="#firmante-tab" class="tab-title" data-toggle="tab">Firmantes <i class="fa"></i></a></li>
                        <li><a href="#chequera-tab" class="tab-title" data-toggle="tab">Chequera <i class="fa"></i></a></li>
                        <li><a href="#token-tab" class="tab-title" data-toggle="tab">Token <i class="fa"></i></a></li>
                        <li><a href="#preguntas-tab" class="tab-title" data-toggle="tab">Preguntas secretas<i class="fa"></i></a></li>
                    </ul>
                        <div class="tab-content">
                        <br>
                            <div class="tab-pane active" id="cuenta-tab">
                                <div class="form-group">
                                <div class="group">
                                    <label class="col-lg-2 control-label">Banco: <span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-4">
                                       <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="bank" name="bank" data-size="10" data-bv-notempty data-bv-notempty-message="Seleccione el banco de la cuenta" onchange="busca_sucursal()">
                                        <option value="">-- Seleccione banco --</option>
                                        	 <?php while($banco= $bancos->fetch_assoc())
                                                {?>
                                                   <option value="<?php echo $banco['idbancos']?>" data-subtext="<?php echo $banco['cve_transfer']?>"><?php echo $banco['nombre']?></option>

                                                <?php } ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="group">
                                     <label class="col-lg-1 control-label">Cuenta:<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-3">
                                       <input type="text" class="form-control" maxlength="15" id="cta" name="cta" data-bv-group=".group">
                                    </div>
                                  </div>
                                </div>
                                 <div class="form-group">
                                   <div class="group">
                                        <label class="col-lg-2 control-label">Sucursal:</label>
                                        <div class="col-lg-4">
                                        <select class="form-control" name="sucursal" id="sucursal" data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                      <label class="btn btn-warning btn-xs" onclick="modal_sucursal()"><i class="fa fa-plus"></i></label>
                                    </div>
                                </div>
                              <div class="form-group">
                                  <div class="group">
                                    <label class="col-lg-2 control-label">Tipo cuenta:</label>
                                    <div class="col-lg-3">
                                       <select name="tipo_cuenta" id="tipo_cuenta" class="form-control">
                                         <option value="">-- Seleccione el tipo --</option>
                                         <option value="Normal">Normal</option>
                                         <option value="Empresarial">Empresarial</option>
                                       </select>
                                    </div>
                                  </div>
                                   <div class="group">
                                         <label class="col-lg-2 control-label">Clabe interbancaria:<span style="color:#960C0C">*</span></label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" name="clabe" id="cbe" data-bv-group=".group"/>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                     <div class="group">
                                         <label class="col-lg-2 control-label">No. cliente:</label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" name="no_cliente" id="no_cliente" data-bv-group=".group"/>
                                        </div>
                                    </div>
                                     <div class="group">
                                        <label class="col-lg-2 control-label">No.contrato:<span style="color:#960C0C">*</span></label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" name="no_contrato" id="cont" data-bv-group=".group" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <div class="group">
                                 <label class="col-lg-2 control-label">Fecha apertura:</label>
                                    <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="f_alta" id="f_alta" placeholder="dd-mm-aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="group">
                                    <label class="col-lg-2 control-label">Area operacion:<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-3">
                                         <select id="area" class="form-control" name="area" data-bv-group=".group">
                                         <option value="">-- Seleccione area --</option>
                                            <?php while($area= $areas->fetch_assoc())
                                                {?>
                                                   <option value="<?php echo $area['idarea_operacion']?>"><?php echo $area['nombre']?></option>

                                                <?php } ?>
                                         </select>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="group">
                                 <label class="col-lg-2 control-label">Tipo operación:<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-3">
                                      <select class="form-control" name="tipo_op" id="tipo_op">
                                        <option value=""> -- Seleccione operacion --</option>
                                        <option value="F1">F1</option>
                                        <option value="F2">F2</option>
                                        <option value="RCI">RCI</option>
                                        <option value="GENTEX">GENTEX</option>
                                      </select>
                                    </div>
                                </div>
                                 <div class="group">
                                    <label class="col-lg-2 control-label">Contrato por nomina:<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-3">
                                         <select id="contrato_nomina" class="form-control" name="contrato_nomina" data-bv-group=".group">
                                            <option value="">-- Seleccione --</option>
                                            <option value="Si">Si</option>
                                            <option value="Otros">Otros</option>
                                         </select>
                                    </div>
                                </div>
                            </div>
                           
                                <div class="form-group">
                                <div class="group">
                                    <label class="col-lg-2 control-label">Estado cuenta:</label>
                                    <div class="col-lg-3">
                                         <select id="status_cta" class="form-control" name="status_cta" onChange="mostrar(this.value);">
                                           <?php while($est= $estados_cuenta->fetch_assoc())
                                            {?>
                                               <option value="<?php echo $est['idstatus_cuenta']?>"><?php echo $est['nombre']?></option>

                                            <?php } ?>
                                         </select>
                                    </div>
                                 </div>
                                </div>
                                <div class="form-group" id="extra" style="display:none;">
                                      <div class="col-md-12" style="background: #ECECEC; border-radius: 5px; padding: 1%;">
                                                <label class="col-lg-1 control-label">Folio:</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="folio" id="folio">
                                                </div>
                                                <label class="col-md-1">Fecha:</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="fecha_bloq" id="fecha_bloq">
                                                </div>
                                                <label class="col-md-2">Observaciones:</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" name="coment" id="coment"></textarea>
                                                </div>
                                        </div>
                                </div>
                                   <div class="form-group">
                                    <label class="col-lg-2 control-label">Saldo inicial:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control input-lg" name="saldo_inicial" id="saldo_inicial" />
                                    </div>
                                     <label class="col-lg-1 control-label">Moneda:</label>
                                    <div class="col-lg-3">
                                        <select name="moneda" id="moneda" class="form-control" data-bv-group=".group">
                                          <option value="MXN">MXN</option>
                                          <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                             <div class="form-group">
                            <div class="col-lg-5 col-lg-offset-4">
                            <br><br>
                                <button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i>  Guardar/Dar de alta</button>
                            </div>
                        </div>

                            </div>
                              <div class="tab-pane" id="domicilio-tab">
                                <div class="form-group">
                                  <label class="col-lg-3 control-label">¿Cuenta con domicilio?<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-4">
                                      <select name="preg_dom" id="preg_dom" class="form-control" onchange="show_dom()">
                                        <option value="">-- Seleccione --</option>
                                        <option value="1">Si</option>
                                        <option value="2">No</option>
                                      </select>
                                    </div>
                                </div>
                                <div id="muestraDom" style="display:none;">
                                  <div class="form-group">
                                    <div class="group">
                                        <label class="col-lg-2 col-lg-offset-1 control-label">Domicilio:</label>
                                        <div class="col-lg-4">
                                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" name="domicilio" id="cboDom" >
                                                <option value="">-- Seleccione domicilio --</option>
                                               <?php while($dom= $domicilios->fetch_assoc())
                                                {?>
                                                   <option value="<?php echo $dom['id_domicilio']?>"><?php echo $dom['domicilio']?></option>

                                                <?php } ?>
                                           </select>
                                        </div>
                                        <div class="col lg-1">
                                            <label class="btn btn-primary btn-xs" onclick="modalDomicilio()">Agregar domicilio <label>
                                        </div>  
                                    </div>
                                  </div>
                                  <div class="form-group">
                                       <label class="col-lg-2 col-lg-offset-1 control-label">Periodo inicio:</label>
                                          <div class="col-lg-2 date">
                                              <div class="input-group input-append date" id="datePicker">
                                                  <input type="text" class="form-control" name="dom_ini" id="dom_ini" placeholder="dd-mm-aaaa" />
                                                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                              </div>
                                          </div>
                                           <label class="col-lg-1 control-label">Fin:</label>
                                          <div class="col-lg-2 date">
                                              <div class="input-group input-append date" id="datePicker">
                                                  <input type="text" class="form-control" name="dom_fin" id="dom_fin" placeholder="dd-mm-aaaa" />
                                                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                              </div>
                                          </div>
                                  </div>
                                </div>
                                <br><br>
                            </div><!-- /#responsable-tab -->
                             <div class="tab-pane" id="usuario-tab">
                                   <div class="form-group">
                                      <label class="col-lg-2 control-label">Personal:<span style="color:#960C0C">*</span></label>
                                      <div class="col-lg-4">
                                          <select name="personal_tipo" id="personal_tipo" onchange="tipoPer()" class="form-control">
                                            <option value="">-- Tipo de personal --</option>
                                            <option value="1">Interno</option>
                                            <option value="2">Externo</option>
                                            <option value="00">Sin usuario de cuenta</option>
                                          </select>
                                      </div>
                                </div>
                                <div id="interno" style="display:none;">
                                  <div class="form-group">
                                        <label class="col-lg-2 control-label">Plaza usuario:</label>
                                        <div class="col-lg-4">
                                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_user" id="plaza_user" >
                                                <option value="">-- Seleccione plaza --</option>
                                                <option value="00">Sin plaza</option>
                                                <?php while($pz= $pzs->fetch_assoc())
                                                {?>
                                                   <option value="<?php echo $pz['idplaza']?>"><?php echo $pz['plaza']?></option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1" id="loader_user" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                                        <label class="control-label col-md-2">Sociedad usuario:</label>
                                         <div class="col-lg-4" id="rowSoc">
                                           <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_user" id="soc_user" bv-group=".group" >
                                              <option value=""> -- Seleccione sociedad --</option>
                                              <option value="00">SIN SOCIEDAD</option>
                                              <?php while($s_us= $sociedades_us->fetch_assoc())
                                              {?>
                                                <option value="<?php echo $s_us['idempresa']?>"><?php echo $s_us['razonsocial']?></option>
                                              <?php } ?>
                                           </select>
                                        </div>
                                </div>
                                <div class="form-group">
                                <label for="" class="control-label col-lg-2">Usuario:</label>
                                     <div class="col-lg-4">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="user" id="user">
                                            <option value="">-- Seleccione usuario --</option>
                                            <?php while($u= $users->fetch_assoc())
                                              {
                                                  echo '<option  value="'.$u['Id_empleado'].'">'.$u['nombre_emp'].'</option>'; 
                                               } ?>
                                        </select>
                                    </div>
                                </div>
                                </div>
                                 <div id="externo" style="display:none;">
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Usuario externo:</label>
                                    <div class="col-lg-4">
                                      <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="usuario_ext" id="usuario_ext">
                                      </select>
                                    </div>
                                    <div class="col-lg-1">
                                      <label for="" class="btn btn-warning btn-xs" onclick="modalExterno()"><i class="fa fa-plus"></i></label>
                                    </div>
                                  </div>
                                </div>
                                

                                <br><br>
                            </div><!-- /#responsable-tab -->
                            <div class="tab-pane" id="responsable-tab">
                              <div class="form-group">
                                <label class="col-lg-2 control-label">¿Tiene responsable?<span style="color:#960C0C">*</span></label>
                                <div class="col-lg-3">
                                   <select class="form-control" id="preg_resp" name="preg_resp" onchange="pregResp()">
                                      <option value="">-- Seleccione --</option>
                                      <option value="1">Si</option>
                                      <option value="0">No</option>
                                    </select>
                                </div>
                              </div>
                              <div id="divSi" style="display:none;">
                                <div class="form-group">
                                  <label class="col-lg-2 control-label">Plaza:</label>
                                  <div class="col-lg-3">
                                    <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-default" data-size="10" data-width="100%" name="plazaResp" id="plazaResp" >
                                      <option value="">-- Seleccione plaza --</option>
                                      <option value="00">Sin plaza</option>
                                      <?php while($p_resp= $p_responsables->fetch_assoc())
                                      {?>
                                         <option value="<?php echo $p_resp['idplaza']?>"><?php echo $p_resp['plaza']?></option>

                                      <?php } ?>
                                    </select>
                                  </div>
                                  <label class="col-lg-1 control-label">Sociedad:</label>
                                  <div class="col-lg-4" id="rowSoc">
                                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-default" data-size="10" data-width="100%" name="soc_resp" id="soc_resp">
                                              <option value=""> -- Seleccione sociedad --</option>
                                                <option value="00">SIN SOCIEDAD</option>
                                                <?php while($s_resp= $sociedades_resp->fetch_assoc())
                                                {?>
                                                  <option value="<?php echo $s_resp['idempresa']?>"><?php echo $s_resp['razonsocial']?></option>
                                                <?php } ?>
                                          </select>
                                  </div>
                                </div>
                                  <div class="form-group">
                                   <label class="col-lg-2 control-label">Tipo:</label>
                                      <div class="col-lg-3">
                                          <select name="tipo_resp" id="tipo_resp" class="form-control" onChange="responsable()">
                                              <option value="">-- Tipo responsable --</option>
                                              <option value="1">Empleado</option>
                                              <option value="2">Cliente</option>
                                          </select>
                                      </div>
                                      <div class="col-lg-1" id="load" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                                      <label class="col-lg-1 control-label">Responsable:</label>
                                      <div class="col-lg-4">
                                          <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="resp_cta" id="resp_cta" class="form-control"></select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">Observaciones:</label>
                                      <div class="col-lg-8">
                                         <textarea class="form-control" id="obs"></textarea>
                                      </div>
                                  </div>
                                </div>
                                <br><br>
                            </div><!-- /#responsable-tab -->
                             <div class="tab-pane" id="firmante-tab">
                               <div class="form-group">
                                    <label class="col-lg-2 control-label">Personal:<span style="color:#960C0C">*</span></label>
                                    <div class="col-lg-4">
                                        <select name="firmante_tipo" id="firmante_tipo" onchange="tipoFirm()" class="form-control">
                                          <option value="">-- Tipo de firmante --</option>
                                          <option value="1">Interno</option>
                                          <option value="2">Externo</option>
                                          <option value="00">Cuenta sin firmantes</option>
                                        </select>
                                    </div>
                                </div>
                              <div id="firmante-int"  style="display:none;">
                               <div class="form-group">
                                          <label class="col-lg-2 control-label">Plaza:</label>
                                          <div class="col-lg-4">
                                              <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="plaza_firm" id="plaza_firm">
                                                  <option value="">-- Seleccione plaza --</option>
                                                  <?php while($pz= $plzas->fetch_assoc())
                                                  {?>
                                                     <option value="<?php echo $pz['idplaza']?>"><?php echo $pz['plaza']?></option>

                                                  <?php } ?>
                                              </select>
                                                  <div class="col-lg-1" id="loader_firm" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                                          </div>
                                          <label class="control-label col-md-1">Sociedad:</label>
                                           <div class="col-lg-4" id="rowSoc">
                                             <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="soc_firm" id="soc_firm" bv-group=".group" >
                                                <option value=""> -- Seleccione sociedad --</option>
                                                <option value="00">SIN SOCIEDAD</option>
                                                <?php while($s_fir= $sociedades_fir->fetch_assoc())
                                                {?>
                                                  <option value="<?php echo $s_fir['idempresa']?>"><?php echo $s_fir['razonsocial']?></option>
                                                <?php } ?>
                                             </select>
                                          </div>
                                  </div>
                                  <div class="form-group">
                                   <label class="col-lg-1 control-label col-lg-offset-1">Firmante:</label>
                                      <div class="col-lg-4">
                                           <select data-live-search="true" class="selectpicker show-menu-arrow"  data-size="10" data-width="100%" name="firmante" id="firmante" placeholder="Textbox #1" />
                                              <option value="">-- seleccione persona --</option>
                                                <?php while($per= $firmantes->fetch_assoc())
                                                  {?>
                                                     <option value="<?php echo $per['Id_empleado']?>"><?php echo $per['nombre_emp']?></option>

                                                  <?php } ?>
                                          </select>
                                      </div>
                                      <div class="col-lg-3">
                                        <label class="btn btn-info btn-xs" onclick="guardaFirmante()"><i class="fa fa-save"></i>  Guardar firmante</label>
                                    </div>
                                    </div> 
                                  </div>
                                    <div id="firmante-ext" style="display:none;">
                                       <div class="form-group">
                                          <label class="col-lg-2 control-label">Firmante externo:</label>
                                          <div class="col-lg-4">
                                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="firm_ext" id="firm_ext">
                                            </select>
                                          </div>
                                          <div class="col-lg-1">
                                            <label for="" class="btn btn-warning btn-xs" onclick="modalExterno()"><i class="fa fa-plus"></i></label>
                                          </div>
                                           <div class="col-lg-3">
                                        <label class="btn btn-info btn-xs" onclick="guardaFirmante()"><i class="fa fa-save"></i>  Guardar firmante</label>
                                    </div>
                                        </div>
                                       
                                    </div>
                                <div class="col-lg-11">  
                                    <table id="firmante-table"  data-locale="es-MX"></table>
                                </div>
                            </div><!-- /#responsable-tab -->
                            <div class="tab-pane" id="chequera-tab">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Responsable:</label>
                                    <div class="col-lg-4">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="resp_cheq" id="resp_cheq">
                                            <option value="">-- seleccione usuario --</option>
                                            <option value="00">Sin responsable</option>
                                              <?php while($responsable= $responsables->fetch_assoc())
                                                {?>
                                                    <option value="<?php echo $responsable['Id_empleado']?>"><?php echo $responsable['nombre_emp']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label">fecha asignación:</label>
                                   <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="fecha_asig">
                                            <input type="text" class="form-control" name="f_asig" id="f_asig" placeholder="dd-mm-aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                 <div class="group">
                                    <label class="col-lg-2 control-label">Folio chequera:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="folio_cheq" name="folio_cheq"  />
                                    </div>
                                 </div>
                                 <div class="group">
                                    <label class="col-lg-2 control-label">No.cheques:</label>
                                    <div class="col-lg-2">
                                        <input type="number" class="form-control" name="no_cheques" id="no_cheques" data-bv-group=".group" />
                                    </div>
                                  </div> 
                                </div>
                                   <div class="form-group">
                                    <label class="col-lg-2 control-label">Cheque inicial:</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" name="cheque_inicial" id="cheque_inicial"  />
                                    </div>
                                    <label class="col-lg-2 control-label">Cheque final:</label>
                                    <div class="col-lg-2">
                                        <input type="number" class="form-control" name="cheque_final" id="cheque_final"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Estado:</label>
                                    <div class="col-lg-4">
                                      <select name="status_chequera" id="status_chequera" class="form-control">
                                          <option value="1">Activa</option>
                                          <option value="2">Cancelada</option>
                                          <option value="3">Bloqueada</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Observaciones:</label>
                                    <div class="col-lg-6">
                                     <textarea name="obs_cheque" class="form-control" id="obs_cheque" ></textarea>
                                    </div>
                                </div>
       
                            </div> <!-- /#chequera-tab -->

                             <div class="tab-pane" id="token-tab">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Codigo/no.serie:</label>
                                    <div class="col-lg-4">
                                       <input type="text" name="cod_token" id="cod_token" class="form-control">
                                    </div>
                                    <label class="col-lg-2 control-label">fecha asignación:</label>
                                   <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="fecha_token">
                                            <input type="text" class="form-control" name="f_token" id="f_token" placeholder="dd-mm-aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                               <label for="" class="col-lg-2 control-label">Responsable:</label>
                                    <div class="col-lg-5">
                                        <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="resp_token" id="resp_token">
                                          <option value="">-- Seleccione responsable --</option>
                                          <option value="00">Sin responsable</option>
                                          <?php while($p= $personal->fetch_assoc())
                                                    {
                                                        echo '<option  value="'.$p['Id_empleado'].'">'.$p['nombre_emp'].'</option>'; 
                                                     } ?>

                                        </select>
                                    </div>
                            </div>
                                 <div class="form-group">
                                    <label class="col-lg-2 control-label">¿Este token tiene vencimiento?</label>
                                    <div class="col-lg-3">
                                        <select name="vence" id="vence" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Si</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label">Vencimiento aprox:</label>
                                      <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="fecha_vence">
                                            <input type="text" class="form-control" name="f_vence" id="f_vence" placeholder="dd-mm-aaaa" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                    
                                </div>
                                   <div class="form-group">
                                    <label class="col-lg-2 control-label">Comentarios:</label>
                                    <div class="col-lg-7">
                                       <textarea name="obs_token" id="obs_token" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
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
       
                            </div> <!-- /#token-tab -->
                              <div class="tab-pane" id="preguntas-tab">
                                    <div class="form-group">
                                         <label class="col-lg-1 control-label col-lg-offset-1">Pregunta:</label>
                                            <div class="col-lg-7">
                                                <textarea name="preg" id="preg" cols="1" rows="1" class="form-control"></textarea>
                                            </div>                                        
                                    </div>
                                    <div class="form-group">
                                         <label class="col-lg-1 control-label col-lg-offset-1">Respuesta:</label>
                                            <div class="col-lg-7">
                                                <textarea name="resp_preg" id="resp_preg" class="form-control" cols="1" rows="1"></textarea>
                                            </div>    
                                             <div class="col-lg-2">
                                            <label class="btn btn-info btn-sm" id="btn-preg" onclick="guardarPregunta()"><i class="fa fa-plus"></i>  Agregar</label>
                                        </div>
                                        <div class="col-lg-1" id="load-preg" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>                                    
                                    </div>
                                <div class="col-lg-11 ">  
                                    <table id="preguntas-table"  data-locale="es-MX" ></table>
                                </div>
                            </div><!-- /#responsable-tab -->

                        </div>
                      
                    </form>
                </div>
            </section>
        </div>
<!-- modal borrar -->
<div class="modal fade" id="esperar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <h3 class="modal-title" id="lineModalLabel">Guardando cuenta, por favor espere ...</h3>
        </div>
        <div class="modal-body">
        <div id="loading" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok" style="display:none;" class="alert alert-success">
            <h3><i class="fa fa-info-circle"></i>  ¡La cuenta ha sido creado exitosamente! </h3>
        </div>
        </div>
        <div class="modal-footer">
        <div id="button">
           <button class="pull-right btn btn-default" onclick="aceptar()">Aceptar</button>
        </div>
        </div>
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
         <div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog"  style="width:85%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-home"></i>  Domicilios registrados</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                          <label for="" class="col-lg-1 col-lg-offset-1">Cp:</label>
                        <div class="col-lg-2">
                            <div class="input-group">
                            
                              <input type="text" class="form-control" id="cp" class="cp" placeholder="00000">
                              <span class="input-group-btn">
                                <button class="btn btn-info" type="button" onclick="busca_cp()" style="height:39px;"><i class="fa fa-search"></i></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                            <input type="hidden" id="id_cp">
                            <label for="" class="col-lg-1">Colonia:</label>
                            <div class="col-lg-4">
                              <select data-live-search="true" class="selectpicker show-menu-arrow" onchange="busca_datos()" data-size="10" data-width="100%" name="cboCol" id="cboCol">
                                </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-1 col-lg-offset-1">Municipio:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="mpo_cp" name="mpo_cp" disabled="true">
                            </div>
                              <label for="" class="col-lg-1">Estado:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="edo_cp" name="edo_cp" disabled="true">
                            </div>
                        </div>

                        <div class="form-group row">
                             <label for="" class="col-lg-1 col-lg-offset-1">Calle:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle">
                            </div>
                            <label for="" class="col-lg-1">No.ext:</label>
                             <div class="col-lg-2">
                              <input type="text" class="form-control" id="ext" name="ext" placeholder="ext">
                            </div>
                             <label for="" class="col-lg-1">No.int:</label>
                            <div class="col-lg-1">
                              <input type="text" class="form-control" id="int" name="int" placeholder="int">
                            </div>
                          </div>
                        <div class="form-group row">
                            <label class="col-lg-1 col-lg-offset-1 control-label">  Periodo del:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="inicio_dom" id="inicio_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <label  class="col-lg-1 control-label">al:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="fin_dom" id="fin_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                          <label  class="col-lg-2 col-lg-offset-1 control-label">Informacion extra:</label>
                          <div class="col-lg-7">
                                  <textarea  class="form-control" id="info_extra" name="info_extra"></textarea>
                          </div>
                           <div class="col-lg-2">
                                <button class="btn btn-info btn-sm " id="btn-cp" onclick="guarda_dom()"><i class="fa fa-plus"></i>  Agregar</button> 
                            </div>
                           <div class="col-lg-1" id="loader-dom" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                           <br><br>
                        </div>
                        <br>
                        <table id="table-domicilios"
                               data-toggle="table"
                               data-height="300" >
                            <thead>
                            <tr>
                                <th data-field="id">Id</th>
                                <th data-field="cp">CP</th>
                                <th data-field="col">Colonia</th>
                                <th data-field="calle">Calle</th>
                                <th data-field="num_ext">Ext</th>
                                <th data-field="num_int">Int</th>
                                <th data-field="inicio">Inicio</th>
                                <th data-field="fin">Fin</th>
                                <th data-field="estado">Estado</th>
                                <th data-field="Acciones" data-formatter="FormatterDomicilio" data-events="eventsDomicilio">Acciones</th>
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
        <!-- Modal registro de usuarios externos -->
        <div class="modal fade" id="modalExterno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i>  Personal externo</h4>
            </div>
            <div class="modal-body">
           <div class="form-group row">
              <label for="" class="col-lg-2">Nombre:</label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="n_externo" id="n_externo">
                </div>
              </div>
            <div class="form-group row">
              <label for="" class="col-lg-2">RFC:</label>
                <div class="col-lg-5">
                  <input type="text" class="form-control" name="rfc_ext" id="rfc_ext">
                </div>
                 <div class="col-lg-2">
                    <span style="color:#797979;font-size:12px;">* Opcional *</span>
                  </div>
              </div>
               <div class="form-group row">
              <label for="" class="col-lg-3">Observaciones:</label>
                <div class="col-lg-7">
                  <input type="text" class="form-control" name="obs_ext" id="obs_ext">
                </div>
                  <div class="col-lg-1" id="load-externo" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                 <div class="col-lg-1">
              <button class="btn btn-info btn-xs" id="nuevo_aut" onclick="nuevo_externo()"><i class="fa fa-plus"></i>  Agregar</button>
                  <br><br>
              </div>
              </div>
                <table id="table-externos"
                       data-toggle="table"
                       data-height="299" 
                       data-url="ajax.php?c=cuentas&f=personal_externo&plaza=0&soc=0">
                    <thead>
                    <tr>
                        <th data-field="Id">Id</th>
                        <th data-field="nombre">Nombre completo</th>
                        <th data-field="rfc">RFC</th>
                        <th data-field="obs">Observaciones</th>
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
<!-- Modal registro de sucursales bancarias -->
        <div class="modal fade" id="modal_suc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:40%">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-university"></i>  Sucursales bancarias</h4>
            </div>
            <div class="modal-body">
           <div class="form-group row">
              <label for="" class="col-lg-2">Numero:</label>
                <div class="col-lg-5">
                  <input type="text" class="form-control" name="num_suc" id="num_suc">
                </div>
              </div>
            <div class="form-group row">
              <label for="" class="col-lg-2">Nombre:</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="nombre_suc" id="nombre_suc">
                </div>
                <div class="col-lg-1">
                  <button class="btn btn-primary btn-sm" id="btn-suc"onclick="guarda_suc()">Guardar</button>
                </div>
                 <div class="col-lg-1" id="loader_suc" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
              </div>
                <table id="table-sucursal"
                       data-toggle="table"
                       data-height="299" 
                       data-url="ajax.php?c=cuentas&f=sucursales_banco">
                    <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="num_suc">Numero</th>
                        <th data-field="nombre">Nombre sucursal</th>
                         <th data-field="Acciones" data-formatter="FormatterAccionesSuc" data-events="tablaSucEvents" >Borrar</th>
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
<!-- Modal para editar el domicilio -->
<div class="modal fade" id="editar-domicilio" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:68%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i>  Editar domicilio</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
    <input type="hidden" id="edit_id_dom">
          <div class="form-group row">
                          <label for="" class="col-lg-1 col-lg-offset-1">Cp:</label>
                        <div class="col-lg-2">
                            <div class="input-group">
                            
                              <input type="text" class="form-control" id="edit_cp" class="cp" placeholder="00000">
                              <span class="input-group-btn">
                                <button class="btn btn-info" type="button" onclick="busca_cp()" style="height:39px;"><i class="fa fa-search"></i></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                            <input type="hidden" id="edit_id_cp">
                            <label for="" class="col-lg-1">Colonia:</label>
                            <div class="col-lg-4">
                              <select data-live-search="true" class="selectpicker show-menu-arrow" onchange="busca_datos()" data-size="10" data-width="100%" name="edit_cboCol" id="edit_cboCol">
                                </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-1 col-lg-offset-1">Municipio:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="edit_mpo_cp" name="edit_mpo_cp" disabled="true">
                            </div>
                              <label for="" class="col-lg-1">Estado:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="edit_edo_cp" name="edo_cp" disabled="true">
                            </div>
                        </div>

                        <div class="form-group row">
                             <label for="" class="col-lg-1 col-lg-offset-1">Calle:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="edit_calle" name="calle" placeholder="Calle">
                            </div>
                            <label for="" class="col-lg-1">No.ext:</label>
                             <div class="col-lg-2">
                              <input type="text" class="form-control" id="edit_ext" name="ext" placeholder="ext">
                            </div>
                             <label for="" class="col-lg-1">No.int:</label>
                            <div class="col-lg-2">
                              <input type="text" class="form-control" id="edit_int" name="int" placeholder="int">
                            </div>
                          </div>
                          <div class="form-group row">
                              <label for="" class="col-lg-3 col-lg-offset-1">Información adicional:</label>
                              <div class="col-lg-7">
                                  <textarea  class="form-control" id="info_extra" name="edit_info_extra"></textarea>
                              </div>
                          </div>
                        <div class="form-group row">
                          <label class="col-lg-1 col-lg-offset-1 control-label">  Estado:</label>
                          <div class="col-lg-3">
                            <select name="status_dom" id="edit_status_dom" class="form-control">
                              <option value="">-- Seleccione --</option>
                              <option value="1">Activo</option>
                              <option value="0">Cancelado</option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <span style="color:#6B2323;">*ATENCION: El cambio de estado del domicilio afecta a las cuentas bancarias con este domicilio*</span>
                          </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-1 col-lg-offset-1 control-label">  Periodo del:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="inicio_dom" id="edit_inicio_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <label  class="col-lg-1 control-label">al:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="fin_dom" id="edit_fin_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label  class="col-lg-3 col-lg-offset-1 control-label">Información extra:</label>
                          <div class="col-lg-7">
                                  <textarea  class="form-control" id="info_extra" name="info_extra"></textarea>
                          </div>
                           <div class="col-lg-1" id="loader-dom-edit" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                           <br><br>
                        </div>
                        <br><br>
    </div>
  </div>
<div class="btn-group btn-group-justified" role="group" id="buttons_agrega_cheq" aria-label="group button">
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
      </div>
      <div class="btn-group" role="group">
          <button class="btn btn-info pull-right addButton"  data-template="textbox" id="up_dom" onclick="update_dom()"><i class="fa fa-refresh"></i>  Actualizar datos</button>
      </div>
</div>
</div>
    </div>
</div>
<script> 

function busca_cp() {

    if ($("#cp").val().length == 5) {
         $str = "id=" +$('#cp').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol").html($data);
           $('#cboCol').selectpicker('refresh');

        }
        })
    }
    else
    {
        alert("El C.P debe estar conformado por 5 digitos");
    }

  }
 
 function muestra_periodo()
    {
    $('#muestra_periodo').show();
    $('#msg-per').show();
    $('#dom_fin').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
}
 function modalDomicilio()
    {
          if(document.getElementById("cboPlaza").value=="00" || document.getElementById("cboSociedad").value=="00")
        {
            alert("Seleccione la plaza y la sociedad primero");
        }
        else
        {
        $('#modalDomicilio').modal('show');
         $('#table-domicilios').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_domicilio&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
        }
    }
      function busca_datos()
    {
        $str = "cp=" +  $('#cp').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=datos_cp",
        success:function (data){
            var json_obj = $.parseJSON(data);//parse JSON
            
            for (var i in json_obj) 
            {
                $('#mpo_cp').val(json_obj[i].mun);
                $('#edo_cp').val(json_obj[i].edo);
              
            }

        }
    })
    }

      function guarda_dom()
    {

       $('#btn-cp').hide();
       $('#loader-dom').show();
       $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() + "&cp=" + $('#cboCol').val() +"&calle=" + $('#calle').val() +"&ext=" + $('#ext').val() + "&int=" + $('#int').val() + "&inicio=" + $('#inicio_dom').val() + "&fin=" + $('#fin_dom').val() + "&info=" + $('#info_extra').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=guarda_domicilio",
            success:function ($databack)
            {
                if($databack==1)
                {
                    $('#loader-dom').hide();
                    show_stack_bar_top('success','¡Guardado!','Domicilio guardado exitosamente');
                    $('#btn-cp').show();
                    $('#table-domicilios').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_domicilio'});
                    combo_domicilio();
                    
                }
                 else
                {
                     $('#loader-dom').hide();
                    $('#btn-cp').show();
                    alert("Lo sentimos ha ocurrido un error al  guardar el domicilio, intentelo de nuevo");
                }  
            }
        })  
        //limpiamos las cajas de texto
        $('#mpo_cp').val("");
        $('#cp').val("");
        $("#cboCol").empty();
        $('#edo_cp').val("");
        $('#calle').val("");
        $('#int').val("");
        $('#ext').val("");
        $('#inicio_dom').val("");
        $('#fin_dom').val("");
    }
    function modalExterno()
    {
      if( $('#cboPlaza').val() == "" || $('#cboSociedad').val() == "")
      {
        show_stack_bar_top('warning','Plaza y sociedad','Seleccione la plaza y la sociedad');

      }
      else
      {
        $('#modalExterno').modal('show');
        $('#table-externos').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=personal_externo&plaza=' + $('#cboPlaza').val() + '&soc=' + $('#cboSociedad').val()});
    }
  }
$('input#cp').keyup(function() {
  if ($("#cp").val().length == 5) {
    $str = "id=" +$('#cp').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol").html($data);
           $('#cboCol').selectpicker('refresh');

        }
        })
   }
   else if($("#cp").val().length > 5)
   {
      show_stack_bar_top('warning','C.P invalido','El cp debe tener 5 digitos');
   }

});
 
</script>
