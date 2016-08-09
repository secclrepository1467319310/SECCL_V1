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

$proyecto = $_GET['proyecto'];


//actualizo el estado del instrumento
$strSQL1 = "INSERT INTO INDUCCION
        (ID_PROYECTO,ID_USU_REGISTRO,INDUCCION_CERRADA)
        VALUES 
        ('$proyecto','$id','1') ";


$objParse1 = oci_parse($connection, $strSQL1);
$objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
if ($objExecute1) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse1);
    echo "Error Save [" . $e['message'] . "]";
}

echo("<SCRIPT>window.alert(\"Sensibilizacion Formalizada\")</SCRIPT>");

//formalizar a las personas

$query2 = ("SELECT documento FROM usuario where usuario_id =  '$id'");
$statement2 = oci_parse($connection, $query2);
$resp2 = oci_execute($statement2);
$doceva = oci_fetch_array($statement2, OCI_BOTH);

$query9 = ("select ID_INDUCCION from induccion where id_proyecto='$proyecto'");
$statement9 = oci_parse($connection, $query9);
$resp9 = oci_execute($statement9);
$idind = oci_fetch_array($statement9, OCI_BOTH);



    $query = "SELECT usuario.usuario_id,candidatos_proyecto.id_candidatos_proyecto,
        candidatos_proyecto.id_norma
FROM usuario
INNER JOIN candidatos_proyecto 
ON candidatos_proyecto.id_candidato = usuario.usuario_id
WHERE candidatos_proyecto.id_proyecto = '$proyecto' ";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);
    $numero = 0;
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {

        $q2 = "INSERT INTO INDUCCION_CANDIDATO (ID_INDUCCION,ID_CANDIDATO_PROYECTO,ID_CANDIDATO,ID_NORMA,ID_PROYECTO) "
                . "VALUES "
                . "('$idind[0]','$row[ID_CANDIDATOS_PROYECTO]','$row[USUARIO_ID]','$row[ID_NORMA]','$proyecto') ";
        $statement2 = oci_parse($connection, $q2);
        oci_execute($statement2);

        $numero++;
    }
    
oci_close($connection);
?>
<script type="text/javascript">
    window.location = "../Presentacion/gen_induccion.php?proyecto=<?php echo $proyecto ?>";
</script>