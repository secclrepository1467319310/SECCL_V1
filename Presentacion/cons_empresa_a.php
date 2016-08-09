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

$nit = $_POST['nit'];
$strSQL = "select nombre_empresa from empresas_sistema where nit_empresa='$nit'";
$statement1 = oci_parse($connection, $strSQL);
$resp1 = oci_execute($statement1);
$nom = oci_fetch_array($statement1, OCI_BOTH);
//----
$strSQL2 = "select sigla_empresa from empresas_sistema where nit_empresa='$nit'";
$statement2 = oci_parse($connection, $strSQL2);
$resp2 = oci_execute($statement2);
$sig = oci_fetch_array($statement2, OCI_BOTH);



oci_close($connection);


?>
<script type="text/javascript">
    window.location = "../Presentacion/consultar_empresa_a.php?nit=<?php echo $nit ?>&sigla=<?php echo $sig[0] ?>&nombre=<?php echo $nom[0] ?>";
</script>
