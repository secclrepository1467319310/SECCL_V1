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

$proyecto=$_GET["proyecto"];
$documento=$_POST['documento'];
$nombres=$_POST['nombres'];
$ape=$_POST['pri_apellido'];
$sape=$_POST['seg_apellido'];
$email=$_POST['email'];
$email2=$_POST['email2'];
$cel=$_POST['cel'];
$tel=$_POST['tel'];

$status = "";

if ($_POST["action"] == "upload") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    //    $prefijo = substr(md5(uniqid(rand())),0,6);

    if ($archivo != "") {
        // guardamos el archivo a la carpeta files
        $destino = "hoja/" . $archivo;

        if (copy($_FILES['archivo']['tmp_name'], $destino)) {
            $status = "Archivo subido: <b>" . $archivo . "</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }
}


    $strSQL = "INSERT INTO CONSTRUCTOR_ITEMS
        (
        
        NOMBRE,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        DOCUMENTO,
        CELULAR,
        CORREO,
        CORREO2,
        TELEFONO,
        HVIDA,
        ID_PROYECTO
        
        )
        VALUES (
        
        '$nombres','$ape','$sape','$documento','$cel','$email','$email2','$tel','$destino','$proyecto') ";
    
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

oci_close($connection);

    ?>

<script type="text/javascript">
    window.location = "../Presentacion/cronogramai_proyecto_c.php?proyecto=<?php echo $proyecto?>";
</script>
