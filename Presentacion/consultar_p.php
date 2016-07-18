<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

    <!--        CREDITOS  CREDITS
    Plantilla modificada por: Jhonatan Andres Garnica Paredes
    Requerimiento: Adaptación imagen corporativa.
    Direccion de Sistema - SENA, Dirección General
    última actualización Octubre /2012
    !-->

    <head>
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />


    </head>
    <body>
        <div id="">


            <div id="goog"></div>
            <div id="header">
                <div id="header_contenedor">
                    <a href="#"></a><div style="clear:both; "></div>
                    <div id="ads"><img src="../images/header_ads.png" /></div>

                    <div id="logo" style="height: 123px">
                        <p align="center"><strong>Sistema de Evaluación y Certificación
                                de Competencias Laborales</strong></p>
                        <p>&nbsp;</p>
                    </div>
                    <!-- <div style="clear:both; "></div>-->

                    <div id="menu" style="clear:both;">


                        <ul id="nav">
                            <li class="top"><a href="../Presentacion/menucandidato.php" class="top_link"><span>Inicio</span></a>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Oferta</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/cons_oferta.php">Consultar</a></li>
                                    <li><a href="../Presentacion/insc_oferta.php">Inscritas</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Datos Personales</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/ver_ficha.php">Ver Ficha</a></li>
                                </ul>
                                <li class="top"><a href="#" class="top_link"><span class="down">Portafolio Digital</span></a>
                                    <ul class="sub">
                                        <li><a href="../Presentacion/adicionar_p.php">Adicionar</a></li>
                                        <li><a href="../Presentacion/consultar_p.php">Consultar</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                        </ul>

                        <div class="bot_redes"><a href= "http://www.facebook.com/sena.general" title="SENA en Facebook" rel="external"><img src="../images/iconos/facebook.jpg" border="0" width="26" height="26" /></a> &nbsp; <a href="http://twitter.com/senacomunica" title="SENA en Twitter" rel="external"><img src="../images/iconos/twitter.jpg" border="0" width="26" height="26" /></a></div>
                    </div>
                </div>
            </div>



            <!-- CONTINUA -->

            <div id="contenedorcito">
                <br></br>
                <center><strong>Documentos En Mi Portafolio</strong></center>
                <br></br>
                <center>
                    <table border="1">
    <thead><tr>
            <th><strong>ID</strong></th>
            <th><strong>NOMBRE</strong></th>
            <th><strong>TIPO DE DOCUMENTO</strong></th>
            <th><strong>DESCRIPCION</strong></th>
            <th><strong>TIPO ARCHIVO</strong></th>
            <th><strong>VER</strong></th>
        </tr></thead>
    <tbody>
    </tbody>
    <?php
    include("../Clase/conectar.php");
    $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
    $query = "SELECT ID_PORTAFOLIO,FILENAME,TIPO_DOCUMENTO,DESCRIPCION,FILETYPE FROM PORTAFOLIO WHERE ID_USUARIO='$id' ORDER BY ID_PORTAFOLIO DESC";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $numero = 0;
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {
        
        if ($row["TIPO_DOCUMENTO"]==1) {
            $e="Documento de Identidad";
        }else{
            $e="Certificado Laboral";
        }
        
        echo "<tr><td width=\"20%\"><font face=\"verdana\">" .
        $row["ID_PORTAFOLIO"] . "</font></td>";
        echo "<td width=\"20%\"><font face=\"verdana\">" .
        $row["FILENAME"] . "</font></td>";
        echo "<td width=\"20%\"><font face=\"verdana\">" .
        $e . "</font></td>";
        echo "<td width=\"20%\"><font face=\"verdana\">" .
        $row["DESCRIPCION"] . "</font></td>";
        echo "<td width=\"20%\"><font face=\"verdana\">" .
        $row["FILETYPE"] . "</font></td>";
        echo "<td width=\"15%\"><a href=\"file.php?id=" . $row["ID_PORTAFOLIO"] . "\" TARGET=\"_blank\">
        Ver</a></td></tr>";


        $numero++;
    }
    oci_close($connection);
    ?>
</table>
                </center>
                <br></br>
            </div>
        </div>

        <div id="footer_info" class="center">
            <p>.:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
                Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
                Horario de atención: lunes a viernes de 8:00 am a 5:30 pm<br />
                Todos los derechos reservados © 2012 ::.
                <br />
                <br />
            </p>

        </div>

        <div style="clear:both; "></div>

        <div id="footer_links" class="center">
            <a href="http://www.sena.edu.co" title="Portal SENA" target="_blank"><img src="../images/logos/sena.jpg" width="77" height="58" alt="logo SENA" border="0" /></a> &nbsp; 
            <a href="http://wsp.presidencia.gov.co" title="Presidencia de la Rep&uacute;blica" target="_blank"><img src="../images/logos/presidencia.jpg" width="167" height="58" alt="logo Presidencia de la Rep&uacute;blica" border="0" /></a> &nbsp; 
            <a href="http://www.gobiernoenlinea.gov.co" title="Gobierno en l&iacute;nea" target="_blank"><img src="../images/logos/gel.jpg" width="121" height="58" alt="logo Gobierno en l&iacute;nea" border="0"/></a> &nbsp; 
            <a href="http://www.mintrabajo.gov.co" title="Ministerio del Trabajo" target="_blank"><img src="../images/logos/mintrabajo.jpg" width="114" height="58" alt="logo Ministerio del Trabajo" border="0"/></a> &nbsp;  
            <a href="http://www.sigob.gov.co" title="SIGOB" target="_blank"><img src="../images/logos/sigob.jpg" width="102" height="58" alt="logo SIGOB" border="0"/></a>
        </div>
        <div id="footer_ads" class="center">
                <!-- <img src="http://periodico.sena.edu.co/_img/footer_ads.png" width="1050" height="30" /> -->
        </div>
    </body>
</html>
