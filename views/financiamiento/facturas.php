<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container-fluid">
    <div class="page-header">
    <br>
        <h3 class="title"><i class="fa fa-file-pdf-o"></i>  Consulta facturas</h3>
    </div>
<div class="col-lg-12">
   <div class="form-group">
      <label class="col-lg-1 control-label">Plaza:</label>
      <div class="col-lg-4">
          <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="100%" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
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
         <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad"></select>
      </div>
      <div class="col-lg-1">
        <button class="btn btn-primary btn-xs" onclick="consultar()"><i class="fa fa-search"></i>  Buscar</button>
      </div>
      <br><br>
  </div>
</div>
<!-- modal editar registro -->
<div class="modal fade" id="editFactura" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i>  Editar factura</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
            <!-- content goes here -->
            <div class="form-group row">
                  <label class="col-md-3">Id factura:</label>
                  <div class="col-md-6">
                      <input type="text" name="edit_fact" class="form-control" id="edit_id" disabled="true">
                  </div>
            </div>
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-3">Folio factura:</label>
                <div class="col-md-6">
                    <input type="text" name="edit_folio" class="form-control" id="edit_folio" >
                </div>
                </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-3">Fecha factura:</label>
                <div class="col-lg-6 date">
                    <div class="input-group input-append date" id="fecha_asig">
                      <input type="text" class="form-control" name="edit_fecha" id="edit_fecha" placeholder="dd-mm-aaaa" />
                      <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-3">Importe factura:</label>
                <div class="col-md-6">
                <input type="text" name="edit_imp" class="form-control" id="edit_imp">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-3">Estado:</label>
                <div class="col-md-4">
                       <select name="edit_edo" class="form-control" id="edit_edo" >
                        <?php while($s= $status_fact->fetch_assoc())
                      {?> 
                        <option value="<?php echo $s['idstatus_factura']?>"><?php echo $s['nombre']?></option>
                      <?php } ?>
                      </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-3">Observaciones:</label>
                <div class="col-md-8">
                    <textarea name="edit_obs" id="edit_obs" class="form-control"></textarea>
                </div>
                </div>

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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="update_factura()" role="button">Guardar</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>
<div class="btn-group btn-group-xs pull-right" role="group" style="margin-top:24px;margin-left:4px;"aria-label="...">
  <button type="button" class="btn btn-success" onclick="activas()">Activas</button>
  <button type="button" class="btn btn-danger" onclick="canceladas()">Canceladas</button>
  <button type="button" class="btn btn-warning" onclick="pendientes()">Pendientes</button>
