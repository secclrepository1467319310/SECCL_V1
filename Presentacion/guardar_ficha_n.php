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

//info especial
$tcaract = $_POST['tcaract'];
$tgeo = $_POST['tgeo'];
$pgremio = $_POST['pgremio'];
$gremio = $_POST['gremio'];
$pasoc = $_POST['pasoc'];
$asoc = $_POST['asoc'];
//info empresa
$tid = $_POST['tid'];
$nit = $_POST['nit'];
$tam = $_POST['tam'];
$empleados = $_POST['empleados'];
$razon = $_POST['razonsoc'];
$sigla = $_POST['sigla'];
$direm = $_POST['direccion_e'];
$depto = $_POST['departamento'];
$munc = $_POST['municipio'];
$rep = $_POST['representante'];
$emailrep = $_POST['email_rep'];
$tele = $_POST['tel_e'];
$clasif = $_POST['clasificacion'];
$sector = $_POST['sector'];
$tipo_e = $_POST['tipo_e'];
//informacion del coordinador
$tdoc = $_POST['tdoc'];
$documento = $_POST['documento'];
$nombres = $_POST['nombres'];
$ape = $_POST['papellido'];
$ape2 = $_POST['sapellido'];
$direccion = $_POST['direccion'];
$cargo = $_POST['cargo'];
$tel = $_POST['tel'];
$cel = $_POST['cel'];
$email = $_POST['email'];

$query8 = ("SELECT count(*) from empresas_sistema where nit_empresa='$nit'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0]>0) {
echo("<SCRIPT>window.alert(\"Empresa Ya Registrada\")</SCRIPT>");

?>
<script type="text/javascript">
        window.location = "../Presentacion/asociar_ncl_n.php?plan=<?php echo $plan?>";
</script>
<?php
}else { 
    
    $strSQL = "INSERT INTO EMPRESAS_SISTEMA
        (
        TIPO_IDENTIFICACION,
        NIT_EMPRESA,
        NOMBRE_EMPRESA,
        TAM_EMPRESA,
        NUM_EMPLEADOS,
        SIGLA_EMPRESA,
        DIRECCION,
        ID_DEPARTAMENTO,
        ID_MUNICIPIO,
        TELEFONO,
        GERENTE,
        EMAIL_GERENTE,
        CLASIFICACION,
        SECTOR_ECONOMICO,
        TIPO_EMPRESA,
        TIPO_CARACTERISTICA,
        TIPO_SEDE_E,
        P_GREMIO,
        NIT_GREMIO,
        P_ASOCIACION,
        NIT_ASOCIACION,
        USU_REGISTRO
        
        )
        VALUES (
        
        '$tipo_e','$nit','$razon','$tam','$empleados','$sigla','$direm','$depto','$munc','$tel',"
            . "'$rep','$emailrep','$clasif','$sector','$tipo_e','$tcaract','$tgeo','$pgremio','$gremio',"
            . "'$pasoc','$asoc','$id') ";
    
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
//-----------------------------------------------------------------------------
$strSQL2 = "INSERT INTO COORDINADOR_PROYECTOS
        (
        NIT_EMPRESA,
        TIPO_DOC,
        DOCUMENTO,
        NOMBRES,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        DIRECCION,
        CARGO,
        TELEFONO,
        CELULAR,
        EMAIL
        )
        VALUES (
        
        '$nit','$tdoc','$documento','$nombres','$ape','$ape2','$direccion','$cargo','$tel','$cel','$email') ";
    
    $objParse2 = oci_parse($connection, $strSQL2);
$objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
if($objExecute2)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse2); 
	echo "Error Save [".$e['message']."]";
}

oci_close($connection);
}
    ?>

<script type="text/javascript">
    window.location = "../Presentacion/ficha_empresa_n.php";
</script>
