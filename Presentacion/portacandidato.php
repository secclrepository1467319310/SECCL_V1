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
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        
        
        <script type="text/javascript">
            $(document).ready(function() {


                // Initialise Plugin
                var options1 = {
                    clearFiltersControls: [$('#cleanfilters')],
                    matchingRow: function(state, tr, textTokens) {
                        if (!state || !state.id) {
                            return true;
                        }
                        var val = tr.children('td:eq(2)').text();
                        switch (state.id) {
                            case 'onlyyes':
                                return state.value !== 'true' || val === 'yes';
                            case 'onlyno':
                                return state.value !== 'true' || val === 'no';
                            default:
                                return true;
                        }
                    }
                };

                $('#demotable1').tableFilter(options1);

                var grid2 = $('#demotable2');
                var options2 = {
                    filteringRows: function(filterStates) {
                        grid2.addClass('filtering');
                    },
                    filteredRows: function(filterStates) {
                        grid2.removeClass('filtering');
                        setRowCountOnGrid2();
                    }
                };
                function setRowCountOnGrid2() {
                    var rowcount = grid2.find('tbody tr:not(:hidden)').length;
                    $('#rowcount').text('(Rows ' + rowcount + ')');
                }

                grid2.tableFilter(options2); // No additional filters			
                setRowCountOnGrid2();
            });
        </script>


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


<!--                        <ul id="nav">
                            <li class="top"><a href="../Presentacion/menulider.php" class="top_link"><span>Inicio</span></a>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">PAECCL</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/registrar_poa.php">Registrar</a></li>
                                    <li><a href="../Presentacion/ver_poa.php">Consultar</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Proyectos</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/verproyectos_c.php">Consultar</a></li>
                                </ul>
                            </li>
                                <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                        </ul>-->

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
    <thead<tr>
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
    $connection = @OCILogon('certicompetencias', 'Ccompetencias7', '//localhost/orcl.0.16.99');
    $query = "SELECT ID_PORTAFOLIO,FILENAME,TIPO_DOCUMENTO,DESCRIPCION,FILETYPE FROM PORTAFOLIO WHERE ID_USUARIO='61' ORDER BY ID_PORTAFOLIO DESC";
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
