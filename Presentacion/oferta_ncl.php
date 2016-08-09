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
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
         <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>

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
                            <li class="top"><a href="#" class="top_link"><span class="down">Banco Instrumentos</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/instrumentos_c.php">Consultar</a></li>
                                    <li><a href="../Presentacion/sol_instrumentos_c.php">Consultar</a></li>
                                </ul>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">Portafolio</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/consultar_p_l.php">Mi Portafolio</a></li>
                                    <li><a href="../Presentacion/misdatos_l.php">Mis Datos</a></li>
                                </ul>
                            </li>
                                <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                        </ul>

                        <div class="bot_redes"><a href= "http://www.facebook.com/sena.general" title="SENA en Facebook" rel="external"><img src="../images/iconos/facebook.jpg" border="0" width="26" height="26" /></a> &nbsp; <a href="http://twitter.com/senacomunica" title="SENA en Twitter" rel="external"><img src="../images/iconos/twitter.jpg" border="0" width="26" height="26" /></a></div>
                    </div>
                </div>
            </div>



            <!-- CONTINUA -->

            <div id="">
                <br></br>
                <?php
                include("../Clase/conectar.php");
                include("../Clase/Norma.php");
                include ("calendario/calendario.php");
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                $ob = New Norma();
                $of=$_GET['codigo'];
                
                $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
            $statement5 = oci_parse($connection, $query5);
            $resp5 = oci_execute($statement5);
            $idc = oci_fetch_array($statement5, OCI_BOTH);

            $query3 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
            $statement3 = oci_parse($connection, $query3);
            $resp3 = oci_execute($statement3);
            $reg = oci_fetch_array($statement3, OCI_BOTH);

            $query4 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
            $statement4 = oci_parse($connection, $query4);
            $resp4 = oci_execute($statement4);
            $cen = oci_fetch_array($statement4, OCI_BOTH);

            $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
            $statement7 = oci_parse($connection, $query7);
            $resp7 = oci_execute($statement7);
            $nomreg = oci_fetch_array($statement7, OCI_BOTH);

            $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
            $statement8 = oci_parse($connection, $query8);
            $resp8 = oci_execute($statement8);
            $nomcen = oci_fetch_array($statement8, OCI_BOTH);
                ?>
                <center>
                    <strong>OFERTAS DE PROCESOS DE CERTIFICACIÓN DE COMPETENCIAS LABORALES</strong><BR></BR>
                </center>
                <br></br>
                <center>
                        <form name="formmapa" 
                      action="guardar_oferta_ncl.php?oferta=<?php echo $of ?>" method="post" accept-charset="UTF-8" >
                            <table>
                                <tr>
                                    <th><strong>Código Regional</strong></th><th><strong>Nombre Regional</strong></th><th><strong>Código Centro</strong></th>
                                    <th><strong>Centro</strong></th><th><strong>Líder de ECCL</strong></th><th><strong>Bimestre</strong></th>
                                </tr>
                                <tr>
                                    <td><?php echo $reg[0]; ?></td><td><?php echo $nomreg[0] ?></td><td><?php echo $cen[0]; ?></td>
                                    <td><?php echo $nomcen[0] ?></td><td><?php echo $nom.' '.$ape ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Fecha Inicio</strong></th><th><strong>Fecha Fin</strong></th><th><strong>Estado Oferta</strong></th>
                                    <th><strong>Tipo Oferta</strong></th><th><strong>Código Oferta</strong></th><th><strong>Fecha Publicación</strong></th>
                                </tr>
                                <tr>
                                </tr>
                            </table>
                            <br></br>
                            <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                <table id="demotable1" >
                                <thead><tr>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Nombre Mesa</strong></th>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión Norma</strong></th>
                                        <th><strong>Título Norma</strong></th>
                                        <th><strong>Fecha Expiración Norma</strong></th>
                                        <th><strong>Descripción Norma</strong></th>
                                        <th><strong>Requisitos Norma</strong></th>
                                        <th><strong>Cupo</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                
                                $query = "SELECT 
                                m.codigo_mesa CODIGO_MESA   ,
                                m.nombre_mesa NOMBRE_MESA , 
                                n.codigo_norma   CODIGO_NORMA ,
                                n.version_norma  VERSION_NORMA ,
                                n.titulo_norma TITULO_NORMA ,
                                TO_CHAR(n.expiracion_norma,'dd/mm/yyyy') AS EXPIRACION,
                                n.id_norma ID_NORMA
                                FROM norma n
                                INNER JOIN mesa m ON n.codigo_mesa =  m.codigo_mesa";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero=0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    echo "<tr><td width=\"\"><font face=\"verdana\">" .
                                    $row["CODIGO_MESA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["NOMBRE_MESA"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["CODIGO_NORMA"] . "</font></td>";
                                    echo "<td width=\"\"><center><font face=\"verdana\">" .
                                    $row["VERSION_NORMA"] . "</font></center></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["EXPIRACION"] . "</font></td>";
                                    echo "<td><textarea name=\"descripcion[]\" cols=\"30\" rows=\"3\"></textarea></td></td>";
                                    echo "<td><textarea name=\"requisitos[]\" cols=\"30\" rows=\"3\"></textarea></td></td>";
                                    echo "<td><input type=\"text\" size=\"2\" name=\"cupo[]\"></input></td>";
                                    
                                    $date1 = $row["EXPIRACION"];
                                    $date2 = date("d/m/y");

                                            // Compara Fechas

                                            $d = $ob->restaFechas($date2, $date1);

                                            if ($d > 240) {
                                                ?>
                                        <td width=""><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                        <?php        
                                            } else if ($d <= 240) {
                                                ?>
                                    <td width=""><input name="codigo[]" disabled="disabled" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                            <?php 
                                            
                                            }
                                            $numero++;
                                        }
                                            
                                            ?>
                                </table>
                                    <br></br>
                                    <center><input type="submit" value="Guardar Oferta"></input></center>
                        </form>
                </center>
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