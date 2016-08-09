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
extract($_POST);

require_once('../Clase/conectar.php');
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$qvalidardocumento="SELECT * FROM USUARIO WHERE ROL_ID_ROL!=6 AND DOCUMENTO='$documento'";
$svalidardocumento=oci_parse($connection,$qvalidardocumento);
oci_execute($svalidardocumento);
$rvalidardocumento=oci_fetch_array($svalidardocumento,OCI_ASSOC);
$location= $_SERVER[HTTP_REFERER];


if(!$rvalidardocumento){
    $qinsertarauditores="INSERT INTO T_DIREC_AUDITORES "
    . "(CODIGO_CENTRO, AUDITOR_INTERNO,TIPO_DOCUMENTO, DOCUMENTO_AUDITOR, TELEFONO, IP, TELEFONO_MOVIL, TIPO_VINCULACION, CARGO_GRADO, NUMERO_CONTRATO, FECHA_CONTRATO, EMAIL_SENA, EMAIL_ALTERNO, N_CERTIFICADO, FECHA_CERTIFICACION, CERTIFICADO_ISO19011, FECHA_CERTIFICACION_ISO19011, ENTIDAD_CERTIFICADORA, FECHA_AUDITORIA, FECHA_AUDITORIA_2, OBSERVACIONES) "
    . "VALUES"
    . "('$centro','$auditor','$t_documento','$documento','$telefono','$ip','$telefonomovil','$t_vinculacion','$cargo_grado','$numero_contrato','$fechacontrato','$emailsena','$emailalterno','$ncertificado','$fechacertificacion','$certificadoiso19011','$fechacertificadoiso19011','$entidadcertificadora','$fechaauditoria','$fechaauditoria2','$observaciones')";

    $sinsertarauditores= oci_parse($connection, $qinsertarauditores);
    if(oci_execute($sinsertarauditores)){
        echo "<script>alert('Éxito al guardar');</script>";
    }
    else{
        $e=oci_error($connection);
        echo "<script>"
                . "alert('Error  al guardar, $e[message]]');"
                . "location.href='$location?prueba=1';"
            . "</script>";
        $location.="?prueba=1";
        
    }
}
else{
    echo "<script>"
            . "alert('El auditor no esta registrado');"
            . "location.href='$location?prueba=2';"
        . "</script>";
    
    
    
}
echo "<script>location.href='$location?prueba=2';</script>";


?>
