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
        <script type="text/javascript">

            function comprobar() {

                valor = document.getElementById('but').value;

                if (valor == 1) {

                    document.f2.tp1.disabled = !document.f2.tp1.disabled;
                    document.f2.nit_empresa.disabled = !document.f2.nit_empresa.disabled;


                }
            }
        </script>
        <script type="text/javascript">

            function comprobar2() {

                valor = document.getElementById('but2').value;

                if (valor == 2) {

                    document.f2.tp.disabled = !document.f2.tp.disabled;
                    document.f2.nit_empresa.enabled = !document.f2.nit_empresa.enabled;

                }
            }
        </script>
        <script language="javascript">
            function validarv()
            {
                while (!document.f2.tp.checked && !document.f2.tp1.checked)
                {
                    window.alert("Seleccione un Tipo de Ejecución");
                    return false;
                }
                return true;
            }
        </script>
        <script language="javascript">
            function validar() {
                var key = window.event.keyCode;
                if (key < 48 || key > 57) {
                    window.event.keyCode = 0;
                }
            }
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
                            <li class="top"><a href="../Presentacion/menubanco.php" class="top_link"><span>Inicio</span></a>
                            </li>
                            <li class="top"><a href="#" class="top_link"><span class="down">PAECCL</span></a>
                                <ul class="sub">
                                    <li><a href="../Presentacion/registrar_poa.php">Registrar</a></li>
                                    <li><a href="../Presentacion/ver_poa.php">Consultar</a></li>
                                </ul>
                                <li class="top"><a href="#" class="top_link"><span class="down">Proyectos</span></a>
                                    <ul class="sub">
                                        <li><a href="../Presentacion/registrar_proyecto.php">Registrar</a></li>
                                        <li><a href="../Presentacion/ver_proyecto.php">Consultar</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="#" class="top_link"><span class="down">Instrumentos</span></a>
                                    <ul class="sub">
                                        <li><a href="cons_instrumentos.php">Consultar</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="#" class="top_link"><span class="down">Banco</span></a>
                                    <ul class="sub">
                                        <li><a href="../Presentacion/solicitar_ins.php">Solicitudes</a></li>
                                        <li><a href="../Presentacion/solicitar_op.php">Aut Oportunidad</a></li>
                                        <li><a href="../Presentacion/solicitar_ie.php">Aut IE STMS</a></li>
                                        <li><a href="../Presentacion/solicitar_contingencia.php">Contingencia</a></li>
                                    </ul> 
                                </li>
                                <li class="top"><a href="#" class="top_link"><span class="down">Directorio</span></a>
                                    <ul class="sub">
                                        <li><a href="http://10.0.1.25/directorio">Dsnft</a></li>
                                        <li><a href="../Presentacion/consultar_dir_e.php">Empresarial</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="#" class="top_link"><span class="down">Novedades</span></a>
                                    <ul class="sub">
                                        <li><a href="../Presentacion/generar_novedad.php">Generar</a></li>
                                        <li><a href="../Presentacion/consultar_novedad.php">Consultar</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="#" class="top_link"><span class="down">Reportes</span></a>
                                    <ul class="sub">
                                        <li><a href="../Presentacion/generar_reporte.php">Generar</a></li>
                                    </ul>
                                </li>
                                <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                        </ul>

                        <div class="bot_redes"><a href= "http://www.facebook.com/sena.general" title="SENA en Facebook" rel="external"><img src="../images/iconos/facebook.jpg" border="0" width="26" height="26" /></a> &nbsp; <a href="http://twitter.com/senacomunica" title="SENA en Twitter" rel="external"><img src="../images/iconos/twitter.jpg" border="0" width="26" height="26" /></a></div>
                    </div>
                </div>
            </div>



            <!-- CONTINUA -->

            <div id="contenedorcito"
                <?php
                include("../Clase/conectar.php");
                
                $plan = $_GET["plan"];
                
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                $query3 = ("SELECT 
   id_centro
FROM centro_usuario 
where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);
                
                
                $query1 = ("SELECT 
   codigo_regional
FROM centro 
where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);
                
                $query2 = ("SELECT 
   codigo_centro
FROM centro 
where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMATO DE REGISTRO DE PROGRAMACIÓN ANUAL PARA EL PROCESO</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong>
                    <strong>Datos Generales</strong><br></br>


                    <form name="f2" action="guardar_ncl.php" method="post" >
                        <br></br>
                        
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                    <table id="demotable1" >
                                <thead><tr>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Mesa</strong></th>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión</strong></th>
                                        <th><strong>Título Norma</strong></th>
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
   n.id_norma ID_NORMA
FROM norma n
INNER JOIN mesa m ON n.codigo_mesa =  m.codigo_mesa
where n.id_norma=";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero=0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    echo "<tr><td width=\"10%\"><font face=\"verdana\">" .
                                    $row["CODIGO_MESA"] . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["NOMBRE_MESA"] . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["CODIGO_NORMA"] . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["VERSION_NORMA"] . "</font></td>";
                                    
                            ?>

                                    <td width="10%"><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                    <input type="hidden" name="usuario" value="<?php echo $login ?>" ></input>

                                    <?php
                                    $numero++;
                                }
                                oci_close($connection);
                                ?>
                            </table>
                        <br></br>
                        <p><label>
                                <input type="submit" onclick="return validarv();" name="insertar" id="insertar" value="Siguiente" accesskey="I" />
                        </label></p>
                        <br></br>
                        
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