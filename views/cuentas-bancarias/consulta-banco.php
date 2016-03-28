<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="cont-principal container">
    <div class="page-header">
        <h2 class="title"><i class="fa fa-university"></i>  Bancos</h2>
    </div>
<button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary"><i class="fa fa-plus"></i>  Nuevo banco</button>
   <!-- Tabla de bancos carga datos por medio de json-->
    <table id="Bancos" data-show-export="true"  data-locale="es-MX" data-show-toggle="true" ><table/>
    <!-- Modal agregar banco -->
</div>
<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-plus"></i>  Nuevo banco</h3>
        </div>
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


 


<script type="text/javascript">
$(document).ready(function() {
	$('#Bancos').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=muestra_bancos',
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
            field: 'idbancos',
            title: 'Id',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'nombre',
            title: 'Banco',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'no_institucion',
            title: 'No.institución',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'cve_transfer',
            title: 'Clave',
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
               '<button class="btn btn-info btn-xs btn-editar" style="margin-right:2%;">Editar</button>',
               '<button class="btn btn-danger btn-xs btn-borrar">Borrar</button>'
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
        'click .btn-borrar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalBorrar(row.idbancos);
        },
          'click .btn-editar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalEditar(row.idbancos);

        }
    };
    //muestra el modal para eliminar el registro
    function modalBorrar(id)
    {
        $('#borrar').modal('show');
        $('#idbanco').val(id);
        
    }
    function borrarBanco()
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
                    $('#Bancos').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el banco no ha podido ser eliminado');
                }
              }
          });
    }

     function modalEditar(id)
    {
        //alert(id);
         $strD = "id=" + id;
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "html",
              url: "ajax.php?c=cuentas&f=buscar_banco",
              success: function (data) {
            $('#editar-banco').modal('show');
            var json_obj = $.parseJSON(data);//parse JSON
            
            for (var i in json_obj) 
            {
                $('#edit_id').val(json_obj[i].idban);
                $('#edit_banco').val(json_obj[i].nombre);
                $('#edit_inst').val(json_obj[i].no);
                $('#edit_clave').val(json_obj[i].cve);
            }

              }
          });
    }
    function update_banco()
    {
         $('#datos-form3').hide();
         $('#load3').show();
         $strD = "id=" + $('#edit_id').val() + "&nombre="+ $('#edit_banco').val() + "&no="+ $('#edit_inst').val() + "&cve="+ $('#edit_clave').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=update_banco",
              success: function (data) {

                if(data.trim()=="OK") {
                    $('#load3').hide();
                    $('#buttons3').hide();
                    $('#btnok3').show();
                    $('#ok3').show();
                    $('#Bancos').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el banco no ha podido ser eliminado');
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
     $('#editar-banco').modal('hide');
    }
    function aceptar_borrar()
    {
        $('#buttons2').show();
        $('#btnok2').hide();
        $('#ok2').hide();
        $('#datos-form2').show();
        $('#borrar').modal('hide');
    }
     function aceptar_nuevo()
    {
        $('#buttons').show();
        $('#btnok').hide();
        $('.preg').hide();
        $('#ok').hide();
        $('#datos-form').show();
        $('#banco').val('');
        $('#no_inst').val('');
        $('#clave').val('');
        $('#squarespaceModal').modal('hide');

    }

</script>
