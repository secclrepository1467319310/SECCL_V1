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

$selectMesa = "SELECT CODIGO_MESA,NOMBRE_MESA FROM MESA";
$objParseSelectMesa = oci_parse($objConnect, $selectMesa);
$objExecuteSelectMesa = oci_execute($objParseSelectMesa, OCI_DEFAULT);
$arraySelectMesa = oci_fetch_all($objParseSelectMesa, $rowSelectMesa);

//echo '<pre>';
//var_dump($rowSelectMesa);
//echo '</pre>';

for ($i = 0; $i < $arraySelectMesa; $i++) {
    echo "<tr id='trMesa$i'>";
    echo "<td id='tdCodigoMesa$i'><font face='verdana'>" . $rowSelectMesa[CODIGO_MESA][$i] . "</font></td>";
    echo "<td id='tdNombreMesa$i'><font face='verdana'>" . utf8_encode($rowSelectMesa[NOMBRE_MESA][$i]) . "</font></td>";
    echo "<td id='tdChkMesa$i'>";
    echo '<input type="checkbox" name="chkMesa[]" value="' . $rowSelectMesa[CODIGO_MESA][$i] . '"/>';
    echo "</td>";
    echo "</tr>";
}
