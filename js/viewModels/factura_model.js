var Factura = function(data) {
	var self = this;
	self.nombre= ko.observable("");
	self.esNueva = true;
	self.isDisabled = ko.observable(false);
	if(data == null || data == undefined || data == ""){
		data = {
			facturaID: 0,
			datosGenerales: new DatosGenerales(),
			depositosCliente: new DepositosCliente(),
			descuentosPromotor: new DescuentosPromotor(),
			notasCredito: new NotasCredito(),
		}
		self.esNueva = true;
		self.isDisabled(false);	
	}
	else{
		self.isDisabled(true);
		data['datosGenerales'] = new DatosGenerales(data);
		data['depositosCliente'] = new DepositosCliente(data);
		data['descuentosPromotor'] = new DescuentosPromotor(data);
		data['notasCredito'] = new NotasCredito(data);
		self.esNueva = false;
	}
	self.fIndex = ko.observable(1);
	self.facturaID = data.facturaID;
	self.datosGenerales = ko.observable(data.datosGenerales);
	self.descuentosPromotor = ko.observable(data.descuentosPromotor);
	self.depositosCliente = ko.observable(data.depositosCliente);
	self.notasCredito = ko.observable(data.notasCredito);
	self.descuentosEliminados = [];
	self.importeDescuentosPromotor = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.descuentosPromotor().descuentos().length; i++){
			var monto = parseFloat(self.descuentosPromotor().descuentos()[i].importe_desc().replace(',', ''))
			var total  = total + monto; 
		}
		return (total).formatMoney(2,'.',',');
	});
	self.importeDepositados = ko.pureComputed(function() {
		var total = 0;
		for(var i = 0; i < self.depositosCliente().cheques().length; i++){
			var monto = parseFloat(self.depositosCliente().cheques()[i].importe().replace(',', ''))
			total = total + monto;
		}
		return (total).formatMoney(2,'.',',');
	});
	self.saldoFactura = ko.pureComputed(function() {
		var total = 0;
		var fact=parseFloat(self.datosGenerales().importeFactura().replace(',', ''));
		var dep= parseFloat(self.importeDepositados().replace(',', ''));
		total= (fact-dep);
		return (total).formatMoney(2,'.',',');
	});
	self.totalNotas = ko.pureComputed(function() {
		var total_nota = 0;
		for(var i = 0; i < self.notasCredito().notas().length; i++){
			var monto_nota = parseFloat(self.notasCredito().notas()[i].importe_nota().replace(',', ''))
			total_nota = total_nota + monto_nota;
		}
		return (total_nota).formatMoney(2,'.',',');
	});
	self.totalImporte = ko.pureComputed(function() {
		var imp = parseFloat(self.datosGenerales().importeFactura().replace(',', ''));
		return imp.formatMoney(2,'.',',');
	});

	self.toModel = function(){
		var facturaModel = {
			facturaID: self.facturaID,
			folioFactura: self.datosGenerales().folioFactura(),
			folioKid: self.datosGenerales().folioKid(),
			socFactura: self.datosGenerales().socFactura(),
			importeFactura: parseFloat(self.datosGenerales().importeFactura().replace(',', '')),
			fechaFactura: self.datosGenerales().fechaFactura(),
			estadoFactura: self.datosGenerales().estadoFactura(),
			nombreFactura: self.datosGenerales().nombreFactura(),
			observaciones: self.datosGenerales().observaciones(),
			cheques: self.depositosCliente().toModelCheques(),
			importeDepositado: parseFloat(self.importeDepositados().replace(',', '')),
			importeDescuentosPromotor: parseFloat(self.importeDescuentosPromotor().replace(',', '')),
			descuentosPromotor: self.descuentosPromotor().toModelDescuentos(),
			notasCredito: self.notasCredito().toModelNotas(),
			nuevaFactura: self.esNueva,
			descuentosEliminados: self.descuentosEliminados

		}
		return facturaModel;
	} 

}