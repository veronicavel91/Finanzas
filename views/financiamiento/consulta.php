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
                <h3 class="title">Consulta financiamiento</h3>
            </div>

            <form id="defaultForm" method="post" class="form-horizontal">
            	<div class="form-group">
                    <label class="col-lg-2 control-label">Plaza:</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="plaza" id="cboPlaza" onchange="busqueda()" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                           <?php while($plaza= $plazas->fetch_assoc())
                                {?>
                                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                     <div class="col-lg-4" id="rowSoc" style="display:none;">
                        <select class="form-control" name="cboSociedad" id="cboSociedad" data-bv-notempty data-bv-notempty-message="la sociedad es requerida" onchange="busqueda_cliente()">
                        </select>
                    </div>
                    <div class="col-lg-1" id="loader2" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                </div>
                <div class="form-group">
                <div id="rowCliente" style="display:none;">
                    <label class="col-lg-2 control-label">Cliente:</label>
                    <div class="col-lg-4">
                      <select class="form-control" name="cboCliente" id="cboCliente" data-bv-notempty data-bv-notempty-message="el cliente es requerido">
                    </select>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Periodo del:</label>
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
</div><!--  /container-fluid -->
<div class="container">
    <div class="row">
        
        
        <div class="col-md-12">
        <div class="table-responsive">
        <br><br>
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
                   
                   <th><input type="checkbox" id="checkall" /></th>
                   <th>Fecha</th>
                    <th>Periodo financiado</th>
                     <th>Factura</th>
                     <th>Cliente</th>
                     <th>Autorizado</th>
                     <th>Saldo</th>
                     <th>Estado</th>
                     <th>Editar</th>
                     <th>Borrar</th>
                   </thead>
        <tbody>

        <tr>
            <td><input type="checkbox" class="checkthis" /></td>
            <td>01/01/2014</td>
            <td>01/01/2014 - 02/01/2015 </td>
            <td>05698452</td>
            <td>Carla Maria Jimenez</td>
            <td>Ana Lopez - Finanzas</td>
            <td>$20,000.00</td>
            <td><label class="label label-danger" >vencido</label></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
        </tr>
        <tr>
            <td><input type="checkbox" class="checkthis" /></td>
            <td>01/01/2014</td>
            <td>01/01/2015 - 02/10/2015 </td>
            <td>0962574</td>
            <td>Juan Torres</td>
            <td>Ana Lopez - Finanzas</td>
            <td>$80,000.00</td>
            <td><label class="label label-warning" >pendiente</label></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
        </tr>
        <tr>
            <td><input type="checkbox" class="checkthis" /></td>
            <td>02/05/2015</td>
            <td>02/05/2015 - 02/10/2015 </td>
            <td>8525858</td>
            <td>Visiones crista luz</td>
            <td>Raul ochoa - Finanzas</td>
            <td>$10,000.00</td>
            <td><label class="label label-success" >pagado</label></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
        </tr>
         <tr>
            <td><input type="checkbox" class="checkthis" /></td>
            <td>02/05/2015</td>
            <td>02/05/2015 - 02/10/2015 </td>
            <td>8525858</td>
            <td>Visiones crista luz</td>
            <td>Raul ochoa - Finanzas</td>
            <td>$10,000.00</td>
            <td><label class="label label-success" >pagado</label></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
        </tr>
    </tbody>
</table>

<div class="clearfix"></div>
<ul class="pagination pull-right">
  <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
</ul>
                
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-danger">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-pencil"></i>  Editar financiamiento</h4>
      </div>
          <div class="modal-body">
           <form id="defaultForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-lg-2 control-label">Plaza:</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="plaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                            <option value="fr">Plaza x</option>
                            <option value="de">Plaza y</option>
                            <option value="it">Plaza z</option>
                        </select>
                    </div>
                     <div class="col-lg-5">
                        <select class="form-control" name="plaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                            <option value="fr">Plaza x</option>
                            <option value="de">Plaza y</option>
                            <option value="it">Plaza z</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Cliente:</label>
                    <div class="col-lg-4">
                      <select class="form-control" name="cliente" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                        <option value="fr">Juan Lopez</option>
                        <option value="de">Veronica Lujan</option>
                        <option value="it">David Velasco</option>
                    </select>
                    </div>
                    <label class="col-lg-2 control-label">fecha:</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="fecha_finan" value="01/01/2014" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Periodo financiado:</label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="periodo_del" value="01/02/2015" />
                    </div>
                    <label  class="col-lg-1 control-label">al:</label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="periodo_al" value="01/02/2015"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Fecha factura:</label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="fecha_fact" value="01/01/2015" />
                    </div>
                    <label  class="col-lg-1 control-label">Folio:</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="folio_fact" value="522555" />
                    </div>
                </div>
                <div class="form-group">
                     <label  class="col-lg-2 control-label">Importe:</label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="importe_fact" value="$20,000.00"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Autorizado por:</label>
                    <div class="col-lg-6">
                         <select class="form-control" name="autorizado" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                        <option value="fr">Juan Lopez</option>
                        <option value="de">Veronica Lujan</option>
                        <option value="it">David Velasco</option>
                    </select>
                    </div>
                </div>

                    <ul class="nav nav-tabs">
                     <li class="active"><a href="#saldo-tab" data-toggle="tab">Saldos <i class="fa"></i></a></li>
                        <li><a href="#cheques-tab" data-toggle="tab">Cheques del cliente <i class="fa"></i></a></li>
                        <li><a href="#address-tab" data-toggle="tab">Descuentos promotor <i class="fa"></i></a></li>
                    </ul>
                        <div class="tab-content">
                        <br>
                            <div class="tab-pane active" id="saldo-tab">
                                <div class="form-group">
                                    <h5 class="col-lg-3 col-lg-offset-2"><span class="label label-success">Importe depositado:</span></h5>
                                    <div class="col-lg-3">
                                       <input type="text" class="form-control " name="importe_dep" value="$30,000.00"/>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <h5 class="col-lg-3 col-lg-offset-2"><span class="label label-danger">Importe financiado:</span></h5>
                                    <div class="col-lg-3">
                                       <input type="text" class="form-control " name="importe_fin" value="$20,000.00"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5 class="col-lg-3 col-lg-offset-2"><span class="label label-default">Saldo financiado:</span></h5>
                                    <div class="col-lg-3">
                                       <input type="text" class="form-control " name="saldo_fact" value="$10,000.00" disabled="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="cheques-tab">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">No. cheque:</label>
                                    <div class="col-lg-4">
                                      <input type="text" class="form-control" name="no_cheque" value="525">
                                    </div>
                                    <label class="col-lg-2 control-label">Fecha:</label>
                                     <div class="col-lg-3">
                                      <input type="date" class="form-control" name="fecha_cheque" value="01/01/2015">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Sociedad del cheche:</label>
                                    <div class="col-lg-7">
                                       <select class="form-control" name="plaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida">
                                            <option value="fr">Sociedad x</option>
                                            <option value="de">Sociedad y</option>
                                            <option value="it">Sociedad z</option>
                                        </select>
                                    </div>
                        
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Observaciones:</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" >Ya no financiarle mas a este cliente, es incumplido</textarea>
                                        <br>
                                         <button class="btn btn-success btn-xs pull-right"><i class="fa fa-plus"></i>  Agregar otro cheque</button>
                                    </div>

                                </div>
                            </div>
                        <div class="tab-pane" id="address-tab">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Promotor</label>
                                    <div class="col-lg-6">
                                       <select class="form-control" name="promotor">
                                            <option value="FR">Fernando galvan</option>
                                            <option value="DE">German torres</option>
                                            <option value="IT">Miriam Vazquez</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Descuento:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="importe_desc" value="$2,000.00"/>
                                    </div>
                                     <label class="col-lg-1 control-label">Tipo:</label>
                                    <div class="col-lg-2">
                                        <input type="radio" name="tipo" value="1">% porcentaje
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="radio" name="tipo" value="1" checked>importe
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Observaciones:</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control">Sin observaciones</textarea>
                                        <br>
                                         <button class="btn btn-success btn-xs pull-right"><i class="fa fa-plus"></i>  Agregar otro descuento</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-primary btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>  Actualizar</button>
                </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-danger">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-trash"></i>  Eliminar financiamiento</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>  ¿Esta seguro que desea eliminar este registro?</div>
       
      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>

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
  function busqueda(){ 
       // $('#myModal').modal('show'); 
       $("#rowSoc").hide('fast');
       $('#loader').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboSociedad").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               //alert($databack);
               //$('#myModal').modal('hide'); 
               $('#loader').hide();
               $("#rowSoc").show('fast');
               $("#cboSociedad").html($databack);
        
            }
        })
    }; 
      function busqueda_cliente(){ 
       // $('#myModal').modal('show'); 
       $('#loader2').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboCliente").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=busca_clientes",
            success:function ($databack){
               $('#loader2').hide();
               $("#rowCliente").show('fast');
               $("#cboCliente").html($databack);
        
            }
        })
    }; 
</script>
<?php
#incluye pie
include '../includes/footer.php';
?>