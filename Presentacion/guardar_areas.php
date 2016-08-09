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


$idarea = $_GET['idarea'];
$perinv = $_POST["codigo"];

$total = count($perinv);
for ($i = 0; $i < $total; $i++) {

    $strSQL = "INSERT INTO AREAS_CLAVES_CENTRO (ID_AREA_CLAVE,ID_MESA,OBS_MISIONAL,USU_REGISTRO,APROBADO_ASESOR,PERIODO)
        VALUES ('$idarea','$perinv[$i]','Sin Comentarios','$id','3','2015')";
    
    
        
$objParse = oci_parse($objConnect, $strSQL);
$objExecute=oci_execute($objParse, OCI_DEFAULT);


if($objExecute)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse); 
	
}
}
oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/cargar_soporte_area.php?idarea=<?php echo $idarea ?>";
</script>