<?php

include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);
//$objConnect = @OCILogon('certicompetencias', 'Ccompetencias7', '//localhost/orcl.0.16.99');

$proyecto=$_GET["proyecto"];
//$evaluador=$_POST['id'];
$norma=$_POST["codigo"];
$evaluador=$_POST['documento'];


$total2 = count($norma);

for ($i = 0; $i < $total2; $i++) {
    ECHO $norma[$i]."---";

    $qyaasociado="SELECT * FROM EVALUADOR_PROYECTO WHERE id_evaluador='$evaluador' AND ID_PROYECTO='$proyecto' AND ID_NORMA='$norma[$i]'";
    $syaasociado= oci_parse($objConnect, $qyaasociado);
    oci_execute($syaasociado);
    $ryaasociado=oci_fetch_array($syaasociado,OCI_NUM);


    if(!$ryaasociado){
            $strSQL3 = "INSERT INTO EVALUADOR_PROYECTO
            (
            ID_EVALUADOR,
            ID_PROYECTO,
            ID_NORMA
            )
            VALUES (
            
            '$evaluador','$proyecto','$norma[$i]') ";
        
        //die($strSQL3);   
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


oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/evaluadores_proyecto_c.php?proyecto=<?php echo $proyecto ?>";
</script>