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

$proyecto=$_GET['proyecto'];
$tdoc=$_POST['tdoc'];
$documento=$_POST['documento'];
$nombres=$_POST['nombre'];
$ape=$_POST['apellido'];
$sape=$_POST['apellido2'];
$cel=$_POST['cel'];
$email=$_POST['email'];

$query1 = ("select count(*) from usuario 
where documento='$documento' or email='$email'");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$total = oci_fetch_array($statement1, OCI_BOTH);


echo $proyecto;
if ($total[0]>0) {
    echo("<SCRIPT>window.alert(\"Usuario Ya registrado\")</SCRIPT>");
?>
    <script type="text/javascript">
        window.location = "./registrar_ev.php";
    </script>
    <?php
}else{


$strSQL = "INSERT INTO USUARIO
        (
        TIPO_DOC,
        DOCUMENTO,
        NOMBRE,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        CELULAR,
        EMAIL,
        USUARIO_LOGIN,
        USUARIO_PASSWORD,
        ESTADO,
        ROL_ID_ROL
        
        )
        VALUES (
        
        '$tdoc','$documento','$nombres','$ape','$sape','$cel',"
            . "'$email','$documento','$documento','5','7') ";
    
    $objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if($objExecute)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse); 
	echo "Error Save [".$e['message']."]";
}
}
oci_close($connection);

    ?>

<script type="text/javascript">
    window.location = "../Presentacion/evaluadores_proyecto_c.php?proyecto=<?php echo $proyecto?>";
</script>