var NotasCredito = function(data) {
	
	var self = this;
	self.notas = ko.observableArray([]);
	self.notaSeleccionada = ko.observable();

	if(data == null ||  data == undefined){
		self.notaSeleccionada(new Nota());
	}
	else{
		for(var x = 0; x < data.notas.length; x++){
			self.notas.push(new Nota(data.notas[x]));
		}
		self.notaSeleccionada(new Nota(data.notas[0]));
	}

	self.toModelNotas = function(){
		var data = [];
		for( var i = 0; i < self.notas().length; i++){
			data.push(self.notas()[i].toModel())
		}
		return data;
	} 

	self.agregarNota = function(){
		self.notaSeleccionada(new Nota());
		$('#agregar_nota').modal('show');
		$('#act_nota').hide();
		$('#buttons-nota').show();
		$('#fecha_nota').datepicker({
		        format: 'dd/mm/yyyy',
		        language: 'es',
		        clearBtn: true,
		        todayHighlight: true
    			})
	}
	self.nuevaNota = function(){
		if ($('#importe_nota').val()=="0.00"  || $('#importe_nota').val()=="" || $('#estado_nota').val()=="") {
           show_stack_bar_top('warning','¡Datos incompletos!','Favor de completar la información, para poder agregar el movimiento correctamente.');

		}else {
			$('#panel_notas').hide();
			self.notaSeleccionada().estadoNombre($('#estado_nota option:selected').html());
			self.notaSeleccionada().pagadoraNombre($('#pagadora option:selected').html());
			self.notas.push(self.notaSeleccionada());
			$('#agregar_nota').modal('hide');
			notasData = self.toModelNotas();
			show_stack_bar_top('success','¡Nota agregada!','La nota de credito ha sido AGREGADA, los cambios se guardaran hasta que presione el boton Guardar');
			$('#notas-table').bootstrapTable('destroy');
			renderTableNotas(self.toModelNotas());
		}
	};



   
}