   <div class="container">
     <div class="page-header">
    <br>
        <h3 class="title"><i class="fa fa-male"></i>  Detalle de descuentos</h3>
        <h5>Empleado: <?php echo $nombre_emp ?></h5>
    </div>
    <div class="btn-group btn-group-sm pull-right" aria-label="Small button group" role="group" style="margin-top:10px;margin-left:1%;">
        <button class="btn btn-warning" type="button" onclick="pendientes()">Pendientes</button>
        <button class="btn btn-success" type="button" onclick="pagados()">Pagados</button>
    </div>
        <div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:60%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>  Regreso de descuentos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <input type="hidden" id="fin">
                            <input type="hidden" id="desc">
                            <label for="" class="col-lg-2">Importe:</label>
                            <div class="col-lg-4">
                               <input type="text" class="form-control" id="imp_regreso" name="imp_regreso">
                            </div>
                             <label for="" class="col-lg-1">Fecha:</label>
                            <div class="col-lg-4">
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control" name="fecha_regreso" id="fecha_regreso" placeholder="aaaa-mm-dd" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-2">Observaciones:</label>
                            <div class="col-lg-8">
                            <textarea name="" id="" class="form-control" id="obs_regreso" name="obs_regreso"></textarea>
                            </div>
                            <div class="col-lg-1">
                        <button class="btn btn-success btn-sm" id="nuevo_aut" onclick="guarda_regreso()"><i class="fa fa-money"></i>  Pagar</button>
                            <br><br>
                        </div>
                        </div>
                        <div class="col-lg-1" id="loader-modal" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>
                       <table id="table-regresa"
                               data-toggle="table"
                               data-height="299"
                               data-url="../json/data1.json">
                            <thead>
                            <tr>
                                <th data-field="id">#</th>
                                <th data-field="fecha">Fecha</th>
                                <th data-field="imp">Importe</th>
                                <th data-field="obser">Observaciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
<table id="table-detalle" data-show-export="true"  data-locale="es-MX"  data-show-toggle="true" data-row-style="rowStyle"><table/>
<script>
    $(document).ready(function() {
    $('#table-detalle').bootstrapTable({
        method: 'get',
        url: 'ajax.php?c=financiamiento&f=detalle_descuento',
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
            field: 'fecha',
            title: 'Fecha',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            field: 'id_fin',
            title: '#Fin',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'razon',
            title: 'Cliente',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'idFact',
            title: '#Factura',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'folio_fact',
            title: 'Folio factura',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'observaciones',
            title: 'observaciones',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'status',
            title: 'Estado',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'importe_pag',
            title: 'Pagado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: priceFormatter,
        },
        {
            field: 'imp_desc',
            title: 'Descontado',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: depositoFormatter,
        },
        {
            field: 'saldo',
            title: 'Saldo final',
            align: 'center',
            valign: 'middle',
            sortable: true,
            formatter: financiadoFormatter,
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
       $('#imp_regreso').mask('000,000,000,000,000.00', {reverse: true});
        $('#fecha_regreso').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })


});
     function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-success btn-xs btn-pagar"><i class="fa fa-money"></i></button>'
        ].join('');
    }
    window.operateEvents = {
        'click .btn-pagar': function (e, value, row, index) {
            $('#modalTable').modal('show');
            $('#table-regresa').bootstrapTable();
            $('#table-regresa').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_regreso&desc=' + row.id});
            $('#fin').val(row.id_fin);
            $('#desc').val(row.id);

            }
    };
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
    function consultar()
    {
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=1&plaza='+$('#cboPlaza').val()+'&soc='+$('#cboSociedad').val()});
    }
    function pendientes()
    {
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=1'});
    }
     function pagados()
    {
       $('#table-descuentos').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=all_descuentos&busca=2'});
    }
 function rowStyle(row, index) {
        var danger = ['danger'];
        var success = ['success'];
        var warning = ['warning'];
        if (row.saldo != "0.00") {
            return {
                classes: warning
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
    function guarda_regreso()
    {
         $strD = "fin="+ $('#fin').val()+"&imp=" + "&desc="+ $('#desc').val()+ "&imp="+$('#imp_regreso').val().replace(',', '') + "&fecha=" +  $('#fecha_regreso').val() + "&obs="+ $('#obs_regreso').val();
            $.ajax({
                data: $strD,
                type: "POST",
                dataType: "text",
                url: "ajax.php?c=financiamiento&f=regreso_promotor",
                success:function ($databack){
                  if($databack == 1)
                  {
                     show_stack_bar_top('success','¡Pago guardado!','El pago al promotor ha sido guardado');
                     $('#table-regresa').bootstrapTable('refresh', {url: 'ajax.php?c=financiamiento&f=consulta_regreso&desc=' + $('#desc').val()});
                     $('#table-detalle').bootstrapTable('refresh', {silent: true });
                    $('#obs_regreso').val('');
                    $('#imp_regreso').val('');
                    $('#fecha_regreso').val('');
                  }
               }
            })
           
    }
</script>