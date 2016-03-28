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
    function busqueda_cliente(){ 
       $('#loader2').show();
        $strD = "soc=" + $('#cboSociedad').val();
         $("#cboCliente").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            async: false,
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=busca_clientes",
            success:function ($databack){
               $("#cboCliente").html($databack);
               $('#cboCliente').selectpicker('refresh');
                $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val() ;
                 $("#autorizado").empty();
                $.ajax({
                    data: $strD,
                    async:false,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=busca_autorizado",
                    success:function ($data){
                         $('#loader2').hide();
                       $("#autorizado").html($data);
                       $('#autorizado').selectpicker('refresh');
                
                    }
                })
        
            }
        })
    }; 
$(document).ready(function() {

    $('#myTab a').click(function (e) {
   e.preventDefault()
   $(this).tab('show')
})

    var self = this;
    $('#imp_cheque').mask('000,000,000,000,000.00', {reverse: true});
    $('#imp_fact').mask('000,000,000,000,000.00', {reverse: true});
    $('#importe_nota').mask('000,000,000,000,000.00', {reverse: true});
    $('#importe_desc').mask('000,000,000,000,000.00', {reverse: true});
    $('#importe_factura').mask('000,000,000,000,000.00', {reverse: true});
   // $('#socFactura').selectpicker();
    $('#fecha_factura').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#fecha_fact').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#fecha_desc').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    
    $('#fecha_finan').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
    })
    $('#periodo_del').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#periodo_al').datepicker({
        format: 'dd/mm/yyyy',
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
    $('#fecha_factura').mask('00/00/0000');
    $('#fecha_fact').mask('00/00/0000');
    $('#fecha_finan').mask('00/00/0000');
    $('#periodo_del').mask('00/00/0000');
    $('#periodo_al').mask('00/00/0000');
    $('#fecha_cheque').mask('00/00/0000');
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

    depositosData = [];
    descuentosBorrar = [];
    depositosBorrar = [];
    abonosBorrar = [];
    chequesBorrar = [];
    notasBorrar = [];
     //----knockout inicializacion-----
    var knockoutValidationSettings = {
    insertMessages: true,
    decorateElement: true,
    errorMessageClass: 'error',
    errorElementClass: 'error',
    errorClass: 'error',
    errorsAsTitle: true,
    parseInputAttributes: false,
    messagesOnModified: true,
    decorateElementOnModified: true,
    decorateInputElement: true
    };
    ko.validation.init(knockoutValidationSettings, true);
    FinanciamientoModel = new Financiamiento();
    ko.applyBindings(FinanciamientoModel);

    $(document).on('hide.bs.modal','#agregar_cheque', function () {
            FinanciamientoModel.facturaSeleccionada().depositosCliente().chequeSeleccionado().sociedadNombre($('#soc_cheque option:selected').html());
            FinanciamientoModel.facturaSeleccionada().depositosCliente().chequeSeleccionado().estadoNombre($('#edo_abono option:selected').html());
            $('#cheques-table').bootstrapTable('destroy');
            // show_stack_bar_top('success','Datos actualizados!','Los cambios que realize se guardaran hasta que de click en el <strong>boton GUARDAR</strong>.');
           renderTable(FinanciamientoModel.facturaSeleccionada().depositosCliente().toModelCheques());
       })
     $(document).on('hide.bs.modal','#agregar_abono', function () {
            $('#abonos-table').bootstrapTable('destroy');
           renderTableAbonos(FinanciamientoModel.toModelAbonos());
       })
     $(document).on('hide.bs.modal','#agregar_descuento', function () {
            FinanciamientoModel.facturaSeleccionada().descuentosPromotor().descuentoSeleccionado().promotorNombre($('#promotor option:selected').html());
            FinanciamientoModel.facturaSeleccionada().descuentosPromotor().descuentoSeleccionado().estadoNombre($('#edo_desc option:selected').html());
            $('#promotor-table').bootstrapTable('destroy');
            // show_stack_bar_top('success','Datos actualizados!','Los cambios que realize se guardaran hasta que de click en el <strong>boton GUARDAR</strong>.');
           renderTableDescuento(FinanciamientoModel.facturaSeleccionada().descuentosPromotor().toModelDescuentos());
       })
      $(document).on('hide.bs.modal','#agregar_nota', function () {
            FinanciamientoModel.facturaSeleccionada().notasCredito().notaSeleccionada().estadoNombre($('#estado_nota option:selected').html());
            FinanciamientoModel.facturaSeleccionada().notasCredito().notaSeleccionada().pagadoraNombre($('#pagadora option:selected').html());
           $('#notas-table').bootstrapTable('destroy');
            // show_stack_bar_top('success','Datos actualizados!','Los cambios que realize se guardaran hasta que de click en el <strong>boton GUARDAR</strong>.');
            renderTableNotas(FinanciamientoModel.facturaSeleccionada().notasCredito().toModelNotas());
       })

});
 function modal_autoriza()
    {

        if(document.getElementById("cboPlaza").value=="00" || document.getElementById("cboSociedad").value=="00")
        {
            show_stack_bar_top('warning','¡Atencion!','Seleccione la plaza y la sociedad');

        }
        else
        {
            var $table = $('#table-autoriza');
            $('#modalTable').modal('show');
            $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" +  $('#cboSociedad').val();
            $("#cboEmp").empty();
            $.ajax({
                data: $strD,
                type: "POST",
                dataType: "text",
                url: "ajax.php?c=financiamiento&f=aut_plaza_soc",
                success:function ($databack){
                   $("#cboEmp").html($databack);
                   $('#cboEmp').selectpicker('refresh');
               }
            })
            $table.bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=autorizados&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
        }
    }
        //suma el total de los chuques depositados
        function calcular_deposito(deposito) {
            total_depositos= (total_depositos+deposito);
            total=total_depositos;
            var to=(total).formatMoney(2,'.',',');
            $('#importe_dep').val(to);
            calcula_saldo();
          
        }
        //resta del deposito de los cheques cuando se elimina un cheque
         function restar_deposito(deposito) {
           total_depositos= (total_depositos-deposito);
           total=total_depositos;
           var to=(total).formatMoney(2,'.',',');
           calcula_saldo();
            $('#importe_dep').val(to); 
        }
    //acciones de cheques
   
