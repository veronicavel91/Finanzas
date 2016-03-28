var Nota = function(data) {
	
	var self = this;
	self.esNueva = true;
	if(data == null || data == undefined){
		data = {
			idNota: 0,
			folio: 0,
			importe_nota: "0.00",
			pagadora: "",
			pagadoraNombre: "",
			estado_nota: "",
			obs_nota: "",
			fecha_nota: "",
			estadoNombre: "",
		}
		self.esNueva = true;
	}
	else
	{
		self.esNueva = false;
	}
	self.idNota = ko.observable(data.idNota);
	self.folio = ko.observable(data.folio);
	self.importe_nota = ko.observable(data.importe_nota);
	self.pagadora = ko.observable(data.pagadora);
	self.pagadoraNombre = ko.observable(data.pagadoraNombre);
	self.estado_nota = ko.observable(data.estado_nota);
	self.obs_nota = ko.observable(data.obs_nota);
	self.fecha_nota = ko.observable(data.fecha_nota);
	self.estadoNombre = ko.observable(data.estadoNombre);

	
    self.toModel = function () {
		data = {
			idNota: self.idNota(),
			folio: self.folio(),
			importe_nota: self.importe_nota(),
			pagadora: self.pagadora(),
			pagadoraNombre: self.pagadoraNombre(),
			estado_nota: self.estado_nota(),
			obs_nota: self.obs_nota(),
			fecha_nota: self.fecha_nota(),
			estadoNombre: self.estadoNombre(),
			nuevaNota: self.esNueva

		}
	    return data;
    }

}