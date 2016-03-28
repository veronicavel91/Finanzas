var Descuento = function(data) {
	
	var self = this;
	self.esNuevo = true;
	if(data == null || data == undefined){
		data = {
			idDescuento: 0,
			promotor: 0,
			promotorNombre: "",
			importe_desc: "0.00",
			edo_desc: "",
			estadoNombre: "",
			observaciones: "",
			fecha_desc: "",
		}
		self.esNuevo = true;
	}
	else
	{
		self.esNuevo = false;
	}
	self.idDescuento = ko.observable(data.idDescuento);
	self.promotor = ko.observable(data.promotor);
	self.importe_desc = ko.observable(data.importe_desc);
	self.edo_desc = ko.observable(data.edo_desc);
	self.fecha_desc = ko.observable(data.fecha_desc);
	self.observaciones = ko.observable(data.observaciones);
	self.estadoNombre = ko.observable(data.estadoNombre);
	self.promotorNombre = ko.observable(data.promotorNombre);
	
    self.toModel = function () {
		data = {
			idDescuento: self.idDescuento(),
			promotor: self.promotor(),
			importe_desc: self.importe_desc().replace(',', ''),
			edo_desc: self.edo_desc(),
			fecha_desc: self.fecha_desc(),
			observaciones: self.observaciones(),
			promotorNombre: self.promotorNombre(),
			estadoNombre: self.estadoNombre(),
			nuevoDesc: self.esNuevo
		}
	    return data;
    }

}