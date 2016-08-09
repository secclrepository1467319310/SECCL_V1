<?php
// Recibiendo los datos pasados por la pagina "form_contato.php"
include("../Clase/conectar.php");

$connection = conectar($bd_host, $bd_usuario, $bd_pwd);


$nombres = strtoupper($_POST["nombre"]);
$p_apellido = strtoupper($_POST["apellido"]);
$s_apellido = strtoupper($_POST["segapellido"]);
$t_documento = $_POST["t_doc"];
$documento = $_POST["documento"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];
$pass = $_POST["contra"];
//---------empresarial
$tusu = $_POST["tusu"];
$cargo = $_POST["cargo"];
$nit = $_POST["nit_empresa"];
$nom = $_POST["nombre_empresa"];

$documento=str_replace(' ', '', $documento);
if($t_documento==2){
    $documento= preg_replace("/[a-zA-z\-\s\_]/", '', $documento);
}

$query1 = ("select documento, email, usuario_login from usuario 
where documento='$documento' or email='$email' or usuario_login='$nit' ");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$usuario = oci_fetch_array($statement1, OCI_BOTH);

if ($nom == 'Empresa no Registrada') {
    echo("<SCRIPT>window.alert(\"Verificar Empresa\")</SCRIPT>");
    ?>
    <script type="text/javascript">
        window.location = "../index.php";
    </script>
    <?php
}

if ($nombres == '' || $p_apellido == null) {
    echo("<SCRIPT>window.alert(\"Por Favor Ingrese la Información\")</SCRIPT>");
    ?>
    <script type="text/javascript">
        window.location = "../index.php";
    </script>
    <?php
}

if ($usuario) {
    if ($usuario['USUARIO_LOGIN'] == $documento) {
        echo("<SCRIPT>window.alert(\"No es posible registrar al usuario debido a que el documento: $documento ya se encuentra registrado en el sistema.\")</SCRIPT>");
    }else if(strtolower ($usuario['EMAIL']) == strtolower($email)){
         echo("<SCRIPT>window.alert(\"No es posible registrar al usuario debido a que el email: $email ya se encuentra registrado en el sistema.\")</SCRIPT>");
    }
    ?>
    <script type="text/javascript">
        window.location = "../index.php";
    </script>
    <?php
} else if ($tusu == 10) {

    $strSQL = "INSERT INTO USUARIO
        (USUARIO_LOGIN,USUARIO_PASSWORD,NOMBRE,PRIMER_APELLIDO,SEGUNDO_APELLIDO,TIPO_DOC,DOCUMENTO,TELEFONO,EMAIL,DIRECCION_RESIDENCIA,ROL_ID_ROL,ESTADO,APROBADO)
        VALUES ('$documento','$pass','$nombres','$p_apellido','$s_apellido','$t_documento','$documento','$telefono','$email','$direccion','10','1','1')";

    $objParse = oci_parse($connection, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
        echo "Error Save [" . $e['message'] . "]";
    }

    oci_close($connection);
} else if ($tusu == 9) {

    $strSQL = "INSERT INTO USUARIO
        (USUARIO_LOGIN,USUARIO_PASSWORD,NOMBRE,PRIMER_APELLIDO,SEGUNDO_APELLIDO,TIPO_DOC,DOCUMENTO,EMAIL,NIT_EMPRESA,ROL_ID_ROL,ESTADO,CARGO)
        VALUES ('$nit','$pass','$nombres','$p_apellido','$s_apellido','$t_documento','$documento','$email','$nit','9','1','$cargo')";

    $objParse = oci_parse($connection, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
        echo "Error Save [" . $e['message'] . "]";
    }

    oci_close($connection);
}
echo("<SCRIPT>window.alert(\"Registro Exitoso, por favor Revise su correo\")</SCRIPT>");
?>
<!--    <script type="text/javascript">
    window.location="/index.php";
</script>-->

<script type="text/javascript">
    window.location = "http://10.0.1.2/seccl/Presentacion/enviocorreo2.php?sapellido=<?php echo $s_apellido ?>&apellido=<?php echo $p_apellido ?>&nombre=<?php echo $nombres ?>&correo=<?php echo $email ?>&usuario=<?php echo $documento ?>&pass=<?php echo $pass ?>";
</script>