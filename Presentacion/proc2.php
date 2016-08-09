<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$q = $_POST['q'];


$query2 = ("SELECT * FROM NORMA WHERE CODIGO_MESA='$q'");
$statement2 = oci_parse($connection, $query2);
oci_execute($statement2);

?>

<select name="municipio" style=" width:100px">

    <?php while ($row = oci_fetch_array($statement2, OCI_BOTH)) { ?>
    <option value="<?PHP echo $row ["ID_NORMA"] ?>" ><?php echo $row["CODIGO_NORMA"].' - '. utf8_encode($row["TITULO_NORMA"]); ?></option>
    <?php } ?>

</select>

