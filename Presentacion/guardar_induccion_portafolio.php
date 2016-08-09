<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

$proyecto=$_GET['proyecto'];
$lim_tam = "4096000";
$t_doc = $_POST['tipodoc'];
$lob_description = $_POST['lob_description'];
$lob_upload_name = $_FILES['lob_upload']['name'];
$lob_upload_size = $_FILES['lob_upload']['size'];
$lob_upload_type = $_FILES['lob_upload']['type'];
$lob_upload = $_FILES['lob_upload']['tmp_name'];

if ($_FILES['lob_upload']['type'] == "image/jpeg" || $_FILES['lob_upload']['type'] == "image/gif" || $_FILES['lob_upload']['type'] == "image/png" || $_FILES['lob_upload']['type'] == "application/pdf") {

if($_FILES['lob_upload']['error']==1){
print "
	<script>
	alert('El Archivo supera el límite de tamaño, por favor seleccione un archivo diferente.')
	document.location.href='adicionar_p_l.php'
	</script>
	";
}else if($lob_upload_size>$lim_tam){
print "
	<script>
	alert('El Archivo supera el límite de tamaño, por favor seleccione un archivo diferente.')
	document.location.href='adicionar_p_l.php'
	</script>
	";
} else if($_FILES['lob_upload']['error']!=0){
print "
	<script>
	alert('Error de Archivo, el archivo no se puede subir.')
	document.location.href='adicionar_p_l.php'
	</script>
	";
}
else {

//Aqui se establece la conexion con una base de datos oracle.
include("../Clase/conectar.php");
$conn = conectar($bd_host, $bd_usuario, $bd_pwd);



/*Inicializa un nuevo descriptor vacío LOB/FILE (LOB por defecto)
Reserva espai per mantenir descriptors o localitzadors LOB. Els valors valids pel tipus type son
OCI_D_FILE, OCI_D_LOB, OCI_D_ROWID. Per descriptors LOB, els metodes LOAD, SAVE, i SAVEFILE estan associats
amb el descriptor, per BFILE només existeix el mètode LOAD*/
$lob = OCINewDescriptor($conn, OCI_D_LOB);

//Preparem la consulta SQL(INSERT) capaç d'introduir els valors a la base de dades.
$stmt = OCIParse($conn,"INSERT INTO PORTAFOLIO_PROCESO "
        . "(id_proyecto,tipo_documento,descripcion,bin_data,filename,filesize,filetype,id_usuario) "
        . "VALUES ('$proyecto','$t_doc','$lob_description',EMPTY_BLOB(),'$lob_upload_name','$lob_upload_size','$lob_upload_type','$id') returning BIN_DATA into :the_blob");

/* Enlaza una variable PHP a un Placeholder de Oracle
Enllaça la variable PHP variable a un placeholder d'ORACLE ph_name. Si aquesta serà usada per entrada o
o sortida es determinarà en temps d'execució, i serà reservat l'espai necessari d'emmagatzemament. El
parametre lenght estableix el tamany màxim de l'enllaç. Si s'estableix length a -1 OCIBindByName utilitzarà
el tamany de la variable per establir el tamany màxim.
EN LA ULTIMA PRUEBA QUE SE REALIZÓ EL 07/01/2011 ESTE VALOR $LOB VENÍA PASADO POR REFERENCIA &$LOB NO OBSTANTE ESTO ES UN ERROR EN ESTE CASO
*/
OCIBindByName($stmt, ':the_blob',$lob, -1, OCI_B_BLOB);

//Ejecucion de la sentencia.
OCIExecute($stmt, OCI_DEFAULT);
if($lob->savefile($lob_upload))
{
OCICommit($conn);
echo "Documento Cargado Exitosamente\n<br>";
echo "<a href=subir_induccion_ev.php?proyecto=$proyecto>Ver Documentos</a>";
}
else
{
echo "Archivo No Cargado\n";
}
OCIFreeStatement($stmt);
OCILogoff($conn);
}}else{
    echo "Documento No Cargado \n<br>";
echo "<a href=subir_induccion_ev.php?proyecto=$proyecto>Volver</a>";
}
?>