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
                $regional = "1";
                $centro = "17076";
                $usuario = $id;
                
                $query4 = ("SELECT count(*) FROM plan_anual where "
                        . "id_centro='117' and usu_registro='$id'");
                $statement4 = oci_parse($connection, $query4);
                $resp4 = oci_execute($statement4);
                $total = oci_fetch_array($statement4, OCI_BOTH);
                
                if ($total[0]>0) {
                    ?>
<script type="text/javascript">
    window.location = "../Presentacion/ver_poa_n.php";
</script>
<?php                
}else{
                    
                


    
    $strSQL = "INSERT INTO PLAN_ANUAL
        (
        ID_REGIONAL,
        ID_CENTRO,
        USU_REGISTRO
        )
        VALUES (
        
        '$regional','$centro','$usuario') ";
    
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
}
    ?>

<script type="text/javascript">
    window.location = "../Presentacion/ver_poa_n.php";
</script>
