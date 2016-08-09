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
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
//var_dump($_POST);
if($_POST[Observacion]==null){
    echo 'El campo es nulo';
}else{
    $_POST[Observacion]=  str_replace("'"," " , $_POST[Observacion]);
    $QInsert = ("INSERT INTO  T_OBSERV_BANCO_SOLIC "
            . "(ID_SOLICITUD,USUARIO_REGISTRO,OBSERVACION) "
            . "VALUES "
            . "('$_POST[Id_solicitud]','$id','$_POST[Observacion]')");
    
    
    
    $statement3 = oci_parse($connection, $QInsert);
    $resp3 = oci_execute($statement3);
    //echo $QInsert;
    if($resp3==true){
      echo "Éxito al guardar";  
    }
    else{
      echo "No Éxito al guardar";  
    }
}
?>
