<?php session_start();
error_reporting(E_ALL);
//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/cuentas_model.php");

class cuentas extends Common
{
    public $cuentas_model;

    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->cuentas_model = new cuentas_model();
        $this->cuentas_model->connect();
    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->cuentas_model->close();
    }

    function get_cuenta()
    {   
        $plazas = $this->cuentas_model->all_plazas();
        $sociedades = $this->cuentas_model->all_sociedad();
        $bancos = $this->cuentas_model->all_bancos();
        $personas = $this->cuentas_model->all_personal();
        $users = $this->cuentas_model->all_personal();
        $firmantes = $this->cuentas_model->all_personal();
        $responsables = $this->cuentas_model->all_personal();
        $status_token = $this->cuentas_model->status_token();
        $areas = $this->cuentas_model->areas_operacion();
        $estados_cuenta = $this->cuentas_model->estados_cuenta();
        $cps = $this->cuentas_model->codigo_postal();
        $personal = $this->cuentas_model->all_personal();
        $pzs = $this->cuentas_model->all_plazas();
        $plzas = $this->cuentas_model->all_plazas();
        $p_responsables = $this->cuentas_model->all_plazas();
        $sociedades_cta = $this->cuentas_model->all_sociedad();
        $sociedades_resp = $this->cuentas_model->all_sociedad();
        $sociedades_us = $this->cuentas_model->all_sociedad();
        $sociedades_fir = $this->cuentas_model->all_sociedad();
        $domicilios = $this->cuentas_model->busca_domicilios();
        require('views/cuentas-bancarias/alta-cuenta.php'); 

    }
    //busca las sociedades de la plaza
    function get_sociedades()
    {
        $idplaza= $_REQUEST['plaza'];
        $sociedades = $this->cuentas_model->busca_sociedad($idplaza);
        $total=count($sociedades->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option value="" selected>-- No existen sociedades --</option>';
         }
         else
         {
            echo ' <option value="" selected>-- Seleccione la sociedad --</option>';
             echo ' <option value="00" selected>-- Sin sociedad --</option>';
            while($sociedad=$sociedades->fetch_assoc())
            {
                echo '<option  value="'.$sociedad['idempresa'].'">'.$sociedad['razonsocial'].'</option>'; 
            }
         }

    }
    //asignacion de chequeras
      function get_chequera()
    {   
        $plazas = $this->cuentas_model->all_plazas();
        $bancos = $this->cuentas_model->all_bancos();
        require('views/chequeras/asignacion.php');
    }
    //consulta de movimientos
      function get_movimientos()
    {   
        require('views/cuentas-bancarias/consulta-movimientos.php');
    }
      function get_bancos()
    {   
        require('views/cuentas-bancarias/consulta-banco.php');
    }
    //tabla de bancos
      function muestra_bancos()
    {   
       $bancos = $this->cuentas_model->all_bancos();
       $array_bancos = array(); //creamos un array
 
        while($banco=$bancos->fetch_assoc()) 
        { 
            $idbanco=$banco['idbancos'];
            $nombre=$banco['nombre'];
            $inst=$banco['no_institucion'];
            $cve=$banco['cve_transfer'];
            $array_bancos[] = array('idbancos'=> $idbanco,'nombre'=>$nombre,'no_institucion'=> $inst,'cve_transfer'=>$cve);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_bancos);
        echo $json_string;

    }

    //consulta cuentas bancarias
       function get_consulta()
    {   
        $plazas = $this->cuentas_model->all_plazas();
        $sociedades = $this->cuentas_model->all_sociedad();
        require('views/cuentas-bancarias/consulta-cuenta.php');
    }
    //Consulta de cuentas
       function busca_cuentas()
    {   
       $plaza= $_REQUEST['plaza'];
       $soc= $_REQUEST['soc'];
       $filtro=$_GET['filtro'];
        $array_cuentas = array(); //creamos un array
        // si la variable ctas esta vacia no aplicamos ningun filtro a las cuentas
            if($plaza == "TODAS" and $soc == "TODAS")
            {
                $cuentas = $this->cuentas_model->todas_cuentas();

            }
            else
            {
                $cuentas = $this->cuentas_model->consulta_cuentas($plaza,$soc);
            }
            while($cuenta=$cuentas->fetch_assoc()) 
            { 
                $id=$cuenta['idcta'];
                $num_cta=$cuenta['num_cuenta'];
                $clabe=$cuenta['clabe'];
                $banco=$cuenta['banco'];
                $nombre_resp=$cuenta['nombre_resp'];
                $suc= $cuenta['sucursal'];
                if($cuenta['fecha_apertura'] != "" or $cuenta['fecha_apertura'] != "-")
                {
                    $f_ap=$this->cambiaf_a_normal($cuenta['fecha_apertura']);
                }
                else
                {
                    $f_ap = "Sin fecha";
                }
                $status=$cuenta['status_cta'];
                $area=$cuenta['area'];
                $tipo_cta=$cuenta['tipo_cuenta'];
                $tipo_op=$cuenta['tipo_operacion'];
                if($status=="Activa")
                {
                    $estado= "<span  class='label label-success'>Activa</label>";
                }
                elseif($status=="Cancelada")
                {
                     $estado= "<span  class='label label-default'>Cancelada</label>";
                }
                elseif($status=="Bloqueada")
                {
                    $estado= "<span  class='label label-danger'>Bloqueada</label>";
                }
                else
                {
                    $estado=$status;
                }
                if($filtro == 0)
                {
                    $array_cuentas[] = array('id'=> $id,'num_cta'=>$num_cta,'clabe'=> $clabe,'resp'=>$nombre_resp,'banco'=>$banco,'suc'=>$suc,'f_ap'=>$f_ap,'status'=>$estado,'area'=>$area,'tipo_op'=>$tipo_op,'tipo_cuenta'=>$tipo_cta);
                }
                //condiciones que se aplican cuando el usuario pone filtros en la consulta
                elseif($filtro == 1 and $status=="Activa")
                {
                    $array_cuentas[] = array('id'=> $id,'num_cta'=>$num_cta,'clabe'=> $clabe,'resp'=>$nombre_resp,'banco'=>$banco,'suc'=>$suc,'f_ap'=>$f_ap,'status'=>$estado,'area'=>$area,'tipo_op'=>$tipo_op,'tipo_cuenta'=>$tipo_cta);
                }
                elseif($filtro == 2 and $status=="Cancelada" )
                {
                    $array_cuentas[] = array('id'=> $id,'num_cta'=>$num_cta,'clabe'=> $clabe,'resp'=>$nombre_resp,'banco'=>$banco,'suc'=>$suc,'f_ap'=>$f_ap,'status'=>$estado,'area'=>$area,'tipo_op'=>$tipo_op,'tipo_cuenta'=>$tipo_cta);
                }
                elseif($filtro == 3 and $status=="Bloqueada")
                {
                    $array_cuentas[] = array('id'=> $id,'num_cta'=>$num_cta,'clabe'=> $clabe,'resp'=>$nombre_resp,'banco'=>$banco,'suc'=>$suc,'f_ap'=>$f_ap,'status'=>$estado,'area'=>$area,'tipo_op'=>$tipo_op,'tipo_cuenta'=>$tipo_cta);
                }
                else
                {
                    //no hacemos nada
                }
            }   
        //Creamos el JSON
        $json_string = json_encode($array_cuentas);
        echo $json_string;
    }
    function guarda_banco()
    {
        $banco=$_REQUEST['banco'];
        $no_inst=$_REQUEST['no_inst'];
        $cve=$_REQUEST['cve'];
        $guarda = $this->cuentas_model->guarda_banco($banco,$no_inst, $cve);
        echo "OK";
        

    }
    function borrar_banco()
    {
        $id=$_REQUEST['id'];
        $borrar=$this->cuentas_model->borrar_banco($id);
        echo "OK";
    }
     function buscar_banco()
    {
        $id=$_REQUEST['id'];
        $bancos=$this->cuentas_model->busca_banco($id);
        $array_bancos = array(); //creamos un array

        while($banco=$bancos->fetch_assoc()) 
        { 
            $idban=$banco['idbancos'];
            $nombre=$banco['nombre'];
            $no=$banco['no_institucion'];
            $cve=$banco['cve_transfer'];
            $status= $banco['estado'];
            $array_bancos[] = array('idban'=> $idban,'nombre'=>$nombre,'no'=> $no,'cve'=>$cve,'status'=>$status);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_bancos);
        echo $json_string;
    }
    //actualiza datos del banco
     function update_banco()
    {
        $id=$_REQUEST['id'];
        $banco=$_REQUEST['nombre'];
        $inst=$_REQUEST['no'];
        $cve=$_REQUEST['cve'];
        $upd=$this->cuentas_model->update_banco($id,$banco,$inst,$cve);
        echo "OK";

    }
     //guarda cuentas
     function guarda_cuenta()
    {
        $fecha= date('y-m-d');
        //datos para guardar en la tabla de cuenta_bancaria   
        $plaza = $_POST['plaza'];
        $soc = $_POST['soc'];
        $cta = $_POST['cuenta'];
        $clabe = $_POST['clabe'];
        $banco = $_POST['banco'];
        $area = $_POST['area'];
        $sucursal = $_POST['sucursal'];
        $domicilio = $_POST['domicilio'];
        $f_alta = $this->cambiaf_a_mysql($_POST['f_alta']);
        $usuario = $_POST['user'];
        $personal_tipo = $_POST['personal_tipo'];
        $usuario_ext = $_POST['usuario_ext'];
        $plaza_user = $_POST['plaza_user'];
        $soc_user = $_POST['soc_user'];
        if(empty($_POST['no_contrato']))
        {
            $no_contrato = 0;
        }
        else
        {
            $no_contrato = $_POST['no_contrato'];
        }
        if(empty($_POST['no_cliente']))
        {
            $no_cliente = 0;
        }
          else
        {
            $no_cliente = $_POST['no_contrato'];
        }
        $contrato_nomina = $_POST['contrato_nomina'];
        $tipo_op = $_POST['tipo_op'];
        $tipo_cuenta = $_POST['tipo_cuenta'];
        if(empty($_POST['saldo_inicial']))
        {
            $saldo = 0;
        }
        else
        {
            $saldo = number_format($_POST['saldo_inicial'],2,".",",");
        }
        $moneda = $_POST['moneda'];
        $preg_resp = $_POST['preg_resp'];
        $preg_dom = $_POST['preg_dom'];
        $firmante_tipo = $_POST['firmante_tipo'];
        //datos para guardar en la tabla responsables
        $tipo_resp=$_POST['tipo_resp'];
        $plaza_resp=$_POST['plaza_resp'];
        $resp_cta= $_POST['resp_cta'];
        $soc_resp=$_POST['soc_resp'];
        $obs=$_POST['obs'];
        //datos para guardar en la tabla historial_status
        $status=$_POST['status_cta'];
        $folio=$_POST['folio'];
        $fecha_bloq=$this->cambiaf_a_mysql($_POST['fecha_bloq']);
        $coments= $_POST['coment'];
        //datos para guardar en la tabla de chequeras
        $resp_cheq= $_POST['resp_cheq'];
        $fecha_asig=$this->cambiaf_a_mysql($_POST['f_asig']);
        $folio_cheq=$_POST['folio_cheq'];
        $no_cheques=$_POST['no_cheques'];
        $cheque_ini=$_POST['cheque_inicial'];
        $cheque_fin=$_POST['cheque_final'];
        $status_cheq=$_POST['status_chequera'];
        $obs_cheque=$_POST['cheque_obs'];
        //datos para guardar en el historial del domicilio
        $dom_ini=$_POST['dom_ini'];
        $dom_fin=$_POST['dom_fin'];
        //datos del token
        $cod_token= $_POST['cod_token'];
        $resp_token= $_POST['resp_token'];
        $f_token= $this->cambiaf_a_mysql($_POST['f_token']);
        $vence=  $_POST['vence'];
        $f_vence=  $this->cambiaf_a_mysql($_POST['f_vence']);
        $obs_token=  $_POST['obs_token'];
        $status_token= $_POST['status_token'];
        //arreglos
        if(isset($_POST['firmantes']))
        {
            $tot_firmantes= count($_POST['firmantes']); 
        }
        if(isset($preguntas))
        {
            $preguntas = $_POST['preguntas'];
        }
        else
        {
            $preguntas = "";
        }
        //otros datos
        date_default_timezone_set('America/Mexico_City');
        $dateTime =date('Y-m-d H:i:s');
        $tot_preg= count($preguntas); 
        if($saldo == "")
        {
            $saldo = 0;
        }
        if($no_cliente == "")
        {
            $no_cliente=0;
        }
        if($no_contrato == 0)
        {
            $no_contrato = 0;
        }
        if($personal_tipo == 1)
        {
            $cuenta= $this->cuentas_model->guardar_cta($plaza,$soc,$area,$cta,$clabe,$banco, $sucursal,$f_alta,$personal_tipo, $usuario,$plaza_user,$soc_user,$no_contrato,$no_cliente,$contrato_nomina,$tipo_op,$tipo_cuenta,$saldo,$moneda, $dateTime);
        }
        elseif($personal_tipo == 2)
        {
            $cuenta= $this->cuentas_model->guardar_cta($plaza,$soc,$area,$cta,$clabe,$banco, $sucursal,$f_alta,$personal_tipo,$usuario_ext,$plaza,$soc,$no_contrato,$no_cliente,$contrato_nomina,$tipo_op,$tipo_cuenta,$saldo,$moneda, $dateTime);
        }
        else
        {
            //si no tiene usuario de cuenta
            $cuenta= $this->cuentas_model->guardar_cta($plaza,$soc,$area,$cta,$clabe,$banco, $sucursal,$f_alta,$personal_tipo,00,00,00,$no_contrato,$no_cliente,$contrato_nomina,$tipo_op,$tipo_cuenta,$saldo,$moneda, $dateTime);
        }

         if(is_numeric($cuenta))
        {  
            //si tiene domicilio
            if($preg_dom == 1)
            {
              $historial_dom= $this->cuentas_model->inserta_historial($cuenta,$domicilio,$dom_ini,$dom_fin,$dateTime);
              $update_dom = $this->cuentas_model->update_dom_cuenta($cuenta, $historial_dom);
            }
              //guarda en la tabla historial el status actual de la cuenta
              $status_actual= $this->cuentas_model->guarda_status_cuenta($cuenta,$status,$folio,$fecha_bloq,$coments,$dateTime);
              //actualizamos el estado actual de la cuenta bancaria
              $update = $this->cuentas_model->update_status_historial($cuenta, $status_actual);
              if($preg_resp == 1)
              {
                //guardamos el responsable de la cuenta
                $idresp= $this->cuentas_model->inserta_resposable($cuenta,$resp_cta,$tipo_resp,$plaza_resp,$soc_resp,$f_alta,$dateTime);
                //actualizamos el responsable de la cuenta
                $update_resp= $this->cuentas_model->update_responsable($cuenta,$idresp);
              }
             //guarda la chequera actual de la cuenta
             if($folio_cheq != "" and $resp_cheq != "")
             {
                 $idcheq= $this->cuentas_model->inserta_chequera($cuenta,$folio_cheq,$fecha_asig,$no_cheques,$cheque_ini,$cheque_fin,$resp_cheq,$obs_cheque,$status_cheq,$dateTime);
             }
             if($cod_token != "" or $cod_token!= null)
            {
                $guarda_token= $this->cuentas_model->guarda_token($cuenta,$cod_token,$f_token,$resp_token,$vence,$f_vence,$obs_token,$status_token);
            }
        if($preguntas!="")
        {
          if($tot_preg>0)
          {
            foreach ($preguntas as $preg) 
            {
                $guarda_pregunta= $this->cuentas_model->guarda_pregunta($cuenta,$preg['Pregunta'],$preg['Respuesta']);
            }
          }
        }
          //guarda facturas
          if(isset($tot_firmantes) and isset($_POST['firmantes']))
          {
            foreach ($_POST['firmantes'] as $fir) 
            {
                $guarda_firmante= $this->cuentas_model->guarda_firmante($cuenta,$fir['Idfirmante'],$fir['PlazaFirm'],$fir['Tipo'],$fir['SocFirm']);
            }
          }
        }
        echo "OK";

    }
    function busca_responsable()
    {
        $tipo_resp= $_REQUEST['tipo_resp'];
        $soc= $_REQUEST['soc'];
        // si el responsable es 1 es empleado y si es 2 es cliente
        if($tipo_resp == 1)
        {
            $empleados = $this->cuentas_model->all_personal();
            $total= count($empleados->fetch_assoc());
            if($total == 0 )
            {
                echo ' <option  selected>-- No existen registros --</option>';
            }
             else
             {
                echo ' <option  value="" selected>-- Seleccione empleado --</option>';
                while($empleado=$empleados->fetch_assoc())
                {
                    echo '<option  value="'.$empleado['Id_empleado'].' ">'.$empleado['nombre_emp'].'</option>'; 
                }
             }
        }
        else
        {
            $clientes = $this->cuentas_model->clientes_plaza_soc($soc);
            $totalcl= count($clientes->fetch_assoc());
            
            if($totalcl == 0 )
            {
                echo ' <option  selected>-- No existen registros --</option>';
            }
             else
             {
                echo ' <option  selected>-- Seleccione cliente --</option>';
                while($cliente=$clientes->fetch_assoc())
                {
                    echo '<option  value="'.$cliente['id'].' ">'.$cliente['razon'].'</option>'; 
                }
             }
        }
    }
    //funcion que busca los detalles de la cuenta
    function detalle_cuenta()
    {
        $id=$_REQUEST['id'];
        $datos=$this->cuentas_model->datos_cuenta($id);
        //var_dump($datos);
        $array_cuenta = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $plaza=$dato['Plaza'];
            $soc=$dato['razonsocial'];
            $banc=$dato['nombre'];
            $id=$dato['idcuenta'];
            $cta=$dato['num_cuenta'];
            $cbe= $dato['clabe'];
            $suc= $dato['sucursal'];
            $f_ap= $dato['fecha_apertura'];
            $us= $dato['nombre_us'];
            $cont= $dato['no_contrato'];
            $sal = $dato['saldo_inicial'];

            $array_cuenta[] = array('id'=> $id,'plaza'=> $plaza,'soc'=>$soc,'banc'=> $banc,'cta'=>$cta,'cbe'=>$cbe,'suc'=>$suc, 'f_ap'=> $f_ap, 'us'=> $us, 'cont'=> $cont, 'sal'=> $sal);
         
        }
        
        //Creamos el JSON
        $json_string = json_encode($array_cuenta);
        echo $json_string;
    }
      function borrar_cuenta()
    {
        $id=$_REQUEST['id'];
        $borrar=$this->cuentas_model->borrar_cuenta($id);
        echo $borrar;
    }
    function busca_domicilios()
    {
      $plaza= $_REQUEST['plaza'];
      $soc= $_REQUEST['soc'];
      $domicilios = $this->cuentas_model->busca_domicilios($plaza,$soc);
        $total=count($domicilios->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen domicilios --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione domicilio --</option>';
            foreach($domicilios as $dom)
            {
                echo '<option value="'.$dom['id_domicilio'].'">'.$dom['domicilio'].'</option>'; 
            }
         }
    }
     function busca_colonias()
    {
        $id=$_REQUEST['id'];
        $as= $this->cuentas_model->busca_colonias($id);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen colonia  --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione colonia --</option>';
            foreach($as as $a)
            {
                echo '<option  value="'.$a['Id'].'">'.$a['colonia'].'</option>'; 
            }
         }

    }
    function datos_cp()
    {
        $cp=$_REQUEST['cp'];
        $datos=$this->cuentas_model->datos_cp($cp);
        $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $mun=$dato['delegacionmunicipio'];
            $edo=$dato['estado'];
            $array_datos[] = array('mun'=> $mun,'edo'=>$edo);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
    function guarda_domicilio()
    {
        $cp=$_POST['cp'];
        $calle=$_POST['calle'];
        $ext=$_POST['ext'];
        $int=$_POST['int'];
        $info_extra=$_POST['info'];
        $inicio= $this->cambiaf_a_mysql($_POST['inicio']);
        $fin = $this->cambiaf_a_mysql($_POST['fin']);
        date_default_timezone_set('America/Mexico_City');
        $dateTime =date('Y-m-d H:i:s');
        $guarda= $this->cuentas_model->guarda_domicilio($cp,$calle,$int,$ext,$inicio,$fin,$dateTime,$info_extra);
        echo $guarda;
    }
    function consulta_domicilio()
    {
        $plaza= $_REQUEST['plaza'];
        $soc= $_REQUEST['soc'];
        $domicilios= $this->cuentas_model->consulta_domicilios($plaza,$soc);
        $array_dom = array(); //creamos un array
 
        while($dom=$domicilios->fetch_assoc()) 
        { 
            $id=$dom['id_domicilio'];
            $cp=$dom['codigopostal'];
            $col=$dom['colonia'];
            $calle=$dom['calle'];
            $ext=$dom['num_ext'];
            $int=$dom['num_int'];
            $inicio=$dom['periodo_inicio'];
            $fin=$dom['periodo_fin'];
            $edo= $dom['estado'];
            if($edo==0)
            {
                $estado="<span  class='label label-default'>Inactivo</span>";
            }
            elseif($edo == 1)
            {
                $estado="<span  class='label label-success'>Activo</span>";
            }
            $array_dom[] = array('id'=> $id,'cp'=>$cp,'col'=>$col,'calle'=> $calle,'num_ext'=>$ext,'num_int'=>$int,'inicio'=>$inicio,'fin'=>$fin,'estado'=>$estado);

         
        }
         //Creamos el JSON
            $json_string = json_encode($array_dom);
            echo $json_string;

    }
      function busca_dom()
    {
        $plaza=$_REQUEST['plaza'];
        $soc=$_REQUEST['soc'];
        $as= $this->cuentas_model->busca_dom($plaza,$soc);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen domicilios --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione domicilio--</option>';
            foreach($as as $a)
            {
                echo '<option  value="'.$a['id_domicilio'].'" data-subtext="'.$a['periodo'].'">'.$a['dom'].'</option>'; 
            }
         }

    }
     function busca_suc_banco()
    {
        $id=$_REQUEST['id'];
        $as= $this->cuentas_model->busca_suc_banco($id);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen sucursales --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione sucursal--</option>';
            foreach($as as $a)
            {
                echo '<option  value="'.$a['idsucursal'].'" data-subtext="'.$a['num_suc'].'">'.$a['nombre'].'</option>'; 
            }
         }

    }
    function chequeras()
    {
        $id=$_REQUEST['id'];
        $chequeras= $this->cuentas_model->consulta_chequera($id);
       $array_cheques = array(); //creamos un array
        while($cheq=$chequeras->fetch_assoc()) 
        { 
            $idcheq=$cheq['idchequera'];
            $folio=$cheq['folio_cheq'];
            $fecha=$this->cambiaf_a_normal($cheq['fecha_alta']);
            $no_cheq=$cheq['num_cheques'];
            $cheque_ini=$cheq['cheque_inicial'];
            $cheque_fin=$cheq['cheque_final'];
            $cheques_tot=$cheque_ini." al ".$cheque_fin;
            $responsable= $cheq['responsable'];
            $obs= $cheq['observaciones'];
            $act= date('d/m/Y H:i:s', strtotime($cheq['updated_at']));
            $id_edo=$cheq['status'];
            if($id_edo == 1)
            {
                $estado="<span  class='label label-success'>".$cheq['nombre_status']."</label>";
            }
            elseif($id_edo == 2)
            {
                $estado="<span  class='label label-danger'>".$cheq['nombre_status']."</label>";
            }
            elseif($id_edo == 3)
            {
                $estado="<span  class='label label-default'>".$cheq['nombre_status']."</label>";
            }
            else
            {
                $estado=$cheq['nombre_status'];
            }
    
            $array_cheques[] = array('id'=> $idcheq,'folio'=>$folio,'responsable'=>$responsable,'fecha'=> $fecha,'num_cheques'=>$no_cheq,'cheq'=> $cheques_tot,'estado'=> $estado,'obs'=> $obs,'act'=> $act);
         
        }
           //Creamos el JSON
        $json_string = json_encode($array_cheques);
        echo $json_string;
    }
     function datos_cuenta()
  {
    $id=$_REQUEST['id'];
    $plazas = $this->cuentas_model->all_plazas();
    $datos= $this->cuentas_model->general_cuenta($id);
    $edos= $this->cuentas_model->status_cuenta();
    $empleados = $this->cuentas_model->all_personal();
    $personal = $this->cuentas_model->all_personal();
    $firmantes_cta = $this->cuentas_model->personal_firmante($id);
    $responsables = $this->cuentas_model->all_personal();
    $edos_cheq = $this->cuentas_model->edos_chequera();
    $status_token = $this->cuentas_model->status_token();
    $edo_tok = $this->cuentas_model->status_token();
    $p_firms = $this->cuentas_model->all_plazas();
    $plaza_us= $this->cuentas_model->all_plazas();
    $usuarios = $this->cuentas_model->all_personal();
    $p_responsables= $this->cuentas_model->all_plazas();
    require('views/cuentas-bancarias/detalles-cuenta.php');
  }
  function consulta_token()
  {
     $id=$_REQUEST['id'];
      $tokens= $this->cuentas_model->consulta_token($id);
       $array_token = array(); //creamos un array
        while($tok=$tokens->fetch_assoc()) 
        { 
            $id=$tok['idtoken'];
            $cod=$tok['codigo'];
            $f_asig=$tok['fecha_asig'];
            $vence=$tok['vence'];
            $f_vence=$tok['fecha_vence'];
            $obs=$tok['observaciones'];
            $edo= $tok['idstatus_token'];
            $resp= $tok['responsable'];
            $act= $tok['updated_at'];
            if($edo == 2)
            {
                $estado="<span  class='label label-danger'>".$tok['nom_status']."</label>";
            }
            elseif($edo == 1)
            {
                $estado="<span  class='label label-success'>".$tok['nom_status']."</label>";
            }
            elseif($edo == 3)
            {
                $estado="<span  class='label label-default'>".$tok['nom_status']."</label>";
            }
            else
            {
                $estado="<span  class='label label-danger'>".$tok['nom_status']."</label>";
            }

            if( $vence== 0)
            {
                $msj="No";
                $f_vence="N/A";
            }
             elseif( $vence== 1)
            {
                $msj="Si";
            }
            if($obs=="")
            {
                $obs="<span style='color:#8B8B8B'>Sin observaciones</span>";
            }
            $array_token[] = array('id'=> $id,'folio'=>$folio,'cod'=>$cod,'f_asig'=> $f_asig,'vence'=>$msj,'f_vence'=> $f_vence,'obs'=> $obs,'estado'=> $estado,'resp'=> $resp,'act'=> $act);
         
        }
           //Creamos el JSON
        $json_string = json_encode($array_token);
        echo $json_string;
  }
  function consulta_preguntas()
  {
      $id=$_REQUEST['id'];
      $preguntas= $this->cuentas_model->consulta_preguntas($id);
       $array_preg = array(); //creamos un array
        while($preg=$preguntas->fetch_assoc()) 
        { 
            $id=$preg['idpregunta'];
            $pregunta=$preg['pregunta'];
            $respuesta=$preg['respuesta'];
            $id_edo=$preg['status'];
            $act=$preg['updated_at'];
              if($id_edo == 0)
            {
                $estado="<span  class='label label-default'>Cancelado</label>";
            }
            elseif($id_edo == 1)
            {
                $estado="<span  class='label label-success'>Activo</label>";
            }
            $array_preg[] = array('id'=> $id,'pregunta'=>$pregunta,'respuesta'=>$respuesta,'estado'=>$estado,'act'=>$act);
         
        }
           //Creamos el JSON
        $json_string = json_encode($array_preg);
        echo $json_string;

  }
   function consulta_firmantes()
  {
      $id=$_REQUEST['id'];
      $firm_cta= $this->cuentas_model->firmates_cta($id);
       $array_firm = array(); 
        while($f=$firm_cta->fetch_assoc()) 
        { 
            $tipo_firm=$f['tipo']; 
            if($tipo_firm == 1)
            {
                $firmantes= $this->cuentas_model->consulta_firmantes($id);
            }
            else
            {
                $firmantes= $this->cuentas_model->firmantes_externos($id);
            }
        }
        while($firm=$firmantes->fetch_assoc()) 
        {
            $id=$firm['idfirmante'];
            $empleado=$firm['nombre_emp'];
            $plaza=$firm['Plaza'];
            $soc=$firm['razonsocial'];
            $edo=$firm['status'];
             if($edo == 0)
            {
                $estado="<span  class='label label-default'>Cancelado</label>";
            }
            elseif($edo == 1)
            {
                $estado="<span  class='label label-success'>Activo</label>";
            }
            $array_firm[] = array('id'=> $id,'empleado'=>$empleado,'plaza'=>$plaza,'soc'=>$soc,'estado'=>$estado);
         
        }
           //Creamos el JSON
        $json_string = json_encode($array_firm);
        echo $json_string;

  }
  function consulta_status()
  {
      $id=$_REQUEST['id'];
      $historial=$this->cuentas_model->consulta_status($id);
       $array_status = array(); //creamos un array
        while($his=$historial->fetch_assoc()) 
        { 
            $id=$his['idhistorial_cuenta'];
            $edo=$his['nombre'];
            $id_edo=$his['idstatus_cuenta'];
            $folio=$his['folio'];
            $fecha=$this->cambiaf_a_normal($his['fecha']);
            $obs=$his['observaciones'];
            $creado=$his['created_at'];

             if($id_edo == 2)
            {
                $estado="<span  class='label label-default'>Cancelada</label>";
            }
            elseif($id_edo == 1)
            {
                $estado="<span  class='label label-success'>Activo</label>";
            }
              elseif($id_edo == 3)
            {
                $estado="<span  class='label label-danger'>Bloqueada</label>";
            }
            $array_status[] = array('id'=> $id,'estado'=>$estado,'folio'=>$folio,'fecha'=>$fecha,'obs'=>$obs,'creado'=>$creado);
         
        }
           //Creamos el JSON
        $json_string = json_encode($array_status);
        echo $json_string;

  }
  function busca_edo_cta()
  {
    $id=$_REQUEST['id'];
    $estado=$this->cuentas_model->busca_edo_cta($id);
  }
  function actualiza_edo_cta()
  {
    $id=$_REQUEST['id'];
    $edo=$_REQUEST['edo'];
    $fecha=$this->cambiaf_a_mysql($_REQUEST['fecha']);
    $folio=$_REQUEST['folio'];
    $obs=$_REQUEST['obs'];
    date_default_timezone_set('America/Mexico_City');
    $dateTime =date('Y-m-d H:i:s');
    //guarda en el historial el cambio de estado de la cuenta
    $historial= $this->cuentas_model->guarda_historial($id,$edo,$folio,$fecha,$obs,$dateTime);
    //actualiza en la cuenta bancaria el status actual
    $actualiza= $this->cuentas_model->actualiza_edo_cta($id,$historial);
    echo "OK";
  }
  function historial_domicilios()
  {
     $id=$_REQUEST['id'];
     $historial=$this->cuentas_model->historial_domicilios($id);
     $array_dom = array(); //creamos un array
    while($his=$historial->fetch_assoc()) 
    { 
        $id=$his['idhistorial_domicilio'];
        $cp=$his['codigopostal'];
        $col=$his['colonia'];
        $mun=$his['delegacionmunicipio'];
        $estado=$his['estado_cp'];
        $ciudad=$his['ciudad'];
        $domicilio=$his['calle']." #".$his['num_ext']." Num.int:".$his['num_int'];
        $inicio=$this->cambiaf_a_normal($his['ini']);
        $fin=$this->cambiaf_a_normal($his['fin']);
        $act= date('d/m/Y H:i:s', strtotime($his['act']));

        $array_dom[] = array('id'=> $id,'domicilio'=>$domicilio,'col'=>$col,'mun'=>$mun,'estado'=>$estado,'ciudad'=>$ciudad,'cp'=>$cp,'inicio'=>$inicio,'fin'=>$fin,'act'=>$act,);
     
    }
           //Creamos el JSON
        $json_string = json_encode($array_dom);
        echo $json_string;
  }
  function busca_cp_colonia()
  {
    $cp=$_REQUEST['cp'];
    $col=$_REQUEST['col'];
    $id=$this->cuentas_model->busca_cp_colonia($cp,$col);
    echo $id;
  }
  function update_domicilio()
  {
    $cuenta=$_REQUEST['cta'];
    $domicilio=$_REQUEST['dom'];
    $dom_ini=$this->cambiaf_a_mysql($_REQUEST['del']);
    $dom_fin=$this->cambiaf_a_mysql($_REQUEST['al']);
    date_default_timezone_set('America/Mexico_City');
    $dateTime =date('Y-m-d H:i:s');
    $historial=$this->cuentas_model->inserta_historial($cuenta,$domicilio,$dom_ini,$dom_fin,$dateTime);
    $update_dom= $this->cuentas_model->update_dom_cuenta($cuenta,$historial);
    echo "OK";

  }
   function consulta_responsables()
  {
     $id=$_REQUEST['id'];
     $historial=$this->cuentas_model->consulta_responsables($id);
     $array_resp = array(); //creamos un array
    while($his=$historial->fetch_assoc()) 
    { 
        $id=$his['idhistorial'];
        $id_tipo=$his['tipo_resp'];
        $fecha=$this->cambiaf_a_normal($his['fecha']);
        $crea=date('d/m/Y H:i:s', strtotime($his['created_at']));
        if($id_tipo==1)
        {
            $tipo="Empleado";
            $resp=$his['responsable'];

        }
        elseif($id_tipo==2)
        {
            $tipo="Cliente";
            //buscamos el nombre del cliente responsable
            $busca_cte= $this->cuentas_model->busca_cte_resp($id);
        }
        $array_resp[] = array('id'=> $id,'resp'=>$resp,'tipo'=>$tipo,'fecha'=>$fecha,'crea'=>$crea);
     
    }
           //Creamos el JSON
        $json_string = json_encode($array_resp);
        echo $json_string;
  }
  function act_chequera()
  {
    $folio_cheq= $_POST['folio'];
    $cta= $_POST['cta'];
    $fecha_asig= $this->cambiaf_a_mysql($_POST['fecha']);
    $resp_cheq= $_POST['resp'];
    $no_cheques= $_POST['no'];
    $cheq_ini= $_POST['ini'];
    $cheq_fin= $_POST['fin'];
    $obs_cheque= $_POST['obs'];
    $status_cheq=1;
    date_default_timezone_set('America/Mexico_City');
    $dateTime =date('Y-m-d H:i:s');
    $cheq= $this->cuentas_model->inserta_chequera($cta,$fecha_asig,$folio_cheq,$no_cheques,$cheq_ini,$cheq_fin,$resp_cheq,$obs_cheque,$status_cheq,$dateTime);
    echo $cheq;
  }
  function act_responsable()
  {
    $cta= $_POST['cta'];
    $plaza= $_POST['plaza'];
    $soc= $_POST['soc'];
    $tipo_resp= $_POST['tipo_resp'];
    $resp_cta= $_POST['resp_cta'];
    $resp_cheq= $_POST['resp'];
    $resp= $_POST['resp'];
    $f_alta= $this->cambiaf_a_mysql($_POST['asg_resp']);
    date_default_timezone_set('America/Mexico_City');
    $dateTime =date('Y-m-d H:i:s');
     $idresp= $this->cuentas_model->inserta_resposable($cta,$resp_cta,$tipo_resp,$plaza,$soc,$f_alta,$dateTime);
     //actualizamos el responsable de la cuenta
     $update_resp= $this->cuentas_model->update_responsable($cta,$idresp);
     echo $update_resp;
  }
  function guarda_firmante()
  {
     $cuenta= $_POST['cta'];
     $firm= $_POST['firm'];
     $plaza= $_POST['plaza'];
     $soc= $_POST['soc'];
     $guarda_firmante= $this->cuentas_model->guarda_firmante($cuenta,$firm,$plaza,$soc);
     echo $guarda_firmante;

  }
  function guarda_usuario()
  {
     $cuenta= $_POST['cta'];
     $usuario= $_POST['usuario'];
     $plaza= $_POST['plaza'];
     $soc= $_POST['soc'];
     $guarda= $this->cuentas_model->guarda_firmante($cuenta,$firm,$plaza,$soc);
     echo $guarda;

  }
  function guarda_pregunta()
  {
    $cuenta= $_POST['cta'];
    $preg= $_POST['preg'];
    $resp= $_POST['resp_preg'];
    $guarda_pregunta= $this->cuentas_model->guarda_pregunta($cuenta,$preg,$resp);
    echo $guarda_pregunta;

  }
  function busca_datos_chequera()
  {
    $id=$_POST['id'];
    $datos= $this->cuentas_model->datos_chequera($id);

      $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $id=$dato['idchequera'];
            $folio=$dato['folio_cheq'];
            $fecha=$this->cambiaf_a_normal($dato['fecha_alta']);
            $no_cheques=$dato['num_cheques'];
            $cheque_ini=$dato['cheque_inicial'];
            $cheque_fin=$dato['cheque_final'];
            $id_resp= $dato['id_responsable'];
            $resp= $dato['responsable'];
            $status= $dato['idstatus_chequera'];
            $obs= $dato['observaciones'];

            $array_datos[] = array('id'=> $id,'folio'=> $folio,'fecha'=>$fecha,'num_cheq'=> $no_cheques,'cheque_ini'=>$cheque_ini,'cheque_fin'=>$cheque_fin,'resp'=>$resp, 'edo'=> $status, 'obs'=> $obs,'id_resp'=>$id_resp); 
        }
        
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
    function update_datos_chequera()
    {
        $id=$_REQUEST['id'];
        $cheq_fecha=$this->cambiaf_a_mysql($_REQUEST['cheq_fecha']);
        $cheq_num=$_REQUEST['cheq_num'];
        $cheq_ini=$_REQUEST['cheq_ini'];
        $cheq_fin=$_REQUEST['cheq_fin'];
        $cheq_obs=$_REQUEST['cheq_obs'];
        $cheq_resp=$_REQUEST['cheq_resp'];
        $update_cheq= $this->cuentas_model->update_datos_chequera($id,$cheq_fecha,$cheq_num,$cheq_ini,$cheq_fin,$cheq_obs,$cheq_resp);
        echo $update_cheq;

    }
    function busca_edo_chequera()
  {
    $id=$_POST['id'];
    $datos= $this->cuentas_model->status_chequera($id);

      $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $idedo=$dato['idstatus_chequera'];
            $estado=$dato['nombre'];
            $id=$dato['idchequera'];
            $array_datos[] = array('id'=> $id,'idedo'=> $idedo,'estado'=>$estado); 
        }
        
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
    function actualiza_edo_chequera()
    {
      $id=$_POST['id'];   
      $edo=$_POST['edo'];   
      $update_edo= $this->cuentas_model->update_edo_chequera($id,$edo);
      echo $update_edo;
    }
     function busca_edo_firmante()
  {
    $id=$_POST['id'];
    $datos= $this->cuentas_model->status_firmante($id);
     while($dato=$datos->fetch_assoc()) 
        {
            echo $dato['status'];
        }
    }
    function actualiza_edo_firmante()
    {
      $id=$_POST['id'];   
      $edo=$_POST['edo'];
      $update_edo= $this->cuentas_model->update_edo_firmante($id,$edo);
      echo $update_edo;

    }
     function busca_edo_pregunta()
  {
    $id=$_POST['id'];
    $datos= $this->cuentas_model->status_pregunta($id);
     while($dato=$datos->fetch_assoc()) 
        {
            echo $dato['status'];
        }
    }

      function actualiza_edo_pregunta()
    {
      $id=$_POST['id'];   
      $edo=$_POST['edo'];
      $update_edo= $this->cuentas_model->update_edo_pregunta($id,$edo);
      echo $update_edo;

    }
    function guarda_token()
    {
      $cta=$_POST['cta'];   
      $cod_token=$_POST['cod_token'];
      $f_token=$this->cambiaf_a_mysql($_POST['f_token']);   
      $resp_token=$_POST['resp_token'];
      $vence=$_POST['vence'];
      $fecha_vence=$this->cambiaf_a_mysql($_POST['fecha_vence']);
      $obs_token=$_POST['obs_token'];
      $status_token=$_POST['status_token'];
      $guarda_token= $this->cuentas_model->guarda_token($cta,$cod_token,$f_token,$resp_token,$vence,$fecha_vence,$obs_token,$status_token);
      echo $guarda_token;

    }
      function busca_edo_token()
      {
        $id=$_POST['id'];
        $datos= $this->cuentas_model->busca_edo_token($id);
         while($dato=$datos->fetch_assoc()) 
            {
                echo $dato['idstatus_token'];
            }
        }
          function actualiza_edo_token()
    {
      $id=$_POST['id'];   
      $edo=$_POST['edo'];
      $update_edo= $this->cuentas_model->update_edo_token($id,$edo);
      echo $update_edo;

    }
    function sendmail_cuenta()
    {
        date_default_timezone_set('Etc/UTC');

        require './librerias/phpMailer/PHPMailerAutoload.php';
        $id= $_POST['cta'];
        $texto=$_POST['texto'];
        $busca_cuenta= $this->cuentas_model->busca_cuenta_id($id);
        $emails= $_REQUEST['emails'];
        $datos=json_decode($emails,true);
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
          while($dato=$busca_cuenta->fetch_assoc()) 
            {
                $cuenta=$dato['num_cuenta'];
                $clabe=$dato['clabe'];
                $banco=$dato['banco'];
                $sucursal=$dato['sucursal'];
                $updated_at=$dato['updated_at'];
                $estado=$dato['estado'];
                $folio=$dato['folio'];
                $fecha=$dato['fecha'];
                $id_edo=$dato['idstatus_cuenta'];
                $observaciones=$dato['observaciones'];
                if($id_edo==1)
                {
                    $edo_nombre="ACTIVADA";
                }
                 elseif($id_edo==2)
                {
                    $edo_nombre="CANCELADA";
                }
                 elseif($id_edo==3)
                {
                    $edo_nombre="BLOQUEADA";
                }
                else
                {
                    $edo_nombre=$estado;
                }
                //contenido del correo
                $contents="
               <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <title>AVISO DE CAMBIO DE ESTADO DE CUENTA</title>
                </head>
                <body>
                    <div style'margin-left:5%;'>
                        <h1 style='color:#000;'>Aviso de cuenta $estado</h1>
                        <h2 style='color:#000;'>CUENTA:$cuenta</h2><br>
                        <span style='color:#000;'>Por medio del presente le informamos que la cuenta <strong>$cuenta</strong> del banco <strong>$banco</strong> ha sido <strong>$edo_nombre</strong>, el cambio de estado se llevo a cabo en la fecha y hora: <strong>$updated_at</strong>, por tal motivo le pedimos tomar en cuenta las consideraciones necesarias en relación a esta cuenta.</span>
                        <br>
                        <p style='color:#000;'>$texto</p>
                        <br><br>
                         <table style='width:60%' border='1'>
                          <tr>
                            <td>Folio</td>
                            <td>Estado</td>
                            <td>Fecha</td>
                            <td>Observaciones</td>
                          </tr>
                          <tr>
                            <td>$folio</td>
                             <td>$estado</td>
                            <td>$fecha</td>
                            <td>$observaciones</td>
                          </tr>
                        </table> 
                        <br><br>
                        <strong style='color:#000;'>¡Saludos!</strong><br><br>
                        <img src='./images/logo-integra-xl.png'/><br>
                        <span style='color:#686767;'>Por favor no responda a este mensaje, este es un correo automatico enviado a travez de la plataforma <strong>INTEGRA FINANZAS</strong>.</span>
                        
                    </div>
                </body>
                </html>";
            }

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "integra.finanzas15@gmail.com";

        //Password to use for SMTP authentication
        $mail->Password = "d3s4rr0ll0";

        //Set who the message is to be sent from 
        $mail->setFrom('integra.finanzas15@gmail.com', 'INTEGRA FINANZAS');

        //Set an alternative reply-to address
        $mail->addReplyTo('integra.finanzas15@gmail.com', 'INTEGRA FINANZAS');

        //Set who the message is to be sent to
         foreach ($datos as $key => $value) 
         {
            $email=$value['email'];
            $nombre=$value['nombre_emp'];

            $mail->addAddress($email, $nombre_emp);
         }
        //Set the subject line
        $mail->Subject = 'CAMBIO DE ESTADO DE CUENTA';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($contents);

        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
       // $mail->addAttachment('./images/logo-integra.png');

        //send the message, check for errors
        if (!$mail->send()) {
            echo "Error al enviar mensaje: ".$mail->ErrorInfo;;
        } else {
            echo 1;
        }
          
    }
    function busca_cuentas_plaza_soc()
    {
        $plaza= $_REQUEST['plaza'];
        $soc= $_REQUEST['soc'];
        $cuentas = $this->cuentas_model->busca_cuentas_plaza_soc($plaza,$soc);
        $total=count($cuentas->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option value="00" selected>-- No existen cuentas --</option>';
         }
         else
         {
            echo ' <option value="00" selected>-- Seleccione la cuenta --</option>';
            while($cta=$cuentas->fetch_assoc())
            {
                echo '<option  value="'.$cta['idcuenta'].' ">'.$cta['num_cuenta'].'</option>'; 
            }
         }
    }
     function filtra_cuentas_banco()
    {
        $plaza= $_REQUEST['plaza'];
        $soc= $_REQUEST['soc'];
        $banco= $_REQUEST['banco'];
        $cuentas = $this->cuentas_model->filtra_cuentas_banco($plaza,$soc,$banco);
        $total=count($cuentas->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option value="00" selected>-- No existen cuentas --</option>';
         }
         else
         {
            echo ' <option value="00" selected>-- Seleccione la cuenta --</option>';
            foreach($cuentas as $cta)
            {
                echo '<option  value="'.$cta['idcuenta'].' ">'.$cta['num_cuenta'].'</option>'; 
            }
         }
    }
    function get_archivos()
    {
        $plazas = $this->cuentas_model->all_plazas();
        $bancos = $this->cuentas_model->all_bancos();
        require('views/cuentas-bancarias/archivos.php');
    }
     function busca_archivos()
    {   
       $cuenta= $_REQUEST['cuenta'];
       $archivos = $this->cuentas_model->consulta_archivos($cuenta);
       $array_archivos = array(); //creamos un array
 
        while($file=$archivos->fetch_assoc()) 
        { 
            $id=$file['idarchivo_cuenta'];
            $cuenta=$file['idcuenta'];
            $nom=$file['org_nombre'];
            $titulo=$file['titulo'];
            $desc=$file['descripcion'];
            $n_nombre="<a href='/systema/finanzas/uploads/cuenta$cuenta /".$file['nuevo_nombre']."' target='_BLANK'>".$file['org_nombre']."</a>";
            $tipo=$file['tipo'];
            $act= $file['updated_at'];
            $filename="./uploads/cuenta".$cuenta."/".$n;
            $array_archivos[] = array('id'=> $id,'org_nom'=>$nom,'titulo'=>$titulo,'desc'=> $desc,'tipo'=> $tipo,'desc'=>$desc,'act'=>$act,'n_nombre'=>$n_nombre);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_archivos);
        echo $json_string;
    }
     function upload_file()
    {
        date_default_timezone_set('America/Mexico_City');
        $date=date('Y-m-d');
        $cuenta=$_REQUEST['cuenta'];
        $titulo=$_REQUEST['titulo'];
        $descripcion=$_REQUEST['descripcion'];
        $folder = "./uploads/cuenta$cuenta/";
        $uploadOk = 1;
        //generamos una cadena aleatoria
        $random= $this->generateRandomString();
        $maxlimit = 50000000; // Máximo límite de tamaño (en bits)
        $allowed_ext ="csv,xlsx,jpg,png"; // Extensiones permitidas (usad una coma para separarlas)
        $overwrite = "yes"; // Permitir sobreescritura? (yes/no)
        $match = ""; 
        $filesize = $_FILES['fileToUpload']['size']; // toma el tamaño del archivo
        $old_name = strtolower($_FILES['fileToUpload']['name']); // toma el nombre del archivo y lo pasa a minúsculas
        $name=$_FILES['fileToUpload']['name'];
        $file_ext = pathinfo($name, PATHINFO_EXTENSION);
        if(!file_exists($folder))
        {
        mkdir ($folder);
        } 
        $filename= "file_".$date."_".$random.".".$file_ext;
        // comprobar tamaño de archivo
        if($filesize < 1){ // el archivo está vacío
           $error .= "- Archivo vacío.<br>";
        }elseif($filesize > $maxlimit){ // el archivo supera el máximo
           $error .= "- Este archivo supera el máximo tamaño permitido.<br>";
        }

        if(@$error){
           print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
        }
        else{

           if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $folder.$filename))
           { // Finalmente sube el archivo
                //rename($folder.$filename,$folder.$old_name);
                echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  La importacion de los datos se realizo exitosamente</strong></div>";       
                $guarda_archivo= $this->cuentas_model->guarda_archivo($cuenta,$name,$filename,$file_ext,$titulo,$descripcion);
                if($guarda_archivo != 1)
                {
                    $error .= 'Ocurrio un error al guardar el archivo en la base de datos';
                }             
            }
            else
            {
                echo "<div class='alert alert-danger'><strong><i class='fa fa-info-circle'></i>  Ha ocurrido un error al subir el archivo, intentelo de nuevo</strong></div>";                    

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
    function borrar_archivo()
    {
        $id=$_POST['id'];
        $borrar= $this->cuentas_model->borrar_archivo($id);
        echo $borrar;
    }
     function cancela_domicilio()
    {
        $id=$_POST['id'];
        $cancelar = $this->cuentas_model->cancela_domicilio($id);
        echo $cancelar;
    }
    function detalle_consulta()
    {
        $cta=$_REQUEST['cta'];
        $firmantes=$this->cuentas_model->detalle_firmante($cta);
        $html= "<div class='col-lg-offset-1'>";
        while($firm=$firmantes->fetch_assoc()) 
        { 
            $id=$firm['idfirmante'];
            $firmante=$firm['firmante'];
            $status=$firm['status'];
            if($status==1)
            {
                $estado= '<span  class="label label-success">Activo</label></span>';
            }
            else
            {
                $estado= '<span  class="label label-default">Cancelado</label></span>';
            }
            $html .="<strong>Firmante: </strong>".$firmante.
                    " ".$estado."<br>";
         
        } 
        $domicilio=$this->cuentas_model->detalle_domicilio($cta);
        $html .= "<strong>Domicilio actual: </strong>";
         while($dom=$domicilio->fetch_assoc()) 
        { 
            $html .="".$dom['domicilio']."-<strong>Periodo inicio:</strong>".$dom['periodo_inicio']."<strong>  Fin: </strong>".$dom['periodo_inicio'];
        }
        $datos_usuario= $this->cuentas_model->detalle_usuarios($cta);
         $html .= "<br><strong>Usuario cuenta: </strong>";
         while($us=$datos_usuario->fetch_assoc()) 
        { 
            $html .="".$us['usuario']." <strong>   Sociedad usuario: </strong>".$us['razonsocial'];
        }
        $html .="</div>";
        echo $html;
    } 
    function estados_cuenta()
    {
        $plazas = $this->cuentas_model->all_plazas();
        $bancos = $this->cuentas_model->all_bancos();
        $sociedades = $this->cuentas_model->all_sociedad();
        require('views/cuentas-bancarias/estados-cuenta.php'); 
    }
    function personal_externo()
    {
       $plaza = $_REQUEST['plaza'];
       $soc = $_REQUEST['soc'];
       if($plaza != "" and $soc != "" )
       {
           $externos = $this->cuentas_model->all_externos($plaza,$soc);
           $array_ext = array(); //creamos un array
            while($ext=$externos->fetch_assoc()) 
            { 
                $id=$ext['id_externo'];
                $nombre=$ext['nombre_completo'];
                $rfc=$ext['rfc'];
                $obs=$ext['observaciones'];
                $array_ext[] = array('Id'=> $id,'nombre'=>$nombre,'rfc'=>$rfc,'obs'=>$obs);
             
            }
            //Creamos el JSON
            $json_string = json_encode($array_ext);
            echo $json_string; 
        }
    }
     function nuevo_externo()
    {
      $nombre=$_REQUEST['nombre'];
      $rfc=$_REQUEST['rfc'];
      $obs=$_REQUEST['obs'];
      $plaza=$_REQUEST['plaza'];
      $soc=$_REQUEST['soc'];
      $nuevo=$this->cuentas_model->guarda_externo($nombre,$rfc,$obs,$plaza,$soc);
      echo $nuevo;
    }
     function busca_externos()
    {
        $plaza=$_REQUEST['plaza'];
        $soc=$_REQUEST['soc'];
        $as= $this->cuentas_model->busca_externos($plaza,$soc);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existe personal --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione persona--</option>';
            foreach($as as $a)
            {
                echo '<option  value="'.$a['id_externo'].'">'.$a['nombre_completo'].'</option>'; 
            }
         }
    }
    function upload_estadoCta()
    {
        date_default_timezone_set('America/Mexico_City');
        $dateTime =date('Y-m-d H:i:s');
        $anio = $_POST['anioId'];
        $mes = $_POST['mesId'];
        $usuario = 1;
        $cta = $_POST['ctaId'];
        $busca_mes = $this->cuentas_model->nombre_mes($mes);
          while($b=$busca_mes->fetch_assoc()) 
            { 
                $nombre_mes = $b['nombre_mes'];
            }
        $folder = "/var/www/html/systema/finanzas/uploads/estados_cuenta/$anio/$cta/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $uploadOk = 1;
        //generamos una cadena aleatoria
        $random = $this->generateRandomString();
        $maxlimit = 50000000; // Máximo límite de tamaño (en bits)
        $allowed_ext ="csv,xlsx,pdf,docx,xlsm"; // Extensiones permitidas (usad una coma para separarlas)
        $overwrite = "yes"; // Permitir sobreescritura? (yes/no)
        $match = ""; 
        $filesize = $_FILES['fileToUpload']['size']; // toma el tamaño del archivo
        $filename = strtolower($_FILES['fileToUpload']['name']); // toma el nombre del archivo y lo pasa a minúsculas
        if(!$filename || $filename==""){ 
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

        if(!@$error){
            $ubicacion=$folder.$filename;
            $nvo_nombre= $nombre_mes."_".$anio;
            $ext = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'],'.'));
           if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$folder.$nvo_nombre.$ext))
           {    
                $archivo = $nvo_nombre.$ext;
                $busca =  $this->cuentas_model->busca_mes_estado($mes);
                if(count($busca) >0)
                {  
                    $dat = $busca->fetch_assoc();
                    if($dat['idarchivo_estado']!= "")
                    {
                        $update_estado = $this->cuentas_model->update_edoCuenta($dat['idarchivo_estado'],$archivo);
                        if($update_estado == 1)
                        {
                            echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  Archivo subido correctamente</strong></div>";                    
                        } 
                    }
                     else
                {
                    $guarda_estado = $this->cuentas_model->insert_edoCuenta($mes,$cta,$archivo,$usuario,$dateTime);
                    if($guarda_estado == 1)
                    {
                        echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  Archivo subido correctamente</strong></div>";                    
                    } 
                }

                }
                else
                {
                    $guarda_estado = $this->cuentas_model->insert_edoCuenta($mes,$cta,$archivo,$usuario,$dateTime);
                    if($guarda_estado == 1)
                    {
                        echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  Archivo subido correctamente</strong></div>";                    
                    } 
                }
        }
            else
            {
                echo "<div class='alert alert-danger'><strong><i class='fa fa-info-circle'></i>  Ha ocurrido un error al subir el archivo, intentelo de nuevo</strong></div>";                    
 
            }
           
        }
        else{

          print "<div class='alert alert-danger'><strong><i class='fa fa-info-circle'></i>Se ha producido el siguiente error al subir el archivo:</strong><br> $error</div>"; // Muestra los errores

        }

    }
     //checklist estados de cuenta
      function get_estados()
    {   
        $cta = $_REQUEST['cta'];
        $anio = $_REQUEST['anio'];
        $meses = $this->cuentas_model->mes_anio($anio);
        $datos = $this->cuentas_model->datos_cuenta($cta);
        while($dato= $datos->fetch_assoc())
        {
            $num_cuenta = $dato['num_cuenta'];
            $banco = $dato['nombre'];
            $id_cta = $dato['idcuenta'];
        }
        require('views/cuentas-bancarias/checklist-cuenta.php');
    }
     function mes_estados()
    {   
       $cuenta= $_REQUEST['cuenta'];
       $anio= $_REQUEST['anio'];
       $archivos = $this->cuentas_model->consulta_estadosCta($cuenta,$anio);
       $array_archivos = array(); //creamos un array
 
        while($file=$archivos->fetch_assoc()) 
        { 
            $id=$file['idarchivo_cuenta'];
            $cuenta=$file['idcuenta'];
            $nom=$file['org_nombre'];
            $titulo=$file['titulo'];
            $desc=$file['descripcion'];
            $n_nombre="<a href='/systema/finanzas/uploads/cuenta$cuenta /".$file['nuevo_nombre']."' target='_BLANK'>".$file['org_nombre']."</a>";
            $tipo=$file['tipo'];
            $act= $file['updated_at'];
            $filename="./uploads/cuenta".$cuenta."/".$n;
            $array_archivos[] = array('id'=> $id,'org_nom'=>$nom,'titulo'=>$titulo,'desc'=> $desc,'tipo'=> $tipo,'desc'=>$desc,'act'=>$act,'n_nombre'=>$n_nombre);
         
        } 
        //Creamos el JSON
        $json_string = json_encode($array_archivos);
        echo $json_string;
    }
     function get_meses()
    {
        $cta= $_REQUEST['cta'];
        $anio= $_REQUEST['anio'];
        $meses = $this->cuentas_model->mes_anio($cta,$anio);
        $total=count($meses->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option value="" selected>-- No hay meses disponibles --</option>';
         }
         else
         {
            echo ' <option value="" selected>-- Seleccione el mes --</option>';
            while($mes=$meses->fetch_assoc())
            {
                echo '<option  value="'.$mes['idmes_anio'].'">'.$mes['nombre_mes'].'</option>'; 
            }
         }

    }
    function busca_estados()
    {   
       $cta= $_REQUEST['cta'];
       $anio= $_REQUEST['anio'];
       $meses = $this->cuentas_model->mes_anio($anio);
       $i=0;
       $nom= "";
       $array_archivos = array(); //creamos un array
        while($dato=$meses->fetch_assoc()) 
        { 
                $archivos = $this->cuentas_model->busca_estados($cta,$dato['idmes_anio']);
                $id = "";
                $nom= "";
                $n_nombre= "";
                $act= "";
                while($file=$archivos->fetch_assoc()) 
                { 
                    $id=$file['idarchivo_estado'];
                    $nom=$file['org_nombre'];
                    $id_mes=$file['idmes_anio'];
                    $filename="./uploads/estados_cuenta/".$anio.'/'.$cta.'/';
                   if($nom != "")
                    {
                        $mes="<span style='color:#267B36;'><i class='fa fa-check'></i>".$dato['nombre_mes']."</span>";
                        $n_nombre="<a href='/systema/finanzas/index.php?c=cuentas&f=muestra_archivo&cta=".$cta."&anio=".$anio." target='_BLANK'>".$file['org_nombre']."</a>";
                        $act= $file['updated_at'];
                    }
                    else
                    {
                        $mes="<span style='color:#9C3030;'><i class='fa fa-times'></i>".$dato['nombre_mes']."</span>";
                        $n_nombre="Sin archivo";
                        $act= "n/a";

                    }
                     $array_archivos[$i] = array('id_mes'=> $dato['idmes_anio'],'nombre_mes'=> $mes,'act'=>$act,'archivo'=>$n_nombre);
                    $i++;
            }
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_archivos);
        echo $json_string;
    }
    function muestra_archivo()
    {
        $cta = $_REQUEST['cta'];
        $anio = $_REQUEST['anio'];
        require('views/cuentas-bancarias/frame.php'); 
    }
 function importar_cuentas()
    {
        ini_set('max_execution_time', 300);
        $folder = "./uploads/";
        $uploadOk = 1;
        $random = $this->generateRandomString();
        $maxlimit = 50000000; 
        $allowed_ext ="csv,xlsx"; 
        $overwrite = "yes";
        $match = ""; 
        date_default_timezone_set('America/Mexico_City');
        $fecha_actual  =date('Y-m-d H:i:s');
        $filesize = $_FILES['fileToUpload']['size']; 
        $filename = strtolower($_FILES['fileToUpload']['name']); 
        if(!$filename || $filename==""){ 
           $error="- Ningún archivo selecccionado para subir.<br>";
        }elseif(file_exists($folder.$filename) && $overwrite=="no"){ 
           @unlink($_GET[$folder.$filename]); 
        }
        if($filesize < 1){ 
           $error .= "- Archivo vacío.<br>";
        }elseif($filesize > $maxlimit){ 
           $error .= "- Este archivo supera el máximo tamaño permitido.<br>";
        }

        $file_ext = preg_split("/\./",$filename); 
        $allowed_ext = preg_split("/\,/",$allowed_ext); 
        foreach($allowed_ext as $ext){
           if($ext==$file_ext[1]) $match = "1"; 
        }
        if(!$match){
           $error .= "- Este tipo de archivo no está permitido: $filename<br>";
        }

        if(@$error){
           print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
        }
        else
        { 

            $ubicacion=$folder.$filename;

           if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $ubicacion))
           { 
                $vaciar_tabla= $this->cuentas_model->vacia_tempCuentas();
                $guarda_temporal= $this->cuentas_model->guarda_tempCuentas($ubicacion);
                $busca_temporal= $this->cuentas_model->busca_tempCuentas();  
                $no_cliente = 0;
                $no_contrato = 0;
                  while($b=$busca_temporal->fetch_assoc())
                {
                    $busca_soc = $this->cuentas_model->busca_soc_nombre($b['sociedad']);
                    while($s=$busca_soc->fetch_assoc())
                    {
                        $soc = $s['idempresa'];

                    }
                    $busca_plaza = $this->cuentas_model->busca_plaza_nombre($b['plaza']);
                    while($p=$busca_plaza->fetch_assoc())
                    {
                        $plaza = $p['idplaza'];
                    }
                    $busca_area = $this->cuentas_model->busca_area_op($b['area']);
                    while($a=$busca_area->fetch_assoc())
                    {
                        $area = $a['idarea_operacion'];
                    }
                    $cta= $b['num_cuenta'];
                    $clabe = $b['clabe'];
                   if( $b['banco'] != "")
                    {
                        $busca_banco = $this->cuentas_model->buscar_banco_nombre($b['banco']); 
                          while($ban=$busca_banco->fetch_assoc())
                        {
                            $banco = $ban['idbancos'];
                        }
                        if($b['sucursal'] != "" or $b['sucursal'] != "-")
                        {
                            $busca_suc = $this->cuentas_model->buscar_suc_nombre($b['sucursal'],$b['nombre_suc']); 
                            if(count($busca_suc->fetch_assoc()) > 0)
                            {
                                  while($sc=$busca_suc->fetch_assoc())
                                {
                                    $id_suc = $sc['idsucursal'];
                                }
                            }
                            else
                            {
                                $id_suc = $this->cuentas_model->guarda_suc($banco,$b['sucursal'],$b['nombre_suc']); 
                            }
                        }
                        else
                        {
                            $id_suc = 0;
                        }
                    }
                   $nom_tipo= $b['tipo'];
                   $tipo_op = $b['tipo_op'];
                   $contrato_nomina = "Otros";
                   $tipo_cuenta = $b['tipo'];
                   if($b['fecha_ap'] != "" or $b['fecha_ap']!="-" or !empty($b['fecha_ap']))
                    {
                        $f_alta = $this->cambiaf_a_mysql($b['fecha_ap']);
                    }
                    else
                    {
                        $f_alta = "0000-00-00";
                    }
                   $saldo = 0;
                   $no_cliente = 0;
                   $no_contrato = 0;
                   $plaza_user = 0;
                   $soc_user = 0;
                   $moneda = "MXN";
                   if( $b['responsable'] != "" or $b['responsable'] != "-")
                    {
                        $busca_resp = $this->cuentas_model->busca_emp_rfc($b['responsable']); 
                        if(count($busca_resp) > 0)
                        {
                            while($res=$busca_resp->fetch_assoc())
                            {
                                $responsable = $res['Id_empleado'];
                                $usuario = $res['Id_empleado'];
                                $personal_tipo = 1;
                            }
                        }
                        else
                        {
                            $rfc = "";
                            $obs = "";
                            $plaza = "";
                            $soc = "";
                            $nombre = $b['responsable'];
                            $personal_tipo = 2;
                            $guarda_externo = $this->cuentas_model->guarda_externo($nombre,$rfc,$obs,$plaza,$soc);
                            $usuario = $guarda_externo;
                            $responsable= $guarda_externo;
                        }
                     $fecha_resp ="";
                    }
                        $cuenta= $this->cuentas_model->guardar_cta($plaza,$soc,$area,$cta,$clabe,$banco, $id_suc,$f_alta,$personal_tipo, $usuario,$plaza_user,$soc_user,$no_contrato,$no_cliente,$contrato_nomina,$tipo_op,$tipo_cuenta,$saldo,$moneda, $fecha_actual);
                        if($responsable != "")
                        {
                             $idresp= $this->cuentas_model->inserta_resposable($cuenta,$responsable,$personal_tipo,$plaza,$soc,$fecha_resp,$fecha_actual);
                            //actualizamos el responsable de la cuenta
                            $update_resp= $this->cuentas_model->update_responsable($cuenta,$responsable);
                        }

                           if($b['codigo_dom'] != "" and is_numeric($b['codigo_dom']))
                    {
                        $dom_ini = "0000-00-00";
                        $dom_fin = "0000-00-00";
                        $domicilio = $b['codigo_dom'];
                        $historial_dom= $this->cuentas_model->inserta_historial($cuenta,$domicilio,$dom_ini,$dom_fin,$fecha_actual);
                        $update_dom = $this->cuentas_model->update_dom_cuenta($cuenta, $historial_dom);
                    }
                   if( $b['firmantes'] != "" or $b['firmantes'] != "-")
                    {
                       $firmantes = explode("/", $b['firmantes']);
                        $plaza_firm=0;
                        $soc_firm=0;
                       foreach ($firmantes as $firm) {
                            $b_firm= trim($firm);
                           $busca_firm = $this->cuentas_model->busca_emp_rfc($b_firm);
                           if(count($busca_firm)>0)
                           {
                              $tipo_firm = 1;
                               while($f=$busca_firm->fetch_assoc())
                               {

                                    $guarda_firmante= $this->cuentas_model->guarda_firmante($cuenta,$f['Id_empleado'],$plaza_firm,$tipo_firm,$soc_firm);
                               }
                            }
                            else
                            {
                                $tipo_firm = 2;
                                $rfc="";
                                $obs="";
                                $guarda_externo = $this->cuentas_model->guarda_externo($b_firm,$rfc,$obs,$plaza_firm,$soc_firm);
                                 $guarda_firmante= $this->cuentas_model->guarda_firmante($cuenta,$guarda_externo,$plaza_firm,$tipo_firm,$soc_firm);
                            }
                       }
                    }
                    //unset($firmantes);
                    $status = $b['status'];
                    if($status == 0)
                    {
                        $status = 2;
                    }
                    $folio = "";
                    $fecha_bloq = "";
                    $coments = "";

                    $status_actual= $this->cuentas_model->guarda_status_cuenta($cuenta,$status,$folio,$fecha_bloq,$coments,$fecha_actual);
              //actualizamos el estado actual de la cuenta bancaria
              $update = $this->cuentas_model->update_status_historial($cuenta, $status_actual);
                }
                $vaciar_tabla = $this->cuentas_model->vacia_tempCuentas();
                echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  La importacion de los datos se realizo exitosamente</strong></div>";                    
            }
        }
    }
       function domicilios()
    {   
        require('views/cuentas-bancarias/domicilios.php');
    }
    //muestra todos los domicilios
      function muestra_dom()
    {   
       $domicilios = $this->cuentas_model->all_domicilios();
       $array_domicilio = array(); //creamos un array
 
        while($dom = $domicilios->fetch_assoc()) 
        { 
            $id = $dom['id_domicilio'];
            $domicilio = $dom['domicilio'];
            if($dom['periodo_inicio'] != "0000-00-00")
            {
                $inicio = $this->cambiaf_a_normal($dom['periodo_inicio']);
            }
            else
            {
                $inicio = "Sin fecha";
            }
             if($dom['periodo_fin'] != "0000-00-00")
            {
                $fin = $this->cambiaf_a_normal($dom['periodo_fin']);
            }
             else
            {
                $fin = "Sin fecha";
            }
            $estado = $dom['edo_dom'];
            if($estado == 1)
            {
                $nom_estado = "<span  class='label label-success'>ACTIVO</label>";
            }
            else
            {
                 $nom_estado = "<span  class='label label-default'>CANCELADO</label>";
            }
            $array_domicilio[] = array('id'=> $id,'domicilio'=>$domicilio,'periodo_inicio'=> $inicio,'periodo_fin'=>$fin, 'estado' => $nom_estado);
         
        }
            
        $json_string = json_encode($array_domicilio);
        echo $json_string;

    }
    //busca un domicilio en particular
      function buscar_domicilio()
    {
        $id=$_REQUEST['id'];
        $domicilios=$this->cuentas_model->busca_dom_id($id);
        $array_domicilio = array(); 

        while($dom=$domicilios->fetch_assoc()) 
        { 
            $id = $dom['id_domicilio'];
            $cp =$dom['codigopostal'];
            $mun =$dom['delegacionmunicipio'];
            $edo =$dom['estado'];
            $calle = $dom['calle'];
            $num_ext =$dom['num_ext'];
            $num_int = $dom['num_int'];
            $inicio = $this->cambiaf_a_normal($dom['periodo_inicio']);
            $fin =  $this->cambiaf_a_normal($dom['periodo_fin']);
            $info_extra = $dom['info_extra'];
            $Idcol = $dom['Id'];
            $status = $dom['status_dom'];
            $array_domicilio[] = array('id'=> $id,'cp'=>$cp,'num_ext'=> $num_ext,'num_int'=>$num_int,'inicio'=>$inicio,'fin'=>$fin,'info_extra'=>$info_extra,'Idcol'=>$Idcol,'calle'=>$calle,'mun'=>$mun,'edo'=>$edo,'status'=>$status);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_domicilio);
        echo $json_string;
    }
    //actualiza los datos de un domicilio en especifico
      function update_datos_domicilio()
    {
        $cp=$_POST['cp'];
        $id=$_POST['id'];
        $ext=$_POST['ext'];
        $int=$_POST['int'];
        $info_extra=$_POST['info_extra'];
        $calle=$_POST['calle'];
        $status_dom = $_POST['status_dom'];
        $inicio= $this->cambiaf_a_mysql($_POST['inicio_dom']);
        $fin = $this->cambiaf_a_mysql($_POST['fin_dom']);
        date_default_timezone_set('America/Mexico_City');
        $dateTime =date('Y-m-d H:i:s');
        $guarda= $this->cuentas_model->update_domicilio($cp,$id,$ext,$int,$info_extra,$calle,$inicio,$fin,$status_dom);
        echo $guarda;
    }
    function cambiaf_a_mysql($fecha) {
        if($fecha!= "" or !empty($fecha) or $fecha!="-")
        {
            $arr = explode('/', $fecha);
            if(count($arr) >=2 )
            {
                $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
            }
            else
            {
                $newDate = "0000-00-00";  
            }
        }
        else
        {
          $newDate = "0000-00-00";  
        }
    return $newDate;
}
 function cambiaf_a_normal($fecha) {
     $arr = explode('-', $fecha);
    $newDate = $arr[2].'/'.$arr[1].'/'.$arr[0];
    return $newDate;
}
    function consulta_sucursales()
    {
        $id= $_REQUEST['id'];
        $sucursales= $this->cuentas_model->busca_suc_banco($id);
        $array_suc = array(); //creamos un array
 
        while($suc=$sucursales->fetch_assoc()) 
        { 
            $id=$suc['idsucursal'];
            $nombre=$suc['nombre'];
            $num_suc=$suc['num_suc'];
            $array_suc[] = array('id'=> $id,'nombre'=>$nombre,'num_suc'=>$num_suc);

        }
         //Creamos el JSON
            $json_string = json_encode($array_suc);
            echo $json_string;

    }
      function guarda_sucursal()
    {
        $nombre=$_POST['nom'];
        $num_suc=$_POST['num'];
        $banco = $_POST['id'];
        $guarda = $this->cuentas_model->guarda_suc($banco,$num_suc,$nombre);
        echo $guarda;
    }
     function borra_sucursal()
    {
        $id=$_POST['banco'];
        $borrar=$this->cuentas_model->borra_sucursal($id);
        echo $borrar;
    }
    function membretes()
    {
        require('views/cuentas-bancarias/membretes.php');

    }
    function busca_membretes()
    {
        $membretes = $this->cuentas_model->all_sociedad();
        $array_mem = array(); 

        while($mem = $membretes->fetch_assoc()) 
        { 
            $id=$mem['idempresa'];
            $soc = $mem['razonsocial'];
            $filename ="./uploads/formatos/membretes/".$mem['idempresa'].".jpg";
            if (file_exists($filename)) 
            {
                $archivo = '<a target="_BLANK" href="./uploads/formatos/membretes/'.$mem['idempresa'].'.jpg">membrete_'.$soc.'</a>';
            } else 
            {
                $archivo = "Sin membrete";
            }
          
            $array_mem[] = array('id'=> $id,'soc'=>$soc,'archivo'=> $archivo);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_mem);
        echo $json_string;
    }
    function subir_membrete()
    {
        date_default_timezone_set('America/Mexico_City');
        $date=date('Y-m-d');
        $id_soc=$_REQUEST['id_soc'];
        $folder = "./uploads/formatos/membretes/";
        $uploadOk = 1;
        $random= $this->generateRandomString();
        $maxlimit = 50000000; 
        $allowed_ext ="jpg"; 
        $overwrite = "yes"; 
        $match = ""; 
        $filesize = $_FILES['fileToUpload']['size']; 
        $old_name = strtolower($_FILES['fileToUpload']['name']); 
        $name=$_FILES['fileToUpload']['name'];
        $file_ext = pathinfo($name, PATHINFO_EXTENSION);
        if(!file_exists($folder))
        {
        mkdir ($folder);
        } 
        $filename= $id_soc.".".$file_ext;
        // comprobar tamaño de archivo
        if($filesize < 1){ // el archivo está vacío
           $error .= "- Archivo vacío.<br>";
        }elseif($filesize > $maxlimit){ // el archivo supera el máximo
           $error .= "- Este archivo supera el máximo tamaño permitido.<br>";
        }

        if(@$error){
           print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
        }
        else{
            $nvo_nombre= $id_soc.'.jpg';
            $ext = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'],'.'));
           if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$folder.$nvo_nombre))
           { 
                echo "<div class='alert alert-success'><strong><i class='fa fa-info-circle'></i>  La importacion de los datos se realizo exitosamente</strong></div>";      
            }
            else
            {
                echo "<div class='alert alert-danger'><strong><i class='fa fa-info-circle'></i>  Ha ocurrido un error al subir el archivo, intentelo de nuevo</strong></div>";                    

            }
        } 
    }
    
}

?>
