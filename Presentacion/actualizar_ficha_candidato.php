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
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

//usuario
$idc = $_GET['id'];
$tipodoc = $_POST["tipodoc"];
$documento = $_POST["documento"];
$expedicion = $_POST["expedicion"];
$libreta = $_POST["libreta"];
$papellido = $_POST["papellido"];
$sapellido = $_POST["sapellido"];
$nombre = $_POST["nombre"];
$fnacimiento = $_POST["fnacimiento"];
$deptonac = $_POST["deptonac"];
$municipionac = $_POST["municipio"];
$sexo = $_POST["sexo"];
$sangre = $_POST["sangre"];
$deptodom = $_POST["deptodom"];
$municipiodom = $_POST["municipio2"];
$barrio = $_POST["barrio"];
$domicilio = $_POST["domicilio"];
$telefono = $_POST["telefono"];
$celular = $_POST["celular"];
$estado = $_POST["estado"];
$estrato = $_POST["estrato"];
$escolaridad = $_POST["escolaridad"];
$email = $_POST["email"];

//--contacto
$cpapellido = $_POST["cpapellido"];
$csapellido = $_POST["csapellido"];
$cnombre = $_POST["cnombre"];
$cresidencia = $_POST["cresidencia"];
$ctelefono = $_POST["ctelefono"];
$ccelular = $_POST["ccelular"];
$cemail = $_POST["cemail"];
$cparentesco = $_POST["cparentesco"];

//--
$condicion_laboral = $_POST["claboral"];
$nit_empresa = $_POST["nit_empresa"];
$trabajador_sena = $_POST["trabajador_sena"];
$poblacion = $_POST["poblacion"];

$libreta = trim($libreta);

if (!preg_match("/\D{1,}/", $libreta)) {


    $SQLcertificacion = "SELECT COUNT(*) FROM CERTIFICACION WHERE ID_CANDIDATO='$idc'";
//echo $SQLcertificacion;
    $statementCertificacion = oci_parse($objConnect, $SQLcertificacion);
    $respCertificacion = oci_execute($statementCertificacion);
    $nCertificaciones = oci_fetch_array($statementCertificacion, OCI_BOTH);

    if ($nCertificaciones['COUNT(*)'] >= 1) {
        $campoCondicionales = " ";
    } else {
        $campoCondicionales = " TIPO_DOC='$tipodoc', DOCUMENTO='$documento',NOMBRE='$nombre',PRIMER_APELLIDO='$papellido',SEGUNDO_APELLIDO='$sapellido',";
    }

//actualizar persona

    if ($fnacimiento == NULL) {

        $strSQL3 = "UPDATE USUARIO 
        SET" . $campoCondicionales . " 
        EXPEDICION='$expedicion',
        LIBRETA_MILITAR='$libreta',
        DEPTO_NACIMIENTO='$deptonac',
        MUNICIPIO_NACIMIENTO='$municipionac',
        ID_SEXO='$sexo',
        ID_SANGUINEO='$sangre',
        DEPTO_RESIDENCIA='$deptodom',
        MUNICIPIO_RESIDENCIA='$municipiodom',
        BARRIO='$barrio',
        DIRECCION_RESIDENCIA='$domicilio',
        TELEFONO='$telefono',
        CELULAR='$celular',
        ID_ESTADO_CIVIL='$estado',
        ESTRATO='$estrato',
        ID_ESCOLARIDAD='$escolaridad',
        EMAIL='$email',
        CONDICION_LABORAL='$condicion_laboral',
        NIT_EMPRESA='$nit_empresa',
        ID_TIPO_TRABAJADOR_SENA='$trabajador_sena',
        ID_TIPO_POBLACION='$poblacion'
        WHERE USUARIO_ID='$idc'";
        $objParse3 = oci_parse($objConnect, $strSQL3);
        $objExecute3 = oci_execute($objParse3, OCI_DEFAULT);


        if ($objExecute3) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse3);
        }
    } else {
        $strSQL32 = "UPDATE USUARIO 
        SET" . $campoCondicionales . " 
        EXPEDICION='$expedicion',
        LIBRETA_MILITAR='$libreta',
        F_NACIMIENTO='$fnacimiento',
        DEPTO_NACIMIENTO='$deptonac',
        MUNICIPIO_NACIMIENTO='$municipionac',
        ID_SEXO='$sexo',
        ID_SANGUINEO='$sangre',
        DEPTO_RESIDENCIA='$deptodom',
        MUNICIPIO_RESIDENCIA='$municipiodom',
        BARRIO='$barrio',
        DIRECCION_RESIDENCIA='$domicilio',
        TELEFONO='$telefono',
        CELULAR='$celular',
        ID_ESTADO_CIVIL='$estado',
        ESTRATO='$estrato',
        ID_ESCOLARIDAD='$escolaridad',
        EMAIL='$email',
        CONDICION_LABORAL='$condicion_laboral',
        NIT_EMPRESA='$nit_empresa',
        ID_TIPO_TRABAJADOR_SENA='$trabajador_sena',
        ID_TIPO_POBLACION='$poblacion'
        WHERE USUARIO_ID='$idc'";


        $objParse32 = oci_parse($objConnect, $strSQL32);
        $objExecute32 = oci_execute($objParse32, OCI_DEFAULT);


        if ($objExecute32) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse32);
        }
    }


