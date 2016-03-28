$(document).ready(function() {
    show_stack_bar_top('warning','¡Atencion!','Actualmente solo se encuentra habilitada la opción <strong>reporte por grupo</strong>');
       $('#periodo_del').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
        $('#periodo_al').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        clearBtn: true,
        todayHighlight: true
    })
    $('#periodo_del').mask('00/00/0000');
    $('#periodo_al').mask('00/00/0000');
});
function reporte_grupo()
    {

        if(document.getElementById("cboPlaza").value=="00" || document.getElementById("cboSociedad").value=="00" || $('#cboGrupo').val()== "" || $('#cboFormato').val()== "")
        {
            show_stack_bar_top('warning','¡Atencion!','Para generar el archivo es necesario completar todos los campos');

        }
        else
        {
            window.location="/systema/finanzas/ajax.php?c=reportes&f=reporte_grupo&plaza=" + $('#cboPlaza').val() + "&soc=" +  $('#cboSociedad').val() + "&gpo=" + $('#cboGrupo').val() + "&fto=" + $('#cboFormato').val() + "&f1=" + $('#periodo_del').val() + "&f2=" + $('#periodo_al').val() ;
        }
    }
