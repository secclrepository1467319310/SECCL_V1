<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrés Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
última actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />


        <script>

            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;



            function inicio() {

                if (is_chrome) {
                    /*var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
                     var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
                     //Comprobar version
                     ver_chrome = parseFloat(ver_chrome);
                     alert('Su navegador es Google Chrome, Version: ' + ver_chrome);*/
                    document.getElementById("flotante")
                            .style.display = 'none';
                }
                else {
                    document.getElementById("flotante")
                            .style.display = '';
                }

            }
            function cerrar() {
                document.getElementById("flotante")
                        .style.display = 'none';
            }
        </script>
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
                $('#demotable2').tableFilter(options1);

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
        <script>
            function aMayusculas(obj, id) {
                obj = obj.toUpperCase();
                document.getElementById(id).value = obj;
            }
        </script>

    </head>
    <body onload="inicio()">
        <div id="flotante">
            <input type="button" value="X" onclick="cerrar('flotante')"
                   class="boton_verde2"></input> Se recomienda el uso de Google Chrome
            para una correcta visualizaci&oacute;n. Para descargarlo haga clic <a
                href="https://www.google.com/intl/es/chrome/browser/?hl=es"
                target="_blank">aqu&iacute;</a>
        </div>
        <div id="top">
            <div class="total" style="background:url(../_img/bck.header.jpg) no-repeat; height:40px;">
                <div class="min_space">&nbsp;</div>
                <div class="float_right" style="margin-right:20px;">
                    <a href="https://twitter.com/senacomunica" rel="external"><img src="../_img/rs.twitter.jpg" alt="SENA en Twiiter" /></a>&nbsp;
                    <a href="http://www.facebook.com/sena.general" rel="external"><img src="../_img/rs.facebook.jpg" alt="SENA en Facebook" /></a>&nbsp;
                    <a href="https://plus.google.com/111618152086006296623/posts" rel="external"><img src="../_img/rs.googleplus.jpg" alt="SENA en Google+" /></a>&nbsp;
                    <a href="http://pinterest.com/SENAComunica/" rel="external"><img src="../_img/rs.pinterest.jpg" alt="SENA en Pinterest" /></a>&nbsp;
                </div>		
            </div>
        </div>
        <div id="header" class="bck_lightgray">
            <div class="total">
                <a href="../index.php"><img src="../_img/header.jpg"/></a>
                <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
                <div id="menu">
                    <ul id="nav">
                        <li class="top"><a href="../index.php" class="top_link"><span>Inicio</span></a></li>
                        <li class="top"><a href="./que.php" class="top_link"><span>¿Qué es CCL?</span></a></li>
                        <li class="top"><a href="./principios.php" class="top_link top_link"><span>Principios y Características ECCL</span></a></li>
                        <li class="top"><a href="./normatividad.php" class="top_link top_link"><span>Normatividad </span></a></li>
                        <li class="top"><a href="./instrumentos.php" class="top_link top_link"><span>Catálogo de Instrumentos</span></a></li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Consultar</span></a>
                            <ul class="sub">
                                <li><a href="./oferta.php">Oferta</a></li>
                                <li><a href="http://certificados.sena.edu.co" target="blank">Certificados</a></li>
                                <li><a href="./memorias.php">Documentos</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Atención al Ciudadano</span></a>
                            <ul class="sub">
                                <li><a href="http://sciudadanos.sena.edu.co/SolicitudIndex.aspx" target="blank">PQRSF</a></li>
                                <li><a href="./contacto.php">Contáctenos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div></div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito" style="width: auto !important">
            <br>
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            ?>
            <center>
                <br>
                </br>

                <center>
                    <strong style="display: block; width: 800px; font-size: 15px">Del siguiente listado de NLC por favor seleccione la que desea certificar, teniendo en cuenta el cumplimiento de requisitos.  Recuerda que solo puedes preinscribirte a UNA norma</strong><br><br>
                    <div style="width: 950px">* El cupo  a ser atendido es el que figura en el campo denominado Cupo Final, sin embargo, en el caso que, en la revisión de cumplimiento de requisitos algunos postulados NO cumplan, serán revisados los 100 siguientes que se hayan preinscrito, motivo por el cual en el campo denominado Cupo Preinscripción aparece un número mayor.</div><br>
                    <fieldset style="text-align: left; padding: 20px; width: 800px">
                        <legend><b>Normas Técnicas</b></legend>
                        <table id="demotable1" >
                            <thead><tr>
                                    <th><strong>Codigo Regional</strong></th>
                                    <th><strong>Regional</strong></th>
                                    <th><strong>Codigo Centro</strong></th>
                                    <th><strong>Centro</strong></th>
                                    <th><strong>Codigo Mesa</strong></th>
                                    <th><strong>Nombre Mesa</strong></th>
                                    <th><strong>Codigo Norma</strong></th>
                                    <th><strong>Versión Norma</strong></th>
                                    <th><strong>Titulo Norma</strong></th>
                                    <th><strong>Cupo Final*</strong></th>
                                    <th><strong>Cupo Preinscripción*</strong></th>
                                    <th><strong>Inscripción</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query = "SELECT OFE.ID_OFERTA, OFE.CODIGO_OFERTA, OFE.ID_NORMA, OFE.VERSION_NORMA, OFE.ID_OFERTA, CE.CODIGO_CENTRO, CE.NOMBRE_CENTRO, REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, NM.TITULO_NORMA, ME.CODIGO_MESA, ME.NOMBRE_MESA, OFE.CUPOS FROM T_NORMAS_OFERTADAS OFE "
                                    . "INNER JOIN CENTRO CE ON OFE.CODIGO_CENTRO = CE.CODIGO_CENTRO "
                                    . "INNER JOIN REGIONAL REG ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                                    . "INNER JOIN NORMA NM ON OFE.ID_NORMA = NM.CODIGO_NORMA AND OFE.VERSION_NORMA = NM.VERSION_NORMA "
                                    . "INNER JOIN MESA ME ON ME.CODIGO_MESA = NM.CODIGO_MESA "
                                    . "WHERE OFE.TIPO_NORMA = 1 AND OFE.CODIGO_OFERTA = 1 "
                                    . "ORDER BY REG.NOMBRE_REGIONAL ASC";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                $queryInscripcion = "SELECT count(*) AS INSCRITOS FROM T_INSCRIPCION_OFERTA "
                                        . "WHERE ID_OFERTA = $row[ID_OFERTA]";
                                $statementInscripcion = oci_parse($connection, $queryInscripcion);
                                oci_execute($statementInscripcion);
                                $rowsNumInscripcion = oci_fetch_all($statementInscripcion, $rowsInscripcion);

                                $cupo_final = $row['CUPOS'] - $rowsInscripcion['INSCRITOS'][0];
                                $cupo_pre = ($row['CUPOS'] + 100) - $rowsInscripcion['INSCRITOS'][0];
                                if ($cupo_final <= 0) {
                                    $cupo_final = 0;
                                }
                                if ($cupo_pre <= 0) {
                                    $cupo_pre = 0;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['CODIGO_REGIONAL'] ?></td>
                                    <td><?php echo utf8_encode($row['NOMBRE_REGIONAL']) ?></td>
                                    <td><?php echo $row['CODIGO_CENTRO'] ?></td>
                                    <td><?php echo utf8_encode($row['NOMBRE_CENTRO']) ?></td>
                                    <td><?php echo $row['CODIGO_MESA'] ?></td>
                                    <td><?php echo utf8_encode($row['NOMBRE_MESA']) ?></td>
                                    <td><?php echo $row['ID_NORMA'] ?></td>
                                    <td><?php echo $row['VERSION_NORMA'] ?></td>
                                    <td><?php echo utf8_encode($row['TITULO_NORMA']) ?></td>
                                    <td><?php echo $cupo_final ?></td>
                                    <td><?php echo $cupo_pre ?></td>
                                    <td>
                                        <?php if ($cupo_pre <= 0) { ?>
                                            Preinscripcón cerrada
                                        <?php } else { ?>
                                            <form action="validar_inscripcion.php" method="POST">
                                                <input type="hidden" value="<?php echo $row['ID_OFERTA'] ?>" id="id_oferta" name="id_oferta" />
                                                <input type="hidden" value="<?php echo $row['CODIGO_OFERTA'] ?>" id="oferta" name="oferta" />
                                                <input type="submit" value="PREINSCRIPCIÓN" />
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br><br>
                    <fieldset style="text-align: left; padding: 20px; width: 1080px">
                        <legend><b>Normas Transversales</b></legend>
                        <table id="demotable2" >
                            <thead><tr>
                                    <th><strong>Codigo Regional</strong></th>
                                    <th><strong>Regional</strong></th>
                                    <th><strong>Codigo Centro</strong></th>
                                    <th><strong>Centro</strong></th>
                                    <th><strong>Codigo Mesa</strong></th>
                                    <th><strong>Nombre Mesa</strong></th>
                                    <th><strong>Codigo Norma</strong></th>
                                    <th><strong>Nombre Norma</strong></th>
                                    <th><strong>Titulo Norma</strong></th>
                                    <th><strong>Cupo Final*</strong></th>
                                    <th><strong>Cupo Pre-inscripción*</strong></th>
                                    <th><strong>Inscripción</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query2 = "SELECT OFE.ID_NORMA, OFE.ID_OFERTA, OFE.CODIGO_OFERTA, OFE.VERSION_NORMA, CE.CODIGO_CENTRO, CE.NOMBRE_CENTRO, REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, NM.TITULO_NORMA, ME.CODIGO_MESA, ME.NOMBRE_MESA, OFE.CUPOS FROM T_NORMAS_OFERTADAS OFE "
                                    . "INNER JOIN CENTRO CE ON OFE.CODIGO_CENTRO = CE.CODIGO_CENTRO "
                                    . "INNER JOIN REGIONAL REG ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                                    . "INNER JOIN NORMA NM ON OFE.ID_NORMA = NM.CODIGO_NORMA AND OFE.VERSION_NORMA = NM.VERSION_NORMA "
                                    . "INNER JOIN MESA ME ON ME.CODIGO_MESA = NM.CODIGO_MESA "
                                    . "WHERE OFE.TIPO_NORMA = 2 AND OFE.CODIGO_OFERTA = 1 "
                                    . "ORDER BY REG.NOMBRE_REGIONAL ASC";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                                $queryInscripcion = "SELECT count(*) AS INSCRITOS FROM T_INSCRIPCION_OFERTA "
                                        . "WHERE ID_OFERTA = $row2[ID_OFERTA]";
                                $statementInscripcion = oci_parse($connection, $queryInscripcion);
                                oci_execute($statementInscripcion);
                                $rowsNumInscripcion = oci_fetch_all($statementInscripcion, $rowsInscripcion);

                                $cupo_final = $row2['CUPOS'] - $rowsInscripcion['INSCRITOS'][0];
                                $cupo_pre = ($row2['CUPOS'] + 100) - $rowsInscripcion['INSCRITOS'][0];
                                if ($cupo_final <= 0) {
                                    $cupo_final = 0;
                                }
                                if ($cupo_pre <= 0) {
                                    $cupo_pre = 0;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row2['CODIGO_REGIONAL'] ?></td>
                                    <td><?php echo utf8_encode($row2['NOMBRE_REGIONAL']) ?></td>
                                    <td><?php echo $row2['CODIGO_CENTRO'] ?></td>
                                    <td><?php echo utf8_encode($row2['NOMBRE_CENTRO']) ?></td>
                                    <td><?php echo $row2['CODIGO_MESA'] ?></td>
                                    <td><?php echo utf8_encode($row2['NOMBRE_MESA']) ?></td>
                                    <td><?php echo $row2['ID_NORMA'] ?></td>
                                    <td><?php echo $row2['VERSION_NORMA'] ?></td>
                                    <td><?php echo utf8_encode($row2['TITULO_NORMA']) ?></td>
                                    <td><?php echo $cupo_final ?></td>
                                    <td><?php echo $cupo_pre ?></td>
                                    <td>
                                        <?php if ($cupo_pre <= 0) { ?>
                                            Preinscripcón cerrada
                                        <?php } else { ?>
                                            <form action="validar_inscripcion.php" method="POST">
                                                <input type="hidden" value="<?php echo $row2['ID_OFERTA'] ?>" id="id_oferta" name="id_oferta" />
                                                <input type="hidden" value="<?php echo $row2['CODIGO_OFERTA'] ?>" id="oferta" name="oferta" />
                                                <input type="submit" value="PREINSCRIPCIÓN" />
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            oci_close($connection);
                            ?>
                        </table>
                    </fieldset>
                </center>
        </div>
        <div class="espacio">&nbsp;</div>
    </div>
    <div class="space">&nbsp;</div>
    <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
    <div class="space">&nbsp;</div>
    <div class="min_space">&nbsp;</div>
    <div class="total" style="border-top: 2px solid #888;">
        <table align="right">
            <tr class="font14 bold">
                <td rowspan="2">
                    <a href="http://wsp.presidencia.gov.co" title="Gobierno de Colombia" rel="external"><img src="../_img/links/gobierno.jpg" alt="logo Gobierno de Colombia" /></a> &nbsp; 
                </td>
                <td>
                    <a href="http://mintrabajo.gov.co/" title="Ministerio de Trabajo" rel="external"><img src="../_img/links/mintrabajo.jpg" alt="logo Ministerio de Trabajo" /></a> &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    <a href="http://www.mintic.gov.co/" title="Ministerio de Tecnologías de la Información y las Comunicaciones" rel="external"><img src="../_img/links/mintic.jpg" alt="logo Ministerio de Tecnologías de la Información y las Comunicaciones" /></a>
                </td>
            </tr>
        </table>
        <div class="space">&nbsp;</div>
    </div>

    <div class="bck_orange">
        <div class="space">&nbsp;</div>
        <div class="total center white">
            Última modificación 08/04/2013 4:00 PM<br /><br />
            .:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
            Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
            Horario de atención: lunes a viernes de 8:00 am a 5:30 pm                        <br />
            <span class="font13 white">Correo electrónico para notificaciones judiciales: <a href="mailto:notificacionesjudiciales@sena.edu.co" class="bold white" rel="external">notificacionesjudiciales@sena.edu.co</a></span> <br />
            Todos los derechos reservados © 2012 ::.
        </div>
        <div class="total right">
            <a href="#top"><img src="../_img/top.gif" alt="Subir" title="Subir" /></a> &nbsp;
        </div>
        <!--<div class="space">&nbsp;</div>-->
    </div>

    <map name="Map2">
        <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
        <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
        <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
    </map>
</body>
</html>