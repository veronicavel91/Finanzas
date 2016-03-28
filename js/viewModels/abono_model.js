var Abono = function(data) {
	
	var self = this;
	self.esNuevo = true;

	if(data == null || data == undefined){
		data = {
			idDeposito: 0,
			importe: 0.00,
			fecha: "",
			observaciones: "",
		}
		self.esNuevo = true;
	}
	else
	{
		self.esNuevo = false;
	}
	self.idDeposito = ko.observable(data.idDeposito);
	self.importe = ko.observable(data.importe).extend({
    required: { message: "El importe es requerido" }
	});
	self.fecha = ko.observable(data.fecha).extend({
    required: { message: "Ingrese la fecha del deposito" }
	});
	self.observaciones = ko.observable(data.observaciones);

	
    self.toModel = function () {
		var abono = {
			idDeposito: self.idDeposito(),
			importe: self.importe(),
			fecha: self.fecha(),
			fecha: self.fecha(),
			observaciones: self.observaciones(),
			nuevoAbono: self.esNuevo
		}
	    return abono;//cual es el pedo? ps este
    }

}