
$(document).ready(function() {
    var id= $('#id_cta').val();
$('#fecha_bloq').mask('00/00/0000');
$('#asg_resp').mask('00/00/0000');
$('#fecha_cheq').mask('00/00/0000');
$('#cheq_fecha').mask('00/00/0000');
$('#f_token').mask('00/00/0000');
$('#f_vence').mask('00/00/0000');
 $('#asg_resp')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
  $('#periodo_del')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })

$('#periodo_al')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
$('#cheq_fecha')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
$('#fecha_cheq')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
$('#f_token')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
 $('#form-edo-cta').bootstrapValidator({
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
             folio: {
                group: '.group',
                validators: {
                    numeric: {
                        message: 'El folio debe ser númerico'
                    }

                }
            },
             fecha_bloq: {
                validators: {
                     date: {
                        format: 'DD/MM/YYYY',
                        message: 'Ingrese una fecha valida'
                    }
                }
            },
            Edo: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione el estado'
                    }
                }
            },
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors_edo_cta').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors_edo_cta');
            }
            $('#errors_edo_cta').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors_edo_cta').find('li[data-bv-for="' + data.field + '"]').remove();
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
             var edo=$('#nom_edo').val();
     var nvo= $('#Edo option:selected').html();
     if(edo == nvo)
     {
        show_stack_bar_top('error','¡Error!','No se puede actualizar el estado debido a que el nuevo estado es el mismo que el anterior');

     }
     else
     {

         $('#load').show();
         $('#datos').hide();
         $('#buttons').hide();
         $strD = "id=" + $('#id_cta').val()  +"&folio=" + $('#folio').val() +"&edo=" + $('#Edo').val() + "&fecha=" + $('#fecha_bloq').val() + "&obs=" + $('#obs_edo').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=actualiza_edo_cta",
                  success: function (data) {
                    if(data.trim()=="OK") {
                        $('#load').hide();
                        $('#datos').show();
                        $('#ok').hide();
                        $('#buttons').hide();
                        $('#modalEdo').modal('hide');
                        show_stack_bar_top('success','¡Modificación exitosa!','El estado ha sido modificado exitosamente');

                        modal_email();
                    }else{
                        show_stack_bar_top('error','¡Error al guardar!','Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');

                    }
                  }
              });
    }
        
});
 $('#form-cheq').bootstrapValidator({
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
             folio_cheq: {
                group: '.group',
                validators: {
                      notEmpty: {
                        message: 'Ingrese el folio de la chequera'
                    },
                    numeric: {
                        message: 'El folio debe ser númerico'
                    }

                }
            },
             fecha_cheq: {
                validators: {
                     date: {
                        format: 'DD/MM/YYYY',
                        message: 'Ingrese una fecha valida'
                    }
                }
            },
            cboResp: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione responsable'
                    },
                }
            },
             no_cheques: {
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
             cheque_inicial: {
                group: '.group',
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
             cheque_final: {
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors_cheq').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors_cheq');
            }
            $('#errors_cheq').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors_cheq').find('li[data-bv-for="' + data.field + '"]').remove();
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
            $('#errores_chequera').hide('fast');

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            $('#datos_cheq').hide();
            $('#load_cheq').show();
             $('#buttons_cheq').hide();
             $strD = "cta=" + $('#id_cta').val() + "&folio=" + $('#folio_cheq').val()  +"&fecha=" + $('#fecha_cheq').val() +"&resp=" + $('#cboResp').val() + "&no=" + $('#no_cheques').val() + "&ini=" + $('#cheque_inicial').val() + "&fin=" + $('#cheque_final').val() + "&obs=" + document.getElementById("obs_cheque").value;
                  $.ajax({
                      data: $strD,
                      type: "POST",
                      dataType: "text",
                      url: "ajax.php?c=cuentas&f=act_chequera",
                      success: function (data) {
                        if(data.trim()==1) {
                            $('#load_cheq').hide();
                            $('#btnok_cheq').show();
                            $('#ok_cheq').show();
                            $('#form-cheq').data('bootstrapValidator').resetForm(true);
                            $('#cboResp').selectpicker('deselectAll');
                        }else{ 
                            show_stack_bar_top('error','¡Error!','Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');

                        }
                      }
                  });        
});
     //VALIDADOR DE FORMULARIO AGREGAR TOKEN
   $('#form-token').bootstrapValidator({
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
             cod_token: {
                validators: {
                      notEmpty: {
                        message: 'Ingrese el codigo del token'
                    }

                }
            },
            f_token: {
                validators: {
                     date: {
                        format: 'DD/MM/YYYY',
                        message: 'Ingrese una fecha valida'
                    }

                }
            },
             resp_token: {
                validators: {
                     notEmpty: {
                        message: 'Seleccione responsable del token'
                    }

                }
            },
             f_vence: {
                validators: {
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'Ingrese una fecha valida'
                    }

                }
            },
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors_token').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors_token');
            }
            $('#errors_token').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors_token').find('li[data-bv-for="' + data.field + '"]').remove();
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
            $('#errores_token').hide('fast');

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
          $('#datos_token').hide();
        $('#load_token').show();
         $('#buttons_token').hide();
         $strD = "cta=" + $('#id_cta').val() + "&cod_token=" + $('#cod_token').val()  +"&f_token=" + $('#f_token').val() +"&resp_token=" + $('#resp_token').val() + "&vence=" + $('#vence').val() + "&fecha_vence=" + $('#fecha_vence').val() + "&obs_token=" + document.getElementById("obs_token").value + "&status_token=" + $('#status_token').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=guarda_token",
              success: function (data) {
                if(data.trim()==1) 
                {
                    $('#load_token').hide();
                    $('#datos_token').show();
                    $('#buttons_token').show();
                    show_stack_bar_top('success','Token agregado!','El token ha sido agregado correctamente');
                     $('#form-token').data('bootstrapValidator').resetForm(true);
                     $('#resp_token').selectpicker('deselectAll');
                     $('#modalToken').modal('hide');
                    $('#token-table').bootstrapTable('refresh', {silent: true });
                }else{ 
                    show_stack_bar_top('error','¡Error!','Lo sentimos, ha ocurrido un error al guardar el token, recarge la pagina e intentelo de nuevo');

                }
            }
              });
        });
