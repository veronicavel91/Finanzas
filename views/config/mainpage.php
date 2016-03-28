<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script language='javascript'>
$(document).ready(function() {
	$('#nmloader_div',window.parent.document).hide();
});

function guardaInicio(){
	$.post("ajax.php?c=Config&f=FirstExercise",
	{
		Ejercicio: $("#ejercicio").val(),
	},
	function()
	{
		location.reload()
	});
};
function Cerrar(IdEx,NombreEjercicio)
{
	var confirma = confirm("Esta seguro de cerrar el ejercicio "+NombreEjercicio+"?")
	if(confirma)
	{
		$.post("ajax.php?c=Config&f=CloseExercise",
		{
			Id: IdEx,
			Ejercicio: NombreEjercicio,
		},
		function(data)
		{
			switch(data)
			{
				case 'Si':
						alert("El Ejercicio "+NombreEjercicio+" ha sido Cerrado");
						location.reload()
						break;
				case 'No':
						alert("((ALERTA)) No se ha generado la poliza del periodo 13, por lo tanto no se puede cerrar el ejercicio.");
						break;
				default:
						alert("No se ha cerrado el ejercicio anterior.")		
			}
			
			
		});
	}
}

function validar(f)
{
	if(f.activo.checked == false)
	{
		alert("Seleccione un ejercicio");
		return false
	}
}
</script>
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<style>
#title
{
	width:350px;
	border-bottom:2px solid white;
	text-align: center;
}
table tr
{
	background-color:#EEEEEE;
}
table tr td
{
	width:136px;
	text-align: center;
	font-size:16px;
	padding:10px;
	border-bottom:1px solid #BEBCBC;
}
a
{
	color:black;
	text-decoration: none;
}
a:hover
{
	text-decoration: underline;
}
</style>
<?php
if(!$IsEmpty)
{
	?>
	<center><div id='title'>Comenzando desde?</div>
		<table cellspacing='0' cellpadding='0'>
			<tr><td style='width:28px;'></td><td>
				<select name='ejercicio' id='ejercicio'>
					<?php
					$anyo = date('Y');
					for($i=0;$i<=4;$i++)
					{
						echo "<option value='$anyo'>$anyo</option>";
						$anyo -= 1;

					}
					?>
					
				</select>
				<td><input type='button' id='guardaInicio' value='Establecer' onClick='javascript:guardaInicio()'></td>
			</table>
			<?php
		}
		else{
			?>
			<form name='guarda' method='post' action='index.php?c=Config&f=Establecer' onSubmit='return validar(this)'>
				<center><div  class="nmwatitles">Cat&aacute;logo de Ejercicios</div>
					<table cellspacing='0' cellpadding='0'>
						<?php
						while($Ex = $Exercises->fetch_array())
						{
							if($Ex['EjercicioActual'])
							{
								$checked = "checked";
								$estilo = "background-color:#525154;color:white;";
							}
							else
							{
								$checked = "";
								$estilo = "background-color:none;color:black;";
							}
							if(!$Ex['Cerrado'])
							{
								$cerrado = "<input type='button' onClick='javascript:Cerrar(".$Ex['Id'].",".$Ex['NombreEjercicio'].");' class='nminputbutton_color2' value='Cerrar?' />";
							}else
							{
								$cerrado = "Cerrado";
							}
							echo "<tr style='$estilo'><td style='width:20px;'><input type='radio' name='activo' value='".$Ex['NombreEjercicio']."' $checked ></td><td>".$Ex['NombreEjercicio']."</td><td>$cerrado</td></tr>";	
						}
						?>
						<tr><td style='width:20px;'></td><td> <input type='submit' class="nminputbutton_color2" value='Establecer como actual' name='guardar'> </td><td></td></tr>
						<tr><td style='width:20px;'></td><td><b> <input type="button" class="nminputbutton" onClick="window.open('index.php?c=Config&f=configExercise','_self')" value="Configuraci&oacute;n" ></b></td><td></td></tr>
					</form>
				</table>
				<?php
			}
			?>

