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
$h = 0;
for ($i = 0; $i < count($chkMesa); $i++) {

    $selectNorma = "SELECT CODIGO_NORMA,VERSION_NORMA,TITULO_NORMA,TO_CHAR(EXPIRACION_NORMA,'dd/mm/yyyy') AS EXPIRACION,ID_NORMA
        FROM NORMA
        WHERE CODIGO_MESA = $chkMesa[$i] AND ACTIVA = '1'";
    $objParseSelectNorma = oci_parse($objConnect, $selectNorma);
    $objExecuteSelectNorma = oci_execute($objParseSelectNorma, OCI_DEFAULT);
    $arraySelectNorma = oci_fetch_all($objParseSelectNorma, $rowSelectNorma);

    for ($j = 0; $j < $arraySelectNorma; $j++) {
        echo "<tr id='trNorma$h'>";
        echo "<td id='tdCodigoNorma$h'><font face='verdana'>" . $rowSelectNorma[CODIGO_NORMA][$j] . "</font></td>";
        echo "<td id='tdVersionNorma$h'><font face='verdana'>" . $rowSelectNorma[VERSION_NORMA][$j] . "</font></td>";
        echo "<td id='tdTituloNorma$h'><font face='verdana'>" . utf8_encode($rowSelectNorma[TITULO_NORMA][$j]) . "</font></td>";
        echo "<td id='tdExpiracionNorma$h'><font face='verdana'>" . $rowSelectNorma[EXPIRACION][$j] . "</font></td>";
        echo "<td id='tdChkNorma$h'>";
        echo '<input type="checkbox" name="codigo[]" value="' . $rowSelectNorma[ID_NORMA][$j] . '"/>';
        echo "</td>";
        echo "</tr>";
        $h++;
    }
}