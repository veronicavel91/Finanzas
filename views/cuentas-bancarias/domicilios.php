<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<div class="cont-principal container">
    <div class="page-header">
        <h2 class="title"><i class="fa fa-home"></i>  Domicilios</h2>
    </div>
<button data-toggle="modal" data-target="#nuevo-domicilio" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>  Nuevo domicilio</button>
   <!-- Tabla de bancos carga datos por medio de json-->
    <table id="domicilio-table" data-show-export="true"  data-locale="es-MX" data-show-toggle="true" ><table/>
    <!-- Modal agregar banco -->
    <br>
    <br>
    <br>
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
<div class="modal fade" id="editar-domicilio" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:68%;">
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i>  Editar domicilio</h3>
        </div>
        <div class="modal-body">
    <div id="datos-form3">
    <input type="hidden" id="id_dom">
          <div class="form-group row">
                          <label for="" class="col-lg-1 col-lg-offset-1">Cp:</label>
                        <div class="col-lg-2">
                            <div class="input-group">
                            
                              <input type="text" class="form-control" id="cp" class="cp" placeholder="00000">
                              <span class="input-group-btn">
                                <button class="btn btn-info" type="button" onclick="busca_cp()" style="height:39px;"><i class="fa fa-search"></i></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                            <input type="hidden" id="id_cp">
                            <label for="" class="col-lg-1">Colonia:</label>
                            <div class="col-lg-4">
                              <select data-live-search="true" class="selectpicker show-menu-arrow" onchange="busca_datos()" data-size="10" data-width="100%" name="cboCol" id="cboCol">
                                </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-1 col-lg-offset-1">Municipio:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="mpo_cp" name="mpo_cp" disabled="true">
                            </div>
                              <label for="" class="col-lg-1">Estado:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="edo_cp" name="edo_cp" disabled="true">
                            </div>
                        </div>

                        <div class="form-group row">
                             <label for="" class="col-lg-1 col-lg-offset-1">Calle:</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle">
                            </div>
                            <label for="" class="col-lg-1">No.ext:</label>
                             <div class="col-lg-2">
                              <input type="text" class="form-control" id="ext" name="ext" placeholder="ext">
                            </div>
                             <label for="" class="col-lg-1">No.int:</label>
                            <div class="col-lg-2">
                              <input type="text" class="form-control" id="int" name="int" placeholder="int">
                            </div>
                          </div>
                          <div class="form-group row">
                              <label for="" class="col-lg-3 col-lg-offset-1">Información adicional:</label>
                              <div class="col-lg-7">
                                  <textarea  class="form-control" id="info_extra" name="info_extra"></textarea>
                              </div>
                          </div>
                        <div class="form-group row">
                          <label class="col-lg-1 col-lg-offset-1 control-label">  Estado:</label>
                          <div class="col-lg-3">
                            <select name="status_dom" id="status_dom" class="form-control">
                              <option value="">-- Seleccione --</option>
                              <option value="1">Activo</option>
                              <option value="0">Cancelado</option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <span style="color:#6B2323;">*ATENCION: El cambio de estado del domicilio afecta a las cuentas bancarias con este domicilio*</span>
                          </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-1 col-lg-offset-1 control-label">  Periodo del:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="inicio_dom" id="inicio_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <label  class="col-lg-1 control-label">al:</label>
                            <div class="col-lg-3 date">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="fin_dom" id="fin_dom" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                              <div class="col-lg-1" id="loader-dom" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                        </div>
    </div>
  </div>
<div class="btn-group btn-group-justified" role="group" id="buttons_agrega_cheq" aria-label="group button">
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
      </div>
      <div class="btn-group" role="group">
          <button class="btn btn-info pull-right addButton"  data-template="textbox" id="guarda_cheque" onclick="update_dom()"><i class="fa fa-refresh"></i>  Actualizar datos</button>
      </div>
</div>
</div>
    </div>
