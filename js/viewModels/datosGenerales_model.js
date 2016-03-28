var DatosGenerales = function(data) {
	
	var self = this;
	self.isDisabled = ko.observable(false);
	if(data == null || data == undefined){
		data = {
			folioFactura: 0,
			folioKid: 0,
			socFactura: 0,
			importeFactura: "0.00",
			estadoFactura: "",
			fechaFactura:"",
			nombreFactura:"",
			observaciones:"",
		}
		self.isDisabled(false);
	}
	else
	{
		self.isDisabled(true);
	}
	
	self.folioFactura = ko.observable(data.folioFactura);
	self.folioKid = ko.observable(data.folioKid);
	self.socFactura = ko.observable(data.socFactura);
	self.importeFactura = ko.observable(data.importeFactura).extend({ notEqual: "0.00" });
	self.estadoFactura = ko.observable(data.estadoFactura);
	self.fechaFactura = ko.observable(data.fechaFactura);
	self.nombreFactura = ko.observable(data.nombreFactura);
	self.observaciones = ko.observable(data.observaciones);

}