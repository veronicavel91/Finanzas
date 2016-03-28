<?php session_start();

//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/email_model.php");

class email extends Common
{
    public $email_model;

    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->email_model = new email_model();
        $this->email_model->connect();
    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->email_model->close();
    }

    //panel del administrador
      function emails()
    {   
        $personas= $this->email_model->all_personal();
        $empleados= $this->email_model->all_personal();
        $plazas = $this->email_model->all_plazas();
        require('views/emails/emails.php');
    }
    function muestra_emails()
    {
       $plaza=$_REQUEST['plaza'];
       $soc=$_REQUEST['soc'];
       $emails = $this->email_model->all_emails2($plaza,$soc);
       $array_emails = array(); //creamos un array
 
        while($email=$emails->fetch_assoc()) 
        { 
            $id=$email['idcorreo'];
            $emp=$email['nombre_emp'];
            $email=$email['email'];
            $status=$email['correos.estado'];
            $array_emails[] = array('id'=> $id,'nombre_emp'=> $emp,'email'=>$email, 'estado_email' => $status);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_emails);
        echo $json_string;
    }
    //busca el correo del empleado y extrae los datos
     function buscar_email()
    {
        $id=$_REQUEST['id'];
        $correos=$this->email_model->busca_email($id);
        $array_correos = array(); //creamos un array

        while($correo=$correos->fetch_assoc()) 
        { 
            $email=$correo['email'];
            $status= $correo['estado'];
            $nombre_emp= $correo['nombre_emp'];
            $idcorreo= $correo['idcorreo'];
            $array_correos[] = array('idcorreo'=> $idcorreo,'nombre_emp'=> $nombre_emp,'email'=>$email,'status'=>$status);
         
        }
            
        //Creamos el JSON
        $json_string = json_encode($array_correos);
        echo $json_string;
    }
    // actualiza los datos del correo del empleado
      function update_email()
    {
        $id=$_REQUEST['id'];
        $email=$_REQUEST['email'];
        $status=$_REQUEST['status'];
        $upd=$this->email_model->update_email($id,$email, $status);
        echo "OK";
    }
    //boramos el registro
     function borrar_email()
    {
        $id=$_REQUEST['id'];
        $borrar=$this->email_model->borrar_email($id);
        echo "OK";
    }
    //guarda correo del empleado
        function guarda_email()
    {
        $email=$_REQUEST['email'];
        $emp=$_REQUEST['emp'];
        $plaza=$_REQUEST['plaza'];
        $soc=$_REQUEST['soc'];
        $guarda = $this->email_model->guarda_email($emp,$email,$plaza,$soc);
        echo "OK";
        

    }

    



    
   

    
}

?>
