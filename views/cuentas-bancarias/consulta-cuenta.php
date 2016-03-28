<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<meta charset="UTF-8">
<style>
    table
    {
        width: 90%;
    }
</style>
<div class="container cont-principal">
   <div class="page-header">
        <h2 class="title">Lista de cuentas</h2>
    </div>
        <div class="col-lg-12">
             <div class="form-group">
                        <label class="col-lg-1 control-label">Plaza:</label>
                        <div class="col-lg-4">
                           <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="auto" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" >
                                <option value="">-- Seleccione plaza --</option>
                                <option value="TODAS">Todas las plazas</option>
                                <?php while($plaza= $plazas->fetch_assoc())
                                {?>
                                   <option value="<?php echo $plaza['idplaza']?>"><?php echo $plaza['plaza']?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                        <label class="control-label col-md-1">Sociedad:</label>
                         <div class="col-lg-5" id="rowSoc">
                         <div class="col-lg-10">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad">
                                  <option value="">-- Seleccione sociedad --</option>
                                  <option value="TODAS">Todas las sociedades</option>
                                 <?php while($soc= $sociedades->fetch_assoc())
                                {?>
                                   <option value="<?php echo $soc['idempresa']?>"><?php echo $soc['razonsocial']?></option>

                                <?php } ?>
                            </select>
                            
                          </div>
                          <div class="col-lg-2">
                            <button class="btn btn-primary" onclick="showTable()"><i class="fa fa-search"></i>  Buscar</button>
                            </div>
                        </div>
                    </div>
                    <br><br>
        
        </div>
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-plus"></i>  Nuevo banco</h3>
        </div>
        <!-- Modal editar de la cuenta -->
        <div class="modal-body">
            <div id="datos-form">
            <!-- content goes here -->
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-2">Banco:</label>
                <div class="col-md-6">
                    <input type="text" name="banco" class="form-control" id="banco" placeholder="Nombre del banco">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-2">No. institución:</label>
                <div class="col-md-6">
                <input type="text" name="no_inst" class="form-control" id="no_inst">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-2">Clave:</label>
                <div class="col-md-4">
                <input type="text" id="clave" name="clave" class="form-control col-lg-4">
                </div>
                <p class="help-block">Clave corta para referenciar el banco.</p>
              </div>

        </div>
        <div id="load" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok" style="display:none;" class="alert alert-success">
            <h3><i class="fa fa-check"></i>  Banco guardado correctamente</h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_banco()" role="button">Guardar</button>
                </div>
            </div>
            <div id="btnok" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_nuevo()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>

</div>
<div class="modal fade" id="modaldetalles" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:85%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-list"></i>  Detalles de la cuenta</h3>
        </div>
        <!-- Modal editar de la cuenta -->
        <div class="modal-body">
            <div id="datos-form">
            <!-- content goes here -->
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-1 col-md-offset-1">Cuenta:</label>
                <div class="col-md-4">
                    <input type="text" name="cta" class="form-control" id="cta" disabled="true" >
                </div>
                <div class="col-md-1">
                    <input type="text" name="id" class="form-control" id="id"  disabled="true">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-1 col-md-offset-1">Plaza:</label>
                <div class="col-md-4">
                    <input type="text" name="pza" class="form-control" id="pza" disabled="true" >
                </div>
                 <label for="" class="col-md-1">Sociedad:</label>
                <div class="col-md-4">
                    <input type="text" name="soc" class="form-control" id="soc"  disabled="true">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-1 col-md-offset-1">Clabe:</label>
                <div class="col-md-5">
                <input type="text" name="cbe" class="form-control" id="cbe" disabled="true">
                </div>
                 <label class="col-md-1">Sucursal:</label>
                <div class="col-md-3">
                <input type="text" name="suc" class="form-control" id="suc" disabled="true">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-1 col-md-offset-1">Banco:</label>
                <div class="col-md-3">
                <input type="text" id="banc" name="banc" class="form-control col-lg-4"  disabled="true">
                </div>
                <label class="col-md-1">Contrato:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="cont" id="cont" disabled="true">
                </div>
              </div>
               <div class="form-group row">
                <label class="col-md-1 col-md-offset-1">Apertura:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="f_ap" id="f_ap" disabled="true">
                </div>
                 <label for="exampleInputPassword1" class="col-md-1">Usuario:</label>
                <div class="col-md-5">
                <input type="text" name="us" class="form-control" id="us" disabled="true">
                </div>
              </div>
                <div class="form-group row">
                <label class="col-md-1 col-md-offset-1">Area:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="area" id="area" disabled="true">
                </div>
                 <label class="col-md-1">Estado:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="es" value="Activa" id="es" disabled="true">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-1 col-md-offset-1">Saldo:</label>

                <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon" id="sizing-addon2">$</span>
                  <input type="text" name="sal" class="form-control input-lg" id="sal" disabled="true">
                </div>
                </div>
              </div>
              <div class="row">
                   <div class="col-md-12">
            <div class="panel with-nav-tabs panel-info">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1info" data-toggle="tab">Info 1</a></li>
                            <li><a href="#tab2info" data-toggle="tab">Info 2</a></li>
                            <li><a href="#tab3info" data-toggle="tab">Info 3</a></li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#tab4info" data-toggle="tab">Info 4</a></li>
                                    <li><a href="#tab5info" data-toggle="tab">Info 5</a></li>
                                </ul>
                            </li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1info">Info 1</div>
                        <div class="tab-pane fade" id="tab2info">Info 2</div>
                        <div class="tab-pane fade" id="tab3info">Info 3</div>
                        <div class="tab-pane fade" id="tab4info">Info 4</div>
                        <div class="tab-pane fade" id="tab5info">Info 5</div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
              </div> <!-- row -->
          </div> <!-- body -->



       
        <div class="modal-footer">
           <!--  <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_banco()" role="button">Guardar</button>
                </div>
            </div>
            <div id="btnok" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_nuevo()" role="button">Aceptar</button>
            </div> -->
        </div>
    </div>
  </div>
</div>
<!-- fin Modal-->
<!-- modal borrar -->
<div class="modal fade" id="borrar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-red">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-trash"></i>  Eliminar cuenta</h3>
        </div>
        <div class="modal-body">
            <div id="datos-form2" class="alert alert-danger preg">
                <strong class="center">¿ Esta seguro de eliminar esta cuenta?</strong>
                <input type="text" name="idcta" id="idcta" style="display:none;">
              </div>
        <div id="load2" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok2" style="display:none;" class="alert alert-danger">
            <h3><i class="fa fa-info-circle"></i>  La cuenta ha sido eliminada correctamente </h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons2" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" onclick="borrarCuenta()" role="button">Eliminar</button>
                </div>
            </div>
            <div id="btnok2" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_borrar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>   
<div class="pull-left" style="margin-top:24px;margin-left:6px;"><a href="#" class="btn btn-success btn-xs" onclick="reporte_cuentas()" style="background-color:#238662;border-color:#238662;"><i class="fa fa-file-excel-o"></i> Reporte cuentas</a>
<button type="button" class="btn btn-primary btn-green btn-xs" data-toggle="modal" data-target="#excel"><i class="fa fa-upload"></i>
              Importar cuentas</button>
</div>
<div class="btn-group btn-group-xs pull-right" role="group" style="margin-top:24px;margin-left:4px;"aria-label="...">
  <button type="button" class="btn btn-success" onclick="activas()">Activas</button>
  <button type="button" class="btn btn-default btn-gris" onclick="canceladas()">Canceladas</button>
  <button type="button" class="btn btn-danger" onclick="bloqueadas()">Bloqueadas</button>
</div>
 <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-verde">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-file-excel-o"></i>
  Importar cuentas desde excel </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="upload" action="ajax.php?c=cuentas&f=importar_cuentas" id="upload" enctype="multipart/form-data">
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
<table id="table-cuentas"  data-id-field="id" data-detail-view="true" data-filter-control="true" data-detail-formatter="detailFormatter" data-show-export="true"  data-locale="es-MX" data-show-toggle="true"><table/>

<script type="text/javascript">
$(document).ready(function() {
    $('.selectpicker').selectpicker();
     $('#table-cuentas').bootstrapTable({
            method: 'get',
            url: 'ajax.php?c=cuentas&f=busca_cuentas&filtro=0&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val(),
            cache: false,
            height: 1100,
            width: 1900,
            striped: true,
            pagination: true,
            pageSize: 200,
            pageList: [10, 25, 50, 100, 200],
            search: true,
            showColumns: true,
            showRefresh: true,
            minimumCountColumns: 2,
            clickToSelect: true,
            exportTypes:[ 'xml','txt','excel','pdf','word'],
            exportDataType: $(this).val(),
            columns: [
            {
                field: 'id',
                title: 'Id',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'num_cta',
                title: 'No.cuenta',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
            {
                field: 'tipo_cuenta',
                title: 'Tipo',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
             {
                field: 'tipo_op',
                title: 'Operación',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
            {
                field: 'clabe',
                title: 'Clabe',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
            {
                field: 'resp',
                title: 'Responsable',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            }
            ,
            {
                field: 'area',
                title: 'Area',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
            {
                field: 'banco',
                title: 'Banco',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input'
            },
            {
                field: 'suc',
                title: 'Sucursal',
                align: 'center',
                valign: 'middle',
                sortable: true,
                filterControl: 'input',
            },
            {
                field: 'f_ap',
                title: 'Apertura',
                align: 'center',
                valign: 'middle',
                sortable: true,
            },
            {
                field: 'status',
                title: 'Estado',
                align: 'center',
                valign: 'middle',
                sortable: true
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
$('#f_ap').addClass('selectpicker');
 });

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
     function borrarCuenta()
    {
       $('#datos-form2').hide('fast');
          $('#load2').show('fast');
          $strD = "id=" + $('#idbanco').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=borrar_banco",
              success: function (data) {

                if(data.trim()=="OK") {
                    $('#load2').hide();
                    $('#buttons2').hide();
                    $('#btnok2').show();
                    $('.preg').hide();
                    $('#ok2').show();
                    $('#table-cuentas').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el banco no ha podido ser eliminado');
                }
              }
          });
    }
//funcion para ver los datos de la cuenta
  function modalDatos(id)
    {
        window.location="/systema/finanzas/index.php?c=cuentas&f=datos_cuenta&id="+id;
    }
     //muestra el modal para eliminar el registro
    function modalBorrar(id)
    {
        $('#borrar').modal('show');
        $('#idcta').val(id);
        
    }
    function borrarCuenta()
    {
       $('#datos-form2').hide('fast');
          $('#load2').show('fast');
          $strD = "id=" + $('#idcta').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=borrar_cuenta",
              success: function (data) {

                if(data.trim()==1) {
                    $('#load2').hide();
                    $('#buttons2').hide();
                    $('#btnok2').show();
                    $('.preg').hide();
                    $('#ok2').show();
                    $('#table-cuentas').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el banco no ha podido ser eliminado');
                }
              }
          });
    }

function showTable() 
{
       
    $('#table-cuentas').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_cuentas&filtro=0&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val()});
     
}
function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-info btn-xs btn-ver" style="margin-right:4%;"><i class="fa fa-bars"></i></button>',
               '<button class="btn btn-warning  btn-archivo btn-xs" data-toggle="modal" ><i class="fa fa-file-text-o"></i></button>'
        ].join('');
    }
//eventos de la bootstrap table
  window.operateEvents = {
        'click .btn-archivo': function (e, value, row, index) {
            var anio = 2016;
            window.location="/systema/finanzas/index.php?c=cuentas&f=get_estados&cta="+ row.id+"&anio="+anio;
        },
          'click .btn-ver': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalDatos(row.id);

        }
    };
      function aceptar_borrar()
    {
        $('#buttons2').show();
        $('#btnok2').hide();
        $('#ok2').hide();
        $('#datos-form2').show();
        $('#borrar').modal('hide');
    }
    $('#table-cuentas').on('expand-row.bs.table', function (e, index, row, $detail) {
                $detail.html('Cargando información, espere un momento...');
                $.get('ajax.php?c=cuentas&f=detalle_consulta&cta='+row.id, function (res) {
                    $detail.html(res.replace(/\n/g, '<br>'));
                });
        });
    function activas()
    {
        $('#table-cuentas').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_cuentas&filtro=1&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });

    }
    function bloqueadas()
    {
       $('#table-cuentas').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_cuentas&filtro=3&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });
    }
    function canceladas()
    {
        $('#table-cuentas').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_cuentas&filtro=2&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val() });

    }
    function reporte_cuentas()
    {
        if($('#cboPlaza').val() == "" || $('#cboSociedad').val()== "" )
        {
            show_stack_bar_top('warning','¡Datos incompletos!','Seleccione la plaza y la sociedad');
        }
        else
        {
            window.location="/systema/finanzas/ajax.php?c=reportes&f=general_cuentas&plaza="+ $('#cboPlaza').val()+"&soc="+ $('#cboSociedad').val();
        }
    }
     $('#table-cuentas').tableExport({
       fileName: 'reporte_cuentas',
       type:'pdf',
       jspdf: {orientation: 'p',
               margins: {left:20, top:10},
               autotable: false}
      });
   

</script>
<script type="text/javascript" src="./js/importa-cuentas.js"></script>
