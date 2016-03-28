<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<style>
    table
    {
        width: 90%;
    }
</style>
<div class="container cont-principal">
   <div class="page-header">
        <h2 class="title"><i class="fa fa-file"></i>  Archivos de cuenta</h2>
    </div>
        <div class="col-lg-12">
             <div class="form-group row">
                        <label class="col-lg-1 control-label">Plaza:</label>
                        <div class="col-lg-4">
                           <select data-live-search="true" class="selectpicker show-menu-arrow"  data-style="btn-info" data-size="10" data-width="auto" name="plaza" id="cboPlaza" data-bv-notempty data-bv-notempty-message="la plaza es requerida" onchange="busqueda()">
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
                         <div class="col-lg-10">
                            <select data-live-search="true" class="selectpicker show-menu-arrow" data-style="btn-info" data-size="10" data-width="100%" name="sociedad" id="cboSociedad"></select>
                          </div>
                          
                        </div>
                    </div>
                      <div class="form-group row">
                           <label class="col-lg-1 control-label">Banco:</label>
                            <div class="col-lg-3">
                               <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboBanco" name="cboBanco" data-size="10" onchange="filtra_cuentas()">
                                <option value="">-- Seleccione banco --</option>
                                     <?php while($banco= $bancos->fetch_assoc())
                                        {?>
                                           <option value="<?php echo $banco['idbancos']?>" data-subtext="<?php echo $banco['cve_transfer']?>"><?php echo $banco['nombre']?></option>

                                        <?php } ?>
                                </select>
                            </div>
                             <label class="col-lg-1 control-label">Cuenta:</label>
                            <div class="col-lg-4">
                                    <select data-live-search="true" class="selectpicker show-menu-arrow" data-size="10" data-width="100%" name="cboCuenta" id="cboCuenta" onchange="asigna_cta()"></select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary btn-sm" onclick="showTable()"><i class="fa fa-search"></i>  Buscar</button>
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

<!-- modal borrar -->
<div class="modal fade" id="borrar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-red">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-trash"></i>  Eliminar archivo</h3>
        </div>
        <div class="modal-body">
            <div id="datos-form2" class="alert alert-danger preg">
                <strong class="center">¿ Esta seguro de eliminar el archivo?</strong>
                <input type="text" name="id_file" id="id_file" style="display:none;">
              </div>
        <div id="load2" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok2" style="display:none;" class="alert alert-danger">
            <h3><i class="fa fa-info-circle"></i>  El archivo ha sido eliminada correctamente </h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons2" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" onclick="borrarFile()" role="button">Eliminar</button>
                </div>
            </div>
            <div id="btnok2" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_borrar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>  
 <div class="modal fade" id="nuevo_archivo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-danger">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-file-o"></i>
  Nuevo archivo </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="upload" action="ajax.php?c=cuentas&f=upload_file" id="upload" enctype="multipart/form-data">
               <input type="hidden" name="cuenta" id="cuenta">
                <div class="form-group row">
                    <label for="" class="control-label col-lg-2">Titulo</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="titulo" name="titulo">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="control-label col-lg-2">Descripción:</label>
                    <div class="col-lg-9">
                       <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                      <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                      <div id=" errorblock" class="help-block"></div>
                    </div>
                </div>
            </form>
<!--           </div>
 -->          <span style="color:#808080">*Seleccione el archivo que desea subir(jpg,png,pdf.docx,xls,csv,etc)*</span>
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
    <div class="col-lg-12">  
        <button class="btn btn-warning pull-left btn-xs" onclick="modalArchivo()"><i class="fa fa-plus"></i>  Agregar archivo</button>
        <table id="table-archivos"><table/>
    </div>
 


<script type="text/javascript">
$(document).ready(function() {
    $('.selectpicker').selectpicker();
     $('#table-archivos').bootstrapTable({
            method: 'get',
            url: 'ajax.php?c=cuentas&f=busca_archivos&cuenta='+ $('#cboCuenta').val(),
            cache: false,
            height: 900,
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
            columns: [{
                field: 'id',
                title: 'Id',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'org_nom',
                title: 'Archivo',
                align: 'center',
                valign: 'middle',
                sortable: true,
                visible: false
            },
             {
                field: 'n_nombre',
                title: 'archivo',
                align: 'center',
                valign: 'middle',
                sortable: true,
            },
            {
                field: 'tipo',
                title: 'Tipo',
                align: 'center',
                valign: 'middle',
                sortable: true,
            },
            {
                field: 'titulo',
                title: 'Titulo',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'desc',
                title: 'Descripción',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'act',
                title: 'Actualización',
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
 });
function modalArchivo()
{
 if($('#cboPlaza').val()=="" || $('#cboSociedad').val()==""  || $('#cboBanco').val()=="" || $('#cboCuenta').val()=="" )
 {
    show_stack_bar_top('warning','Complete los campos','Para agregar un archivo son necesarios la sociedad, banco y la cuenta');

 }
 else
 {
    $('#nuevo_archivo').modal('show');
 }
}
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
  
//funcion para ver los datos de la cuenta
  function modalDatos(id)
    {
        window.location="/systema/finanzas/index.php?c=cuentas&f=datos_cuenta&id="+id;
      
    }
     //muestra el modal para eliminar el registro
  self.modalBorrar = function(id)
    {
        $('#borrar').modal('show');
        $('#id_file').val(id);
        
    }
    function borrarFile()
    {
       $('#datos-form2').hide('fast');
          $('#load2').show('fast');
          $strD = "id=" + $('#id_file').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=borrar_archivo",
              success: function (data) {

                if(data.trim()==1) {
                    $('#load2').hide();
                    $('#buttons2').hide();
                    $('#btnok2').show();
                    $('.preg').hide();
                    $('#ok2').show();
                    $('#table-archivos').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el archivo no ha podido ser eliminado');
                }
              }
          });
    }

function showTable() 
{
    $('#table-archivos').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_archivos&cuenta='+ $('#cboCuenta').val() });
     
}
function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-danger btn-xs btn-borrar" style="margin-right:4%;"><i class="fa fa-trash"></i></button>'
        ].join('');
    }
//eventos de la bootstrap table
  window.operateEvents = {
        'click .btn-borrar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalBorrar(row.id);
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
   
function asigna_cta()
{
    var cta= $('#cboCuenta').val();
    $('#cuenta').val(cta);
}

</script>