<?php session_start();

//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/conciliacion_model.php");

class conciliacion extends Common
{
    public $conciliacion_model;

    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->conciliacion_model = new conciliacion_model();
        $this->conciliacion_model->connect();
    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->conciliacion_model->close();
    }
     //vista financiamiento
      function get_conciliar()
    {   
        $plazas= $this->conciliacion_model->all_plazas();
        $bancos= $this->conciliacion_model->all_bancos();
        $referencias= $this->conciliacion_model->codigo_sociedad();
        require('views/conciliacion/consulta.php');
    }
    function conciliacion()
    {
      $plazas= $this->conciliacion_model->all_plazas();
        $bancos= $this->conciliacion_model->all_bancos();
        $referencias= $this->conciliacion_model->codigo_sociedad();
        require('views/conciliacion/consulta-conciliar.php');   
    }
    function upload()
    {
        require('views/file-upload.php');
    }
     function upload_file()
    {
            date_default_timezone_set('America/Mexico_City');
            $dateTime =date('Y-m-d H:i:s');
            $folder = "./uploads/";
            $uploadOk = 1;
            $plaza = $_POST['plaza'];
            $soc = $_POST['soc'];
            $cuenta = $_POST['cuenta'];
            //generamos una cadena aleatoria
            $random = $this->generateRandomString();
            $maxlimit = 50000000; // Máximo límite de tamaño (en bits)
            $allowed_ext ="csv,xlsx"; // Extensiones permitidas (usad una coma para separarlas)
            $overwrite = "yes"; // Permitir sobreescritura? (yes/no)
            $match = ""; 
            $filesize = $_FILES['fileToUpload']['size']; // toma el tamaño del archivo
            $filename = strtolower($_FILES['fileToUpload']['name']); // toma el nombre del archivo y lo pasa a minúsculas
            if(!$filename || $filename==""){ // mira si no se ha seleccionado ningún archivo
               $error="- Ningún archivo selecccionado para subir.<br>";
            }elseif(file_exists($folder.$filename) && $overwrite=="no"){ // comprueba si el archivo existe ya
               @unlink($_GET[$folder.$filename]); 
            }
            // comprobar tamaño de archivo
            if($filesize < 1){ // el archivo está vacío
               $error .= "- Archivo vacío.<br>";
            }elseif($filesize > $maxlimit){ // el archivo supera el máximo
               $error .= "- Este archivo supera el máximo tamaño permitido.<br>";
            }

            $file_ext = preg_split("/\./",$filename); // aquí no tengo claro lo que hace xD
            $allowed_ext = preg_split("/\,/",$allowed_ext); // ídem, algo con las extensiones
            foreach($allowed_ext as $ext){
               if($ext==$file_ext[1]) $match = "1"; // Permite el archivo
            }

            // Extensión no permitida
            if(!$match){
               $error .= "- Este tipo de archivo no está permitido: $filename<br>";
            }

            if(@$error){
               print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
            }
            else{

                $ubicacion=$folder.$filename;

               //if(move_uploaded_file($_FILES['userfile']['tmp_name'], $folder.$filename)){ // Finalmente sube el archivo
               if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $ubicacion))
               { // Finalmente sube el archivo
                    $vaciar_tabla= $this->conciliacion_model->vacia_tabla();
                    $guarda_temporal= $this->conciliacion_model->guarda_temporal($ubicacion);  
                    $busca_temporal= $this->conciliacion_model->busca_temporal();  
                      while($b=$busca_temporal->fetch_assoc())
                    {
                       $date= $b['fecha'];
                       $fecha_movto=$this->cambiaf_a_mysql($date);
                       $nom_tipo= $b['tipo'];
                       $num_abono= floatval($b['abonos']);
                       $imp_abono=$num_abono;
                       $num_cargo=floatval($b['cargos']);
                       $imp_cargo=$num_cargo;
                       $folio=$b['folio'];
                        if($folio == "")
                        {
                          $folio = 0;
                        }
                       $referencia=$b['referencia'];
                       $codigo=$b['codigo'];
                       $concepto=$b['concepto'];
                       if($imp_cargo=="")
                       {
                        $imp_cargo=0;
                       }
                        if($imp_abono=="")
                       {
                        $imp_abono=0;
                       }
                       if($nom_tipo== "INGRESOS" or $nom_tipo== "ingresos" or $nom_tipo== "ingreso" or $nom_tipo=="INGRESO")
                       {
                        $tipo_movto=1;
                       }
                       elseif($nom_tipo== "EGRESOS" or $nom_tipo== "egresos" or $nom_tipo== "egreso" or $nom_tipo=="EGRESO")
                       {
                        $tipo_movto=2;
                       }

                       $guarda_concepto= $this->conciliacion_model->guarda_concepto($plaza,$soc,$cuenta,$folio,$fecha_movto,$tipo_movto,$imp_cargo,$imp_abono,$concepto,$referencia);
                    }
                    $vaciar_tabla= $this->conciliacion_model->vacia_tabla();
                    echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  La importacion de los datos se realizo exitosamente</strong></div>";                    
                }
            }
    }
    function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function cambiaf_a_mysql($fecha)
    {
        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
        $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
        return $lafecha;
    }
    function cambiaf_a_normal($fecha){
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
        return $lafecha;
    }
      function movimientos()
    {   
       $cuenta= $_REQUEST['cuenta'];
       $inicio=$this->cambiaf_a_mysql($_REQUEST['inicio']);
       $fin=$this->cambiaf_a_mysql($_REQUEST['fin']);
       $movs = $this->conciliacion_model->mov_conciliacion($cuenta,$inicio,$fin);
       $array_mov= array(); //creamos un array
 
        while($mov=$movs->fetch_assoc()) 
        { 
            $id=$mov['idconciliacion'];
            $cuenta=$mov['num_cuenta'];
            $folio=$mov['folio'];
            if($folio == "")
            {
              $folio = 0;
            }
            $fecha_movto=$mov['fecha_movto'];
            $tipo_movto=$mov['tipo_movto'];
            if($tipo_movto==1)
            {
                $tipo="INGRESO";
            }
            else
            {
                $tipo="EGRESO";
            }
            $cargo=$mov['cargo'];
            $abono=$mov['abono'];
            $concepto=$mov['concepto'];
            $referencia=$mov['referencia'];
            $obs=$mov['observaciones'];
            $array_mov[] = array('id'=> $id,'cuenta'=> $num_cuenta,'folio'=>$folio,'fecha_movto'=> $fecha_movto,'tipo_movto'=>$tipo,'cargo'=>$cargo,'abono'=>$abono,'concepto'=>$concepto,'referencia'=>$referencia,'obs'=>$obs);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_mov);
        echo $json_string;

    }
      function calcula_cargos()
    {
      $cuenta= $_REQUEST['cuenta'];
       $inicio=$this->cambiaf_a_mysql($_REQUEST['inicio']);
       $fin=$this->cambiaf_a_mysql($_REQUEST['fin']);
      $cargos= $this->conciliacion_model->calcula_cargos($cuenta,$inicio,$fin);
      while($i=$cargos->fetch_assoc()) 
      {
        $num=floatval($i['total_cargo']);
        $money=number_format($num,2,".",",");
        echo $money;
      }
    }  
        function calcula_abonos()
    {
      $cuenta= $_REQUEST['cuenta'];
       $inicio=$this->cambiaf_a_mysql($_REQUEST['inicio']);
       $fin=$this->cambiaf_a_mysql($_REQUEST['fin']);
      $abonos= $this->conciliacion_model->calcula_abonos($cuenta,$inicio,$fin);
      while($i=$abonos->fetch_assoc()) 
      {
        $num=floatval($i['total_abono']);
        $money=number_format($num,2,".",",");
        echo $money;
      }
    }
    function borrar_movimientos()
    {
        $elementos=$_POST['elementos'];
        $datos=json_decode($elementos,true);
        //while($dato=$datos->fetch_assoc()) 
        foreach ($datos as $dato) 
        {
            $borrar= $this->conciliacion_model->borrar_movimientos($dato['id']);
        }       
        echo "OK";
        
    }
    function guarda_nuevo_mov()
    {
        $plaza=$_POST['plaza'];
        $soc=$_POST['soc'];
        $cuenta=$_POST['cuenta'];
        $tipo_mov= $_POST['tipo_mov'];
        $importe_mov=number_format($_POST['importe_mov'],2,".",",");
        $folio_mov= $_POST['folio_mov'];
        $f_mvto= $_POST['f_mvto'];
        $ref_mov= $_POST['ref_mov'];
        $concepto_mvto= $_POST['concepto_mvto'];
        if($tipo_mov==1)
        {
            $abono=$importe_mov;
            $cargo=0;
        }
        else
        {
            $abono=0;
            $cargo=$importe_mov;
        }
        $guarda= $this->conciliacion_model->guarda_concepto($plaza,$soc,$cuenta,$folio_mov,$f_mvto,$tipo_mov,$cargo,$abono,$concepto_mvto,$ref_mov);
        echo $guarda;
    }

}

?>