</div>
<!-- Modal para agregar un nuevo domicilio -->
<div class="modal fade" id="nuevo-domicilio" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:68%;">
    <div class="modal-content">
      <div class="modal-header modal-header-danger">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-home"></i>  Nuevo domicilio</h3>
      </div>
      <div class="modal-body">
        <div id="datos-form3">
          <div class="form-group row">
              <label for="" class="col-lg-1 col-lg-offset-1">Cp: <span style="color:#A92E2E;">*</span>  </label>
            <div class="col-lg-2">
                <div class="input-group">
                
                  <input type="text" class="form-control" id="cp_nvo" class="cp" placeholder="00000">
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="busca_cp_nvo()" style="height:39px;"><i class="fa fa-search"></i></button>
                  </span>
                </div><!-- /input-group -->
            </div>
                <input type="hidden" id="id_cp">
                <label for="" class="col-lg-1">Colonia:<span style="color:#A92E2E;">*</span></label>
                <div class="col-lg-4">
                  <select data-live-search="true" class="selectpicker show-menu-arrow" onchange="busca_datos_nvo()" data-size="10" data-width="100%" name="cboCol_nvo" id="cboCol_nvo">
                    </select>
                    </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-lg-1 col-lg-offset-1">Municipio:<span style="color:#A92E2E;">*</span></label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="mpo_cp_nvo" name="mpo_cp" disabled="true">
                </div>
                  <label for="" class="col-lg-1">Estado:<span style="color:#A92E2E;">*</span></label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="edo_cp_nvo" name="edo_cp" disabled="true">
                </div>
            </div>
            <div class="form-group row">
                 <label for="" class="col-lg-1 col-lg-offset-1">Calle:<span style="color:#A92E2E;">*</span></label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="calle_nvo" name="calle" placeholder="Calle">
                </div>
                <label for="" class="col-lg-1">No.ext:<span style="color:#A92E2E;">*</span></label>
                 <div class="col-lg-2">
                  <input type="text" class="form-control" id="ext_nvo" name="ext" placeholder="ext_nvo">
                </div>
                 <label for="" class="col-lg-1">No.int:</label>
                <div class="col-lg-2">
                  <input type="text" class="form-control" id="int_nvo" name="int" placeholder="int_nvo">
                </div>
              </div>
              <div class="form-group row">
                  <label for="" class="col-lg-3 col-lg-offset-1">Información adicional:</label>
                  <div class="col-lg-7">
                      <textarea  class="form-control" id="info_extra_nvo" name="info_extra_nvo"></textarea>
                  </div>
              </div>
            <div class="form-group row">
                <label class="col-lg-1 col-lg-offset-1 control-label">  Periodo del:</label>
                <div class="col-lg-3 date">
                    <div class="input-group input-append date" id="datePicker">
                        <input type="text" class="form-control" name="inicio_dom" id="inicio_dom_nvo" placeholder="aaaa-mm-dd" />
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                <label  class="col-lg-1 control-label">al:</label>
                <div class="col-lg-3 date">
                    <div class="input-group input-append date" id="datePicker">
                        <input type="text" class="form-control" name="fin_dom_nvo" id="fin_dom_nvo" placeholder="aaaa-mm-dd" />
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                  <div class="col-lg-1" id="loader-dom" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
            </div>
         </div>
  </div>
   <div class="btn-group btn-group-justified" role="group" id="buttons_agrega_cheq" aria-label="group button">
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
      </div>
      <div class="btn-group" role="group">
          <button class="btn btn-info pull-right addButton"  data-template="textbox" id="guarda_cheque" onclick="guarda_dom()"><i class="fa fa-refresh"></i>  Guardar domicilio</button>
      </div>
</div>



 


<script type="text/javascript">
$(document).ready(function() {
   $('#inicio_dom').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#fin_dom').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
	$('#domicilio-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=muestra_dom',
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
            title: 'Codigo',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'domicilio',
            title: 'Domicilio',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'periodo_inicio',
            title: 'Periodo inicio',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'periodo_fin',
            title: 'Periodo fin',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'estado',
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

});

     function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-info btn-xs btn-editar" style="margin-right:2%;">Editar</button>'
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
            self.modalEditar(row.id);

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
              url: "ajax.php?c=cuentas&f=buscar_domicilio",
              success: function (data) {
            $('#editar-domicilio').modal('show');
            $('#id_dom').val(id);

            var json_obj = $.parseJSON(data);//parse JSON
            
            for (var i in json_obj) 
            {
              $('#cp').val(json_obj[i].cp);
              $('#mpo_cp').val(json_obj[i].mun);
              $('#edo_cp').val(json_obj[i].edo);
              $('#calle').val(json_obj[i].calle);
              $('#ext').val(json_obj[i].num_ext);
              $('#int').val(json_obj[i].num_int);
              $('#status_dom').val(json_obj[i].status);
              $('#info_extra').val(json_obj[i].info_extra);
              $('#inicio_dom').val(json_obj[i].inicio);
              $('#fin_dom').val(json_obj[i].fin);
              $str = "id=" +$('#cp').val();
              $.ajax({
              data: $str,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=busca_colonias",
              success:function ($data){
                 $("#cboCol").html($data);
                 $('#cboCol').selectpicker('refresh');
                 $('#cboCol').val(json_obj[i].Idcol);
                 $('#cboCol').selectpicker('render')
              }
              })
              
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

 $('input#cp').keyup(function() {
  if ($("#cp").val().length == 5) {
    $str = "id=" +$('#cp').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol").html($data);
           $('#cboCol').selectpicker('refresh');

        }
        })
   }
   else if($("#cp").val().length > 5)
   {
      show_stack_bar_top('warning','C.P invalido','El cp debe tener 5 digitos');
   }

});
 function busca_cp() {

    if ($("#cp").val().length == 5) {
         $str = "id=" +$('#cp').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol").html($data);
           $('#cboCol').selectpicker('refresh');

        }
        })
    }
    else
    {
        alert("El C.P debe estar conformado por 5 digitos");
    }

  }
    function update_dom()
    {

       $('#btn-cp').hide();
       $('#loader-dom').show();
       $strD = "id=" + $('#id_dom').val() + "&ext=" + $('#ext').val() + "&int=" + $('#int').val() +"&status_dom=" + $('#status_dom').val() +"&info_extra=" + $('#info_extra').val() + "&inicio_dom=" + $('#inicio_dom').val() + "&fin_dom=" + $('#fin_dom').val()+ "&cp=" + $('#cboCol').val() + "&calle=" + $('#calle').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=update_datos_domicilio",
            success:function ($databack)
            {
                if($databack==1)
                {
                    $('#loader-dom').hide();
                    show_stack_bar_top('success','¡Datos actualizados correctamente!');
                     $('#domicilio-table').bootstrapTable('refresh',
                      {silent: true});
                      $('#editar-domicilio').modal('hide');

                }
                 else
                {
                    $('#loader-dom').hide();
                    $('#btn-cp').show();
                    show_stack_bar_top('error','Lo sentimos ha ocurrido un error al actualizar el domicilio, por favor intentelo de nuevo, error:'+ $databack);
                }  
            }
        })  

    }
