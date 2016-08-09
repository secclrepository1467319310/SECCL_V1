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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
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
                <script>
                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    var f = new Date();
                    document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                </script>
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
                <a href="index.php"><img src="../_img/header.jpg"/></a>
                <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
                <div id="menu">
                    <ul id="nav">
                            <li class="top"><a href="../Presentacion/menulider.php" class="top_link"><span>Inicio</span></a>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Planeación</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/solicitudes_c.php">Solicitudes</a></li>
                                    <li><a href="../Presentacion/ver_poa.php">Programación</a></li>
                                    <li><a href="../Presentacion/oferta_c.php">Oferta</a></li>
                                    <li><a href="../Presentacion/verproyectos_c.php">Proyecto</a></li>
                                    <li><a href="../Presentacion/formacion_ev_c.php">Formación Eval</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Ejecución</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/sensibilizacion_c.php">Sensibilización</a></li>
                                    <li><a href="../Presentacion/induccion_c.php">Inducción</a></li>
                                    <li><a href="../Presentacion/inscripcion_c.php">Inscripción</a></li>
                                    <li><a href="../Presentacion/sabana_c.php">Plan Evidencias</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Verificación</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/programacion_a_c.php">Programación</a></li>
                                    <li><a href="../Presentacion/planaudit_c.php">Plan y Des Audit</a></li>
                                    <li><a href="../Presentacion/planmejoramiento_c.php">Plan Mejoramiento</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Certificación</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/alistamiento_c.php">Alistamiento</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Banco Ítems</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/instrumentos_c.php">Catálogo</a></li>
                                    <li><a href="../Presentacion/sol_instrumentos_c.php">Solicitudes</a></li>
                                    <li><a href="../Presentacion/sol_oportunidad_c.php">Oportunidades</a></li>
                                    <li><a href="../Presentacion/sol_contingencia_c.php">Contingencias</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Novedades</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/crearnovedad_c.php">Generar</a></li>
                                    <li><a href="../Presentacion/consultarnovedad_c.php">Consultar</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Staff</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/evaluadores_c.php">Evaluadores</a></li>
                                    <li><a href="../Presentacion/auditores_c.php">Auditores</a></li>
                                    <li><a href="../Presentacion/apoyos_c.php">Apoyo SECCL</a></li>
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
                                    <li><a href="../Presentacion/reportes_c.php">Sistema SECCL</a></li>
                                    <li><a href="http://gestionweb.sena.red/" target="blank">Firma Digital</a></li>
                                </ul>
                            </li>
                                <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
                        </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto=$_GET['proyecto'];
            ?>
                
                <center>
                    <strong>Adicionar Documentos a Mi Portafolio</strong><br></br>
                    Documentos No Mayores a 2MB, Formatos permitidos (PDF,JPEG,GIF,BMP,JPG)
                </center>
                <br></br>
<!--                <form action="guardar_sensibilizacion_portafolio.php?proyecto=<?php echo $proyecto?>" method="post" enctype="multipart/form-data">
                    <table>
                        <tr><th>Tipo Documento</th>
                            <td><Select Name="tipodoc" >

                                <?PHP
                                
                                
//                                $query2 = ("select * 
//                                FROM TIPO_DOC_PORTAFOLIO 
//                                WHERE (ID_TDOC_PORTAFOLIO NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25,26,27,28,29,30,31,32,33,34,35))");
//                                $statement2 = oci_parse($connection, $query2);
//                                oci_execute($statement2);
//                                while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
//                                    $id_td = $row["ID_TDOC_PORTAFOLIO"];
//                                    $doc = $row["NOMBRE_DOCUMENTO"];
//
//                                    echo "<OPTION value=" . $id_td . ">", utf8_encode($doc), "</OPTION>";
//                                }
                                ?>

                            </Select></td></tr>
                        <tr><th>Descripción</th><td><input type="text" name="lob_description"></td></tr>
                        <tr><th>Seleccionar archivo</th><td><input type="file" name="lob_upload"><br><br></td></tr>
                         <tr><td></td><td><input type="submit" value="Subir Documento"> - <input type="reset"></td></tr>
                    </table>
                  </form>-->
                  </center>
                  <br></br>
                  <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
                  <center><strong>Documentos En el Portafolio del Proceso</strong></center>
                <br></br>
                <center>
                    <table border="1" id="demotable1">
    <thead><tr>
            <th><strong>ID</strong></th>
            <th><strong>TIPO DE DOCUMENTO</strong></th>
            <th><strong>DESCRIPCION</strong></th>
            <th><strong>NOMBRE ARCHIVO (en el Servidor)</strong></th>
            <th><strong>VER</strong></th>
            <th></th>
        </tr></thead>
    <tbody>
    </tbody>
    <?php
    
    
    $query = "SELECT 
    ID_PORTAFOLIO_PROCESO,
    NOMBRE_DOCUMENTO,
    DESCRIPCION,
    FILENAME
    FROM PORTAFOLIO_PROCESO P
    INNER JOIN TIPO_DOC_PORTAFOLIO TP
    ON P.TIPO_DOCUMENTO=TP.ID_TDOC_PORTAFOLIO
    WHERE ID_PROYECTO='$proyecto'
    ORDER BY ID_PORTAFOLIO_PROCESO DESC";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);
    
    
    $numero = 0;
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {
        
        
        echo "<tr><td width=\"\"><font face=\"verdana\">" .
        $row["ID_PORTAFOLIO_PROCESO"] . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["NOMBRE_DOCUMENTO"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["DESCRIPCION"]) . "</font></td>";
        echo "<td width=\"\"><font face=\"verdana\">" .
        utf8_encode($row["FILENAME"]) . "</font></td>";
        echo "<td width=\"\"><a href=\"file2.php?id=" . $row["ID_PORTAFOLIO_PROCESO"] . "\" TARGET=\"_blank\">
        Ver</a></td>";
        echo "<td><a href='eliminar_portafolio.php?portafolio=$row[ID_PORTAFOLIO_PROCESO]&documento=2&proyecto=$proyecto'>Eliminar</a></td></tr>";


        $numero++;
    }
    
    oci_close($connection);
    ?>
</table>
                </center>
                <br></br>
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