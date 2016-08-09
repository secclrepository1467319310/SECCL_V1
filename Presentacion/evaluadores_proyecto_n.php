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
                <?php
                include("../Clase/conectar.php");
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

                $proyecto = $_GET["proyecto"];
                ?>
                <br>
                    <center><strong>Evaluador(es) del Proyecto</strong></center>
                </br>

                <form name="formmapa" action="guardar_evaluador_c.php?proyecto=<?php echo $proyecto ?>" 
                      method="post" accept-charset="UTF-8" enctype="multipart/form-data" >

                    <center>
                        <table id='demotable1'>
                                <tr>
                                        <th><label>ID</label></th>
                                        <td><input name="id" type="text" readonly value="<?php echo $_GET["id"] ?>"></input>
                                    </tr>
                                    
                                <tr>
                                        <th>Número de Documento</th>
                                        <td><input name="documento" id="documento" maxlength="15" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["documento"] ?>">
                                            </input>
                                            <input type="button" value="Validar doc" onkeypress="validar();" class="botones" onClick="window.location = 'validar_doc_ev.php?proyecto=<?php echo $proyecto ?>&doc=' + document.getElementById('documento').value"></input><br>
                                            <?php
                                            if ($_GET["id"] == null) 
                                                {?>
                                                    <!--<a href="registrar_ev.php?proyecto=<?php echo $proyecto ?>&documento=<?php echo $_GET["documento"] ?>">Registrar Evaluador</a>-->
                                                <?php }else if ($_GET["id"]==null || $_GET["estado"]==4) {
 
                                                    ?><a>Evaluador Regisrado</a><?php
                                                }
                                               ?>
                                        </td>
                                    </tr>
                                <tr>
                                        <th><label>Nombre(s)</label></th>
                                        <td><input name="nombre" type="text" readonly value="<?php echo $_GET["nombre"] ?>"></input>
                                    </tr>
                                    <tr>
                                        <th><label>Email</label></th>
                                        <td><input name="email" type="text" readonly value="<?php echo $_GET["email"] ?>"></input>
                                    </tr>
                                    <tr>
                                        <th><label>Estado</label></th>
                                        <?php 
                                          if ($_GET["estado"]==1) {?>
                                              <td><input name="estado" type="text" readonly value="<?php echo "Activo"  ?>"></input></td>
                                              <?php }else if ($_GET["estado"]==0) {?>
                                                  <td><input name="estado" type="text" readonly value="<?php echo "Inactivo"  ?>"></input></td>
                                                      <?php }else if ($_GET["estado"]==3) {?>
                                                      <td><input name="estado" type="text" readonly value="<?php echo "Postulado"  ?>"></input></td>
                                                      <?php }else if ($_GET["estado"]==5) {?>
                                                      <td><input name="estado" type="text" readonly value="<?php echo "En Actualización"  ?>"></input></td>
                                                      <?php }else if ($_GET["estado"]==6) {?>
                                                      <td><input name="estado" type="text" readonly value="<?php echo "Retirado"  ?>"></input></td>
                                                      <?php } ?>
                                    </tr>
                        </table>
                    </center>
                    <br></br>
                    <?php
                                            if ($_GET["documento"] != null) 
                                                {?>
                                            
                    <br>
                        
                            <table id="demotable1">
                                <thead><tr>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Mesa</strong></th>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión</strong></th>
                                        <th><strong>Título Norma</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

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
                                        echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                        $row["CODIGO_MESA"] . "</font></td>";
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["NOMBRE_MESA"] . "</font></td>";
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["CODIGO_NORMA"] . "</font></td>";
                                        echo "<td width=\"2%\"><font face=\"verdana\">" .
                                        $row["VERSION_NORMA"] . "</font></td>";
                                        echo "<td width=\"25%\"><font face=\"verdana\">" .
                                        utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                        ?>

                                        <td width="10%"><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td>

                                        <?php
                                        $numero3++;
                                    }
                                    $numero++;
                                }
                                ?>
                            </table>
                            <br></br>
                            <center><input name="send" type="submit" id="send" value="Asociar"></input></center>
                            <br></br>
                    <a href="verproyectos_c.php"> Siguiente     </a>
                        
                </form>
                <?php }else{
                                                    echo "No es Posible Asociar Normas";
                                                }
                                               ?>
                
                <br></br>
                <form>
                    <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Email SENA</th>
                                
                                
                        </tr>
                        <?php
                        $query8 = ("SELECT ID_EVALUADOR FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                $statement8 = oci_parse($connection, $query8);
                                $resp8 = oci_execute($statement8);
                                $ev = oci_fetch_array($statement8, OCI_BOTH);
                        $query = "SELECT * FROM EVALUADOR WHERE DOCUMENTO='$ev[0]'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                <td><?php echo $row["NOMBRE"]; ?></td>
                                <td><?php echo $row["EMAIL"]; ?></td>
                                
                            </tr>


                            <?php
                            $numero++;
                        }
                        
                        ?>
                    </table><br></br>
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