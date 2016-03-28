var DepositosCliente = function(data) {
	
	var self = this;

	self.cheques = ko.observableArray([]);
	self.chequeSeleccionado = ko.observable();
	if(data == null ||  data == undefined){
		self.chequeSeleccionado(new Cheque());
	}
	else{
		for(var i = 0; i < data.cheques.length; i++){
			self.cheques.push(new Cheque(data.cheques[i]));
		}
		self.chequeSeleccionado(new Cheque(data.cheques[0]));
	}

	self.toModelCheques = function(){
		var data = [];
		for( var i = 0; i < self.cheques().length; i++){
			data.push(self.cheques()[i].toModel())

		}
		return data;
	} 
	self.agregarCheque = function(){
			
				self.chequeSeleccionado(new Cheque());
				$('#agregar_cheque').modal('show');
				$('#act').hide();
				$('#buttons_agrega_cheq').show();
				$('.selectpicker').selectpicker();
				$('#fecha_cheque').datepicker({
		        format: 'dd/mm/yyyy',
		        language: 'es',
		        clearBtn: true,
		        todayHighlight: true
    			})
	}
	self.nuevoCheque = function(){
		if ($('#imp_cheque').val()=="0.00"  || $('#imp_cheque').val()=="" || $('#tipo_pago').val()=="" || $('#soc_cheque').val()=="" || $('#edo_abono').val()=="") {
           show_stack_bar_top('warning','¡Datos incompletos!','Favor de completar la información, para poder agregar el movimiento correctamente.');

		}else {
			$('#panel_depositos').hide();
			self.chequeSeleccionado().sociedadNombre($('#soc_cheque option:selected').html());
			self.chequeSeleccionado().tipo_nombre($('#tipo_pago option:selected').html());
			self.chequeSeleccionado().estadoNombre($('#edo_abono option:selected').html());
			self.cheques.push(self.chequeSeleccionado());
			$('#agregar_cheque').modal('hide');
			depositosData = self.toModelCheques();
			$('#cheques-table').bootstrapTable('destroy');
			show_stack_bar_top('success','¡Exitoso!','El <strong>'+ $('#tipo_pago option:selected').html() +' </strong>ha sido agregado correctamente');
			renderTable(self.toModelCheques());
			self.esNuevo = true;

		}
 
	};


   
}