<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<script type="text/javascript" src="./js/upload-membrete.js"></script>

<div class="cont-principal container">
    <div class="page-header">
        <h2 class="title"><i class="fa fa-file-o"></i>  Hojas membretadas</h2>
    </div>
    <span style="color:#8D2424;">* <strong>IMPORTANTE:</strong> los membretes se deberán subir en formato .jpg con dimensiones de hoja tamaño carta(Ancho:2550px  x Largo:3300px) para q se puedan mostrar en una calidad optima*   </span><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#helpModal">?</button><br>
    <a href="http://smallpdf.com/es/pdf-a-jpg" target="_BLANK"  style="font-weight:bold; "><i class="fa fa-file-image-o"></i>
  Convertir pdf a imagen</a>
    <!-- Modal agregar banco -->
</div>
<!-- line modal -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:65%;">
    <div class="modal-content" >
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-question-circle"></i>  Ayuda para subir membretes</h3>
        </div>
        <div class="modal-body">
          <div id="paso1">
            <img src="./uploads/formatos/membretes/pasos/paso1.png" alt="" class="img-responsive" id="img-help"/>
          </div>       
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info" id="btn-ant" onclick="anterior()"  role="button"><i class="fa fa-arrow-left"></i>
  Anterior</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="btn-sig" class="btn btn-primary " data-action="save" onclick="siguiente()" role="button"><i class="fa fa-arrow-right"></i>
  Siguiente</button>
                </div>
            </div>
            <div id="btnok" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_nuevo()" role="button">Aceptar</button>
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
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-trash"></i>  Eliminar banco</h3>
        </div>
        <div class="modal-body">
            <div id="datos-form2" class="alert alert-danger preg">
                <strong class="center">¿ Esta seguro de eliminar este registro?</strong>
                <input type="text" name="idbanco" id="idbanco" style="display:none;">
              </div>
        <div id="load2" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok2" style="display:none;" class="alert alert-danger">
            <h3><i class="fa fa-info-circle"></i>  El banco ha sido eliminado correctamente </h3>
        </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons2" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" onclick="borrarBanco()" role="button">Eliminar</button>
                </div>
            </div>
            <div id="btnok2" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar_borrar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- modal editar registro -->
<div class="modal fade" id="editar-banco" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i>  Editar banco</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
            <!-- content goes here -->
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-2">Banco:</label>
                <div class="col-md-6">
                    <input type="text" name="edit_banco" class="form-control" id="edit_banco" >
                </div>
                 <div class="col-md-2">
                    <input type="text" name="edit_banco" class="form-control" id="edit_id" disabled="true">
                </div>
                </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-2">No. institución:</label>
                <div class="col-md-6">
                <input type="text" name="edit_inst" class="form-control" id="edit_inst">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-2">Clave:</label>
                <div class="col-md-4">
                <input type="text" id="edit_clave" name="edit_clave" class="form-control col-lg-4">
                </div>
                <p class="help-block">Clave corta para referenciar el banco.</p>
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
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="update_banco()" role="button">Guardar</button>
                </div>
            </div>
            <div id="btnok3" style="display:none;">
                 <button type="button" class="btn btn-default" onclick="aceptar()" role="button">Aceptar</button>
            </div>
        </div>
    </div>
  </div>
</div>

 <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-upload"></i>
  Subir membrete </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="formMembrete" action="ajax.php?c=cuentas&f=subir_membrete" id="formMembrete" enctype="multipart/form-data" onsubmit="return false;">
            <input type="hidden" id="id_soc" name="id_soc">
                <div class="col-lg-12">
                  <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                  <span style="color:#6C0B0B;">* Solamente se permiten imagenes con extensión .jpg *</span>
                </div>
            </form>
            <br><br><br><br>
              <div id="resultados"></div>
          </div>
              <div class="modal-footer ">
           </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
 <!-- Tabla de membretes carga datos por medio de json-->
    <table id="membretes" data-show-export="true"  data-locale="es-MX" data-show-toggle="true" ><table/>

 

<script type="text/javascript">
// initialize with defaults
 $("#fileToUpload").fileinput({
        showUpload: true,
        allowedFileExtensions: ['jpg'],
        elErrorContainer: '#errorBlock',
        language: 'es',
    });

$('#formMembrete').submit(function(e){
   $(this).ajaxSubmit({
        target: '#resultados'
  });

      //e.preventDefault();
    $('#membrete').bootstrapTable('refresh', {silent: true });
     $('#fileToUpload').fileinput('clear');
 
}); 
$(document).ready(function() {
  $i = 1;
	$('#membretes').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=busca_membretes',
        cache: false,
        height: 600,
        striped: true,
        pagination: true,
        pageSize: 200,
        pageList: [10, 25, 50, 100, 200],
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
            field: 'soc',
            title: 'Empresa',
            align: 'center',
            valign: 'middle',
            sortable: true,
            filterControl: 'input'
        },
        {
            field: 'archivo',
            title: 'Membrete',
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

     function FormatterAcciones(values, row) {
        return [
               //'<button class="btn btn-primary  btn-ver" data-toggle="modal" data-target="#Modal-Registrar-Cliente">Ver</button>',
               '<button class="btn btn-info btn-xs btn-editar" style="margin-right:2%;"><i class="fa fa-file-o"></i>  Subir</button>',
        ].join('');
    }

   

//guarda nuevo banco
function guarda_banco()
{
          $('#datos-form').hide('fast');
          $('#load').show('fast');
          $strD = "no_inst=" + $('#no_inst').val() + "&banco=" + $('#banco').val() + "&cve=" + $('#clave').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=guarda_banco",
              success: function (datainstall) {

                if(datainstall.trim()=="OK") {
                    $('#load').hide();
                    $('#buttons').hide();
                    $('#btnok').show();
                    $('#ok').show();
                    $('#Bancos').bootstrapTable('refresh', {silent: true });
                }else{
                    alert('Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');
                }
              }
          });
}
//eventos de la bootstrap table
  window.operateEvents = {
          'click .btn-editar': function (e, value, row, index) {
             $('#uploadFile').modal('show');
             $('#id_soc').val(row.id);
        }
    };
  function siguiente()
  {
      if($i < 6)
      {
        $i++;
      }
     if($("#btn-ant").is(":disabled") == true)
      {
        $('#btn-ant').prop('disabled', false);
      }
     if($i > 5 )
    {
      $('#btn-sig').prop('disabled', true);
    }
    else
    {
      $('#btn-sig').prop('disabled', false);
      $("#img-help").attr("src","./uploads/formatos/membretes/pasos/paso"+$i+".jpg");
    }
  }
   function anterior()
  {
      if($i > 1)
      {
        $i= $i-1;
      }
     if($("#btn-sig").is(":disabled") == true)
      {
        $('#btn-sig').prop('disabled', false);
      }
     if($i <= 1 )
    {
      $('#btn-ant').prop('disabled', true);
    }
    else
    {
      $('#btn-ant').prop('disabled', false);
      $("#img-help").attr("src","./uploads/formatos/membretes/pasos/paso"+$i+".jpg");
    }
  }


  
   

</script>