</div>
<table id="facturas" data-filter-control="true" data-show-export="true" data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
<script type="text/javascript">
$(document).ready(function() {
	$('#facturas').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=0',
        cache: false,
        height: 800,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        pagination: true,
        showExport:true,
        resizable:false,
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'fin',
            title: 'Fin',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'cliente',
            title: 'Cliente',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'folio',
            title: 'Folio factura',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'fecha',
            title: 'Fecha',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'imp_fact',
            title: 'Facturado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: financiadoFormatter,
        },
         {
            field: 'imp_desc',
            title: 'Descuentos',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: priceFormatter,
            filterControl: 'input'
        },
         {
            field: 'imp_dep',
            title: 'Depositado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: priceFormatter,
            filterControl: 'input'
        },
        {
            field: 'saldo_fact',
            title: 'Saldo',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: priceFormatter,
             filterControl: 'input'
        },
         {
            field: 'edo',
            title: 'Estado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: edoFormatter,
        },
         {
            field: 'obs',
            title: 'observaciones',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'mod',
            title: 'Ult.mod',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
      	{
            field: 'Acciones',
            title: 'Acciones',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            formatter: FormatterAcciones,
            events: operateEvents
        }
    	]
    });
     $('#edit_fecha').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
    $('#edit_imp').mask('000,000,000,000,000.00', {reverse: true});
     $(document).on('hide.bs.modal','#editFactura', function () {
           $('#datos-form3').show();
           $('#load3').hide();
           $('#buttons3').show();
           $('#btnok3').hide();
           $('#ok3').hide();
       })

});


     function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-warning btn-xs btn-ver" style="margin-right:8%;"><i class="fa fa-pencil "></i></button>'        ].join('');
    }
    window.operateEvents = {
        'click .btn-ver': function (e, value, row, index) {
            self.modalEditar(row.id);
        }
    };
    function busqueda(){ 
       // $('#myModal').modal('show'); 
       $('#loader').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboSociedad").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader').hide();
               $("#cboSociedad").html($databack);
               $('#cboSociedad').selectpicker('refresh');
            }
        })
    }; 
    function consultar()
    {
       $('#facturas').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=0&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
    }
    function Detalles(id)
    {
      window.location="/systema/finanzas/index.php?c=financiamiento&f=sesion_detalle&idFin="+ id;       
        
    }
          function priceFormatter(value) {
           // 16777215 == ffffff in decimal
        var color = '#6cfed';
        return '<div  style="color: ' + color + '">' +
                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
                value +
                '</strong></div>';
    }
    function financiadoFormatter(value) {
           // 16777215 == ffffff in decimal
        var color = '#912B2B';
        return '<div  style="color: ' + color + '">' +
                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
                value +
                '</strong></div>';
    }
     function depositoFormatter(value) {
           // 16777215 == ffffff in decimal
        var color = '#1F6D51';
        return '<div  style="color: ' + color + '">' +
                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
                value +
                '</strong></div>';
    }
    function edoFormatter(value) {
           // 16777215 == ffffff in decimal
        if(value == "Activa")
        {
        return '<span class="label label-success">' + 
                value +
                '</span>';
        }
        else if(value == "Cancelada")
        {
          return '<span class="label label-danger">' + 
                value +
                '</span>';
        }
        else if(value == "Pendiente")
        {
          return '<span class="label label-warning">' + 
                value +
                '</span>';
        }
        else
        {
          return '<span class="label label-default">' + 
                value +
                '</span>';
        }
    }
  function rowStyle(row, index) {
        var danger = ['danger'];
        var success = ['success'];
        var warning = ['warning'];
        if (row.id_edo == 5) {
            return {
                classes: danger
            };
        }
        else if(row.id_edo == 2)
        {
            return {
                classes: success
            };
        }
         else if(row.id_edo == 4)
        {
            return {
                classes: warning
            };
        }
       else
       {

       }
        return {};
    }
    function modalEditar(id)
    {
      $strD = "id=" + id;
      $.ajax({
        data: $strD,
        type: "POST",
        dataType: "html",
        url: "ajax.php?c=financiamiento&f=busca_factura",
        success: function (data) 
        {
          $('#editFactura').modal('show');
          var json_obj = $.parseJSON(data);//parse JSON
          
          for (var i in json_obj) 
          {
              $('#edit_folio').val(json_obj[i].folio);
              $('#edit_id').val(json_obj[i].idfact);
              $('#edit_fecha').val(json_obj[i].fecha);
              $('#edit_imp').val(json_obj[i].imp);
              $('#edit_obs').val(json_obj[i].obs);
              $('#edit_edo').val(json_obj[i].edo);

          }

            }
        });
    }
     function update_factura()
    {
         $('#datos-form3').hide();
         $('#load3').show();
         $strD = "id=" + $('#edit_id').val() + "&folio="+ $('#edit_folio').val() + "&fecha="+ $('#edit_fecha').val() + "&imp="+ $('#edit_imp').val().replace(',', '')+ "&edo="+ $('#edit_edo').val()+ "&obs="+ $('#edit_obs').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=financiamiento&f=update_factura",
              success: function (data) {
                if(data.trim()==1) {
                    $('#load3').hide();
                    $('#buttons3').hide();
                    $('#btnok3').show();
                    $('#ok3').show();
                    $('#facturas').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=0&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, los datos no han podido ser actualizados');
                }
              }
          });
    }
     function aceptar()
    {
     $('#datos-form3').show();
     $('#load3').hide();
     $('#buttons3').show();
     $('#btnok3').hide();
     $('#ok3').hide();
     $('#editFactura').modal('hide');
    }
     function activas()
    {
        $('#facturas').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=1&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() });

    }
    function pendientes()
    {
        $('#facturas').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=3&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() });
    }
    function canceladas()
    {
        $('#facturas').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_facturas&filtro=2&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() });

    }
       


</script>