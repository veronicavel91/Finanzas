<?php
#incluye encabezado
include '../includes/top.php';?>
<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<link rel="stylesheet" type="text/css" href="./css/movimientos.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<div class="container cont-principal">
<div class="row">
    <section>
        <div class="col-lg-12">
            <div class="page-header">
                <h3 class="title">Consulta movimientos</h3>
            </div>

            <form id="defaultForm" method="post" class="form-horizontal">
            	<div class="form-group">
                    <label class="col-lg-2 control-label">Plaza:</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="plaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                            <option value="">-- Seleccione plaza --</option>
                            <option value="fr">Cualquiera</option>
                            <option value="fr">Plaza x</option>
                            <option value="de">Plaza y</option>
                            <option value="it">Plaza z</option>
                        </select>
                    </div>
                     <div class="col-lg-4">
                        <select class="form-control" name="plaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                            <option value="">-- Seleccione sociedad --</option>
                            <option value="fr">Cualquiera</option>
                            <option value="fr">Plaza x</option>
                            <option value="de">Plaza y</option>
                            <option value="it">Plaza z</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Banco:</label>
                    <div class="col-lg-3">
                      <select class="form-control" name="cliente" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                        <option value="">-- Seleccione cliente --</option>
                        <option value="fr">TODOS</option>
                        <option value="fr">BANCOMER</option>
                        <option value="de">BANAMEX</option>
                        <option value="it">SANTANDER</option>
                    </select>
                    </div>
                     <label class="col-lg-2 control-label">Cuenta:</label>
                    <div class="col-lg-3">
                      <select class="form-control" name="cliente" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                        <option value="">-- Seleccione cuenta --</option>
                        <option value="fr">**** **** *** 4545 - Agustin perez</option>
                        <option value="fr">**** **** *** 8565 - Ramiro ochoa</option>
                        <option value="de">**** **** *** 6627 - Laura lopez</option>
                        <option value="de">**** **** *** 6852 - Jose marquez</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Periodo:</label>
                    <div class='col-lg-2'>
                        <input type='date' placeholder="dd/mm/aaaa" class="form-control" />
                    </div>
                    <label  class="col-lg-1 control-label">al:</label>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" name="periodo_al" placeholder="dd/mm/aaaa"/>
                    </div>
                     <div class="col-lg-2">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i>  Listar</button>
                    </div>
                </div>
            </form>
        </section>
    </div><!--  /col-12 -->
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-10">
                <div class="col-lg-2">
                    <h3>Movimientos</h3> 
                </div>
                <div class="btn-group col-lg-4">
                <br>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Año <i class="fa fa-calendar"></i> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">2015</a></li>
                    <li><a href="#">2014</a></li>
                    <li><a href="#">2013</a></li>
                    <li><a href="#">2012</a></li>
                    <li><a href="#">2011</a></li>
                    <li><a href="#">2010</a></li>
                    <li class="divider"></li>
                    <li><a href="#">mas años</a></li>
                  </ul>
                </div>
            </div>
            </div>
            <br>
            <div class="tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_default_1" data-toggle="tab">
                            Enero </a>
                        </li>
                        <li>
                            <a href="#tab_default_2" data-toggle="tab">
                            Febrero </a>
                        </li>
                        <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Marzo </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Abril </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Mayo </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Junio </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Julio </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Agosto </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Septiembre </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Octubre </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Noviembre </a>
                        </li>
                         <li>
                            <a href="#tab_default_3" data-toggle="tab">
                            Diciembre </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <br>
                        <div class="tab-pane active" id="tab_default_1">
                            <div class="row">
       
                                <div id="no-more-tables">
                                    <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                        <thead class="cf">
                                            <tr>
                                                <th>Id</th>
                                                <th>Fecha</th>
                                                <th class="numeric">Tipo mov.</th>
                                                <th class="numeric">Cargo</th>
                                                <th class="numeric">Abono</th>
                                                <th class="numeric">Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td data-title="Code">025</td>
                                                <td data-title="Code">21/06/2015</td>
                                                <td data-title="Company">Deposito en efectivo.</td>
                                                <td data-title="Price" class="numeric">$0.00</td>
                                                <td data-title="Change" class="numeric">$20,000.00</td>
                                                <td data-title="Change %" class="numeric">$30,000.00</td>
                                            </tr>
                                             <tr>
                                                <td data-title="Code">9854</td>
                                                <td data-title="Code">01/09/2015</td>
                                                <td data-title="Company">Retiro pago de nomina.</td>
                                                <td data-title="Price" class="numeric">$81,000.00</td>
                                                <td data-title="Change" class="numeric">$0.00</td>
                                                <td data-title="Change %" class="numeric">$81,000.00</td>
                                            </tr>
                                            <tr>
                                                <td data-title="Code">9854</td>
                                                <td data-title="Code">01/09/2015</td>
                                                <td data-title="Company">Retiro pago de nomina.</td>
                                                <td data-title="Price" class="numeric">$81,000.00</td>
                                                <td data-title="Change" class="numeric">$0.00</td>
                                                <td data-title="Change %" class="numeric">$81,000.00</td>
                                            </tr>
                                            <tr>
                                                <td data-title="Code">9854</td>
                                                <td data-title="Code">01/09/2015</td>
                                                <td data-title="Company">Retiro pago de nomina.</td>
                                                <td data-title="Price" class="numeric">$81,000.00</td>
                                                <td data-title="Change" class="numeric">$0.00</td>
                                                <td data-title="Change %" class="numeric">$81,000.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pull-right col-lg-3">
                                 <div class="col-lg-12">
                                    <h4>Cargos:<span style="color:#AE3A3A;">$100,000.000</span></h4>
                                </div><br>
                                <div class="col-lg-12">
                                    <h4>Abonos:<span style="color:#24682A;">$300,000.000</span></h4>
                                </div>
                                 <div class="col-lg-12">
                                    <h4 style="font-weight:bold;">SALDO:<span>$200,000.000</span></h4>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_default_2">
                        <div class="row">
                            <div id="no-more-tables">
                                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <tr>
                                            <th>Id</th>
                                            <th>Fecha</th>
                                            <th class="numeric">Tipo mov.</th>
                                            <th class="numeric">Cargo</th>
                                            <th class="numeric">Abono</th>
                                            <th class="numeric">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-title="Code">025</td>
                                            <td data-title="Code">21/06/2015</td>
                                            <td data-title="Company">Deposito en efectivo.</td>
                                            <td data-title="Price" class="numeric">$0.00</td>
                                            <td data-title="Change" class="numeric">$20,000.00</td>
                                            <td data-title="Change %" class="numeric">$100,000.00</td>
                                        </tr>
                                         <tr>
                                            <td data-title="Code">9854</td>
                                            <td data-title="Code">01/09/2015</td>
                                            <td data-title="Company">Retiro pago de nomina.</td>
                                            <td data-title="Price" class="numeric">$80,000.00</td>
                                            <td data-title="Change" class="numeric">$0.00</td>
                                            <td data-title="Change %" class="numeric">$20,000.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pull-right col-lg-3">
                                 <div class="col-lg-12">
                                    <h4>Cargos:<span style="color:#AE3A3A;">$20,000.000</span></h4>
                                </div><br>
                                <div class="col-lg-12">
                                    <h4>Abonos:<span style="color:#24682A;">$80,000.000</span></h4>
                                </div>
                                 <div class="col-lg-12">
                                    <h4 style="font-weight:bold;">SALDO:<span>$60,000.000</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--  /container-fluid -->

