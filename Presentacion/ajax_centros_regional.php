<?php

include("../Clase/conectar.php");
extract($_POST);
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$queryCentros = "SELECT * "
        . "FROM CENTRO "
        . "WHERE CODIGO_REGIONAL = $codigo_regional";
$statementCentros = oci_parse($connection, $queryCentros);
oci_execute($statementCentros);
?>
<option value="0">-- Seleccione --</option>
<?php while ($centros = oci_fetch_array($statementCentros, OCI_BOTH)) { ?>
    <option value="<?php echo $centros['CODIGO_CENTRO'] ?>"><?php echo $centros['CODIGO_CENTRO'] . " - " . utf8_encode($centros['NOMBRE_CENTRO']) ?></option>
<?php } ?>