var DescuentosPromotor = function(data) {
	
	var self = this;

	self.descuentos = ko.observableArray([]);
	self.descuentoSeleccionado = ko.observable();

	if(data == null ||  data == undefined ){
		self.descuentoSeleccionado(new Descuento());
	}
	else{
		for(var x = 0; x < data.descuentos.length; x++){
			self.descuentos.push(new Descuento(data.descuentos[x]));
		}
		self.descuentoSeleccionado(new Descuento(data.descuentos[0]));
	}

	self.toModelDescuentos = function(){
		var data = [];
		for( var i = 0; i < self.descuentos().length; i++){
			data.push(self.descuentos()[i].toModel())

		}
		return data;
	} 

	self.agregarDescuento = function(){
		self.descuentoSeleccionado(new Descuento());
		$('#act').hide();
		$('#buttons_agrega_cheq').show();
		$('#agregar_descuento').modal('show');
		$('#act_desc').hide();
		$('#buttons-desc').show();
		$('.selectpicker').selectpicker();
		$('#fecha_desc').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })

	}
	self.nuevoDescuento = function(){
		if ($('#importe_desc').val()=="0.00"  || $('#importe_desc').val()=="" || $('#edo_desc').val()=="") {
           show_stack_bar_top('warning','¡Datos incompletos!','Favor de completar la información, para poder agregar el movimiento correctamente.');

		}else {
			$('#panel_descuentos').hide();
			self.descuentoSeleccionado().estadoNombre($('#edo_desc option:selected').html());
			self.descuentoSeleccionado().promotorNombre($('#promotor option:selected').html());
			self.descuentos.push(self.descuentoSeleccionado());
			$('#agregar_descuento').modal('hide');
			descuentosData = self.toModelDescuentos();
			show_stack_bar_top('success','¡Exitoso!','El descuento al promotor <strong style="font-size:1.2em">'+ $('#promotor option:selected').html()+' </strong>ha sido guardado');
			$('#promotor-table').bootstrapTable('destroy');
			renderTableDescuento(self.toModelDescuentos());
		}
	};
	



   
}