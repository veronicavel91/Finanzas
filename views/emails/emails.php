<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<style type="text/css">
  .table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
  background-color: #C8E2EC;
  color:#000;
}
</style>
<div class="container">
    <div class="page-header">
    <br>
        <h2 class="title"><i class="fa fa-envelope"></i>  Correos del personal</h2>
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
        <button class="btn btn-primary btn-sm" onclick="consulta_email()"><i class="fa fa-search"></i>  Buscar</button>
      </div>
      <br><br>
  </div>
</div>
    <!-- Modal agregar banco -->
</div>
<div class="col-lg-11 col-lg-offset-1">
<button onclick="modalEmail()" class="btn btn-warning pull-left btn-sm"><i class="fa fa-plus"></i>  Registrar correo</button>
  <table id="table-emails" data-show-export="true"  data-locale="es-MX" data-show-toggle="true" data-width="100%" ><table/>
</div>
<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-plus"></i>  Nuevo correo</h3>
        </div>
        <div class="modal-body">
            <div id="datos-form">
            <!-- content goes here -->
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-2 control-label">Empleado:</label>

                <div class="col-md-6">

                    <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" name="usuario" id="user">
                      <option value="">-- Seleccione empleado --</option>
                      <?php while($persona= $personas->fetch_assoc())
                      {?>
                         <option value="<?php echo $persona['Id_empleado']?>"><?php echo $persona['nombre_emp']?></option>

                      <?php } ?>
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-2">Email:</label>
                <div class="col-md-6">
                <input type="email" name="email" class="form-control" id="email">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-2">Estado:</label>
                <div class="col-md-4">
                  <input type="text" name="status_email" id="status_email" class="form-control" value="Activo" disabled="true">
                </div>
              </div>

        </div>
        <div id="load" style="display:none;" class="col-md-10 col-md-offset-2">
            <img src="./images/loader.gif">
            <br><br>
        </div>
        <div id="ok" style="display:none;" class="alert alert-success">
            <h3><i class="fa fa-check"></i>  Correo guardado correctamente</h3>
        </div>
        
        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" id="buttons" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="guarda_email()" role="button">Guardar</button>
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
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-trash"></i>  Eliminar correo</h3>
        </div>
        <div class="modal-body">
            <div id="datos-form2" class="alert alert-danger preg">
                <i class="fa fa-info-circle"></i><strong class="center">¿ Esta seguro de eliminar este correo ?</strong><span> una vez eliminado ya no podra enviarle correos a este empleado </span>
                <input type="text" name="id" id="id" style="display:none;">
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
                    <button type="button" class="btn btn-danger" onclick="borrarEmail()" role="button">Eliminar</button>
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
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i>  Editar correo</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
            <!-- content goes here -->
              <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-2">Empleado:</label>
                <div class="col-md-6">
                   <input type="text" name="edit_name" id="edit_name" class="form-control" disabled="true">
                </div>
                <label class="col-md-1">Id:</label>
                 <div class="col-md-2">
                    <input type="text" name="edit_id" class="form-control" id="edit_id" disabled="true">
                </div>
                </div>
              <div class="form-group row">
                <label for="exampleInputPassword1" class="col-md-2">Email:</label>
                <div class="col-md-6">
                <input type="text" name="edit_email" class="form-control" id="edit_email">
                </div>
              </div>
              <div class="form-group row">
                <label for="clave" class="col-md-2">Estado:</label>
                <div class="col-md-4">
                  <select class="form-control" name="edit_status" id="edit_status">
                    <option value="1">Activo</option>
                    <option value="0">Cancelado</option>
                  </select>
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
                    <button type="button" id="saveImage" class="btn btn-info btn-hover-green" data-action="save" onclick="update_email()" role="button">Guardar</button>
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
	$('#table-emails').bootstrapTable({
       method: 'get',
        url: 'ajax.php?c=email&f=muestra_emails',
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
            field: 'nombre_emp',
            title: 'Empleado',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'email',
            title: 'Email',
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
  $('.selectpicker').selectpicker();
});

     function FormatterAcciones(values, row) {
        return [
               //'<button class="btn btn-primary  btn-ver" data-toggle="modal" data-target="#Modal-Registrar-Cliente">Ver</button>',
               '<button class="btn btn-info btn-xs btn-editar" style="margin-right:2%;">Editar</button>',
               '<button class="btn btn-danger btn-xs btn-borrar">Borrar</button>'
        ].join('');
    }

