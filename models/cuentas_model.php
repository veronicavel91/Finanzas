<?php
    require("models/connection_sqli_manual.php"); // funciones mySQLi

    class cuentas_model extends Connection
    {
        //obtiene todos los bancos registrados
        function all_bancos(){
            $query='SELECT * from finanzas.bancos order by nombre';
            $bancos = $this->query($query);
            return $bancos;
        }
        //obtiene todas las plazas
        function all_plazas()
        {
            $query='SELECT * from sistema.plazas order by plaza';
            $datos = $this->query($query);
            return $datos;
        }
         //busca todas las sociedades
         function all_sociedad()
        {
            $query="SELECT idempresa,razonsocial from empresas order by razonsocial";
            $datos = $this->query($query);
            return $datos;
        }

        //busca las sociedades de la plaza
         function busca_sociedad($idplaza)
        {
            $query="SELECT idempresa,razonsocial from empresas where idplaza=".$idplaza." order by razonsocial";
            $datos = $this->query($query);
            return $datos;
        }

        function consulta_cuentas($plaza,$soc)
        {
            $query="SELECT cb.idcuenta as idcta,cb.num_cuenta,cb.clabe,cb.tipo_operacion,cb.tipo_cuenta,fb.cve_transfer as banco,suc.num_suc as sucursal,cb.fecha_apertura,st.nombre as status_cta,CONCAT( er.Nombre,' ', er.Apellidop,' ', er.Apellidom ) 
        as nombre_resp, ar.nombre as area from finanzas.bancos as fb inner join finanzas.cuenta_bancaria as cb on fb.idbancos=cb.id_banco
        left join finanzas.historial_cuenta as h on h.idhistorial_cuenta=cb.idhistorial_cuenta left join finanzas.status_cuenta as st 
        on st.idstatus_cuenta=h.idstatus_cuenta left join finanzas.historial_responsable as hr on hr.idhistorial=cb.idhistorial_responsable 
        left join apatodo.Empleados as er on er.Id_empleado=hr.idresponsable left join finanzas.area_operacion as ar on ar.idarea_operacion=cb.idarea_operacion 
        left join finanzas.sucursal_banco as suc on suc.idsucursal=cb.idsucursal where cb.idplaza=".$plaza." and cb.idsociedad=".$soc;
            $datos= $this->query($query);
            return $datos;
        }
        function todas_cuentas()
        {
            $query="SELECT cb.idcuenta as idcta,cb.num_cuenta,cb.clabe,cb.tipo_operacion,cb.tipo_cuenta,fb.cve_transfer as banco,suc.num_suc as sucursal,cb.fecha_apertura,st.nombre as status_cta,CONCAT( er.Nombre,' ', er.Apellidop,' ', er.Apellidom ) 
as nombre_resp, ar.nombre as area from finanzas.bancos as fb inner join finanzas.cuenta_bancaria as cb on fb.idbancos=cb.id_banco
left join finanzas.historial_cuenta as h on h.idhistorial_cuenta=cb.idhistorial_cuenta left join finanzas.status_cuenta as st 
on st.idstatus_cuenta=h.idstatus_cuenta left join finanzas.historial_responsable as hr on hr.idhistorial=cb.idhistorial_responsable 
left join apatodo.Empleados as er on er.Id_empleado=hr.idresponsable left join finanzas.area_operacion as ar on ar.idarea_operacion=cb.idarea_operacion 
left join finanzas.sucursal_banco as suc on suc.idsucursal=cb.idsucursal";
            $datos= $this->query($query);
            return $datos;
        }
        //busca el personal o empleados desde people
        function all_personal()
        {
            $query ="SELECT Id_empleado,  CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados where estado='ALTA' and plazamadre<>5 and plazamadre=1 or plazamadre=6 order by nombre_emp";
            $datos=$this->query($query);
            return $datos;
        }
         //guarda nuevo banco
        function guarda_banco($banco,$no_inst, $cve)
        {
            $query = "INSERT INTO finanzas.bancos (nombre,no_institucion,cve_transfer,estado) values('".$banco."',".$no_inst.",'".$cve."',1)";
            $datos = $this->query($query);
        }
        function borrar_banco($id)
        {
            $query = "DELETE FROM finanzas.bancos WHERE idbancos=".$id;
            $datos = $this->query($query);
        }
        function busca_banco($id)
        {
            $query = "SELECT * from finanzas.bancos where idbancos=".$id;
            $datos = $this->query($query)        ;
            return $datos;
        }
        function datos_cuenta($id)
        {
            $query = "SELECT cb.idcuenta, p.Plaza, e.razonsocial, b.nombre, cb.num_cuenta, cb.clabe, suc.num_suc as sucursal, cb.fecha_apertura, 
CONCAT(a.Nombre,' ', a.Apellidop,' ', a.Apellidom ) as nombre_us, cb.no_contrato, cb.saldo_inicial  
from finanzas.cuenta_bancaria cb  inner join finanzas.bancos b on b.idbancos=cb.id_banco 
inner join apatodo.Empleados a on a.Id_empleado=cb.usuario_cuenta inner join sistema.plaza p on p.id=cb.idplaza 
inner join sistema.empresas e on e.idempresa=cb.idsociedad left join finanzas.sucursal_banco as suc on suc.idsucursal=cb.idsucursal where cb.idcuenta=".$id;
            $datos = $this->query($query);
            return $datos;
        }
        function update_banco($id,$nombre,$inst,$cve)
        {
            $query="UPDATE finanzas.bancos SET nombre="."'".$nombre."'".", no_institucion=$inst, cve_transfer="."'".$cve."'"." WHERE idbancos=".$id;
            $datos = $this->query($query);
        }
          function guardar_cta($plaza,$soc,$area,$cta,$clabe,$banco, $id_suc,$f_alta,$personal_tipo, $usuario,$plaza_user,$soc_user,$no_contrato,$no_cliente,$contrato_nomina,$tipo_op,$tipo_cuenta,$saldo,$moneda,$dateTime)
        {
            $query = "INSERT INTO finanzas.cuenta_bancaria 
            (idplaza, idsociedad, idarea_operacion, num_cuenta, clabe, id_banco, idsucursal,fecha_apertura,tipo_usuario, 
            usuario_cuenta, usuario_plaza, usuario_soc, no_contrato, no_cliente, 
            contrato_nomina, tipo_operacion, tipo_cuenta, saldo_inicial, moneda, usuario_captura, created_at) 
            values(".$plaza.",".$soc.",".$area.",'".$cta."','".$clabe."',".$banco.",".$id_suc.",'".$f_alta."',".$personal_tipo.",".$usuario.",".$plaza_user.",".$soc_user.
                ",".$no_contrato.",".$no_cliente.","."'".$contrato_nomina."'".",'".$tipo_op."','".$tipo_cuenta."',".$saldo.",'".$moneda."',1,'".$dateTime."');";
            $datos = $this->insert_id($query);
            return $datos;
        }
        function guarda_status_cuenta($cta,$status,$folio,$fecha_bloq,$coments,$date)
        {
             $query= "INSERT INTO finanzas.historial_cuenta (idcuenta,idstatus_cuenta, folio, fecha, observaciones,created_at) values (".$cta.",".$status.",'".$folio."','".$fecha_bloq."','".$coments."','".$date."');";
             $datos = $this->insert_id($query);
             return $datos;
        }
        //guarda nueva cuenta
        function guarda_cuenta($plaza, $soc, $cta, $clabe, $banco, $sucursal, $domicilio, $f_alta, $usuario, $no_contrato, $saldo, $resp_cta,$tipo_resp,$fecha, $status,$folio,$coments)
        {
            $query = "INSERT INTO finanzas.cuenta_bancaria (idplaza,idsociedad,num_cuenta, clabe, id_banco,sucursal,id_domicilio, fecha_apertura,usuario_cuenta, no_contrato, saldo_inicial, usuario_captura) values(".$plaza.",".$soc.",'".$cta."','".$clabe."',".$banco.",".$sucursal.",".$domicilio.",'".$f_alta."',".$usuario.",".$no_contrato.",". $saldo.",1);";
            $query .= "INSERT INTO finanzas.historial_cuenta (idcuenta,idstatus_cuenta, folio, fecha, observaciones) values (".$cta.",".$status.",'".$folio."','".$fecha."','".$coments."');";
            $query .="INSERT INTO finanzas.historial_responsable (idcuenta, idresponsable, tipo_resp, fecha, status_responsable) values (".$cta.",".$resp_cta.",".$tipo_resp.",'".$fecha."',1);";
            $datos = $this->dataTransact($query);
           return $datos;
        }
        function guarda_responsable($cta,$resp_cta,$tipo_resp,$fecha)
        {
            $query = "INSERT INTO finanzas.historial_responsable (idcuenta, idresponsable, tipo_resp, fecha, status_responsable) values (".$cta.",".$resp_cta.",".$tipo_resp.",'".$fecha."',1)";
            $datos = $this->query($query);
        }
        function status_cta($cta,$status,$folio,$fecha,$coments)
        {
            $query = "INSERT INTO finanzas.historial_cuenta (idcuenta,idstatus_cuenta, folio, fecha, observaciones) values (".$cta.",".$status.",'".$folio."','".$fecha."','".$coments."')";
            $datos = $this->query($query);
        }
        function all_clientes()
        {
            $query = "SELECT idempresa,razonsocial from empresas order by razonsocial";
            $datos = $this->query($query);
            return $datos;
        }
        //filtrar clientes
        function clientes_plaza_soc($soc)
        {
            $query = "SELECT c.id,c.razon from clientes c, empresacte e where e.idempresa=$soc and c.id=e.idcte order by c.razon" ;
            $datos = $this->query($query);
            return $datos;
        }
        function guarda_cheq($cta,$fecha_asig,$folio_cheq,$no_cheques,$cheq_ini,$cheq_fin,$resp_cheq,$status_cheq,$date)
        {
            $query = "INSERT INTO finanzas.chequera (idcuenta, folio_cheq, fecha_alta, num_cheques, cheque_inicial, cheque_final, id_responsable, status, usuario_captura, created_at) values (".$cta.",".$folio_cheq.",'".$fecha_asig."',".$no_cheques.",".$cheq_ini.",".$cheq_fin.",".$resp_cheq.",".$status_cheq.",1,'".$date."')";
            $datos = $this->query($query);
            return $datos;

        }
          function borrar_cuenta($id)
        {
            $query = "DELETE from finanzas.cuenta_bancaria where idcuenta=$id;";
            $query .="DELETE from finanzas.historial_responsable where idcuenta=$id;";
            $datos = $this->multi_query($query);
            return $datos;
        }
        function status_token()
        {
            $query="SELECT * from finanzas.status_token";
            $datos= $this->query($query);
            return $datos;
        }
        function areas_operacion()
        {
            $query="SELECT * from finanzas.area_operacion";
            $datos= $this->query($query);
            return $datos;
        }
         function estados_cuenta()
        {
            $query="SELECT * from finanzas.status_cuenta";
            $datos= $this->query($query);
            return $datos;
        }
         function busca_domicilios()
        {
            $query="SELECT id_domicilio, CONCAT(calle,'#',num_ext,'int.',num_int) as domicilio from finanzas.domicilio_cuenta ";
            $datos= $this->query($query);
            return $datos;
        }
        function codigo_postal()
        {
            $query="SELECT distinct Id,codigopostal from codigospostales";
            $datos= $this->query($query);
            return $datos;
        }
         function busca_colonias($id)
        {
            $query="SELECT * from codigospostales where codigopostal=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function datos_cp($cp)
        {
            $query="SELECT * from codigospostales where codigopostal=".$cp;
            $datos= $this->query($query);
            return $datos;
        }
         function guarda_domicilio($cp,$calle,$int,$ext,$inicio,$fin,$date,$info_extra)
        {
            $query="INSERT into finanzas.domicilio_cuenta(idcodigo_postal, calle, num_ext, num_int, periodo_inicio, periodo_fin, estado,info_extra, usuario_captura, created_at) values(".$cp.",'".$calle."','".$ext."','".$int."','".$inicio."','".$fin."',1,'".$info_extra."',1,'".$date."')";
            $datos= $this->query($query);
            return $datos;
        }
        function consulta_domicilios($plaza,$soc)
        {
            $query="SELECT d.estado,id_domicilio, codigopostal, calle, num_ext, num_int, periodo_inicio, periodo_fin, colonia from finanzas.domicilio_cuenta as d inner join codigospostales as c on c.Id=d.idcodigo_postal ";
            $datos= $this->query($query);
            return $datos;
        }
        function busca_dom($plaza,$soc)
        {
            $query= "SELECT id_domicilio,  CONCAT(calle,'#',num_ext,'int.',num_int) as dom, CONCAT(periodo_inicio,'/',periodo_fin) as periodo from finanzas.domicilio_cuenta where idplaza=".$plaza." and idsociedad=".$soc;
            $datos= $this->query($query);
            return $datos;
        }
        function guarda_firmante($cuenta,$fir,$tipo,$plaza,$soc)
        {
            $query= "INSERT INTO finanzas.firmante(idcuenta, id_empleado,tipo,idplaza,idsociedad, status) values('".$cuenta."',".$fir.",".$plaza.",".$tipo.",".$soc.",1)";
            $datos= $this->query($query);
            return $datos;
        }
        function guarda_pregunta($cuenta,$preg,$resp)
        {
            $query= "INSERT INTO finanzas.pregunta_secreta(idcuenta, pregunta, respuesta) values('".$cuenta."','".$preg."','".$resp."')";
            $datos= $this->query($query);
            return $datos;
        }
        function guarda_token($cuenta,$cod_token,$f_token,$resp_token,$vence,$f_vence,$obs_token,$status_token)
        {
            $query= "INSERT INTO finanzas.token_cuenta(idcuenta, codigo, fecha_asig,id_responsable, vence, fecha_vence, observaciones, idstatus_token) values(".$cuenta.",'".$cod_token."','".$f_token."',".$resp_token.",".$vence.",'".$f_vence."','".$obs_token."',".$status_token.")";
            $datos= $this->query($query);
            return $datos;
        }
        function consulta_chequera($id)
        {
            $query= "SELECT idchequera,folio_cheq,c.observaciones,c.fecha_alta,num_cheques,cheque_inicial,cheque_final,c.idstatus_chequera as status,st.nombre as nombre_status, CONCAT( e.Nombre
            ,' ', e.Apellidop,' ', e.Apellidom ) as responsable,c.updated_at from apatodo.Empleados as e inner join finanzas.chequera
             as c on c.id_responsable=e.Id_empleado inner join finanzas.status_chequera as st on st.idstatus_chequera=c.idstatus_chequera where c.idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
     
             function general_cuenta($id)
        {
            $query="SELECT distinct cb.idcuenta, p.Plaza,hr.idresponsable,hr.tipo_resp,hr.fecha as fecha_resp,hr.created_at as crea_resp,
            CONCAT( emp.Nombre,' ', emp.Apellidop,' ', emp.Apellidom ) as responsable,cb.idplaza,cb.tipo_cuenta,cb.tipo_operacion,cb.contrato_nomina,cb.no_cliente,
            cb.moneda,cb.idsociedad, e.razonsocial, a.nombre as area,
            cb.num_cuenta, cb.clabe, b.nombre as banco, st.idstatus_cuenta, st.nombre as status_cuenta, hc.folio, hc.fecha as f_his, 
            hc.observaciones as obs_his, hc.created_at as crea_his, suc.num_suc as sucursal,suc.nombre as suc_nombre,CONCAT(d.calle,' #',num_ext,' int.',num_int) as domicilio,
            cp.colonia,cp.delegacionmunicipio, cp.estado,cp.ciudad,cp.codigopostal,cb.fecha_apertura
            ,CONCAT( ae.Nombre,' ', ae.Apellidop,' ', ae.Apellidom ) as usuario_cta, plu.Plaza as plaza_usuario,
            eu.razonsocial as usuario_soc, cb.no_contrato, cb.saldo_inicial, cb.created_at,cb.updated_at from finanzas.bancos as b inner join finanzas.cuenta_bancaria as cb on cb.id_banco=b.idbancos left join sistema.plaza p on p.id=cb.idplaza
            left join sistema.empresas e on e.idempresa=cb.idsociedad left join finanzas.historial_responsable as hr on hr.idhistorial=cb.idhistorial_responsable 
            left join apatodo.Empleados as emp on emp.Id_empleado=hr.idresponsable left join finanzas.historial_domicilio as hd on hd.idhistorial_domicilio=cb.idhistorial_domicilio 
            left join finanzas.domicilio_cuenta as d on hd.id_domicilio=d.id_domicilio left join finanzas.area_operacion as a on a.idarea_operacion=cb.idarea_operacion left join
            finanzas.historial_cuenta as hc on hc.idhistorial_cuenta=cb.idhistorial_cuenta left join finanzas.status_cuenta as st on st.idstatus_cuenta=hc.idstatus_cuenta left join
            apatodo.Empleados as ae on ae.Id_empleado=cb.usuario_cuenta left join sistema.codigospostales as cp on cp.id=d.idcodigo_postal left join sistema.plaza plu on 
            plu.id=cb.usuario_plaza left join sistema.empresas eu on eu.idempresa=cb.usuario_soc left join finanzas.sucursal_banco as suc on suc.idsucursal=cb.idsucursal where cb.idcuenta=".$id." limit 1;";
            $datos= $this->query($query);
            return $datos;
        }
        function consulta_preguntas($id)
        {
            $query = "SELECT * from finanzas.pregunta_secreta where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;

        }
           function consulta_token($id)
        {
            $query = "SELECT idtoken,t.codigo,t.fecha_asig,CONCAT( a.Nombre,' ', Apellidop,' ', Apellidom ) as responsable,fecha_vence,t.observaciones,s.nombre as nom_status,t.idstatus_token,t.updated_at from finanzas.status_token as s inner join finanzas.token_cuenta as t on s.idstatus_token=t.idstatus_token inner join apatodo.Empleados as a on a.Id_empleado=t.id_responsable where t.idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;

        }
         function personal_firmante($id)
        {
            $query ="SELECT Id_empleado,  CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from apatodo.Empleados where Id_empleado not in(SELECT id_empleado from finanzas.firmante where idcuenta=".$id.")order by nombre_emp;";
            $datos=$this->query($query);
            return $datos;
        }
        function consulta_firmantes($id)
        {
            $query = "SELECT f.idfirmante,f.status, CONCAT( a.Nombre,' ', a.Apellidop,' ', a.Apellidom ) as nombre_emp
            , p.Plaza, e.razonsocial from finanzas.firmante as f inner join apatodo.Empleados as a on a.Id_empleado
            =f.id_empleado left join sistema.plaza p on p.id=f.idplaza left join sistema.empresas e on e.idempresa
            =f.idsociedad where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
         function consulta_status($id)
        {
            $query = "SELECT * from finanzas.historial_cuenta as h inner join finanzas.status_cuenta as s on s.idstatus_cuenta=h.idstatus_cuenta where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function update_status_historial($cta,$status_actual)
        {
            $query = "UPDATE finanzas.cuenta_bancaria set idhistorial_cuenta=".$status_actual." where idcuenta=".$cta;
            $datos= $this->query($query);
            return $datos;
        }
        function status_cuenta()
        {
            $query= "SELECT * from finanzas.status_cuenta";
             $datos= $this->query($query);
            return $datos;
        }
          function guarda_historial($id,$status,$folio,$fecha,$obs,$date)
        {
            $query= "INSERT INTO finanzas.historial_cuenta( idcuenta, idstatus_cuenta, folio, fecha, observaciones, created_at) values(".$id.",".$status.",'".$folio."','".$fecha."','".$obs."','".$date."')";
            $datos = $this->insert_id($query);
            return $datos;
        }
        function actualiza_edo_cta($id,$historial)
        {
            $query= "UPDATE finanzas.cuenta_bancaria set idhistorial_cuenta=".$historial." where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function historial_domicilios($id)
        {
            $query= "SELECT h.idhistorial_domicilio,cp.codigopostal,cp.colonia,cp.delegacionmunicipio,cp.estado as estado_cp,cp.ciudad,d.calle,d.num_ext,d.num_int,h.periodo_inicio as ini, h.periodo_fin as fin, h.updated_at as act from finanzas.historial_domicilio as h inner join finanzas.domicilio_cuenta as d on d.id_domicilio=h.id_domicilio inner join codigospostales as cp on cp.Id=d.idcodigo_postal where h.idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function inserta_historial($cuenta,$domicilio,$dom_ini,$dom_fin,$dateTime)
        {
            $query="INSERT INTO finanzas.historial_domicilio(id_domicilio,idcuenta,periodo_inicio,periodo_fin,created_at) values(".$domicilio.",".$cuenta.",'".$dom_ini."','".$dom_fin."','".$dateTime."')";
            $datos = $this->insert_id($query);
             return $datos;
             
        }
        function update_dom_cuenta($cuenta, $historial_dom)
        {
            $query= "UPDATE finanzas.cuenta_bancaria set idhistorial_domicilio=".$historial_dom." where idcuenta=".$cuenta;
              $datos= $this->query($query);
             return $datos;
        }
        function busca_cp_colonia($cp,$col)
        {
            $query="SELECT Id from codigospostales where codigopostal=".$cp." and colonia='".$col."'";
            $datos= $this->query($query);
            return $datos;
        }
        function consulta_responsables($cta)
        {
            $query="SELECT CONCAT( a.Nombre,' ', a.Apellidop,' ', a.Apellidom ) as responsable,r.idhistorial,r.tipo_resp,r.fecha,r.created_at
from finanzas.historial_responsable as r inner join apatodo.Empleados as a on r.idresponsable=a.Id_empleado where r.idcuenta=".$cta;
            $datos= $this->query($query);
            return $datos;
        }
         function inserta_resposable($cta,$resp_cta,$tipo_resp,$plaza,$soc,$fecha,$date)
        {
            $query="INSERT INTO finanzas.historial_responsable (idcuenta, idresponsable, tipo_resp, idplaza, idsociedad, fecha, status_responsable,created_at) values (".$cta.",".$resp_cta.",".$tipo_resp.",".$plaza.",".$soc.",'".$fecha."',1,'".$date."');";
            $datos = $this->insert_id($query);
           return $datos;
        }
        function update_responsable($cuenta,$resp)
        {
            $query= "UPDATE finanzas.cuenta_bancaria set idhistorial_responsable=".$resp." where idcuenta=".$cuenta;
             $datos= $this->query($query);
            return $datos;
        }
         function inserta_chequera($cta,$fecha_asig,$folio_cheq,$no_cheques,$cheq_ini,$cheq_fin,$resp_cheq,$obs_cheque,$status_cheq,$date)
        {
            $query = "INSERT INTO finanzas.chequera (idcuenta, folio_cheq, fecha_alta, num_cheques, cheque_inicial, cheque_final, id_responsable,observaciones, idstatus_chequera, usuario_captura, created_at) values (".$cta.",".$folio_cheq.",'".$fecha_asig."',".$no_cheques.",".$cheq_ini.",".$cheq_fin.",".$resp_cheq.",'".$obs_cheque."',".$status_cheq.",1,'".$date."')";
            $datos = $this->query($query);
            return $datos;

        }
        function datos_chequera($id)
        {
            $query="SELECT idchequera,folio_cheq,c.observaciones,c.fecha_alta,num_cheques, cheque_inicial,cheque_final,c.id_responsable,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as responsable,c.observaciones,c.idstatus_chequera from finanzas.chequera as c inner join apatodo.Empleados as e on e.Id_empleado=c.id_responsable where idchequera=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function update_datos_chequera($id,$cheq_fecha,$cheq_num,$cheq_ini,$cheq_fin,$cheq_obs,$cheq_resp)
        {
            $query="UPDATE finanzas.chequera set fecha_alta='".$cheq_fecha."', num_cheques=".$cheq_num.",cheque_inicial=".$cheq_ini.",cheque_final=".$cheq_fin.",id_responsable=".$cheq_resp.",observaciones='".$cheq_obs."'  where idchequera=".$id;
             $datos= $this->query($query);
            return $datos;
        }
        function status_chequera($id)
        {
            $query= "SELECT c.idstatus_chequera,s.nombre, c.idchequera from finanzas.chequera as c inner join finanzas.status_chequera as s on s.idstatus_chequera=c.idstatus_chequera where c.idchequera=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function edos_chequera()
        {
            $query="SELECT * from finanzas.status_chequera";
            $datos= $this->query($query);
            return $datos;
        }
        function update_edo_chequera($id,$edo)
        {
            $query="UPDATE finanzas.chequera set idstatus_chequera=".$edo." where idchequera=".$id;
            $datos= $this->query($query);
            return $datos;
        }
           function status_firmante($id)
        {
            $query= "SELECT status from finanzas.firmante where idfirmante=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function update_edo_firmante($id,$edo)
        {
            $query="UPDATE finanzas.firmante set status=".$edo." where idfirmante=".$id;
            $datos= $this->query($query);
            return $datos;
        }
            function status_pregunta($id)
        {
            $query= "SELECT status from finanzas.pregunta_secreta where idpregunta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function update_edo_pregunta($id,$edo)
        {
            $query="UPDATE finanzas.pregunta_secreta set status=".$edo." where idpregunta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
          function busca_edo_token($id)
        {
            $query= "SELECT status from finanzas.token_cuenta where idtoken=".$id;
            $datos= $this->query($query);
            return $datos;
        }
         function update_edo_token($id,$edo)
        {
            $query="UPDATE finanzas.token_cuenta set idstatus_token=".$edo." where idtoken=".$id;
            $datos= $this->query($query);
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
        function busca_cuentas_plaza_soc($plaza,$soc)
        {
          $query="SELECT * from finanzas.cuenta_bancaria where idplaza=".$plaza." and idsociedad=".$soc;
          $datos= $this->query($query);
          return $datos;
        }
          function consulta_archivos($cuenta)
        {
            $query= "SELECT * from finanzas.archivos_cuenta where idcuenta=".$cuenta;
            $datos= $this->query($query);
             return $datos;
        }
         function filtra_cuentas_banco($plaza,$soc,$banco)
        {
          $query="SELECT * from finanzas.cuenta_bancaria where idplaza=".$plaza." and idsociedad=".$soc." and id_banco=".$banco;
          $datos= $this->query($query);
          return $datos;
        }
        function guarda_archivo($cuenta,$name,$nuevo_nombre,$file_ext,$titulo,$descripcion)
        {
            $query="INSERT INTO finanzas.archivos_cuenta(idcuenta, org_nombre,nuevo_nombre, tipo, titulo, descripcion) values(".$cuenta.",'".$name."','".$nuevo_nombre."','".$file_ext."','".$titulo."','".$descripcion."')";
            $datos= $this->query($query);
            return $datos;
        }
        function borrar_archivo($id)
        {
            $query="DELETE from finanzas.archivos_cuenta where idarchivo_cuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function detalle_firmante($cta)
        {
          $query="SELECT f.idfirmante,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as firmante,f.status from finanzas.firmante as f inner join apatodo.Empleados as e on e.Id_empleado=f.id_empleado where idcuenta=".$cta;
          $datos= $this->query($query);
          return $datos;
        }
        function detalle_domicilio($cta)
        {
            $query="SELECT CONCAT(calle,'#',num_ext,'int.',num_int) as domicilio, d.periodo_inicio,d.periodo_fin from finanzas.historial_domicilio as h inner join
            finanzas.cuenta_bancaria as c on c.idhistorial_domicilio=h.idhistorial_domicilio inner join finanzas.domicilio_cuenta as d on d.id_domicilio=h.id_domicilio where c.idcuenta=".$cta;
            $datos= $this->query($query);
            return $datos;
        }
         function detalle_usuarios($cta)
        {
          $query="SELECT CONCAT( a.Nombre,' ', Apellidop,' ', Apellidom ) as usuario,razonsocial from sistema.empresas as e inner join finanzas.cuenta_bancaria as c 
          on e.idempresa=c.usuario_soc inner join apatodo.Empleados as a on a.Id_empleado=c.usuario_cuenta where c.idcuenta=".$cta;
          $datos= $this->query($query);
          return $datos;
        }
        //actualiza el usuario de una cuenta
        function guarda_usuario($cuenta,$usuario,$plaza,$soc)
        {
            $query="UPDATE finanzas.cuenta_bancaria SET usuario_cuenta=".$usuario.", usuario_plaza=".$plaza.", usuario_soc=".$soc." WHERE idcuenta=".$cuenta;
            $datos = $this->query($query);
            return $datos;
        }
        function busca_cte_resp($id)
        {
            $query="";
        }
        function all_externos($plaza,$soc)
        {
            $query = "SELECT * from finanzas.personal_externo where idplaza=".$plaza." and idsociedad=".$soc;
            $datos = $this->query($query);
            return $datos;
        }
        function guarda_externo($nombre,$rfc,$obs,$plaza,$soc)
        {
            $query = "INSERT INTO finanzas.personal_externo(nombre_completo,rfc,observaciones,idplaza,idsociedad) values('".$nombre."','".$rfc."','".$obs."',".$plaza.",".$soc.")";
            $datos = $this->insert_id($query);
            return $datos;
        }
        function busca_externos($plaza,$soc)
        {
            $query = "SELECT * from finanzas.personal_externo where idplaza=".$plaza." and idsociedad=".$soc;
            $datos = $this->query($query);
            return $datos;
        }
          function guarda_temporal_estado($ubicacion)
        { 
             $query="load data local infile '$ubicacion' into table finanzas.temp_estados_cuenta fields terminated by ',' enclosed by '\"' lines terminated by '\n' IGNORE 1 LINES (fecha, tipo,abonos,cargos,folio,referencia,codigo,concepto);";
             $datos = $this->query($query);
            return $datos;
        }
         function vacia_tabla_estados()
        {
            $query= "TRUNCATE finanzas.temp_estados_cuenta";
            $datos = $this->query($query);
            return $datos;
        }
        //guarda los conceptos del estado de cuenta
         function guarda_concepto_estado($cta,$fecha,$desc,$cargo,$abono,$saldo,$usuario)
        {
            $query= "INSERT INTO finanzas.conciliacion(idcuenta,fecha,descripcion,cargo,abono,saldo,usuario_captura) values(".$cta.",'".$fecha."','".$desc."',".$cargo.",".$abono.",".$saldo.",".$usuario.")";
            $datos = $this->query($query);
            return $datos;
        }
        function mes_anio($anio)
        {
            $query = "SELECT * FROM finanzas.meses_anios where anio=".$anio." group by idmes_anio";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_estados($cta,$mes)
        {
            $query = "SELECT * FROM finanzas.archivo_estado where idcuenta=".$cta;
            $datos = $this->query($query);
            return $datos;
        }
        function consulta_estadosCta($cta)
        {
            $query = "SELECT * FROM finanzas.archivo_estado where idcuenta=".$cta;
        }
         function nombre_mes($mes)
        {
            $query = "SELECT distinct nombre_mes FROM finanzas.meses_anios where idmes_anio=".$mes;
            $datos = $this->query($query);
            return $datos;
        }
        function insert_edoCuenta($mes,$cta,$archivo,$usuario,$dateTime)
        {
            $query = "INSERT INTO finanzas.archivo_estado(idmes_anio, idcuenta, archivo, usuario_captura, created_at) values(".$mes.",".$cta.",'".$archivo."',".$usuario.",'".$dateTime."')";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_mes_estado($mes)
        {
            $query = "SELECT idarchivo_estado from finanzas.archivo_estado where idmes_anio=".$mes;
            $datos = $this->query($query);
            return $datos;
        }
        function update_edoCuenta($id,$archivo)
        {
            $query = "UPDATE finanzas.archivo_estado set archivo='".$archivo."' where idarchivo_estado=".$id;
            $datos = $this->query($query);
            return $datos;
        }
        function cancela_domicilio($id)
        {
            $query = "UPDATE finanzas.domicilio_cuenta set estado=0 where id_domicilio=".$id;
            $datos = $this->query($query);
            return $datos;
        }
           function guarda_tempCuentas($ubicacion)
        {   
             $query="load data local infile '$ubicacion' into table finanzas.temp_cuentas fields terminated by ',' enclosed by '\"' lines terminated by '\n' IGNORE 1 LINES (num,sociedad, plaza,banco,tipo,num_cheques,tipo_op,responsable,firmantes,num_cuenta,clabe,fecha_ap,sucursal,nombre_suc,codigo_dom,moneda,area,status,comentarios);";
             $datos = $this->query($query);
            return $datos;
        }
        function vacia_tempCuentas()
        {
            $query= "TRUNCATE finanzas.temp_cuentas";
            $datos = $this->query($query);
            return $datos;
        }
         function busca_tempCuentas(){
            $query='SELECT * from finanzas.temp_cuentas';
            $datos = $this->query($query);
            return $datos;
        }
        function buscar_banco_nombre($banco)
        {
            $query = "SELECT * from finanzas.bancos where nombre like '%".$banco."%'";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_suc_nombre($suc,$nombre)
        {
            $query = "SELECT * from finanzas.sucursal_banco where num_suc=".$suc." and nombre like '%".$nombre."%'";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_soc_nombre($soc)
        {
            $query = "SELECT idempresa,razonsocial from empresas where razonsocial like '%".$soc."%'";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_plaza_nombre($plaza)
        {
            $query = "SELECT * from sistema.plazas where plaza like '%".$plaza."%'";
            $datos = $this->query($query);
            return $datos;
        }
        function busca_emp_nombre($nombre)
        {
            $query = "SELECT * from apatodo.Empleados as e where CONCAT( e.Nombre
            ,' ', e.Apellidop,' ', e.Apellidom ) like '%".$nombre."%'";
             $datos = $this->query($query);
            return $datos;
        }
        function coincidencia_cp($colonia,$cp)
        {
            $query = "SELECT * from sistema.codigospostales where codigopostal=".$cp." and colonia LIKE '%".$colonia."%'";
            $datos = $this->query($query);
            return $datos;
        }
         function coincidencia_dom($colonia,$id_cp,$calle,$num_ext,$num_int)
        {
            $query = "SELECT * from finanzas.domicilio_cuenta where idcodigo_postal=".$id_cp." and calle like '%".$calle."%' and num_ext like '%".$num_ext."%' and num_int like '".$num_int."'" ;
            $datos = $this->query($query);
            return $datos;
        }
         //obtiene todos los domicilios registrados
        function all_domicilios(){
        $query="SELECT *,CONCAT(calle,'#',num_ext,'int.',num_int,',MPO.',delegacionmunicipio,',',ciudad,',',c.estado
        ) as domicilio,d.estado as edo_dom from finanzas.domicilio_cuenta as d inner join sistema.codigospostales as c on d.idcodigo_postal
        =c.Id";
            $bancos = $this->query($query);
            return $bancos;
        }
        //busca un domicilio en especifico
         function busca_dom_id($id)
        {
            $query = "SELECT *, d.estado as status_dom from finanzas.domicilio_cuenta as d inner join sistema.codigospostales as c on d.idcodigo_postal=c.Id where id_domicilio=".$id;
            $datos = $this->query($query)        ;
            return $datos;
        }
        //actualiza los datos del domicilio
          function update_domicilio($cp,$id,$ext,$int,$info_extra,$calle,$inicio,$fin,$status)
        {
            $query="UPDATE finanzas.domicilio_cuenta set idcodigo_postal=".$cp.",calle='".$calle."',num_ext=".$ext.",num_int='".$int."',estado=".$status.",info_extra='".$info_extra."',periodo_inicio='".$inicio."',periodo_fin='".$fin."' where id_domicilio=".$id;
            $datos= $this->query($query);
            return $datos;
        }
           function busca_area_op($area)
    {
        $query= "SELECT * from finanzas.area_operacion where abreviatura='".$area."'";
        $datos= $this->query($query);
        return $datos;
    }
    //guarda una sucursal
    function guarda_suc($banco,$num_suc,$nombre)
    {
        $query = "INSERT INTO finanzas.sucursal_banco(idbanco, num_suc, nombre) VALUES (".$banco.",'".$num_suc."','".$nombre."')";
        $datos= $this->insert_id($query);
        return $datos;
    }
     function buscar_suc_nombre($num,$nombre)
    {
        $query = "SELECT * from finanzas.sucursal_banco where num_suc=".$num." and nombre like '%".$nombre."'";
        $datos= $this->query($query);
        return $datos;
    }
    function busca_emp_rfc($rfc)
    {
      $query = "SELECT * from apatodo.Empleados where Rfc='".$rfc."'";
      $datos= $this->query($query);
      return $datos;

    }
    function firmates_cta($cta)
    {
        $query = "SELECT * from finanzas.firmante where idcuenta=".$cta;
        $datos= $this->query($query);
        return $datos;
    }
     function firmantes_externos($id)
        {
            $query = "SELECT * from finanzas.firmante as f left join finanzas.personal_externo as a on a.id_externo=f.id_empleado left join sistema.plaza p on p.id=f.idplaza left join sistema.empresas e on e.idempresa=f.idsociedad where idcuenta=".$id;
            $datos= $this->query($query);
            return $datos;
        }
        function busca_suc_banco($id)
    {
        $query = "SELECT * from finanzas.sucursal_banco where idbanco=".$id;
        $datos= $this->query($query);
        return $datos;
    }
      function sucursal_banco($id)
    {
        $query = "SELECT * from finanzas.sucursal_banco as s inner join bancos as b on.idbancos=s.idbanco where idbanco=".$id;
        $datos= $this->query($query);
        return $datos;
    }
    function borra_sucursal($id)
    {
        $query= "DELETE from finanzas.sucursal_banco where idsucursal=".$id;
        $datos= $this->query($query);
        return $datos;
    }

    }
?>