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
                <a href="ver_poa_c_n_histo.php">Programacion año 2015</a> || 
                <a href="ver_poa_c_n.php">Programacion año 2016</a>
                <center>
                    <br>
                    <center><?php echo '<font><strong>Programacion 2016</strong></font>'; ?></center>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    </br>
                    <form action="" >
                        <center><table id='demotable1'>

                                <thead><tr>
                                        <th>Radicado PAECCL</th>
                                        <th>Fecha y Hora Elaboración</th>
                                        <th>Fecha y Hora de Última Modificación</th>
                                        <th>Código Regional</th>
                                        <th>Regional</th>
                                        <th>Código de Centro</th>
                                        <th>Centro</th>
                                        <th>Detalles PAECCL</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                $fecha = date('Y');
                                $query = "SELECT ID_PLAN,ID_REGIONAL,ID_CENTRO,FECHA_ELABORACION,ID_PLAN FROM PLAN_ANUAL WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    $query4 = ("select MAX(fecha_registro) from detalles_poa
                where id_plan = $row[ID_PLAN]");
                                    $statement4 = oci_parse($connection, $query4);
                                    $resp4 = oci_execute($statement4);
                                    $max = oci_fetch_array($statement4, OCI_BOTH);


                                    $query5 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$row[ID_REGIONAL]'");
                                    $statement5 = oci_parse($connection, $query5);
                                    $resp5 = oci_execute($statement5);
                                    $nomreg = oci_fetch_array($statement5, OCI_BOTH);

                                    $query6 = ("SELECT nombre_centro FROM centro where CODIGO_CENTRO =  '$row[ID_CENTRO]'");
                                    $statement6 = oci_parse($connection, $query6);
                                    $resp6 = oci_execute($statement6);
                                    $nomcen = oci_fetch_array($statement6, OCI_BOTH);


                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $fecha . '-' . $row["ID_REGIONAL"] . '-' . $row["ID_CENTRO"] . '-' . $row["ID_PLAN"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["FECHA_ELABORACION"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $max[0] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["ID_REGIONAL"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($nomreg[0]) . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["ID_CENTRO"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($nomcen[0]) . "</font></td>";
                                    echo "<td width=\"\"><a href=\"./verdetalles_poa_c.php?centro=$row[ID_CENTRO]&plan=" . $row["ID_PLAN"] . "\" TARGET=\"_blank\">
                                Ver Detalles</a></td></tr>";


                                    $numero++;
                                }



                                oci_close($connection);
                                ?>
                            </table>


                        </center><br></br>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>


    </body>
</html>