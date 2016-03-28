// initialize with defaults
 $("#fileToUpload").fileinput({
        showUpload: true,
        allowedFileExtensions: ['xls', 'xlsx', 'csv'],
        elErrorContainer: '#errorBlock',
        language: 'es',
    });

$('#upload').submit(function(e){
	 $(this).ajaxSubmit({
	 	data:{
	 		plaza: document.getElementById("cboPlaza").value,
	 		soc: document.getElementById("cboSociedad").value,
	 		cuenta: document.getElementById("cboCuenta").value
	 	},
        target: '#resultados'
	});

	    e.preventDefault();
      $('#table-movimientos').bootstrapTable('refresh', {silent: true });
	   $('#fileToUpload').fileinput('clear');
	 importe_cargos();
	 importe_abonos();
	 calcula_saldo();
}); 
