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


$idnorma = $_GET['idnorma'];
$proyecto = $_POST["proyecto"];
//$grupo = $_POST["grupo"];
$evaluador = $_POST["evaluador"];
$perinv = $_POST["usuario"];
$auto_grupo = $_POST["auto_grupo"];
$auto_grupo2 = $_POST["auto_grupo2"];




//Consultamos el último grupo, le agregamos 1 evitar posible xss sobre campo grupo

$query35 = ("select max(n_grupo) from proyecto_grupo where id_proyecto='$proyecto' and id_norma='$idnorma'");
$statement35 = oci_parse($objConnect, $query35);
$resp35 = oci_execute($statement35);
$grupo = oci_fetch_array($statement35, OCI_NUM);
$grupo = $grupo[0];
$grupo++;


if ($auto_grupo > 0) {
    $minimo = 10;
} else {
    $minimo = 20;
}

if ($auto_grupo2 > 0) {
    $minimo = 5;
}
$total = count($perinv);
$idCandidatos = implode("','", $perinv);
if ($total < $minimo || $total > 40) {
    header("location:crear_grupo.php?norma=$idnorma&proyecto=$proyecto&error=1");
} else {
    $qRevisarCandidatos = "SELECT COUNT(*)cnt  FROM proyecto_grupo WHERE id_proyecto='$proyecto' AND id_norma='$idnorma' AND id_candidato IN ('$idCandidatos')";
    $sRevisarCandidatos = oci_parse($objConnect, $qRevisarCandidatos);
    oci_execute($sRevisarCandidatos);
    $rRevisarCandidatos = oci_fetch_array($sRevisarCandidatos, OCI_ASSOC);
    if ($rRevisarCandidatos["CNT"] > 0) {
        $grupo--;
        echo "<script>alert('El grupo ya está creado');</script>";
        echo "<script>window.location = \"../Presentacion/cronograma_grupo.php?norma=$idnorma&grupo=$grupo&proyecto=$proyecto\"</script>";
        die();
    }
    for ($i = 0; $i < $total; $i++) {

        $strSQL = "INSERT INTO PROYECTO_GRUPO (ID_PROYECTO,N_GRUPO,ID_CANDIDATO,ID_NORMA,ID_EVALUADOR)
        VALUES ('$proyecto','$grupo','$perinv[$i]','$idnorma',$evaluador)";



        $objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);


        if ($objExecute) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse);
        }
    }
    /////////////////
    if (!is_null($_POST["seg_intento"])) {
        $segIntento = implode("','", $_POST["seg_intento"]);
        $qSegundoIntento = "UPDATE proyecto_grupo SET seg_intento='1'  WHERE id_proyecto='$proyecto' AND n_grupo='$grupo' AND ID_NORMA='$idnorma' AND id_candidato IN ('$segIntento')";
        $sSegundoIntento = oci_parse($objConnect, $qSegundoIntento);
        if (oci_execute($sSegundoIntento)) {
            echo "<script>alert('Se registraron los segundos intentos');</script>";
        } else {
            echo "<script>alert('Ocurrió un error');</script>";
        }
    }
//    die();
    ////////////////////
}
oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/cronograma_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $grupo ?>&proyecto=<?php echo $proyecto ?>";
</script>