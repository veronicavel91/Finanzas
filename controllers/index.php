<?php error_reporting(E_ERROR);
//Carga la funciones comunes top y footer
require('common.php');

class Index extends Common
{

    //Metodo que genera la Pagina default en caso de no existir la funcion
    function mainPage(){
       require('views/inicio/Principal.php');
    }

    //Metodo de prueba
    function getNada(){
        echo "<br />No hay nada<br />";
    }

}
?>