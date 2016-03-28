<br><br>

<br><br>
&#60;iframe src=&#34;http://docs.google.com/gview?url=http://victorpimentel.com/stuff/rubik.pdf&#38;embedded=true&#34; style=&#34;width:500px; height:375px;&#34; frameborder=&#34;0&#34;&#62;&#60;/iframe&#62;
<label for="" onclick="genera_reporte()">Generar</label>
<?php ob_start();
 require_once("librerias/dompdf/dompdf_config.inc.php");        
      # Contenido HTML del documento que queremos generar en PDF.
      $html =
        '<html><body>'.
        '<p>Put your html here, or generate it with your favourite '.
        'templating system.</p>'.
        '</body></html>';

      $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('a4', 'portrait');
    $dompdf->render();
    $dompdf->stream("new.pdf");
?>
<script>
	function genera_reporte(){ 
        $.ajax({
            type: "GET",
            dataType: "text",
            url: "ajax.php?c=financiamiento&f=genera_reporte",
            success:function ($databack){
             alert($databack);
        
            }
        })
    }; 
</script>