//VALIDADOR DE EL FORMULARIO EDITAR LA CHEQUERA
$('#form-edita-cheq').bootstrapValidator({
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
             cheq_folio: {
                group: '.group',
                validators: {
                      notEmpty: {
                        message: 'Ingrese el folio de la chequera'
                    },
                    numeric: {
                        message: 'El folio debe ser númerico'
                    }

                }
            },
             cheq_fecha: {
                validators: {
                     date: {
                        format: 'DD/MM/YYYY',
                        message: 'Ingrese una fecha valida'
                    }
                }
            },
            cheq_resp: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione responsable'
                    },
                }
            },
             cheq_num: {
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
             cheq_ini: {
                group: '.group',
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
             cheq_fin: {
                validators: {
                    numeric: {
                        message: 'Este campo debe ser númerico'
                    }
                }
            },
            }
        })
        .on('error.field.bv', function(e, data) {
            var messages = data.bv.getMessages(data.field);
            $('#errors_cheq').find('li[data-bv-for="' + data.field + '"]').remove();
            for (var i in messages) {
                $('<li/>').attr('data-bv-for', data.field).html(messages[i]).appendTo('#errors_edita_cheq');
            }
            $('#errors_edita_cheq').parents('.form-group').removeClass('hide');
        })
        .on('success.field.bv', function(e, data) {
            $('#errors_edita_cheq').find('li[data-bv-for="' + data.field + '"]').remove();
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
            $('#errores_edita_cheque').hide('fast');

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
           $('#load_edit_cheq').show();
        $strD="id=" + $('#cheq_id').val() + "&cheq_fecha=" + $('#cheq_fecha').val() + "&cheq_num=" + $('#cheq_num').val() + "&cheq_ini=" + $('#cheq_ini').val() + "&cheq_fin=" + $('#cheq_fin').val() + "&cheq_obs=" + $('#cheq_obs').val() + "&cheq_resp=" + $('#cheq_resp').val();
        $.ajax({
        data: $strD,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=update_datos_chequera",
        success:function ($data){
            if($data==1)
            {
                  $('#load_edit_cheq').hide();
                $('#modalEdita-chequera').modal('hide');
                  show_stack_bar_top('success','¡Datos actualizados!','La chequera ha sido actualizada correctamente');

                  $('#chequeras-table').bootstrapTable('refresh', {silent: true });
            }
            else
            {
                 $('#load_edit_cheq').hide();
                $('#modalEdita-chequera').modal('hide');
                show_stack_bar_top('error','¡Error!','Ha ocurrido un error los datos no han podido ser actualizados');

            }
        }
    });
   
   
});
$('#chequeras-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=chequeras&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'folio',
            title: 'Folio',
            sortable: true
        },
        {
            field: 'responsable',
            title: 'Responsable',
            sortable: true
        },
        {
            field: 'fecha',
            title: 'Fecha',
            sortable: true
        },
        {
            field: 'num_cheques',
            title: 'No.cheques',
            sortable: true
        },
         {
            field: 'cheq',
            title: 'Cheque inicio/fin',
            sortable: true
        },
         {
            field: 'obs',
            title: 'Observaciones',
            sortable: true
        },
         {
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
         {
            field: 'act',
            title: 'Actualización',
            sortable: true
        },
        {
        field: 'Acciones',
        title: 'Acciones',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesCheq,
        events: tablaChequeraEvents
        }
        ]
    });
    $('#token-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=consulta_token&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'cod',
            title: 'Codigo/no.serie',
            sortable: true
        },
        {
            field: 'f_asig',
            title: 'Fecha asig.',
            sortable: true
        },
        {
            field: 'resp',
            title: 'Responsable',
            sortable: true
        },
        {
            field: 'vence',
            title: 'Vence',
            sortable: true
        },
        {
            field: 'f_vence',
            title: 'Fecha vence',
            sortable: true
        },
        {
            field: 'obs',
            title: 'Observaciones',
            sortable: true
        },
        {
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
         {
        field: 'Acciones',
        title: 'Acciones',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesToken,
        events: tablaTokenEvents
        }
        ]
    });
     $('#preguntas-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=consulta_preguntas&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: '#',
            sortable: true
        },
        {
            field: 'pregunta',
            title: 'Pregunta',
            sortable: true
        },
        {
            field: 'respuesta',
            title: 'Respuesta',
            sortable: true
        },
         {
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
        {
            field: 'act',
            title: 'Actualización',
            sortable: true
        },
        {
        field: 'Acciones',
        title: 'Cambiar estado',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesPreg,
        events: tablaPreguntaEvents
        }
        ]
    });
     $('#firmantes-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=consulta_firmantes&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'empleado',
            title: 'Firmante',
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
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
        {
        field: 'Acciones',
        title: 'Cambiar estado',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesFirm,
        events: tablaFirmanteEvents
        }
        ]
    });
     $('#historial-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=consulta_status&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
        {
            field: 'folio',
            title: 'Folio',
            sortable: true
        },
         {
            field: 'fecha',
            title: 'Fecha',
            sortable: true
        },
        {
            field: 'obs',
            title: 'Observaciones',
            sortable: true
        },
        {
            field: 'creado',
            title: 'Fecha',
            sortable: true
        }
        ]
    });
 $('#historial-domicilios').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=historial_domicilios&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'domicilio',
            title: 'Domicilio',
            sortable: true
        },
        {
            field: 'col',
            title: 'Colonia',
            sortable: true
        },
         {
            field: 'mun',
            title: 'Municipio',
            sortable: true
        },
        {
            field: 'estado',
            title: 'Estado',
            sortable: true
        },
        {
            field: 'ciudad',
            title: 'Ciudad',
            sortable: true
        },
        {
            field: 'cp',
            title: 'C.P',
            sortable: true
        },
        {
            field: 'inicio',
            title: 'Inicio',
            sortable: true
        },
         {
            field: 'fin',
            title: 'Fin',
            sortable: true
        },
         {
            field: 'act',
            title: 'Creación',
            sortable: true
       }
        ]
    });
    $('#table-responsable').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=cuentas&f=consulta_responsables&id='+ id,
        cache: false,
        height: 500,
        striped: true,
        search: true,
        showColumns: true,
        showRefresh: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        showExport:true,
        resizable:false,
         pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        exportTypes:[ 'xml','txt','excel','pdf','word'],
        exportDataType: $(this).val(),
        columns: [{
            field: 'id',
            title: 'Id',
            sortable: true
        },
        {
            field: 'resp',
            title: 'Responsable',
            sortable: true
        },
        {
            field: 'tipo',
            title: 'Tipo',
            sortable: true
        },
         {
            field: 'fecha',
            title: 'Fecha',
            sortable: true
        },
        {
            field: 'crea',
            title: 'Creado',
            sortable: true
        }
        ]
    });
});
function editarDatos()
{
    $('#Datos').hide();
    $('#Editar').hide();

}
function cambiarDom()
{
   $('#modalDom').modal('show'); 
   $strD = "plaza=" + $('#plaza').val() + "&soc=" + $('#soc').val() ;
     $("#cboDom").empty();
    $.ajax({
        data: $strD,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=cuentas&f=busca_domicilios",
        success:function ($data){
           $("#cboDom").html($data);
           $('#cboDom').selectpicker('refresh');
    
        }
    })
}
function agrega_cheq()
{
   $('#modalCheq').modal('show'); 
}

