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
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

//usuario
$pass=$_POST["pass"];


//Actualizar contacto


    $strSQL4 = "UPDATE USUARIO 
        SET 
        USUARIO_PASSWORD='$pass'
        WHERE USUARIO_ID='$id'";
    
   
$objParse4 = oci_parse($objConnect, $strSQL4);
$objExecute4=oci_execute($objParse4, OCI_DEFAULT);


if($objExecute4)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse4); 
	
}


echo("<SCRIPT>window.alert(\"Datos Actualizados\")</SCRIPT>");

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/misdatos_l.php";
</script>
