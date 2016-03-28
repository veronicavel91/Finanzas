$(document).ready(function() {
    $('#imp_cheque').mask('000,000,000,000,000.00', {reverse: true});
    $('#imp_fact').mask('000,000,000,000,000.00', {reverse: true});
    $('#importe_desc').mask('000,000,000,000,000.00', {reverse: true});
    $('#imp_reg').mask('000,000,000,000,000.00', {reverse: true});
    $('#fecha_fact').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
     $('#fecha_reg')
        .datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })
          $('#fecha_cheque')
        .datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            clearBtn: true,
            todayHighlight: true
        })

	    //tabla de cheques
    var id= $('#id_fin').val();
    imp_dep();
    imp_fin();
    desc();
    fact_combo();
    $('#facturas-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=detalle_factura&id='+ id,
        cache: false,
        height: 600,
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
            field: 'idfact',
            title: 'Id',
            sortable: true
        },
        {
            field: 'folio',
            title: 'Folio factura',
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
            field: 'importe',
            title: 'Importe',
            sortable: true,
            formatter: financiadoFormatter
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
        formatter: FormatterAccionesFact,
        events: tablaFacturasEvents
        }
        ]
    });
 $('#abonos-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=detalle_abonos&id='+ id,
        cache: false,
        height: 600,
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
            field: 'factura',
            title: 'Factura abono',
            sortable: true
        },
        {
            field: 'metodo',
            title: 'Metodo de pago',
            sortable: true
        },
        {
            field: 'fecha',
            title: 'Fecha abono',
            sortable: true
        },
        {
            field: 'obs',
            title: 'Observaciones',
            sortable: true
        },
        {
            field: 'importe',
            title: 'Importe',
            sortable: true
        },
       {
        field: 'Acciones',
        title: 'Borrar',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesAbonos,
        events: tablaAbonosEvents
        }
        ]
    });
  $('#descuento-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=detalle_desc&id='+ id,
        cache: false,
        height: 600,
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
            field: 'id_des',
            title: 'Id',
            sortable: true
        },
        {
            field: 'emp',
            title: 'Promotor',
            sortable: true
        },
        {
            field: 'idfactura_finan',
            title: '# factura',
            sortable: true
        },
        {
            field: 'folio_fact',
            title: 'Folio',
            sortable: true
        },
        {
            field: 'edo',
            title: 'Estado',
            sortable: true
        },
        {
            field: 'obs',
            title: 'Observaciones',
            sortable: true
        },
        {
            field: 'importe',
            title: 'Descuento',
            sortable: true,
            formatter: financiadoFormatter,
        },
        {
            field: 'pagado',
            title: 'Pagado',
            sortable: true,
            formatter: depositoFormatter,

        },
        {
            field: 'saldo',
            title: 'Pendiente',
            sortable: true,
            formatter: priceFormatter,
        },
       {
        field: 'Acciones',
        title: '  Acciones  ',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesDesc,
        events: tablaDescuentosEvents
        }
        ]
    });
 $('#cheques-table').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=detalle_cheques&id='+ id,
        cache: false,
        height: 400,
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
            field: 'idcheque',
            title: 'Id',
            sortable: true
        },
        {
            field: 'folio_cheque',
            title: 'Folio cheque',
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
            field: 'edo',
            title: 'Estado',
            sortable: true
        },
        {
            field: 'importe',
            title: 'Importe',
            sortable: true,
            formatter: depositoFormatter
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
});

