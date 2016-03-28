<?php
#incluye encabezado
include '../includes/top.php';?>
<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container cont-principal">
<div class="row">
    <section>
        <div class="col-lg-12">
            <div class="page-header">
                <h2 class="title">Financiamiento</h2>
            </div>

            <form id="FormFinanciamiento" method="post" class="form-horizontal">
            	<div class="form-group">
                    <label class="col-lg-2 col-lg-offset-1 control-label">Plaza:</label>
                    <div class="col-lg-4">
                        <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="100%" name="cboPlaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
                            <option value="">-- Seleccione plaza --</option>
                           <?php while($plaza= $plazas->fetch_assoc())
                            {?>
                               <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                     <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                     <label for="" class="col-lg-2 col-lg-offset-1 control-label">Sociedad:</label>
                     <div class="col-lg-4" id="rowSoc">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad"></select>
                        </select>
                    </div>
                    <div class="col-lg-1" id="loader2" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                </div>

                <div class="form-group">
                <div id="rowCliente">
                    <label class="col-lg-2 col-lg-offset-1 control-label">Cliente:</label>
                    <div class="col-lg-4">
                     <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCliente" id="cboCliente" data-bv-notempty data-bv-notempty-message="el cliente es requerido">
                    </select>
                    </div>
                </div>
                </div>
                 <div class="form-group">
                    <label class="col-lg-2 col-lg-offset-1 control-label">Autorizado por:</label>
                    <div class="col-lg-4">
                         <select class="form-control" name="autorizado" id="autorizado" data-bv-notempty data-bv-notempty-message="Seleccione la persona que autoriza">
                        <option value="">-- Seleccione persona --</option>
                        <option value="fr">Juan Lopez</option>
                        <option value="de">Veronica Lujan</option>
                        <option value="it">David Velasco</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-lg-offset-1 control-label">Fecha financiamiento:</label>
                      <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="fecha_finan" id="fecha_finan" placeholder="aaaa-mm-dd" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-lg-offset-1 control-label">Periodo financiado del:</label>
                    <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="periodo_del" id="periodo_del" placeholder="aaaa-mm-dd" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                    <label  class="col-lg-1 control-label">al:</label>
                    <div class="col-lg-3 date">
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="periodo_al" id="periodo_al" placeholder="aaaa-mm-dd" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                </div>
             </div>
         </section>
    </div>