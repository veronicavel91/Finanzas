<?php
    require("models/connection_sqli_manual.php"); // funciones mySQLi

    class financiamiento_model extends Connection
    {
         //obtiene todas las plazas
       function all_plazas()
        {
            $query='SELECT * from sistema.plazas order by plaza';
            $datos = $this->query($query);
            return $datos;
        }
        //filtra los clientes por plaza
        function clientes_empresa($idplaza)
        {
        	$query='SELECT distinct clientes.id,razon from empresacte inner join clientes on clientes.id=empresacte.idcte order by razon';
            $datos = $this->query($query);
            return $datos;
        }
             function all_personal()
        {
            $query ="SELECT Id_empleado,  CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados where estado='ALTA' and plazamadre<>5 and plazamadre=1 or plazamadre=6 order by nombre_emp";
            $datos=$this->query($query);
            return $datos;
        }
        //autorizados filtrados por plaza y sociedad
        function aut_plaza_soc($plaza, $soc)
        {
            $query ="SELECT Id_empleado,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados where Id_empleado not in(select id_empleado from finanzas.autoriza_financiamiento where idplaza=".$plaza." and idsociedad=".$soc.") and estado='ALTA' order by nombre_emp;";
            $datos=$this->query($query);
            return $datos;
        }
        function all_sociedades()
        {
            $query="SELECT idempresa,razonsocial from empresas order by razonsocial";
            $datos = $this->query($query);
            return $datos;
        }
        function all_status()
        {
            $query = "SELECT * from finanzas.status_financiamiento";
            $datos = $this->query($query);
            return $datos;
        }
        function guarda_financ($pza, $soc, $cte, $aut,$fecha,$del, $al,$imp_dep,$imp_desc,$imp_ab,$imp_fin, $edo, $obs, $dateTime)
        {
            $query = "INSERT INTO finanzas.Financiamiento(idplaza, idsociedad, idcte, id_autorizador, fecha, periodo_inicio, periodo_fin, importe_depo, importe_financiado, importe_desc, depositos_cliente,idstatus_financiado, observaciones, usuario_captura, created_at) values(".$pza.",".$soc.",".$cte.",".$aut.",'".$fecha."','".$del."','".$al."',".$imp_dep.",".$imp_fin.",".$imp_desc.",".$imp_ab.",".$edo.",'".$obs."',"."1".",'".$dateTime."');";
            $datos = $this->insert_id($query);
            return $datos;
        }
        function guarda_cheque($fin,$idFactura,$cheque,$soc_cheque,$edo_cheque,$fecha_cheque,$importe,$obs,$created_at)
        {
            $query = "INSERT INTO finanzas.cheque_financiamiento(idfinanciamiento,idfactura_finan, folio_cheque, idsociedad, idstatus_cheque, fecha, importe, observaciones, created_at) values(".$fin.",".$idFactura.",".$cheque.",".$soc_cheque.",".$edo_cheque.",'".$fecha_cheque."',".$importe.",'".$obs."','".$created_at."');";
            $datos = $this->query($query);
            return $datos;
        }
         function guarda_factura($fin,$folio_fact,$fecha_fact,$folio_kid,$socFactura,$importe_dep,$importe_fact,$importe_desc,$nombre_factura,$obs_fact,$edo_fact, $dateTime)
        {
            $query = "INSERT INTO finanzas.facturas_finan(idfinanciamiento, folio_factura, fecha_factura,folio_kid,idsociedad,importe_depositado, importe_facturado, importe_descuentos, nombre_factura, observaciones, status_fact,created_at) values(".$fin.",".$folio_fact.",'".$fecha_fact."',".$folio_kid.",".$socFactura.",".$importe_dep.",".$importe_fact.",".$importe_desc.",'".$nombre_factura."','".$obs_fact."',".$edo_fact.",'".$dateTime."');";
            $datos = $this->insert_id($query);
            return $datos;
        }  
         function guarda_descuento($fin,$idFactura,$promotor,$importe,$fecha,$estado,$obser,$dateTime)
        {
            $query = "INSERT INTO finanzas.descuento_promotor(idfinanciamiento, id_empleado, idfactura_finan, importe_desc,fecha, observaciones, idstatus_descuento, usuario_captura, created_at) values(".$fin.",".$promotor.",".$idFactura.",".$importe.",".$fecha.",'".$obser."',".$estado.",1,'".$dateTime."');";
            $datos = $this->query($query);
            return $datos;
        }  
        function status_fact()
        {
            $query = "SELECT * from finanzas.status_factura";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_aut($plaza,$soc)
        {
            $query= "SELECT apatodo.Empleados.Id_empleado as id,  CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados inner join finanzas.autoriza_financiamiento on apatodo.Empleados.Id_empleado=finanzas.autoriza_financiamiento.id_empleado where finanzas.autoriza_financiamiento.idplaza=".$plaza." and finanzas.autoriza_financiamiento.idsociedad=".$soc;
            $datos = $this->query($query);
            return $datos;
        }
        //datos generales del financiamiento
        function detalles($idfin)
        {
            $query="SELECT f.idfinanciamiento, f.created_at, f.updated_at,pl.plaza,s.razonsocial, e.razon cte, CONCAT( apa.Nombre,' ', apa.Apellidop,' ', apa.Apellidom ) as nombre_aut, f.periodo_inicio,
f.periodo_fin, CONCAT( apa.Nombre,' ', apa.Apellidop,' ', apa.Apellidom ) as nombre_aut,f.idstatus_financiado, ef.nombre as st_fin, f.observaciones, f.importe_depo, f.importe_financiado, f.importe_desc
from finanzas.Financiamiento as f inner join finanzas.status_financiamiento as ef on ef.idstatus_financiado=f.idstatus_financiado
inner join apatodo.Empleados as apa on f.id_autorizador=apa.Id_empleado inner join clientes as e 
on e.id=f.idcte left join sistema.plazas as pl on pl.idplaza=f.idplaza left join sistema.empresas as s on s.idempresa=f.idsociedad where f.idfinanciamiento=".$idfin;
            $datos = $this->query($query);
            return $datos;
        }
        function cheques_financ($idfin)
        {
            $query= "SELECT * from finanzas.cheque_financiamiento ch inner join finanzas.status_cheque s on ch.idstatus_cheque=s.idstatus_cheque where idfinanciamiento=".$idfin;
            $datos= $this->query($query);
            return $datos;
        }
        function facturas_financ($idfin)
        {
            $query= "SELECT * from finanzas.facturas_finan as f inner join finanzas.status_factura as s on s.idstatus_factura=f.status_fact where idfinanciamiento=".$idfin;
            $datos= $this->query($query);
            return $datos;
        }
         function desc_financ($idfact)
        {
            $query= "SELECT *, CONCAT( a.Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp  
            from apatodo.Empleados as a  inner join finanzas.descuento_promotor as d on a.Id_empleado=d.id_empleado inner join 
            finanzas.status_descuento as s on s.idstatus_descuento=d.idstatus_descuento where d.idfactura_finan=".$idfact;
            $datos= $this->query($query);
            return $datos;
        }
        function abono_factura($idFact)
        {
            $query= "SELECT a.idabono, a.idfinanciamiento, a.idfactura_finan, a.idsociedad, a.idtipo_pago, 
            a.fecha, a.importe, a.idstatus_abono, a.observaciones, a.usuario_captura, a.created_at, 
            a.updated_at,s.razonsocial, e.nombre, t.nombre as tipo_nombre from finanzas.abonos_financiamiento a 
            inner join finanzas.tipo_pago t on a.idtipo_pago=t.idtipo_pago 
            left join sistema.empresas as s on s.idempresa=a.idsociedad 
            inner join finanzas.status_abono as e on e.idstatus_abono=a.idstatus_abono where idfactura_finan=".$idFact;
            $datos= $this->query($query);
            return $datos;
        }
        function autorizados($plaza,$soc)
        {
            $query="SELECT aut.id_empleado,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre from finanzas.autoriza_financiamiento aut inner join apatodo.Empleados apa on aut.id_empleado=apa.Id_empleado where aut.idplaza=".$plaza." and aut.idsociedad=".$soc;   
            $datos= $this->query($query);
            return $datos;
        }
        function guarda_autoriza($plaza, $soc, $idemp)
        {
            $query="INSERT INTO finanzas.autoriza_financiamiento(idplaza,idsociedad,id_empleado,status) values(".$plaza.",".$soc.",".$idemp.",1)";
            $datos= $this->query($query);
        }
        function consulta_finan($plaza,$soc)
        {
            $query = "SELECT idfinanciamiento,razon,periodo_inicio,periodo_fin,nombre,fin.updated_at,fin.idstatus_financiado,importe_depo,importe_financiado
from clientes as c inner join finanzas.Financiamiento as fin on c.id=fin.idcte inner join finanzas.status_financiamiento
as s on s.idstatus_financiado=fin.idstatus_financiado where fin.idplaza=9 and fin.idsociedad=".$soc." ORDER BY fin.idfinanciamiento DESC";
            $datos= $this->query($query);
            return $datos;
        }
        function borrar_factura($fact)
        {
            $query="DELETE from finanzas.facturas_finan where idfactura_finan=".$fact;
            $datos= $this->query($query);
            return $datos;
        }
        function borrar_cheque($id)
        {
            $query="DELETE from finanzas.cheque_financiamiento where idcheque=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function calcula_fin($id)
        {
            $query="SELECT importe_financiado from finanzas.Financiamiento where idfinanciamiento=".$id.";";
            $datos= $this->query($query);
            return $datos;
        }
         function calcula_dep($id)
        {
            $query="SELECT importe_depo from finanzas.Financiamiento where idfinanciamiento=".$id;
            $datos= $this->query($query);
            return $datos;
        }
         function calcula_desc($id)
        {
            $query="SELECT importe_desc from finanzas.Financiamiento where idfinanciamiento=".$id.";";
            $datos= $this->query($query);
            return $datos;
        }
        //suma el importe de la factura al saldo del financiamiento de la factura
        function sumar_financiado($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_financiado=importe_financiado +".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
         //suma el importe de la factura al saldo del financiamiento de la factura
        function sumar_descuento($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_desc=importe_desc +".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
         function sumar_deposito($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_depo=importe_depo +".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
         //resta el importe de la factura al saldo del financiamiento de la factura
        function resta_impFin($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_financiado=importe_financiado -".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
        function restar_descuento($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_desc=importe_desc -".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
         function restar_deposito($fin,$importe)
        {
            $query= "UPDATE finanzas.Financiamiento set importe_depo=importe_depo -".$importe." where idfinanciamiento=".$fin;
            $datos= $this->query($query);
            return $datos;
        }
         //suma el importe de la factura al saldo del financiamiento de la factura
        function estados_cheque()
        {
            $query= "SELECT * from finanzas.status_cheque;";
            $datos= $this->query($query);
            return $datos;
        }
         function estados_descuento()
        {
            $query= "SELECT * from finanzas.status_descuento;";
            $datos= $this->query($query);
            return $datos;
        }
          function update_pago_desc($des,$imp)
        {
            $query= "UPDATE finanzas.descuento_promotor set importe_pagado=importe_pagado+".$imp." where id_descuento=".$des;
            $datos= $this->query($query);
            return $datos;
        }
       
        function regreso_promotor($fin,$desc,$imp,$fecha,$obs)
        {
            $query= "INSERT INTO finanzas.regreso_descuentos(idfinanciamiento,id_descuento,importe,fecha,observaciones) values(".$fin.",".$desc.",".$imp.",'".$fecha."','".$obs."')";
            $datos= $this->query($query);
            return $datos;
        }
        function consulta_regresos($desc)
        {
            $query="SELECT * from finanzas.regreso_descuentos where id_descuento=".$desc;
            $datos= $this->query($query);
            return $datos;
        }
         function borrar_pago($id)
        {
            $query="DELETE from finanzas.regreso_descuentos where idregreso=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function resta_pago_desc($des,$imp)
        {
            $query= "UPDATE finanzas.descuento_promotor set importe_pagado=importe_pagado-".$imp." where id_descuento=".$des;
            $datos= $this->query($query);
            return $datos;
        }
        function facturas_combo($id)
        {
            $query= "SELECT * from finanzas.facturas_finan where idfinanciamiento=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function borrar_descuento($desc)
        {
            $query= "DELETE from finanzas.descuento_promotor where id_descuento=".$desc;
            $datos= $this->query($query);
            return $datos;
        }
        function busca_status()
        {
            $query="SELECT * from finanzas.status_financiamiento where idstatus_financiado<>5 and idstatus_financiado<>2";
             $datos= $this->query($query);
            return $datos;

        }
        function actualiza_edo_fin($id,$edo)
        {
            $query="UPDATE finanzas.Financiamiento set idstatus_financiado=".$edo." where idfinanciamiento=".$id;
            $datos= $this->query($query);
            return $datos;
        }
           function edo_actual_factura($id)
        {
            $query= "SELECT f.status_fact, s.nombre,f.idfactura_finan from finanzas.facturas_finan as f inner join finanzas.status_factura as s on s.idstatus_factura=f.status_fact where idfactura_finan=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function edo_actual_descuento($id)
        {
            $query= "SELECT * from finanzas.descuento_promotor where id_descuento=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function facturas_descuentos($id)
        {
            $query="SELECT count(folio_fact) as total_fact from finanzas.descuento_promotor where folio_fact=".$id;
            $datos= $this->query($query);
            return $datos;
        }
           function update_edo_factura($id,$edo)
        {
            $query="UPDATE finanzas.facturas_finan set status_fact=".$edo." where idfactura_finan=".$id;
            $datos= $this->query($query);
            return $datos;
        }
            function edo_actual_cheque($id)
        {
            $query= "SELECT c.idstatus_cheque, s.nombre,c.idcheque from finanzas.cheque_financiamiento as c inner join finanzas.status_cheque as s on s.idstatus_cheque=c.idstatus_cheque where idcheque=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function update_edo_cheque($id,$edo)
        {
            $query="UPDATE finanzas.cheque_financiamiento set idstatus_cheque=".$edo." where idcheque=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function update_edo_descuento($id,$edo)
        {
            $query="UPDATE finanzas.descuento_promotor set idstatus_descuento=".$edo." where id_descuento=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function all_descuentos($id)
        {
            $query= "SELECT id_descuento,idfinanciamiento,sum(d.importe_desc) as descuento from finanzas.descuento_promotor as d where d.id_empleado=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function all_descuentos2($plaza,$soc)
        {
            $query= "SELECT d.id_descuento, f.idfinanciamiento,id_empleado,d.id_descuento from finanzas.Financiamiento as f inner join finanzas.descuento_promotor as d on d.idfinanciamiento=f.idfinanciamiento where idplaza=".$plaza." and idsociedad=".$soc;
            $datos= $this->query($query);
            return $datos;
        }

          function personal_desc()
        {
            $query ="SELECT distinct d.id_empleado,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from finanzas.descuento_promotor as d inner join apatodo.Empleados as a on a.Id_empleado=d.id_empleado";
            $datos=$this->query($query);
            return $datos;
        }
        function suma_pagos($id)
        {
            $query="SELECT importe from finanzas.regreso_descuentos where id_descuento=".$id;
            $datos=$this->query($query);
            return $datos;
        }
        function finan_desc($plaza,$soc)
        {
           $query="SELECT d.id_descuento from finanzas.Financiamiento as f inner join finanzas.descuento_promotor as d on d.idfinanciamiento=f.idfinanciamiento  where idplaza=".$plaza." and idsociedad=".$soc; 
           $datos=$this->query($query);
           return $datos;
        }
        function tipos_mov_deposito()
        {
           $query="SELECT * from finanzas.tipo_pago"; 
           $datos=$this->query($query);
           return $datos;
        }
           function status_nota_credito()
        {
           $query="SELECT * from finanzas.status_nota"; 
           $datos=$this->query($query);
           return $datos;
        }
         function status_abono()
        {
           $query="SELECT * from finanzas.status_abono"; 
           $datos=$this->query($query);
           return $datos;
        }
        function guarda_abono($fin,$Idfactura,$soc_pago,$tipoPago,$fecha_pago,$importe_pago,$edo_abono,$obs_pago,$dateTime)
        {
            $query= "INSERT INTO finanzas.abonos_financiamiento(idfinanciamiento,idfactura_finan, idsociedad,idtipo_pago,fecha, idstatus_abono,importe, observaciones, created_at) values(".$fin.",".$Idfactura.",".$soc_pago.",".$tipoPago.",'".$fecha_pago."',".$edo_abono.",".$importe_pago.",'".$obs_pago."','".$dateTime."')";
            $datos=$this->query($query);
            return $datos;
        }
        function guarda_notaCredito($fin,$Idfactura,$folio_nota,$fecha_nota,$importe_nota,$pagadora,$edo_nota,$obs_nota,$dateTime)
        {
            $query = "INSERT INTO finanzas.notas_credito(idfinanciamiento, idfactura_finan, folio, fecha, importe,pagadora,estado, observaciones,created_at) values(".$fin.",".$Idfactura.",".$folio_nota.",'".$fecha_nota."',".$importe_nota.",".$pagadora.",".$edo_nota.",'".$obs_nota."','".$dateTime."')";
            $datos=$this->query($query);
            return $datos;
        }
        function get_datos_financiamiento($idfin)
        {
            $query ="SELECT * from finanzas.Financiamiento where idfinanciamiento=".$idfin;
            $datos=$this->query($query);
            return $datos;
        }
        function cheque_factura($idfact)
        {
            $query = "SELECT c.idcheque, c.idfinanciamiento, c.idfactura_finan, c.folio_cheque, 
            c.idsociedad, c.idstatus_cheque, c.fecha, c.importe, c.observaciones, c.usuario_captura,
            c.created_at, c.updated_at,s.razonsocial, e.nombre
            from finanzas.cheque_financiamiento as c
            inner join finanzas.status_abono as e on
            c.idstatus_cheque=e.idstatus_abono left join 
            sistema.empresas as s on s.idempresa=c.idsociedad 
            where idfactura_finan=".$idfact;
            $datos=$this->query($query); 
            return $datos; 
        } 
        function notas_factura($idfact)
        {
            $query = "SELECT n.idnota_credito,n.folio, n.fecha,n.importe,n.pagadora,s.idstatus_nota, s.nombre, n.observaciones, e.idempresa, e.razonsocial
            from finanzas.notas_credito as n inner join 
            finanzas.status_nota as s on s.idstatus_nota=n.estado left join 
            sistema.empresas as e on e.idempresa=n.pagadora where idfactura_finan=".$idfact;
            $datos=$this->query($query);
            return $datos;
        }
        function update_factura($idFactura,$folio_fact,$fecha_fact,$folio_kid,$socFactura,$importe_dep,$importe_fact,$importe_desc,$nombre_factura,$obs_fact,$edo_fact)
        {
            $query = "UPDATE finanzas.facturas_finan set folio_factura=".$folio_fact.",fecha_factura='".$fecha_fact."',folio_kid=".$folio_kid.",idsociedad='".$socFactura."',importe_depositado=".$importe_dep.",importe_facturado=".$importe_fact.",importe_descuentos=".$importe_desc.",nombre_factura='".$nombre_factura."',observaciones='".$obs_fact."',status_fact=".$edo_fact." where idfactura_finan=".$idFactura;
            $datos=$this->query($query);
            return $datos;
        }
        function update_financiamiento($idFin,$idcte,$autorizador,$fecha, $del, $al,$imp_dep,$imp_desc,$imp_ab,$imp_fin, $estado, $comentarios)
        {
            if($comentarios!="")
            {
                $query = "UPDATE finanzas.Financiamiento set idcte=".$idcte.",id_autorizador=".$autorizador.",fecha='".$fecha."',periodo_inicio='".$del."', periodo_fin='".$al."',importe_depo=".$imp_dep.",importe_financiado=".$imp_fin.",importe_desc=".$imp_desc.",depositos_cliente=".$imp_ab.",idstatus_financiado=".$estado.",observaciones="."'".$comentarios."'"." where idfinanciamiento=".$idFin;
            }
            else
            {
                $query = "UPDATE finanzas.Financiamiento set idcte=".$idcte.",id_autorizador=".$autorizador.",fecha='".$fecha."',periodo_inicio='".$del."', periodo_fin='".$al."',importe_depo=".$imp_dep.",importe_financiado=".$imp_fin.",importe_desc=".$imp_desc.",depositos_cliente=".$imp_ab.",idstatus_financiado=".$estado." where idfinanciamiento=".$idFin;
            }
            $datos=$this->query($query);
            return $datos;
        }
         function update_cheque($idcheque,$folioCheque,$soc_pago,$edo_cheque,$fecha_pago,$importe_pago,$obs_pago)
        {
            $query= "UPDATE finanzas.cheque_financiamiento set folio_cheque=".$folioCheque.", idsociedad=".$soc_pago.", idstatus_cheque=".$edo_cheque.", fecha='".$fecha_pago."',importe=".$importe_pago.",observaciones='".$obs_pago."' where idcheque=".$idcheque;
            $datos=$this->query($query);
            return $datos;
        }
           function update_abono($idAbono,$soc_pago,$tipoPago,$fecha_pago,$importe_pago,$edo_abono)
        {
            $query= "UPDATE finanzas.abonos_financiamiento  set idsociedad=".$soc_pago.",idtipo_pago=".$tipoPago.",idstatus_abono=".$edo_abono.",fecha='".$fecha_pago."',importe=".$importe_pago." where idabono=".$idAbono;
            $datos=$this->query($query);
            return $datos;
        }
           function update_notaCredito($idNota,$Idfactura,$folio_nota,$fecha_nota,$importe_nota,$pagadora,$edo_nota,$obs_nota)
        {
            $query= "UPDATE finanzas.notas_credito set  folio=".$folio_nota.",fecha='".$fecha_nota."',importe=".$importe_nota.",pagadora=".$pagadora.",estado=".$edo_nota.",observaciones='".$obs_nota."' where idnota_credito=".$idNota;
            $datos=$this->query($query);
            return $datos;
        }
        function update_descuento($idDescuento,$Idfactura,$promotor,$imp_desc,$edo_desc,$fecha_desc,$obs_desc)
        {
            $query = "UPDATE finanzas.descuento_promotor set id_empleado=".$promotor.", importe_desc=".$imp_desc.",fecha='".$fecha_desc."',observaciones='".$obs_desc."',idstatus_descuento=".$edo_desc." where id_descuento=".$idDescuento;
            $datos=$this->query($query);
            return $datos;
        }
        //metodos para eliminar
        function elimina_descuento($id)
        {
            $query= "DELETE from finanzas.descuento_promotor where id_descuento=".$id;
            $datos=$this->query($query);
            return $datos;
        }
        function elimina_cheque($id)
        {
            $query= "DELETE from finanzas.cheque_financiamiento where idcheque=".$id;
            $datos=$this->query($query);
            return $datos;
        }
        function elimina_abono($id)
        {
            $query= "DELETE from finanzas.abonos_financiamiento where idabono=".$id;
            $datos=$this->query($query);
            return $datos;
        }
         function elimina_nota($id)
        {
            $query= "DELETE from finanzas.notas_credito where idnota_credito=".$id;
            $datos=$this->query($query);
            return $datos;
        }
        function update_edoFin($id,$nvo_edo)
        {
            $query= "UPDATE finanzas.Financiamiento set idstatus_financiado=".$nvo_edo." where idfinanciamiento=".$id;
            $datos=$this->query($query);
            return $datos;
        }
        function descuentos_detalle($id)
        {
            $query= "SELECT distinct d.id_descuento, d.fecha, d.idfinanciamiento,d.idfactura_finan,f.folio_factura,d.observaciones,d.importe_desc,d.importe_pagado, 
            c.razon,s.nombre
             from finanzas.descuento_promotor as d inner join finanzas.facturas_finan as f on f.idfactura_finan=d.idfactura_finan inner join finanzas.Financiamiento as fin 
            on fin.idfinanciamiento=d.idfinanciamiento inner join empresacte as e on e.idcte=fin.idcte inner join clientes as c on c.id=e.idcte left join finanzas.status_descuento
            as s on s.idstatus_descuento=d.idstatus_descuento where d.id_empleado=".$id;
            $datos = $this->query($query);
            return $datos;
        }
         function elimina_cheques_fact($id)
        {
            $query= "DELETE from finanzas.cheque_financiamiento where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
         function elimina_desc_fact($id)
        {
            $query= "DELETE from finanzas.descuento_promotor where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
        function elimina_notas_fact($id)
        {
            $query= "DELETE from finanzas.descuento_promotor where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
         function elimina_abono_fact($id)
        {
            $query= "DELETE from finanzas.abonos_financiamiento where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
          function elimina_factura($id)
        {
            $query= "DELETE from finanzas.facturas_finan where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
        function nombre_empleado($id)
        {
            $query= "SELECT CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados where Id_empleado=".$id." limit 1";
            $datos = $this->query($query);
            return $datos;
        }
        function consulta_facturas($plaza,$soc)
        {
            $query = "SELECT f.idfactura_finan,f.fecha_factura, f.idfinanciamiento,f.folio_factura, f.importe_depositado, f.importe_facturado, f.importe_descuentos,
            f.observaciones,f.updated_at,c.razon as cliente,s.nombre as estado from finanzas.facturas_finan as f inner join finanzas.Financiamiento as fin on fin.idfinanciamiento=f.idfinanciamiento inner join empresacte as e on e.idcte=fin.idcte inner join 
            clientes as c on c.id=e.idcte inner join finanzas.status_factura as s on s.idstatus_factura=f.status_fact where fin.idplaza=".$plaza." and fin.idsociedad=".$soc." group by f.idfactura_finan";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_factura($id)
        {
            $query = "SELECT f.idfactura_finan,f.fecha_factura, f.idfinanciamiento,f.folio_factura, f.importe_depositado, f.importe_facturado, f.importe_descuentos,
            f.observaciones,f.updated_at,c.razon as cliente,f.status_fact,s.nombre as estado,s.idstatus_factura from finanzas.facturas_finan as f inner join finanzas.Financiamiento as fin on fin.idfinanciamiento=f.idfinanciamiento inner join empresacte as e on e.idcte=fin.idcte inner join 
            clientes as c on c.id=e.idcte inner join finanzas.status_factura as s on s.idstatus_factura=f.status_fact where f.idfactura_finan=".$id." limit 1";
            $datos = $this->query($query);
            return $datos;
        }
        function update_datos_factura($id,$folio,$fecha,$imp,$edo,$obs)
        {
            $query = "UPDATE finanzas.facturas_finan set folio_factura=".$folio.",fecha_factura='".$fecha."',importe_facturado=".$imp.",status_fact=".$edo.
            ",observaciones='".$obs."' where idfactura_finan=".$id;
            $datos = $this->query($query);
            return $datos;
        }
           function guarda_depositoFinan($fin,$idDepositoFin,$importe,$fecha,$observaciones,$dateTime)
        {
            $query = "INSERT INTO finanzas.depositos_cliente(idDeposito, idfinanciamiento, importe, fecha_deposito, observaciones, created_at) values(".$idDepositoFin.",".$fin.",".$importe.",'".$fecha."','".$observaciones."','".$dateTime."');";
            $datos = $this->query($query);
            return $datos;
        }
          function update_depositoFinan($fin,$idDepositoFin,$importe,$fecha,$observaciones,$dateTime)
        {
            $query = "UPDATE finanzas.depositos_cliente set importe=".$importe.",fecha_deposito='".$fecha."',observaciones='".$observaciones."' where idDeposito=".$idDepositoFin;
            $datos = $this->query($query);
            return $datos;
        }
           function depositos_info($idFin)
        {
            $query = "SELECT * from finanzas.depositos_cliente where idfinanciamiento=".$idFin;
            $datos = $this->query($query);
            return $datos;
        }
           function borrar_abono($id)
        {
            $query="DELETE from finanzas.depositos_cliente where idDeposito=".$id;
            $datos= $this->query($query);
            return $datos;
        }
    }
?>