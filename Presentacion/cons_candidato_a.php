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

$documento = $_POST['documento'];
//--obtener id
$strSQL = "select usuario_id from usuario where documento='$documento'  and (rol_id_rol=10 or aprobado='1')";
$statement1 = oci_parse($connection, $strSQL);
$resp1 = oci_execute($statement1);
$idc = oci_fetch_array($statement1, OCI_BOTH);
//----obtener nombre
$strSQL2 = "select nombre from usuario where usuario_id='$idc[0]'  and (rol_id_rol=10 or aprobado='1')";
$statement2 = oci_parse($connection, $strSQL2);
$resp2 = oci_execute($statement2);
$nombre = oci_fetch_array($statement2, OCI_BOTH);
//---obtener apellido
$strSQL3 = "select primer_apellido from usuario where usuario_id='$idc[0]'  and (rol_id_rol=10 or aprobado='1')";
$statement3 = oci_parse($connection, $strSQL3);
$resp3 = oci_execute($statement3);
$pape = oci_fetch_array($statement3, OCI_BOTH);
//---obtener apellido
$strSQL4 = "select segundo_apellido from usuario where usuario_id='$idc[0]'  and (rol_id_rol=10 or aprobado='1')";
$statement4 = oci_parse($connection, $strSQL4);
$resp4 = oci_execute($statement4);
$sape = oci_fetch_array($statement4, OCI_BOTH);

oci_close($connection);


?>
<script type="text/javascript">
    window.location = "../Presentacion/consultar_datos_a.php?id=<?php echo $idc[0] ?>&documento=<?php echo $documento ?>&nombre=<?php echo $nombre[0] ?>&pape=<?php echo $pape[0] ?>&sape=<?php echo $sape[0] ?>";
</script>
