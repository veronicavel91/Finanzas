var Cheque = function(data) {
	
	var self = this;
	self.esNuevo = true;

	if(data == null || data == undefined){// comienza bindeando el html del modal, ps ya esta segun, ya lo teniamos bindeado
		data = {
			idDeposito: 0,
			folioCheque: 0,
			fecha: "",
			sociedad: "",
			sociedadNombre: "",
			fecha: "",
			estado: "",
			estadoNombre: "",
			importe: "0.00",
			observaciones: "",
			tipo_pago: 0,
			tipo_nombre: "",
		}
	self.esNuevo = true;
	}
	else
	{
		self.esNuevo = false;
	}
	self.idDeposito = ko.observable(data.idDeposito);
	self.folioCheque = ko.observable(data.folioCheque);
	self.fecha = ko.observable(data.fecha);
	self.sociedad = ko.observable(data.sociedad);
	self.sociedadNombre = ko.observable(data.sociedadNombre);
	self.estadoNombre = ko.observable(data.estadoNombre);
	self.estado = ko.observable(data.estado);
	self.importe = ko.observable(data.importe);
	self.observaciones = ko.observable(data.observaciones); 
	self.tipo_pago = ko.observable(data.tipo_pago); 
	self.tipo_nombre = ko.observable(data.tipo_nombre); 

	
    self.toModel = function () {
		data = {
			idDeposito: self.idDeposito(),
			folioCheque: self.folioCheque(),
			fecha: self.fecha(),
			sociedad: self.sociedad(),
			sociedadNombre: self.sociedadNombre(),
			estado: self.estado(),
			estadoNombre: self.estadoNombre(),
			importe: self.importe().replace(',', ''),
			observaciones: self.observaciones(), 
			tipo_pago: self.tipo_pago(),
			tipo_nombre: self.tipo_nombre(), 
			nuevoCheque: self.esNuevo
		}
	    return data;
    }

}