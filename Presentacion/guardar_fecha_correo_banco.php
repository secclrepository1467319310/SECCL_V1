<?php

session_start();
if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

extract($_POST);

echo '<pre>';
var_dump($_POST);
echo '</pre>';

for ($i = 0; $i < count($chkCorreo); $i++)
{

    echo '<br><br>' . $insert = "INSERT INTO T_FECHA_CORREO_BANCO(
    ID_ESTADO_SOLICITUD,
    USU_REGISTRO
    ) VALUES(
    '$chkCorreo[$i]',
    '$_SESSION[USUARIO_ID]'
    )";

    $objParse = oci_parse($objConnect, $insert);
    $objExecute = oci_execute($objParse);

    if ($objExecute)
    {
        oci_commit($objConnect); //*** Commit Transaction ***//
        if (isset($_GET['redirec']) && $_GET['redirec'] == 1)
        {
            if ($_GET['id'] == 1)
            {
                header('location: ver_atendidas_banco.php');
            }
            else if ($_GET['id'] == 2)
            {
                header('location: ver_devueltas_banco.php');
            }
        }
        else
        {
            if ($_GET['id'] == 1)
            {
                header('location: ver_atendidas_banco_asesor.php');
            }
            else if ($_GET['id'] == 2)
            {
                header('location: ver_devueltas_banco_asesor.php');
            }
        }
    }
    else
    {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
    }
}
oci_close($objConnect);