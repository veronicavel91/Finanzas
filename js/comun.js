  Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
   function priceFormatter(value) {
           // 16777215 == ffffff in decimal
         if(value == "0.00")
        {
	        var color = '#6cfed';
        }
        else{
        	 var color = '#9B2727';
        }
           return '<div  style="color: ' + color + '">' +
	                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
	                value +
	                '</strong></div>';
    }
    function financiadoFormatter(value) {
           // 16777215 == ffffff in decimal
        var color = '#2278A4';
        return '<div  style="color: ' + color + '">' +
                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
                value +
                '</strong></div>';
    }
     function depositoFormatter(value) {
           // 16777215 == ffffff in decimal
        var color = '#1F6D51';
        return '<div  style="color: ' + color + '">' +
                '<i class="glyphicon glyphicon-usd"></i><strong>' + 
                value +
                '</strong></div>';
    }
    function busqueda(){ 
       // $('#myModal').modal('show'); 
       $('#loader').show();
        $strD = "plaza=" + $('#cboPlaza').val();
         $("#cboSociedad").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            async: false,
            url: "ajax.php?c=cuentas&f=get_sociedades",
            success:function ($databack){
               $('#loader').hide();
               $("#cboSociedad").html($databack);
               $('#cboSociedad').selectpicker('refresh');
        
            }
        })
    }; 
      function busca_cuentas(){ 
       $('#loader_cta').show();
        $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
         $("#cboCuenta").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_cuentas_plaza_soc",
            success:function ($databack){
               $('#loader_cta').hide();
               $("#cboCuenta").html($databack);
               $('#cboCuenta').selectpicker('refresh');
        
            }
        })
    }; 
     function filtra_cuentas(){ 
       $('#loader_cta').show();
        $strD = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val()+ "&banco=" + $('#cboBanco').val();
         $("#cboCuenta").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=filtra_cuentas_banco",
            success:function ($databack){
               $('#loader_cta').hide();
               $("#cboCuenta").html($databack);
               $('#cboCuenta').selectpicker('refresh');
        
            }
        })
    }; 
var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
self.show_stack_bar_top = function (type,title,mensaje) {
    var opts = {
        cornerclass: "",
        styling: 'bootstrap3'
    };
    switch (type) {
    case 'error':
        opts.title = title;
        opts.text = mensaje;
        opts.type = "error";
        break;
    case 'info':
        opts.title = title;
        opts.text = mensaje;
        opts.type = "info";
        break;
    case 'success':
        opts.title = title;
        opts.text = mensaje;
        opts.type = "success";
        break;
    case 'warning':
        opts.title = title;
        opts.text = mensaje;
        opts.type = "warning";
        break;
    }
   new PNotify(opts);
}
    function tipoPer()
{
  if($('#cboPlaza').val() == "" || $('#cboSociedad').val() == "")
  {
    show_stack_bar_top('warning','Faltan campos','Seleccione la plaza y la sociedad');

  }
  else
  {
    if($('#personal_tipo').val() == 1)
    {
        $('#externo').hide();
        $('#interno').show();
    }
    else if($('#personal_tipo').val() == 2)
    {
      $('#interno').hide();
      $('#externo').show();
        $str = "plaza=" + $('#cboPlaza').val() + "&soc=" + $('#cboSociedad').val();
        $("#usuario_ext").empty();
        $.ajax({
            data: $str,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=busca_externos",
            success:function ($data){
               $("#usuario_ext").html($data);
               $('#usuario_ext').selectpicker('refresh');
        
            }
        })
    }
    else
    {
      $('#externo').hide();
      $('#interno').hide();
    }
  }
};
 function pregResp()
    {
        if($('#preg_resp').val() == 1)
        {
            $('#divSi').show();
        }
        else
        {
           $('#divSi').hide();
        }
    }
 function busca_cta(){ 
        $strD = "plaza=" + $('#plaza_form').val() + "&soc=" + $('#soc_form').val()+ "&banco=" + $('#banco_form').val();
         $("#cuenta_form").empty();
        $.ajax({
            data: $strD,
            type: "POST",
            dataType: "text",
            url: "ajax.php?c=cuentas&f=filtra_cuentas_banco",
            success:function ($databack){
               $("#cuenta_form").html($databack);
               $('#cuenta_form').selectpicker('refresh');
        
            }
        })
    }; 