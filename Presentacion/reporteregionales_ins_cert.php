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
    <!--            
Reporte en donde se consulta el numero de personas inscritas y certificadas de los 
proyetos pertenecientes a la regional asignada al usuario logueado.
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/magnificpopup.css" />
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

                $('#demotable').tableFilter(options1);

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
        <script type="text/javascript" language="JavaScript">
            function validar() {
                var form = document.f2;
                var total = 0;
                for (var i = 0; i < form.codigo.length; i++) {
                    //cuento la cantidad de input activos
                    if (form.codigo[i].checked) {
                        total = total + 1;
                    }
                }  //cierre for
                if (total == 12) {
                    for (i = 0; i < form.codigo.length; i++) {
                        //deshabilito el resto de checkbox
                        if (!form.codigo[i].checked) {
                            form.codigo[i].disabled = true;
                        }
                    }
                } else {
                    for (i = 0; i < form.codigo.length; i++) {
                        // habilito los checkbox cuando el total es menor que 3
                        form.codigo[i].disabled = false;
                    }
                }
                return false;
            } //cierre función

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
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div style="width:900px; margin: 0 auto;">
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            ?>
            <center>
                <strong>REPORTE DE PERSONAS INSCRITAS Y CERTIFICADAS EN LA REGIONAL: </strong><br></br>
            </center>

            <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />
            <center>
                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <br></br>
                <table id="demotable">
                    <thead>
                        <tr>
                            <th>Código Regional</th>
                            <th>Regional</th>
                            <th>Certificados</th>
                            <th>Inscritos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    //Consulta de una regional en especifico
                    $query = "SELECT NOMBRE_REGIONAL, CODIGO_REGIONAL 
                    FROM REGIONAL ORDER BY NOMBRE_REGIONAL";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);
                    while ($regional = oci_fetch_array($statement, OCI_BOTH)) {

                        /* Consulta para contar el numero de personas 
                          certificadas en los proyectos de la regional */
                        $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS FROM CE_FIRMA_CERTIFICADOS "
                                . "WHERE CENTRO_REGIONAL_ID_REGIONAL = $regional[CODIGO_REGIONAL]");
                        $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                        oci_execute($statementCandidatosCertificados);
                        $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);
                        
                        $queryCandidatosCertificadosGC = ("SELECT SUM(CER.NUMERO_CERTIFICACIONES) AS NUMERO_CERTIFICACIONES FROM CENTRO CE"
                                . " INNER JOIN T_CERTIFICACIONES_2014 CER ON CE.CODIGO_CENTRO = CER.CODIGO_CENTRO "
                                . "WHERE CE.CODIGO_REGIONAL = $regional[CODIGO_REGIONAL]");
                        $statementCandidatosCertificadosGC = oci_parse($connection, $queryCandidatosCertificadosGC);
                        oci_execute($statementCandidatosCertificadosGC);
                        $candidatosCertificadosGC = oci_fetch_array($statementCandidatosCertificadosGC, OCI_BOTH);
                        $candidatosCertificados = $certificados['CERTIFICADOS'] + $candidatosCertificadosGC['NUMERO_CERTIFICACIONES'];

                        /* Consulta para contar el numero de personas 
                          inscritas en los proyectos de esa regional */
                        $queryCandidatosInscritos = "SELECT COUNT(*) AS INSCRITOS FROM PROYECTO PY "
                                . "INNER JOIN INSCRIPCION INS ON PY.ID_PROYECTO = INS.ID_PROYECTO "
                                . "WHERE PY.ID_REGIONAL = $regional[CODIGO_REGIONAL]";
                        $statementCandidatosInscritos = oci_parse($connection, $queryCandidatosInscritos);
                        oci_execute($statementCandidatosInscritos);
                        $candidatosInscritos = oci_fetch_array($statementCandidatosInscritos, OCI_BOTH);
                        ?>
                        <tr>
                            <td><?php echo $regional['CODIGO_REGIONAL'] ?></td>
                            <td><?php echo utf8_encode($regional['NOMBRE_REGIONAL']) ?></td>
                            <td><?php echo $candidatosCertificados ?></td>
                            <td><?php echo $candidatosInscritos['INSCRITOS'] ?></td>
                            <td>
                                <form action="reporte_cent_ins_cert.php" method="POST">
                                    <input type="hidden" name="regional" value="<?php echo $regional['CODIGO_REGIONAL'] ?>" />
                                    <input type="submit" value="Consultar">
                                </form>
                            </td>
                        </tr>


                        <?php
                    }
                    oci_close($connection);
                    ?>
                </table>

            </center>
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