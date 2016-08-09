<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
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
        <script language="JavaScript" src="calendario/javascripts.js"></script>

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

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                include ("calendario/calendario.php");

                $proyecto = $_GET["proyecto"];
                ?>
                <br>
                <center><strong>Cronograma del Proyecto</strong></center>
                </br>

                <br>
                <p align="justify">
                    <strong>NOTA IMPORTANTE : Deberá diligenciar las 18 actividades en su totalidad, teniendo en cuenta
                        las fechas de inicio, fecha final y el responsable de cada una de las 
                        actividades.</strong>
                </p>
                </br>

                <form name="formmapa" 
                      action="guardar_cronograma_n.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >

                    <table border="1">

                        <tr>
                            <th>DESCRIPCIÓN DE LAS ACTIVIDADES</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FINAL</th>
                            <th>RESPONSABLE </th>
                            <th>OBSERVACIONES </th>


                        </tr>
                        <tr>
                            <td>
                                <Select Name="actividad" style=" width:150px" >

                                    <?PHP
                                    $query2 = ("SELECT * FROM ACTIVIDADES");

                                    $statement2 = oci_parse($connection, $query2);
                                    oci_execute($statement2);

                                    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                        $id_m = $row["ID_ACTIVIDAD"];
                                        $nombre_m = $row["DESCRIPCION"];

                                        echo "<OPTION value=" . $id_m . ">", utf8_encode($row["DESCRIPCION"]), "</OPTION>";
                                    }
                                    ?>

                                </Select>

                            </td>

                            <td  class='BA'>
                                <?php
                                escribe_formulario_fecha_vacio("fi", "formmapa");
                                ?>
                            </td>
                            <td  class='BA'>
                                <?php
                                escribe_formulario_fecha_vacio("ff", "formmapa");
                                ?>

                            </td>
                            <td><input type="text"  name="responsable"></input></td>
                            <td><textarea rows="4" cols="50" name="obs"></textarea></td>

                        </tr>

                    </table>

                    <br></br>
                    <center><p><label>
                                <a href = "verproyectos_n.php"> Volver </a>
                                <br></br>
                                <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                            </label></p>

                </form>
                <div>

                </div>
                <br></br>
                <form>
                    <table align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt"><tr>


                            <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                            <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                            <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$proyecto'";
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
                                <td><?php echo $row["OBSERVACIONES"]; ?></td>

                            </tr>


                            <?php
                            $numero++;
                        }
                        ?>


                    </table><br></br>
                </form>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>



    </body>
</html>