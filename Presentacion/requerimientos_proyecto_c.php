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
                <center><strong>Requerimientos del Proyecto </strong></center>
                </br>

                <form action="guardar_requerimiento_c.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8">

                    <center><table border="1">

                            <tr rowspan="3" >
                                <th rowspan="2">DESCRIPCIÓN</th>
                                <th colspan="2">SENA</th>
                                <th colspan="2">EMPRESA</th>
                                <th rowspan="2" >Descripción (Otros)</th>
                            </tr>
                            <tr>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                                <th>CANTIDAD</th>
                                <th>V.UNITARIO</th>
                            </tr>

                            <tr>
                                <td>
                                    <Select Name="requerimiento"  style=" width:150px" >

                                        <?PHP
                                        $query2 = ("SELECT * FROM REQUERIMIENTO WHERE ID_REQUERIMIENTO NOT IN (SELECT ID_ACTIVIDAD FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='$proyecto')");
					//echo $query2;
                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);
                                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                            $id_m = $row["ID_REQUERIMIENTO"];
                                            $nombre_m = $row["DESCRIPCION"];

                                            echo "<OPTION value=" . $id_m . ">", utf8_encode($nombre_m), "</OPTION>";
                                        }
                                        ?>

                                    </Select>

                                </td>
                                <td><input type="text" size="5" name="sena_cantidad" onKeyPress="return validar(event)"></input></td>
                                <td><input type="text" size="5" name="sena_val_unit" onKeyPress="return validar(event)"></input></td>
                                <td><input type="text" size="5" name="empresa_cantidad" onKeyPress="return validar(event)"></input></td>
                                <td><input type="text" size="5" name="empresa_val_unit" onKeyPress="return validar(event)"></input></td>
                                <td><input type="text" name="obs" onKeyPress="return validar(event)"></input></td>
                            </tr>

                        </table></center>
                    <br></br>

                    <center>
                        <p><label>
                                <a href="verproyectos_c.php"> Siguiente     </a>
                                <br></br>
                                <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I" />
                            </label></p> 
                </form>
                <div>

                </div>
                <br></br>
                <form>
                    <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                        <tr rowspan="3" >
                            <th rowspan="2">DESCRIPCIÓN</th>
                            <th colspan="3">SENA</th>
                            <th colspan="4">EMPRESA</th>
                            <th rowspan="2">DESCRIPCIÓN</th>
                        </tr>
                        <tr>
                            <th>CANTIDAD</th>
                            <th>V.UNITARIO</th>
                            <th>TOTAL</th>
                            <th>CANTIDAD</th>
                            <th>V.UNITARIO</th>
                            <th>TOTAL</th>
                            <th>ELIMINAR</th>
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
                                if ($obs[0] == 0) {
                                    ?>
                                    <td align="right"><a href="eliminar_requerimiento.php?id=<?php echo $row["ID_REQUERIMIENTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td align="right"><a href="eliminar_requerimiento.php?id=<?php echo $row["ID_REQUERIMIENTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <!--<td align="right">No Disponible</td>-->
                                    <?php
                                }
                                $t1+=($row["CANTIDAD_SENA"] * $row["VAL_UNIT_SENA"]);
                                $t2+=($row["CANTIDAD_EMPRESA"] * $row["VAL_UNIT_EMPRESA"]);
                                ?>
                                <td><?php echo utf8_encode($row["OBS"]); ?></td>
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


                    </table><br></br>
                </form>  
                <br></br>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>