﻿<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/conectar.php");
include ("calendario/calendario.php");
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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_cronograma_proyecto_c.js"></script>
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
        <script type="text/javascript">

            function fi()
            {
                var kfi = formmapa.fi.value;
                if (kfi == "")
                {
                    alert("escriba la fecha inicial");
                }
            }

            function ff()
            {
                var kff = formmapa.ff.value;
                if (kff == "")
                {
                    alert("Escriba la Fecha de Respuesta");
                }
            }
        </script>

    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $proyecto = $_GET["proyecto"];

                $query1 = ("select id_provisional from proyecto where id_proyecto=  '$proyecto'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $prov = oci_fetch_array($statement1, OCI_BOTH);

                $query3 = ("select count(*) from obs_banco where id_provisional=  '$prov[0]'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $obs = oci_fetch_array($statement3, OCI_BOTH);
                ?>
                <br>
                <center><strong>Cronograma del Proyecto</strong></center>
                </br>

                <br>
                <p align="justify">
                    <strong>NOTA IMPORTANTE : Deberá diligenciar las actividades en su totalidad, teniendo en cuenta
                        las fechas de inicio, fecha final y el responsable de cada una de las 
                        actividades.</strong>
                </p>
                </br>

                <form name="formmapa" id="f1"
                      action="guardar_cronograma_c.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >

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
                                    $query2 = ("SELECT * FROM ACTIVIDADES WHERE (ID_ACTIVIDAD < 4 OR ID_ACTIVIDAD = 19) AND ID_ACTIVIDAD NOT IN (SELECT ID_ACTIVIDAD FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$proyecto')ORDER BY ID_ACTIVIDAD ASC");
				   //echo $query2."<br/>";

                                    $statement2 = oci_parse($connection, $query2);
                                    oci_execute($statement2);

                                    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                        $id_m = $row["ID_ACTIVIDAD"];
                                        $nombre_m = $row["DESCRIPCION"];

                                        echo "<option value=" . $id_m . ">", utf8_encode($row["DESCRIPCION"]), "</option>";
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
                                <a href = "verproyectos_c.php"> Siguiente </a>
                                <br></br>
                                <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                            </label></p>

                </form>
                <div>

                </div>
                <br></br>
                <form>
                    <table align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt"><tr>


                            <th><font face = "verdana"><b>ID CRONO</b></font></th>
                            <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                            <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                            <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                            <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                            <th><font face = "verdana"><b>ELIMINAR</b></font></th>
                            <th><font face = "verdana"><b>NOVEDAD POST ENTREGA INSTRUMENTOS</b></font></th>
                            <th><font face = "verdana"><b>MODIFICAR NOVEDAD</b></font></th>

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
                                <td><?php echo $row["ID_CRONOGRAMA_PROYECTO"]; ?></td>
                                <td><?php echo utf8_encode($des[0]); ?></td>
                                <td><?php echo $row["FECHA_INICIO"]; ?></td>
                                <td><?php echo $row["FECHA_FIN"]; ?></td>
                                <td><?php echo $row["RESPONSABLE"]; ?></td>
                                <td><?php echo $row["OBSERVACIONES"]; ?></td>
                                <?php
                                if ($obs[0] == 0) {
                                    ?>
                                    <td align="right"><a href="eliminar_cronograma.php?id=<?php echo $row["ID_CRONOGRAMA_PROYECTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td align="right"><a href="eliminar_cronograma.php?id=<?php echo $row["ID_CRONOGRAMA_PROYECTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <!--<td align="right">No Disponible</td>-->
                                    <?php
                                }
                                ?>
                                <?php
                                if ($obs[0] > 0) {
                                    ?>
                                    <td align="right"><?php echo $row["OBSERVACIONES_INSTRUMENTOS"]; ?></td>
                                    <td align="right"><a href="observaciones_post_entrega.php?id=<?php echo $row["ID_CRONOGRAMA_PROYECTO"] ?>&proyecto=<?php echo $proyecto ?>" >Modificar Novedad</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td align="right">No Disponible</td>
                                    <td align="right">No Disponible</td>
                                    <?php
                                }
                                ?>
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