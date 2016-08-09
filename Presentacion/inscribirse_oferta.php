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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_inscripcion_oferta.js" type="text/javascript"></script>



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
        <div id="contenedorcito">
            <br>
            <?php
            include("../Clase/conectar.php");
            extract($_GET);
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $sqlInscripcion = "SELECT * FROM T_NIVELES_OCUPACIONALES ORDER BY NIVEL_OCUPACIONAL ASC";
            $parseInscripcion = oci_parse($connection, $sqlInscripcion);
            oci_execute($parseInscripcion);
            $numRowsInscripcion = oci_fetch_all($parseInscripcion, $rowsInscripcion);

            $sqlOferta = "SELECT * FROM T_NORMAS_OFERTADAS NOR "
                    . "INNER JOIN NORMA NORM "
                    . "ON NOR.ID_NORMA = NORM.CODIGO_NORMA "
                    . "AND NOR.VERSION_NORMA = NORM.VERSION_NORMA "
                    . "WHERE NOR.ID_OFERTA = $id_oferta ";
            $parseOferta = oci_parse($connection, $sqlOferta);
            oci_execute($parseOferta);
            $numRowsOferta = oci_fetch_all($parseOferta, $rowsOferta);

            $queryRegionales = "SELECT * "
                    . "FROM REGIONAL "
                    . "ORDER BY NOMBRE_REGIONAL ASC ";
            $statementRegionales = oci_parse($connection, $queryRegionales);
            oci_execute($statementRegionales);
            ?>
            <form class="proyecto" style="text-align: left" id="form_inscripcion" action="guardar_inscripcion_oferta.php" method="POST">
                <center>
                    <strong style="display: block; width: 800px; font-size: 15px">Usted se está preinscribiendo en la NCL <?php echo $rowsOferta['CODIGO_NORMA'][0] ?> (<?php echo utf8_encode($rowsOferta['TITULO_NORMA'][0]) ?>), recuerde que debe contar con certificación de 1 año de experiencia realizando esta función productiva.</strong><br><br>
                </center>
                <input type="hidden" name="id_oferta" id="id_oferta" value="<?php echo $id_oferta ?>" />
                <fieldset>
                    <legend><b>Información Básica Inscripción</b></legend>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Número de cedula:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><?php echo $documento ?><input type="hidden" name="nro_cedula" id="nro_cedula" style="width: 100%" value="<?php echo $documento ?>" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Nombre Completo:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><input type="text" name="nombre" id="nombre" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Primer Apellido:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><input type="text" name="primer_apellido" id="primer_apellido" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Segundo Apellido:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><input type="text" name="segundo_apellido" id="segundo_apellido" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Nivel Ocupacional: </b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top">
                        <select name="nivel_ocupacional" id="nivel_ocupacional" style="width: 100%">
                            <?php for ($i = 0; $i < $numRowsInscripcion; $i++) { ?>
                                <option value="<?php echo $rowsInscripcion['ID_NIVEL_OCUPACIONAL'][$i] ?>"><?php echo utf8_encode($rowsInscripcion['NIVEL_OCUPACIONAL'][$i]) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Cargo: </b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top" ><input type="text" name="cargo" id="cargo" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Email:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><input type="text" name="correo" id="correo" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Celular:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top"><input type="text" name="celular" id="celular" style="width: 100%" /></div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Regionales:</b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top">
                        <select name="regionales" id="regionales" >
                            <option value="0">--Seleccione--</option>
                            <?php while ($regional = oci_fetch_array($statementRegionales, OCI_BOTH)) { ?>
                                <option value="<?php echo $regional['CODIGO_REGIONAL'] ?>"><?php echo utf8_encode($regional['NOMBRE_REGIONAL']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br><br>
                    <div style="display: inline-block; width: 150px; vertical-align: top"><b>Centros: </b></div>
                    <div style="display: inline-block; width: 675px; vertical-align: top">
                    <select name="centros" id="centros">

                    </select>
                    </div>
                    <br><br>
                    <div style="width: 100%; text-align: right">
                        <br>
                        <input type="submit" value="INSCRIBIRSE">
                    </div>
                    <br>
                </fieldset>
                <br><br>
            </form>
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
            <a href="#top"><  img src="../_img/top.gif" alt="Subir" title="Subir" /></a> &nbsp;
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