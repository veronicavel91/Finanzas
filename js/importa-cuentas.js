  // initialize with defaults
 $("#fileToUpload").fileinput({
        showUpload: true,
        allowedFileExtensions: ['xls', 'xlsx', 'csv', 'xl'],
        elErrorContainer: '#errorBlock',
        language: 'es',
    });

$('#upload').submit(function(e){
    $('#myPleaseWait').modal('show');
     $(this).ajaxSubmit({
        target: '#resultados',
        success: hideEsperar 
    }
    );
        e.preventDefault();
        
}); 

function hideEsperar()
{
     $('#myPleaseWait').modal('hide');
}