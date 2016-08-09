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

    /*
    $selectNorma = "SELECT ID_NORMA,VRS,TITULO_NORMA,TO_CHAR(EXPIRACION,'dd/mm/yyyy') AS EXPIRACION,CODIGO_INSTRUMENTO,TRIM(OBSERVACIONES) AS OBSERVACIONES
        FROM INSTRUMENTOS
        WHERE ID_MESA = $chkMesa[$i]";
     * 
     */
    $selectNorma = "SELECT 	
            I.ID_NORMA,
            I.VRS,
            N.TITULO_NORMA,
            TO_CHAR(N.EXPIRACION_NORMA,	'dd/mm/yyyy') AS EXPIRACION,
            TRIM(I.OBSERVACIONES) AS OBSERVACIONES 
    FROM INSTRUMENTOS I
            JOIN NORMA N 
            ON (
                    I.ID_NORMA=N.CODIGO_NORMA
                    AND 
                    I.VRS=N.VERSION_NORMA
                    AND
                    N.ACTIVA = 1
                    )

    WHERE N.CODIGO_MESA =  '$chkMesa[$i]'";
    $objParseSelectNorma = oci_parse($objConnect, $selectNorma);
    $objExecuteSelectNorma = oci_execute($objParseSelectNorma, OCI_DEFAULT);
    $arraySelectNorma = oci_fetch_all($objParseSelectNorma, $rowSelectNorma);
    //die($selectNorma);
    echo "<input type='hidden' name='hidMesa[]' value='$chkMesa[$i]'>";
    
    for ($j = 0; $j < $arraySelectNorma; $j++) {
        echo "<tr id='trNorma$h'>";
        echo "<td id='tdCodigoNorma$h'><font face='verdana'>" . $rowSelectNorma[ID_NORMA][$j] . "</font></td>";
        echo "<td id='tdVersionNorma$h'><font face='verdana'>" . $rowSelectNorma[VRS][$j] . "</font></td>";
        echo "<td id='tdTituloNorma$h'><font face='verdana'>" . utf8_encode($rowSelectNorma[TITULO_NORMA][$j]) . "</font></td>";
        echo "<td id='tdExpiracionNorma$h'><font face='verdana'>" . $rowSelectNorma[EXPIRACION][$j] . "</font></td>";
        echo "<td id='tdChkNorma$h'>";
        if ($rowSelectNorma[OBSERVACIONES][$j] == 'NO HAY INSTRUMENTOS') {
            echo '<input type="checkbox" name="codigo[]" value="' . $rowSelectNorma[ID_NORMA][$j] . ',' . $rowSelectNorma[VRS][$j] . '"/>';
        } else if ($rowSelectNorma[OBSERVACIONES][$j] == 'SI HAY INSTRUMENTOS') {
            echo '<input type="checkbox" name="codigo[]" value="' . $rowSelectNorma[ID_NORMA][$j] . ',' . $rowSelectNorma[VRS][$j] . '" checked/>';
        }
        echo "</td>";
        echo "</tr>";
        $h++;
    }
}