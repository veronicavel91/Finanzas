<?php session_start();
error_reporting(E_ALL);
date_default_timezone_set('America/Mexico_City');

//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/reportes_model.php");

class reportes extends Common
{

    public $reportes_model;
    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->reportes_model = new reportes_model();
        $this->reportes_model->connect();
        $dateTime =date('Y-m-d H:i:s');
        require_once("librerias/dompdf/dompdf_config.inc.php"); 

    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->reportes_model->close();
    }
     function menu_cuentas()
    {
        $bancos = $this->reportes_model->all_bancos();
        $bancos_form = $this->reportes_model->all_bancos();
        $bancos_cheq = $this->reportes_model->all_bancos();
        $bancos_datos = $this->reportes_model->all_bancos();
        $plazas = $this->reportes_model->all_plazas();
        $plazas_can = $this->reportes_model->all_plazas();
        $plazas_datos = $this->reportes_model->all_plazas();
        $sociedades = $this->reportes_model->all_sociedad();
         $sociedades_datos = $this->reportes_model->all_sociedad();
        $sociedades_can = $this->reportes_model->all_sociedad();
         $sociedades_cheq = $this->reportes_model->all_sociedad();
         $plazas_cheq = $this->reportes_model->all_plazas();
        require('views/reportes/cuentas/menu-cuentas.php');
    }
     function cambiaf_a_mysql($fecha)
    {
        $date = explode('/', $fecha);
        $new_date = $date[2].'-'.$date[1].'-'.$date[0];
        return $new_date;
    }
     function vista_reporte()
    {
      require('views/reportes/reporte.php');
    }
    function genera_reporte()
    {
       ini_set('xdebug.max_nesting_level', 900);
       $id=$_POST['cboCuenta'];
       $fecha_actual = $this->datacastella(date('Y-m-d'));
       $solicitante = strtoupper($_POST['solicitante']);
       $ent = $_REQUEST['ent'];
       $info_ext = $_POST['info'];
       $in = $_POST['folio_del'];
       $fn = $_POST['folio_al'];
       $imp_dep = $_POST['imp_dep'];
       $cuentas = $this->reportes_model->busca_cuenta($id);
        while ($cta= $cuentas->fetch_assoc()) {
            $banco = strtoupper($cta['banco']);
            $num_cuenta = $cta['num_cuenta'];
            $clabe = $cta['clabe'];
            $responsable = $cta['responsable'];
            $empresa = strtoupper($cta['razonsocial']);
            $id_soc = $cta['idempresa'];
            $fecha_ap = $this->datacastella($cta['fecha_apertura']);
            $domicilio = strtoupper($cta['domicilio']);

        }
        $i=0;
        $busca_firm = $this->reportes_model->busca_firmante($id); 
        $firmantes = "";
        while($firm = $busca_firm->fetch_assoc())
        {
            $firmantes .= $firm['nombre_emp']. ",";
        }
        $emp_firmantes =substr($firmantes, 0, -1);
        $sheet[$i] = array($cta['Plaza'],$cta['razonsocial'],$cta['banco'],$cta['tipo_cuenta'],$cta['contrato_nomina'],$cta['tipo_operacion'],$cta['responsable'],$firmantes,$cta['num_cuenta'],$cta['clabe'],$cta['no_cliente'],$cta['fecha_apertura'],$cta['no_contrato'],$cta['sucursal'],$cta['nombre_sucursal'],$cta['domicilio'],$cta['moneda'],$cta['area'],$cta['status_cuenta'],$cta['observaciones'],$cta['usuario_cta']);
        $i++;
             $html = "<html><style>html {
              margin: 0;
            }body { background-image: url('./uploads/formatos/membretes/".$id_soc.".jpg'); background-repeat: no-repeat; background-position: 0mm 0mm; background-height: 100%; background-width: 100%;}</style><body>";

        $html .= '<div style="margin-top:30px;text-align: justify;padding:10%;">
        <span style="margin-left:52%;"><br><br>Guadalajara,Jalisco a  '.$fecha_actual.'</span><br><br><p>Por este medio se hace entrega 
        al solicitante: <strong>'.$solicitante.'</strong> la cuenta de banco: 
        <strong>'.$banco.'</strong>, de la empresa:<strong>'.$empresa.'</strong> con 
        número de cuenta: <strong>'.$num_cuenta.'</strong> y Clabe Interbancaria
        Estandarizada(Clabe) <strong>N.'.$clabe.'</strong>.
        <br><br><br>';
        $claves_acceso = 0;
        $token = 0;
        if(count($ent)>1)
        {
            $html .='De la cual se está entregando lo siguiente:</p><ol>';
            foreach($ent as $e) 
            {

                if($e =="Chequera inicial del folio")
                {
                    $html.='<li>Chequera inicial del folio:'.$in.' al:'.$fn.'</li>';
                }
                 elseif($e=="Deposito por la cantidad de:")
                {
                    $html.='<li>Deposito por la cantidad de: $'.$imp_dep;
                }
                else
                {
                    $html.='<li>'.$e.'</li>';
                }
                  if($e =="Claves de acceso")
                {
                    $claves_acceso = 1;
                }
                   if($e =="Token Administrador y operador")
                {
                    $token = 1;
                }
            }

            $html.='<br><br><br>';
        }
        $html .='<br><strong>Datos Generales de la cuenta:</strong><span> Fecha de apertura '.$fecha_ap.',firmará en la cuenta
        como Representante Legal '.$responsable.' en forma mancomunada con '.$emp_firmantes. '<br><br>Los estados de cuenta llegarán al domicilio
        fiscal '.$domicilio.',Guadalajara,Jalisco.';
        $html .= '<br><br>'.$info_ext.'<br><br><br><br>';
        $html .= '<br><br><div style="width:40%;float:left;margin-left:10%;font-size:41px;"><strong style="font-size:41px;">Entrega:</strong><br><br>
        _______________________<br>C. Paulina Arroyo Alvarado<br>Enlace bancario</div></div>';
        $html .= '<div style="width:40%;float:right;font-size:41px;"><strong style="font-size:41px;">Recibe:</strong><br><br><br>
        _______________________<br>C.'.$_POST['solicitante'].'<br></div></div><div style="page-break-before: always;">';
     
        if($claves_acceso == 1)
        {
            $preguntas = $this->reportes_model->preguntas_cuenta($id);
            if(count($preguntas->fetch_assoc())>=1)
            {
                $html .= '<div style="padding:10%;"><strong style="font-size:43px;">PREGUNTAS DE SEGURIDAD:</strong><br><ol>';
                foreach ($preguntas as $preg) {
                   $html.= '<li><span style="font-size:40px;font-weight:bold;"> P.</span><span style="font-size:40px;">'.$preg['pregunta'].'</span><br><span style="font-size:40px;font-weight:bold;"> R.</span><span style="font-size:40px;">'.$preg['respuesta'].'</span></li><br>';
                }
                $html .= '</ol></div>';
            }
            else
            {
                $html .= '<div style="padding:10%;"><strong>*Esta cuenta no tiene preguntas de seguridad registradas*</strong></div>';
            }
        }
        if($token == 1)
        {
            $token_datos = $this->reportes_model->token_cuenta($id);
            if(count($token_datos->fetch_assoc())>=1)
            {
                $html .= '<strong style="font-size:43px;">TOKEN DE CUENTA:</strong><br><ol>';
                while ($tok= $token_datos->fetch_assoc()) {
                    if($tok['vence'] == 1)
                    {
                        $vence = "Si";
                    }
                    else
                    {
                        $vence = "No tiene vencimiento";
                    }
                    $f_vence = $this->datacastella($tok['fecha_vence']);
                   $html.= '<strong style="font-size:43px;">Codigo/No.serie:</strong><span style="font-size:43px;">'.$tok['codigo'].'
                   </span><br><strong style="font-size:43px;">Vence:</strong><span style="font-size:43px;">'.$vence;
                   if($tok['vence'] == 1)
                   {
                    $html.= '</span><br><strong style="font-size:43px;">Fecha vencimiento:</strong><span style="font-size:43px;">'.$f_vence;
                   }
                   $html.= '</span><br><strong style="font-size:43px;">Comentarios:</strong><span style="font-size:43px;">'.$tok['observaciones'];
                }
            }
            else
            {
                $html .= '<div style="margin-left:10%;"><strong>*Esta cuenta no tiene datos del token registrados*</strong></div>';
            }
        }
       
        $html .='</div></body></html>';
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
         //For header
        $canvas = $dompdf->get_canvas();
        $header = $canvas->open_object();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $date = date("Y-m-d H:i:s");
        $canvas->page_text(250, 800, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas->add_object($header, "all"); 
        $n_file = "entrega_cuenta_".$id."_".$cad_ran.".pdf";
        file_put_contents("./uploads/formatos/entrega_cuenta/".$n_file, $dompdf->output());
        $archivo = "./uploads/formatos/entrega_cuenta/".$n_file;
        echo $archivo;
    }
    function general_cuentas()
    {
        require_once("librerias/PHPExcel-1.8/Classes/PHPExcel.php"); 
        $plaza= $_GET['plaza'];
        $soc= $_GET['soc'];; 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Plaza');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sociedad');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Banco');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tipo banca');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Contrato nomina');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Operación');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Responsable');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Firmantes');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'No.Cuenta');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Clabe');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', 'No.Cliente');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Fecha alta');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Contrato');
            $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Sucursal');
            $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Nombre suc.');
            $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Domicilio');
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Moneda');
            $objPHPExcel->getActiveSheet()->setCellValue('R1', 'Area op.');
            $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Status');
            $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Comentarios');
           // $objPHPExcel->getActiveSheet()->setCellValue('U1', 'Usuarios de banca');
            $objPHPExcel->getActiveSheet()->getStyle("A1:T1")->getFont()->setBold(true)->setName('Verdana')
            ->setSize(10)->getColor()->setRGB('ffffff');
            $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('0E7897');
            if($plaza == "TODAS" and $soc == "TODAS")
            {
                $cuentas = $this->reportes_model->todas_cuentas();
            }
            else
            {
                $cuentas = $this->reportes_model->all_cuentas($plaza,$soc);
            }
            $sheet= array();
            $i=0;
            while ($cta= $cuentas->fetch_assoc()) {
                if($cta['idcuenta'] != "")
                { 
                    $busca_firm = $this->reportes_model->busca_firmante($cta['idcuenta']); 
                }
                $firmantes = "";
                if(isset($busca_firm))
                {
                    while($firm = $busca_firm->fetch_assoc())
                    {
                        $firmantes .= $firm['nombre_emp']. ",";
                    }
                }
                if($firmantes == "")
                {
                    $firmantes = "sin firmantes";
                }
                if($cta['idcuenta'] != "")
                {
                    if($cta['domicilio'] == "")
                    {
                        $domicilio = "Sin domicilio";
                    }
                    else
                    {
                        $domicilio = $cta['domicilio'];
                    }
                    $sheet[$i] = array($cta['Plaza'],$cta['razonsocial'],$cta['banco'],$cta['tipo_cuenta'],$cta['contrato_nomina'],$cta['tipo_operacion'],$cta['responsable'],$firmantes,$cta['num_cuenta'],$cta['clabe'],$cta['no_cliente'],$cta['fecha_apertura'],$cta['no_contrato'],$cta['sucursal'],$cta['nombre_sucursal'],$domicilio,$cta['moneda'],$cta['area'],$cta['status_cuenta'],$cta['observaciones']);
                    $i++;
                }
            }
              
        $rowID = 2;
        foreach($sheet as $rowArray) 
        {
           $columnID = 'A';
           foreach($rowArray as $columnValue) {
              $objPHPExcel->getActiveSheet()->setCellValue($columnID.$rowID, $columnValue);
              $objPHPExcel->getActiveSheet()->getStyle($columnID.$rowID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $columnID++;
           }
           $rowID++;
        }
        foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="reporte_cuentas.xls"');
        header('Cache-Control: max-age=0');

        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
     function reporte_finan()
    {
        require_once("librerias/PHPExcel-1.8/Classes/PHPExcel.php"); 
        $id= $_REQUEST['id'];
        $datos_finan = $this->reportes_model->detalles($id);
        while ($d= $datos_finan->fetch_assoc()) 
        {
            $fecha_fin = $this->datacastella($d['fecha']);
            $inicio = $this->datacastella($d['periodo_inicio']);
            $fin = $this->datacastella($d['periodo_fin']);
            $importe_desc = number_format($d['importe_desc'],2,".",",");
            $importe_dep = number_format(floatval($d['importe_depo']),2,".",",");
            $importe_fin = number_format($d['importe_financiado'],2,".",",");
            $saldo = floatval($d['importe_financiado']-$d['importe_depo']);
            $saldo_final =number_format($saldo);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Datos Financiamiento');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Id');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $d['idfinanciamiento']);
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Sociedad');
            $objPHPExcel->getActiveSheet()->setCellValue('b3', $d['razonsocial']);
            $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Cliente');
            $objPHPExcel->getActiveSheet()->setCellValue('b4', $d['cte']);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Fecha');
            $objPHPExcel->getActiveSheet()->setCellValue('B5', $fecha_fin);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Autorizador');
            $objPHPExcel->getActiveSheet()->setCellValue('b6', $d['nombre_aut']);
            $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Inicio');
            $objPHPExcel->getActiveSheet()->setCellValue('B7', $inicio);
            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Vencimiento');
            $objPHPExcel->getActiveSheet()->setCellValue('B8', $fin);
            $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Estado');
            $objPHPExcel->getActiveSheet()->setCellValue('B9', $d['st_fin']);
            $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Observaciones');
            $objPHPExcel->getActiveSheet()->setCellValue('B10', $d['observaciones']);
            $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Detalles financiamiento');
            $objPHPExcel->getActiveSheet()->setCellValue('A12', 'FACTURAS');
            //hacer un ciclo y buscar las facturas y detalles de las facturas
            $facturas_finan = $this->reportes_model->facturas_financ($id);
            $c = 13;
            while ($fac= $facturas_finan->fetch_assoc()) 
            {
                $saldo_f = floatval($fac['importe_facturado']-$fac['importe_depositado']);
                $saldo_fac =number_format($saldo_f);
                $imp_desc = number_format($fac['importe_descuentos'],2,".",",");
                $imp_dep = number_format(floatval($fac['importe_depositado']),2,".",",");
                $imp_fac = number_format($fac['importe_facturado'],2,".",",");
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'IDFACTURA');
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $fac['idfactura_finan']);
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'FOLIO');
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $fac['folio_factura']);
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'FECHA');
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'DESCUENTOS');
                  $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$c.':C'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('AFD4E3');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $c++;
                $descuentos= $this->reportes_model->desc_financ($fac['idfactura_finan']);
                while ($des= $descuentos->fetch_assoc()) 
                {
                    $e=($c-1);
                    $imp_desc=number_format($des['importe_desc'],2,".",",");
                    $imp_pag=number_format($des['importe_pagado'],2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$e, 'Promotor');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $des['nombre_emp']);
                    $e++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$e, 'Descuentos');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $imp_desc);
                    $e++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$e, 'Pagado');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $imp_pag);
                    $e++;
                    $c++;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'DEPOSITOS');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$c.':C'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('AFD4E3');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');

                $c++;
                $abonos= $this->reportes_model->abono_factura($fac['idfactura_finan']);
                while ($ab= $abonos->fetch_assoc()) 
                {
                    $f=($c-1);
                    $fecha_abono = $this->datacastella($ab['fecha']);
                    $imp_abono=number_format($ab['importe'],2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$f, 'Razon social');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$f, $ab['razonsocial']);
                    $f++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$f, 'Tipo');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$f, $ab['tipo_nombre']);
                    $f++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$f, 'Estado');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$f, $ab['nombre']);
                    $f++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$f, 'Importe');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$f, $imp_abono);
                    $f++;
                    $c++;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'CHEQUES');
                  $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                 $objPHPExcel->getActiveSheet()->getStyle('B'.$c.':C'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('AFD4E3');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $c++;
                $cheques= $this->reportes_model->cheque_factura($fac['idfactura_finan']);
                while ($ch= $cheques->fetch_assoc()) 
                {
                    $g=($c-1);
                    $fecha_cheq = $this->datacastella($ch['fecha']);
                    $imp_cheq=number_format($ch['importe'],2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$g, 'Razon social');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$g, $ch['razonsocial']);
                    $g++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$g, 'Folio');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$g, $ch['folio_cheque']);
                    $g++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$g, 'Fecha');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$g, $fecha_cheq);
                    $g++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$g, 'Estado');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$g, $ch['nombre']);
                    $g++;
                    $c++;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$g, 'Importe');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$g, $imp_cheq);
                    $g++;
                    $c++;
                }
                  $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'TOTALES FACTURA FOLIO:'.$fac['folio_factura']);
                 $objPHPExcel->getActiveSheet()->getStyle('B'.$c.':F'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('457184');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('ffffff');
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'IMPORTE FACTURADO');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$c,$imp_fac);
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EDE8AD');
                $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'IMPORTE DESCUENTOS');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$c,$imp_desc);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EDE8AD');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'IMPORTE DEPOSITADO');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$c,$imp_dep);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EDE8AD');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
                $c++;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'SALDO FINAL');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$c,$saldo_fac);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EDE8AD');
                 $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');

            }
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, 'TOTALES FINANCIAMIENTO');
             $objPHPExcel->getActiveSheet()->getStyle('B'.$c.':F'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('12404F');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Verdana')
            ->setSize(10)->getColor()->setRGB('ffffff');

            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'TOTAL FINANCIADO');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, $importe_fin);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5DC7E9');
              $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'TOTAL DEPOSITOS');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, $importe_dep);
             $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5DC7E9');
              $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'TOTAL DESCUENTOS');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, $importe_desc);
             $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5DC7E9');
              $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, 'SALDO FINAL');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, $saldo_final);
             $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EDE44F');
              $objPHPExcel->getActiveSheet()->getStyle('E'.$c.':F'.$c)->getFont()->setBold(true)->setName('Verdana')
                ->setSize(10)->getColor()->setRGB('2C2A2A');
        }
        //$objPHPExcel->getActiveSheet()->setCellValue('A22', 'ABONOS/DEPOSITOS');
        $objPHPExcel->getActiveSheet()->getStyle("A1:A22")->getFont()->setBold(true)->setName('Verdana')
        ->setSize(10)->getColor()->setRGB('2C2A2A');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('287DA1');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setName('Verdana')
        ->setSize(10)->getColor()->setRGB('ffffff');
        $objPHPExcel->getActiveSheet()->getStyle('A11')->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('287DA1');
        $objPHPExcel->getActiveSheet()->getStyle("A11")->getFont()->setBold(true)->setName('Verdana')
        ->setSize(10)->getColor()->setRGB('ffffff');
         $objPHPExcel->getActiveSheet()->getStyle('A12')->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('E8E1AB');

            foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        } 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="reporte_financiamiento.xls"');
        header('Cache-Control: max-age=0');

        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    function datacastella($data = '') 
    {  
        static $mes = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'); 
        if ($data == '') $data = time(); 
        if ((int)$data > 9999) $data = date('Y-m-d', $data); list($a,$m,$d) = explode('-', $data); $d = (int)$d; $m = (int)$m; 
        return "$d de $mes[$m] de $a"; 
    }
     function fecha_abrev($data = '') 
    {  
        static $mes = array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'); 
        if ($data == '') $data = time(); 
        if ((int)$data > 9999) $data = date('Y-m-d', $data); list($a,$m,$d) = explode('-', $data); $d = (int)$d; $m = (int)$m; 
        return "$d-$mes[$m]-$a"; 
    }
   
      function menu_financ()
    {
        $bancos = $this->reportes_model->all_bancos();
        $plazas = $this->reportes_model->all_plazas();
        require('views/financiamiento/reportes/menu-reportes.php');
    }
     function reporte_grupo()
    {
        require_once("librerias/PHPExcel-1.8/Classes/PHPExcel.php"); 
        $plaza= $_REQUEST['plaza'];
        $soc = $_REQUEST['soc'];
        $fecha1 = $this->cambiaf_a_mysql($_REQUEST['f1']);
        $fecha2 = $this->cambiaf_a_mysql($_REQUEST['f2']);
        $gpo = $_REQUEST['gpo'];
        $fto = $_REQUEST['fto'];
        //id de las sociedades del reporte a generar
        $dirham = 5369;
        $forinte = 5370;
        $valpatri = 5371;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $total_financiado = 0;
        $total_depositado = 0;
        //Generar el formato interno
        if($fto == 1)
        {
              
            $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2D4875');
            $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true)->setName('Calibri')
            ->setSize(11)->getColor()->setRGB('ffffff');
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i=0;
            $c = 2 ;
            //Busca los financiamientos del cliente
            $grupos = $this->reportes_model->soc_grupo($gpo); 
            foreach($grupos as $gpo) 
            {
                $razon = $gpo['razon'];
                $financ_cliente = $this->reportes_model->financ_cliente($gpo['id'],$fecha1,$fecha2,$soc); 
                $abono = 0;
                $total_abonos = 0;
                $total_saldos = 0;
                $total_dirham = 0;
                $total_forinte = 0;
                $total_valpatri = 0;
                while ($fin = $financ_cliente->fetch_assoc()) 
                {
                    $imp_abono_dir=0;
                    $imp_abono_for=0;
                    $imp_abono_val=0;
                    $imp_number_dir = 0;
                    $imp_abono_for = 0;
                    $imp_abono_val = 0;
                    $saldo = 0;
                    $folio_fact = $fin['folio_factura'];
                    $pagadora = $fin['pagadora'];
                    $folio_kid = $fin['folio_kid'];
                    $periodo_inicio = $this->fecha_abrev($fin['periodo_inicio']);
                    $periodo_fin = $this->fecha_abrev($fin['periodo_fin']);
                    $periodo = $periodo_inicio.'/'.$periodo_fin;
                    $fecha_fin = $this->fecha_abrev($fin['fecha']);
                    $periodo_finan = $fin['periodo_inicio'].'/'.$fin['periodo_fin'];
                    $importe_nota = $fin['importe_nota'];
                    $calcula_abonos = $this->reportes_model->abonos_factura($fin['idfactura_finan']);
                    $abono = $fin['importe_depositado'];
                    $total_abonos = $total_abonos + $abono;
                     if($fin['fecha_nota'] == '0000-00-00')
                    {
                        $fecha_nota = "Sin fecha"; 
                    }
                    else
                    {
                        $fecha_nota = $this->fecha_abrev($fin['fecha_nota']);
                    }
                    $folio_nota = $fin['folio_nota'];
                    if($folio_nota == "")
                    {
                        $folio_nota = "N/A";
                    }
                    $status_nota = $fin['status_nota'];
                    $saldo = floatval($fin['importe_facturado']-$fin['importe_depositado']);
                    $format_saldo = number_format($saldo,2,".",",");
                    $total_saldos = $total_saldos + $saldo;
                    $deposito = $fin['importe_depositado'];
                    $nombre_factura = $fin['nombre_factura'];
                    $observaciones = $fin['obs_fact'];
                    $total_financiado = $total_financiado + $fin['importe_facturado'];
                    $total_depositado = $total_depositado + $fin['importe_depositado'];
                    if($fin['idsociedad'] == $dirham)
                    {
                        $imp_abono_dir = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_dir = $fin['importe_facturado'];
                        $total_dirham = ($total_dirham + $imp_number_dir);
                    }
                    elseif($fin['idsociedad'] == $forinte)
                    {
                        $imp_abono_for = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_for = $fin['importe_facturado']; 
                        $total_forinte = ($total_forinte + $imp_number_for);
                    }
                    elseif ($fin['idsociedad'] == $valpatri) 
                    {
                        $imp_abono_val = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_val = $fin['importe_facturado']; 
                        $total_valpatri = ($total_valpatri + $imp_number_val);
                    }
                     if($fin['fecha'] == '')
                    {
                        $fecha_abono = "Sin fecha"; 
                    }
                    else
                    {
                        $fecha_abono = $this->fecha_abrev($fin['fecha']);
                    }
                    $depositos_info = $this->reportes_model->depositos_info($fin['idfinanciamiento']);
                    $dep_text = "";
                     while ($dep = $depositos_info->fetch_assoc()) 
                    {
                        $imp_depCliente = number_format($dep['importe'],2,".",",");
                        $dep_text .= '$'.$imp_depCliente ." y ";
                    }
                    if($dep_text != "")
                    {
                        $format_dep =  substr($dep_text, 0, -2);
                    }
                    else
                    {
                        $format_dep = 0.00;
                    }
                    $format_total_saldos = number_format($total_saldos,2,".",",");
                    $format_total_abonos = number_format($total_abonos,2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$c, $folio_kid);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, $fecha_fin);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $razon);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2D4875');
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getFont()->setBold(true)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('ffffff');
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$c, $periodo);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, $nombre_factura);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, $folio_fact);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$c, '$'.$imp_abono_dir);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$c, '$'.$imp_abono_for);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$c, '$'.$imp_abono_val);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$c.':I'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9AB1E4');
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$c, $fecha_abono);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, '$'.$abono);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, '$'.$format_saldo);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B9E3BA');
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$c, $format_dep);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$c, $observaciones);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
                     $objPHPExcel->getActiveSheet()->setCellValue('O'.$c, $pagadora);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$c, $importe_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$c, $fecha_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$c, $status_nota);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$c, $folio_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$c.':B'.$c)->getFont()->setBold(false)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('000000');
                     $objPHPExcel->getActiveSheet()->getStyle('D'.$c.':S'.$c)->getFont()->setBold(false)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('000000');
                     $objPHPExcel->getActiveSheet()->getStyle('A'.$c.':S'.$c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $c++;
                }
                $border_style= array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK)));
                $format_dirham = number_format($total_dirham,2,".",",");
                $format_forinte = number_format($total_forinte,2,".",",");
                $format_valpatri = number_format($total_valpatri,2,".",",");
                $format_saldo = number_format($total_saldos,2,".",",");
                $format_abonos = number_format($total_abonos,2,".",",");
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$c, '$'.$format_dirham);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$c, '$'.$format_forinte);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$c, '$'.$format_valpatri);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, '$'.$format_abonos);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, '$'.$format_saldo);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$c.':S'.$c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle ("A".$c.':S'.$c)->applyFromArray($border_style);
                $c++;

            }
            $saldo_financiamiento = ($total_financiado - $total_depositado);
            $format_saldo_fin = number_format($saldo_financiamiento,2,".",",");
            $format_total_financiado = number_format($total_financiado,2,".",",");
            $format_total_depositado = number_format($total_depositado,2,".",",");
            $c = $c+3;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, 'TOTAL FINANCIADO');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$c, '$'.$format_total_financiado);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('447B98');
             $objPHPExcel->getActiveSheet()->getStyle('M'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('44A0C2');
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c.':M'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(12)->getColor()->setRGB('ffffff');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, 'TOTAL ABONOS');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$c, '$'.$format_total_depositado);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('447B98');
             $objPHPExcel->getActiveSheet()->getStyle('M'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('44A0C2');
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c.':M'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(12)->getColor()->setRGB('ffffff');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, 'SALDO FINAL');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$c, '$'.$format_saldo_fin);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBB158');
            $objPHPExcel->getActiveSheet()->getStyle('M'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('13405F');
            $objPHPExcel->getActiveSheet()->getStyle('L'.$c.':M'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(16)->getColor()->setRGB('ffffff');
        }
        //Generar el formato de los clientes
        else
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FECHA DE FINAN.');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'RAZON SOCIAL');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'FACTURA');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'DIRHAM');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FORINTE');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'VALPATRI');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'FECHA DE ABONO');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'ABONO');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'SALDO');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'DEPOSITO');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', 'DEVOLUCION/NOTA DE CRÉDITO');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', 'FECHA DE ABONO');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', 'ESTATUS');
            $objPHPExcel->getActiveSheet()->setCellValue('N1', 'FOLIO');
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2D4875');
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true)->setName('Calibri')
            ->setSize(11)->getColor()->setRGB('ffffff');
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i=0;
            $c = 2 ;
            //Busca los financiamientos del cliente
            $grupos = $this->reportes_model->soc_grupo($gpo); 
            foreach($grupos as $gpo) 
            {
                $razon = $gpo['razon'];
                $financ_cliente = $this->reportes_model->financ_cliente($gpo['id'],$fecha1,$fecha2,$soc);
                $abono = 0;
                $total_abonos = 0;
                $total_saldos = 0;
                $total_dirham = 0;
                $total_forinte = 0;
                $total_valpatri = 0;
                while ($fin = $financ_cliente->fetch_assoc()) 
                {
                    $imp_abono_dir=0;
                    $imp_abono_for=0;
                    $imp_abono_val=0;
                    $imp_number_dir = 0;
                    $imp_abono_for = 0;
                    $imp_abono_val = 0;
                    $saldo = 0;
                    $folio_fact = $fin['folio_factura'];
                    $fecha_fin = $this->fecha_abrev($fin['fecha']);
                    $periodo_finan = $fin['periodo_inicio'].'/'.$fin['periodo_fin'];
                    $importe_nota = $fin['importe_nota'];
                    $calcula_abonos = $this->reportes_model->abonos_factura($fin['idfactura_finan']);
                    $abono = $fin['importe_depositado'];
                    $total_abonos = $total_abonos + $abono;
                     if($fin['fecha_nota'] == '0000-00-00')
                    {
                        $fecha_nota = "Sin fecha"; 
                    }
                    else
                    {
                        $fecha_nota = $this->fecha_abrev($fin['fecha_nota']);
                    }
                    $folio_nota = $fin['folio_nota'];
                    if($folio_nota == "")
                    {
                        $folio_nota = "N/A";
                    }
                    $status_nota = $fin['status_nota'];
                    $saldo = floatval($fin['importe_facturado']-$fin['importe_depositado']);
                    $format_saldo = number_format($saldo,2,".",",");
                    $total_saldos = $total_saldos + $saldo;
                    $deposito = $fin['importe_depositado'];
                    $total_financiado = $total_financiado + $fin['importe_facturado'];
                    $total_depositado = $total_depositado + $fin['importe_depositado'];
                    if($fin['idsociedad'] == $dirham)
                    {
                        $imp_abono_dir = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_dir = $fin['importe_facturado'];
                        $total_dirham = ($total_dirham + $imp_number_dir);
                    }
                    elseif($fin['idsociedad'] == $forinte)
                    {
                        $imp_abono_for = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_for = $fin['importe_facturado']; 
                        $total_forinte = ($total_forinte + $imp_number_for);
                    }
                    elseif ($fin['idsociedad'] == $valpatri) 
                    {
                        $imp_abono_val = number_format($fin['importe_facturado'],2,".",",");
                        $imp_number_val = $fin['importe_facturado']; 
                        $total_valpatri = ($total_valpatri + $imp_number_val);
                    }
                     if($fin['fecha'] == '')
                    {
                        $fecha_abono = "Sin fecha"; 
                    }
                    else
                    {
                        $fecha_abono = $this->fecha_abrev($fin['fecha']);
                    }
                    $depositos_info = $this->reportes_model->depositos_info($fin['idfinanciamiento']);
                    $dep_text = "";
                     while ($dep = $depositos_info->fetch_assoc()) 
                    {
                        $imp_depCliente = number_format($dep['importe'],2,".",",");
                        $dep_text .= '$'.$imp_depCliente ." y ";
                    }
                    if($dep_text != "")
                    {
                        $format_dep =  substr($dep_text, 0, -2);
                    }
                    else
                    {
                        $format_dep = 0.00;
                    }
                    $format_total_saldos = number_format($total_saldos,2,".",",");
                    $format_total_abonos = number_format($total_abonos,2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$c, $fecha_fin);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$c, $razon);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2D4875');
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$c)->getFont()->setBold(true)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('ffffff');
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $folio_fact);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$c, '$'.$imp_abono_dir);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, '$'.$imp_abono_for);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, '$'.$imp_abono_val);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$c.':F'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9AB1E4');
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$c, $fecha_abono);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$c, '$'.$abono);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$c, '$'.$format_saldo);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$c)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B9E3BA');
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$c, $format_dep);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, $importe_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$c, $fecha_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$c, $status_nota);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$c, $folio_nota);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$c)->getFont()->setBold(false)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('000000');
                     $objPHPExcel->getActiveSheet()->getStyle('C'.$c.':N'.$c)->getFont()->setBold(false)->setName('Calibri')
                    ->setSize(10)->getColor()->setRGB('000000');
                     $objPHPExcel->getActiveSheet()->getStyle('A'.$c.':N'.$c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $c++;
                }
                    $border_style= array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK)));
                    $format_dirham = number_format($total_dirham,2,".",",");
                    $format_forinte = number_format($total_forinte,2,".",",");
                    $format_valpatri = number_format($total_valpatri,2,".",",");
                    $format_saldo = number_format($total_saldos,2,".",",");
                    $format_abonos = number_format($total_abonos,2,".",",");
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$c, '$'.$format_dirham);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$c, '$'.$format_forinte);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$c, '$'.$format_valpatri);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$c, '$'.$format_abonos);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$c, '$'.$format_saldo);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$c.':N'.$c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle ("A".$c.':N'.$c)->applyFromArray($border_style);
                    $c++;

            }
            $saldo_financiamiento = ($total_financiado - $total_depositado);
            $format_saldo_fin = number_format($saldo_financiamiento,2,".",",");
            $format_total_financiado = number_format($total_financiado,2,".",",");
            $format_total_depositado = number_format($total_depositado,2,".",",");
            $c = $c+3;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$c, 'TOTAL FINANCIADO');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, '$'.$format_total_financiado);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('447B98');
             $objPHPExcel->getActiveSheet()->getStyle('K'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('44A0C2');
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c.':K'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(12)->getColor()->setRGB('ffffff');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$c, 'TOTAL ABONOS');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, '$'.$format_total_depositado);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('447B98');
             $objPHPExcel->getActiveSheet()->getStyle('K'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('44A0C2');
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c.':K'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(12)->getColor()->setRGB('ffffff');
            $c++;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$c, 'SALDO FINAL');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$c, '$'.$format_saldo_fin);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBB158');
            $objPHPExcel->getActiveSheet()->getStyle('K'.$c)->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('13405F');
            $objPHPExcel->getActiveSheet()->getStyle('J'.$c.':K'.$c)->getFont()->setBold(true)->setName('Calibri')
            ->setSize(16)->getColor()->setRGB('ffffff');
        }
  

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="reporte_financiamiento.xls"');
        header('Cache-Control: max-age=0');

        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
     function formatoEstado()
    {
       ini_set('xdebug.max_nesting_level', 900);
       $id=$_POST['cuenta_form'];
       $fecha_actual = $this->datacastella(date('Y-m-d'));
       $info_ext = $_POST['comentarios_form'];
       $formato = $_POST['cboFormato'];
       $cad_ran = $this->generateRandomString();
       require_once("librerias/dompdf/dompdf_config.inc.php"); 
        $cuentas = $this->reportes_model->busca_cuenta($id);
        while ($cta= $cuentas->fetch_assoc()) {
            $banco = strtoupper($cta['banco']);
            $num_cuenta = $cta['num_cuenta'];
            $clabe = $cta['clabe'];
            $responsable = $cta['responsable'];
            $empresa = strtoupper($cta['razonsocial']);
            $fecha_ap = $this->datacastella($cta['fecha_apertura']);
            $domicilio = strtoupper($cta['domicilio']);

        } 
        if($formato == 1)
        {
            $status = "ACTIVADA";
        } 
        elseif($formato == 0)
        {
            $status = "CANCELADA";
        }
        elseif($formato == 2)
        {
            $status = "BLOQUEADA";
        }
        //subir la imagen para el reporte
       if (!empty($_FILES['logo_format']['name'])){ 
            $folder = "./uploads/formatos/logos/";
            $uploadOk = 1;
            $maxlimit = 50000000; 
            $allowed_ext ="jpg,png,jpeg"; 
            $overwrite = "yes"; 
            $match = ""; 
            $filesize = $_FILES['logo_format']['size']; 
            $old_name = strtolower($_FILES['logo_format']['name']); 
            $name = $_FILES['logo_format']['name'];
            $file_ext = pathinfo($name, PATHINFO_EXTENSION);
            if(!file_exists($folder))
            {
            mkdir ($folder);
            } 
            $filename= "logo_".$cad_ran.".".$file_ext;
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

               if(move_uploaded_file($_FILES['logo_format']['tmp_name'], $folder.$filename))
               { 
                   
                }
            }   
        }  
        $html ='<html><body>'.'<body>';
         if (!empty($_FILES['logo_format']['name']))
         { 
             $rt = '/var/www/html/systema/finanzas/uploads/formatos/logos/'.$filename;
            $html .= '
            <div style="position; fixed; left: 0px; right: 0px; top: 35px;">
                <img src="'.$rt.'" width="270" height="270" style="margin-top:15px;"/>
            </div>';
        }
        $busca_firm = $this->reportes_model->busca_firmante($id); 
        $firmantes = "";
        while($firm = $busca_firm->fetch_assoc())
        {
            $firmantes .= $firm['nombre_emp']. ",";
        }
        $emp_firmantes =substr($firmantes, 0, -1);
        $html .= '<div style="margin-top:150px;text-align: justify;" >
        <span style="margin-left:52%;">Guadalajara,Jalisco a  '.$fecha_actual.'</span><br><br><p>Por el presente medio se les informa a todos los interesados que la cuenta: 
        <strong>'.$num_cuenta.'</strong> del banco: 
        <strong>'.$banco.'</strong>, de la empresa:<strong> '.$empresa.'</strong> con 
        clabe interbancaria estandarizada(clabe)<strong>N.'.$clabe.'</strong> ha sido <strong>'.$status.'</strong>, esta cuenta permanecerá en el estado antes mencionado hasta nuevo aviso, por lo tanto le pedimos de la manera mas atenta tomar 
        las consideraciones  necesarias en relación a esta cuenta.<br>';
        $html .='<br><strong>Datos Generales de la cuenta:</strong><span> Fecha de apertura <strong>'.$fecha_ap.'</strong>, firmo en la cuenta
        como representante legal '.$responsable.' en forma mancomunada con <strong>'.$emp_firmantes. '</strong>, en la cuenta <strong>'.$num_cuenta.'</strong> con domicilio
        fiscal <strong>'.$domicilio.'</strong>,Guadalajara,Jalisco. <br><br><br>';

        if($info_ext != "")
        {
            $html .= '<strong>Información adicional:</strong>'.$info_ext.'<br><br>';
        }
        $html .='<p>Sin más por el momento me despido con un cordial saludo.</p></div></body></html>';
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
         //For header
        $canvas = $dompdf->get_canvas();
        $header = $canvas->open_object();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $date = date("Y-m-d H:i:s");
        $canvas->page_text(35, 25, "Informe de cambio de estado de cuenta", $font, 8, array(0, 0, 0));
        $canvas->page_text(490, 25, "SISTEMA FINANZAS", $font, 8, array(0, 0, 0));
        $canvas->page_text(250, 800, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas->add_object($header, "all"); 
        $n_file = "formato_".$status."_".$cad_ran.".pdf";
        file_put_contents("./uploads/formatos/estado/".$n_file, $dompdf->output());
        $archivo = "./uploads/formatos/estado/".$n_file;
        if (!empty($_FILES['logo_format']['name']))
        {
            if (file_exists($folder.$filename)) 
            {
                unlink($folder.$filename); 
            }
        }
        echo $archivo;
    }
    function mail_reporte_estado()
    {
        //funcion para enviar un reporte por mail
        $archivo = $_POST['arch'];
        $cta = $_POST['cta'];
        $pza = $_POST['pza'];
        $soc = $_POST['soc'];
        date_default_timezone_set('Etc/UTC');
        require './librerias/phpMailer/PHPMailerAutoload.php';
        $busca_cuenta= $this->reportes_model->busca_cuenta_id($cta);
        $datos= $this->reportes_model->busca_correos($pza,$soc);
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
                        <span style='color:#686767;'>Por favor no responda a este mensaje, este es un correo automatico enviado desde de la plataforma <strong>INTEGRA FINANZAS</strong>.</span>
                        
                    </div>
                </body>
                </html>";
            }
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "integra.finanzas15@gmail.com";
        $mail->Password = "d3s4rr0ll0";
        $mail->setFrom('integra.finanzas15@gmail.com', 'INTEGRA FINANZAS');
        $mail->addReplyTo('integra.finanzas15@gmail.com', 'INTEGRA FINANZAS');
         foreach ($datos as $dato) 
         {
            $email=$dato['email'];
            $nombre=$dato['empleado'];

            $mail->addAddress($email, $nombre);
         }
        $mail->Subject = 'CAMBIO DE ESTADO DE CUENTA';
        $mail->AddAttachment($archivo);
        $mail->msgHTML($contents);
        $mail->AltBody = 'Este es un mensaje de texto plano';
        if (!$mail->send()) {
            echo "Error al enviar mensaje: ".$mail->ErrorInfo;;
        } else {
            echo 1;
        }
    }
     function entregaChequera()
    {
      
       ini_set('xdebug.max_nesting_level', 900);
       $id=$_POST['cuenta_cheq'];
       $fecha_actual = $this->datacastella(date('Y-m-d'));
       $representante = $_POST['rep_legal'];
       $per_entrega = $_POST['entregar_cheq'];
       $ife = $_POST['ife_cheq'];
       $comentarios = $_POST['comentarios_cheq'];
       $f2 = $_POST['firmante2'];
       $cad_ran = $this->generateRandomString();
       $cuentas = $this->reportes_model->busca_cuenta($id);
        while ($cta= $cuentas->fetch_assoc()) {
            $banco = strtoupper($cta['banco']);
            $num_cuenta = $cta['num_cuenta'];
            $responsable = $cta['responsable'];
            $empresa = strtoupper($cta['razonsocial']);
            $id_soc = $cta['idempresa'];
        } 

         $html = "<html><style>html {
              margin: 0;
            }body { background-image: url('./uploads/formatos/membretes/".$id_soc.".jpg'); background-repeat: no-repeat; background-position: 0mm 0mm; background-height: 100%; background-width: 100%;}</style><body><div style='padding:10%'>";
        $html .= '<div style="margin-top:150px;text-align: justify;" >
        <span style="margin-left:52%;">Guadalajara,Jalisco a  '.$fecha_actual.'</span><br><br>
        <H4 style="font-weight:bold;">'.$banco.'</H4>
        <strong>Presente</strong><br><br>
        <H4>A QUIEN CORRESPONDA</H4>    
        <p>Por medio de la presente autorizo  a C.'.$per_entrega.'  con número de <strong>IFE '.$ife.'</strong> para que en mi nombre y representación pueda recoger la(s) chequera(s) de la(s) cuenta(s)
        <strong> N° '.$num_cuenta.'</strong> a nombre de <strong> '.$empresa.'</strong> y que en el momento de su entrega sea <strong>ACTIVADA</strong>';
        if($comentarios != "")
        {
            $html .='<p>'.$comentarios.'</p>';
        }
        $html .='<p>Me despido quedando a sus órdenes para cualquier duda o aclaración al respecto.</p></div>';
        $html .= '<br><br><br><div style="text-align:center;"><br><br><br><span>_______________________</span><br><span>'.$representante.'<br><br><br><br><br><span>_______________________</span><br><span>'.$f2.'</span><br></div>';
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
         //For header
        $canvas = $dompdf->get_canvas();
        $header = $canvas->open_object();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $date = date("Y-m-d H:i:s");
        $canvas->page_text(250, 800, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas->add_object($header, "all"); 
        $n_file = "formato_chequera_".$cad_ran.".pdf";
        file_put_contents("./uploads/formatos/chequeras/".$n_file, $dompdf->output());
        $archivo = "./uploads/formatos/chequeras/".$n_file;
        // if (file_exists($folder.$filename)) 
        // {
        //     unlink($folder.$filename); 
        // }
        echo $archivo;
    }
     function formatoDatos()
    {
      
       ini_set('xdebug.max_nesting_level', 900);
       $id=$_POST['cuenta_dat'];
       $fecha_actual = $this->datacastella(date('Y-m-d'));
       $comentarios = $_POST['comentarios_dat'];
       $f2 = $_POST['firm_dat'];
       $fto = $_POST['fto_datos'];
       $cad_ran = $this->generateRandomString();
       $cuentas = $this->reportes_model->busca_cuenta($id);
        while ($cta= $cuentas->fetch_assoc()) {
            $banco = strtoupper($cta['banco']);
            $num_cuenta = $cta['num_cuenta'];
            $responsable = $cta['responsable'];
            $empresa = strtoupper($cta['razonsocial']);
            $id_hisDom = $cta['idhistorial_domicilio'];
            $id_empresa = $cta['idempresa'];
        } 
        $html = "<html><style>html {
  margin: 0;
}body { background-image: url('./uploads/formatos/membretes/".$id_empresa.".jpg'); background-repeat: no-repeat; background-position: 0mm 0mm; background-height: 100%; background-width: 100%;}</style><body>";
        $html .= '<div style="margin-top:150px;text-align: justify; padding:10%;" >
        <span style="margin-left:52%;">Guadalajara,Jalisco a  '.$fecha_actual.'</span><br><br>
        <span style="font-weight:bold;">'.$banco.'</span><br>
        <strong>Presente</strong><br><br>
        <H4>A quien corresponda</H4>    
        <p>Por medio de la presente solicito actualización de ';
        if($fto == 1)
        {
            $html .= 'firmantes ';
        }
        elseif($fto == 2)
        {
            $html .= 'domicilio ';
        }
        $html .= '<strong> en la cuenta N° '.$num_cuenta.'</strong> a nombre de <strong> '.$empresa.', quedando de la siguiente manera:<br><br>';
        if($fto == 1)
        {
            $html .= '- '.$responsable.' (Apoderado legal)<br>';
            $busca_firm = $this->reportes_model->busca_firmante($id); 
            while($firm = $busca_firm->fetch_assoc())
            {
                $html .= '- '.$firm['nombre_emp'].'<br>';
            }
        }
        else
        {
              $busca_dom = $this->reportes_model->datos_domicilio($id_hisDom);
            while($d = $busca_dom->fetch_assoc())
            {
                $html.= $d['domicilio'];
            }
        }
        if($comentarios != "")
        {
            $html .='<br><p>'.$comentarios.'</p>';
        }
        $html .='<br><br><p>Me despido quedando a sus órdenes para cualquier duda o aclaración al respecto.</p></div>';
        $html .= '<br><br><br><div style="text-align:center;"><br><br><br><span>_______________________</span><br><span>'.$responsable.'</span><br>(Apoderado Legal)<br><br><br><br><br><span>_______________________</span><br><span>'.$f2.'</span><br></div>';
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper("A4", "portrait");
        $dompdf->render();
         //For header
        $canvas = $dompdf->get_canvas();
        $header = $canvas->open_object();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $date = date("Y-m-d H:i:s");
        $canvas->page_text(250, 800, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $canvas->add_object($header, "all"); 
        $n_file = "formato_".$status."_".$cad_ran.".pdf";
        file_put_contents("./uploads/formatos/datos/".$n_file, $dompdf->output());
        $archivo = "./uploads/formatos/datos/".$n_file;
        echo $archivo;
    }
  

}

?>
