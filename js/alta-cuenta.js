
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
               //alert($databack);
               //$('#myModal').modal('hide'); 
               $('#loader').hide();
               $("#cboSociedad").html($databack);
               $('#cboSociedad').selectpicker('refresh');
        
            }
        })
    }; 
    //busca responsables de la cuenta dependiendo del tipo de responsable
   function responsable()
    {
        $('#load_tipo').show();
        $strD = "tipo_resp=" + $('#tipo_resp').val() + "&soc=" + $('#soc_resp').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_responsable",
            success:function ($databack){
               $('#load_tipo').hide();
               $("#resp_cta").html($databack);
               $('#resp_cta').selectpicker('refresh');
        
            }
        })
    };

//validador de formulario
$(document).ready(function() {
    //mascaras
    $('#saldo_inicial').mask('000,000,000,000,000.00', {reverse: true});

    //notificaciones
    PNotify.prototype.options.styling = "fontawesome";
    var notice = new PNotify({
    title: 'Alta de cuenta',
    text: 'Complete todos los campos y dar click en guardar',
    type: 'info',
    buttons: {
        closer: true,
        closer_hover: true,
        sticker: false
    }
});
notice.get().click(function() {
    notice.remove();
});
//notificacion horizontal

    $('.cp').mask('00000');
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
      $('#f_alta').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#dom_ini').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
     $('#dom_fin').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
       $('#f_token').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
      $('#f_vence').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#defaultForm')
        .bootstrapValidator({
            locale: 'es_ES',
            framework: 'bootstrap',
            excluded: [':disabled'],
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                 cboPlaza: {
                group: '.group',
                validators: {
                    notEmpty: {
                        message: 'Seleccione plaza'
                    }

                }
            },
            sociedad: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione sociedad'
                    }
                }
            },
                 bank: {
                group: '.group',
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            cta: {
                validators: {
                    notEmpty: {
                        message: 'La cuenta es requerida'
                    },
                     numeric: {
                            message: 'La cuenta debe ser númerica'
                        }

                }
            },
                sucursal: {
                    group: '.group',
                    validators: {
                        numeric: {
                            message: 'La sucursal debe ser númerica'
                        } 
                    }
                },
                 tipo_cuenta: {
                    group: '.group',
                    validators: {
                        notEmpty: {
                            message: 'Tipo de cuenta requerido'
                        }     
                    }
                },
                clabe: {
                validators: {
                    notEmpty: {
                        message: 'La clabe es requerida'
                    }

                }
            },
                f_alta: {
                    group: '.group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese la fecha de apertura'
                        }
                    }
                },
                 usuario: {
                validators: {
                    notEmpty: {
                        message: 'El usuario de la cuenta es requerido'
                    }

                }
            },
                status_cta: {
                    group: '.group',
                    validators: {
                        notEmpty: {
                            message: 'Seleccione un estado para la cuenta'
                        }
                    }
                },
                resp_nombre: {
                    validators: {
                        notEmpty: {
                            message: 'El responsable es requerido'
                        }
                    }
                },
                 area: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione area de operación'
                        }
                    }
                },
                tipo_op: {
                group: '.group',
                validators: {
                    notEmpty: {
                        message: 'Seleccione operación'
                    }

                }
            },
            preg_dom: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una opción'
                    }
                }
            },
            personal_tipo: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de personal'
                    }
                }
            },
            firmante_tipo: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el tipo de personal'
                    }
                }
            },
            contrato_nomina: {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido'
                    }
                }
            },
                saldo_inicial: {
                    group: '.group',
                    validators: {
                        notEmpty: {
                            message: 'Ingrese el saldo inicial'
                        }
                    }
                },
                  preg_resp: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione una opción'
                        }
                    }
                },
                 no_cheques: {
                    numeric: {
                            message: 'La cuenta debe ser númerica'
                        }
                },
                cheque_inicial: {
                    enabled: false,
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
                        }
                    }
                },
                 cheque_final: {
                    enabled: false,
                },
                 no_cheques: {
                    enabled: false,
                },
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
        .on('status.field.bv', function(e, data) {
            var $form     = $(e.target),
                validator = data.bv,
                $tabPane  = data.element.parents('.tab-pane'),
                tabId     = $tabPane.attr('id');
            
            if (tabId) {
                var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

                // Add custom class to tab containing the field
                if (data.status == validator.STATUS_INVALID) {
                    $icon.removeClass('fa-check').addClass('fa-times');
                } else if (data.status == validator.STATUS_VALID) {
                    var isValidTab = validator.isValidContainer($tabPane);
                    $icon.removeClass('fa-check fa-times')
                         .addClass(isValidTab ? 'fa-check' : 'fa-times');
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

          
          if( $('#firmante_tipo').val() != 00 && firmantes.length == 0){  
            show_stack_bar_top('error','Datos incompletos','No agrego ningun firmante');
          }
          else{
            $('#esperar').modal('show');
              $.ajax({
                   data: 
                  {
                    'firmantes': firmantes,
                    'preguntas': preguntas,
                    'plaza':  $('#cboPlaza').val(),
                    'soc': $('#cboSociedad').val(),
                    'domicilio':  $('#cboDom').val(),
                    'banco':  $('#bank').val(),
                    'cuenta':  $('#cta').val(),
                    'sucursal':  $('#sucursal').val(),
                    'n_sucursal':  $('#n_sucursal').val(),
                    'moneda':  $('#moneda').val(),
                    'clabe':  $('#cbe').val(),
                    'f_alta': $('#f_alta').val(),
                    'user': $('#user').val(),
                    'plaza_user': $('#plaza_user').val(),
                    'soc_user': $('#soc_user').val(),
                    'status_cta': $('#status_cta').val(),
                    'area': $('#area').val(),
                    'saldo_inicial':  $('#saldo_inicial').val(),
                    'no_contrato':  $('#cont').val(),
                    'no_cliente' : $('#no_cliente').val(),
                    'contrato_nomina' : $('#contrato_nomina').val(),
                    'tipo_op' : $('#tipo_op').val(),
                    'tipo_cuenta' : $('#tipo_cuenta').val(),
                    'tipo_resp':  $('#tipo_resp').val(),
                    'resp_cta': $('#resp_cta').val(),
                    'soc_resp': $('#soc_resp').val(),
                    'plaza_resp': $('#plazaResp').val(),
                    'obs': $('#obs').val(),
                    'dom_ini': $('#dom_ini').val(),
                    'dom_fin': $('#dom_fin').val(),
                    'personal_tipo': $('#personal_tipo').val(),
                    'status_cta': $('#status_cta').val(),
                    'folio': $('#folio').val(),
                    'fecha_bloq': $('#fecha_bloq').val(),
                    'firmante_tipo': $('#firmante_tipo').val(),
                    'coment': $('#coment').val(),
                    'resp_cheq': $('#resp_cheq').val(),
                    'usuario_ext': document.getElementById("usuario_ext").value,
                    'cheque_obs': document.getElementById("obs_cheque").value,
                    'f_asig': document.getElementById("f_asig").value,
                    'folio_cheq':  $('#folio_cheq').val(),
                    'no_cheques':  $('#no_cheques').val(),
                    'cheque_inicial':  $('#cheque_inicial').val(),
                    'cheque_final': document.getElementById("cheque_final").value,
                    'status_chequera': $('#status_chequera').val(),
                    'cod_token': $('#cod_token').val(),
                    'resp_token': $('#resp_token').val(),
                    'f_token': $('#f_token').val(),
                    'vence':  $('#vence').val(),
                    'f_vence':  $('#f_vence').val(),
                    'obs_token':  $('#obs_token').val(),
                    'status_token': $('#status_token').val(),
                    'preg_dom': $('#preg_dom').val(),
                    'personal_tipo': $('#personal_tipo').val(),
                    'preg_resp': $('#preg_resp').val()
                  },
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=guarda_cuenta",
                  success: function (data) {
                   // alert(data);
                    if(data.trim()=="OK") {
                        $('#loading').hide();
                        $('#lineModalLabel').text('La cuenta ha sido guardada');
                        $('#ok').show();
                        $('#button').show();
                        $("#defaultForm")[0].reset();
                        window.location="/systema/finanzas/index.php?c=cuentas&f=get_consulta";
                        }else{
                        $('#esperar').modal('hide');
                        alert('Lo sentimos, ha ocurrido un error al guardar la cuenta');
                    }
                  }
                  });
            }
});
      
    //cajas de fechas
    $('#datePicker')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
        });
      $('#fecha_asig')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })

        $('#f_alta').mask('00/00/0000');
        $('#f_asig').mask('00/00/0000');
         //cambiando el idioma del date picker       
    ;(function($){
    $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        clear: "Borrar",
        weekStart: 1,
        format: "dd/mm/yyyy"
    };
    }(jQuery));

    $('#firmante-table').bootstrapTable({
        cache: false,
        height: 650,
        striped: true,
        pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        search: true,
        showColumns: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        resizable:false,
        columns: [{
            field: 'id_fir',
            title: 'Id',
            sortable: true
        },
        {
            field: 'tipo',
            title: 'Tipo',
            sortable: true
        },
        {
            field: 'plaza',
            title: 'Plaza',
            sortable: true
        },
        {
            field: 'soc',
            title: 'Sociedad',
            sortable: true
        },
        {
            field: 'nombre',
            title: 'Firmante',
            sortable: true
        },
        
       {
        field: 'Acciones',
        title: 'Borrar',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterFirmante,
        events: eventsFirmante
        }
        ]
    });
    $('#preguntas-table').bootstrapTable({
        cache: false,
        height: 480,
        width: 300,
        striped: true,
        pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        search: true,
        showColumns: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        resizable:false,
        cardView:true,
        columns: [
        {
            field: 'preg',
            title: 'Pregunta',
            sortable: true
        },
        {
            field: 'resp_preg',
            title: 'Respuesta',
            sortable: true
        },
       {
        field: 'Acciones',
        title: 'Borrar',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        //formatter: FormatterAcciones,
        //events: operateEvents
        }
        ]
    });
});
  function FormatterFirmante(values, row) {
        return [
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    //acciones de firmantes
      window.eventsFirmante = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarCheque(index, row.id, row.importe);
            }
        };
         function FormatterDom(values, row) {
        return [
               '<label class="btn btn-danger btn-xs btn-borrar pull-right"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    //acciones de firmantes
      window.eventsDom = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarDom(row.id);
            }
        };
     function FormatterDomicilio(values, row) {
        if(row.estado == "<span  class='label label-success'>Activo</span>")
        {
            return [
                   '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-exclamation-circle"></i></label>',
                    '<label class="btn btn-info btn-xs btn-editar" style="margin-left:8%;"><i class="fa fa-pencil"></i></label>'

            ].join('');
        }
    }
    //acciones de firmantes
      window.eventsDomicilio = {
            'click .btn-borrar': function (e, value, row, index) {
                 $.confirm({
                text: "¿Esta seguro que desea cancelar este domicilio?(Este domicilio lo pueden estar utilizando actualmente otras cuentas)",
                confirmButton: "Si, Cancelar",
                cancelButton: "No",
                confirm: function() {
                    $strD = "id=" + row.id;
                    $.ajax({
                    data: $strD,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=cuentas&f=cancela_domicilio",
                    success:function ($data){
                    if($data == 1)
                    {
                        show_stack_bar_top('info','Domicilio cancelado','el domicilio ha sido cancelado');
                        $('#table-domicilios').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_domicilio&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
                    }
                    else
                    {
                        show_stack_bar_top('danger','Error','Ha ocurrido un error al cancelar el domicilio'+ $data);
                    }

                    }
                })

                    },
                cancel: function() {

                }
              });   
            }
            ,
             'click .btn-editar': function (e, value, row, index) {
         $('#edit_id_dom').val(row.id);
         $('#modalDomicilio').modal('hide');
         $('#editar-domicilio').modal('show');
         $strD = "id=" + row.id;
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "html",
              url: "ajax.php?c=cuentas&f=buscar_domicilio",
              success: function (data) {
            $('#id_dom').val(row.id);

            var json_obj = $.parseJSON(data);//parse JSON
            
            for (var i in json_obj) 
            {
              $('#edit_cp').val(json_obj[i].cp);
              $('#edit_mpo_cp').val(json_obj[i].mun);
              $('#edit_edo_cp').val(json_obj[i].edo);
              $('#edit_calle').val(json_obj[i].calle);
              $('#edit_ext').val(json_obj[i].num_ext);
              $('#edit_int').val(json_obj[i].num_int);
              $('#edit_status_dom').val(json_obj[i].status);
              $('#edit_info_extra').val(json_obj[i].info_extra);
              $('#edit_inicio_dom').val(json_obj[i].inicio);
              $('#edit_fin_dom').val(json_obj[i].fin);
              $str = "id=" +$('#edit_cp').val();
              $.ajax({
              data: $str,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=busca_colonias",
              success:function ($data){
                 $("#edit_cboCol").html($data);
                 $('#edit_cboCol').selectpicker('refresh');
                 $('#edit_cboCol').val(json_obj[i].Idcol);
                 $('#edit_cboCol').selectpicker('render')
              }
              })
              
            }
              }
          });
             }
        };