//acciones cheques
     function FormatterAcciones(values, row) {
        return [
               '<a class="btn btn-warning btn-xs btn-edita-cheq" style="margin-right:10%;"><i class="fa fa-exclamation-circle"></i></a>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
     //acciones de cheques
      window.operateEvents = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarCheque(index, row.idcheque, row.importe);
            },
            'click .btn-edita-cheq': function (e, value, row, index) {
                self.CambiaEdoCheque(index, row.idcheque, row.importe);
            }
        };
     //acciones descuentos
     function FormatterAccionesDesc(values, row) {
        return [
               '<button class="btn btn-success btn-xs btn-edit-desc " style="margin-right:12%;margin-bottom:6%;"><i class="fa fa-money"></i></button>',
               '<button class="btn btn-warning btn-xs btn-edo-desc " style="margin-right:12%;margin-bottom:6%;"><i class="fa fa-exclamation-circle"></i></button>',
               '<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
               
        ].join('');
    }
     //acciones de descuentos
        window.tablaDescuentosEvents = {
            'click .btn-edo-desc': function (e, value, row, index) {
                self.EdoDescuento(row.id_des, row.edo, row.importe);
            },
             'click .btn-borrar': function (e, value, row, index) {
                self.BorrarDescuento(row.id_des, row.importe);
            },
          'click .btn-edit-desc': function (e, value, row, index) {
            //editar el descuento del promotor
            self.modal_regresa(row.id_des);

        }
        };
          function FormatterAccionesAbonos(values, row) {
        return [
               '<label class="btn btn-danger btn-sm btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
       //acciones de abonos
        window.tablaAbonosEvents = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarAbono(index, row.promotor, row.importe);
            }
        };
      function FormatterAccionesFact(values, row) {
        return [
               //'<a class="btn btn-info btn-xs btn-edita-fact" style="margin-right:10%;"><i class="fa fa-pencil"></i></a>',
               '<a class="btn btn-danger btn-xs btn-edo" style="margin-right:10%;"><i class="fa fa-exclamation-circle"></i></a>'
               //'<label class="btn btn-danger btn-xs btn-borrar"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    //acciones de facturas
        window.tablaFacturasEvents = {
            'click .btn-borrar': function (e, value, row, index) {
                self.BorrarFactura(index, row.idfact, row.importe);
            },
            'click .btn-edo': function (e, value, row, index) {
                self.CambiaEdoFactura(index, row.idfact, row.estado,row.importe);
            }
        };
        function FormatterAccionesRegreso(values, row) {
        return [
               '<label class="btn btn-danger btn-xs btn-borrar-reg"><i class="fa fa-trash"></i></label>'
        ].join('');
    }
    //acciones de facturas
        window.tablaRegresoEvents = {
            'click .btn-borrar-reg': function (e, value, row, index) {
               self.BorrarPago(row.id, row.imp);
            }
        };


    self.BorrarFactura = function(index, row, financiado)
    {
        var r = confirm("¿Esta seguro de eliminar la factura folio:" + row + "?");
        if (r == true) 
        {
              $str = "id=" + row;
                 $("#autorizado").empty();
                $.ajax({
                    data: $str,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=borrar_factura",
                    success:function ($data){
                        if($data==1)
                        {
                            alert("La factura "+ row + " ha sido eliminada");
                            $('#facturas-table').bootstrapTable('refresh', {silent: true });
                            var fin =parseFloat(financiado.replace(',', ''));
                              $datos = "id=" + $('#id_fin').val() + "&imp=" + fin;
                               $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_financiado",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var acumulado =parseFloat($('#importe_fin').val().replace(',', ''));
                                        var tot= (acumulado - fin);
                                        var total=(tot).formatMoney(2,'.',',');
                                        $("#importe_fin").val(total);
                                         calcula_saldo();
                                    }             
                            
                                }
                            })
                        }  
                        else
                        {
                            alert("ha ocurrido un error al eliminar la factura error:"+ $data);
                        }                  
                
                    }
                })
        } else {
        }          
    }
     function imp_dep()
     {
        $str = "id=" + $('#id_fin').val();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=calcula_dep",
            success:function ($data){
                $('#importe_dep').val($data);  
                calcula_saldo()    
        
            }
        })

     }
      function imp_fin()
     {

        $str = "id=" + $('#id_fin').val();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=calcula_fin",
            success:function ($data){
                $('#importe_fin').val($data);
                calcula_saldo();
            }
        })

        
     }
     function desc()
     {
         $str = "id=" + $('#id_fin').val();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=calcula_desc",
            success:function ($data){
                $('#tot_desc').val($data);
                calcula_saldo()
                 
            }
        })
     }
    //borrar cheque
    self.BorrarCheque = function(index, row, deposito)
        {
            var r = confirm("¿Esta seguro de eliminar el cheque no." + row + "?");
            if (r == true) 
            {
                $str = "id=" + row;
                $.ajax({
                    data: $str,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=borrar_cheque",
                    success:function ($data){
                        if($data==1)
                        {
                            alert("Cheque eliminado");
                             var dep =parseFloat(deposito.replace(',', ''));
                             var acumulado =parseFloat($('#importe_dep').val().replace(',', ''));
                            $('#cheques-table').bootstrapTable('refresh', {silent: true });
                             $datos = "id=" + $('#id_fin').val() + "&imp=" + dep;
                            $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_deposito",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var tot= (acumulado-dep);
                                        var total=(tot).formatMoney(2,'.',',');
                                        $("#importe_dep").val(total);
                                        calcula_saldo();
                                    }             
                            
                                }
                            })
                            //restar_financiado(financiado);
                        }  
                        else
                        {
                            alert("ha ocurrido un error al eliminar la factura error:"+ $data);
                        }                  
                
                    }
                })
            } else {
            }
                        
        }
    //agregar una factura
