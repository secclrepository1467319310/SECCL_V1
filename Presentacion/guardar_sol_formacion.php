<?php

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$regional = $_POST["regional"];
$centro = $_POST["centro"];
$documento = $_POST["documento"];
$priapellido = $_POST["priapellido"];
$segapellido = $_POST["segapellido"];
$nombres =$_POST["nombres"];
$email = $_POST["email"];
$pass = $_POST["pass"];
$fn = $_POST["fn"];
$lugarn = $_POST["lugarn"];
$fe = $_POST["fe"];
$lugare = $_POST["lugare"];
$op = $_POST["op"];

$query1 = ("select count(*) from curso_ev 
where (documento='$documento' or email='$email') AND (EXTRACT (YEAR FROM TO_DATE(SUBSTR(FECHA_REGISTRO,0,10),'DD/MM/YYYY') )= '2016' AND FECHA_REGISTRO IS NOT NULL)");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$total = oci_fetch_array($statement1, OCI_BOTH);

$status = "";

if ($_POST["action"] == "upload") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    //    $prefijo = substr(md5(uniqid(rand())),0,6);
    

    if ($archivo != "") {

// guardamos el archivo a la carpeta files
    $destino = "hv/" . $documento.$archivo;

        if (copy($_FILES['archivo']['tmp_name'], $destino )) {
            $status = "Archivo subido: <b>" . $archivo . "</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }
}

if ($total[0]>0 || $documento==null || $documento=='') {
    echo("<SCRIPT>window.alert(\"Usuario ya Registrado,Por Favor Verifique Documento\")</SCRIPT>");
?>
    <script type="text/javascript">
        window.location = "./formacion_ev_c.php";
    </script>
<?php
}else{
//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO CURSO_EV
        (
        CODIGO_REGIONAL,
        ID_CENTRO,
        DOCUMENTO,
        PRIAPELLIDO,
        SEGAPELLIDO,
        NOMBRE,
        EMAIL,
        PASS,
        FECHA_NACIMIENTO,
        LUGAR_NACIMIENTO,
        FECHA_EXPEDICION,
        LUGAR_EXPEDICION,
        HV,
        TIPO_EVALUADOR
        )
        VALUES (
        
        '$regional','$centro','$documento','$priapellido','$segapellido','$nombres','$email','$pass','$fn','$lugarn','$fe','$lugare','$destino','$op') ";


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
}

oci_close($connection);



echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
?>

<script type="text/javascript">
    window.location = "./formacion_ev_c.php";
</script>