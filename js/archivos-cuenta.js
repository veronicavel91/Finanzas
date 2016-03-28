$(document).ready(function() {
    $('.selectpicker').selectpicker();
     $('#table-archivos').bootstrapTable({
            method: 'get',
            url: 'ajax.php?c=cuentas&f=busca_archivos&cuenta='+ $('#cboCuenta').val(),
            cache: false,
            height: 900,
                field: 'id',
                title: 'Id',
            clickToSelect: true,
            columns: [{
            minimumCountColumns: 2,
            pageList: [10, 25, 50, 100, 200],
            pageSize: 200,
            pagination: true,
            search: true,
            showColumns: true,
            showRefresh: true,
            striped: true,
            width: 1900,
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'org_nom',
                title: 'Archivo',
                align: 'center',
                valign: 'middle',
                sortable: true,
                visible: false
            },
             {
                field: 'n_nombre',
                title: 'archivo',
                align: 'center',
                valign: 'middle',
                sortable: true,
            },
            {
                field: 'tipo',
                title: 'Tipo',
                align: 'center',
                valign: 'middle',
                sortable: true,
            },
            {
                field: 'titulo',
                title: 'Titulo',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'desc',
                title: 'Descripción',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'act',
                title: 'Actualización',
                align: 'center',
                valign: 'middle',
                sortable: true
            },
            {
                field: 'Acciones',
                title: 'Acciones',
                align: 'center',
                valign: 'middle',
                clickToSelect: false,
                formatter: FormatterAcciones,
                events: operateEvents
            }
            ]
        });
 }); 
 function busqueda(){ 
       // $('#myModal').modal('show'); 
       $('#loader').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboSociedad").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader').hide();
               $("#cboSociedad").html($databack);
               $('#cboSociedad').selectpicker('refresh');
        
            }
        })
    }; 
  
//funcion para ver los datos de la cuenta
  function modalDatos(id)
    {
        window.location="/systema/finanzas/index.php?c=cuentas&f=datos_cuenta&id="+id;
      
    }
     //muestra el modal para eliminar el registro
  self.modalBorrar = function(id)
    {
        $('#borrar').modal('show');
        $('#id_file').val(id);
        
    }
    function borrarFile()
    {
       $('#datos-form2').hide('fast');
          $('#load2').show('fast');
          $strD = "id=" + $('#id_file').val();
          $.ajax({
              data: $strD,
              type: "POST",
              dataType: "text",
              url: "ajax.php?c=cuentas&f=borrar_archivo",
              success: function (data) {

                if(data.trim()==1) {
                    $('#load2').hide();
                    $('#buttons2').hide();
                    $('#btnok2').show();
                    $('.preg').hide();
                    $('#ok2').show();
                    $('#table-archivos').bootstrapTable('refresh', {silent: true });
                    }else{
                    alert('Lo sentimos, ha ocurrido un error, el archivo no ha podido ser eliminado');
                }
              }
          });
    }

function showTable() 
{
    $('#table-archivos').bootstrapTable('refresh', {url: 'ajax.php?c=cuentas&f=busca_archivos&cuenta='+ $('#cboCuenta').val() });
     
}
function FormatterAcciones(values, row) {
        return [
               '<button class="btn btn-danger btn-xs btn-borrar" style="margin-right:4%;"><i class="fa fa-trash"></i></button>'
        ].join('');
    }
//eventos de la bootstrap table
  window.operateEvents = {
        'click .btn-borrar': function (e, value, row, index) {
            //el objeto row es el que nos trae toda la info del objeto
            self.modalBorrar(row.id);
        }
    };
      function aceptar_borrar()
    {
        $('#buttons2').show();
        $('#btnok2').hide();
        $('#ok2').hide();
        $('#datos-form2').show();
        $('#borrar').modal('hide');
    }
    // initialize with defaults
 $("#fileToUpload").fileinput({
        showUpload: true,
        elErrorContainer: '#errorBlock',
        language: 'es',
    });

$('#upload').submit(function(e){
     $(this).ajaxSubmit({
        target: '#resultados'
    });

        e.preventDefault();
       $('#fileToUpload').fileinput('clear');
       $('#table-archivos').bootstrapTable('refresh', {silent: true });
}); 
function asigna_cta()
{
    var cta= $('#cboCuenta').val();
    $('#cuenta').val(cta);
}