function update_dom()
{
 if($('#cboDom').val() == "" || $('#periodo_del').val() == "" || $('#periodo_al').val() == "" )
     {
            show_stack_bar_top('warning','¡Faltan datos!','Por favor complete todos los campos');

     }
     else
     {
        $('#load_dom').show(); 
        $('#buttons_dom').hide();
           $strD = "&cta=" + $('#id_cta').val() + "&dom=" + $('#cboDom').val() + "&del=" + $('#periodo_del').val()+ "&al=" + $('#periodo_al').val();
            $.ajax({
                data: $strD,
                type: "POST",
                dataType: "text",
                url: "ajax.php?c=cuentas&f=update_domicilio",
                success:function ($data){
                 if($data.trim()=="OK")
                 {
                    $('#load_dom').hide(); 
                    $('#ok_dom').show();
                    $('#btnok_dom').show();
                 }
                }
            })
    }
}
function acepta_dom()
{
    $('#datos').show();
    $('#ok').hide();
    $('#btnok_dom').hide();
    $('#buttons_dom').show();
    $('#modalDom').modal('hide');
    location.reload(); 
}
    function cambiaEstado()
{
     $('#modalEdo').modal('show');
     var edo = $('#id_edo').val();
     var nom_edo = $('#status_nom').val()
     $('#nom_edo').val(nom_edo);
    // $('#Edo > option[value="'+edo+'"]').attr('selected', 'selected');
      $('#fecha_bloq').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        });
       
}
function acepta()
{
    $('#datos').show();
    $('#ok').hide();
    $('#buttons').hide();
    $('#modalEdo').modal('hide');
    location.reload(); 
}
function acepta_cheq()
{
    $('#datos_cheq').show();
    $('#ok_cheq').hide();
    $('#buttons_cheq').hide();
    $('#modalCheq').modal('hide');
    $('#chequeras-table').bootstrapTable('refresh', {silent: true });
    
}
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
               //alert($databack);
               //$('#myModal').modal('hide'); 
               $('#load_tipo').hide();
               $("#resp_cta").html($databack);
               $('#resp_cta').selectpicker('refresh');
        
            }
        })


    }
    function actualiza_responsable()
{
        if($('#tipo_resp').val()== "" || $('#resp_cta').val()== "")
        {
            show_stack_bar_top('warning','¡Datos incompletos!','El tipo de responsable o el responsable estan vacios y son obligatorios');

        }
        else
        {
            $('#datos_resp').hide();
            $('#load_resp').show();
             $('#buttons_resp').hide();
             $strD = "cta=" + $('#id_cta').val() + "&tipo_resp=" + $('#tipo_resp').val()  +"&resp_cta=" + $('#resp_cta').val() +"&resp=" + $('#cboResp').val() + "&asg_resp=" + $('#asg_resp').val() + '&plaza=' + $('#plazaResp').val() + '&soc=' + $('#soc_resp').val();
                  $.ajax({
                      data: $strD,
                      type: "POST",
                      dataType: "text",
                      url: "ajax.php?c=cuentas&f=act_responsable",
                      success: function (data) {
                        if(data.trim()==1) {
                            $('#load_resp').hide();
                            $('#btnok_resp').show();
                            $('#ok_resp').show();
                        }else{ 
                            show_stack_bar_top('error','¡Error!','Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');
                        }
                      }
                  });
        }
}
function acepta_resp()
{
    $('#datos_resp').show();
    $('#ok_resp').hide();
    $('#buttons_resp').hide();
    $('#modalResp').modal('hide');
    location.reload(); 
}
  function modalFirm()
{
     $('#modalFirm').modal('show');
}
  function guarda_firm()
{
     if($('#plazaFirm').val() == "" || $('#sociedad_firm').val() == "" || $('#cboFirm').val() == "" )
     {
            show_stack_bar_top('warning','¡Faltan datos!','Por favor complete todos los campos');

     }
     else
     {
        $('#datos_resp').hide();
        $('#load_resp').show();
         $('#buttons_resp').hide();
         $strD = "cta=" + $('#id_cta').val() + "&firm=" + $('#cboFirm').val() + "&plaza=" + $('#plazaFirm').val() + "&soc=" + $('#sociedad_firm').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=guarda_firmante",
                  success: function (data) {
                    if(data.trim()==1) {
                        $('#cboFirm').find('[value='+$('#cboFirm').val()+']').remove();
                        $('#cboFirm').selectpicker('refresh');
                        $('#plazaFirm').selectpicker('deselectAll');
                        $('#sociedad_firm').selectpicker('deselectAll');
                        $('#cboFirm').selectpicker('deselectAll');
                        $('#modalFirm').modal('hide');
                        show_stack_bar_top('success','¡Firmante agregado!','El firmante ha sido guardado correctamente');

                        $('#firmantes-table').bootstrapTable('refresh', {silent: true });
                    }else{ 
                        show_stack_bar_top('error','¡Error!','Ha ocurrido un error, el firmante no ha podido ser guardado');
                    }
                  }
              });
    }
}
 function guarda_usuario()
{
     if($('#plazaUs').val() == "" || $('#sociedadUs').val() == "" || $('#cboUs').val() == "" )
     {
            show_stack_bar_top('warning','¡Faltan datos!','Por favor complete todos los campos');

     }
     else
     {
        $('#datos_us').hide();
        $('#load_us').show();
         $('#buttons_us').hide();
         $strD = "cta=" + $('#id_cta').val() + "&usuario=" + $('#cboUs').val() + "&plaza=" + $('#plazaUs').val() + "&soc=" + $('#sociedadUs').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=guarda_firmante",
                  success: function (data) {
                    if(data.trim()==1) {
                        $('#load_us').hide();
                        $('#buttons_us').show();
                        $('#datos_us').show();
                        $('#modalUsuario').modal('hide');
                        location.reload(); 
                        show_stack_bar_top('success','¡Usuario agregado!','El usuario ha sido guardado correctamente');
                    }else{ 
                        show_stack_bar_top('error','¡Error!','Ha ocurrido un error, el usuario no ha podido ser guardado');
                    }
                  }
              });
    }
}
function modalPreg()
{
     $('#modalPreg').modal('show');
}
 function guarda_preg()
{
    if($('#preg').val() == "" || $('#resp_preg').val() == "" )
    {
        show_stack_bar_top('warning','¡Datos incompletos!','Por favor complete todos los campos');

    }
    else
    {
        $('#datos_preg').hide();
        $('#load_preg').show();
         $strD = "cta=" + $('#id_cta').val() + "&preg=" + $('#preg').val()+ "&resp_preg=" + $('#resp_preg').val() ;
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=guarda_pregunta",
                  success: function (data) {
                    if(data.trim()==1) {
                        $('#modalPreg').modal('hide');
                        show_stack_bar_top('success','¡Pregunta agregada!','La pregunta ha sido guardada correctamente');

                        $('#preguntas-table').bootstrapTable('refresh', {silent: true });
                    }else{ 
                        show_stack_bar_top('error','¡Error!','Ha ocurrido un error,la pregunta no ha podido guardarse');
                    }
                  }
              });
    }
}
//acciones de tabla chequera
 function FormatterAccionesCheq(values, row) {
        return [
               '<a class="btn btn-warning btn-xs btn-edita-cheq" style="margin-right:10%;"><i class="fa fa-pencil"></i></a>',
               '<a class="btn btn-danger btn-xs btn-edo-cheq"><i class="fa fa-exclamation-circle"></i></a>',
        ].join('');
    }
    window.tablaChequeraEvents = {
        'click .btn-edita-cheq': function (e, value, row, index) {
            self.EditarChequera(index, row.id);
        },
         'click .btn-edo-cheq': function (e, value, row, index) {
            self.CambiaEdoCheq(index, row.id);
        }
    };
     self.EditarChequera = function(index, row)
    {
      $str = "id=" + row;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_datos_chequera",
            success:function ($data){
                $('#modalEdita-chequera').modal('show');
                var json_obj = $.parseJSON($data);//parse JSON
                
                for (var i in json_obj) 
                {
                    $('#cheq_id').val(json_obj[i].id);
                    $('#cheq_folio').val(json_obj[i].folio);
                    $('#cheq_fecha').val(json_obj[i].fecha);
                    $('#cheq_num').val(json_obj[i].num_cheq);
                    $('#cheq_ini').val(json_obj[i].cheque_ini);
                    $('#cheq_fin').val(json_obj[i].cheque_fin);
                    $('#cheq_obs').val(json_obj[i].obs);
                    $("#cheq_resp").selectpicker('val',json_obj[i].id_resp);
        
                }

        
            }
        })
    }
  
  self.CambiaEdoCheq = function(index, row)
    {
      $str = "id=" + row;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_edo_chequera",
            success:function ($data){
                $('#modalEdo-Chequera').modal('show');
                var json_obj = $.parseJSON($data);//parse JSON
                 $('#id_chequera').val(row);
                for (var i in json_obj) 
                {
                    $('#actual_cheq').val(json_obj[i].estado);
        
                }

        
            }
        })
    }
    function updateEdoChequera()
{
     var edo=$('#actual_cheq').val();
     var nvo= $('#nuevo_edo option:selected').html();
     if(edo == nvo)
     {
        show_stack_bar_top('error','¡Error!','El nuevo estado no puede ser igual al anterior');

     }
     else
     {
        if($('#nuevo_edo').val() == "")
        {
            show_stack_bar_top('warning','¡Atencion!','Seleccione el nuevo estado de la chequera');

        }
        else
        {
             $('#loading_edo').show();
             $strD = "id=" + $('#id_chequera').val()  +"&edo=" + $('#nuevo_edo').val();
                  $.ajax({
                      data: $strD,   
                      type: "POST",
                      dataType: "text",
                      url: "ajax.php?c=cuentas&f=actualiza_edo_chequera",
                      success: function (data) {
                        if(data.trim()==1) {
                          $('#loading_edo').hide();
                          $('#modalEdo-Chequera').modal('hide');
                          show_stack_bar_top('success','¡Estado actualizado!','El estado ha sido actualizado correctamente');

                         $('#chequeras-table').bootstrapTable('refresh', {silent: true });
                        }else{
                          show_stack_bar_top('error','¡Error!','Ha ocurrido un error al actualizar el estado');
                        }
                      }
                  });
        }
    }
}
function detalles()
{
    $('#detalles-cuenta').toggle();
    $('#general').toggle();
}
//acciones de tabla firmante
 function FormatterAccionesFirm(values, row) {
        return [
               '<a class="btn btn-danger btn-xs btn-edo"><i class="fa fa-exclamation-circle"></i></a>',
        ].join('');
    }
    window.tablaFirmanteEvents = {
         'click .btn-edo': function (e, value, row, index) {
            self.CambiaEdoFirmante(row.id,row.estado);
        }
    };
 self.CambiaEdoFirmante = function(id, estado)
    {
        $str = "id=" + id;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_edo_firmante",
            success:function ($data){
                 $('#modalEdoFirm').modal('show');
                 $('#edo_firm').html(estado);
                 $('#firm_id').val(id);
                  $('#edo_firm_nombre').val($data);
        
            }
        })
            
    }
 function updateEdoFirmante()
{
     var edo=$('#edo_firm_nombre').val();
     var nvo= $('#edo_firm_nvo').val();
     if(edo == nvo)
     {
        show_stack_bar_top('error','¡Error!','El nuevo estado no puede ser igual al anterior');

     }
     else
     {
        if(nvo == "")
        {
            show_stack_bar_top('warning','¡Datos incompletos!','Por favor seleccione un nuevo estado');

        }
        else
        {
         $('#load_firm').show();
         $strD = "id=" + $('#firm_id').val()  +"&edo=" + $('#edo_firm_nvo').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=actualiza_edo_firmante",
                  success: function (data) {
                    if(data.trim()==1) {
                      $('#load_firm').hide();
                      $('#modalEdoFirm').modal('hide');
                      show_stack_bar_top('success','¡Estado actualizado!','Estado actualizado correctamente');
                     $('#firmantes-table').bootstrapTable('refresh', {silent: true });
                    }else{
                        show_stack_bar_top('error','¡Error!','ha ocurrido un error sus datos no han podido ser actualizados');

                    }
                  }
              });
            }
    }
}
//acciones de tabla preguntas
 function FormatterAccionesPreg(values, row) {
        return [
               '<a class="btn btn-danger btn-xs btn-edo"><i class="fa fa-exclamation-circle"></i></a>',
        ].join('');
    }
    window.tablaPreguntaEvents = {
         'click .btn-edo': function (e, value, row, index) {
            self.CambiaEdoPregunta(row.id,row.estado);
        }
    };
