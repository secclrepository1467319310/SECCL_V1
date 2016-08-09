<?php
session_start();
if ($_SESSION["rol"] == 1) {
    include("layout/menuAdministrador.php");
} else if ($_SESSION["rol"] == 2) {
    include("layout/menuBanco.php");
} else if ($_SESSION["rol"] == 3) {
    include("layout/menuAsesor.php");
} else if ($_SESSION["rol"] == 4) {
    include("layout/menuLider.php");
} else if ($_SESSION["rol"] == 5) {
    
} else if ($_SESSION["rol"] == 6) {
    include("layout/menuAuditor.php");
    
} else if ($_SESSION["rol"] == 7) {
    include("layout/menuEvaluador.php");
} else if ($_SESSION["rol"] == 8) {
    include("layout/menuMisional.php");
} else if ($_SESSION["rol"] == 9) {
    
} else if ($_SESSION["rol"] == 10) {
    include("layout/menuCandidato.php");
} else if ($_SESSION["rol"] == 11) {
    include("layout/menuApoyo.php");
} else if ($_SESSION["rol"] == 12) {
    include("layout/menuLiderRegional.php");
}else if ($_SESSION["rol"] == 13) {
    include("layout/menuadministradorbanco.php");
}else if ($_SESSION["rol"] == 14) {
    include("layout/menuconsulta.php");
}else if ($_SESSION["rol"] == 15) {
    include("layout/menuconsultaenlace.php");
}
?>

<style>
    br { clear: both; }
      .cntSeparator {
        font-size: 54px;
        margin: 10px 7px;
        color: #000;
      }
    .desc { margin: 7px 3px; }
      .desc div {
        float: left;
        font-family: Arial;
        width: 70px;
        margin-right: 65px;
        font-size: 13px;
        font-weight: bold;
        color: #000;
      }
</style>
<div style="margin: 0 auto; width:50%">
<h3><b>Se realizará el Cierre por migración de servidor </b></h3>
        <div class="desc">
            <div>Días</div>
            <div>Horas</div>
            <div>Minutos</div>
            <div>Segundos</div>
          </div><br/>
        <div id="counter"></div>
        <br/>
        <br/>

</div>
<?php
$fechaCierre=new DateTime("2015-11-06 16:59:59");
$fecha=new DateTime();
$interval=$fecha->diff($fechaCierre);
if($fechaCierre>=$fecha){
?>
    <script src="../js/cronometro.js" type="text/javascript"></script>
    <script>
        <?php if ($_SESSION["rol"] == 13 || $_SESSION["rol"] == 2){?>
//        jq('#counter').ready(function(){
            jq('#counter').countdown({stepTime: 60,
        
            format: 'dd:hh:mm:ss',
            startTime: '<?=$interval->format('%D:%H:%I:%S')?>',
            digitImages: 6,
            digitWidth: 53,
            digitHeight: 77,
            image:"../images/digits.png", timerEnd:function(){alert("Tiempo acabado");window.location.href=window.location.href}});
//        });
        <?php }else{?>
//        $(document).ready(function(){
        $('#counter').countdown({stepTime: 60,
            format: 'dd:hh:mm:ss',
            startTime: '<?=$interval->format('%D:%H:%I:%S')?>',
            digitImages: 6,
            digitWidth: 53,
            digitHeight: 77,
            image:"../images/digits.png", timerEnd:function(){alert("Tiempo acabado");window.location.href=window.location.href}});
//        });
        <?php }?>
    </script>
<?php }else{
    session_destroy();
    
    ?>
    
    <script>alert("Ya no se puede acceder ");window.location.href=window.location.href</script>
                
    <?php }?>