//valida si ya tiene registro en contacto sino actualiza
//---obtener id_munc_NAC
    $strSQL17 = "select count(*) from contacto_candidato where id_candidato='$idc'";
    $statement17 = oci_parse($objConnect, $strSQL17);
    $resp17 = oci_execute($statement17);
    $total = oci_fetch_array($statement17, OCI_BOTH);


    if ($total[0] < 1) {

        //Registrar contacto


        $strSQL5 = "INSERT INTO CONTACTO_CANDIDATO
        (
        ID_CANDIDATO,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        NOMBRE,
        DIRECCION,
        TELEFONO,
        CELULAR,
        EMAIL,
        PARENTESCO,
        USU_REGISTRO
        )
        VALUES (
        
        '$idc','$cpapellido','$csapellido','$cnombre','$cresidencia','$ctelefono','$ccelular','$cemail','$cparentesco','$id') ";


        $objParse5 = oci_parse($objConnect, $strSQL5);
        $objExecute5 = oci_execute($objParse5, OCI_DEFAULT);


        if ($objExecute5) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse5);
        }
    } else {


//Actualizar contacto


        $strSQL4 = "UPDATE CONTACTO_CANDIDATO 
        SET 
        PRIMER_APELLIDO='$cpapellido',
        SEGUNDO_APELLIDO='$csapellido',
        NOMBRE='$cnombre',
        DIRECCION='$cresidencia',
        TELEFONO='$ctelefono',
        CELULAR='$ccelular',
        EMAIL='$cemail',
        PARENTESCO='$cparentesco'
        WHERE ID_CANDIDATO='$idc'";


        $objParse4 = oci_parse($objConnect, $strSQL4);
        $objExecute4 = oci_execute($objParse4, OCI_DEFAULT);


        if ($objExecute4) {
            oci_commit($objConnect); //*** Commit Transaction ***//
        } else {
            oci_rollback($objConnect); //*** RollBack Transaction ***//
            $e = oci_error($objParse4);
        }
    }

    echo("<SCRIPT>window.alert(\"Datos Actualizados\")</SCRIPT>");

    oci_close($objConnect);

} else {
    echo("<SCRIPT>window.alert(\"El la libreta militar solo debe contener números\")</SCRIPT>");
}
?>
<script type="text/javascript">
    window.location = "../Presentacion/actualizar_ficha.php?id=<?php echo $idc ?>";
</script>