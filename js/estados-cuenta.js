  $(document).ready(function() {
     $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });
    var anio = $('#anio').val();
    $('.selectpicker').val(anio);
    $('.selectpicker').selectpicker('render');
//$('.selectpicker').selectpicker('refresh');
     $(document).on('hide.bs.modal','#upload_file', function () {
         $('#myPleaseWait').modal('show');

         location.reload(); 
        
       })
});
 $("#fileToUpload").fileinput({
        showUpload: true,
        allowedFileExtensions: ['pdf'],
        elErrorContainer: '#errorBlock',
        language: 'es',
    });
//subir el estado de cuenta
$('#upload').submit(function(e){
    $(this).ajaxSubmit({
        data:{
            cuenta: $('#cta').val(),
            anio: $('#anio').val()
        },
        target: '#resultados'
    });
    e.preventDefault();
   $('#fileToUpload').fileinput('clear');
});
function busca_mes(){ 
        $strD = "cta=" + $('#cta').val()+"&anio="+ $('#cboanio').val();
         $("#cboMes").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_meses",
            success:function ($databack){
               $("#cboMes").html($databack);
               $('#cboMes').selectpicker('refresh');
        
            }
        })
    };
function modal_estado()
{
    $('#upload_file').modal('show');
    busca_mes();
}; 
function showTable()
{
    $('#table-estados').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_estados&cta=' + $('#cta').val()+"&anio="+ $('#cboanio').val()});
};
 

$('#upload_file').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var mesId = $(e.relatedTarget).data('mes-id');

    //populate the textbox
    $(e.currentTarget).find('input[name="mesId"]').val(mesId);
});
function cambia_año()
{
    $('#myPleaseWait').modal('show');
    window.location.href = '/systema/finanzas/index.php?c=cuentas&f=get_estados&cta='+$('#cta').val()+'&anio='+$('#cboanio').val();
}