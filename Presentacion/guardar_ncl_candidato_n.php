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

$documento = $_GET["id"];
$proyecto = $_GET["proyecto"];

$perinv = $_POST['codigo'];
$total = count($perinv);
for ($i = 0; $i < $total; $i++) {

    $strSQL = "INSERT INTO candidatos_proyecto (ID_PROYECTO,ID_CANDIDATO,ID_NORMA)
        VALUES ('$proyecto','$documento','$perinv[$i]') ";
    
    $objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);

if($objExecute)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse); 
	echo "Error Save [".$e['message']."]";
}
}
oci_close($connection);


?>
<script type="text/javascript">
    window.location="../Presentacion/candidatos_proyecto_n.php?proyecto=<?php echo $proyecto?>";
</script>