function guardarFactura()
{
    $('#datos-fact').hide('fast');
    $('#buttons-fact').hide('fast');
    $('#load-fact').show('fast');
    var imp_fact=parseFloat($('#imp_fact').val().replace(',', ''));

    $str = "id=" + $('#id_fin').val() + "&folio="+ $('#folio_fact').val() + "&fecha="+ $('#fecha_fact').val() + "&imp="+ imp_fact + "&edo="+ $('#edo_fact').val() + "&obs="+ $('#obser_fact').val();
    $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=guarda_factura",
            success:function ($data){
                if($data.trim() == 1)
                {
                     $datos = "id=" + $('#id_fin').val() + "&imp=" + imp_fact;
                       $.ajax({
                        data: $datos,
                        type: "POST",
                        dataType: "text",
                        url: "ajax.php?c=financiamiento&f=sumar_financiado",
                        success:function ($resp){
                            if($resp.trim()== 1)
                            {
                              var acumulado= parseFloat($('#importe_fin').val().replace(',', ''));
                               var tot= (parseFloat(acumulado)+parseFloat(imp_fact));
                               var total=(tot).formatMoney(2,'.',',');
                                $('#importe_fin').val(total);
                                 $('#datos-fact').show('fast');
                                 $('#buttons-fact').show('fast');
                                 $('#load-fact').hide('fast');
                                 //limpiar campos
                                 $('#folio_fact').val("");
                                 $('#fecha_fact').val("");
                                 $('#imp_fact').val(0);
                                 $('#obser_fact').val("");
                                 $('#agregar_factura').modal('hide');
                                 alert("Factura agregada");
                                $('#facturas-table').bootstrapTable('refresh', {silent: true });
                                fact_combo();
                                 calcula_saldo();

                            }             
                    
                        }
                    })
                }
                else
                {
                    alert("Error al agregar la factura, intentelo de nuevo");
                }
            }
        })
        
        //calcular_financiado(financiado);
       // calcula_saldo();
   
}
//muestra el modal para agregar el cheque
function modalCheque()
{
    $('#agregar_cheque').modal('show');
}
function modalFactura()
{
    $('#agregar_factura').modal('show');
}
   function guardarCheque()
    {
   
        $('#datos-cheque').hide('fast');
        $('#buttons3').hide('fast');
        $('#carga_cheque').show();
        var imp=parseFloat($('#imp_cheque').val().replace(',', ''));
        $str = "id=" + $('#id_fin').val() + "&cheque=" + $('#no_cheque').val() + "&fecha=" + $('#fecha_cheque').val() + "&soc=" + $('#soc_cheque').val() + "&imp=" + imp  + "&obs=" + document.getElementById("obs_cheque").value + "&edo_cheque=" + $('#edo_cheque').val();
         $.ajax({
                    data: $str,
                    type: "POST",
                    dataType: "text",
                    url: "ajax.php?c=financiamiento&f=guarda_cheque",
                    success:function ($data){
                        if($data==1)
                        {
                            $datos = "id=" + $('#id_fin').val() + "&imp=" + imp;
                           $.ajax({
                            data: $datos,
                            type: "POST",
                            dataType: "text",
                            url: "ajax.php?c=financiamiento&f=sumar_deposito",
                            success:function ($resp){
                                if($resp.trim()== 1)
                                {
                                     var acumulado=parseFloat($('#importe_dep').val().replace(',', ''));

                                     var tot= (parseFloat(acumulado)+parseFloat(imp));
                                     var total=(tot).formatMoney(2,'.',',');
                                     $('#importe_dep').val(total);
                                     $('#datos-cheque').show('fast');
                                     $('#buttons3').show('fast');
                                     $('#load_cheque').hide('fast');
                                     //limpiar campos
                                     $('#no_cheque').val("");
                                     $('#fecha_cheque').val("");
                                     $('#soc_cheque').selectpicker('refresh');
                                     $('#imp_cheque').val("");
                                     $('#obs_cheque').val("");
                                     $('#agregar_cheque').modal('hide');
                                    alert("Cheque guardado");
                                    $('#cheques-table').bootstrapTable('refresh', {silent: true });
                                     calcula_saldo();

                                }             
                        
                            }
                        })
                
                        }  
                        else
                        {
                              $('#datos-cheque').show('fast');
                             $('#buttons3').show('fast');
                             $('#load3').hide('fast');
                             //limpiar campos
                             $('#no_cheque').val("");
                             $('#fecha_cheque').val("");
                             $('#soc_cheque').selectpicker('refresh');
                             $('#imp_cheque').val("");
                             $('#obs_cheque').val("");
                             $('#agregar_cheque').modal('hide');
                            alert("ha ocurrido un error al guardar el cheque, intentelo de nuevo");
                        }                  
                
                    }
                })
     
}
   function modal_regresa(id)
    {
        $('#modalRegresa').modal('show');
        $('#id_desc').val(id);
        $('#table-regresa').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_regreso&desc=' + id});

    }
