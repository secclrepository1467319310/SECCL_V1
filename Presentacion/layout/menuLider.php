<?php
//$fechaCierre=new DateTime("2015-11-30 16:59:59");
//$fecha=new DateTime();
//$interval=$fecha->diff($fechaCierre);
//if($fechaCierre>=$fecha){
?>
    <!--<script src="../js/cronometro.js" type="text/javascript"></script>-->
    <script>//$(document).ready(function(){$('#counter').countdown({stepTime: 60,
//    format: 'dd:hh:mm:ss',
//    startTime: '<?php //cambiar por <?=$interval->format('%a:%H:%I:%S')?>',
//    digitImages: 6,
//    digitWidth: 53,
//    digitHeight: 77,
//    image:"../images/digits.png"});});</script>
<?php // }?>
<style>
/*    br { clear: both; }
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
      }*/
</style>
<div id="menu">
    <ul id="nav">
        <li class="top"><a href="../Presentacion/menulider.php" class="top_link"><span>Inicio</span></a>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Planeación</span></a>
            <ul class="sub">
                <!--<li><a href="../Presentacion/comites_c.php">Comités</a></li>-->
                <!--<li><a href="../Presentacion/areas_c.php">Áreas Claves</a></li>-->
                <!--<li><a href="../Presentacion/solicitudes_c.php">Solicitudes</a></li>-->
                <li><a href="../Presentacion/ver_poa.php">Programación</a></li>
                <!--<li><a href="../Presentacion/oferta_c.php">Oferta</a></li>-->
                <li><a href="../Presentacion/verproyectos_c.php">Proyecto</a></li>
                <li><a href="../Presentacion/formacion_ev_c.php">Formación Eval</a></li>
            </ul>
        </li>
        
        <li class="top"><a href="#" class="top_link"><span class="down">Areas Claves</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/areas_claves_nacionales.php">Áreas claves nacionales</a></li>
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Ejecución</span></a>
            <ul class="sub">
                <!--<li><a href="../Presentacion/sensibilizacion_c.php">Sensibilización</a></li>-->
                <!--<li><a href="../Presentacion/induccion_c.php">Inducción</a></li>-->
                <li><a href="../Presentacion/inscripcion_c.php">Inscripción</a></li>
                <li><a href="../Presentacion/sabana_c.php">Plan Evidencias</a></li>
            </ul>
        </li>
<!--        <li class="top"><a href="#" class="top_link"><span class="down">Verificación</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/programacion_a_c.php">Programación</a></li>
                <li><a href="../Presentacion/planaudit_c.php">Plan y Des Audit</a></li>
                <li><a href="../Presentacion/planmejoramiento_c.php">Plan Mejoramiento</a></li>
            </ul>
        </li>-->
<!--        <li class="top"><a href="#" class="top_link"><span class="down">Certificación</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/alistamiento_c.php">Alistamiento</a></li>
            </ul>
        </li>-->
<!--        <li class="top"><a href="#" class="top_link"><span class="down">Banco Ítems</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/instrumentos_c.php">Catálogo</a></li>-->
                <!--<li><a href="../Presentacion/sol_instrumentos_c.php">Solicitudes</a></li>-->
<!--                <li><a href="../Presentacion/sol_oportunidad_c.php">Oportunidades</a></li>
                <li><a href="../Presentacion/sol_contingencia_c.php">Contingencias</a></li>-->
<!--            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Novedades</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/crearnovedad_c.php">Generar</a></li>
                <li><a href="../Presentacion/consultarnovedad_c.php">Consultar</a></li>
            </ul>
        </li>-->
        <li class="top"><a href="#" class="top_link"><span class="down">Staff</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/evaluadores_c.php">Evaluadores</a></li>
                <li><a href="../Presentacion/auditores_c.php">Auditores</a></li>
                <!--<li><a href="../Presentacion/apoyos_c.php">Apoyo SECCL</a></li>-->
            </ul>
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Consulta</span></a>
            <ul class="sub">
                <li><a href="../Presentacion/consultar_p_l.php">Mi Portafolio</a></li>
                <li><a href="../Presentacion/misdatos_l.php">Mis Datos</a></li>
                <li><a href="../Presentacion/misdatos_c_l.php">Datos Candidato</a></li>
            </ul>
        </li> 
        <li class="top"><a href="#" class="top_link"><span class="down">Reportes</span></a>
            <ul class="sub">
                <!--<li><a href="../Presentacion/reportes_c.php">Sistema SECCL</a></li>-->
                
                <li><a href="regionales_programacion.php">Programación Nacional</a></li>
                <li><a href="reportes_lideres.php">Reportes Descargables</a></li>
                <li><a href="http://gestionweb.sena.red/" target="blank">Firma Digital</a></li>
                
            </ul>
        </li>
        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
    </ul>
    <!--<br/>-->
<!--      activar el lunes  9 11 2015 <h3><b>Se realizará el Cierre de programaciones, proyectos, grupos, requerimientos del banco en: </b></h3>
        <div class="desc">
            <div>Días</div>
            <div>Horas</div>
            <div>Minutos</div>
            <div>Segundos</div>
          </div><br/>
        <div id="counter"></div>
        <br/>-->
        <!--<br/>-->
</div>