<?php
    require("models/connection_sqli_manual.php"); // funciones mySQLi

    class email_model extends Connection
    {
    	function all_emails()
        {
            $query="SELECT c.estado as estado_email,c.email, c.idcorreo,CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp from finanzas.correos_empleado as c inner join apatodo.Empleados as e on e.Id_empleado=c.id_empleado";
            $datos= $this->query($query);
            return $datos;
        }
        function all_emails2($plaza,$soc)
        {
            $query="SELECT correos.idcorreo, correos.email, CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp, correos.estado from finanzas.correos_empleado as correos inner join apatodo.Empleados as emp on emp.Id_empleado=correos.id_empleado where idplaza=".$plaza." and idsociedad=".$soc;
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
         function all_plazas()
        {
            $query='SELECT * from sistema.plazas order by plaza';
            $datos = $this->query($query);
            return $datos;
        }
	    function guarda_email($emp,$email,$plaza,$soc)
	    {
            $query = "INSERT INTO finanzas.correos_empleado(id_empleado,idplaza,idsociedad,email,estado) values(".$emp.",".$plaza.",".$soc.",'".$email."',1)";
            $datos = $this->query($query);
            return $datos;
        }
         function busca_email($id)
        {
            $query = "SELECT idcorreo,  CONCAT( Nombre,' ', Apellidop,' ', Apellidom ) as nombre_emp,email, correos.estado from finanzas.correos_empleado as correos inner join apatodo.Empleados as emp on emp.Id_Empleado=correos.id_empleado  where correos.idcorreo=".$id;
            $datos = $this->query($query);
            return $datos;
        }
        function update_email($id,$email,$status)
        {
            $query="UPDATE finanzas.correos_empleado SET email="."'".$email."'".", estado=$status WHERE idcorreo=".$id;
            $datos = $this->query($query);
        }
          function borrar_email($id)
        {
            $query = "DELETE FROM finanzas.correos_empleado WHERE idcorreo=".$id;
            $datos = $this->query($query);
        }
        
        
    }
?>