function regresar()
    {
        $('#regresa').hide();
        $('#loader-modal').show();
        var imp =parseFloat($('#imp_reg').val().replace(',', ''));
       $strD = "fin=" + $('#id_fin').val() +"&desc=" + $('#id_desc').val() +"&fecha=" + $('#fecha_reg').val()+"&imp=" + imp+"&obs=" + $('#obs_reg').val();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=regreso_promotor",
            success:function ($databack){
                if($databack.trim()==1)
                {
                    $('#regresa').show();
                    $('#loader-modal').hide();
                    $('#fecha_reg').val("");
                    $('#imp_reg').val("");
                    $('#obs_reg').val("");
                    $datos = "id=" + $('#id_fin').val() + "&imp=" + imp;
                               $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_descuento",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var tot_desc=parseFloat($("#tot_desc").val().replace(',', ''));
                                        var tot= (tot_desc - imp);
                                        var descuento =(tot).formatMoney(2,'.',',');
                                        $('#tot_desc').val(descuento);
                                         calcula_saldo();
                                    }             
                            
                                }
                            })
                    alert("Pago agregado");
                    $('#table-regresa').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_regreso&desc=' + $('#id_desc').val() });
                    $('#descuento-table').bootstrapTable('refresh', {silent: true });
                }
                else
                {
                    alert("Ha ocurrido un error al agregar el pago " + $databack)
                }
            }
        })  
    }
