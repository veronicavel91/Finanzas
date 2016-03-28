
    (function ($) {
    $.fn.extend({
        tableAddCounter: function (options) {

            // set up default options 
            var defaults = {
                title: '#',
                start: 1,
                id: false,
                cssClass: false
            };

            // Overwrite default options with user provided
            var options = $.extend({}, defaults, options);

            return $(this).each(function () {
                // Make sure this is a table tag
                if ($(this).is('table')) {

                    // Add column title unless set to 'false'
                    if (!options.title) options.title = '';
                    $('th:first-child, thead td:first-child', this).each(function () {
                        var tagName = $(this).prop('tagName');
                        $(this).before('<' + tagName + ' rowspan="' + $('thead tr').length + '" class="' + options.cssClass + '" id="' + options.id + '">' + options.title + '</' + tagName + '>');
                    });

                    // Add counter starting counter from 'start'
                    $('tbody td:first-child', this).each(function (i) {
                        $(this).before('<td>' + (options.start + i) + '</td>');
                    });

                }
            });
        }
    });
})(jQuery);

$(document).ready(function () {
     $('#importe_mov').mask('000,000,000,000,000.00', {reverse: true});
      $('#periodo_del').mask('00/00/0000');
      $('#periodo_al').mask('00/00/0000');
      $('#f_mvto').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })

        $('#table-movimientos').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=conciliacion&f=movimientos&cuenta=' + document.getElementById("cboCuenta").value,
        cache: false,
        height: 800,
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
        columns: [
         {
            field: 'state',
            checkbox:true
        },
        {
            field: 'id',
            title: '#',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'fecha_movto',
            title: 'Fecha',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
         {
            field: 'folio',
            title: 'folio',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'tipo_movto',
            title: 'Tipo',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
         {
            field: 'concepto',
            title: 'Concepto',
            align: 'center',
            valign: 'middle',
            sortable: true,
            //formatter: depositoFormatter,
        },
        {
            field: 'referencia',
            title: 'Referencia',
            align: 'center',
            valign: 'middle',
            sortable: true,
            //formatter: depositoFormatter,
        },
        {
            field: 'obs',
            title: 'Observaciones',
            align: 'center',
            valign: 'middle',
            sortable: true,
            //formatter: depositoFormatter,
        },
         {
            field: 'cargo',
            title: 'Cargos',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
          {
            field: 'abono',
            title: 'Abono',
            align: 'center',
            valign: 'middle',
            sortable: true,
            //formatter: depositoFormatter,
        },
        {
            field: 'Acciones',
            title: 'Acciones',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            //formatter: FormatterAcciones,
            //events: operateEvents
        }
        ]
    });
    $.getScript("http://code.jquery.com/ui/1.9.2/jquery-ui.js").done(function (script, textStatus) { $('tbody').sortable();$(".alert-info").alert('close');$(".alert-success").show(); });
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
                            message: 'La sucursal es requerida'
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
            $('#errors')
                .html('')
                .parents('.form-group').addClass('hide');
        });
         $('#periodo_del').datepicker({
            format: "dd/mm/yyyy"
        });
         $('#periodo_al').datepicker({
            format: "dd/mm/yyyy"
        });
});
function movimientos()
{
    $cuenta=document.getElementById("cboCuenta").value;
    $inicio=document.getElementById("periodo_del").value;
    $fin=document.getElementById("periodo_al").value;
    if($cuenta == "" || $inicio== "" || $fin=="")
    {
        alert("Por favor complete todos los campos");
    }
    else
    {
     $('#table-movimientos').bootstrapTable('refresh', {url: 'ajax.php?c=conciliacion&f=movimientos&cuenta=' + document.getElementById("cboCuenta").value + '&inicio='+ $inicio + '&fin=' + $fin });
     importe_cargos();
     importe_abonos();
    }
}
  function importe_cargos()
     {
        $str = "cuenta=" + document.getElementById("cboCuenta").value + "&inicio="+document.getElementById("periodo_del").value + "&fin=" + document.getElementById("periodo_al").value;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=conciliacion&f=calcula_cargos",
            success:function ($data){
                $('#importe_cargo').val($data);  
                 calcula_saldo();
        
            }
        })

     }
  
   function importe_abonos()
     {
        $str = "cuenta=" + document.getElementById("cboCuenta").value + "&inicio="+document.getElementById("periodo_del").value + "&fin=" + document.getElementById("periodo_al").value;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=conciliacion&f=calcula_abonos",
            success:function ($data){
                $('#importe_abono').val($data);     
        
            }
        })

     }
     function calcula_saldo() {
           var total_abonos=parseFloat($('#importe_abono').val().replace(',', ''));
           var total_cargos=parseFloat($('#importe_cargo').val().replace(',', ''));

        
                saldo_final=(total_abonos-total_cargos);
                total=saldo_final;
                var saldo=(total).formatMoney(2,'.',',');
                $('#saldo').val(saldo);
         
        } 
    //borra uno o mas movimientos de la conciliacion
      function borrar_mov()
      {
         var r = confirm("¿Esta seguro que desea eliminar los registros seleccionados?");
            if (r == true) 
            {
                $.ajax({
                    data:{
                        elementos: JSON.stringify($('#table-movimientos').bootstrapTable('getSelections'))},
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=conciliacion&f=borrar_movimientos",
                    success:function ($data){
                       if($data=="OK")
                       {
                        importe_cargos();
                        importe_abonos();
                        calcula_saldo();
                        alert("Elementos eliminados correctamente");
                        $('#table-movimientos').bootstrapTable('refresh', {url: 'ajax.php?c=conciliacion&f=movimientos&cuenta=' + document.getElementById("cboCuenta").value + '&inicio='+ $inicio + '&fin=' + $fin });

                       }
                
                    }
                    })
            }
            else
            {

            }
      }
      function guarda_movimiento()
      {
         $str = "plaza=" + document.getElementById("cboPlaza").value + "&soc=" + document.getElementById("cboSociedad").value + "&cuenta=" + document.getElementById("cboCuenta").value + "&tipo_mov=" + document.getElementById("tipo_mov").value + "&importe_mov="+document.getElementById("importe_mov").value + "&folio_mov=" + document.getElementById("folio_mov").value + "&f_mvto=" + document.getElementById("f_mvto").value + "&ref_mov=" + document.getElementById("ref_mov").value + "&concepto_mvto=" + document.getElementById("concepto_mvto").value;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=conciliacion&f=guarda_nuevo_mov",
            success:function ($data){
                if($data==1)
                {
                  $('#table-movimientos').bootstrapTable('refresh', {url: 'ajax.php?c=conciliacion&f=movimientos&cuenta=' + document.getElementById("cboCuenta").value + '&inicio='+ $inicio + '&fin=' + $fin });
                  $('#tipo_mov').val('');
                  $('#importe_mov').val('');
                  $('#folio_mov').val('');
                  $('#f_mvto').val('');
                  $('#ref_mov').val('');
                  $('#concepto_mvto').val('');
                  $('#new').modal('hide');
                  alert("El movimiento ha sido agregado correctamente");
                    importe_cargos();
                    importe_abonos();
                    calcula_saldo();
                }
        
            }
        })
      }
       