
var Financiamiento = function (){
	var self = this;
	self.esNuevo = true;
	self.isDisabled = ko.observable(false);
	self.financiamientoID = ko.observable(0);
	//facturas que contiene el financiamiento
	self.facturas = ko.observableArray([]);
	self.facturaSeleccionada = ko.observable();
	self.abonos = ko.observableArray([]);
	self.abonoSeleccionado = ko.observable();//
	self.facturasIndex = ko.observable(0);
	self.errors = ko.validation.group(self);
	self.isLoading = ko.observable(false);
	self.facturaNombre = ko.pureComputed(
		function(){ 
			try{
				if(self.facturaSeleccionada().fIndex() == self.facturasIndex()){
					return "Factura " + self.facturasIndex().toString();
				}
				else{
					return "Factura " + self.facturaSeleccionada().fIndex().toString();
				}
			}
			catch(ex){
				return "Sin facturas" ; 
			}

		});
	self.totalDeposito = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.facturas().length; i++){
			var monto = parseFloat(self.facturas()[i].importeDepositados().replace(',', ''));
			var total  = total + monto; 
		}
		return (total).formatMoney(2,'.',',');
	});
	self.totalAbonos = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.abonos().length; i++){
			var monto = parseFloat(self.abonos()[i].importe().replace(',', ''));
			var total  = total + monto; 
		}
		return (total).formatMoney(2,'.',',');
	});
	self.totalDescuento = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.facturas().length; i++){
			var monto = parseFloat(self.facturas()[i].importeDescuentosPromotor().replace(',', ''));
			var total  = total + monto; 
		}
		return (total).formatMoney(2,'.',',');;
	});
	self.totalFacturas = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.facturas().length; i++){
			var monto = parseFloat(self.facturas()[i].datosGenerales().importeFactura().replace(',', ''));
			total = total + monto;
		}
		return (total).formatMoney(2,'.',',');
	});
	self.saldoFinal = ko.pureComputed(function() {
		var total=0;
		var totalFacturas = 0;
		var totalDepositos = 0;
		for(var i = 0; i < self.facturas().length; i++){
			var facturas = parseFloat(self.facturas()[i].datosGenerales().importeFactura().replace(',', ''));
			totalFacturas= totalFacturas + facturas;
			var depositos = parseFloat(self.facturas()[i].importeDepositados().replace(',', ''));
			totalDepositos  = totalDepositos + depositos; 
		}
		total  = (totalFacturas - totalDepositos); 
		return (total).formatMoney(2,'.',',');
	});
	self.plaza = ko.observable().extend({
    required: { message: "La plaza es requerida" }
	});
	self.sociedad = ko.observable().extend({
    required: { message: "La sociedad es requerida" }
	});
	self.cliente = ko.observable().extend({
    required: { message: "El cliente es requerido" }
	});
	self.autorizador = ko.observable();
	self.periodoInicio = ko.observable().extend({
        required: { params: true, message: 'Seleccione la fecha de inicio' }
    });
	self.periodoFin = ko.observable().extend({
        required: { params: true, message: 'Seleccione la fecha de vencimiento' }
    });
	self.estado = ko.observable().extend({
        required: { params: true, message: 'Seleccione el estado' }
    });;
	self.estadoNombre = ko.observable();
	self.comentarios = ko.observable();
	self.importeDepositado = ko.observable();
	self.importeFinanciado = ko.observable();
	self.importeDescuentosPromotor = ko.observable();
	self.financiamientoID = ko.observable(0);
	self.errors = ko.validation.group(self);

	self.nuevaFactura = function(){
		self.isLoading(true);
		self.saldoFinal();
		var fact = new Factura(); 
		self.facturasIndex(self.facturasIndex() + 1);
		fact.fIndex(self.facturasIndex());
		fact.nombre("Factura " + self.facturasIndex().toString());
		self.facturas.push(fact);
		self.facturaSeleccionada(fact);
		  $('#fecha_desc').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})
		   $('#fecha_nota').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})
	    $('#fecha_factura').datepicker({
	 	format: 'dd/mm/yyyy',
    	language: 'es',
    	clearBtn: true,
    	todayHighlight: true
    	})
    	$('#socFactura').selectpicker();
    	self.isLoading(false);

	}

	self.seleccionarFactura = function(){
		self.isLoading(true);
		self.saldoFinal();
		self.facturaSeleccionada(this);
		$('#panel_notas').hide();
		$('#panel_descuentos').hide();
		$('#panel_depositos').hide();
		 $('#cheques-table').bootstrapTable('destroy');
		 renderTable(self.facturaSeleccionada().depositosCliente().toModelCheques());
		 $('#promotor-table').bootstrapTable('destroy');
		 renderTableDescuento(self.facturaSeleccionada().descuentosPromotor().toModelDescuentos());
		 $('#notas-table').bootstrapTable('destroy');
		 renderTableNotas(self.facturaSeleccionada().notasCredito().toModelNotas());
		  $('#fecha_factura').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})
		 $('#fecha_cheque').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})
		  $('#fecha_factura').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})
		  $('#socFactura').selectpicker();
		  self.isLoading(false);
	}

	self.toModelAbonos = function(){
		var data = [];
		for( var i = 0; i < self.abonos().length; i++){
			data.push(self.abonos()[i].toModel());

		}
		return data;
	}

	self.agregarAbono = function(){
		self.abonoSeleccionado(new Abono());
		$('#agregar_abono').modal('show');
		$('#act_dep').hide();
		$('#buttons_nvo_dep').show();
		$('#importe_abono').mask('000,000,000,000,000.00', {reverse: true});
		 $('#fecha_abono').mask('00/00/0000');
		 $('#fecha_abono').datepicker({
		 	format: 'dd/mm/yyyy',
        	language: 'es',
        	clearBtn: true,
        	todayHighlight: true
    	})

	}

	self.nuevoAbono = function(){
		if($('#fecha_abono').val() != "" || $('#importe_abono').val() != "" || $('#importe_abono').val() != 0)
		{
			self.abonos.push(self.abonoSeleccionado());
			$('#agregar_abono').modal('hide');
			$('#panel_ab').hide();
			show_stack_bar_top('success','¡Deposito agregado!','El deposito se agrego correctamente.');
			abonosData = self.toModelAbonos();
			$('#abonos-table').bootstrapTable('destroy');
			renderTableAbonos(abonosData);
			self.esNuevo = true;
		}
		else
		{
			show_stack_bar_top('warning','¡Complete los campos!','La fecha y el importe son requeridos, complete los campos');

		}
 
	}; 
	self.editaFinan  = function(){
		self.isDisabled(false);
		show_stack_bar_top('info','¡Campos habilitados!','Ahora puede editar los datos del financiamiento, a excepcción de la <strong>plaza y la sociedad</strong> con que fue capturado');
	}; 
	self.editaFactura  = function(){
		self.facturaSeleccionada().datosGenerales().isDisabled(false);
		 show_stack_bar_top('info','¡Campos habilitados!','Ahora puede editar la factura');
	}; 

	self.toModel = function(){
		var facturasModel = [];
		for(var i = 0; i < self.facturas().length; i++){
			facturasModel.push(self.facturas()[i].toModel());
		}
		var abonosModel = [];
		for(var i = 0; i < self.abonos().length; i++){
			abonosModel.push(self.abonos()[i].toModel());
		}
		var financiamientoModel = {
			facturas: facturasModel,
			abonos: abonosModel,
			cliente: self.cliente(),
			plaza: self.plaza(),
			sociedad: self.sociedad(),
			autorizador: self.autorizador(),
			periodoInicio: self.periodoInicio(),
			periodoFin: self.periodoFin(),
			estado: self.estado(),
			estadoNombre: self.estadoNombre(),
			comentarios: self.comentarios(),
			totalAbonos : self.totalAbonos().replace(',', ''),
			totalDeposito : self.totalDeposito().replace(',', ''),
			totalFacturas : self.totalFacturas().replace(',', ''),
			totalDescuento : self.totalDescuento().replace(',', ''),
			idFin: self.financiamientoID(),
			nuevoFinanciamiento: self.esNuevo
		}

		return financiamientoModel;
	}

	
	self.cargarInfo = function(info){ 
		$('#myPleaseWait').modal('show');
		self.esNuevo = false;
		self.plaza(info.plaza);
		self.financiamientoID(info.idFin); 
		$('#cboPlaza').selectpicker('val', info.plaza);
		$('#cboPlaza').selectpicker('val', info.plaza);
		busqueda(); 
		self.sociedad(parseInt(info.sociedad));
		busqueda_cliente();
		self.cliente(info.cliente);
		self.autorizador(info.autorizador); 
		$('#cboCliente').selectpicker('val', parseInt(info.cliente));
		$('#cboCliente').prop('disabled', 'disabled');
		$('#autorizado').selectpicker('val', parseInt(info.autorizador));
		self.estado(info.estado);
		$('#edo_fin option[value="'+info.estado+'"]');
		self.comentarios(info.comentarios);
		self.periodoInicio(info.periodoInicio);
		$('#periodo_del').datepicker('remove');
		self.periodoFin(info.periodoFin);
		$('#periodo_al').datepicker('remove');
		self.estado(info.estado);
		for(var i = 0; i < info.facturas.length; i++){
			var fact = new Factura(info.facturas[i]);
			self.facturasIndex(self.facturasIndex() + 1);
			fact.fIndex(self.facturasIndex());
			fact.nombre("Factura " + self.facturasIndex().toString());
			self.facturas.push(fact); 
		}
		if(self.facturas().length > 0)
		{
			self.facturaSeleccionada(self.facturas()[0]);
			$('#panel_depositos').hide();
			$('#panel_descuentos').hide();
			$('#panel_notas').hide();
			renderTable(self.facturaSeleccionada().depositosCliente().toModelCheques());
			renderTableDescuento(self.facturaSeleccionada().descuentosPromotor().toModelDescuentos());
		 	renderTableNotas(self.facturaSeleccionada().notasCredito().toModelNotas());
		}

		self.isDisabled(true);
		$('#cboSociedad').prop('disabled', 'disabled');
		$('#cboPlaza').prop('disabled', 'disabled');
		$('#myPleaseWait').modal('hide');
		for(var i = 0; i < info.abonos.length; i++){
			var ab = new Abono(info.abonos[i]);
			self.abonos.push(ab); 
		}
		abonosData = self.toModelAbonos();
		$('#panel_ab').hide();
		$('#abonos-table').bootstrapTable('destroy');
		renderTableAbonos(abonosData);
		$('#socFactura').selectpicker();
	}

	self.guardarFinanciamiento = function(){
		//si no tiene errores de validacion mandamos la peticion
			if (self.errors().length == 0) {
				$('#myPleaseWait').modal('show');
             $.ajax({
		      data:
		      {
		      	datos: self.toModel(),
		      	descuentosEliminados: descuentosBorrar,
		      	depositosEliminados: depositosBorrar,
		      	abonosEliminados: abonosBorrar,
		      	chequesEliminados: chequesBorrar,
		      	notasEliminadas: notasBorrar,

		      },
		      type: "POST",
		      dataType: "text",
		      url: "ajax.php?c=financiamiento&f=guardaFinanciamiento",
		      success: function (data) {
		       if(data == "")
		       {
		       		$('#myPleaseWait').modal('hide');
		       	    location.reload();
		       	    show_stack_bar_top('success','¡FINACIAMIENTO GUARDADO!','El financiamiento ha sido guardado correctamente.');
		       }
		       else
		       {
		       		alert(data);
		       	    show_stack_bar_top('error','¡Error al guardar!','Ha ocurrido un error al guardar el financiamiento por favor intentelo de nuevo.');

		       }
		      }
		  });
        } else {
            this.errors().forEach(function(data) {
			self.errors.showAllMessages();
		});
            //self.errors.showAllMessages(true);
        }
		 
	}
   
	self.borrarFactura = function(){
		     var id = self.facturaSeleccionada().facturaID;
              $.confirm({
            text: "¿Esta seguro que desea eliminar la factura #"+id+" ?(Se eliminara toda la informacion que esta contenga)",
             confirmButton: "Si, Eliminar",
             cancelButton: "No",
            confirm: function() {
	           if(id > 0)
	           {
				// ajax a borrar factura
				 $strD = "id=" + id ;
	              $.ajax({
	                  data: $strD,
	                  type: "POST",
	                  dataType: "text",
	                  url: "ajax.php?c=financiamiento&f=elimina_factura",
	                  success:function ($databack){
	                    if($databack == 1)
	                    {
	                      self.facturas.remove(self.facturaSeleccionada());
						  self.facturaSeleccionada(self.facturas()[0])
	                      show_stack_bar_top('error','¡Factura Eliminada!','La factura #' + id + ' ha sido eliminada correctamente.');

	                    }
	                     if($databack != 1)
	                    {
	                      show_stack_bar_top('warning','¡Error!','Ha ocurrido un error al eliminar la factura, intentelo de nuevo');

	                    }
	                  }
	              })
			}
			else
			{
			    self.facturas.remove(self.facturaSeleccionada());
				self.facturaSeleccionada(self.facturas()[0])
			}
		},
       	cancel: function() {

            }
			});
		
	}
  
  	renderTableAbonos = function(info){
		$('#abonos-table').bootstrapTable({
			data: info,
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
		    resizable:false,

		    columns: [
		    {
		        field: 'idDeposito',
		        title: 'Id',
		        visible: false
		    },
		    {
		        field: 'fecha',
		        title: 'Fecha'
		    },
		     {
		        field: 'importe',
		        title: 'Deposito',
		    },
		    {
		        field: 'observaciones',
		        title: 'Observaciones'
		    },
		   {
		    field: 'Acciones',
		    title: 'Acciones',
		    align: 'center',
		    valign: 'middle',
		    clickToSelect: false,
		    formatter: AccionesDeposito,
		    events: EventosDeposito
		    }
		]});
	}
	//render de la tabla de depositos o cheques a facturas
	renderTable = function(info){
		$('#cheques-table').bootstrapTable({
			data: info,
		    cache: false,
		    height: 600,
		    striped: true,
		    pagination: true,
		    pageSize: 50,
		    pageList: [10, 25, 50, 100, 200],
		    search: true,
		    showColumns: true,
		    minimumCountColumns: 2,
		    clickToSelect: false,
		    resizable:false,

		    columns: [
		    {
		        field: 'idDeposito',
		        title: 'Id',
		        visible: false
		    },
		    {
		        field: 'tipo_nombre',
		        title: 'Movimiento'
		    },
		     {
		        field: 'tipo_pago',
		        title: 'tipo',
		        visible: false
		    },
		    {
		        field: 'folioCheque',
		        title: 'Folio'
		    },
		    {
		        field: 'fecha',
		        title: 'Fecha'
		    },
		    {
		        field: 'sociedadNombre',
		        title: 'Sociedad'
		    },
		    {
		        field: 'estadoNombre',
		        title: 'Estado'
		    },
		    {
		        field: 'importe',
		        title: 'Importe'
		    },
		    {
		        field: 'observaciones',
		        title: 'Observaciones'
		    },

		   {
		    field: 'Acciones',
		    title: 'Acciones',
		    align: 'center',
		    valign: 'middle',
		    clickToSelect: false,
		    formatter: AccionesCheque,
		    events: EventosCheque
		    }]});
	}
		//tabla de notas de credito
	renderTableNotas = function(datos){
		$('#notas-table').bootstrapTable({
		data: datos,
        cache: false,
        height: 600,
        striped: true,
        pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        search: true,
        showColumns: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        resizable:false,
        columns: [
        {
            field: 'idNota',
            title: 'id',
            visible: false
        },
        {
            field: 'folio',
            title: 'Folio'
        },
        {
            field: 'fecha_nota',
            title: 'Fecha'
        },
        {
            field: 'importe_nota',
            title: 'Importe'
        },
        {
            field: 'pagadoraNombre',
            title: 'Pagadora'
        },
        {
            field: 'estadoNombre',
            title: 'Estado'
        },
        {
            field: 'obs_nota',
            title: 'Observaciones'
        },

       {
        field: 'Acciones',
        title: 'Borrar',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: AccionesNota,
        events: EventosNota
        //events: operateEvents
        }
        ]
    });
	}
	renderTableDescuento = function(info){
		$('#promotor-table').bootstrapTable({
		data: info,
        cache: false,
        height: 600,
        striped: true,
        pagination: true,
        pageSize: 50,
        pageList: [10, 25, 50, 100, 200],
        search: true,
        showColumns: true,
        minimumCountColumns: 2,
        clickToSelect: false,
        resizable:false,
        columns: [
        {
            field: 'idDescuento',
            title: 'id',
            visible: false
        },
        {
            field: 'promotorNombre',
            title: 'Promotor'
        },
        {
            field: 'fecha_desc',
            title: 'Fecha'
        },
        {
            field: 'estadoNombre',
            title: 'Estado'
        },
        {
            field: 'observaciones',
            title: 'Observaciones'
        },
        {
            field: 'importe_desc',
            title: 'Importe'
        },

       {
        field: 'Acciones',
        title: 'Acciones',
        align: 'center',
        valign: 'middle',
        clickToSelect: false,
        formatter: FormatterAccionesDesc,
        events: tablaDescuentosEvents
        //events: operateEvents
        }
        ]
    });
	} 

	self.cargarFinanciamiento = (function(){
		 $.ajax({
		      type: "GET",
		      dataType: "text",
		      url: "ajax.php?c=financiamiento&f=datosFinanciamiento",
		      success: function (data) {
		      	if(data != "" || data != null || data != undefined)
		      	{
			      	var financiamiento = JSON.parse(data);
			      	self.cargarInfo(financiamiento);
			    }
		      } 
		  });
	}); 

	self.cargarFinanciamiento(); 
}