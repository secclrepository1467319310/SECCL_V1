<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$documento = $_POST["documento"];

$query1 = ("select count(*) from curso_ev 
where documento='$documento'");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$total = oci_fetch_array($statement1, OCI_BOTH);

$query12 = ("select priapellido from curso_ev 
where documento='$documento'");
$statement12 = oci_parse($connection, $query12);
$resp12 = oci_execute($statement12);
$pape = oci_fetch_array($statement12, OCI_BOTH);

$query13 = ("select segapellido from curso_ev 
where documento='$documento'");
$statement13 = oci_parse($connection, $query13);
$resp13 = oci_execute($statement13);
$sape = oci_fetch_array($statement13, OCI_BOTH);

$query14 = ("select nombre from curso_ev 
where documento='$documento'");
$statement14 = oci_parse($connection, $query14);
$resp14 = oci_execute($statement14);
$nom = oci_fetch_array($statement14, OCI_BOTH);

$query15 = ("select email from curso_ev 
where documento='$documento'");
$statement15 = oci_parse($connection, $query15);
$resp15 = oci_execute($statement15);
$ema = oci_fetch_array($statement15, OCI_BOTH);
?>
<div id="Resultado">
                <?php
                
                
                if($total[0]==0){
                 ?>
                <h2><label style="color: #cd0a0a">Usuario No Registrado</label></h2>
                <?php
                }else {
                    ?>
                <h2><label style="color: #23838b">Usuario Registrado</label></h2>
                <br><br>
                <table>
                    <tr><td>Nombre</td><td><?php echo $nom[0]; ?></td></tr>
                    <tr><td>Primer Apellido</td><td><?php echo $pape[0]; ?></td></tr>
                    <tr><td>Segundo Apellido</td><td><?php echo $sape[0]; ?></td></tr>
                    <tr><td>Email</td><td><?php echo $ema[0]; ?></td></tr>
                    <tr><td>Documento</td><td><?php echo $documento; ?></td></tr>
                </table>
                <?php
                }
                ?>
</div>
<br>
<center><a href="formacion_ev_c.php">Volver</a></center>