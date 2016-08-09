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
            <center><h1>Información General del Proyecto</h1></center>
            <?php $proyecto = $_GET['proyecto']; ?>
            <form class='proyecto'>
                <center>
                    <fieldset>
                        <legend><strong>Normas que atienden el Proyecto</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th><strong>Código Mesa</strong></th>
                                <th><strong>Mesa</strong></th>
                                <th><strong>Código Norma</strong></th>
                                <th><strong>Versión</strong></th>
                                <th><strong>Título Norma</strong></th>
                            </tr>
                            <?php
                            include("../Clase/conectar.php");
                            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                            $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement8 = oci_parse($connection, $query8);
                            $resp8 = oci_execute($statement8);
                            $pro = oci_fetch_array($statement8, OCI_BOTH);

                            $q = "select id_norma from detalles_poa where id_provisional='$pro[0]'";
                            $statement3 = oci_parse($connection, $q);
                            oci_execute($statement3);
                            $numero3 = 0;
                            while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {
                                $query = "select mesa.nombre_mesa,norma.codigo_mesa,norma.codigo_norma,norma.version_norma,
                                norma.titulo_norma,norma.id_norma from norma
                                join mesa
                                on mesa.codigo_mesa=norma.codigo_mesa
                                where norma.id_norma='$row3[ID_NORMA]'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                    $row["CODIGO_MESA"] . "</font></td>";
                                    echo "<td width=\"5%\"><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_MESA"]) . "</font></td>";
                                    echo "<td width=\"5%\"><font face=\"verdana\">" .
                                    $row["CODIGO_NORMA"] . "</font></td>";
                                    echo "<td width=\"2%\"><font face=\"verdana\">" .
                                    $row["VERSION_NORMA"] . "</font></td>";
                                    echo "<td width=\"25%\"><font face=\"verdana\">" .
                                    utf8_encode($row["TITULO_NORMA"]) . "</font></td></tr>";
                                    $numero3++;
                                }
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Información Empresarial</strong></legend>
                        <?php
                        $query3 = ("SELECT nit_empresa from proyecto where id_proyecto =  '$proyecto'");
                        $statement3 = oci_parse($connection, $query3);
                        $resp3 = oci_execute($statement3);
                        $nit = oci_fetch_array($statement3, OCI_BOTH);
                        $query = "SELECT * FROM EMPRESAS_SISTEMA WHERE NIT_EMPRESA='$nit[0]'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <table>
                                <tr>
                                    <th>Tipo ID</th>
                                    <th>Identificación</th>
                                    <th>Razón Social</th>
                                    <th>Tamaño Empresa</th>
                                    <th>Número de Empleados</th>
                                </tr>
                                <tr>
                                    <?php
                                    if ($row["tipo_identificacion"] < 2) {
                                        $e = "Nit";
                                    } else {
                                        $e = "Rut";
                                    }
                                    $query2 = ("SELECT TAMANO FROM TAM_EMPRESA WHERE ID_TAM='$row[TAM_EMPRESA]'");
                                    $statement2 = oci_parse($connection, $query2);
                                    $resp2 = oci_execute($statement2);
                                    $tam = oci_fetch_array($statement2, OCI_BOTH);
                                    $query4 = ("SELECT CLASIFICACION FROM CLASIF_EMPRESA WHERE ID_CLASIF='$row[CLASIFICACION]'");
                                    $statement4 = oci_parse($connection, $query4);
                                    $resp4 = oci_execute($statement4);
                                    $clasif = oci_fetch_array($statement4, OCI_BOTH);
                                    $query5 = ("SELECT SECTOR FROM SECTOR_ECONOMICO WHERE ID_SECTOR='$row[SECTOR_ECONOMICO]'");
                                    $statement5 = oci_parse($connection, $query5);
                                    $resp5 = oci_execute($statement5);
                                    $sector = oci_fetch_array($statement5, OCI_BOTH);
                                    $query6 = ("SELECT TIPO_EMPRESA FROM TIPO_EMPRESA WHERE ID_TIPO_EMPRESA='$row[TIPO_EMPRESA]'");
                                    $statement6 = oci_parse($connection, $query6);
                                    $resp6 = oci_execute($statement6);
                                    $t_em = oci_fetch_array($statement6, OCI_BOTH);
                                    ?>
                                    <td><?php echo $e; ?></td>
                                    <td><?php echo $row["NIT_EMPRESA"]; ?></td>
                                    <td><?php echo $row["NOMBRE_EMPRESA"]; ?></td>
                                    <td><?php echo utf8_encode($tam[0]); ?></td>
                                    <td><?php echo $row["NUM_EMPLEADOS"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Sigla</th>
                                    <th>Dirección</th>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Teléfono</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row["SIGLA_EMPRESA"]; ?></td>
                                    <td><?php echo $row["DIRECCION"]; ?></td>
                                    <td><?php echo $row["ID_DEPARTAMENTO"]; ?></td>
                                    <td><?php echo $row["ID_MUNICIPIO"]; ?></td>
                                    <td><?php echo $row["TELEFONO"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <th>Gerente</th>
                                    <th>Clasificación Empresa</th>
                                    <th>Sector Económico</th>
                                    <th>Tipo Empresa</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row["FAX"]; ?></td>
                                    <td><?php echo $row["GERENTE"]; ?></td>
                                    <td><?php echo $clasif[0]; ?></td>
                                    <td><?php echo $sector[0]; ?></td>
                                    <td><?php echo $t_em[0]; ?></td>
                                </tr>

                            </table>
                            <?php
                            $numero++;
                        }
                        ?>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Población que atiende el Proyecto</strong></legend>
                        <table>
                            <?PHP
                            $query23 = ("SELECT LINEA FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement23 = oci_parse($connection, $query23);
                            $resp23 = oci_execute($statement23);
                            $linea = oci_fetch_array($statement23, OCI_BOTH);
                            $query24 = ("SELECT TP1 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement24 = oci_parse($connection, $query24);
                            $resp24 = oci_execute($statement24);
                            $tp1 = oci_fetch_array($statement24, OCI_BOTH);
                            $query25 = ("SELECT TP2 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement25 = oci_parse($connection, $query25);
                            $resp25 = oci_execute($statement25);
                            $tp2 = oci_fetch_array($statement25, OCI_BOTH);
                            $query26 = ("SELECT TP3 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement26 = oci_parse($connection, $query26);
                            $resp26 = oci_execute($statement26);
                            $tp3 = oci_fetch_array($statement26, OCI_BOTH);
                            $query27 = ("SELECT TP4 FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement27 = oci_parse($connection, $query27);
                            $resp27 = oci_execute($statement27);
                            $tp4 = oci_fetch_array($statement27, OCI_BOTH);

                            $query333 = ("SELECT DISTINCT ID_EVALUADOR FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                            $statement333 = oci_parse($connection, $query333);
                            $resp333 = oci_execute($statement333);
                            $idev = oci_fetch_array($statement333, OCI_BOTH);
                            ?>
                            <tr>
                                <th>Línea de Atención</th>
                                <th>Tipo de Población</th>
                            </tr>
                            <tr>
                                <?php if ($nit == null) { ?>

                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="checkbox" checked disabled name="la">Demanda Social</input></td>
                                    <?php if ($tp1[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>       
                                <?php }
                                ?> 
                                <?php if ($tp2[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php }
                                ?> 
                                <?php if ($tp3[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php }
                                ?>
                                <?php if ($tp4[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                    <?php
                                }
                                ?>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <td rowspan="5" width="20%" ><input type="checkbox" checked disabled name="la">Alianza</input></td>

                                <?php if ($tp1[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>       
                                <?php }
                                ?> 
                                <?php if ($tp2[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php }
                                ?> 
                                <?php if ($tp3[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                <?php }
                                ?>
                                <?php if ($tp4[0] == 1) { ?>
                                    <tr><td><input type="checkbox" disabled checked  name="al"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                <?php } else {
                                    ?>
                                    <tr><td><input type="checkbox" disabled  name="al"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                    <?php
                                }
                                ?>

                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Requerimientos del Proyecto</strong></legend>
                        <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr rowspan="3" >
                                <th rowspan="2">DESCRIPCIÓN</th>
                                <th colspan="3">SENA</th>
                                <th colspan="3">EMPRESA</th>
                            </tr>
                            <tr>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                                <th>TOTAL</th>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                                <th>TOTAL</th>
                            </tr>


                            </tr>
                            <?php
                            $query = "SELECT * FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='$proyecto'";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                ?>
                                <tr>
                                    <?php
                                    $query3 = ("SELECT descripcion from requerimiento where id_requerimiento =  '$row[ID_ACTIVIDAD]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $des = oci_fetch_array($statement3, OCI_BOTH);
                                    ?>
                                    <td><?php echo utf8_encode($des[0]); ?></td>
                                    <td align="center"><?php echo $row["CANTIDAD_SENA"]; ?></td>
                                    <td align="right"><?php echo '$' . $row["VAL_UNIT_SENA"]; ?></td>
                                    <td align="right"><?php echo '$' . ($row["CANTIDAD_SENA"] * $row["VAL_UNIT_SENA"]) ?></td>
                                    <td align="center"><?php echo $row["CANTIDAD_EMPRESA"]; ?></td>
                                    <td align="right"><?php echo '$' . $row["VAL_UNIT_EMPRESA"]; ?></td>
                                    <td align="right"><?php echo '$' . ($row["CANTIDAD_EMPRESA"] * $row["VAL_UNIT_EMPRESA"]) ?></td>
                                    <?php
                                    $t1+=($row["CANTIDAD_SENA"] * $row["VAL_UNIT_SENA"]);
                                    $t2+=($row["CANTIDAD_EMPRESA"] * $row["VAL_UNIT_EMPRESA"]);
                                    ?>

                                </tr>
                                <?php
                                $numero++;
                            }
                            ?>
                            <tr>
                                <td><stong>TOTAL</stong></td>
                            <td colspan="3" align="right"><?php echo '$' . $t1 ?></td>
                            <td colspan="3" align="right"><?php echo '$' . $t2 ?></td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Cronograma de Actividades</strong></legend>
                        <table align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt"><tr>


                                <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                                <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIONES POST ENTREGA INSTRUMENTOS</b></font></th>
                            </tr>
                            <?php
                            $query = "SELECT * FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$proyecto' ORDER BY FECHA_INICIO ASC";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                ?>
                                <tr>
                                    <?php
                                    $query3 = ("SELECT descripcion from actividades where id_actividad =  '$row[ID_ACTIVIDAD]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $des = oci_fetch_array($statement3, OCI_BOTH);
                                    ?>
                                    <td><?php echo utf8_encode($des[0]); ?></td>
                                    <td><?php echo $row["FECHA_INICIO"]; ?></td>
                                    <td><?php echo $row["FECHA_FIN"]; ?></td>
                                    <td><?php echo $row["RESPONSABLE"]; ?></td>
                                    <td><?php echo $row["OBSERVACION"]; ?></td>
                                    <td><?php echo $row["OBSERVACIONES_INSTRUMENTOS"]; ?></td>

                                </tr>
                                <?php
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Evaluadores Asociados al Proyecto</strong></legend>
                        <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Email </th>
                                <th>Celular</th>
                                <th>Teléfono</th>
                                <th>Certif</th>
                                <th>Número de Certificado</th>
                            </tr>
                            <?php
                            $query333 = ("SELECT DISTINCT ID_EVALUADOR FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                            $statement333 = oci_parse($connection, $query333);
                            oci_execute($statement333);
                            $num = 0;
                            while ($row333 = oci_fetch_array($statement333, OCI_BOTH)) {

                                $query = "SELECT * FROM EVALUADOR WHERE DOCUMENTO=$row333[ID_EVALUADOR]";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    ?>
                                    <tr><?php
                                        if ($row["T_DOCUMENTO"] == 1) {
                                            $e = "TI";
                                        } else if ($row["T_DOCUMENTO"] == 2) {
                                            $e = "CC";
                                        } else {
                                            $e = "CE";
                                        }

                                        if ($row["CERTIFICADO"] == 1) {
                                            $c = "Si";
                                        } else {
                                            $c = "No";
                                        }
                                        ?>

                                        <td><?php echo $row["DOCUMENTO"]; ?></td>
                                        <td><?php echo $row["NOMBRE"]; ?></td>
                                        <td><?php echo $row["EMAIL"]; ?></td>
                                        <td><?php echo $row["CELULAR"]; ?></td>
                                        <td><?php echo $row["IP"]; ?></td>
                                        <td><?php echo $c; ?></td>
                                        <td><?php echo $row["N_CERTI"]; ?></td>
                                    </tr>


                                    <?php
                                    $num++;
                                }
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Grupos-Normas-Evaluadores</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th><strong>Código Mesa</strong></th>
                                <th><strong>Mesa</strong></th>
                                <th><strong>Código Norma</strong></th>
                                <th><strong>Versión</strong></th>
                                <th><strong>Título Norma</strong></th>
                                <th><strong>N° Personas Asociadas</strong></th>
                                <th><strong>Ver Grupos NCL</strong></th>
                                <!--<th><strong>Ver candidatos</strong></th>-->
                                
                            </tr>
                            <?php
                            $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement8 = oci_parse($connection, $query8);
                            $resp8 = oci_execute($statement8);
                            $pro = oci_fetch_array($statement8, OCI_BOTH);

                            $q = "select id_norma from detalles_poa where id_provisional='$pro[0]'";
                            $statement3 = oci_parse($connection, $q);
                            oci_execute($statement3);
                            $numero3 = 0;
                            while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {
                                $query = "select mesa.nombre_mesa,norma.codigo_mesa,norma.codigo_norma,norma.version_norma,
                                norma.titulo_norma,norma.id_norma from norma
                                join mesa
                                on mesa.codigo_mesa=norma.codigo_mesa
                                where norma.id_norma='$row3[ID_NORMA]'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    $query23 = ("select count(*) from candidatos_proyecto where id_proyecto='$proyecto' and id_norma='$row3[ID_NORMA]'");
                                    $statement83 = oci_parse($connection, $query23);
                                    $resp83 = oci_execute($statement83);
                                    $tot = oci_fetch_array($statement83, OCI_BOTH);

                                    echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                    $row["CODIGO_MESA"] . "</font></td>";
                                    echo "<td width=\"5%\"><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_MESA"]) . "</font></td>";
                                    echo "<td width=\"5%\"><font face=\"verdana\">" .
                                    $row["CODIGO_NORMA"] . "</font></td>";
                                    echo "<td width=\"2%\"><font face=\"verdana\">" .
                                    $row["VERSION_NORMA"] . "</font></td>";
                                    echo "<td width=\"25%\"><font face=\"verdana\">" .
                                    utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                    echo "<td width=\"2%\"><font face=\"verdana\">" .
                                    $tot[0] . "</font></td>";
                                    echo "<td width=\"\"><a href=\"./grupo_consulta.php?norma=$row3[ID_NORMA]&proyecto=" . $proyecto . "\" >
                                Consultar</a></td></tr>";
//                                    echo "<td width=\"\"><a href=\"./consultar_candidatos_norma_bnc.php?norma=$row3[ID_NORMA]&proyecto=" . $proyecto . "\" >
//                                Consultar</a></td></tr>";
                                    $numero3++;
                                }
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>

                



                    <fieldset>
                        <legend><strong>Compromisos</strong></legend>
                        <table>
                            <tr>
                                <th colspan="2">COMPROMISOS EMPRESA</th>
                                <td>
                                    La empresa, gremio, asociación u organización se compromete a: <br></br>

                                    • Designar una persona que coordine la planeación y ejecución del Proyecto.<br>
                                    • Postular personal experto en las funciones productivas a evaluar, como candidato a ser  Evaluador. <br>
                                    • Garantizar ambientes de evaluación como sitios reales de trabajo de los candidatos. <br>
                                    • Proveer los materiales y equipos necesarios para llevar a cabo la evaluación. <br>
                                    • Facilitar expertos técnicos para la construcción de ítems e indicadores de evaluación, que garanticen las herramientas
                                    &nbsp;&nbsp;&nbsp;necesarias para la ejecución del procedimiento. <br>
                                    • Notificar las novedades durante el desarrollo de la evaluación y después de otorgada la certificación.<br>
                                    • Asistir y participar en la auditoría  en el  lugar, fecha  y hora acordados.<br>
                                    • Diligenciar las encuestas de servicio e impacto de PECCL en caso de ser seleccionados. <br>
                                    • Asumir los costos y recursos representados en:<br></br>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Tiempos asignados y desplazamientos de evaluadores y coordinador del proceso.<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Tiempos requeridos para la evaluación de los candidatos.<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Reproducciones de los registros o instrumentos utilizados.<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Portafolios cuando esto aplique.<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;o Ambientes de trabajo como sitios de recolección de evidencias.<br>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">COMPROMISOS SENA</th>
                                <td>
                                    El SENA se compromete a: <br></br>

                                    • Formar evaluadores en caso de ser necesario.<br>
                                    • Acompañar permanentemente el proceso por parte del Líder de ECCL o su delegado. <br>
                                    • Coordinar la elaboración de ítems o indicadores de evaluación cuando no existan en el Banco Nacional de Instrumentos.<br>
                                    • Suministrar instrumentos de evaluación existentes en el Banco Nacional de Instrumentos (BNI)
                                    para la Valoración de &nbsp;&nbsp;&nbsp;Evidencias. <br>
                                    • Designar auditor para cada proceso. <br>
                                    • Generar el Certificado de Competencia Laboral cuando los candidatos con emisión de  juicio  <br>
                                    &nbsp;&nbsp;&nbsp;“Competente” no presenten ningún hallazgo abierto en el  informe de auditoría y en el término <br>
                                    &nbsp;&nbsp;&nbsp;establecido en esta Guía.  
                                </td>
                            </tr>
                            <?php
                            $query5 = ("SELECT ID_ESTADO_PROYECTO FROM PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                            $statement5 = oci_parse($connection, $query5);
                            $resp5 = oci_execute($statement5);
                            $id = oci_fetch_array($statement5, OCI_BOTH);
                            ?>

                            <?php
                            if ($id[0] == 1) {
                                $query3 = ("SELECT compromisos from proyecto where id_proyecto =  '$proyecto'");
                                $statement3 = oci_parse($connection, $query3);
                                $resp3 = oci_execute($statement3);
                                $comp = oci_fetch_array($statement3, OCI_BOTH);
                                ?><tr><th colspan="2">OTROS COMPROMISOS</th><td><textarea name="compromisos" disabled rows="5" cols="80"><?php echo $comp[0] ?></textarea></td></tr>
                                <?php
                            } else {
                                ?><tr><th colspan="2">OTROS COMPROMISOS</th><td><textarea name="compromisos" readonly rows="5" cols="80"  ><?php echo $comp[0] ?></textarea></td></tr>
                                            <?php } ?>
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