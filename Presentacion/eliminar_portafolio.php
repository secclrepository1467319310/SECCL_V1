<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eliminar_portafolio
 *
 * @author oforero
 */
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
$usuario = $_GET['candidato'];
$portafolio = $_GET['portafolio'];
$documento = $_GET['documento'];
$proyecto = $_GET['proyecto'];
$plan = $_GET['plan'];
$norma = $_GET['norma'];
$grupo = $_GET['grupo'];

//erificar si un usuario ya esta certificado.


switch ($documento) {
    case 1:
        $delSQL = "DELETE FROM portafolio WHERE id_portafolio=$portafolio";
        $urlRedireccion = "../Presentacion/portafolio_candidato.php?idc=$usuario&mensaje=$mensaje";
        $numCertificaciones = 0;
        break;
    case 2:
        $delSQL = "DELETE FROM portafolio_proceso WHERE id_portafolio_proceso=$portafolio";
        $urlRedireccion = "../Presentacion/subir_sensibilizacion_c.php?proyecto=$proyecto";
        $numCertificaciones = 0;
        break;
    case 3:
        $delSQL = "DELETE FROM portafolio_proceso WHERE id_portafolio_proceso=$portafolio";
        $urlRedireccion = "../Presentacion/subir_induccion_ev.php?proyecto=$proyecto";
        $numCertificaciones = 0;
        break;
    case 4:
        $queryCertificacion = "SELECT COUNT(*) FROM certificacion WHERE id_candidato='$usuario' AND id_norma = '$norma' AND id_proyecto=$proyecto";
        $statement = oci_parse($objConnect, $queryCertificacion);
        oci_execute($statement);
        $numCertificaciones = oci_fetch_array($statement, OCI_BOTH);
        $numCertificaciones = $numCertificaciones['COUNT(*)'];
        if ($numCertificaciones < 1) {
            $mensaje = 1;
        } else {
            $mensaje = 2;
        }
        $delSQL = "DELETE FROM portafolio_evidencias WHERE id_portafolio_evidencias=$portafolio";
        $urlRedireccion = "../Presentacion/cargar_soportes_evidencias.php?proyecto=$proyecto&idplan=$plan&grupo=$grupo&norma=$norma&idca=$usuario&mensaje=$mensaje";
        break;
}

//Eliminar un portafolio.

if ($numCertificaciones < 1) {
    $objParse = oci_parse($objConnect, $delSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
    }
    oci_close($objConnect);
}


header("location: $urlRedireccion");
