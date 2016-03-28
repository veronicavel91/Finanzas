
$(document).ready(function() {
    $('#imp_dep').mask('000,000,000,000,000.00', {reverse: true});
});
$('#entrega_cta').submit(function(e){
     if(document.getElementById("cboPlaza").value=="00" || document.getElementById("cboSociedad").value=="00" || document.getElementById("cboCuenta").value=="" || $('#solicitante').val()== ""|| $('#att').val()== "")
        {
            show_stack_bar_top('warning','¡Atencion!','Para generar el archivo es necesario completar todos los campos');

        }
        else
        {
            var checked = [];
            // Loop de los checkbox
            $('input:checkbox:checked').each(function() {
                checked.push( $(this).next('span').text() );
            });
            $(this).ajaxSubmit({
        data:{
                ent: checked
            },
            success: function(data) {
                window.open(data, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");
            },
            });
            e.preventDefault();
        }
}); 
$('#cancela_act').submit(function(e){
     if(document.getElementById("plaza_form").value=="" || document.getElementById("cboFormato").value==""|| document.getElementById("soc_form").value=="" ||document.getElementById("plaza_form").value=="00" || document.getElementById("soc_form").value=="00" || document.getElementById("banco_form").value=="" || document.getElementById("cuenta_form").value=="" )
        {
            show_stack_bar_top('warning','¡Atencion!','Para generar el archivo los campos plaza, sociedad,cuenta,banco y formato son requeridos');

        }
        else
        {
            $(this).ajaxSubmit({
                    success: function(data) {
                        window.open(data, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");
                        $.confirm({
                        text: "¿Desea enviar por correo el archivo"+data+"? ",
                         confirmButton: "Si, Enviar",
                         cancelButton: "No",
                        confirm: function() {
                            $strD = "arch=" + data + "&cta=" + $('#cuenta_form').val() + "&pza=" + $('#plaza_form').val() + "&soc=" + $('#soc_form').val() ;
                            $.ajax({
                            data: $strD,
                            type: "POST",
                            dataType: "text",
                            url: "ajax.php?c=reportes&f=mail_reporte_estado",
                            success:function ($databack){
                              if($databack == 1)
                              {
                                show_stack_bar_top('success','¡Correo enviado!','El archivo ha sido enviado exitosamente.');
                              }
                              else
                              {
                                show_stack_bar_top('error','¡Error!','Ha ocurrido un error al enviar el archivo, error:' + $databack);
                              }
                           }
                        }) 

                            },
                        cancel: function() {

                        }
                      });  
                    },
            });
            e.preventDefault();
        }
});
function busca_cta_cheq(){ 
        $strD = "plaza=" + $('#plaza_cheq').val() + "&soc=" + $('#soc_cheq').val()+ "&banco=" + $('#banco_cheq').val();
         $("#cuenta_cheq").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=filtra_cuentas_banco",
            success:function ($databack){
               $("#cuenta_cheq").html($databack);
               $('#cuenta_cheq').selectpicker('refresh');
        
            }
        })
    }; 
function busca_cta_dat(){ 
        $strD = "plaza=" + $('#plaza_dat').val() + "&soc=" + $('#soc_dat').val()+ "&banco=" + $('#banco_dat').val();
         $("#cuenta_dat").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=filtra_cuentas_banco",
            success:function ($databack){
               $("#cuenta_dat").html($databack);
               $('#cuenta_dat').selectpicker('refresh');
        
            }
        })
    }; 
$('#FormChequera').submit(function(e){
     if(document.getElementById("plaza_cheq").value=="00" || document.getElementById("soc_cheq").value=="00" || document.getElementById("cuenta_cheq").value=="" || $('#entregar_cheq').val()== "" || $('#banco_cheq').val()== "" || $('#ife_cheq').val()== "" || $('#rep_legal').val()== "" || $('#firmante2').val()== "" )
        {
            show_stack_bar_top('warning','¡Atencion!','Para generar el archivo es necesario completar todos los campos(*)');

        }
        else
        {
            $(this).ajaxSubmit({
            success: function(data) {
                window.open(data, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");
            },
            });
            e.preventDefault();
        }
}); 
$('#formatoDatos').submit(function(e){
     if(document.getElementById("plaza_dat").value=="00" || document.getElementById("soc_dat").value=="00" || document.getElementById("cuenta_dat").value=="" || $('#fto_datos').val()== "" || $('#banco_dat').val()== "" || $('#firm_dat').val()== "" )
        {
            show_stack_bar_top('warning','¡Atencion!','Para generar el archivo es necesario completar todos los campos(*)');

        }
        else
        {
            // Loop de los checkbox
            $(this).ajaxSubmit({
            success: function(data) {
                window.open(data, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");
            },
            });
            e.preventDefault();
        }
}); 