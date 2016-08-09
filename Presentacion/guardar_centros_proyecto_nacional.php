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

$selecDetPoa = "SELECT DISTINCT DP.ID_NORMA,DP.NIT_EMPRESA
    FROM DETALLES_POA DP
    INNER JOIN PROYECTO PRO
        ON DP.ID_PROVISIONAL = PRO.ID_PROVISIONAL
    INNER JOIN T_PROY_NAC_PROYECTO TPNP
        ON PRO.ID_PROYECTO = TPNP.ID_PROYECTO
    INNER JOIN T_PROYECTOS_NACIONALES TPN
        ON TPNP.ID_PROYECTO_NACIONAL = TPN.ID_PROYECTO_NACIONAL
    WHERE TPN.ID_PROYECTO_NACIONAL = $proNac";

$objParse = oci_parse($objConnect, $selecDetPoa);
oci_execute($objParse, OCI_DEFAULT);
$numRow = oci_fetch_all($objParse, $rows);

//echo '<pre>';
//var_dump($rows);
//echo '</pre>';

echo $totalPlanes = count($idPlanes);
for ($j = 0; $j < $totalPlanes; $j++) {
    $strSQL1 = "INSERT INTO PROVISIONAL
        (
        ID_USUARIO
        )
        VALUES (
        '$id')";

    $objParse1 = oci_parse($objConnect, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);

    if ($objExecute1) {
        oci_commit($objConnect);
    } else {
        oci_rollback($objConnect);
        $e = oci_error($objParse1);
        echo "Error Save [" . $e['message'] . "]";
    }

//    $e = oci_error($objParse);

    $query3 = ("select count(*) from provisional");
    $statement3 = oci_parse($objConnect, $query3);
    $resp3 = oci_execute($statement3);
    $provisional = oci_fetch_array($statement3, OCI_BOTH);

    for ($i = 0; $i < count($rows[ID_NORMA]); $i++) {

        $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL,USU_REGISTRO)
                    VALUES ('" . $rows[ID_NORMA][$i] . "','" . $rows[NIT_EMPRESA][0] . "','$idPlanes[$j]','$provisional[0]','$id')returning ID_NORMA into :id ";

        $objParse = oci_parse($objConnect, $strSQL);
        OCIBindByName($objParse, ":id", $idDetalle, 32);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);

        if ($objExecute) {
            oci_commit($objConnect);
        } else {
            oci_rollback($objConnect);
            $e = oci_error($objParse);
        }
//        $e = oci_error($objParse);
    }

    $select = "SELECT ID_REGIONAL,ID_CENTRO FROM PLAN_ANUAL WHERE ID_PLAN = '$idPlanes[$j]'";
    $objParse = oci_parse($objConnect, $select);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    $arraySelect = oci_fetch_array($objParse, OCI_BOTH);

    $insertProyecto = "INSERT INTO PROYECTO(
              ID_REGIONAL,
              ID_CENTRO,
              FECHA_ELABORACION,
              ID_PLAN,
              NIT_EMPRESA,
              ID_ESTADO_PROYECTO,
              USU_REGISTRO,
              ID_PROVISIONAL,
              APROBADO_INSTRUMENTOS,
              TIPO_PROYECTO,
              LINEA,
              TP1,
              TP2,
              TP3,
              TP4
              )
              VALUES(
              '" . $arraySelect['ID_REGIONAL'] . "',
              '" . $arraySelect['ID_CENTRO'] . "',
              '" . date('d/m/Y') . "',
              '" . $idPlanes[$j] . "',
              '{$rows[NIT_EMPRESA][0]}',
              '1',
              '" . $_SESSION['USUARIO_ID'] . "',
              '" . $provisional[0] . "',
              '0',
              '$tp',
              '$tp',
              '$al1',
              '$al2',
              '$al3',
              '$al4'
              )returning ID_PROYECTO into :id";

    $objParseProyecto = oci_parse($objConnect, $insertProyecto);
    OCIBindByName($objParseProyecto, ":id", $id_proyecto, 32);
    $objExecuteProyecto = oci_execute($objParseProyecto, OCI_DEFAULT);

    if ($objExecute) {
        oci_commit($objConnect);
    } else {
        oci_rollback($objConnect);
        $e = oci_error($objParse);
    }
//    $e = oci_error($objParse);

    $insertProyNacProyecto = "INSERT INTO T_PROY_NAC_PROYECTO(
              ID_PROYECTO_NACIONAL,
              ID_PROYECTO
              )
              VALUES(
              '$proNac',
              '$id_proyecto'
              )returning ID_PROYECTO into :id";

    $objParseProyNacProyecto = oci_parse($objConnect, $insertProyNacProyecto);
    OCIBindByName($objParseProyNacProyecto, ":id", $id_pro, 32);
    $objExecuteProyNacProyecto = oci_execute($objParseProyNacProyecto, OCI_DEFAULT);
    echo '<br/><br/>'.$id_pro;
    if ($objExecute) {
        oci_commit($objConnect);
    } else {
        oci_rollback($objConnect);
        $e = oci_error($objParse);
    }
//    $e = oci_error($objParse);
}
oci_close($objConnect);
?>
<script type = "text/javascript">
    window.location = "../Presentacion/ver_proyectos_nacionales.php";
</script>