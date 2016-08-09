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

$regional = $_POST["regional"];
$tdoc = $_POST["tdoc"];
$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$papellido =$_POST["papellido"];
$sapellido = $_POST["sapellido"];
$email = $_POST["email"];


$query8 = ("SELECT count(*) from T_INSTRUMENTADORES where documento='$documento'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0]>0) {
echo("<SCRIPT>window.alert(\"Apoyo Ya Registrado\")</SCRIPT>");

?>
<script type="text/javascript">
        window.location = "../Presentacion/registrar_instrumentador_c.php";
</script>
<?php
}else 
{ 

//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO T_INSTRUMENTADORES
        (CODIGO_REGIONAL,
        T_DOCUMENTO,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        NOMBRE,
        DOCUMENTO,
        EMAIL,
        ESTADO,
        USU_REGISTRO)
        VALUES 
        ('$regional','$tdoc','$papellido','$sapellido','$nombres','$documento','$email',1,$id) ";


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
    window.location="../Presentacion/instrumentadores_c.php";
</script>