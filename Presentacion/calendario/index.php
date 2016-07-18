<?php
///////////////////////////////////////////////////////////////////////////////////////////////
//Libreria para mostrar un calendario y obtener una fecha
//
//La p�gina que llame a esta libreria debe contener un formulario con tres campos donde se introducir� el d�a el mes y el a�o que se desee
//Para que este calendario pueda actualizar los campos de formulario correctos debe recibir varios datos (por GET)
//formulario (con el nombre del formulario donde estan los campos
//dia (con el nombre del campo donde se colocar� el d�a)
//mes (con el nombre del campo donde se colocar� el mes)
//ano (con el nombre del campo donde se colocar� el a�o)
///////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Calendario PHP</title>
	<link rel="STYLESHEET" type="text/css" href="estilo.css">
	<script>
		function devuelveFecha(dia,mes,ano){
			//Se encarga de escribir en el formulario adecuado los valores seleccionados
			//tambi�n debe cerrar la ventana del calendario
			var formulario_destino = '<?php echo $_GET["formulario"]?>'
			
			var campo_destino = '<?php echo $_GET["nomcampo"]?>'
					
			//meto el dia
                        if(dia < 10){
                            dia = '0'+dia;
                        }
                        
                        if(mes < 10){
                            mes = '0'+mes;
                        }
			eval ("opener.document." + formulario_destino + "." + campo_destino + ".value='" + dia + "/" + mes + "/" + ano + "'")
                        window.close();
		}
	</script>
</head>

<body>

<?php
//TOMO LOS DATOS QUE RECIBO POR LA url Y LOS COMPONGO PARA PASARLOS EN SUCESIVAS EJECUCIONES DEL CALENDARIO
$parametros_formulario = "formulario=" . $_GET["formulario"] . "&nomcampo=" . $_GET["nomcampo"];
?>

<div align="center">
<?php
require ("calendario.php");
$tiempo_actual = time();
$dia_solo_hoy = date("d",$tiempo_actual);
if (!$_POST && !isset($_GET["nuevo_mes"]) && !isset($_GET["nuevo_ano"])){
	$mes = date("n", $tiempo_actual);
	$ano = date("Y", $tiempo_actual);
}elseif ($_POST) {
	$mes = $_POST["nuevo_mes"];
	$ano = $_POST["nuevo_ano"];
}else{
	$mes = $_GET["nuevo_mes"];
	$ano = $_GET["nuevo_ano"];
}
	
mostrar_calendario($mes,$ano);
formularioCalendario($mes,$ano);
?>
</div>
</body>
</html>