//radio button estado
function mostrar(id) {
   if (id == 1) {
        $("#extra").hide();
    }
    if (id == 2) {
        $("#extra").show();
    }

    if (id == 3) {
        $("#extra").show();
    }
}

//funcion del boton aceptar del modal
function aceptar()
{
    $('#ok').hide();
    $('#button').hide();
    $('#loading').show();
    $('#esperar').modal('hide');
}
 //agregar otro firmante
        var self = this;
        index= 1;
        self.firmantes = [];
        self.firmanteSelected = null;

        self.guardaFirmante = function () {
            if($('#firmante_tipo').val() == 1)
            {
                if($('#plaza_firm').val()== "" || $('#soc_firm').val()== 00 || $('#soc_firm').val()== null || $('#firmante').val()== "" )
                {
                    show_stack_bar_top('error','Datos incompletos en firmante','Por favor complete todos los campos para poder agregar un firmante')

                }
                else
                {
                 var firmante = {
                        emp: $('#firmante').val(),
                        pza: $('#plaza_firm').val(),
                        soc: $('#soc_firm ').val(),
                        tipo: $('#firmante_tipo ').val(),
                    }
                    self.firmantes.push(new Firmante(firmante))
                    index=index+1;

                    //mostramos el cheque en la tabla
                     $('#firmante-table').bootstrapTable('insertRow', {
                        index: + index,
                        row: {
                            id_fir: document.getElementById("firmante").value,
                            tipo: 'Interno',
                            plaza: $('#plaza_firm option:selected').html(),
                            soc: $('#soc_firm option:selected').html(),
                            nombre: $('#firmante option:selected').html(),
                        }
                    });
                }
            }
            else
            {
                if(document.getElementById("firm_ext").value == "" || document.getElementById("firm_ext").value == "-- Seleccione persona--")
                {
                    show_stack_bar_top('warning','Datos incompletos','Seleccione un firmante')

                }
                else{
                var firmante = {
                        emp: $('#firm_ext').val(),
                        pza: $('#cboPlaza').val(),
                        soc: $('#cboSociedad ').val(),
                        tipo: $('#firmante_tipo ').val(),
                    }
                    self.firmantes.push(new Firmante(firmante))
                    index=index+1;

                    //mostramos el cheque en la tabla
                     $('#firmante-table').bootstrapTable('insertRow', {
                        index: + index,
                        row: {
                            id_fir: document.getElementById("firm_ext").value,
                            tipo: 'Externo',
                            plaza: $('#cboPlaza option:selected').html(),
                            soc: $('#cboSociedad option:selected').html(),
                            nombre: $('#firm_ext option:selected').html(),
                        }
                    });
                }

            }
            
        }
         function Firmante(data) {
            var self = this;
            self.Idfirmante = data.emp;
            self.PlazaFirm = data.pza;
            self.SocFirm = data.soc;
            self.Tipo = data.tipo;
        }
        //agregar otro firmante
        var self = this;
        i= 1;
        self.preguntas = [];
        self.preguntaSelected = null;

        self.guardarPregunta = function () {
            var pregunta = {
                preg: $('#preg').val(),
                resp_preg: $('#resp_preg').val(),
            }
            self.preguntas.push(new Pregunta(pregunta))
            i=i+1;

            //mostramos el cheque en la tabla
             $('#preguntas-table').bootstrapTable('insertRow', {
                index: + i,
                row: {
                    preg: document.getElementById("preg").value,
                    resp_preg: document.getElementById("resp_preg").value,
                }
            });
             $('#preg').val("");
             $('#resp_preg').val("");
            show_stack_bar_top('success','¡Pregunta guardada!','La pregunta ha sido agregada exitosamente')
        }
         function Pregunta(data) {
            var self = this;
            self.Pregunta = data.preg;
            self.Respuesta = data.resp_preg;
        }
        function domicilios()
        {
              $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() ;
                 $("#cboDom").empty();
                $.ajax({
                    data: $strD,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=busca_domicilios",
                    success:function ($data){
                         $('#loader2').hide();
                       $("#cboDom").html($data);
                       $('#cboDom').selectpicker('refresh');
                
                    }
                })
        }
   
   
