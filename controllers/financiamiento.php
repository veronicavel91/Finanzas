<?php  session_start();

//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/financiamiento_model.php");

class financiamiento extends Common
{
    public $financiamiento_model;

    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->financiamiento_model = new financiamiento_model();
        $this->financiamiento_model->connect();
    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->financiamiento_model->close();
    }
     //vista financiamiento
      function get_finan() 
    {   
        $plazas = $this->financiamiento_model->all_plazas();
        $promotores = $this->financiamiento_model->all_personal();
        $sociedades = $this->financiamiento_model->all_sociedades();
        $sociedades_fact = $this->financiamiento_model->all_sociedades();
        $status = $this->financiamiento_model->all_status();
        $status_fact = $this->financiamiento_model->status_fact();
        $tipos_mov = $this->financiamiento_model->tipos_mov_deposito();
        $emps = $this->financiamiento_model->all_personal();
        $estados_cheque = $this->financiamiento_model->estados_cheque();
        $status_desc= $this->financiamiento_model->estados_descuento();
        $status_nota= $this->financiamiento_model->status_nota_credito();
        $edos_abonos= $this->financiamiento_model->status_abono();
        session_destroy();
        require('views/financiamiento/registro-financiamiento.php');
    }
     function detalle_financiamiento() 
    {   
        $plazas = $this->financiamiento_model->all_plazas();
        $promotores = $this->financiamiento_model->all_personal();
        $sociedades = $this->financiamiento_model->all_sociedades();
        $sociedades_fact = $this->financiamiento_model->all_sociedades();
        $status = $this->financiamiento_model->all_status();
        $status_fact = $this->financiamiento_model->status_fact();
        $tipos_mov = $this->financiamiento_model->tipos_mov_deposito();
        $emps = $this->financiamiento_model->all_personal();
        $estados_cheque = $this->financiamiento_model->estados_cheque();
        $status_desc= $this->financiamiento_model->estados_descuento();
        $status_nota= $this->financiamiento_model->status_nota_credito();
        $edos_abonos= $this->financiamiento_model->status_abono();
        require('views/financiamiento/datos-financiamiento.php');
    }
         function financiamiento()
    {   
        $plazas = $this->financiamiento_model->all_plazas();
        $promotores = $this->financiamiento_model->all_personal();
        require('views/financiamiento/nuevo_financiamiento.php');
    }
    //funcion para buscar clientes cuando se selecciona una plaza
    function busca_clientes()
    {
        $soc=$_REQUEST['soc'];
        $clientes= $this->financiamiento_model->clientes_empresa($soc);
        $total=count($clientes->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen clientes --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione el cliente--</option>';
            while($cliente=$clientes->fetch_assoc())
            {
                echo '<option  value="'.$cliente['id'].'">'.$cliente['razon'].'</option>'; 
            }
         }

    }
     function busca_autorizado()
    {
        $plaza=$_REQUEST['plaza'];
        $soc=$_REQUEST['soc'];
        $as= $this->financiamiento_model->autorizados($plaza,$soc);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen autorizadores --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione autorizador--</option>';
            foreach($as as $a)
            {
                echo '<option  value="'.$a['id_empleado'].'">'.$a['nombre'].'</option>'; 
            }
         }

    }
     function aut_plaza_soc()
    {
        $plaza=$_REQUEST['plaza'];
        $soc=$_REQUEST['soc'];
        $as= $this->financiamiento_model->aut_plaza_soc($plaza, $soc);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen empleados --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione autorizador--</option>';
            while($a=$as->fetch_assoc())
            {
                echo '<option  value="'.$a['Id_empleado'].'">'.$a['nombre_emp'].'</option>'; 
            }
         }

    }
   
    //consulta financiamento
    function consulta()
    {
        $plazas = $this->financiamiento_model->all_plazas();
        require('views/financiamiento/financiamientos.php');
    }
    function guardaFinanciamiento()
    {

      date_default_timezone_set('America/Mexico_City');
      $dateTime =date('Y-m-d H:i:s');
      $fecha = date('Y-m-d');
      $json= json_encode($_POST['datos']);
      $datos = json_decode($json,true);
      $financiamiento_id = $datos['idFin'];
      $cliente = $datos['cliente'];
      $autorizador = $datos['autorizador'];
      $del = $this->cambiaf_a_mysql($datos['periodoInicio']);
      $al = $this->cambiaf_a_mysql($datos['periodoFin']);
      $plaza = $datos['plaza'];
      $sociedad = $datos['sociedad'];
      $estado = 1;
      $comentarios = $datos['comentarios'];
      $imp_fin= $datos['totalFacturas'];
      $imp_dep = $datos['totalDeposito'];
      $imp_ab = $datos['totalAbonos'];
      $imp_desc = $datos['totalDescuento'];
      $descuentosEliminados = $_POST['descuentosEliminados'];
      $depositosEliminados = $_POST['depositosEliminados'];
      $chequesEliminados = $_POST['chequesEliminados'];
      $abonosEliminados = $_POST['abonosEliminados'];
      $notasEliminadas = $_POST['notasEliminadas'];
      if($financiamiento_id == "" or $financiamiento_id == 0)
      {
        $fin= $this->financiamiento_model->guarda_financ($plaza, $sociedad, $cliente, $autorizador,$fecha,$del, $al,$imp_dep,$imp_desc,$imp_ab,$imp_fin, $estado, $comentarios, $dateTime);
      }
      else
      {
         $fin=$financiamiento_id;
         $update= $this->financiamiento_model->update_financiamiento($fin,$cliente,$autorizador,$fecha, $del, $al,$imp_dep,$imp_desc,$imp_ab,$imp_fin, $estado, $comentarios);
      }
       //depositos del cliente al financiamiento
        for($a=0; $a< count($datos['abonos']); $a++)
        {
          $idDepositoFin =$datos['abonos'][$a]['idDeposito'];
          $importe =$datos['abonos'][$a]['importe'];
          $fecha =$datos['abonos'][$a]['fecha'];
          $fecha_ab = $this->cambiaf_a_mysql($fecha);
          $observaciones =$datos['abonos'][$a]['observaciones'];
          if($idDepositoFin  == 0 or $idDepositoFin  == "")
          {
            $guarda_depositoFinan = $this->financiamiento_model->guarda_depositoFinan($fin,$idDepositoFin,$importe,$fecha_ab,$observaciones,$dateTime);
          }
          //si no solo lo actualizamos
          else
          {
            $update_depositoFinan = $this->financiamiento_model->update_depositoFinan($fin,$idDepositoFin,$importe,$fecha_ab,$observaciones);
          }
         
        }
      $i=0;
      $x=0;
      $y=0;
      $z=0;
      for($i=0; $i< count($datos['facturas']); $i++)
      {
        $facturaID =$datos['facturas'][$i]['facturaID'];
        $folio_fact =$datos['facturas'][$i]['folioFactura'];
        $folio_kid =$datos['facturas'][$i]['folioKid'];
        $socFactura =$datos['facturas'][$i]['socFactura'];
        $fecha_fact = $this->cambiaf_a_mysql($datos['facturas'][$i]['fechaFactura']);
        $importe_fact = $datos['facturas'][$i]['importeFactura'];
        $importe_dep = $datos['facturas'][$i]['importeDepositado'];
        $importe_desc = $datos['facturas'][$i]['importeDescuentosPromotor'];
        $edo_fact = $datos['facturas'][$i]['estadoFactura'];
        $nombre_factura = $datos['facturas'][$i]['nombreFactura'];
        $obs_fact = $datos['facturas'][$i]['observaciones'];
        //guardamos la factura madre de todos los movimientos 
        if($facturaID == 0)
        {
          $Idfactura= $this->financiamiento_model->guarda_factura($fin,$folio_fact,$fecha_fact,$folio_kid,$socFactura,$importe_dep,$importe_fact,$importe_desc,$nombre_factura,$obs_fact,$edo_fact, $dateTime);
        }
        else
        {
          $Idfactura= $datos['facturas'][$i]['facturaID'];
          $update_factura= $this->financiamiento_model->update_factura($Idfactura,$folio_fact,$fecha_fact,$folio_kid,$socFactura,$importe_dep,$importe_fact,$importe_desc,$nombre_factura,$obs_fact,$edo_fact);
        }
        //recorremos los depositos y/o cheques de la factura
        for($x=0; $x< count($datos['facturas'][$i]['cheques']); $x++)
        {
          $tipoPago= $datos['facturas'][$i]['cheques'][$x]['tipo_pago'];
          $f_c=$datos['facturas'][$i]['cheques'][$x]['fecha'];
          $fecha_pago= $this->cambiaf_a_mysql($f_c);
          $soc_pago= $datos['facturas'][$i]['cheques'][$x]['sociedad'];
          $importe_pago= $datos['facturas'][$i]['cheques'][$x]['importe'];
          $obs_pago= $datos['facturas'][$i]['cheques'][$x]['observaciones'];
          $edo_dep=$datos['facturas'][$i]['cheques'][$x]['estado'];
          //tipo pago == 1 transferencia o deposito, tipo pago == 2 cheque
          if($tipoPago == 1)
          {
            
            if($datos['facturas'][$i]['cheques'][$x]['idDeposito'] == 0 or $datos['facturas'][$i]['cheques'][$x]['idDeposito'] == null)
            {
              $guarda_abono = $this->financiamiento_model->guarda_abono($fin,$Idfactura,$soc_pago,$tipoPago,$fecha_pago,$importe_pago,$edo_dep,$obs_pago,$dateTime);
            }
            else
            {
              $idDeposito=$datos['facturas'][$i]['cheques'][$x]['idDeposito'];
              $update_abono = $this->financiamiento_model->update_abono($idDeposito,$soc_pago,$tipoPago,$fecha_pago,$importe_pago,$edo_dep);
            }
          } 
          elseif($tipoPago == 2)
          {
            if($datos['facturas'][$i]['cheques'][$x]['idDeposito'] == 0 or $datos['facturas'][$i]['cheques'][$x]['idDeposito'] == null)
            {
              $edo_cheque= $datos['facturas'][$i]['cheques'][$x]['estado'];
              $folioCheque= $datos['facturas'][$i]['cheques'][$x]['folioCheque'];
              $guarda_cheque= $this->financiamiento_model->guarda_cheque($fin,$Idfactura,$folioCheque,$soc_pago,$edo_dep,$fecha_pago,$importe_pago,$obs_pago,$dateTime);
            }else
            {
              $idDeposito=$datos['facturas'][$i]['cheques'][$x]['idDeposito'];
              $update_abono = $this->financiamiento_model->update_abono($fin,$Idfactura,$soc_pago,$tipoPago,$fecha_pago,$importe_pago,$edo_dep,$obs_pago,$dateTime);
            }
          }
        }
        // //descuentos de promotor
        for($y=0; $y< count($datos['facturas'][$i]['descuentosPromotor']); $y++)
        {
          $promotor= $datos['facturas'][$i]['descuentosPromotor'][$y]['promotor'];
          $obs_desc= $datos['facturas'][$i]['descuentosPromotor'][$y]['observaciones'];
          $imp_desc= $datos['facturas'][$i]['descuentosPromotor'][$y]['importe_desc'];
          $edo_desc= $datos['facturas'][$i]['descuentosPromotor'][$y]['edo_desc'];
          $f_d=$datos['facturas'][$i]['descuentosPromotor'][$y]['fecha_desc'];
          $fecha_desc= $this->cambiaf_a_mysql($f_d);
          $nuevoDesc= $datos['facturas'][$i]['descuentosPromotor'][$y]['nuevoDesc'];
          if($datos['facturas'][$i]['descuentosPromotor'][$y]['idDescuento'] == 0 or $datos['facturas'][$i]['descuentosPromotor'][$y]['nuevoDesc'] == null)
          {
            $guarda_descuento= $this->financiamiento_model->guarda_descuento($fin,$Idfactura,$promotor,$imp_desc,$fecha_desc,$edo_desc,$obs_desc,$dateTime);
          }
          else
          {
            $idDescuento=$datos['facturas'][$i]['descuentosPromotor'][$y]['idDescuento'];
            $update_descuento= $this->financiamiento_model->update_descuento($idDescuento,$Idfactura,$promotor,$imp_desc,$edo_desc,$fecha_desc,$obs_desc);
          }
        }
      //notas de credito
       for($z=0; $z< count($datos['facturas'][$i]['notasCredito']); $z++)
      {
        $folio_nota= $datos['facturas'][$i]['notasCredito'][$z]['folio'];
        $obs_nota= $datos['facturas'][$i]['notasCredito'][$z]['obs_nota'];
        $f_n = $datos['facturas'][$i]['notasCredito'][$z]['fecha_nota'];
        $fecha_nota = $this->cambiaf_a_mysql($f_n);
        $edo_nota= $datos['facturas'][$i]['notasCredito'][$z]['estado_nota'];
        $importe_nota= $datos['facturas'][$i]['notasCredito'][$z]['importe_nota'];
        $nuevaNota= $datos['facturas'][$i]['notasCredito'][$z]['nuevaNota'];
        $folio_nota= $datos['facturas'][$i]['notasCredito'][$z]['folio'];
        $pagadora= $datos['facturas'][$i]['notasCredito'][$z]['pagadora'];
        if($datos['facturas'][$i]['notasCredito'][$z]['idNota'] == 0 or $datos['facturas'][$i]['notasCredito'][$z]['idNota'] == null)
        {
          $guarda_nota= $this->financiamiento_model->guarda_notaCredito($fin,$Idfactura,$folio_nota,$fecha_nota,$importe_nota,$pagadora,$edo_nota,$obs_nota,$dateTime);
          if($guarda_nota!=1)
          {
            $error .="Ha ocurrido un error al guardar  ".$guarda_nota;
          }
        }else{
          $idNota=$datos['facturas'][$i]['notasCredito'][$z]['idNota'];
          $update_nota= $this->financiamiento_model->update_notaCredito($idNota,$Idfactura,$folio_nota,$fecha_nota,$importe_nota,$pagadora,$edo_nota,$obs_nota);
        }
      }
    }
    //Borrando registros
    if(count($descuentosEliminados) > 0)
    {
      for($i=0; $i< count($descuentosEliminados); $i++)
      {
          $borra_desc = $this->financiamiento_model->elimina_descuento($descuentosEliminados[$i]);
      } 
    }
     if(count($depositosEliminados) > 0)
    {
      for($i=0; $i< count($depositosEliminados); $i++)
      {
          $borra_dep = $this->financiamiento_model->elimina_abono($depositosEliminados[$i]);
      } 
    }
     if(count($chequesEliminados) > 0)
    {
      for($i=0; $i< count($chequesEliminados); $i++)
      {
          $borra_dep = $this->financiamiento_model->elimina_cheque($chequesEliminados[$i]);
      } 
    }
     if(count($notasEliminadas) > 0)
    {
      for($i=0; $i< count($notasEliminadas); $i++)
      {
          $borra_nota = $this->financiamiento_model->elimina_nota($notasEliminadas[$i]);
      } 
    }
      if(count($abonosEliminados) > 0)
    {
      for($i=0; $i< count($abonosEliminados); $i++)
      {
          $borra_abono = $this->financiamiento_model->borrar_abono($abonosEliminados[$i]);
      } 
    }
  }

   function datosFinanciamiento()
  {
      $idFin=$_SESSION["id_Financiamiento"]; 

      $datos_generales= $this->financiamiento_model->get_datos_financiamiento($idFin);
      $datos=$_POST['datos'];
      $financiamiento = array();
      $depositosCliente = array();
         while($dato= $datos_generales->fetch_assoc())
         {
          $Financiamiento_id = $dato['idfinanciamiento'];
          $cliente = $dato['idcte'];
          $autorizador = $dato['id_autorizador'];
          $financiamientoID = $dato['idfinanciamiento'];
          $del = $this->cambiaf_a_normal($dato['periodo_inicio']);
          $al = $this->cambiaf_a_normal($dato['periodo_fin']);
          $plaza =$dato['idplaza'];
          $sociedad = $dato['idsociedad'];
          $estado = $dato['periodo_inicio'];
          $comentarios = $dato['observaciones'];
          $imp_fin= $dato['importe_financiado'];
          $imp_dep = $dato['importe_depo'];
          $imp_desc = $dato['importe_desc'];
          $estado = $dato['idstatus_financiado'];

        }
        //cargar los depositos del cliente al financiamiento
          $f=0;
          $depositos_info = $this->financiamiento_model->depositos_info($idFin);
          // if(count($depositos_info)>0)
          // {
            while($info = $depositos_info->fetch_assoc())
            {
              $depositosCliente[$f] =  array ('idDeposito' => $info['idDeposito'],'fecha' => $info['fecha_deposito'],'importe' => $info['importe'],'observaciones' => $info['observaciones']);
              $f++;
            }
          //}
          $facturas_datos=$this->financiamiento_model->facturas_financ($idFin);
          $facturas_array= array();
         
          // //recorrido de facturas
          $cont=0;
          while($factura= $facturas_datos->fetch_assoc())
          {
              $abonos_array= array();
              $notas_array= array();
              $descuentos_array= array();
              $cheques_datos=$this->financiamiento_model->cheque_factura($factura['idfactura_finan']);
              $c=0;
              while($cheque= $cheques_datos->fetch_assoc())
              {
                  $fecha_cheque= $this->cambiaf_a_normal($cheque['fecha']);
                  $abonos_array[$c]= array ('idDeposito' => $cheque['idcheque'],'folioCheque' => $cheque['folio_cheque'],'tipo_pago' => 2,'tipo_nombre'=>'Cheque','fecha' => $fecha_cheque, 'sociedad'=> $cheque['idsociedad'],'sociedadNombre'=> $cheque['razonsocial'],'estado' => $cheque['idstatus_cheque'],'estadoNombre'=>$cheque['nombre'],'importe' => $cheque['importe'],'observaciones' => $cheque['observaciones']); 
                  $c++;
              }
              $abonos_datos=$this->financiamiento_model->abono_factura($factura['idfactura_finan']);
              while($abono= $abonos_datos->fetch_assoc())
              {
                  $fecha_abono= $this->cambiaf_a_normal($abono['fecha']);
                  $abonos_array[$c]= array ('idDeposito' => $abono['idabono'],'folioCheque' => '','tipo_pago' => $abono['idtipo_pago'],'tipo_nombre' => $abono['tipo_nombre'],'fecha' => $fecha_abono, 'sociedad'=> $abono['idsociedad'], 'sociedadNombre'=> $abono['razonsocial'], 'estado' => $abono['idstatus_abono'] ,'estadoNombre' => $abono['nombre'],'importe' => $abono['importe'],'observaciones' => $abono['observaciones']); 
                  $c++;
              }
              $descuentos_datos=$this->financiamiento_model->desc_financ($factura['idfactura_finan']);
              $a=0;
              while($desc= $descuentos_datos->fetch_assoc())
              {
                  $fecha_desc = $this->cambiaf_a_normal($desc['fecha']);
                  $importe_desc = number_format($desc['importe_desc'],2,".",",");
                  $descuentos_array[$a]= array ('idDescuento' => $desc['id_descuento'],'promotor' => $desc['id_empleado'], 'fecha_desc' => $fecha_desc,'promotorNombre' => $desc['nombre_emp'],'importe_desc' => $importe_desc,'edo_desc' => $desc['idstatus_descuento'],'estadoNombre' => $desc['nombre'], 'observaciones'=> $desc['observaciones']); 
                  $a++;
              }
              $n=0;
              $notas_datos=$this->financiamiento_model->notas_factura($factura['idfactura_finan']);
              while($nota= $notas_datos->fetch_assoc())
              {
                  $fecha_nota = $this->cambiaf_a_normal($nota['fecha']);
                  $notas_array[$n]= array ('idNota' => $nota['idnota_credito'],'folio' => $nota['folio'],'importe_nota' => $nota['importe'],'estado_nota' => $nota['idstatus_nota'],'estadoNombre' => $nota['nombre'],'pagadora' => $nota['idempresa'],'pagadoraNombre' => $nota['razonsocial'],'obs_nota'=> $nota['observaciones'], 'fecha_nota'=> $fecha_nota); 
                  $n++;
              }
              $fecha_fact = $this->cambiaf_a_normal($factura['fecha_factura']);
              $facturas_array[$cont]= array ('facturaID' => $factura['idfactura_finan'],'folioFactura' => $factura['folio_factura'], 'folioKid' => $factura['folio_kid'],'socFactura' => $factura['idsociedad'], 'importeFactura'=> $factura['importe_facturado'], 'estadoFactura'=> $factura['status_fact'], 'fechaFactura'=> $fecha_fact, 'nombreFactura'=> $factura['nombre_factura'],'observaciones'=> $factura['observaciones'], 'cheques'=> $abonos_array, 'descuentos'=> $descuentos_array,'notas'=> $notas_array); 
              $cont++;
          }
          $financiamiento = array ('idFin'=>$Financiamiento_id,'autorizador' => $autorizador,'cliente' => $cliente,'del'=>$del,'comentarios'=>$comentarios, 
          'estado'=>$estado, 'periodoFin'=>$al, 'periodoInicio'=>$del,'plaza'=>$plaza, 'sociedad'=>$sociedad, 
          'totalDeposito'=>$imp_dep,'estado'=>$estado,'totalDescuento'=>$imp_desc,'totalDescuento'=>$imp_fin,'facturas'=>$facturas_array,'abonos'=>$depositosCliente);
          $data= json_encode($financiamiento);
          header('Content-Type: application/json');
          echo $data;
          
   }
  function detalle_fin()
  {
    $idfin=$_REQUEST['id_fin']; // si esta
    $sociedades = $this->financiamiento_model->all_sociedades();
    $datos= $this->financiamiento_model->detalles($idfin);
    $promotores = $this->financiamiento_model->all_personal();
    $status_fact = $this->financiamiento_model->status_fact();
    $sociedades = $this->financiamiento_model->all_sociedades();
    $estados_cheque = $this->financiamiento_model->estados_cheque();
    $status_desc= $this->financiamiento_model->estados_descuento();
    $status_fin= $this->financiamiento_model->busca_status();
    $edos_fact= $this->financiamiento_model->status_fact();
    $edos_cheque = $this->financiamiento_model->estados_cheque();
    $edos_desc = $this->financiamiento_model->estados_descuento();
    require('views/financiamiento/detalle_financiamiento.php');
  }
  function detalle_cheques()
    {   
       $idfin=$_REQUEST['id'];
       $cheques = $this->financiamiento_model->cheques_financ($idfin);
       $array_cheques = array(); //creamos un array
 
        while($cheque=$cheques->fetch_assoc()) 
        { 
            $idcheque=$cheque['idcheque'];
            $folio=$cheque['folio_cheque'];
            $fecha=$cheque['fecha'];
            $imp=number_format($cheque['importe'],2,".",",");
            $edo=$cheque['nombre'];
            $id_edo=$cheque['idstatus_cheque'];
            if($cheque['observaciones']=="")
            {
              $obs="Sin observaciones";
            }
            else
            {
              $obs=$cheque['observaciones'];
            }
              if($id_edo == 2)
            {
                $estado="<span  class='label label-default'>".$edo."</label>";
            }
            elseif($id_edo == 1)
            {
                $estado="<span  class='label label-success'>".$edo."</label>";
            }
              elseif($id_edo == 3)
            {
                $estado="<span  class='label label-danger'>".$edo."</label>";
            }
            $array_cheques[] = array('idcheque'=> $idcheque,'folio_cheque'=>$folio,'fecha'=> $fecha,'obs'=>$obs,'edo'=>$estado,'importe'=>$imp);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_cheques);
        echo $json_string;

    }
    function detalle_factura()
    {   
       $idfin=$_REQUEST['id'];
       $facturas = $this->financiamiento_model->facturas_financ($idfin);
       $array_facturas = array(); //creamos un array
 
        while($factura=$facturas->fetch_assoc()) 
        { 
            $idfact=$factura['idfactura_finan'];
            $folio=$factura['folio_factura'];
            $fecha=$factura['fecha_factura'];
            $imp=number_format($factura['importe_fact'],2,".",",");
            $obs=$factura['observaciones'];
            $id_edo=$factura['status_fact'];
              if($id_edo == 2)
            {
                $estado="<span  class='label label-default'>".$factura['nombre']."</label>";
            }
            elseif($id_edo == 1)
            {
                $estado="<span  class='label label-success'>".$factura['nombre']."</label>";
            }
              elseif($id_edo == 3)
            {
                $estado="<span  class='label label-danger'>".$factura['nombre']."</label>";
            }
            $array_facturas[] = array('idfact'=> $idfact,'folio'=>$folio,'fecha'=> $fecha,'obs'=>$obs,'importe'=>$imp,'estado'=>$estado);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_facturas);
        echo $json_string;

    }
    function detalle_desc()
    {
       $idfin=$_REQUEST['id'];
       $descs = $this->financiamiento_model->desc_financ($idfin);
       $array_desc = array();
 
        foreach ($descs as $desc) 
        { 
            $id_des=$desc['id_descuento'];
            $emp=$desc['nombre_emp'];
            $fact=$desc['idfactura_finan'];
            $folio=$desc['folio_fact'];
            $edo=$desc['edo_nombre'];
            $id_edo=$desc['idstatus_descuento'];
            $imp=$desc['importe_desc'];
            $desc_imp=number_format($imp,2,".",",");
            $pag=$desc['importe_pagado'];
            $pag_num=$desc['importe_pagado'];
            $pago=number_format($pag_num,2,".",",");
            $saldo_num=floatval($imp-$pag);
            $saldo=number_format($saldo_num,2,".",",");
            $obs=$desc['observaciones'];
               if($id_edo == 2)
            {
                $estado="<span  class='label label-default'>".$edo."</label>";
            }
            elseif($id_edo == 3)
            {
                $estado="<span  class='label label-danger'>".$edo."</label>";
            }
              elseif($id_edo == 1)
            {
                $estado="<span  class='label label-warning'>".$edo."</label>";
            }

            $array_desc[] = array('id_des'=> $id_des,'emp'=>$emp,'idfactura_finan'=> $fact,'folio_fact'=>$folio,'edo'=> $estado,'obs'=>$obs,'importe'=>$desc_imp,'pagado'=>$pago,'saldo'=>$saldo);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_desc);
        echo $json_string;
    }
     function detalle_abonos()
    {
       $idfin=$_REQUEST['id'];
       $abonos = $this->financiamiento_model->abonos_financ($idfin);
       $array_abonos = array(); //creamos un array
 
        while($abono=$abonos->fetch_assoc()) 
        { 
            $idabono=$abono['idabono'];
            $metodo=$abono['nombre'];
            $folio_fact=$abono['folio_factura'];
            $fact=$abono['folio_fact'];
            $fecha=$abono['fecha'];
            $importe=$abono['importe'];
            $obs=$abono['observaciones'];
            $array_abonos[] = array('id'=> $idabono,'factura'=>$folio_fact,'metodo'=> $metodo,'fecha'=>$fecha,'importe'=>$importe, 'obs'=>$obs);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_abonos);
        echo $json_string;
    }
    function autorizados()
    {
       $plaza=$_REQUEST['plaza'];
       $soc=$_REQUEST['soc'];
       $auts = $this->financiamiento_model->autorizados($plaza,$soc);
       $array_aut = array(); //creamos un array
        while($aut=$auts->fetch_assoc()) 
        { 
            $emp=$aut['id_empleado'];
            $nombre=$aut['nombre'];
            $array_aut[] = array('Id'=> $emp,'nombre'=>$nombre);
         
        }
        //Creamos el JSON
        $json_string = json_encode($array_aut);
        echo $json_string; 
    }
    function nuevo_autoriza()
    {
      $plaza=$_REQUEST['plaza'];
      $soc=$_REQUEST['soc'];
      $idemp=$_REQUEST['emp'];
      $nuevo=$this->financiamiento_model->guarda_autoriza($plaza,$soc,$idemp);
      echo $nuevo;
    }
    function consulta_fin()
    {   
       $fecha_actual =date('Y-m-d');
       $plaza= $_REQUEST['plaza'];
       $soc= $_REQUEST['soc'];
       $filtro = $_REQUEST['filtro'];
       $financiados = $this->financiamiento_model->consulta_finan($plaza,$soc);
       $array_fin = array(); //creamos un array
 
        while($financiado=$financiados->fetch_assoc()) 
        { 
            $id=$financiado['idfinanciamiento'];
            $cliente=$financiado['razon'];
            $inicio=$this->cambiaf_a_normal($financiado['periodo_inicio']);
            $fin=$this->cambiaf_a_normal($financiado['periodo_fin']);
            $estado=$financiado['nombre'];
            $act=$financiado['updated_at'];
            $id_edo_fin=$financiado['idstatus_financiado'];
            $imp_fin=floatval($financiado['importe_financiado']);
            $finan=number_format($imp_fin,2,".",",");
            $imp_dep=floatval($financiado['importe_depo']);
            $depo=number_format($imp_dep,2,".",",");
            $num_saldo = floatval($financiado['importe_financiado']-$financiado['importe_depo']);
            $saldo=number_format($num_saldo,2,".",",");
            $saldo_fin = ($financiado['importe_financiado']-$financiado['importe_depo']);
            $f_inicio=$financiado['periodo_inicio'];
            $f_fin=$financiado['periodo_fin'];
             if($id_edo_fin == 1 and $id_edo_fin != 5 and $f_fin < $fecha_actual and $f_fin != '0000-00-00')
            {
              $nvo_edo=5;
              $update_edoFin= $this->financiamiento_model->update_edoFin($id,$nvo_edo);
            }
            elseif($id_edo_fin != 2 and $saldo_fin == 0 )
            {
              $nvo_edo=2;
              $update_edoFin= $this->financiamiento_model->update_edoFin($id,$nvo_edo);
            }  
              if($filtro == 0)
                {
                    $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                //condiciones que se aplican cuando el usuario pone filtros en la consulta
                elseif($filtro == 1 and $id_edo_fin == 1)
                {
                    $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                elseif($filtro == 2 and $id_edo_fin == 2 )
                {
                    $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                elseif($filtro == 3 and $id_edo_fin == 3)
                {
                     $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                elseif($filtro == 4 and $id_edo_fin == 4)
                {
                     $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                elseif($filtro == 5 and $id_edo_fin == 5)
                {
                     $array_fin[] = array('id'=> $id,'cliente'=>$cliente,'inicio'=> $inicio,'fin'=>$fin,'act'=>$act, 'depo'=>$depo,'finan'=>$finan,'saldo' => $saldo,'estado'=>$estado,'id_edo'=>$id_edo_fin);
                }
                else
                {
                    //no hacemos nada
                }
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_fin);
        echo $json_string;
    }
     function borrar_factura()
    {
        $fact=$_REQUEST['id'];
        $borrar=$this->financiamiento_model->borrar_factura($fact);
        echo $borrar;
    }
    function restar_financiado()
    {
      $fin=$_REQUEST['id'];
      $importe= floatval($_REQUEST['imp']);
      $restar = $this->financiamiento_model->resta_impFin($fin,$importe);
      echo $restar;
    }
    function sumar_financiado()
    {
      $fin=$_REQUEST['id'];
      $importe= $_REQUEST['imp'];
      $sumar= $this->financiamiento_model->sumar_financiado($fin,$importe);
      echo $sumar;
    }
    function sumar_descuento()
    {
      $fin=$_REQUEST['id'];
      $importe= $_REQUEST['imp'];
      $sumar= $this->financiamiento_model->sumar_descuento($fin,$importe);
      echo $sumar;
    }
     function restar_deposito()
    {
      $fin=$_REQUEST['id'];
      $importe= floatval($_REQUEST['imp']);
      $restar = $this->financiamiento_model->restar_deposito($fin,$importe);
      echo $restar;
    }
     function sumar_deposito()
    {
      $fin=$_REQUEST['id'];
      $importe= $_REQUEST['imp'];
      $sumar= $this->financiamiento_model->sumar_deposito($fin,$importe);
      echo $sumar;
    }
     function restar_descuento()
    {
      $fin=$_REQUEST['id'];
      $importe= $_REQUEST['imp'];
      $restar= $this->financiamiento_model->restar_descuento($fin,$importe);
      echo $restar;
    }
    function borrar_cheque()
    {
        $id=$_REQUEST['id'];
        $borrar=$this->financiamiento_model->borrar_cheque($id);
        echo $borrar;
    }
    function calcula_fin()
    {
      $id=$_REQUEST['id'];
      $imp= $this->financiamiento_model->calcula_fin($id);
      while($i=$imp->fetch_assoc()) 
      {
        $num=floatval($i['importe_financiado']);
        $money=number_format($num,2,".",",");
        echo $money;
      }
    }
    function calcula_dep()
    {
      $id=$_REQUEST['id'];
      $imp= $this->financiamiento_model->calcula_dep($id);
      while($i=$imp->fetch_assoc()) 
      {
        $num=floatval($i['importe_depo']);
        $money=number_format($num,2,".",",");
        echo $money;
      }
    }
    function calcula_desc()
    {
      $id=$_REQUEST['id'];
      $imp= $this->financiamiento_model->calcula_desc($id);
      while($i=$imp->fetch_assoc()) 
      {
        $num=floatval($i['importe_desc']);
        $money=number_format($num,2,".",",");
        echo $money; 

      }
    }
    function guarda_factura()
    {
      $fin=$_REQUEST['id'];
      $folio=$_REQUEST['folio'];
      $fecha=$_REQUEST['fecha'];
      $imp=$_REQUEST['imp'];
      $edo= $_REQUEST['edo'];
      $obser=$_REQUEST['obs'];
      $guarda_factura= $this->financiamiento_model->guarda_factura($fin,$folio,$fecha,$imp,$edo,$obser);
      echo $guarda_factura;
    }
    function guarda_cheque()
    {
      $fin=$_REQUEST['id'];
      $cheque=$_REQUEST['cheque'];
      $fecha_cheque=$_REQUEST['fecha'];
      $edo_cheque=$_REQUEST['edo_cheque'];
      $soc_cheque=$_REQUEST['soc'];
      $importe=$_REQUEST['imp'];
      $obs=$_REQUEST['obs'];
      $guarda_cheque= $this->financiamiento_model->guarda_cheque($fin,$cheque,$soc_cheque,$edo_cheque,$fecha_cheque,$importe,$obs);
      echo $guarda_cheque;
    }
    function consulta_regreso()
    {
      $desc=$_REQUEST['desc'];
      $regresos = $this->financiamiento_model->consulta_regresos($desc);
      $array_regreso = array(); //creamos un array
 
        while($regreso=$regresos->fetch_assoc()) 
        { 
            $id=$regreso['idregreso'];
            $imp=$money=number_format($regreso['importe'],2,".",",");
            $fecha=$regreso['fecha'];
            $obser=$regreso['observaciones'];
            if($obser == "" or $obser == undefined)
            {
              $obser="Sin observaciones";
            }
            $array_regreso[] = array('id'=> $id,'imp'=>$imp,'fecha'=> $fecha,'obser'=>$obser);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_regreso);
        echo $json_string;

    }
    function regreso_promotor()
    {
      $fin=$_POST['fin'];
      $desc= $_POST['desc'];
      $imp=$_POST['imp'];
      $fecha=$this->cambiaf_a_mysql($_POST['fecha']);
      $obs=$_POST['obs'];

      $regresa_promotor=$this->financiamiento_model->regreso_promotor($fin,$desc,$imp,$fecha,$obs);
      $update_pago_desc=$this->financiamiento_model->update_pago_desc($desc,$imp);
      echo $regresa_promotor;
    }
    function borra_pago()
    {
      $id=$_REQUEST['id'];
      $imp=$_REQUEST['imp'];
      $des=$_REQUEST['desc'];
      $borrar=$this->financiamiento_model->borrar_pago($id);
      $restar=$this->financiamiento_model->resta_pago_desc($des,$imp);
      echo $borrar;
    }
       function facturas_combo()
    {
        $id=$_REQUEST['fin'];
        $as= $this->financiamiento_model->facturas_combo($id);
        $total=count($as->fetch_assoc());
         if($total == 0 )
         {
              echo ' <option  selected>-- No existen facturas --</option>';
         }
         else
         {
            echo ' <option  selected>-- Seleccione factura--</option>';
            foreach ($as as $a) 
            {
                echo '<option  value="'.$a['idfactura_finan'].' ">'.$a['folio_factura'].'</option>'; 
            }
         }

    }
    function guarda_descuento()
    {
      $dateTime =date('Y-m-d H:i:s');
      $fin=$_POST['fin'];
      $promotor=$_POST['promotor'];
      $factura=$_POST['fact'];
      $importe=$_POST['importe_desc'];
      $estado=$_POST['estado'];
      $Obser=$_POST['obs'];
      $guarda_descuento= $this->financiamiento_model->guarda_descuento($fin,$promotor,$factura,$importe,$estado,$Obser,$dateTime);
      echo $guarda_descuento;
    }
    function borrar_descuento()
    {
      $desc= $_REQUEST['id'];
      $borrar= $this->financiamiento_model->borrar_descuento($desc);
      echo $borrar;
    }
     function actualiza_edo_fin()
  {
    $id=$_REQUEST['id'];
    $edo=$_REQUEST['edo'];
    //actualiza en la cuenta bancaria el status actual
    $actualiza= $this->financiamiento_model->actualiza_edo_fin($id,$edo);
    echo "OK";
  }
   function busca_edo_factura()
  {
    $id=$_POST['id'];
    $datos= $this->financiamiento_model->edo_actual_factura($id);
      $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $idedo=$dato['status_fact'];
            $estado=$dato['nombre'];
            $id=$dato['idfactura_finan'];
            $array_datos[] = array('id'=> $id,'idedo'=> $idedo,'estado'=>$estado); 
        }
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
     function busca_edo_cheque()
  {
     $id=$_POST['id'];
    $datos= $this->financiamiento_model->edo_actual_cheque($id);
      $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $idedo=$dato['idstatus_cheque'];
            $estado=$dato['nombre'];
            $id=$dato['idcheque'];
            $array_datos[] = array('id'=> $id,'idedo'=> $idedo,'estado'=>$estado); 
        }
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
      function busca_edo_desc()
  {
     $id=$_POST['id'];
    $datos= $this->financiamiento_model->edo_actual_descuento($id);
      $array_datos = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $idedo=$dato['idstatus_descuento'];
            $array_datos[] = array('id_edo'=> $idedo); 
        }
        //Creamos el JSON
        $json_string = json_encode($array_datos);
        echo $json_string;
    }
    function facturas_descuentos()
    {
      $id=$_POST['id'];
      $busca= $this->financiamiento_model->facturas_descuentos($id);
       while($b=$busca->fetch_assoc()) 
        { 
            echo $total_facturas=$b['total_fact'];
        }
    }
    //actualiza el estado de la factura del la factura
    function actualiza_edo_factura()
  {
    $id=$_REQUEST['id'];
    $edo=$_REQUEST['edo'];
    $actualiza= $this->financiamiento_model->update_edo_factura($id,$edo);
    echo $actualiza;
  }
   function update_edo_descuento()
  {
    $id=$_REQUEST['id'];
    $edo=$_REQUEST['edo'];
    $actualiza= $this->financiamiento_model->update_edo_descuento($id,$edo);
    echo $actualiza;
  }
  //actualiza el estado de la factura del cheque
   function actualiza_edo_cheque()
  {
    $id=$_REQUEST['id'];
    $edo=$_REQUEST['edo'];
    $actualiza= $this->financiamiento_model->update_edo_cheque($id,$edo);
    echo $actualiza;
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
    //consulta general de los descuentos de promotor
    function descuentos()
    {
      $plazas = $this->financiamiento_model->all_plazas();
      require('views/financiamiento/descuento-promotor.php');
    }
        function all_descuentos()
    {
      $busca=$_REQUEST['busca'];
      $plaza=$_REQUEST['plaza'];
      $soc=$_REQUEST['soc'];
      $empleados= $this->financiamiento_model->personal_desc();
      $array_desc = array(); //creamos un array
      while($e=$empleados->fetch_assoc()) 
        { 
            $id_emp=$e['id_empleado'];
            $nombre=$e['nombre_emp'];
            $descuentos= $this->financiamiento_model->all_descuentos($id_emp);
            $total_pagos=0;
            while($d=$descuentos->fetch_assoc()) 
            { 
                $total_desc=floatval($d['descuento']);
                $id_des=$d['id_descuento'];
                $busca_pagos=$this->financiamiento_model->suma_pagos($id_des);
                  while($b=$busca_pagos->fetch_assoc()) 
                {
                  $importe=floatval($b['importe']);
                  $total_pagos=$total_pagos+$importe;
                } 
                $pendiente=($total_desc-$total_pagos);
                if($pendiente > 0)
                {
                  $estado="<span  class='label label-warning'>Pendiente</label>";
                }
                else
                {
                  $estado="<span  class='label label-success'>Pagado</label>";
                }
                $descuento=number_format($total_desc,2,".",",");
                $pagado=number_format($total_pagos,2,".",",");
                $tot_pendiente=number_format($pendiente,2,".",",");
                $busca_desc=$this->financiamiento_model->finan_desc($plaza,$soc);
                while($bus_d=$busca_desc->fetch_assoc()) 
                {
                  $enc_des= $bus_d['id_descuento'];
                  if($id_des==$enc_des)
                  {
                    if($busca == 0)
                    {
                      $array_desc[] = array('id'=> $id_emp,'empleado'=>$nombre,'descuento'=>$descuento,'pagado'=>$pagado,'pendiente'=>$tot_pendiente,'estado'=>$estado);
                    }
                    elseif($busca==1 and $pendiente>0)
                    {
                      $array_desc[] = array('id'=> $id_emp,'empleado'=>$nombre,'descuento'=>$descuento,'pagado'=>$pagado,'pendiente'=>$tot_pendiente,'estado'=>$estado);
                    }
                    elseif($busca==2 and $pendiente==0)
                    {
                      $array_desc[] = array('id'=> $id_emp,'empleado'=>$nombre,'descuento'=>$descuento,'pagado'=>$pagado,'pendiente'=>$tot_pendiente,'estado'=>$estado);
                    }
                    else
                    {

                    }
                  }
              }
            }
        }
        //Creamos el JSON
        $json_string = json_encode($array_desc);
        echo $json_string;
    }
    function sesion_detalle()
    {
      $id=$_GET['idFin'];
      if(isset($id))
      {
        $_SESSION["id_Financiamiento"]=$id;
        $detalle=$this->detalle_financiamiento();
      }  
      else
      {
        $req=$this->get_finan(); 
      }
    }
    function update_edoFin()
    {
      $id = $_POST['id'];
      $nvo = $_POST['nvo'];
      $update= $this->financiamiento_model->update_edoFin($id,$nvo);
      echo $update;

    }
    function vista_detalleDesc()
    {
      $_SESSION['id_emp']= $_GET['id'];
      $busca_nombre = $this->financiamiento_model->nombre_empleado($_SESSION['id_emp']);
      while($b=$busca_nombre->fetch_assoc()) 
      {
        $nombre_emp = $b['nombre_emp'];
      }
      require('views/financiamiento/detalle_descuentos.php');
    }
    function detalle_descuento()
    {
      $descuentos_fact = $this->financiamiento_model->descuentos_detalle(608);
       $array_detalle = array(); //creamos un array
 
        while($desc=$descuentos_fact->fetch_assoc()) 
        {
            $imp_pag=floatval($desc['importe_pagado']);
            $imp_desc=floatval($desc['importe_desc']);
            $saldo= ($imp_desc-$imp_pag);
            $total= number_format($saldo,2,".",",");
            $array_detalle[] = array('id'=> $desc['id_descuento'],'fecha'=>$desc['fecha'],'id_fin'=>$desc['idfinanciamiento'],'idFact'=>$desc['idfactura_finan'],'folio_fact'=>$desc['folio_factura'],'observaciones'=>$desc['observaciones'],'razon'=>$desc['razon'],'importe_pag'=>$desc['importe_pagado'],'imp_desc'=>$desc['importe_desc'],'saldo'=>$total,'status'=>$desc['nombre']);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_detalle);
        echo $json_string;
    }
    function elimina_factura()
    {
      $id= $_POST['id'];
      $elimina_cheques = $this->financiamiento_model->elimina_cheques_fact($id);
      $elimina_descuento = $this->financiamiento_model->elimina_desc_fact($id);
      $elimina_notas = $this->financiamiento_model->elimina_notas_fact($id);
      $elimina_abonos = $this->financiamiento_model->elimina_abono_fact($id);
      $elimina_fact = $this->financiamiento_model->elimina_factura($id);
      echo $elimina_fact;
    }
    //consulta de facturas
    function facturas()
    {
      $plazas = $this->financiamiento_model->all_plazas();
      $status_fact = $this->financiamiento_model->status_fact();
      require('views/financiamiento/facturas.php');
    }
    function consulta_facturas()
    {
       $fecha_actual =date('Y-m-d');
       $plaza= $_REQUEST['plaza'];
       $filtro= $_REQUEST['filtro'];
       $soc= $_REQUEST['soc'];
       $financiados = $this->financiamiento_model->consulta_facturas($plaza,$soc);
       $array_fact = array(); //creamos un array
 
        while($financiado=$financiados->fetch_assoc()) 
        { 
            $id=$financiado['idfactura_finan'];
            $fin=$financiado['idfinanciamiento'];
            $cliente=$financiado['cliente'];
            $folio=$financiado['folio_factura'];
            $edo=$financiado['estado'];
            $obs=$financiado['observaciones'];
            $mod = $financiado['updated_at'];
            $fecha=$this->cambiaf_a_normal($financiado['fecha_factura']);
            $imp_fact=floatval($financiado['importe_facturado']);
            $facturado=number_format($imp_fact,2,".",",");
            $imp_desc=floatval($financiado['importe_descuentos']);
            $desc=number_format($imp_desc,2,".",",");
            $imp_dep=floatval($financiado['importe_depositado']);
            $dep=number_format($imp_dep,2,".",",");
            $num_saldo = floatval($financiado['importe_facturado']-$financiado['importe_depositado']);
            $saldo=number_format($num_saldo,2,".",",");
            $saldo_fact = ($financiado['importe_facturado']-$financiado['importe_depositado']);
             if($filtro == 0)
                {
                     $array_fact[] = array('id'=> $id,'fin'=>$fin,'cliente'=> $cliente,'edo'=>$edo,'obs'=>$obs, 'fecha'=>$fecha,'imp_fact'=>$facturado,
                    'imp_desc' => $desc,'imp_dep'=>$dep,'saldo_fact'=>$saldo_fact,'folio'=>$folio,'mod'=>$mod);
                }
                //condiciones que se aplican cuando el usuario pone filtros en la consulta
                elseif($filtro == 1 and $edo=="Activa")
                {
                   $array_fact[] = array('id'=> $id,'fin'=>$fin,'cliente'=> $cliente,'edo'=>$edo,'obs'=>$obs, 'fecha'=>$fecha,'imp_fact'=>$facturado,
                    'imp_desc' => $desc,'imp_dep'=>$dep,'saldo_fact'=>$saldo_fact,'folio'=>$folio,'mod'=>$mod);
                }
                elseif($filtro == 2 and $edo=="Cancelada" )
                {
                   $array_fact[] = array('id'=> $id,'fin'=>$fin,'cliente'=> $cliente,'edo'=>$edo,'obs'=>$obs, 'fecha'=>$fecha,'imp_fact'=>$facturado,
                    'imp_desc' => $desc,'imp_dep'=>$dep,'saldo_fact'=>$saldo_fact,'folio'=>$folio,'mod'=>$mod);
                }
                elseif($filtro == 3 and $edo=="Pendiente")
                {
                    $array_fact[] = array('id'=> $id,'fin'=>$fin,'cliente'=> $cliente,'edo'=>$edo,'obs'=>$obs, 'fecha'=>$fecha,'imp_fact'=>$facturado,
                    'imp_desc' => $desc,'imp_dep'=>$dep,'saldo_fact'=>$saldo_fact,'folio'=>$folio,'mod'=>$mod);
                }
                else
                {
                    //no hacemos nada
                }
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_fact);
        echo $json_string;
    }
     function busca_factura()
    {
        $id=$_REQUEST['id'];
        $datos=$this->financiamiento_model->busca_factura($id);
        $array_factura = array(); //creamos un array

        while($dato=$datos->fetch_assoc()) 
        { 
            $idfact=$dato['idfactura_finan'];
            $folio=$dato['folio_factura'];
            $fecha=$this->cambiaf_a_normal($dato['fecha_factura']);
            $imp=number_format($dato['importe_facturado'],2,".",",");
            $edo= $dato['idstatus_factura'];
            $obs= $dato['observaciones'];
            $array_factura[] = array('idfact'=> $idfact,'folio'=>$folio,'fecha'=> $fecha,'imp'=>$imp,'obs'=>$obs,'edo'=>$edo);
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_factura);
        echo $json_string;
    }
     //actualiza datos del banco
     function update_factura()
    {
        $id=$_POST['id'];
        $folio=$_POST['folio'];
        $fecha=$this->cambiaf_a_mysql($_POST['fecha']);
        $imp=$_POST['imp'];
        $edo=$_POST['edo'];
        $obs=$_POST['obs'];
        $update=$this->financiamiento_model->update_datos_factura($id,$folio,$fecha,$imp,$edo,$obs);
        echo $update;
    }
    function menu_reportes()
    {
      
      require('views/financiamiento/reportes/menu-reportes.php');
    }
   
   
   

    
}

?>
