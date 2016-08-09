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


$query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
$statement3 = oci_parse($connection, $query3);
$resp3 = oci_execute($statement3);
$idc = oci_fetch_array($statement3, OCI_BOTH);


$query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$reg = oci_fetch_array($statement1, OCI_BOTH);

$query2 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
$statement2 = oci_parse($connection, $query2);
$resp2 = oci_execute($statement2);
$cen = oci_fetch_array($statement2, OCI_BOTH);

$query4 = ("SELECT COUNT(*) FROM PLAN_ANUAL WHERE ID_CENTRO='$cen[0]' AND SUBSTR(FECHA_ELABORACION, 7,4) = 2016");

$statement4 = oci_parse($connection, $query4);
$resp4 = oci_execute($statement4);
$total = oci_fetch_array($statement4, OCI_BOTH);

if ($total[0] > 0) {
    ?>
    <script type="text/javascript">
        window.location = "../Presentacion/ver_poa.php";
    </script>
    <?php
} else {


    $regional = $reg[0];
    $centro = $cen[0];
    $usuario = $id;
    $fecha_registro = DATE('d/m/y');

    $strSQL = "INSERT INTO PLAN_ANUAL
        (
        ID_REGIONAL,
        ID_CENTRO,
        USU_REGISTRO
        )
        VALUES (
        
        '$reg[0]','$cen[0]','$usuario') ";

    $objParse = oci_parse($connection, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
        echo "Error Save [" . $e['message'] . "]";
    }

    oci_close($connection);
}
?>

<script type="text/javascript">
    window.location = "../Presentacion/ver_poa.php";
</script>
