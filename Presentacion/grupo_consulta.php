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
            <center><h1>Creación de Grupos</h1></center>
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];

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
                                <th><strong>Proyecto</strong></th>
                                <td><input name="proyecto" type="text" readonly="readonly" value="<?php echo $proyecto ?>" ></td>
                                <th><strong>Norma</strong></th>
                                <td><input name="n" type="text" readonly="readonly" value="<?php echo $norma[0] ?>" ></td>
                            <input type="hidden" name="norma" value="<?php echo $idnorma ?>" ></input>       
                            </tr>
                            <tr>
                                <th><strong>Fecha</strong></th>
                                <td><input name="fecha" type="text" readonly="readonly" value="<?php echo $f ?>" ></td>
                                <th><strong>Grupo N°</strong></th>
                                <td>
                                    <Select Name="grupo" style=" width:150px" onChange="this.form.submit()" >
                                        <option value="0">Seleccione</option>
                                        <?PHP
                                        $query22 = ("select unique n_grupo from proyecto_grupo where id_proyecto='$proyecto'");

                                        $statement22 = oci_parse($connection, $query22);
                                        oci_execute($statement22);

                                        while ($row = oci_fetch_array($statement22, OCI_BOTH))
                                        {
                                            $id_m = $row["N_GRUPO"];
                                            if ($id_m == $_GET['grupo'])
                                            {
                                                echo "<OPTION value=" . $id_m . " selected='selected'>", $row["N_GRUPO"], "</OPTION>";
                                            }
                                            else
                                            {
                                                echo "<OPTION value=" . $id_m . ">", $row["N_GRUPO"], "</OPTION>";
                                            }
                                        }
                                        ?>

                                    </Select>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <?php
                    if ($_GET['grupo'])
                    {
                        ?>
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
                                $g = $_GET['grupo'];
                                $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma'  AND ESTADO='1' ORDER BY FECHA_INICIO ASC";
                                $statement21 = oci_parse($connection, $query21);
                                oci_execute($statement21);
                                $numero21 = 0;
                                while ($row = oci_fetch_array($statement21, OCI_BOTH))
                                {
                                    ?>
                                    <tr>
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
                                </tr>
                                <tr>
                                    <?php
                                    $query = "SELECT
UNIQUE ID_CANDIDATO,
DOCUMENTO,
PRIMER_APELLIDO,
SEGUNDO_APELLIDO,
NOMBRE,
USUARIO_ID
FROM USUARIO U
INNER JOIN PROYECTO_GRUPO PY
ON PY.ID_CANDIDATO=U.USUARIO_ID
WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma' AND N_GRUPO='$g'
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
                                    </tr>
                                    <?php
                                    $numero++;
                                }
                                ?>
                            </table>

                        </fieldset>
                        <?php
                    }
                    else
                    {
                        echo "<b>Seleccione un grupo por favor</b>";
                    }
                    ?>
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