function BorrarPago(id,imp)
    {
         var r = confirm("¿Esta seguro de eliminar el pago por $" + imp + "?");
        if (r == true) 
        {
            var importe =parseFloat(imp.replace(',', ''));
            $strD = "id=" + id+"&desc="+ $('#id_desc').val()+"&imp="+ importe;
            $.ajax({
                data: $strD,
                type: "POST",
                dataType: "text",
                url: "ajax.php?c=financiamiento&f=borra_pago",
                success:function ($databack){
                    if($databack.trim()==1)
                    {

                        alert("El pago ha sido eliminado");
                        $('#table-regresa').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_regreso&desc=' + $('#id_desc').val() });
                        $('#descuento-table').bootstrapTable('refresh', {silent: true });
                    }
                    else
                    {
                        alert("Ha ocurrido un error al borrar el pago " + $databack)
                    }
                }
            })
        }  
    }
    function modalPromotor()
{
    
    $('#agregar_descuento').modal('show');
}
function fact_combo()
{
    $str = "fin="+ $('#id_fin').val();
     $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=facturas_combo",
            success:function ($data){
               $("#folio_desc").html($data);
               $('#folio_desc').selectpicker('refresh');
        
            }
        })
}
function guardarDescuento(){
 
    $('#datos-fact').hide('fast');
    $('#buttons-fact').hide('fast');
    $('#load-fact').show('fast');
    var imp_desc=parseFloat($('#importe_desc').val().replace(',', ''));
     $str = "fin="+ $('#id_fin').val() + "&fact="+ $('#folio_desc option:selected').text() +"&promotor="+ $('#promotor').val() +"&importe_desc="+ imp_desc + "&estado="+ $('#edo_desc').val() + "&obs="+ $('#obs_desc').val();
     $.ajax({
        data: $str,
        type: "POST",
        dataType: "text",
        url: "ajax.php?c=financiamiento&f=guarda_descuento",
        success:function ($data){
        if($data == 1)
        {
                      $datos = "id=" + $('#id_fin').val() + "&imp=" + imp_desc;
                       $.ajax({
                        data: $datos,
                        type: "POST",
                        dataType: "text",
                        url: "ajax.php?c=financiamiento&f=sumar_descuento",
                        success:function ($resp){
                            if($resp.trim()== 1)
                            {    
                                var acumulado= parseFloat($('#tot_desc').val().replace(',', ''));
                                var tot= (parseFloat(acumulado)+parseFloat(imp_desc));
                                var saldo=(tot).formatMoney(2,'.',',');
                                $('#tot_desc').val(saldo);
                                $('#datos-desc').show('fast');
                                 $('#buttons-desc').show('fast');
                                 $('#load-desc').hide('fast');
                                 //limpiar campos
                                 $('#importe_desc').val("");
                                 $('#obs_desc').val("");
                                 $('#agregar_descuento').modal('hide');
                                 alert("descuento agregado");
                                  $('#descuento-table').bootstrapTable('refresh', {silent: true });

                            }             
                    
                        }
                    })
        }
        else
        {
            $('#datos-desc').show('fast');
             $('#buttons-desc').show('fast');
             $('#load-desc').hide('fast');
             //limpiar campos
             $('#importe_desc').val("");
             $('#obs_desc').val("");
             $('#agregar_descuento').modal('hide');
            alert("ha ocurrido un error al guardar el descuento, intentelo de nuevo")
        }
        }
    })
}
function BorrarDescuento(row, importe)
{
    var r = confirm("¿Esta seguro de eliminar el descuento #" + row + " por $"+ importe + "?");
    if (r == true) 
    {
        $str = "id="+ row;
         $.ajax({
                data: $str,
                type: "POST",
                dataType: "text",
                url: "ajax.php?c=financiamiento&f=borrar_descuento",
                success:function ($data){
                  if($data==1)
                  {
                    alert("La descuento ha sido eliminado");
                    $('#descuento-table').bootstrapTable('refresh', {silent: true });
                    var imp =parseFloat(importe.replace(',', ''));
                    $datos = "id=" + $('#id_fin').val() + "&imp=" + imp;
                               $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_descuento",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var tot_desc=parseFloat($("#tot_desc").val().replace(',', ''));
                                        var tot= (tot_desc - imp);
                                        var descuento =(tot).formatMoney(2,'.',',');
                                        $('#tot_desc').val(descuento);
                                         calcula_saldo();
                                    }             
                            
                                }
                            })
                  }
            
                }
            })

    } else {
    }
                
}
 function calcula_saldo() {
           var total_financiado=parseFloat($('#importe_fin').val().replace(',', ''));
           var total_depositos=parseFloat($('#importe_dep').val().replace(',', ''));

          if(total_financiado != 0 && total_depositos !=0)
            {
                saldo_final=(total_financiado-total_depositos);
                total=saldo_final;
                var saldo=(total).formatMoney(2,'.',',');
                $('#saldo_fact').val(saldo);
            }
            else if(total_financiado!= 0 && total_depositos ==0)
            {
                saldo_final= total_financiado;
                  total=saldo_final;
                 var tot=(total).formatMoney(2,'.',',');
                $('#saldo_fact').val(tot);
            }else if(total_financiado==0 ){
                saldo_final= 0;
                  total=saldo_final;
                 var tot=(total).formatMoney(2,'.',',');
                $('#saldo_fact').val(tot);
            }
            else
            {

            }
        } 
 function cambiaEstado()
{
 $('#modalEdo').modal('show');
 var edo = $('#id_edo').val();
 var nom_edo = $('#status_nom').val()
 $('#nom_edo').val(nom_edo);
$('#Edo > option[value="'+edo+'"]').attr('selected', 'selected');
  $('#fecha_bloq').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    });
       
}   
self.EdoDescuento = function(row, estado, importe)
    {
      $str = "id=" + row;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=busca_edo_desc",
            success:function ($data){
                $('#modalEdoDescuento').modal('show');
                var json_obj = $.parseJSON($data);//parse JSON
                $('#id_desc_edo').val(row);
                  $('#actual_desc').html(estado);
                   $('#importe_edo_desc').val(importe);
                for (var i in json_obj) 
                {
                    $('#edo_id_desc').val(json_obj[i].id_edo);
        
                }

        
            }
        })
    }
