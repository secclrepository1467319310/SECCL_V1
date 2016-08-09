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


$idnorma = $_GET['norma'];
$proyecto = $_GET['proyecto'];
$grupo = $_GET['grupo'];


    $strSQL = "INSERT INTO PLAN_EVIDENCIAS (ID_PROYECTO,ID_NORMA,GRUPO,USU_REGISTRO)
        VALUES ('$proyecto','$idnorma','$grupo','$id')";
    
    
        
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

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/consultar_grupo_ev.php?norma=<?php echo $idnorma ?>&proyecto=<?php echo $proyecto ?>";
</script>