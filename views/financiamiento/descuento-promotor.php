<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container-fluid">
    <div class="page-header">
    <br>
        <h3 class="title"><i class="fa fa-male"></i>  Consulta descuentos</h3>
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
        <button class="btn btn-primary btn-sm" onclick="consultar()"><i class="fa fa-search"></i>  Buscar</button>
      </div>
      <br><br>
  </div>
</div>
<div class="btn-group btn-group-sm pull-right" aria-label="Small button group" role="group" style="margin-top:10px;margin-left:1%;">
<button class="btn btn-warning" type="button" onclick="pendientes()">Pendientes</button>
<button class="btn btn-success" type="button" onclick="pagados()">Pagados</button>
</div>
<table id="table-descuentos" data-show-export="true"  data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
<script type="text/javascript">
$(document).ready(function() {
	$('#table-descuentos').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=0',
        cache: false,
        height: 700,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'empleado',
            title: 'Empleado',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'descuento',
            title: 'Descuentos',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: financiadoFormatter,
        },
        {
            field: 'pagado',
            title: 'Pagado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: depositoFormatter,
        },
        {
            field: 'pendiente',
            title: 'Pendiente',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: priceFormatter,
        },
        {
            field: 'estado',
            title: 'Estado',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
      	{
            field: 'Acciones',
            title: 'Detalles',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            formatter: FormatterAcciones,
            events: operateEvents
        }
    	]
    });

});
     function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-primary btn-xs btn-ver"><i class="fa fa-list"></i></button>'
        ].join('');
    }
    window.operateEvents = {
        'click .btn-ver': function (e, value, row, index) {
           window.location="/systema/finanzas/index.php?c=financiamiento&f=vista_detalleDesc&id="+ row.id;
        }
    };
    function busqueda(){ 
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
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=1&plaza='+$('#cboPlaza').val()+'&soc='+$('#cboSociedad').val()});
    }
    function pendientes()
    {
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=1'});
    }
     function pagados()
    {
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=2'});
    }
 function rowStyle(row, index) {
        var danger = ['danger'];
        var success = ['success'];
        var warning = ['warning'];
        if (row.pendiente != "0.00") {
            return {
                classes: warning
            };
        }
        else
        {
            return {
                classes: success
            };
        }
        return {};
    }
      $('#table-descuentos').tableExport({
       fileName: 'reporte_cuentas',
       type:'pdf',
       jspdf: {orientation: 'p',
               margins: {left:20, top:10},
               autotable: false}
      });   
       


</script>