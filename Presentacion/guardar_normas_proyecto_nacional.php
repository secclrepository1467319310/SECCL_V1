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

echo '<pre>';
var_dump($_POST);
echo '</pre>';

$query = "SELECT DISTINCT DP.ID_NORMA FROM T_PROYECTOS_NACIONALES PN
INNER JOIN T_PROY_NAC_PROYECTO PNP
  ON PN.ID_PROYECTO_NACIONAL = PNP.ID_PROYECTO_NACIONAL
INNER JOIN PROYECTO PRO
  ON PNP.ID_PROYECTO = PRO.ID_PROYECTO
INNER JOIN DETALLES_POA DP
  ON PRO.ID_PROVISIONAL = DP.ID_PROVISIONAL
WHERE PN.ID_PROYECTO_NACIONAL = $_POST[proNac]";

$obj = oci_parse($objConnect, $query);
oci_execute($obj);
$numRows = oci_fetch_all($obj, $rows);

for ($i = 0; $i < count($codigo); $i++) {
    for ($j = 0; $j < $numRows; $j++) {
        if ($codigo[$i] == $rows[ID_NORMA][$j]) {
            $codigo[$i] = '';
        }
    }
}

$codigo = array_filter($codigo, 'strlen');

$queryProvisional = "SELECT DISTINCT DP.ID_PROVISIONAL FROM T_PROYECTOS_NACIONALES PN
INNER JOIN T_PROY_NAC_PROYECTO PNP
  ON PN.ID_PROYECTO_NACIONAL = PNP.ID_PROYECTO_NACIONAL
INNER JOIN PROYECTO PRO
  ON PNP.ID_PROYECTO = PRO.ID_PROYECTO
INNER JOIN DETALLES_POA DP
  ON PRO.ID_PROVISIONAL = DP.ID_PROVISIONAL
WHERE PN.ID_PROYECTO_NACIONAL = $_POST[proNac]";
//echo $queryProvisional;
//die();
$objProvisional = oci_parse($objConnect, $queryProvisional);
oci_execute($objProvisional);
$numRowsProvisional = oci_fetch_all($objProvisional, $rowsProvisional);

for ($i = 0; $i < $numRowsProvisional; $i++) {

    $queryDP = "SELECT DISTINCT NIT_EMPRESA,ID_PLAN "
            . "FROM DETALLES_POA "
            . "WHERE ID_PROVISIONAL = " . $rowsProvisional[ID_PROVISIONAL][$i];

    $objDP = oci_parse($objConnect, $queryDP);
    oci_execute($objDP);
    $numRowsDP = oci_fetch_all($objDP, $rowsDP);

    for ($j = 0; $j < count($codigo); $j++) {
        if (isset($codigo[$j])) {
            $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL,USU_REGISTRO)
                    VALUES ('" . $codigo[$j] . "','" . $rowsDP[NIT_EMPRESA][0] . "','" . $rowsDP[ID_PLAN][0] . "','" . $rowsProvisional[ID_PROVISIONAL][$i] . "','$id')";

            $objParse = oci_parse($objConnect, $strSQL);
            $objExecute = oci_execute($objParse, OCI_DEFAULT);

            if ($objExecute) {
                oci_commit($objConnect);
            } else {
                oci_rollback($objConnect);
                $e = oci_error($objParse);
            }
        }
    }
}

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/ver_proyectos_nacionales.php";
</script>