<script type="text/javascript" src="../js/alta-cuenta.js"></script>
<script type="text/javascript">
    (function ($) {
    $.fn.extend({
        tableAddCounter: function (options) {

            // set up default options 
            var defaults = {
                title: '#',
                start: 1,
                id: false,
                cssClass: false
            };

            // Overwrite default options with user provided
            var options = $.extend({}, defaults, options);

            return $(this).each(function () {
                // Make sure this is a table tag
                if ($(this).is('table')) {

                    // Add column title unless set to 'false'
                    if (!options.title) options.title = '';
                    $('th:first-child, thead td:first-child', this).each(function () {
                        var tagName = $(this).prop('tagName');
                        $(this).before('<' + tagName + ' rowspan="' + $('thead tr').length + '" class="' + options.cssClass + '" id="' + options.id + '">' + options.title + '</' + tagName + '>');
                    });

                    // Add counter starting counter from 'start'
                    $('tbody td:first-child', this).each(function (i) {
                        $(this).before('<td>' + (options.start + i) + '</td>');
                    });

                }
            });
        }
    });
})(jQuery);

$(document).ready(function () {
    $('.table').tableAddCounter();
    $.getScript("http://code.jquery.com/ui/1.9.2/jquery-ui.js").done(function (script, textStatus) { $('tbody').sortable();$(".alert-info").alert('close');$(".alert-success").show(); });
});
</script>
<?php
#incluye pie
include '../includes/footer.php';
?>