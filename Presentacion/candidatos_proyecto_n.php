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
                    <center><strong>Información Candidato del Proyecto</strong></center>
                </br>
                <center><strong>NOTA: Solo se pueden asociar aspirantes registrados </strong></center>

                <form name="formmapa" action="guardar_depto.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >
                    <table width="200" border="1" color="#99CCCC" align="center">
                        <th colspan="2">Registrar Nuevo Usuario</th>
                        <tr>
                            <td>ID</td>
                            <?php
                            if ($_GET["id"] == null) {
                                ?>
                                <td><input name="id" type="text" readonly value="NO DISPONIBLE "></input>
                                    <?php
                                } else {
                                    ?>
                                    <td><input name="id" type="text" readonly value="<?php echo $_GET["id"] ?>"></input>
                                        <?php
                                    }
                                    ?>

                                    </tr>
                                    <tr>
                                        <td>Número de Documento</td>
                                        <td><input name="documento" id="documento" maxlength="15" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["documento"] ?>">
                                            </input>
                                            <input type="button" value="Validar doc" onkeypress="validar();" class="botones" onClick="window.location = 'validar_doc_n.php?proyecto=<?php echo $proyecto ?>&doc=' + document.getElementById('documento').value"></input><br>
<?php
if ($_GET["id"] == null) {

    ECHO "POR FAVOR REGISTRAR";
}
?>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Nombre(s)</label></td>
                                        <td><input name="nombre" type="text" readonly value="<?php echo $_GET["nombre"] ?>"></input>
                                    </tr>
                                    <tr>
                                        <td><label>Primer Apellido</label></td>
                                        <td><input name="apellido" type="text" readonly value="<?php echo $_GET["apellido"] ?>"></input>
                                    </tr>
                                    <tr>
                                        <td><label>Segundo Apellido</label></td>
                                        <td><input name="apellido2" type="text" readonly value="<?php echo $_GET["apellido2"] ?>"></input>
                                    </tr>
<?php
$query2 = ("SELECT * FROM DEPARTAMENTO");
$statement2 = oci_parse($connection, $query2);
oci_execute($statement2);
?>
                        <tr>
                            <td>Departamento</td>
                            <td><select id="cont" name="departamento" onchange="load(this.value)">

<option value="">Seleccione</option>

<?php

while ($row = oci_fetch_array($statement2, OCI_BOTH)) {

?>

 <option value="<?php echo $row[ID_DEPARTAMENTO]; ?>"><?php echo $row[NOMBRE_DEPARTAMENTO]; ?></option>

<?php } ?>

</select>


<div id="myDiv"></div></td>
                        </tr>
                        <tr><td></td><td rowspan="2"><p><label>
                                <input type="submit" onclick="return validarv();" name="Guardar" id="insertar" value="Guardar Ubicación" accesskey="I" />
                        </label></p></td></tr>
                                    </table>
                                    <br></br>

<?php
if ($_GET["nombre"] == 'No Registrado' || $_GET["nombre"] == null) {

    echo "No Disponible";
} else {
    ?>
                                        <a href="../Presentacion/candidatoncl_n.php?id=<?php echo $_GET["id"] ?>&proyecto=<?php echo $proyecto ?>">Asociar Normas</a></center></center>
                                        <?php
                                    }
                                    ?>
                                    </form>
               

                                    <br></br>

                                    <center><form>
                                            <table>
                                                <tr>
                                                    <th>Tipo Documento</th>
                                                    <th>Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Primer Apellido</th>
                                                    <th>Segundo Apellido</th>
                                                    <th>Normas Asociadas</th>
                                                </tr>

<?php
$query = "SELECT DISTINCT usuario.tipo_doc, usuario.documento,
usuario.nombre, usuario.primer_apellido,usuario.segundo_apellido,usuario.usuario_id
FROM usuario
INNER JOIN candidatos_proyecto 
ON candidatos_proyecto.id_candidato = usuario.usuario_id
WHERE candidatos_proyecto.id_proyecto = '$proyecto'";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numero = 0;
while ($row = oci_fetch_array($statement, OCI_BOTH)) {


    if ($row["TIPO_DOC"] == 1) {
        $e = "TI";
    } else if ($row["TIPO_DOC"] == 2) {
        $e = "CC";
    } else {
        $e = "CE";
    }


    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $e . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["DOCUMENTO"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["NOMBRE"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["PRIMER_APELLIDO"] . "</font></td>";
    echo "<td width=\"10%\"><font face=\"verdana\">" .
    $row["SEGUNDO_APELLIDO"] . "</font></td>";
    echo "<td width=\"15%\"><a href=\"./candidato_ncl_n.php?proyecto=" . $proyecto . "&documento=" . $row["USUARIO_ID"] . "\" >
                                Ver</a></td></tr>";

    $numero++;
}
?>
                                            </table><br></br>
                                        </form></center>

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