<?php
    require("models/connection_sqli_manual.php"); // funciones mySQLi

    class reportes_model extends Connection
    {
    	 function all_cuentas($plaza,$soc)
        {
            $query="SELECT cb.idcuenta,cb.moneda,cb.no_cliente,cb.fecha_apertura,p.Plaza,e.razonsocial,b.nombre as banco,cb.tipo_cuenta,cb.contrato_nomina,cb.tipo_operacion,
			CONCAT( emp.Nombre,' ', emp.Apellidop,' ', emp.Apellidom ) as responsable,cb.num_cuenta,cb.clabe,cb.no_contrato,cb.sucursal,cb.nombre_sucursal,
			CONCAT(d.calle,' #',num_ext,' int.',num_int) as domicilio, a.nombre as area,st.nombre as status_cuenta,CONCAT( ae.Nombre,' ', ae.Apellidop,' ', ae.Apellidom ) as usuario_cta,
			hc.observaciones
			from finanzas.bancos as b inner join finanzas.cuenta_bancaria as cb on cb.id_banco=b.idbancos inner join sistema.plaza p on p.id=cb.idplaza
			inner join sistema.empresas e on e.idempresa=cb.idsociedad inner join finanzas.historial_responsable as h on h.idhistorial=cb.idhistorial_responsable 
			inner join apatodo.Empleados as emp on emp.Id_empleado=h.idresponsable inner join finanzas.historial_domicilio as hd on hd.idhistorial_domicilio=cb.idhistorial_domicilio 
			inner join finanzas.domicilio_cuenta as d on hd.id_domicilio=d.id_domicilio inner join finanzas.area_operacion as a on a.idarea_operacion=cb.idarea_operacion inner join
			finanzas.historial_cuenta as hc on hc.idhistorial_cuenta=cb.idhistorial_cuenta inner join finanzas.status_cuenta as st on st.idstatus_cuenta=hc.idstatus_cuenta inner join
			apatodo.Empleados as ae on ae.Id_empleado=cb.usuario_cuenta
			where cb.idplaza=".$plaza." and cb.idsociedad=".$soc." group by cb.idcuenta";
            $datos= $this->query($query);
            return $datos;
        }
        function busca_firmante($id)
        {
            $query = "SELECT f.idfirmante,f.status, CONCAT( a.Nombre,' ', a.Apellidop,' ', a.Apellidom ) as nombre_emp
            , p.Plaza, e.razonsocial from finanzas.firmante as f left join apatodo.Empleados as a on a.Id_empleado
            =f.id_empleado left join sistema.plaza p on p.id=f.idplaza left join sistema.empresas e on e.idempresa
            =f.idsociedad where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
         function busca_cuenta($id)
        {
            $query="SELECT e.idempresa,cb.idhistorial_domicilio,cb.idcuenta,cb.moneda,cb.no_cliente,cb.fecha_apertura,p.Plaza,e.razonsocial,b.nombre as banco,cb.tipo_cuenta,cb.contrato_nomina,cb.tipo_operacion,
			CONCAT( emp.Nombre,' ', emp.Apellidop,' ', emp.Apellidom ) as responsable,cb.num_cuenta,cb.clabe,cb.no_contrato,suc.num_suc as sucursal,suc.nombre as nombre_sucursal,
			CONCAT(d.calle,' #',num_ext,' Int.',num_int,' Col.',cop.colonia,' CP.',cop.codigopostal) as domicilio, a.nombre as area,st.nombre as status_cuenta,CONCAT( ae.Nombre,' ', ae.Apellidop,' ', ae.Apellidom ) as usuario_cta,
			hc.observaciones
			from finanzas.bancos as b left join finanzas.cuenta_bancaria as cb on cb.id_banco=b.idbancos left join sistema.plaza p on p.id=cb.idplaza
			left join sistema.empresas e on e.idempresa=cb.idsociedad left join finanzas.historial_responsable as h on h.idhistorial=cb.idhistorial_responsable 
			left join apatodo.Empleados as emp on emp.Id_empleado=h.idresponsable left join finanzas.historial_domicilio as hd on hd.idhistorial_domicilio=cb.idhistorial_domicilio 
			left join finanzas.domicilio_cuenta as d on hd.id_domicilio=d.id_domicilio left join finanzas.area_operacion as a on a.idarea_operacion=cb.idarea_operacion left join
			finanzas.historial_cuenta as hc on hc.idhistorial_cuenta=cb.idhistorial_cuenta left join finanzas.status_cuenta as st on st.idstatus_cuenta=hc.idstatus_cuenta left join
			apatodo.Empleados as ae on ae.Id_empleado=cb.usuario_cuenta left join sistema.codigospostales as cop on cop.id=d.idcodigo_postal left join finanzas.sucursal_banco as suc on suc.idsucursal=cb.idsucursal
			where cb.idcuenta=".$id." limit 1";
            $datos= $this->query($query);
            return $datos;
        }
         function all_plazas()
        {
            $query='SELECT * from sistema.plazas order by plaza';
            $datos = $this->query($query);
            return $datos;
        }
         function all_bancos()
        {
            $query='SELECT * from finanzas.bancos order by nombre';
            $bancos = $this->query($query);
            return $bancos;
        }
        function detalles($idfin)
        {
            $query="SELECT f.idfinanciamiento, f.created_at,f.fecha, f.updated_at,pl.plaza,s.razonsocial, e.razon cte, CONCAT( apa.Nombre,' ', apa.Apellidop,' ', apa.Apellidom ) as nombre_aut, f.periodo_inicio,
			f.periodo_fin, CONCAT( apa.Nombre,' ', apa.Apellidop,' ', apa.Apellidom ) as nombre_aut,f.idstatus_financiado, ef.nombre as st_fin, f.observaciones, f.importe_depo, f.importe_financiado, f.importe_desc
			from finanzas.Financiamiento as f inner join finanzas.status_financiamiento as ef on ef.idstatus_financiado=f.idstatus_financiado
			inner join apatodo.Empleados as apa on f.id_autorizador=apa.Id_empleado inner join clientes as e 
			on e.id=f.idcte left join sistema.plazas as pl on pl.idplaza=f.idplaza left join sistema.empresas as s on s.idempresa=f.idsociedad where f.idfinanciamiento=".$idfin;
			$datos = $this->query($query);
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
        //busca los grupos ford y vamsa para generar el reporte por grupo
        function soc_grupo($gpo)
        {
        	$query = "SELECT * from sistema.clientes where idgrupo=".$gpo." and id in(select idcte from finanzas.abonos_financiamiento as a left join finanzas.Financiamiento as f 
			on f.idfinanciamiento=a.idfinanciamiento left join 
			finanzas.facturas_finan as fa on fa.idfinanciamiento=f.idfinanciamiento left join sistema.clientes as c on c.id=f.idcte left join sistema.grupos as g
			on g.id=c.idgrupo left join finanzas.notas_credito as n on n.idfactura_finan=fa.idfactura_finan
			left join sistema.empresas as en on en.idempresa=n.pagadora left join finanzas.status_nota as sn
			on sn.idstatus_nota=n.estado left join finanzas.status_factura as sf on sf.idstatus_factura=fa.status_fact)";
        	$datos=$this->query($query); 
            return $datos; 
        }
        function financ_cliente($cte,$fecha1,$fecha2,$soc)
        {
        	$query = "SELECT distinct fa.idfactura_finan,f.idfinanciamiento,fa.importe_depositado,fa.idsociedad,fa.nombre_factura,fa.observaciones as obs_fact,fa.folio_kid,f.fecha,c.razon,f.periodo_inicio, f.periodo_fin,fa.folio_factura, fa.importe_facturado, f.observaciones,n.folio as folio_nota,n.fecha 
			as fecha_nota, n.importe as importe_nota,en.razonsocial as pagadora,sn.nombre as status_nota from finanzas.facturas_finan as fa left join finanzas.Financiamiento as f on
			f.idfinanciamiento=fa.idfinanciamiento
			left join finanzas.notas_credito as n on n.idfactura_finan=fa.idfactura_finan inner join sistema.clientes as c on c.id=f.idcte left join
			sistema.empresas as en on en.idempresa=n.pagadora left join finanzas.status_nota as sn on sn.idstatus_nota=n.estado 
			left join finanzas.status_factura as sf on sf.idstatus_factura=fa.status_fact
			where f.idcte=".$cte." and f.periodo_inicio between '".$fecha1."' and '".$fecha2."' and f.idsociedad=".$soc." group by fa.idfactura_finan";
        	$datos=$this->query($query); 
            return $datos; 
        }
        function abonos_factura($fac)
        {
        	$query = "SELECT * from finanzas.abonos_financiamiento where idfactura_finan=".$fac;
        	$datos= $this->query($query);
            return $datos;
        }
        function abonos_soc($fact,$soc)
        {
        	$query = "SELECT * from finanzas.abonos_financiamiento where idsociedad=".$soc." and idfactura_finan=".$fact;
        	$datos= $this->query($query);
            return $datos;
        }
        function total_dirham($gpo,$soc)
        {
        	$query = "SELECT sum(a.importe) as total from finanzas.abonos_financiamiento as a inner join finanzas.facturas_finan as fa on fa.idfactura_finan=a.idfactura_finan
			inner join finanzas.Financiamiento as f on f.idfinanciamiento=fa.idfinanciamiento where a.idsociedad=".$soc." and f.idcte=".$gpo;
        }
            function depositos_info($idFin)
        {
            $query = "SELECT * from finanzas.depositos_cliente where idfinanciamiento=".$idFin;
            $datos = $this->query($query);
            return $datos;
        }
           function todas_cuentas()
        {
            $query="SELECT distinct cb.idcuenta,cb.moneda,cb.no_cliente,cb.fecha_apertura,p.Plaza,p.idplaza,
e.razonsocial,b.nombre as banco,cb.tipo_cuenta,cb.contrato_nomina,cb.tipo_operacion, CONCAT( emp.Nombre,' ', emp.Apellidop,' ', emp.Apellidom ) 
as responsable,cb.num_cuenta,cb.clabe,cb.no_contrato,cb.sucursal,cb.nombre_sucursal, CONCAT(d.calle,' #',num_ext,' int.',num_int) as domicilio,
a.nombre as area,st.nombre as status_cuenta,CONCAT( ae.Nombre,' ', ae.Apellidop,' ', ae.Apellidom ) as usuario_cta, hc.observaciones 
from finanzas.bancos as b left join finanzas.cuenta_bancaria as cb on cb.id_banco=b.idbancos left join sistema.plazas p on p.idplaza=cb.idplaza 
left join sistema.empresas e on e.idempresa=cb.idsociedad left join finanzas.historial_responsable as h on h.idhistorial=cb.idhistorial_responsable 
left join apatodo.Empleados as emp on emp.Id_empleado=h.idresponsable left join finanzas.historial_domicilio as hd on hd.idhistorial_domicilio=cb.idhistorial_domicilio 
left join finanzas.domicilio_cuenta as d on hd.id_domicilio=d.id_domicilio left join finanzas.area_operacion as a on a.idarea_operacion=cb.idarea_operacion 
left join finanzas.historial_cuenta as hc on hc.idhistorial_cuenta=cb.idhistorial_cuenta left join finanzas.status_cuenta as st on st.idstatus_cuenta=hc.idstatus_cuenta 
left join apatodo.Empleados as ae on ae.Id_empleado=cb.usuario_cuenta group by cb.idcuenta order by razonsocial;";           
			$datos= $this->query($query);
            return $datos;
        }
        function preguntas_cuenta($id)
        {
        	$query = "SELECT * from finanzas.pregunta_secreta where status=1 and idcuenta=".$id;
        	$datos= $this->query($query);
            return $datos;
        }
          function token_cuenta($id)
        {
        	$query = "SELECT * from finanzas.token_cuenta where idstatus_token=1 and idcuenta=".$id;
        	$datos= $this->query($query);
            return $datos;
        }
         function all_sociedad()
	    {
	        $query="SELECT idempresa,razonsocial from empresas order by razonsocial";
	        $datos = $this->query($query);
	        return $datos;
	    }
	      function busca_cuenta_id($id)
        {
            $query="SELECT c.num_cuenta, c.clabe, b.nombre as banco, sucursal,h.updated_at, h.idstatus_cuenta,s.nombre as estado, h.folio,h.fecha,h.observaciones 
            from finanzas.bancos as b inner join finanzas.cuenta_bancaria as c on b.idbancos=c.id_banco inner join finanzas.historial_cuenta as h 
            on h.idhistorial_cuenta=c.idhistorial_cuenta inner join finanzas.status_cuenta as s on s.idstatus_cuenta=h.idstatus_cuenta where c.idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function busca_correos($pza,$soc)
        {
        	$query = "SELECT *,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as empleado from finanzas.correos_empleado as c inner join apatodo.Empleados as e on e.Id_empleado=c.id_empleado where idplaza=".$pza." and idsociedad=".$soc;
        	$datos= $this->query($query);
            return $datos;
        }
          function datos_domicilio($id){
        $query="SELECT *,CONCAT(calle,'#',num_ext,',int.',num_int,',MPO.',delegacionmunicipio,',',ciudad,',',c.estado
        ) as domicilio,d.estado as edo_dom from finanzas.domicilio_cuenta as d inner join sistema.codigospostales as c on d.idcodigo_postal
        =c.Id left join finanzas.historial_domicilio as h on h.id_domicilio=d.id_domicilio where h.idhistorial_domicilio=".$id;
            $bancos = $this->query($query);
            return $bancos;
        }


    }
?>