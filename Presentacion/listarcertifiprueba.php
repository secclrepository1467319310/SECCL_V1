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
            </div>
        </div>
        <div id="contenedorcito" >
            <br>
            <center><h1>Listado para Emision de Certificado</h1></center>
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];

            //---
            $query23 = ("select n.codigo_norma from norma n inner join plan_evidencias pe on pe.id_norma=n.id_norma where pe.id_plan='$plan'");
            $statement23 = oci_parse($connection, $query23);
            $resp23 = oci_execute($statement23);
            $cnorma = oci_fetch_array($statement23, OCI_BOTH);
            //---
            $query232 = ("select id_proyecto from plan_evidencias where id_plan='$plan'");
            $statement232 = oci_parse($connection, $query232);
            $resp232 = oci_execute($statement232);
            $pr = oci_fetch_array($statement232, OCI_BOTH);
            //---
            $query233 = ("select grupo from plan_evidencias where id_plan='$plan'");
            $statement233 = oci_parse($connection, $query233);
            $resp233 = oci_execute($statement233);
            $g = oci_fetch_array($statement233, OCI_BOTH);
            //---
            $query234 = ("select id_norma from plan_evidencias where id_plan='$plan'");
            $statement234 = oci_parse($connection, $query234);
            $resp234 = oci_execute($statement234);
            $idn = oci_fetch_array($statement234, OCI_BOTH);
            
            $queryNorma = ("select CODIGO_NORMA from NORMA where ID_NORMA='$idn[0]'");
            $statementNorma = oci_parse($connection, $queryNorma);
            oci_execute($statementNorma);
            $norma = oci_fetch_array($statementNorma, OCI_BOTH);
            ?>
            <form class='proyecto' name="formmapa" action="guardar_concertacion_f_plan_ev.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" >
                <center>
                    <fieldset>
                        <legend><strong>Generalidades</strong></legend>
                        <table id="">
                            <tr>
                                <th width="">Norma</th>
                                <th width="">Proyecto</th>
                                <th width="">Grupo</th>
                            </tr>
                            <tr>
                                <td><?php echo $cnorma[0] ?></td>
                                <td><?php echo $pr[0] ?></td>
                                <td><?php echo $g[0] ?></td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Listado de Personas</strong></legend>
                        <br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <table id="demotable1">
                            <thead><tr>
                                    <th width="">N°</th>
                                    <th width="">Primer Apellido</th>
                                    <th width="">Segundo Apellido</th>
                                    <th width="">Nombres </th>
                                    <th width="">Documento </th>
                                    <th width="">Juicio</th>
                                    <th width="">Emitir Certificado</th>
                                </tr></thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query = "select unique
u.usuario_id,
u.documento,
u.nombre,
u.primer_apellido,
u.segundo_apellido
from usuario u
inner join proyecto_grupo pe
on pe.id_candidato=u.usuario_id
where pe.n_grupo='$g[0]' 
and pe.id_proyecto='$pr[0]' 
and id_norma='$idn[0]' order by u.primer_apellido asc ";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                $query33 = ("select estado from evidencias_candidato
                                where id_plan='$plan' and id_norma='$idn[0]' and id_candidato='$row[USUARIO_ID]'");
                                $statement33 = oci_parse($connection, $query33);
                                $resp33 = oci_execute($statement33);
                                $estado = oci_fetch_array($statement33, OCI_BOTH);

                                //----

                                echo $query332 = ("select count(*) from certificacion where id_candidato='$row[USUARIO_ID]' and id_norma='$idn[0]' and id_proyecto = '$pr[0]'");
                                $statement332 = oci_parse($connection, $query332);
                                $resp332 = oci_execute($statement332);
                                $certificadoProyecto = oci_fetch_array($statement332, OCI_BOTH);

                                $query3322 = ("select id_proyecto from certificacion where id_candidato='$row[USUARIO_ID]' and id_norma='$idn[0]' and id_proyecto != '$pr[0]'");
                                $statement3322 = oci_parse($connection, $query3322);
                                $resp3322 = oci_execute($statement3322);
                                $certificadoNorma = oci_fetch_array($statement3322, OCI_BOTH);

                                $query333 = ("select count(*) existe from T_NORMAS_REGULADAS where CODIGO_NORMA='$norma[CODIGO_NORMA]'");
                                $statement333 = oci_parse($connection, $query333);
                                $resp333 = oci_execute($statement333);
                                $normaRegulado = oci_fetch_array($statement333, OCI_BOTH);
                                ?>
                                <tr>
                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <?php
