var AbonosFinanciamiento = function(data) {
	var self = this;
	self.esNuevo = true;
	if(data == null || data == undefined || data == ""){
		self.abonos = ko.observableArray([]);
		self.abonoSeleccionado = ko.observable();
		if(data == null ||  data == undefined){
			self.abonoSeleccionado(new Abono());
		}
		else{
			for(var i = 0; i < data.cheques.length; i++){
				self.abonos.push(new Abono(data.abonos[i]));
			}
			self.abonoSeleccionado(new Cheque(data.abonos[0]));
		}
	self.totalDeposito = ko.observable(0);

	self.toModelAbonos = function(){
			var data = [];
			for( var i = 0; i < self.abonos().length; i++){
				data.push(self.abonos()[i].toModel())

			}
			return data;
	} 
	self.agregarAbono = function(){
			
		self.abonoSeleccionado(new Abono());
		$('#agregar_abono').modal('show');
	}
	self.nuevoAbono = function(){
			self.abonos.push(self.abonoSeleccionado());
			abonosData = self.toModelAbonos();
			$('#abonos-table').bootstrapTable('destroy');
			renderTableAbonos(self.toModelAbonos());
			self.esNuevo = true;
		//}
 
	};

}