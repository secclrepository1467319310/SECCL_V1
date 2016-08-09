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
        <script type="text/javascript" src="js/val_cronogramai_proyecto_c.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="ajax2.js"></script>
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
                ?>
                <br>
                <center><strong>Cronograma de Elaboración de Ítems</strong></center>
                </br>

                <form name="formmapa" id="f1"
                      action="guardar_cronogramai_c.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >

                    <table border="1">

                        <tr>
                            <th>CENTRO</th>
                            <th>NORMA</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FINAL</th>
                            <th>RESPONSABLE </th>
                            <th>N° ÍTEMS </th>
                            <th>OBSERVACIONES </th>
                        </tr>
                        <tr>
                            <td>
                                <Select Name="centro" style=" width:150px" >

                                    <?PHP
                                    $query2 = ("SELECT * FROM CENTRO  order by codigo_centro ASC");

                                    $statement2 = oci_parse($connection, $query2);
                                    oci_execute($statement2);

                                    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                        $id_m = $row["ID_CENTRO"];
                                        $co = $row["CODIGO_CENTRO"];
                                        $nombre_m = $row["NOMBRE_CENTRO"];

                                        echo "<OPTION value=" . $id_m . ">", $co . ' - ' . utf8_encode($nombre_m), "</OPTION>";
                                    }
                                    ?>

                                </Select>

                            </td>
                            <?php
                            $query2 = ("SELECT * FROM MESA");
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            ?>


                            <td><select id="cont" name="departamento" onchange="load(this.value)" style=" width:100px">

                                    <option value="">Seleccione</option>

                                    <?php
                                    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                        ?>

                                        <option value="<?php echo $row[CODIGO_MESA]; ?>"><?php echo utf8_encode($row[NOMBRE_MESA]); ?></option>

                                    <?php } ?>

                                </select>
                                <div id="myDiv"></div>
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
                            <td><Select Name="constructor" style=" width:150px" >

                                    <?PHP
                                    $query25 = ("SELECT * FROM CONSTRUCTOR_ITEMS WHERE ID_PROYECTO='$proyecto'");

                                    $statement25 = oci_parse($connection, $query25);
                                    oci_execute($statement25);

                                    while ($row = oci_fetch_array($statement25, OCI_BOTH)) {
                                        $id_m = $row["ID_CONSTRUCTOR"];
                                        $nombre_m = $row["NOMBRE"];

                                        echo "<OPTION value=" . $id_m . ">" . utf8_encode($nombre_m) . "</OPTION>";
                                    }
                                    ?>

                                </Select>
                                <br><a href="registrar_constructor_c.php?proyecto=<?php echo $proyecto ?>">Registrar Constructor</a></td>
                            <td><input type="text"  name="nitems" size="2"></input></td>
                            <td><textarea rows="2" cols="30" name="obs"></textarea></td>

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
                    <table align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt">
                        <tr>
                            <th>CENTRO</th>
                            <th>NORMA</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FINAL</th>
                            <th>RESPONSABLE </th>
                            <th>N° ÍTEMS </th>
                            <th>OBSERVACIONES </th>
                            <th>ELIMINAR </th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM CRONOGRAMA_ITEMS WHERE ID_PROYECTO='$proyecto'";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <?php
                                $query3 = ("SELECT nombre_centro from centro where id_centro =  '$row[ID_CENTRO]'");
                                $statement3 = oci_parse($connection, $query3);
                                $resp3 = oci_execute($statement3);
                                $cen = oci_fetch_array($statement3, OCI_BOTH);
                                $query32 = ("SELECT titulo_norma from norma where id_norma =  '$row[ID_NORMA]'");
                                $statement32 = oci_parse($connection, $query32);
                                $resp32 = oci_execute($statement32);
                                $norma = oci_fetch_array($statement32, OCI_BOTH);
                                $query33 = ("SELECT nombre from constructor_items where id_constructor =  '$row[ID_CONSTRUCTOR]'");
                                $statement33 = oci_parse($connection, $query33);
                                $resp33 = oci_execute($statement33);
                                $cons = oci_fetch_array($statement33, OCI_BOTH);
                                ?>
                                <td><?php echo $cen[0]; ?></td>
                                <td><?php echo utf8_encode($norma[0]); ?></td>
                                <td><?php echo $row["F_INICIAL"]; ?></td>
                                <td><?php echo $row["F_FINAL"]; ?></td>
                                <td><?php echo $cons[0]; ?></td>
                                <td><?php echo $row["NUM_ITEMS"]; ?></td>
                                <td><?php echo $row["OBS"]; ?></td>
                                <?php
                                if ($obs[0] == 0) {
                                    ?>
                                    <td align="right"><a href="eliminar_cronogramai.php?id=<?php echo $row["ID_CRONOGRAMA_ITEMS"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <?php
                                } else {
                                    ?>
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