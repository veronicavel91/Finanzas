<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="container-fluid">
    <div class="page-header">
    <br>
        <h3 class="title"><i class="fa fa-money"></i>  Consulta financiamiento</h3>
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
<div class="btn-group btn-group-xs pull-left" role="group" style="margin-top:24px;margin-left:4px;"aria-label="...">
  <button type="button" class="btn btn-info" onclick="activos()">Activos</button>
  <button type="button" class="btn btn-default btn-gris" onclick="cancelados()">Cancelados</button>
  <button type="button" class="btn btn-warning" onclick="pendientes()">Pendientes</button>
  <button type="button" class="btn btn-success" onclick="pagados()">Pagados</button>
  <button type="button" class="btn btn-danger" onclick="vencidos()">Vencidos</button>
</div>
<div class="col-md-2 pull-right" style="margin-top:10px;">
  <div id="toolbar">
      <select class="form-control">
          <option value="">Exportar pagina</option>
          <option value="all">Exportar todo</option>
      </select>
  </div>
</div>
<table id="financiamiento" data-filter-control="true" data-show-export="true"  data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
<script type="text/javascript">
$(document).ready(function() {
	$('#financiamiento').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=0',
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
        pagination: true,
        exportTypes:[ 'xml','txt','excel','pdf','doc'],
        columns: [{
            field: 'id',
            title: 'Id',
            align: 'center',
            valign: 'middle',
            sortable: true
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
            field: 'inicio',
            title: 'Inicio',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'fin',
            title: 'Vencimiento',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'depo',
            title: 'Deposito',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input',
            formatter: depositoFormatter,
        },
        {
            field: 'finan',
            title: 'Financiado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input',
            formatter: financiadoFormatter,
        },
         {
            field: 'saldo',
            title: '  Saldo final  ',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input',
            formatter: priceFormatter,
        },
         {
            field: 'estado',
            title: 'Estado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: edoFormatter,
        },
         {
            field: 'id_edo',
            title: 'id',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: edoFormatter,
            visible: false
        },
      	{
            field: 'Acciones',
            title: 'A c c i o n e s',
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
               '<button class="btn btn-warning btn-xs btn-ver" style="margin-right:3%;"><i class="fa fa-list "></i></button>',
               '<button class="btn btn-success btn-xs btn-reporte confirm" style="margin-right:2%;"><i class="fa fa-file-excel-o"></i></button>',
               '<button class="btn btn-danger btn-xs btn-cancela confirm" style="margin-top:3%;"><i class="fa fa-ban"></i></button>'
        ].join('');
    }
    window.operateEvents = {
        'click .btn-ver': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.Detalles(row.id);
        },
        'click .btn-cancela': function (e, value, row, index) {
            $.confirm({
            text: "¿Esta seguro de cancelar este financiamiento?",
             confirmButton: "Si, Cancelar",
             cancelButton: "No",
            confirm: function() {
              $strD = "id=" + row.id + "&nvo=3";
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=financiamiento&f=update_edoFin",
                  success:function ($databack){
                    if($databack == 1)
                    {
                       $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=0&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
                      show_stack_bar_top('error','¡Financiamiento cancelado!','El financiamiento #' + row.id + ' del cliente: ' + row.cliente + ' se cancelo.');
                    }
                     if($databack != 1)
                    {
                      show_stack_bar_top('warning','¡Error!','Ha ocurrido un error al actualizar el financiamiento, intentelo de nuevo');

                    }
                  }
              })
                
            },
            cancel: function() {

              }
            });
          },
           'click .btn-reporte': function (e, value, row, index) {
            $.confirm({
            text: "¿Desea generar el reporte de este financiamiento?",
             confirmButton: "Si, Generar",
             cancelButton: "No",
            confirm: function() {
              window.location="/systema/finanzas/ajax.php?c=reportes&f=reporte_finan&id=" + row.id;
            },
            cancel: function() {

            }
          });
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
       $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=0&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
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
        if(value == "Activo")
        {
        return '<span class="label label-info">' + 
                value +
                '</span>';
        }
        else if(value == "Pagado")
        {
          return '<span class="label label-success">' + 
                value +
                '</span>';
        }
        else if(value == "Vencido")
        {
          return '<span class="label label-danger">' + 
                value +
                '</span>';
        }
        else if(value == "Pendiente por capturar")
        {
          return '<span class="label label-warning">' + 
                value +
                '</span>';
        }
        else if(value == "Cancelado")
        {
          return '<span class="label label-default">' + 
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
   function activos()
    {
         $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=1&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
     function pagados()
    {
         $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=2&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
    function cancelados()
    {
         $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=3&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
    function pendientes()
    {
         $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=4&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
    function vencidos()
    {
         $('#financiamiento').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_fin&filtro=5&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
    $('#financiamiento').tableExport({
                           fileName: 'reporte_financiamiento',
                           type:'pdf',
                           jspdf: {orientation: 'p',
                           format: 'a4',
                                   margins: {left:20, top:10},
                                   autotable: false}
                          });
    var $table = $('#financiamiento');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    }) 

</script>