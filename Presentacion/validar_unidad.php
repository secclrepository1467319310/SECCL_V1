<?php
$poa=$_GET["poa"];
$unidad = $_GET["unidad"];
$nit = $_GET["nit"];
$empresa = $_GET["empresa"];
$sigla = $_GET["sigla"];

?>
<script type="text/javascript">
    window.location = "../Presentacion/asociar_ncl.php?plan=<?php echo $poa?>&unidad=<?php echo $unidad ?>&nit=<?php echo $nit ?>&empresa=<?php echo $empresa ?>&sigla=<?php echo $sigla ?>";
</script>