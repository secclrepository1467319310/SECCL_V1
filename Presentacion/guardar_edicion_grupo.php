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
$idnorma = $_POST['idnorma'];
$proyecto = $_POST["proyecto"];
$grupo = $_POST["grupo"];
$perinv = $_POST["usuario"];
$evaluador = $_POST["evaluador"];
$total = count($perinv);
$auto_grupo = $_POST["auto_grupo"];

$SQL_plan = ("SELECT * FROM plan_evidencias WHERE id_norma = $idnorma AND grupo = $grupo AND id_proyecto = $proyecto");
$statement = oci_parse($objConnect, $SQL_plan);
$resp = oci_execute($statement);
$array_plan = oci_fetch_array($statement, OCI_BOTH);
$contador_candidatos_evidencias = 0;

$SQL_EVALUADOR = ("UPDATE PROYECTO_GRUPO SET ID_EVALUADOR = '$evaluador' WHERE ID_NORMA = $idnorma AND N_GRUPO = $grupo AND ID_PROYECTO = $proyecto");
$statementEvaluador = oci_parse($objConnect, $SQL_EVALUADOR);
oci_execute($statementEvaluador);


if($auto_grupo > 0){
    $minimo = 10;
}else{
    $minimo = 20;
}


if ($total >= $minimo && $total <= 40) {
    if ($array_plan) {
        //Revicion de los candidatos en evidencias
        $SQL_evidencias = "SELECT EVIDENCIAS_CANDIDATO.ID_CANDIDATO, USUARIO.USUARIO_LOGIN FROM EVIDENCIAS_CANDIDATO INNER JOIN USUARIO ON EVIDENCIAS_CANDIDATO.ID_CANDIDATO = USUARIO.USUARIO_ID WHERE EVIDENCIAS_CANDIDATO.ID_PLAN = $array_plan[ID_PLAN] AND EVIDENCIAS_CANDIDATO.ID_NORMA = $idnorma";
        $statement = oci_parse($objConnect, $SQL_evidencias);
        oci_execute($statement);
        while ($array_evidencias = oci_fetch_array($statement, OCI_BOTH)) {
            $candidatos = ' AND id_candidato != ' . $array_evidencias[ID_CANDIDATO];
            $todos_candidatos = $todos_candidatos . $candidatos;
            if (!in_array($array_evidencias[ID_CANDIDATO], $perinv)) {
                $SQL_usu = ("SELECT USUARIO_LOGIN FROM USUARIO WHERE USUARIO_ID = '$array_evidencias[ID_CANDIDATO]'");
                $contador_candidatos_evidencias = 1;
                $mensaje_candidatos = $array_evidencias[USUARIO_LOGIN] . ", ";
                $todos_mensaje_candidatos = $todos_mensaje_candidatos . $mensaje_candidatos;
            }
        }
    }

    for ($i = 0; $i < $total; $i++) {
        $candidatos = ' AND id_candidato != ' . $perinv[$i];
        $todos_candidatos = $todos_candidatos . $candidatos;
    }

//Eliminacion de los candidatos del Grupo
    $delSQL = "DELETE FROM PROYECTO_GRUPO WHERE id_proyecto='$proyecto' AND id_norma='$idnorma' AND N_GRUPO = '$grupo'" . $todos_candidatos;
    $objParse = oci_parse($objConnect, $delSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);

    if ($objExecute) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
    }

//Agregar los nuevos candidatos al grupo
    for ($i = 0; $i < $total; $i++) {

        $query11 = ("select count(*) from proyecto_grupo where id_candidato='$perinv[$i]' and id_proyecto='$proyecto' and id_norma='$idnorma'");
        $statement11 = oci_parse($objConnect, $query11);
        oci_execute($statement11);
        $control = oci_fetch_assoc($statement11);

        if ($control['COUNT(*)'] < 1) {
            $strSQL = "INSERT INTO PROYECTO_GRUPO (ID_PROYECTO,N_GRUPO,ID_CANDIDATO,ID_NORMA,ID_EVALUADOR)
        VALUES ('$proyecto','$grupo','$perinv[$i]','$idnorma','$evaluador')";
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
    if ($contador_candidatos_evidencias == 0) {
        $mensaje = 1;
    } else {
        $mensaje = 3;
    }
} else {
    $mensaje = 2;
}
?>
<script type="text/javascript">
    window.location = "editar_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $grupo ?>&proyecto=<?php echo $proyecto ?>&mensaje=<?php echo $mensaje ?>&candidatos=<?php echo $todos_mensaje_candidatos; ?>";
</script>
