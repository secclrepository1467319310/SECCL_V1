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
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$proyecto=$_GET["proyecto"];
//$evaluador=$_POST['id'];
$norma=$_POST['codigo'];
$evaluador=$_POST['documento'];


$total2 = count($norma);

for ($i = 0; $i < $total2; $i++) {
    $strSQL3 = "INSERT INTO EVALUADOR_PROYECTO
        (
        ID_EVALUADOR,
        ID_PROYECTO,
        ID_NORMA
        )
        VALUES (
        
        '$evaluador','$proyecto','$norma[$i]') ";
    
   
$objParse3 = oci_parse($objConnect, $strSQL3);
$objExecute3=oci_execute($objParse3, OCI_DEFAULT);


if($objExecute3)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse3); 
	
}

}

$strSQL2 = "UPDATE EVALUADOR 
        SET 
         ESTADO_USUARIO='2'
         WHERE DOCUMENTO = '$evaluador'";
    
   
$objParse2 = oci_parse($objConnect, $strSQL2);
$objExecute2=oci_execute($objParse2, OCI_DEFAULT);

if($objExecute2)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse2); 
	
}

oci_close($connection);

    ?>

<script type="text/javascript">
    window.location = "../Presentacion/evaluadores_proyecto_n.php?proyecto=<?php echo $proyecto?>";
</script>
