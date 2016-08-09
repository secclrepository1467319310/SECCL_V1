<?php

include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

$oferta=$_GET['oferta'];

$idn=$_POST["codigo"];
$desc=$_POST["descripcion"];
$req=$_POST["requisitos"];
$cupo=$_POST["cupo"];

//ultimo insert

$total2 = count($idn);
for ($i = 0; $i < $total2; $i++) {
    $strSQL3 = "INSERT INTO OFERTA_NCL
        (
        ID_OFERTA,
        ID_NORMA,
        DESCRIPCION,
        REQUISITOS,
        CUPO
        )
        VALUES (
        
        '$oferta','$idn[$i]','$desc[$i]','$req[$i]','$cupo[$i]') ";
    
   
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
oci_close($objConnect);
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>
