<?php error_reporting(E_ERROR); session_start();

//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/inicio_model.php");

class inicio extends Common
{
    public $inicio_model;

    function __construct()
    {
        //Se crea el objeto que instancia al modelo que se va a utilizar

        $this->inicio_model = new inicio_model();
        $this->inicio_model->connect();
    }

    function __destruct()
    {
        //Se destruye el objeto que instancia al modelo que se va a utilizar
        $this->inicio_model->close();
    }

    //panel del administrador
      function panel()
    {   
        require('views/inicio/panel.php');
    }
    



    
   

    
}

?>