//funcion del boton aceptar del modal
function aceptar()
{
    $('#ok').hide();
    $('#button').hide();
    $('#loading').show();
    $('#esperar').modal('hide');
}
//muestra el modal para agregar el cheque
function modalCheque()
{
    $('#agregar_cheque').modal('show');
}
//muestra el modal para agregar un descuento al promotor
function modalFactura()
{
    $('#agregar_factura').modal('show');
}

 //suma el total de las facturas 
function calcular_financiado(financiado) {
    total_financiado=parseFloat(total_financiado+financiado);
    total=total_financiado;
    var to=(total).formatMoney(2,'.',',');
    $('#importe_fin').val(to);
  
}
//resta una factura al total financiado
 function restar_financiado(financiado) {

   total_financiado= (total_financiado-financiado);
   total=total_financiado;
   var to=(total).formatMoney(2,'.',',');
   calcula_saldo();
    $('#importe_fin').val(to);
  
}

self.BorrarDeposito = function(index, promotor, importe)
{
    var r = confirm("¿Esta seguro de eliminar este pago del cliente por " + importe + " ?");
    if (r == true) 
    {
        FinanciamientoModel.facturaSeleccionada().depositosCliente().cheques.splice(index, 1); 
        $('#cheques-table').bootstrapTable('destroy');
        renderTable(FinanciamientoModel.facturaSeleccionada().depositosCliente().toModelCheques());     
        alert("La descuento ha sido eliminado");
    } else {
    }              
}
 //suma de los descuentos de los promotores