//                                    if ($certificado[0] == 0 && ($estado[0] == 0 || $estado[0] == 2 || $estado[0] == 3 || $estado[0] == 4)) {
//                                        $estadoCertificacion = 'No disponible';
//                                    } else if ($certificado[0] == 0 && ($estado[0] != 1 && $normaRegulado['existe'] >= 1)) {
//                                        $estadoCertificacion = "<a href='generar_certificado.php?idplan=$plan&norma=$idn[0]&idca=$row[USUARIO_ID]&proyecto=$pr[0]' onclick='return confirm(¿Esta seguro que desea generar el certificado a esta persona?)'> <label style='color: #23838b; cursor: pointer'>Generar Certificado</label></a>";
//                                    } else {
//                                        $estadoCertificacion = 'Certificado';
//                                    }

                                    $colorAnuncio = '#cd0a0a';

                                    if ($certificadoProyecto[0] >= 1) {
                                        $estadoCertificacion = 'Certificado';
                                        $colorAnuncio = '#31B404';
                                    } else if ($certificadoNorma) {
                                        $estadoCertificacion = 'Certificado en proyecto P'.$certificadoNorma['ID_PROYECTO'];
                                        $colorAnuncio = '#31B404';
                                    } else if ($estado[0] == 0) {
                                        $estadoCertificacion = 'No disponible';
                                    } else if ($certificado[0] == 0 && ($estado[0] == 4 || $estado[0] == 3) && ($normaRegulado['existe'] >= 1)) {
                                        $estadoCertificacion = 'Norma Regulada';
                                    } else if ($certificado[0] == 0 && ($estado[0] == 1) && ($normaRegulado[0] > 0)) {
                                        $estadoCertificacion = "<a href='generar_certificado.php?idplan=$plan&norma=$idn[0]&idca=$row[USUARIO_ID]&proyecto=$pr[0]&nivel=$estado[0]' onclick='return confirm(¿Esta seguro que desea generar el certificado a esta persona?)'> <label style='color: #23838b; cursor: pointer'>Generar Certificado</label></a>";
                                    } else if ($certificado[0] == 0 && $estado[0] == 2) {
                                        $estadoCertificacion = 'Aun no Competente';
                                    } else if ($certificado[0] == 0 && ($estado[0] == 3 || $estado[0] == 4) && ($normaRegulado[0] > 0)) {
                                        $estadoCertificacion = 'Norma Regulada';
                                    } else if ($certificado[0] == 0 && ($estado[0] == 4 || $estado[0] == 3 || $estado[0] == 1) && ($normaRegulado['existe'] == 0)) {
                                        $estadoCertificacion = "<a href='generar_certificado.php?idplan=$plan&norma=$idn[0]&idca=$row[USUARIO_ID]&proyecto=$pr[0]&nivel=$estado[0]' onclick='return confirm(¿Esta seguro que desea generar el certificado a esta persona?)'> <label style='color: #23838b; cursor: pointer'>Generar Certificado</label></a>";
                                    }

                                    if ($estado[0] == 0) {
                                        $estadoNivel = 'Sin Juicio';
                                    } elseif ($estado[0] == 1) {
                                        $estadoNivel = 'Nivel Avanzado';
                                    } elseif ($estado[0] == 2) {
                                        $estadoNivel = 'Aun no competente';
                                    } elseif ($estado[0] == 3) {
                                        $estadoNivel = 'Nivel Intermedio';
                                    } elseif ($estado[0] == 4) {
                                        $estadoNivel = 'Nivel Básico';
                                    }
                                    ?>
                                    <td><?php echo $estadoNivel ?></td>
                                    <td><label style="color: <?php echo $colorAnuncio; ?>"><?php echo $estadoCertificacion ?></label></td>

                                    <?php
                                    $numero++;
                                }
                                ?>
                            </tr>
                            <?php
//                            }
                            ?>
                        </table>
                    </fieldset>
                </center>
            </form>
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