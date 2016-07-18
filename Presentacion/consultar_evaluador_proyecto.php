<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$documento = $_POST["doc"];

$query1 = ("select count(*) from evaluador_proyecto where id_evaluador='$documento'");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$total = oci_fetch_array($statement1, OCI_BOTH);

?>
    <script type="text/javascript">
        window.location = "cons_proyecto_n.php?t=<?php echo $total[0] ?>";
    </script>