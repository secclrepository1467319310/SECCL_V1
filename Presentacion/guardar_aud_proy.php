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

$auditor = $_POST["audi"];
$proyecto = $_POST["proyecto"];

$query8 = ("SELECT count(*) from auditores_proyecto where id_auditor='$auditor' and id_proyecto='$proyecto'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0]>0) {
echo("<SCRIPT>window.alert(\"Auditor Ya Asociado\")</SCRIPT>");

?>
<script type="text/javascript">
        window.location = "../Presentacion/menumisional.php";
</script>
<?php
}else 
{ 

//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO AUDITORES_PROYECTO
        (
        ID_AUDITOR,
        ID_PROYECTO)
        VALUES 
        ('$auditor','$proyecto') ";


$objParse1 = oci_parse($connection, $strSQL1);
$objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
if($objExecute1)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse1); 
	echo "Error Save [".$e['message']."]";
}


oci_close($connection);
}

echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
?>
<script type="text/javascript">
    window.location="../Presentacion/menumisional.php";
</script>