//actualiza estado del descuento de promotor
function update_estado_desc()
{
     var edo=$('#edo_id_desc').val();
     var nvo= $('#Edo_desc').val();
     if(edo == nvo)
     {
        alert("No se puede actualizar el estado debido a que el nuevo estado es el mismo que el anterior");
     }
     else
     {

         $('#load').show();
         $('#datos').hide();
         $('#buttons').hide();
         $strD = "id=" + $('#id_desc_edo').val()  +"&edo=" + $('#Edo_desc').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=financiamiento&f=update_edo_descuento",
                  success: function (data) {
                    if(data.trim()==1) {
                        if(nvo == 3)
                        {
                          var desc =parseFloat($('#importe_edo_desc').val().replace(',', ''));
                          var acumulado =parseFloat($('#tot_desc').val().replace(',', ''));
                          if(acumulado > 0)
                          {
                              $datos = "id=" + $('#id_fin').val() + "&imp=" + desc;
                               $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_descuento",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var tot= (acumulado - desc);
                                        var total=(tot).formatMoney(2,'.',',');
                                       $("#tot_desc").val(total);
                                     }             
                            
                                }
                            })
                           }
                         }
                           else if(edo==3 && nvo == 1 || nvo == 2)
                           {
                                  var desc =parseFloat($('#importe_edo_desc').val().replace(',', ''));
                                  $dat = "id=" + $('#id_fin').val() + "&imp=" + desc;
                                   $.ajax({
                                    data: $dat,
                                    type: "POST",
                                    dataType: "text",
                                    url: "ajax.php?c=financiamiento&f=sumar_descuento",
                                    success:function ($resp){
                                        if($resp.trim()== 1)
                                        {    
                                            var acumulado= parseFloat($('#tot_desc').val().replace(',', ''));
                                            var tot= (parseFloat(acumulado)+parseFloat(desc));
                                            var saldo=(tot).formatMoney(2,'.',',');
                                            $('#tot_desc').val(saldo);

                                        }             
                                
                                    }
                                })
                           }
                        $('#modalEdoDescuento').modal('hide');
                        alert("¡El estado del descuento ha sido actualizado correctamente!")
                        $('#descuento-table').bootstrapTable('refresh', {silent: true });

                    }else{
                        alert('Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');
                    }
                  }
              });
    }
}
function actualiza_estado()
{
     var edo=$('#nom_edo').val();
     var nvo= $('#Edo option:selected').html();
     if(edo == nvo)
     {
        alert("No se puede actualizar el estado debido a que el nuevo estado es el mismo que el anterior");
     }
     else
     {

         $('#load').show();
         $('#datos').hide();
         $('#buttons').hide();
         $strD = "id=" + $('#id_fin').val()  +"&edo=" + $('#Edo').val();
              $.ajax({
                  data: $strD,
                  type: "POST",
                  dataType: "text",
                  url: "ajax.php?c=financiamiento&f=actualiza_edo_fin",
                  success: function (data) {

                    if(data.trim()=="OK") {
                        $('#load').hide();
                        $('#btnok').show();
                        $('#ok').show();
                    }else{
                        alert('Lo sentimos, ha ocurrido un error sus datos no han podido ser actualizados');
                    }
                  }
              });
    }
}
function acepta()
{
    $('#datos').show();
    $('#ok').hide();
    $('#buttons').hide();
    $('#modalEdo').modal('hide');
    location.reload(); 
}
 self.CambiaEdoFactura = function(index, row, estado, importe)
    {
      $str = "id=" + row;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=busca_edo_factura",
            success:function ($data){
                $('#modalEdo-Factura').modal('show');
                var json_obj = $.parseJSON($data);//parse JSON
                 $('#id_factura').val(row);
                 $('#importe_edo_fact').val(importe);
                for (var i in json_obj) 
                {
                    $('#id_edo_fact').val(json_obj[i].idedo);
                    $('#actual_fact').val(json_obj[i].estado);
        
                }

        
            }
        })
    }