function combo_domicilio()
{
      $str = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
     $("#cboDom").empty();
    $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_dom",
        success:function ($data)
        {
            $('#nuevo_aut').show();
            $('#loader-modal').hide();
            $("#cboDom").html($data);
            $('#cboDom').selectpicker('refresh');
        }
    })  
}
function busca_sucursal()
{
      $str = "id=" + $('#bank').val();
     $("#sucursal").empty();
    $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_suc_banco",
        success:function ($data)
        {
            $("#sucursal").html($data);
            $('#sucursal').selectpicker('refresh');
        }
    })  
}
//busca la sociedad del area de usuarioss
function busqueda_soc_user(){ 
       $('#loader_user').show();
        $strD = "plaza=" + $('#plaza_user').val();
         $("#soc_user").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader_user').hide();
               $("#soc_user").html($databack);
               $('#soc_user').selectpicker('refresh');
        
            }
        })
    }; 
//busca la sociedad del area de firmantes
function busqueda_soc_firm(){ 
       $('#loader_user').show();
        $strD = "plaza=" + $('#plaza_firm').val();
         $("#soc_firm").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader_firm').hide();
               $("#soc_firm").html($databack);
               $('#soc_firm').selectpicker('refresh');
        
            }
        })
    }; 
function busqueda_soc_resp(){ 
       $('#loader_resp').show();
        $strD = "plaza=" + $('#plazaResp').val();
         $("#soc_resp").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader_resp').hide();
               $("#soc_resp").html($databack);
               $('#soc_resp').selectpicker('refresh');
        
            }
        })
    };
 function nuevo_externo()
    {
    
     if($('#n_externo').val() != "")
     {
        $('#load-externo').show();
       $strD =  "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() + "&nombre=" + $('#n_externo').val() +"&rfc=" + $('#rfc_ext').val() +"&obs=" + $('#obs_ext').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=nuevo_externo",
            success:function ($databack){
               $str = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
                $("#usuario_ext").empty();
                $.ajax({
                    data: $str,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=cuentas&f=busca_externos",
                    success:function ($data){
                       $("#usuario_ext").html($data);
                       $('#usuario_ext').selectpicker('refresh');
                
                    }
                })
                $('#load-externo').hide();
                show_stack_bar_top('success','Guardado','Persona externa agregada correctamente');
               $('#table-externos').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=personal_externo&plaza=' + $('#cboPlaza').val() + '&soc=' + $('#cboSociedad').val()});
            }
        })  
       }
       else
       {
            show_stack_bar_top('warning','Ingrese el nombre','El nombre de la persona es requerido');

       }
    }
    function show_dom() {
         if($('#preg_dom').val() == 1)
         {
            $('#muestraDom').show();
         }
         else
         {
            $('#muestraDom').hide();
         }
    }
     function tipoFirm()
{
  if($('#cboPlaza').val() == "" || $('#cboSociedad').val() == "")
  {
    show_stack_bar_top('warning','Faltan campos','Seleccione la plaza y la sociedad');

  }
  else
  {
    if($('#firmante_tipo').val() == 1)
    {
        $('#firmante-ext').hide();
        $('#firmante-int').show();
    }
    else if($('#firmante_tipo').val() == 2)
    {
      $('#firmante-int').hide();
      $('#firmante-ext').show();
        $str = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
        $("#usuario_ext").empty();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_externos",
            success:function ($data){
               $("#firm_ext").html($data);
               $('#firm_ext').selectpicker('refresh');
        
            }
        })
    }
    else
    {
        $('#firmante-ext').hide();
        $('#firmante-int').hide();
    }
  }
};
function modal_sucursal()
{
    if($('#bank').val() == "")
    {
        show_stack_bar_top('warning','Seleccione el banco','Por favor seleccione un banco');
    }
    else{
        $('#modal_suc').modal('show');
        $('#table-sucursal').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_sucursales&id=' + $('#bank').val()});
    }

}
//guarda las sucursales
function guarda_suc()
{
    if($('#num_suc').val() == "" || $('#nom_suc').val() == "")
    {
        show_stack_bar_top('warning','Datos incompletos','El numero y el nombre de la sucursal son requeridos'); 
    }
    else{
    $('#loader_suc').show();
    $('#btn-suc').prop( "disabled", true );
     $strD = "num=" + $('#num_suc').val() + "&nom=" + $('#nombre_suc').val()+ "&id=" + $('#bank').val() ;
                $.ajax({
                    data: $strD,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=cuentas&f=guarda_sucursal",
                    success:function ($data){
                             $('#loader_suc').hide();
                             $('#num_suc').val("");
                             $('#nombre_suc').val("");
                             $('#btn-suc').prop( "disabled", false );
                             show_stack_bar_top('success','¡Guardado!','La sucursal ha sido guardada correctamente.'); 
                              $('#table-sucursal').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_sucursales&id=' + $('#bank').val()});
                
                    }
                })
    }
}

