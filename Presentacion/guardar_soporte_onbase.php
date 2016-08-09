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

$idarea = $_POST["id"];
$centro= $_GET['centro'];

$status = "";

if ($_POST["action"] == "upload") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    //    $prefijo = substr(md5(uniqid(rand())),0,6);
    

    if ($archivo != "") {

// guardamos el archivo a la carpeta files
    $destino = "onbase/" . $documento.$archivo;

        if (copy($_FILES['archivo']['tmp_name'], $destino )) {
            $status = "Archivo subido: <b>" . $archivo . "</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }
}


//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO RESPUESTA_AREAS_CLAVES
        (
        ID_AREA,
        SOPORTE,
        ID_USUARIO
        )
        VALUES (
        
        '$idarea','$destino','$id') ";


$objParse1 = oci_parse($connection, $strSQL1);
$objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
if($objExecute1)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse1); 
	echo "Error Save [".$e['message']."]";
}


oci_close($connection);

?>

<script type="text/javascript">
    window.location = "../Presentacion/consultar_areas_n.php?centro=<?php echo $centro ?>&idarea=<?php echo $idarea ?>";
</script>