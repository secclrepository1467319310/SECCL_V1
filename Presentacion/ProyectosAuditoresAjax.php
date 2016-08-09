<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}


 //   die("entramos");
//var_dump($_POST);
if($_POST[v1]=="prueba"){
    require_once('../Clase/conectar.php');
    $_gcentro=$_POST[currentcentro];
    $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
    $centro="SELECT * FROM CENTRO WHERE CODIGO_REGIONAL=$_POST[regional]";
    $scentro= oci_parse($connection, $centro);
    oci_execute($scentro);
    $devolver="";
    while($rcentro = oci_fetch_array($scentro, OCI_ASSOC)){
        $devolver.="<option value=\"$rcentro[CODIGO_CENTRO]\"  ".($rcentro[CODIGO_CENTRO]==$_gcentro?"selected":"").">$rcentro[CODIGO_CENTRO]-".utf8_encode($rcentro[NOMBRE_CENTRO])."</option>";
    }
    echo $devolver;
    die();
}
?>