function updateEdoFactura()
{
     var edo=$('#id_edo_fact').val();
     var nvo= $('#nuevo_edo_fact').val();
     if(edo == nvo)
     {
        alert("El nuevo estado no puede ser igual al anterior");
     }
     else
     {
        $str = "id=" + $('#id_factura').val();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=facturas_descuentos",
            success:function ($data){
              var total=(parseFloat($data));
              if(total>0)
              {
                $("#falla_fact").show('fast');
              }
              else
              {
                 $('#loading_edo_fact').show();
                  $datos = "id=" + $('#id_factura').val()  +"&edo=" + $('#nuevo_edo_fact').val();
                  $.ajax({
                      data: $datos,
                      type: "POST",
                      dataType: "text",
                      url: "ajax.php?c=financiamiento&f=actualiza_edo_factura",
                      success: function (response) {
                        if(response.trim()==1) {
                            var fin =parseFloat($('#importe_edo_fact').val().replace(',', ''));
                            if($('#nuevo_edo_fact').val() == 2 || $('#nuevo_edo_fact').val() == 3 )
                            {
                              $datos = "id=" + $('#id_fin').val() + "&imp=" + fin;
                               $.ajax({
                                data: $datos,
                                type: "POST",
                                dataType: "text",
                                url: "ajax.php?c=financiamiento&f=restar_financiado",
                                success:function ($resp){
                                    if($resp==1)
                                    {
                                        var acumulado =parseFloat($('#importe_fin').val().replace(',', ''));
                                        var tot= (acumulado - fin);
                                        var total=(tot).formatMoney(2,'.',',');
                                        $("#importe_fin").val(total);
                                         calcula_saldo();
                                    }             
                            
                                }
                            })
                            }
                            else if($('#nuevo_edo_fact').val() == 1)
                            {
                                var fin =parseFloat($('#importe_edo_fact').val().replace(',', ''));
                                $strData = "id=" + $('#id_fin').val() + "&imp=" + fin;
                                   $.ajax({
                                    data: $strData,
                                    type: "POST",
                                    dataType: "text",
                                    url: "ajax.php?c=financiamiento&f=sumar_financiado",
                                    success:function (response){
                                        if(response.trim()== 1)
                                        {
                                          var acumulado= parseFloat($('#importe_fin').val().replace(',', ''));
                                           var tot= (parseFloat(acumulado)+parseFloat(fin));
                                           var total=(tot).formatMoney(2,'.',',');
                                            $('#importe_fin').val(total);
                                             calcula_saldo();

                                        }             
                                
                                    }
                                })
                            }
                            $('#modalEdo-Factura').modal('hide');
                            alert("Estado actualizado correctamente");
                            $('#facturas-table').bootstrapTable('refresh', {silent: true });
                        }else{
                            alert('Lo sentimos, ha ocurrido un error, el estado no ha podido ser actualizado');
                        }
                      }
                  });
              }

        
            }
        })
       
    }
}
self.CambiaEdoCheque = function(index, row, importe)
    {
      $str = "id=" + row;
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=busca_edo_cheque",
            success:function ($data){
                $('#modalEdo-Cheque').modal('show');
                var json_obj = $.parseJSON($data);//parse JSON
                 $('#cheque_id').val(row);
                 $('#importe_edo_cheque').val(importe);
                for (var i in json_obj) 
                {
                    $('#id_edo_cheque').val(json_obj[i].idedo);
                    $('#actual_cheque').val(json_obj[i].estado);
        
                }

        
            }
        })
    }