self.CambiaEdoPregunta = function(id, estado)
    {
        $str = "id=" + id;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_edo_pregunta",
            success:function ($data){
                 $('#modalEdoPreg').modal('show');
                 $('#edo_preg').html(estado);
                 $('#preg_id').val(id);
                  $('#edo_id_preg').val($data);
        
            }
        })
            
    }
 function updateEdoPregunta()
{
     var edo=$('#edo_id_preg').val();
     var nvo= $('#edo_preg_nvo').val();
     if(edo == nvo)
     {
        show_stack_bar_top('error','¡Error!','El nuevo estado no puede ser igual al anterior');

     }
     else
     {
         $('#load_firm').show();
         $strD = "id=" + $('#preg_id').val()  +"&edo=" + $('#edo_preg_nvo').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=cuentas&f=actualiza_edo_pregunta",
                  success: function (data) {
                    if(data.trim()==1) {
                      $('#load_preg').hide();
                      $('#modalEdoPreg').modal('hide');
                      show_stack_bar_top('success','¡Estado actualizado!','El estado ha actualizado correctamente');

                     $('#preguntas-table').bootstrapTable('refresh', {silent: true });
                    }else{
                        show_stack_bar_top('error','¡Error!','Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');

                    }
                  }
              });
    }
}
function modalToken()
{
     $('#modalToken').modal('show');
}

