<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

include("../Clase/conectar.php");
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);


//print_r($_POST);
extract($_POST);

$sql = "Insert into ENCUESTA_LIVE   ( ID_USUARIO,VOTO)
 values ('$id','$encuLive') ";
$datos2 = oci_parse($conexion, $sql);
oci_execute($datos2);

echo("<script>alert('Gracias por su opinion !!')</script>");

header('location: menulider.php');