function updateEdoCheque()
{
     var edo=$('#id_edo_cheque').val();
     var nvo= $('#nuevo_cheque_edo').val();
     if(edo == nvo)
     {
        alert("El nuevo estado no puede ser igual al anterior");
     }
     else
     {
                     $('#loading_edo_fact').show();
                      $datos = "id=" + $('#cheque_id').val()  +"&edo=" + $('#nuevo_cheque_edo').val();
                      $.ajax({
                          data: $datos,
                          type: "POST",
                          dataType: "text",
                          url: "ajax.php?c=financiamiento&f=actualiza_edo_cheque",
                          success: function (response) {
                            if(response.trim()==1) {
                                var dep =parseFloat($('#importe_edo_cheque').val().replace(',', ''));
                                if(edo == 1 && $('#nuevo_cheque_edo').val() == 2 || $('#nuevo_cheque_edo').val() == 3 )
                                {
                                  $datos = "id=" + $('#id_fin').val() + "&imp=" + dep;
                                    $.ajax({
                                        data: $datos,
                                        type: "POST",
                                        dataType: "text",
                                        url: "ajax.php?c=financiamiento&f=restar_deposito",
                                        success:function ($resp){
                                            if($resp==1)
                                            {
                                                var acumulado= parseFloat($('#importe_dep').val().replace(',', ''));
                                                var tot= (acumulado-dep);
                                                var total=(tot).formatMoney(2,'.',',');
                                                $("#importe_dep").val(total);
                                                calcula_saldo();
                                            }             
                                    
                                        }
                                    })
                                }
                                else if(edo != 1 && $('#nuevo_cheque_edo').val() == 1)
                                {
                                     var imp =parseFloat($('#importe_edo_cheque').val().replace(',', ''));
                                    $datos = "id=" + $('#id_fin').val() + "&imp=" + imp;
                                       $.ajax({
                                        data: $datos,
                                        type: "POST",
                                        dataType: "text",
                                        url: "ajax.php?c=financiamiento&f=sumar_deposito",
                                        success:function ($resp){
                                            if($resp.trim()== 1)
                                            {
                                                 var acumulado=parseFloat($('#importe_dep').val().replace(',', ''));
                                                 var tot= (parseFloat(acumulado)+parseFloat(imp));
                                                 var total=(tot).formatMoney(2,'.',',');
                                                 $('#importe_dep').val(total);
                                                 calcula_saldo();

                                            }             
                                    
                                        }
                                    })
                                }
                                $('#modalEdo-Cheque').modal('hide');
                                alert("Estado del cheque actualizado correctamente");
                                $('#cheques-table').bootstrapTable('refresh', {silent: true });
                            }else{
                                alert('Lo sentimos, ha ocurrido un error, el estado no ha podido ser actualizado');
                            }
                          }
                      });
       
    }
}
 function rowStyle(row, index) {
        var danger = ['danger'];
        var success = ['success'];
        if (row.saldo != "0.00") {
            return {
                classes: danger
            };
        }
        else
        {
            return {
                classes: success
            };
        }
        return {};
    }