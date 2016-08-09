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

$proyecto = $_GET['proyecto'];


//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO SENSIBILIZACION
        (ID_PROYECTO,ID_USU_REGISTRO)
        VALUES 
        ('$proyecto','$id') ";


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

echo("<SCRIPT>window.alert(\"Sensibilizacion Formalizada\")</SCRIPT>");

//formalizar a las personas

$query9 = ("select ID_SENSIBILIZACION from sensibilizacion where id_proyecto='$proyecto'");
$statement9 = oci_parse($connection, $query9);
$resp9 = oci_execute($statement9);
$idsen = oci_fetch_array($statement9, OCI_BOTH);

$query = "SELECT DISTINCT usuario.usuario_id
FROM usuario
INNER JOIN candidatos_proyecto 
ON candidatos_proyecto.id_candidato = usuario.usuario_id
WHERE candidatos_proyecto.id_proyecto = '$proyecto'";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numero = 0;
while ($row = oci_fetch_array($statement, OCI_BOTH)) {
    
    $q2="INSERT INTO SENSIBILIZACION_CANDIDATOS (ID_SENSIBILIZACION,ID_CANDIDATO) VALUES ('$idsen[0]','$row[$numero]') ";
    $statement2 = oci_parse($connection, $q2);
    oci_execute($statement2);

    $numero++;
}

oci_close($connection);
?>
<script type="text/javascript">
    window.location="../Presentacion/gen_sensibilizacion.php?proyecto=<?php echo $proyecto ?>";
</script>