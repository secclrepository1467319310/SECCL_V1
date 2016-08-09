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

$proyecto = $_GET["proyecto"];
$provisional = $_GET["provisional"];
$norma = $_POST['norma'];
$sol = $_POST['sol'];
$fi = $_POST['fi'];
$resp = $_POST['resp'];
$ff = $_POST['ff'];
$obs = $_POST['obs'];

    
    $strSQL = "INSERT INTO OBS_BANCO
        (
        ID_PROVISIONAL,
        ID_NORMA,
        SOLICITUD,
        FECHA_SOLICITUD,
        RESPUESTA,
        FECHA_RESPUESTA,
        USU_REGISTRO,
        ID_PROYECTO,
        OBS
        )
        VALUES (
        
        '$provisional','$norma','$sol','$fi','$resp','$ff','$id','$proyecto','$obs') ";
    
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

oci_close($connection);

    ?>

<script type="text/javascript">
    window.location = "../Presentacion/reg_sol_b.php?proyecto=<?php echo $proyecto ?>";
</script>