//guarda un nuevo domicilio
 function guarda_dom()
    {
      if( $('#cboCol_nvo').val() == "" || $('#cboCol_nvo').val() == "" || $('#calle_nvo').val() == "" || $('#calle_nvo').val() == "" || $('#ext_nvo').val() == "" || $('#mpo_cp_nvo').val() == "" || $('#edo_cp_nvo').val() == "" )
      {
        show_stack_bar_top('warning','Datos ','Por favor complete los campos requeridos(*)');

      }
      else
      {
         $('#btn-cp').hide();
         $('#loader-dom-nvo').show();
         $strD = "cp=" + $('#cboCol_nvo').val() +"&calle=" + $('#calle_nvo').val() +"&ext=" + $('#ext_nvo').val() + "&int=" + $('#int_nvo').val() + "&inicio=" + $('#inicio_dom_nvo').val() + "&fin=" + $('#fin_dom_nvo').val() + "&info_extra=" + $('#info_extra_nvo').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=guarda_domicilio",
              success:function ($databack)
              {
                  if($databack==1)
                  {
                      $('#loader-dom').hide();
                      alert("¡Domicilio guardado correctamente!");
                      $('#btn-cp-nvo').show();
                       $('#domicilio-table').bootstrapTable('refresh',
                        {silent: true});
                        $('#nuevo-domicilio').modal('hide');
                      
                  }
                   else
                  {
                       $('#loader-dom-nvo').hide();
                      $('#btn-cp-nvo').show();
                      alert("Lo sentimos ha ocurrido un error al  guardar el domicilio, intentelo de nuevo");
                  }  
              }
          })  
          //limpiamos las cajas de texto
          $('#mpo_cp_nvo').val("");
          $('#edo_cp_nvo').val("");
          $('#calle_nvo').val("");
          $('#int_nvo').val("");
          $('#ext_nvo').val("");
          $('#inicio_dom_nvo').val("");
          $('#fin_dom_nvo').val("");
        }

    }
    //busca cp de nuevo domicilio
    function busca_cp_nvo() {

    if ($("#cp_nvo").val().length == 5) {
         $str = "id=" +$('#cp_nvo').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol_nvo").html($data);
           $('#cboCol_nvo').selectpicker('refresh');

        }
        })
    }
    else
    {
        alert("El C.P debe estar conformado por 5 digitos");
    }

  }
  $('input#cp_nvo').keyup(function() {
  if ($("#cp_nvo").val().length == 5) {
    $str = "id=" +$('#cp_nvo').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_colonias",
        success:function ($data){
           $("#cboCol_nvo").html($data);
           $('#cboCol_nvo').selectpicker('refresh');

        }
        })
   }
   else if($("#cp_nvo").val().length > 5)
   {
      show_stack_bar_top('warning','C.P invalido','El cp debe tener 5 digitos');
   }

});
   function busca_datos_nvo()
    {
        $str = "cp=" +  $('#cp_nvo').val();
        $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=datos_cp",
        success:function (data){
            var json_obj = $.parseJSON(data);//parse JSON
            
            for (var i in json_obj) 
            {
                $('#mpo_cp_nvo').val(json_obj[i].mun);
                $('#edo_cp_nvo').val(json_obj[i].edo);
              
            }

        }
    })
    }
      $('#domicilio-table').tableExport({
       fileName: 'reporte_cuentas',
       type:'pdf',
       jspdf: {orientation: 'p',
               margins: {left:20, top:10},
               autotable: false}
      });
</script>
