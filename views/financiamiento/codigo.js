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
               //alert($databack);
               $('#loader').hide();
               $("#cboSociedad").html($databack);
               $('#cboSociedad').selectpicker('refresh');
        
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
    $(document).ready(function() {
        //tabla de cheques
        $('#cheques-table').bootstrapTable({
            cache: false,
            height: 300,
            striped: true,
            pagination: true,
            pageSize: 50,
            pageList: [10, 25, 50, 100, 200],
            search: true,
            showColumns: true,
            minimumCountColumns: 2,
            clickToSelect: false,
            showExport:true,
            resizable:false,
            exportTypes:[ 'xml','txt','excel','pdf','word'],
            exportDataType: $(this).val(),
            columns: [{
                field: 'id',
                title: 'Folio cheque'
            },
            {
                field: 'fecha_cheque',
                title: 'Fecha'
            },
            {
                field: 'soc_cheque',
                title: 'Sociedad'
            },
            {
                field: 'importe',
                title: 'Importe'
            },
            {
                field: 'obs',
                title: 'Observaciones'
            },

           {
            field: 'Acciones',
            title: 'Borrar',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            formatter: FormatterAcciones,
            events: operateEvents
        }
        ]
    });

     function FormatterAcciones(values, row) {
        return [
               '<label class="btn btn-danger btn-sm btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }//fin tabla de cheques
   
         $('#fecha_finan')
        .datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
          $('#periodo_del').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
        $('#periodo_al').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
         $('#fecha_cheque').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
        $('#fecha_finan').mask('0000-00-00');
        $('#periodo_del').mask('0000-00-00');
        $('#periodo_al').mask('0000-00-00');
        $('#fecha_cheque').mask('0000-00-00');
        //datepicker
            $('#fecha_finan').datepicker({
            format: "dd/mm/yyyy"
        });
          $('#periodo_del').datepicker({
            format: "dd/mm/yyyy"
        }); 
           $('#periodo_al').datepicker({
            format: "dd/mm/yyyy"
        });   
         $('#fecha_fact').datepicker({
            format: "dd/mm/yyyy"
        });   
        //validacion de formulario
          $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                cboPlaza: {
                    validators: {
                        notEmpty: {
                            message: 'El responsable es requerido'
                        }
                    }
                }
                
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors');
            }
            $('#errors').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors').find('li[data-bv-for="' + data.field + '"]').remove();
        })
        .on('success.form.bv', function(e) {
            $('#errors')
                .html('')
                .parents('.form-group').addClass('hide');
            });
    });
//agregar otro cheque
        var self = this;
        index= 1;
        self.cheques = [];
        self.chequeSelected = null;

        self.guardarCheque = function () {
            var cheque = {
                no_cheque: $('#no_cheque').val(),
                soc: $('#soc_cheque').val(),
                fecha_cheque: document.getElementById("fecha_cheque").value,
                importe: $('#imp_cheque').val(),
                obser: document.getElementById("obs_cheque").value,
            }
            self.cheques.push(new Cheque(cheque))
            index=index+1;
            //mostramos el cheque en la tabla
             $('#cheques-table').bootstrapTable('insertRow', {
                index: + index,
                row: {
                    id: + $('#no_cheque').val(),
                    fecha_cheque: document.getElementById("fecha_cheque").value,
                    soc_cheque: +  $('#soc_cheque').val(),
                    importe: + $('#imp_cheque').val(),
                    obs: document.getElementById("obs_cheque").value,
                }
            });
        }
        function Cheque(data) {
            var self = this;
            self.Cheque = data.no_cheque;
            self.Soc_cheque = data.soc;
            self.Fecha_cheque = data.fecha_cheque;
            self.Importe = data.importe;
            self.Observaciones = data.obser;
        }
        function BorrarCheque(index)
        {
            alert(index);
            cheques.splice(index, 1);
        }

      window.operateEvents = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarCheque(index);
            },
              'click .btn-editar': function (e, value, row, index) {
                //el objeto row es el que nos trae toda la info del objeto
                self.modalEditar(row.idbancos);

            }
        };
function guardar()
{
  //$('#esperar').modal('show');
  $strD = $("#FormFinanciamiento").serialize();
  alert($strD);
  $.ajax({
      data: $strD,
      type: "POST",
      dataType: "text",
      url: "ajax.php?c=cuentas&f=guarda_financiamiento",
      success: function (data) {

        if(data.trim()==1) {
            $('#loading').hide();
            $('#lineModalLabel').text('El financiamiento ha sido guardado');
            $('#ok').show();
            $('#button').show();
            }else{
            $('#esperar').modal('hide');
            alert('Lo sentimos, ha ocurrido un error al guardar el financiamiento');
        }
      }
  });
}
//funcion del boton aceptar del modal
function aceptar()
{
    $('#ok').hide();
    $('#button').hide();
    $('#loading').show();
    $('#esperar').modal('hide');
}