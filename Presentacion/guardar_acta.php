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

$SQL_regional = ("SELECT * FROM T_REGIONALES_USUARIOS WHERE ID_USUARIO = $id");
$statement = oci_parse($objConnect, $SQL_regional);
$resp = oci_execute($statement);
$array_regional = oci_fetch_array($statement, OCI_BOTH);

//Obtenemos los datos
extract($_POST);

//function query($query, $objConnect) {
//    $objParse = oci_parse($objConnect, $query);
//    $objExecute = oci_execute($objParse, OCI_DEFAULT);
//
//    if ($objExecute) {
//        oci_commit($objConnect); //*** Commit Transaction ***//
//    } else {
//        oci_rollback($objConnect); //*** RollBack Transaction ***//
//        $e = oci_error($objParse);
//        exit();
//    }
//}

switch ($opcion) {
    case 1:
        // Insertamos el acta
        $queryActa = "INSERT INTO t_acta(CODIGO_REGIONAL, ID_USU_REGISTRO
        )VALUES('$array_regional[CODIGO_REGIONAL]' , '$id'
        )";
        $redireccion = "actas.php?mensaje=1";
        break;
    case 2:
        $hora_inicio = $horaInicioHora . ":" . $horaInicioMinutos . " " . $horaInicioJornada;
        $hora_fin = $horaFinHora . ":" . $horaFinMinutos . " " . $horaFinJornada;
        $queryActa = "UPDATE t_acta SET NOMBRE = '$nombre_comite', CIUDAD = '$ciudad', HORA_INICIO = '$hora_inicio', HORA_FIN = '$hora_fin', LUGAR = '$lugar', TEMA = '$temas', CONCLUSIONES = '$concluciones', DESARROLLO = '$desarrollo', OBJETIVO = '$objetivos' WHERE T_ID_ACTA = $id_acta";


        $query = "SELECT * FROM T_AREAS_CLAVES_ACTAS WHERE ID_ACTA = $id_acta";
        $statement = oci_parse($objConnect, $query);
        oci_execute($statement);
        $numActa = oci_fetch_all($statement, $rowActa);

        if ($numActa <= 0) {
            $redireccion = "acta_areas_claves_cm.php?id_acta=$id_acta&mensaje=1";
        } else {
            $redireccion = "agregar_acta.php?id_acta=$id_acta";
        }


        $deleteCompromisos = "DELETE FROM T_COMPROMISOS_ACTA WHERE ID_ACTA = $id_acta";
        $objParse = oci_parse($objConnect, $deleteCompromisos);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);

        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        $deleteAsistentes = "DELETE FROM T_ASISTENTE_ACTA WHERE ID_ACTA = $id_acta";
        $objParse = oci_parse($objConnect, $deleteAsistentes);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);

        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        $deleteInvitados = "DELETE FROM T_INVITADOS_ACTA WHERE ID_ACTA = $id_acta";
        $objParse = oci_parse($objConnect, $deleteInvitados);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        $nCompromisos = count($actividad);
        $nAsistentes = count($nombre_asistente);
        $nInvitados = count($nombre_invitado);

        for ($i = 0; $i < $nCompromisos; $i++) {
            $fecha = $fechaDia[$i] . '/' . $fechaMes[$i] . '/' . $fechaPeriodo[$i];
            $values = " INTO T_COMPROMISOS_ACTA (ACTIVIDAD,RESPONSABLE,FECHA_COMPROMISO,ID_ACTA,USU_REGISTRO) VALUES ('$actividad[$i]','$responsable[$i]','$fecha',$id_acta,$id)";
            $valuesCompromisos = $valuesCompromisos . $values;
        }
        $queryCompromisos = 'INSERT ALL ' . $valuesCompromisos . ' SELECT * FROM DUAL';
        $objParse = oci_parse($objConnect, $queryCompromisos);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        for ($i = 0; $i < $nAsistentes; $i++) {
            $values = " INTO T_ASISTENTE_ACTA(NOMBRE,CARGO,ID_ACTA) VALUES ('$nombre_asistente[$i]','$cargo_asistente[$i]',$id_acta)";
            $valuesAsistentes = $valuesAsistentes . $values;
        }
        $queryAsistentes = 'INSERT ALL ' . $valuesAsistentes . ' SELECT * FROM DUAL';
        $objParse = oci_parse($objConnect, $queryAsistentes);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        for ($i = 0; $i < $nInvitados; $i++) {
            $values = " INTO T_INVITADOS_ACTA(NOMBRE,CARGO,ENTIDAD,ID_ACTA) VALUES ('$nombre_invitado[$i]','$cargo_invitado[$i]','$entidad_invitado[$i]',$id_acta)";
            $valuesInvitados = $valuesInvitados . $values;
        }
        $queryInvitados = 'INSERT ALL ' . $valuesInvitados . ' SELECT * FROM DUAL';
        $objParse = oci_parse($objConnect, $queryInvitados);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }

        break;
}

//actualizamos el acta
$objParseActa = oci_parse($objConnect, $queryActa);
$objExecuteActa = oci_execute($objParseActa, OCI_DEFAULT);
if ($objExecuteActa) {
    oci_commit($objConnect); //*** Commit Transaction ***//
    header('location:' . $redireccion);
} else {
    oci_rollback($objConnect); //*** RollBack Transaction ***//
    $e = oci_error($objParseActa);
}
oci_close($objConnect);
?>