//formateamos las acciones de la tabla sucursales
   function FormatterAccionesSuc(values, row) {
        return [
               '<label class="btn btn-danger btn-xs btn-borrar pull-right"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    //acciones de firmantes
      window.tablaSucEvents = {
            'click .btn-borrar': function (e, value, row, index) {
                   $.confirm({
                text: "¿Esta seguro que desea eliminar esta sucursal? " + row.num_suc +" - "+ row.nombre ,
                confirmButton: "Si, Eliminar",
                cancelButton: "No",
                confirm: function() {
                $strD = "banco=" + row.id;
                $.ajax({
                    data: $strD,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=cuentas&f=borra_sucursal",
                    success:function ($data){
                       if($data.trim() == 1)
                       {
                             show_stack_bar_top('info','Eliminada!','La sucursal ha sido eliminada correctamente.'); 
                              $('#table-sucursal').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=consulta_sucursales&id=' + $('#bank').val()});
                       }
                       else
                       {
                        show_stack_bar_top('error','¡Error!','Lo sentimos ha ocurrido un error al borrar la sucursal, intentelo de nuevo'); 
                       }
                
                    }
                })
               },
                cancel: function() {

                }
              });   
            }
        };
//actualizar los datos del domicilio
 function update_dom()
    {

       $('#loader-dom-edit').show();
       $strD = "id=" + $('#edit_id_dom').val() + "&ext=" + $('#edit_ext').val() + "&int=" + $('#edit_int').val() +"&status_dom=" + $('#edit_status_dom').val() +"&info_extra=" + $('#edit_info_extra').val() + "&inicio_dom=" + $('#edit_inicio_dom').val() + "&fin_dom=" + $('#edit_fin_dom').val()+ "&cp=" + $('#edit_cboCol').val() + "&calle=" + $('#edit_calle').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=update_datos_domicilio",
            success:function ($databack)
            {
                if($databack==1)
                {
                    $('#loader-dom-edit').hide();
                    show_stack_bar_top('success','¡Domiclio actualizado!','Los datos del domicilio han sido actualizados correctamente');
                     $('#domicilio-table').bootstrapTable('refresh',
                      {silent: true});
                      $('#editar-domicilio').modal('hide');
                      $('#modalDomicilio').modal('show');

                }
                 else
                {
                    $('#loader-dom-edit').hide();
                    show_stack_bar_top('error','Lo sentimos ha ocurrido un error al actualizar el domicilio, por favor intentelo de nuevo, error:'+ $databack);
                }  
            }
        })  

    }
