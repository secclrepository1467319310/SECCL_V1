<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$q = $_POST['q'];
$munc=$_POST['munc'];


$query2 = ("SELECT * FROM MUNICIPIO WHERE ID_DEPARTAMENTO='$q'");
$statement2 = oci_parse($connection, $query2);
oci_execute($statement2);

?>

<select name="municipio">

    <?php while ($row = oci_fetch_array($statement2, OCI_BOTH)) { ?>
    <?php 
        $selected="";
        if($munc==utf8_encode($row["NOMBRE_MUNICIPIO"])){
            $selected="selected";
        }
        ?>
    <option  <?=$selected?>  <?=$munc?> value="<?PHP echo $row[ID_MUNICIPIO] ?>" ><?php echo utf8_encode($row["NOMBRE_MUNICIPIO"]); ?></option>
    <?php } ?>

</select>

