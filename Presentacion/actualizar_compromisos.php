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
$proyecto=$_GET['proyecto'];
$compromisos=$_POST["compromisos"];
$perinv = $_POST["codigo"];
$perinvs = $_POST["codigos"];

$total = count($perinv);
for ($i = 0; $i < $total; $i++) {
    
    

    $strSQL = "INSERT INTO COMPROMISOS_E_PROYECTO (ID_COMPROMISO_EMPRESA,ID_PROYECTO)
        VALUES ('$perinv[$i]','$proyecto')";
    
    
        
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
//--------------
$totals = count($perinvs);
for ($i = 0; $i < $totals; $i++) {
    
    echo $perinvs[$i];

    $strSQLs = "INSERT INTO COMPROMISOS_S_PROYECTO (ID_COMPROMISO_SENA,ID_PROYECTO)
        VALUES ('$perinvs[$i]','$proyecto')";
    
    
        
$objParses = oci_parse($objConnect, $strSQLs);
$objExecutes=oci_execute($objParses, OCI_DEFAULT);


if($objExecutes)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParses); 
	
}
}


//Actualizar contacto


    $strSQL4 = "UPDATE PROYECTO SET COMPROMISOS='$compromisos' WHERE ID_PROYECTO='$proyecto'";
    
   
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


oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/verdetalles_proyecto_c2.php?proyecto=<?php echo $proyecto ?>";
</script>