function calcular_promotor(importe) {
    total_descuentos= (total_descuentos+importe);
    total=total_descuentos;
    var to=(total).formatMoney(2,'.',',');
    $('#tot_desc').val(to);
    calcula_saldo();
}
//resta de los descuentos de los promotores
 function restar_promotor(importe) {
   total_descuentos= (total_descuentos-importe);
   total=total_descuentos;
   var to=(total).formatMoney(2,'.',',');
   $('#tot_desc').val(to);
  
}
//envio de parametros a la tabla autoriza
 function queryParams(params) {
        params.soc = $('#cboSociedad').val(); // add param1
        params.plaza = $('#cboEmp').val(); // add param2
       console.log(JSON.stringify(params));
        return params;
    }
    function nuevo_autoriza()
    {
        $('#nuevo_aut').hide();
        $('#loader-modal').show();
       $strD = "plaza=" + $('#cboPlaza').val() +"&soc=" + $('#cboSociedad').val() +"&emp=" + $('#cboEmp').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=nuevo_autoriza",
            success:function ($databack){
               $('#table-autoriza').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=autorizados&plaza=' + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()});
                $('#cboEmp').find('[value='+$('#cboEmp').val()+']').remove();
                $('#cboEmp').selectpicker('refresh');
               $str = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
                $("#autorizado").empty();
                $.ajax({
                    data: $str,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=busca_autorizado",
                    success:function ($data){
                        $('#nuevo_aut').show();
                        $('#loader-modal').hide();
                       $("#autorizado").html($data);
                       $('#autorizado').selectpicker('refresh');
                
                    }
                })
        
            }
        })  
    }

  function FormatterAccionesDesc(values, row) {
        return [
               '<label class="btn btn-warning btn-xs btn-editaDesc" style="margin-right:4%;"><i class="fa fa-pencil"></i></label>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
      window.tablaDescuentosEvents = {
            'click .btn-borrar': function (e, value, row, index) {
              $.confirm({
            text: "¿Esta seguro de eliminar el descuento del promotor: "+row.promotorNombre+"?",
             confirmButton: "Si, Eliminar",
             cancelButton: "No",
            confirm: function() {
                    var id = row.idDescuento;
                    var descuentosProm = FinanciamientoModel.facturaSeleccionada().descuentosPromotor();
                    if(id == 0 || id == null)
                    {
                        descuentosProm.descuentoSeleccionado(descuentosProm.descuentos()[index]);
                    }
                   else
                   {
                        for(var i= 0; i < descuentosProm.descuentos().length; i++)
                        {
                            if(id == descuentosProm.descuentos()[i].idDescuento())
                            {
                                descuentosProm.descuentoSeleccionado(descuentosProm.descuentos()[i]);
                                break;
                            }
                        }
                        descuentosBorrar.push(row.idDescuento);
                    }
                     FinanciamientoModel.facturaSeleccionada().descuentosPromotor().descuentos.remove(FinanciamientoModel.facturaSeleccionada().descuentosPromotor().descuentoSeleccionado());
                    // FinanciamientoModel.facturaSeleccionada().descuentosPromotor().descuentos.splice(index, 1); 
                    $('#promotor-table').bootstrapTable('destroy');
                    renderTableDescuento(FinanciamientoModel.facturaSeleccionada().descuentosPromotor().toModelDescuentos());     
                    show_stack_bar_top('error','Descuento eliminado!','El Descuento ha sido eliminado(Los cambios se guardarán hasta que presione el boton guardar)');

                },
            cancel: function() {

            }
          });  
            },
            'click .btn-editaDesc': function (e, value, row, index) 
            {
                $('#buttons-desc').hide();
                $('#act_desc').show();
                var id = row.idDescuento;
                var descuentosProm = FinanciamientoModel.facturaSeleccionada().descuentosPromotor();
                if(id == 0 || id == null)
                {
                    descuentosProm.descuentoSeleccionado(descuentosProm.descuentos()[index]);
                }
               else
               {
                    for(var i= 0; i < descuentosProm.descuentos().length; i++)
                    {
                        if(id == descuentosProm.descuentos()[i].idDescuento())
                        {
                            descuentosProm.descuentoSeleccionado(descuentosProm.descuentos()[i]);
                            break;
                        }
                    }
                }
                $('.selectpicker').selectpicker('refresh');
                $('#agregar_descuento').modal('show');
            }
        };
  function AccionesCheque(values, row) {
        return [
               '<label class="btn btn-warning btn-xs btn-editaCheque" style="margin-right:4%;"><i class="fa fa-pencil"></i></label>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    window.EventosCheque = 
    {
           'click .btn-borrar': function (e, value, row, index) {
                  $.confirm({
            text: "¿Esta seguro de eliminar el/la" + row.tipo_nombre + " por $"+ row.importe + " ?",
            confirmButton: "Si, Eliminar",
            cancelButton: "No",
            confirm: function() {
                    var id = row.idDescuento;
                    var depCliente = FinanciamientoModel.facturaSeleccionada().depositosCliente();
                    if(id == 0 || id == null)
                    {
                        depCliente.chequeSeleccionado(depCliente.cheques()[index]);
                    }
                   else
                   {
                        for(var i= 0; i < depCliente.cheques().length; i++)
                        {
                            if(id == depCliente.cheques()[i].idDeposito())
                            {
                                depCliente.chequeSeleccionado(depCliente.cheques()[i]);
                                break;
                            }
                        }
                        if(row.tipo_pago == 2 )
                        {
                           chequesBorrar.push(row.idDeposito);
                        }
                        else
                        {
                            depositosBorrar.push(row.idDeposito);
                        }
                        
                    }
                    FinanciamientoModel.facturaSeleccionada().depositosCliente().cheques.remove(FinanciamientoModel.facturaSeleccionada().depositosCliente().chequeSeleccionado());
                    $('#cheques-table').bootstrapTable('destroy');
                    renderTable(FinanciamientoModel.facturaSeleccionada().depositosCliente().toModelCheques());     
                    show_stack_bar_top('error','Movimiento eliminado!','El Movimiento ha sido eliminado(Los cambios se guardarán hasta que presione el boton guardar)');

                },
            cancel: function() {

            }
          });   
            },
        'click .btn-editaCheque': function (e, value, row, index) 
        {
            $('#buttons_agrega_cheq').hide();
            $('#act').show();
            var id = row.idDeposito;
            var depositos = FinanciamientoModel.facturaSeleccionada().depositosCliente();
            if(id == 0 || id == null)
            {
                depositos.chequeSeleccionado(depositos.cheques()[index]);
            }
           else
           {
                for(var i= 0; i < depositos.cheques().length; i++)
                {
                    if(id == depositos.cheques()[i].idDeposito())
                    {
                        depositos.chequeSeleccionado(depositos.cheques()[i]);
                        break;
                    }// calal
                }
            }
            $('.selectpicker').selectpicker('refresh');
            $('#agregar_cheque').modal('show');
             $('#fecha_cheque').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                clearBtn: true,
                todayHighlight: true
                })
        }
    };
     function AccionesDeposito(values, row) {
        return [
               '<label class="btn btn-warning btn-xs btn-edita" style="margin-right:4%;"><i class="fa fa-pencil"></i></label>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    window.EventosDeposito = 
    {
           'click .btn-borrar': function (e, value, row, index) {
                  $.confirm({
            text: "¿Esta seguro de eliminar el deposito del cliente por $"+ row.importe + " ?",
            confirmButton: "Si, Eliminar",
            cancelButton: "No",
            confirm: function() {
                    var id = row.idDeposito;
                    if(id == 0 || id == null)
                    {
                       FinanciamientoModel.abonoSeleccionado(FinanciamientoModel.abonos()[index]);
                       FinanciamientoModel.abonos.splice(index, 1); 
                    }
                   else
                   {
                        for(var i= 0; i < FinanciamientoModel.abonos().length; i++)
                        {
                            if(id == FinanciamientoModel.abonos()[i].idDeposito())
                            {
                                FinanciamientoModel.abonoSeleccionado(FinanciamientoModel.abonos()[i]);
                                break;
                            }
                        }
                            abonosBorrar.push(row.idDeposito);
                        
                    }
                    FinanciamientoModel.abonos.remove(FinanciamientoModel.abonoSeleccionado());
                    $('#abonos-table').bootstrapTable('destroy');
                    renderTableAbonos(FinanciamientoModel.toModelAbonos());     
                    show_stack_bar_top('error','Movimiento eliminado!','El Movimiento ha sido eliminado(Los cambios se guardarán hasta que presione el boton guardar)');

                },
            cancel: function() {

            }
          });   
            },
        'click .btn-edita': function (e, value, row, index) 
        {
            var id = row.idDeposito;
            if(id == 0 || id == null)
            {
                FinanciamientoModel.abonoSeleccionado(FinanciamientoModel.abonos()[index]);
            }
           else
           {
                for(var i= 0; i < FinanciamientoModel.abonos().length; i++)
                {
                    if(id ==  FinanciamientoModel.abonos()[i].idDeposito())
                    {
                        FinanciamientoModel.abonoSeleccionado(FinanciamientoModel.abonos()[i]);
                        break;
                    }// calal
                }
            }
            $('#agregar_abono').modal('show');
            $('#buttons_nvo_dep').hide();
            $('#act_dep').show();
            $('#importe_abono').mask('000,000,000,000,000.00', {reverse: true});
             $('#fecha_abono').mask('00/00/0000');
             $('#fecha_abono').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                clearBtn: true,
                todayHighlight: true
            })
        }
    };
    function cierra_cheque()
    {
        $('#agregar_cheque').modal('hide');
    }
 function AccionesNota(values, row) {
        return [
               '<label class="btn btn-warning btn-xs btn-edita" style="margin-right:4%;"><i class="fa fa-pencil"></i></label>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
      window.EventosNota = {
            'click .btn-borrar': function (e, value, row, index) {
               $.confirm({
            text: "¿Esta seguro de eliminar la nota de credito : " + row.folio + "?",
            confirmButton: "Si, Eliminar",
            cancelButton: "No",
            confirm: function() {
                    var id = row.idNota;
                    var Nota = FinanciamientoModel.facturaSeleccionada().notasCredito();
                    if(id == 0 || id == null)
                    {
                        Nota.notaSeleccionada(Nota.notas()[index]);
                    }
                   else
                   {
                        for(var i= 0; i < Nota.notas().length; i++)
                        {
                            if(id == Nota.notas()[i].idNota())
                            {
                                Nota.notaSeleccionada(Nota.notas()[i]);
                                break;
                            }
                        }
                        notasBorrar.push(row.idNota);
                    }
                     FinanciamientoModel.facturaSeleccionada().notasCredito().notas.remove(FinanciamientoModel.facturaSeleccionada().notasCredito().notaSeleccionada());
                    $('#notas-table').bootstrapTable('destroy'); 
                    renderTableNotas(FinanciamientoModel.facturaSeleccionada().notasCredito().toModelNotas()); 
                    show_stack_bar_top('error','¡Nota eliminada!','La nota de credito ha sido eliminada, los cambios se guardaran hasta que presione el boton Guardar');
                },
            cancel: function() {

            }
          }); 
            },
            'click .btn-edita': function (e, value, row, index) 
            {
               
                $('#buttons-nota').hide();
                $('#act_nota').show();
                var id = row.idNota;
                var Nota = FinanciamientoModel.facturaSeleccionada().notasCredito();
                if(id == 0 || id == null)
                {
                    Nota.notaSeleccionada(Nota.notas()[index]);
                }
               else
               {
                    for(var i= 0; i < Nota.notas().length; i++)
                    {
                        if(id == Nota.notas()[i].idNota())
                        {
                            Nota.notaSeleccionada(Nota.notas()[i]);
                            break;
                        }
                    }
                }
                $('.selectpicker').selectpicker('refresh');
                $('#agregar_nota').modal('show');
                $('#fecha_nota').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                clearBtn: true,
                todayHighlight: true
                })
            }
        };

  
    