function modalEmail()
{
  if($('#cboPlaza').val()== "" || $('#cboSociedad').val()== "")
  {
      show_stack_bar_top('warning','Complete los campos','Seleccione la plaza y sociedad');
  }
  else
  {
    $('#squarespaceModal').modal('show');
  }
}  

//guarda nuevo banco
function guarda_email()
{
  if($('#email').val()=="" || $('#user').val() == "")
  {
      show_stack_bar_top('warning','Datos incompletos','Por favor complete todos los datos');

  }
  else
  {
          $('#datos-form').hide('fast');
          $('#load').show('fast');
          $strD = "emp=" + $('#user').val() + "&email=" + $('#email').val() + "&plaza=" + $('#cboPlaza').val()  + "&soc=" + $('#cboSociedad').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=email&f=guarda_email",
              success: function (datainstall) {

                if(datainstall.trim()=="OK") {
                    $('#load').hide();
                    $('#buttons').hide();
                    $('#btnok').show();
                    $('#ok').show();
                    $('#table-emails').bootstrapTable('refresh', {silent: true });
                }else{
                    alert('Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');
                }
              }
          });
    }
}
//eventos de la bootstrap table
  window.operateEvents = {
        'click .btn-borrar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalBorrar(row.id);
        },
          'click .btn-editar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalEditar(row.id);

        }
    };
    //muestra el modal para eliminar el registro
    function modalBorrar(id)
    {
        $('#borrar').modal('show');
        $('#id').val(id);
        
    }
    function borrarEmail()
    {
       $('#datos-form2').hide('fast');
          $('#load2').show('fast');
          $strD = "id=" + $('#id').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=email&f=borrar_email",
              success: function (data) {

                if(data.trim()=="OK") {
                    $('#load2').hide();
                    $('#buttons2').hide();
                    $('#btnok2').show();
                    $('.preg').hide();
                    $('#ok2').show();
                    $('#table-emails').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el registro no ha podido ser eliminado');
                }
              }
          });
    }

     function modalEditar(id)
    {

         $strD = "id=" + id;
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "html",
              url: "ajax.php?c=email&f=buscar_email",
              success: function (data) {
            $('#editar-banco').modal('show');
            $("#edit_status").find('option').removeAttr("selected");
            $("#edit_emp").find('option').removeAttr("selected");
            var json_obj = $.parseJSON(data);//parse JSON
            for (var i in json_obj) 
            {
                var st = json_obj[i].status;
                $('#edit_id').val(json_obj[i].idcorreo);
                $('#edit_email').val(json_obj[i].email);
                $('#edit_name').val(json_obj[i].nombre_emp);
                if( st == 1)
                {
                $('#edit_status > option[value="1"]').attr('selected', 'selected');
                }
                else
                {
                  $('#edit_status > option[value="0"]').attr('selected', 'selected');
                }
    
            }

              }
          });
    }
    function update_email()
    {
         $('#datos-form3').hide();
         $('#load3').show();
         $strD = "id=" + $('#edit_id').val() + "&email="+ $('#edit_email').val() + "&status="+ $('#edit_status').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=email&f=update_email",
              success: function (data) {

                if(data.trim()=="OK") {
                    $('#load3').hide();
                    $('#buttons3').hide();
                    $('#btnok3').show();
                    $('#ok3').show();
                    $('#table-emails').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error al actualizar los datos');
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
        $('#email').val('');
        $("#user").find('option').removeAttr("selected");
        $('#squarespaceModal').modal('hide');
    }
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
     function consulta_email()
    {

       $('#table-emails').bootstrapTable('refresh', {url: 'ajax.php?c=email&f=muestra_emails&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val()});
    }
</script>