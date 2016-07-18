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

extract($_POST);

//echo '<pre>';
//var_dump($_POST);
//echo '</pre>';

for ($i = 0;$i < count($hidMesa);$i++) {
    $update = "UPDATE INSTRUMENTOS SET OBSERVACIONES = 'NO HAY INSTRUMENTOS' WHERE ID_MESA = '$hidMesa[$i]'";

    $objParse = oci_parse($objConnect, $update);
    $objExecute = oci_execute($objParse);

    if ($objExecute) {
        oci_commit($objConnect);
    } else {
        oci_rollback($objConnect);
        $e = oci_error($objParse);
    }
}
for ($i = 0; $i < count($codigo); $i++) {
    $datos = explode(',', $codigo[$i]);

    $insert = "UPDATE INSTRUMENTOS SET OBSERVACIONES = 'SI HAY INSTRUMENTOS' WHERE ID_NORMA = '$datos[0]' AND VRS = '$datos[1]'";

    $objParse = oci_parse($objConnect, $insert);
    $objExecute = oci_execute($objParse);

    if ($objExecute) {
        oci_commit($objConnect);
    } else {
        oci_rollback($objConnect);
        $e = oci_error($objParse);
    }
}

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/modificar_estado_instrumentos.php";
</script>