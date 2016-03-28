<?php
//Carga la funciones comunes top y footer
require('common.php');

//Carga el modelo para este controlador
require("models/config.php");

class Config extends Common
{
	public $ConfigModel;
	function __construct()
	{
		//Se crea el objeto que instancia al modelo que se va a utilizar

		$this->ConfigModel = new ConfigModel();
		$this->ConfigModel->connect();
	}

	function __destruct()
	{
		//Se destruye el objeto que instancia al modelo que se va a utilizar
		$this->ConfigModel->close();
	}

	//Funcion mainpage que genera la pagina por default en caso de no existir el controlador
	function mainPage()
	{
		$IsEmpty = $this->ConfigModel->IsEmpty();
		$Exercises = $this->ConfigModel->getAllExercises();
		require('views/config/mainpage.php');
	}

	
}
?>