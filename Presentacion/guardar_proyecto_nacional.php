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

$insertProyectoNacional = "INSERT INTO T_PROYECTOS_NACIONALES(
                            DESCRIPCION,
                            NOMBRE_CONTACTO,
                            TELEFONO_CONTACTO,
                            CECULAR_CONTACTO,
                            EMAIL_CONTACTO,
                            PRESUPUESTO_SENA,
                            PRESUPUESTO_ENTIDAD_EXTERNA,
                            USU_REGISTRO,
                            NUMERO_TOTAL_CANDIDATOS,
                            DESC_PRO_REGIONAL,
                            TIPO_PROYECTO,
                            OBSERVACION
                           )
                           VALUES(
                            '$descripcion',
                            '$nombre_contacto',
                            '$telefono_contacto',
                            '$celular_contacto',
                            '$email_contacto',
                            '$presupuesto_sena',
                            '$presupuesto_entidad',
                            '$id',
                            '$numero_total_candidatos',
                            '$desc_pro_regional',
                            '$tipo_proyecto',
                            '$txt'
                           )returning ID_PROYECTO_NACIONAL into :id";

$objParseProyectoNacional = oci_parse($objConnect, $insertProyectoNacional);
OCIBindByName($objParseProyectoNacional, ":id", $id_proyecto_nac, 32);
$objExecute = oci_execute($objParseProyectoNacional);

if ($objExecute) {
    oci_commit($objConnect);
} else {
    oci_rollback($objConnect);
    $e = oci_error($objParse);
}
//oci_rollback($objConnect);

$idPlanes = explode(",", $planes_centro);


if ($n_empresa == 'Empresa no Registrada' && $tp == 2) {

    echo("<SCRIPT>window.alert(\"Por Favor Revisar la Empresa\")</SCRIPT>");
    ?>
    <script type="text/javascript">
        window.location = "../Presentacion/proyecto_nacional.php";
    </script>

    <?php
} else if ($n_empresa <> 'Empresa no Registrada') {
    $total = count($codigo);
    $totalPlanes = count($idPlanes);
    for ($j = 0; $j < ($totalPlanes-1); $j++) {
        $strSQL1 = "INSERT INTO PROVISIONAL
        (
        ID_USUARIO
        )
        VALUES (
        
        '$id') ";

        $objParse1 = oci_parse($objConnect, $strSQL1);
        $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);

        if ($objExecute1) {
            oci_commit($objConnect);
        } else {
            oci_rollback($objConnect);
            $e = oci_error($objParse1);
            echo "Error Save [" . $e['message'] . "]";
        }
//        oci_rollback($objConnect);

        $query3 = ("select count(*) from provisional");
        $statement3 = oci_parse($objConnect, $query3);
        $resp3 = oci_execute($statement3);
        $provisional = oci_fetch_array($statement3, OCI_BOTH);
        
        for ($i = 0; $i < $total; $i++) {

            if ($tp == 2) {
                $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL,USU_REGISTRO)
                    VALUES ('$codigo[$i]','$nit_empresa','$idPlanes[$j]','$provisional[0]','$id')";
            } else if ($tp == 1) {
                $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL)
                    VALUES ('$codigo[$i]','$nit_empresa','$idPlanes[$j]','$provisional[0]')";
            }

            $objParse = oci_parse($objConnect, $strSQL);
            $objExecute = oci_execute($objParse, OCI_DEFAULT);

            if ($objExecute) {
                oci_commit($objConnect);
            } else {
                oci_rollback($objConnect);
                $e = oci_error($objParse);
            }
//            oci_rollback($objConnect);
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
              '$nit_empresa',
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
//        oci_rollback($objConnect);

        $insertProyNacProyecto = "INSERT INTO T_PROY_NAC_PROYECTO(
              ID_PROYECTO_NACIONAL,
              ID_PROYECTO
              )
              VALUES(
              '$id_proyecto_nac',
              '$id_proyecto'
              )";

        $objParseProyNacProyecto = oci_parse($objConnect, $insertProyNacProyecto);
        $objExecuteProyNacProyecto = oci_execute($objParseProyNacProyecto, OCI_DEFAULT);

        if ($objExecute) {
            oci_commit($objConnect);
        } else {
            oci_rollback($objConnect);
            $e = oci_error($objParse);
        }
//        oci_rollback($objConnect);
    }
}
oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/ver_proyectos_nacionales.php";
</script>