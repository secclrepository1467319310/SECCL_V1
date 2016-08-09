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
                            <li class="top"><a href="../Presentacion/menuasesor.php" class="top_link"><span>Inicio</span></a>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">PAECCL</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/registrar_poa_n.php">Registrar</a></li>
                                    <li><a href="../Presentacion/ver_poa_n.php">Ver PAECCL NAL</a></li>
                                    <li><a href="../Presentacion/ver_poa_c_n.php">Ver PAECCL CEN</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Proyectos</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/verproyectos_n.php">Nacionales</a></li>
                                    <li><a href="../Presentacion/verproyectos_c_n.php">Centros</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Empresas</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/ficha_empresa_n.php">Registrar</a></li>
                                    <li><a href="../Presentacion/ver_empresa_n.php">Consultar</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                        </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
                <br>
                    <center><strong>Información General del Proyecto</strong></center>
                </br>

                <center>
                    <br>
                        <center><strong>Información General de la Empresa</strong></center>
                    </br>
                    <?php $prov = $_GET['prov']; ?>
                    <form id="registro" action="guardar_proyecto_n.php?prov=<?php echo $prov?>" method="post" >
                        <?php
                        include("../Clase/conectar.php");
                        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                        
                        $query3 = ("SELECT nit_empresa from detalles_poa where id_provisional =  '$prov'");
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

                        <br>
                            <center><strong>Información del Coordinador del Proyecto en la Empresa a Nivel Nacional</strong></center>
                        </br>
                        <?PHP
                        $query2 = "SELECT * FROM COORDINADOR_PROYECTOS WHERE NIT_EMPRESA='$nit[0]'";
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        $num = 0;
                        while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                        ?>
                            <table>
                                <tr>
                                    <th>Tipo ID</th>
                                    <th>Identificación</th>
                                    <th>Nombres</th>
                                    <th>Primer Apellido</th>
                                    <th>Segundo Apellido</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row2["TIPO_DOC"]; ?></td>
                                    <td><?php echo $row2["DOCUMENTO"]; ?></td>
                                    <td><?php echo $row2["NOMBRES"]; ?></td>
                                    <td><?php echo $row2["PRIMER_APELLIDO"]; ?></td>
                                    <td><?php echo $row2["SEGUNDO_APELLIDO"]; ?></td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <th>Cargo</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row2["DIRECCION"]; ?></td>
                                    <td><?php echo $row2["CARGO"]; ?></td>
                                    <td><?php echo $row2["TELEFONO"]; ?></td>
                                    <td><?php echo $row2["CELULAR"]; ?></td>
                                    <td><?php echo $row2["EMAIL"]; ?></td>
                                </tr>
                                
                            </table>
                        <?php
                            $num++;
                        }
                        
                        ?>

                        <br>
                            <br>
                            <center><strong>Información de la población que atiende el proyecto</strong></center>
                        </br>
                        <?php
                        if ($nit[0]==NULL) {?>
                            
                            <table>
                                <tr>
                                    <th>Línea de Atención</th>
                                    <th>Tipo de Población</th>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="radio" disabled="disabled" >Alianza</input></td>
                                <tr><td><input type="checkbox" value="1" disabled="disabled" name="al1"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al2"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al3"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al4"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="radio" value="1" checked="checked"  name="la">Demanda Social</input></td>
                                    <tr><td><input type="checkbox" value="1"  name="al1"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al2"></input><strong>• Independientes:</strong>Propietarios de micro-empresa, pequeña empresa o personas que trabajan por cuenta propia.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al3"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al4"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="checkbox" disabled name="la">Atención Diferencial</input></td>
                                    <tr><td><input type="checkbox" value="1" disabled name="al5"></input><strong>• Víctimas:</strong>se refiere aquellas personas que individual
                                            o colectivamente hayan sufrido un daño por hechos ocurridos a partir del 1º de enero de 1985,
                                            como consecuencia de infracciones al Derecho Internacional Humanitario o de violaciones
                                            graves y manifiestas a las normas internacionales de Derechos Humanos, ocurridas con
                                            ocasión del conflicto armado interno y que están contempladas dentro de la clasificación 
                                            de la <a href="http://www.unidadvictimas.gov.co/" target="blank" >Ley 1448 de 2011.</a></td></tr>
                                </tr>
                            </table>
                        </br>
                        <p><label>
                         <input type="submit" name="insertar" id="insertar" value="Crear Proyecto" accesskey="I" />
                         </label></p>
                          <?php
                        }else{
                             ?>
                         <table>
                                <tr>
                                    <th>Línea de Atención</th>
                                    <th>Tipo de Población</th>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="radio" checked="checked" value="2" name="la">Alianza</input></td>
                                <tr><td><input type="checkbox" value="1"  name="al1"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de la empresa.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al2"></input><strong>• Independientes:</strong>Propietarios de micro-empresas, pequeña empresa o personas que trabajan por cuenta propia y son  presentadas por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al3"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual, presentados por gremios, asociaciones o grandes empresas que se comprometen a dar pleno cumplimiento a lo pactado en esta línea de atención.</td></tr>
                                    <tr><td><input type="checkbox" value="1"  name="al4"></input><strong>• Funcionarios:</strong>Trabajadores con relación laboral o contratistas que se  desempeñan en el SENA.</td></tr>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="radio" disabled="disabled" >Demanda Social</input></td>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al1"></input><strong>• Vinculados:</strong>Trabajadores con relación laboral o contratistas de empresas que solicitan el servicio en forma individual, sin presentación por parte de la empresa donde están vinculados.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al2"></input><strong>• Independientes:</strong>Propietarios de micro-empresa, pequeña empresa o personas que trabajan por cuenta propia.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al3"></input><strong>• En Búsqueda de Empleo:</strong>Personas que no tienen vínculo laboral actual.</td></tr>
                                    <tr><td><input type="checkbox" value="1" disabled="disabled" name="al4"></input><strong>• Funcionarios:</strong>Aplica para funcionarios del SENA que se presentan en forma individual y que no están incluidos en proyectos de funcionarios.</td></tr>
                                </tr>
                                <tr>
                                    <td rowspan="5" width="20%" ><input type="checkbox" disabled name="la">Atención Diferencial</input></td>
                                    <tr><td><input type="checkbox" value="1" disabled name="al5"></input><strong>• Víctimas:</strong>se refiere aquellas personas que individual
                                            o colectivamente hayan sufrido un daño por hechos ocurridos a partir del 1º de enero de 1985,
                                            como consecuencia de infracciones al Derecho Internacional Humanitario o de violaciones
                                            graves y manifiestas a las normas internacionales de Derechos Humanos, ocurridas con
                                            ocasión del conflicto armado interno y que están contempladas dentro de la clasificación 
                                            de la <a href="http://www.unidadvictimas.gov.co/" target="blank" >Ley 1448 de 2011.</a></td></tr>
                                </tr>
                            </table>
                        </br>
                        <p><label>
                         <input type="submit" name="insertar" id="insertar" value="Crear Proyecto" accesskey="I" />
                         </label></p>
                         <?php
                        }
                         ?>
                    </form>
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