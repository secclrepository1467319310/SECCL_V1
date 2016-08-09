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
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$regional = $_POST["regional"];
$centro = $_POST["centro"];
$tdoc = $_POST["tdoc"];
$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$ip = $_POST["ip"];
$celular = $_POST["celular"];
$email = $_POST["email"];
$email2 = $_POST["email2"];
$certificado = $_POST["certificado"];
$numcerti = $_POST["num_certificado"];
$fecha_certifica = $_POST["fecha_certificado"];
$activo = $_POST["activo"];
$fecha_proceso = $_POST["fecha_proceso"];
$obs = $_POST["obs"];
$te = $_POST["te"];
$em = $_POST["em"];

$query8 = ("SELECT count(*) from evaluador where documento='$documento'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0] > 0) {
    echo("<SCRIPT>window.alert(\"Evaluador Ya Registrado\")</SCRIPT>");
    ?>
    <script type="text/javascript">
        window.location = "../Presentacion/registrar_actores.php";
    </script>
    <?php

} else {
    $queryUsuario = ("SELECT COUNT(*)AS REGISTROS FROM USUARIO WHERE DOCUMENTO = '$documento'");
    $rowSelect = oci_parse($connection, $queryUsuario);
    oci_execute($rowSelect);
    $numUsuarios = oci_fetch_array($rowSelect, OCI_BOTH);

    if ($numUsuarios['REGISTROS'] > 0) {
        echo("<SCRIPT>window.alert(\"El evaluador se encuentra registrado con otro rol\")</SCRIPT>");
        ?>
        <script type="text/javascript">
            window.location = "../Presentacion/registrar_actores.php";
        </script>
        <?php

    } else {

//actualizo el estado del instrumento
        $strSQL1 = "INSERT INTO EVALUADOR
        (CODIGO_REGIONAL,
        CODIGO_CENTRO,
        T_DOCUMENTO,
        DOCUMENTO,
        NOMBRE,
        IP,
        CELULAR,
        EMAIL,
        EMAIL2,
        CERTIFICADO,
        N_CERTI,
        FECHA_CERTIFICA,
        ACTIVO,
        FECHA_PROCESO,
        OBS,
        USU_REGISTRO,
        TE,
        EMPRESA,
        ESTADO_EVALUADOR)
        VALUES 
        ('$regional','$centro','$tdoc','$documento','$nombres','$ip','$celular','$email','$email2',
        '$certificado','$numcerti','$fecha_certifica','$activo','$fecha_proceso','$obs','$id','$te','$em','3') ";


        $objParse1 = oci_parse($connection, $strSQL1);
        $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
        if ($objExecute1) {
            oci_commit($connection); //*** Commit Transaction ***//
        } else {
            oci_rollback($connection); //*** RollBack Transaction ***//
            $e = oci_error($objParse1);
            echo "Error Save [" . $e['message'] . "]";
        }
        
        oci_close($connection);


        echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
        ?>
        <script type="text/javascript">
            window.location = "../Presentacion/menulider.php";
        </script>
        <?php

    }
}