//acciones de tabla preguntas
 function FormatterAccionesToken(values, row) {
        return [
               '<a class="btn btn-danger btn-xs btn-edo"><i class="fa fa-exclamation-circle"></i></a>',
        ].join('');
    }
    window.tablaTokenEvents = {
         'click .btn-edo': function (e, value, row, index) {
            self.CambiaEdoToken(row.id,row.estado);
        }
    };
self.CambiaEdoToken = function(id, estado)
    {
        $str = "id=" + id;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_edo_token",
            success:function ($data){
                 $('#modalEdoToken').modal('show');
                 $('#edo_token').html(estado);
                 $('#token_id').val(id);
                  $('#edo_id_tok').val($data);
        
            }
        })
            
    }
 function updateEdoToken()
{
     var edo=$('#edo_id_tok').val();
     var nvo= $('#edo_tok_nvo').val();
     if(edo == nvo)
     {
        show_stack_bar_top('error','¡Error!','El nuevo estado no puede ser igual al anterior');

     }
     else
     {
         $('#load_firm').show();
         $strD = "id=" + $('#token_id').val()  +"&edo=" + $('#edo_tok_nvo').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",   
                  url: "ajax.php?c=cuentas&f=actualiza_edo_token",
                  success: function (data) {
                    if(data.trim()==1) {
                      $('#load_preg').hide();
                      $('#modalEdoToken').modal('hide');
                      show_stack_bar_top('error','¡Estado actualizado!','El estado ha sido actualizado correctamente');

                     $('#token-table').bootstrapTable('refresh', {silent: true });
                    }else{
                        show_stack_bar_top('error','¡Error!','Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');

                    }
                  }
              });
    }
}
//funcion de prueba para el envio de mails
function modal_email()
{
    $('#modalEmails').modal('show');
}
function envia_mail()
{
      // alert('getSelections: ' + JSON.stringify($('#emails-table').bootstrapTable('getSelections')));
      $('#buttons-mail').hide();
      $('#mail_loading').show();
        $datos = "&cta=" + $('#id_cta').val();
        $.ajax({
            data: {
                "cta" :  $('#id_cta').val(),
                "emails": JSON.stringify($('#emails-table').bootstrapTable('getSelections')),
                "texto": document.getElementById("correo_texto").value
            },
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=sendmail_cuenta",
            success:function (response){
             if(response.trim()==1)
             {
                $('#buttons-mail').show();
                $('#mail_loading').hide(); 
                $('#modalEmails').modal('hide');
                show_stack_bar_top('error','¡Mensaje enviado!','El mensaje ha sido enviado correctamente');
                location.reload(); 
             }
             else
             {
                show_stack_bar_top('error','¡Error al enviar!','Lo sentimos ha ocurrido un error al enviar el mensaje '+ response);

             }
            }
        })
}
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
function muestra_emails()
{
    $('#emails-table').bootstrapTable('refresh', {url: 'ajax.php?c=email&f=muestra_emails&plaza='+ $('#cboPlaza').val() + "&soc="+$('#cboSociedad').val()});
    $('#emails-table').bootstrapTable('checkAll');
}
function busqueda_soc_firm(){ 
       $('#loader_firm').show();
        $strD = "plaza=" + $('#plazaFirm').val();
         $("#soc_firm").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader_firm').hide();
               $("#sociedad_firm").html($databack);
               $('#sociedad_firm').selectpicker('refresh');
        
            }
        })
    }; 
function busqueda_soc_us(){ 
       $('#loader_firm').show();
        $strD = "plaza=" + $('#plazaUs').val();
         $("#sociedadUs").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader_firm').hide();
               $("#sociedadUs").html($databack);
               $('#sociedadUs').selectpicker('refresh');
        
             }
        })
    };  

