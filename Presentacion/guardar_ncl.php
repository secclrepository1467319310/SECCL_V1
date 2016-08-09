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


$cp = $_POST["plan"];
$unidad = $_POST["unidad"];
$perinv = $_POST["codigo"];
$nit = $_POST["nit_empresa"];
$n_empresa = $_POST["nombre_empresa"];
$nit_empresa = $_POST["nit_empresa"];
$tipo_proyecto = $_POST["tp"];
$fecha_registro = DATE('d/m/y');

if ($n_empresa == 'Empresa no Registrada' && $tp = 2) {

    echo("<SCRIPT>window.alert(\"Por Favor Revisar la Empresa\")</SCRIPT>");
?>
        <script type="text/javascript">
            window.location = "../Presentacion/ver_poa.php";
        </script>

    <?php
} else if ($n_empresa <> 'Empresa no Registrada' && $tp = 2) {

    //generar secuenciador, registrando en la tabla de secuenciador

    $strSQL1 = "INSERT INTO PROVISIONAL
        (
        ID_USUARIO
        )
        VALUES (
        
        '$id') ";

    $objParse1 = oci_parse($objConnect, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
    if ($objExecute1) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse1);
        echo "Error Save [" . $e['message'] . "]";
    }

//-----Obtener el provisional

    $query3 = ("select count(*) from provisional");
    $statement3 = oci_parse($objConnect, $query3);
    $resp3 = oci_execute($statement3);
    $provisional = oci_fetch_array($statement3, OCI_BOTH);


//----------------------------------Detalles-----------------------//


    $total = count($perinv);
    for ($i = 0; $i < $total; $i++) {

        $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL,USU_REGISTRO)
        VALUES ('$perinv[$i]','$nit_empresa','$cp','$provisional[0]','$id')";



        $objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);


        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }
    }
} else if ($tp = 1) {

//generar secuenciador, registrando en la tabla de secuenciador

    $strSQL1 = "INSERT INTO PROVISIONAL
        (ID_USUARIO)VALUES ('$id') ";

    $objParse1 = oci_parse($objConnect, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
    if ($objExecute1) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse1);
        echo "Error Save [" . $e['message'] . "]";
    }

//-----Obtener el provisional

    $query3 = ("select count(*) from provisional");
    $statement3 = oci_parse($objConnect, $query3);
    $resp3 = oci_execute($statement3);
    $provisional = oci_fetch_array($statement3, OCI_BOTH);


//----------------------------------Detalles-----------------------//



    $total = count($perinv);
    for ($i = 0; $i < $total; $i++) {

        $strSQL = "INSERT INTO DETALLES_POA (ID_NORMA,NIT_EMPRESA,ID_PLAN,ID_PROVISIONAL)
        VALUES ('$perinv[$i]','$nit_empresa','$cp','$provisional')";



        $objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);


        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }
    }
}
oci_close($objConnect);
    ?>
<script type="text/javascript">
    window.location = "../Presentacion/registrardetallesplan.php?provi=<?php echo $provisional[0]?>&plan=<?php echo $cp ?>&nit=<?php echo $nit_empresa ?>&tp=<?php echo $tipo_proyecto ?>";
</script>