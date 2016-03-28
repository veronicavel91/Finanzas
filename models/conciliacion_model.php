<?php
    require("models/connection_sqli_manual.php"); // funciones mySQLi

    class conciliacion_model extends Connection
    {
    	//obtiene todas las plazas
        function all_plazas()
        {
        	$query='SELECT * from sistema.plazas';
            $datos = $this->query($query);
            return $datos;
        }
        //obtiene todos los bancos registrados
        function all_bancos(){
            $query='SELECT * from finanzas.bancos';
            $bancos = $this->query($query);
            return $bancos;
        }
         function codigo_sociedad(){
            $query='SELECT * from finanzas.sociedad_contpaq';
            $datos = $this->query($query);
            return $datos;
        }
        function guarda_temporal($ubicacion)
        { 
             $query="load data local infile '$ubicacion' into table finanzas.temporal_conciliacion fields terminated by ',' enclosed by '\"' lines terminated by '\n' IGNORE 1 LINES (fecha, tipo,abonos,cargos,folio,referencia,codigo,concepto);";
             $datos = $this->query($query);
            return $datos;
        }
        function vacia_tabla()
        {
            $query= "TRUNCATE finanzas.temporal_conciliacion";
            $datos = $this->query($query);
            return $datos;
        }
         function busca_temporal(){
            $query='SELECT * from finanzas.temporal_conciliacion';
            $datos = $this->query($query);
            return $datos;
        }
        function guarda_concepto($plaza,$soc,$cuenta,$folio,$fecha_movto,$tipo_movto,$cargo,$abono,$concepto,$referencia)
        {
            $query= "INSERT INTO finanzas.conciliacion(idplaza,idsociedad,idcuenta,folio,fecha_movto,tipo_movto,cargo,abono,concepto,referencia) values(".$plaza.",".$soc.",".$cuenta.",".$folio.",'".$fecha_movto."',".$tipo_movto.",".$cargo.",".$abono.",'".$concepto."','".$referencia."')";
            $datos = $this->query($query);
            return $datos;
        }
        function mov_conciliacion($cuenta,$fecha1,$fecha2)
        {
            $query="SELECT c.idconciliacion,cb.num_cuenta,c.folio,c.fecha_movto,c.cargo,c.abono,c.concepto,c.referencia,c.observaciones,c.estado,c.tipo_movto from finanzas.conciliacion as c inner join finanzas.cuenta_bancaria as cb on cb.idcuenta=c.idcuenta where c.idcuenta=".$cuenta." and fecha_movto between "."'".$fecha1."'"." and "."'".$fecha2."'";
            $datos = $this->query($query);
            return $datos;
        }
        function calcula_cargos($cuenta,$inicio,$fin)
        {
            $query="SELECT SUM(cargo) as total_cargo FROM finanzas.conciliacion where idcuenta=".$cuenta."and fecha_movto between "."'".$inicio."'"." and "."'".$fin."'";
            $datos = $this->query($query);
            return $datos;
        }
         function calcula_abonos($cuenta,$inicio,$fin)
        {
            $query="SELECT SUM(abono) as total_abono FROM finanzas.conciliacion where idcuenta=".$cuenta."and fecha_movto between "."'".$inicio."'"." and "."'".$fin."'";
            $datos = $this->query($query);
            return $datos;
        }
        function borrar_movimientos($id)
        {
            $query="DELETE FROM finanzas.conciliacion where idconciliacion=".$id;
            $datos = $this->query($query);
            return $datos;
        }
    }
?>