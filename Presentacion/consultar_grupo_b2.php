<?php
session_start();
if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
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
            <center><h1>Consulta de Grupos</h1></center>
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];
            $g = $_GET['grupo'];
            $grupo = $_GET['grupo'];

            $query34 = ("select codigo_norma from norma where id_norma='$idnorma'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $norma = oci_fetch_array($statement34, OCI_BOTH);
            $f = date('d/m/Y');
            ?>
            <form class='proyecto'>
                <center>
                    <fieldset>
                        <legend><strong>Información General del Grupo</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th>
                                    <strong>Proyecto</strong>
                                </th>
                                <td>
                                    <input name="proyecto" type="text" readonly="readonly" value="<?php echo $proyecto ?>" >
                                </td>
                                <th>
                                    <strong>Norma</strong>
                                </th>
                                <td>
                                    <input name="n" type="text" readonly="readonly" value="<?php echo $norma[0] ?>" >
                                </td>
                            <input type="hidden" name="norma" value="<?php echo $idnorma ?>" ></input>       
                            </tr>
                            <tr>
                                <th><strong>Fecha</strong></th>
                                <td><input name="fecha" type="text" readonly="readonly" value="<?php echo $f ?>" ></td>
                                <th><strong>Grupo N°</strong></th>
                                <td>
                                    <?php
                                    echo $grupo;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $selectProNac1 = 'SELECT * '
                                    . 'FROM T_PROY_NAC_PROY_REG '
                                    . 'WHERE ID_PROYECTO = ' . $proyecto;

                            $objParseSelect1 = oci_parse($connection, $selectProNac1);
                            oci_execute($objParseSelect1);
                            $arraySelectProNac1 = oci_fetch_all($objParseSelect1, $rowSelectProNac1);

                            $selectProNac2 = 'SELECT * '
                                    . 'FROM T_PROY_NAC_PROYECTO '
                                    . 'WHERE ID_PROYECTO = ' . $proyecto;

                            $objParseSelect2 = oci_parse($connection, $selectProNac2);
                            oci_execute($objParseSelect2);
                            $arraySelectProNac2 = oci_fetch_all($objParseSelect2, $rowSelectProNac2);

                            if ($arraySelectProNac1 == 1 || $arraySelectProNac2 == 1)
                            {
                                $selectNombreEmpresa = 'SELECT ES.NOMBRE_EMPRESA
                                                    FROM PROYECTO P 
                                                    INNER JOIN EMPRESAS_SISTEMA ES
                                                    ON P.NIT_EMPRESA = ES.NIT_EMPRESA
                                                    WHERE P.ID_PROYECTO = ' . $proyecto;

                                $objParseSelectNombreEmpresa = oci_parse($connection, $selectNombreEmpresa);
                                $objExecuteSelectNombreEmpresa = oci_execute($objParseSelectNombreEmpresa, OCI_DEFAULT);
                                $arraySelectNombreEmpresa = oci_fetch_all($objParseSelectNombreEmpresa, $rowSelectNombreEmpresa);
                                ?>

                                <tr>
                                    <th>
                                        <strong>Tipo Proyecto</strong>
                                    </th>
                                    <td>
                                        Proyecto Nacional
                                    </td>
                                    <th>
                                        <strong>Nombre</strong>
                                    </th>
                                    <td>
                                        <?php echo $rowSelectNombreEmpresa['NOMBRE_EMPRESA'][0]; ?>
                                    </td>
                                </tr>
                                <?php
                            }

                            echo utf8_encode($rowSelectNombreEmpresa['NOMBRE_EMPRESA'][0]) . $nombre_proyecto;
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Cronograma del Grupo</strong></legend>
                        <table>
                            <tr>
                                <th><font face = "verdana"><b>ID CRONO</b></font></th>
                                <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                                <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                            </tr>
                            <?php
                            $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ESTADO='1'  ORDER BY FECHA_INICIO ASC";
                            //echo $query21 ;
                            $statement21 = oci_parse($connection, $query21);
                            oci_execute($statement21);
                            $numero21 = 0;
                            while ($row = oci_fetch_array($statement21, OCI_BOTH))
                            {
                                $color="";
                                if($row[ID_ACTIVIDAD]==24 ||$row[ID_ACTIVIDAD]==25 ||$row[ID_ACTIVIDAD]==26){
                                    $color="style='background-color:rgba(255,255,0,0.4)'";
                                }
                                if($row[ID_ACTIVIDAD]==27 ||$row[ID_ACTIVIDAD]==28 ||$row[ID_ACTIVIDAD]==29){
                                    $color="style='background-color:rgba(20,240,20,0.4)'";
                                }
                                ?>
                                <tr <?=$color?>>
                                    <?php
                                    $query3 = ("SELECT descripcion from actividades where id_actividad =  '$row[ID_ACTIVIDAD]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $des = oci_fetch_array($statement3, OCI_BOTH);
                                    ?>
                                    <td><?php echo $row["ID_CRONOGRAMA_GRUPO"]; ?></td>
                                    <td><?php echo utf8_encode($des[0]); ?></td>
                                    <td><?php echo $row["FECHA_INICIO"]; ?></td>
                                    <td><?php echo $row["FECHA_FIN"]; ?></td>
                                    <td><?php echo $row["RESPONSABLE"]; ?></td>
                                    <td><?php echo $row["OBSERVACIONES"]; ?></td>
                                </tr>
                                <?php
                                $numero21++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Evaluador Asignado</strong></legend>
                        <?php
                        $query1 = ("select unique id_evaluador from proyecto_grupo where id_proyecto='$proyecto' and id_norma='$idnorma' and n_grupo='$g'");
                        $statement1 = oci_parse($connection, $query1);
                        $resp1 = oci_execute($statement1);
                        $ideva = oci_fetch_array($statement1, OCI_BOTH);
                        $query2 = "SELECT DOCUMENTO,PRIMER_APELLIDO,SEGUNDO_APELLIDO,NOMBRE FROM USUARIO WHERE USUARIO_ID='$ideva[0]'";
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        $numero2 = 0;
                        while ($row = oci_fetch_array($statement2, OCI_BOTH))
                        {
                            ?>
                            <table>
                                <tr>
                                    <th>Documento</th>
                                    <th>Apellido</th>
                                    <th>Segundo Apellido</th>
                                    <th>Nombre</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                </tr>
                            </table>
                            <?php
                            $numero2++;
                        }
                        ?>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Candidatos Asociados</strong></legend>

                        <table>
                            <tr>
                                <th>N°</th>
                                <th>Documento</th>
                                <th>Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Nombre</th>
                                <th>Formalizado</th>
                                <th>Novedades candidatos</th>
                            </tr>
                            <tr>
                                <?php
                                $query = "SELECT distinct PY.ID_CANDIDATO, 
USU.DOCUMENTO, 
USU.PRIMER_APELLIDO, 
USU.SEGUNDO_APELLIDO, 
USU.NOMBRE, 
USU.USUARIO_ID, 
INS.ESTADO,
case when INS.ESTADO = 1 then 'SI' 
                 else 'NO' 
            end AS FORMALIZADO
FROM PROYECTO_GRUPO PY 
LEFT JOIN INSCRIPCION INS
ON PY.ID_CANDIDATO = INS.ID_CANDIDATO 
AND PY.ID_NORMA = INS.ID_NORMA 
AND PY.ID_PROYECTO = INS.ID_PROYECTO
AND PY.N_GRUPO = INS.GRUPO
LEFT JOIN USUARIO USU 
ON PY.ID_CANDIDATO=USU.USUARIO_ID
WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma' AND PY.N_GRUPO='$g'
ORDER BY PRIMER_APELLIDO ASC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH))
                                {
                                    ?>



                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <td><?php echo utf8_encode($row["FORMALIZADO"]); ?></td>
                                    <td><?php
                                        $qnovedades_grupo = "SELECT TTN.TIPO_NOVEDAD, ID_T_NOVEDADES_GRUPO FROM T_NOVEDADES_CANDI_GRUP TTG 
                                                  JOIN T_TIPO_NOVEDADES TTN 
                                                  ON(TTG.TIPO_NOVEDAD=TTN.ID_T_TIPO_NOVEDADES)
                                                WHERE NORMA=$idnorma  AND GRUPO=$g  AND PROYECTO=$proyecto  AND USUARIO_CANDIDATO=" . $row["ID_CANDIDATO"];
                                        $snovedades_grupo = oci_parse($connection, $qnovedades_grupo);
                                        oci_execute($snovedades_grupo);
                                        $rnovedades_grupo = oci_fetch_array($snovedades_grupo);
                                        if (!$rnovedades_grupo)
                                        {
                                            ?>
                                            No registra
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="consultar_novedad.php?id_novedad=<?php echo $rnovedades_grupo["ID_T_NOVEDADES_GRUPO"]; ?>" target="_blank"><?php echo $rnovedades_grupo["TIPO_NOVEDAD"]; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </td>         
                                </tr>
                                <?php
                                $numero++;
                            }
                            ?>
                        </table>

                    </fieldset>



                    <?php
                    $query217 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                    $statement217 = oci_parse($connection, $query217);
                    oci_execute($statement217);
                    ?><br><br>
                    HISTORIAL DE SOLICITUDES DE ESTE GRUPO
                    <table>
                        <tr>
                            <th><font face = "verdana"><b>Radicado de Solicitud</b></font></th>
                            <th><font face = "verdana"><b>Tipo de Solicitud</b></font></th>
                            <th><font face = "verdana"><b>Fecha de Solicitud</b></font></th>
                            <th><font face = "verdana"><b>Codigo Instrumento</b></font></th>
                            <th><font face = "verdana"><b>Estado de Solicitud</b></font></th>
                            <th><font face = "verdana"><b>Observación Respuesta</b></font></th>
                            <th><font face = "verdana"><b>Fecha respuesta</b></font></th>
                            <th><font face = "verdana"><b>Hora Respuesta</b></font></th>
                        </tr>
                        <?php
                        while ($respSolicitud2 = oci_fetch_array($statement217, OCI_BOTH))
                        {

                            $query223 = "SELECT ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO FROM T_ESTADO_SOLICITUD ES "
                                    . "INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
                                    . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD =  $respSolicitud2[ID_OPERACION])";
                            $statement223 = oci_parse($connection, $query223);
                            oci_execute($statement223);
                            $numRows223 = oci_fetch_all($statement223, $rows223);
                            ?>
                            <tr>
                                <td><?php echo 'R' . $proyectoC['ID_REGIONAL'] . '-C' . $proyectoC['ID_CENTRO'] . '-P' . $proyectoC['ID_PROYECTO'] . '-' . $norma[0] . '-' . $g . '-' . $respSolicitud2["ID_OPERACION"]; ?></td>
                                <td><?php echo $respSolicitud2["DESCRIPCION"]; ?></td>
                                <td><?php echo $respSolicitud2["FECHA_REGISTRO"]; ?></td>
                                <?php
                                if ($numRows223 == 1)
                                {
                                    echo "<td>" . $rows223['CODIGO_INSTRUMENTO'][0] . "</td>";
                                    echo "<td>" . utf8_encode($rows223['DETALLE'][0]) . "</td>";
                                    echo "<td>" . nl2br($rows223['OBSERVACION'][0]) . "</td>";
                                    echo "<td>" . $rows223['FECHA_REGISTRO'][0] . "</td>";
                                    echo "<td>" . $rows223['HORA_REGISTRO'][0] . "</td>";
                                }
                                else
                                {
                                    echo "<td>No disponible</td>";
                                    echo "<td>Enviada</td>";
                                    echo "<td>Aun no disponible</td>";
                                    echo "<td>Aun no disponible</td>";
                                    echo "<td>Aun no disponible</td>";
                                }
                                ?>
                            </tr>
                        <?php } ?>
                    </table><br>
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