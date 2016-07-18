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
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_centros_proyecto_nacional.js" type="text/javascript"></script>
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
                <center>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    </br>
                    <form id="frmCentrosProyectoNacional" action="proyecto_nacional.php" method="post">
                        <label id="valError"></label>
                        <center><table id='demotable1'>
                                <thead><tr>
                                        <th>Código Regional</th>
                                        <th>Regional</th>
                                        <th>Código de Centro</th>
                                        <th>Centro</th>
                                        <th>Seleccionar</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                $fecha = date('Y');
                                $query = "SELECT PA.ID_PLAN, CE.CODIGO_CENTRO, CE.NOMBRE_CENTRO, REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL FROM PLAN_ANUAL PA 
    INNER JOIN CENTRO CE ON PA.ID_CENTRO = CE.CODIGO_CENTRO 
    INNER JOIN REGIONAL REG ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL WHERE SUBSTR(PA.FECHA_ELABORACION, 7,4) = 2016 ORDER BY REG.CODIGO_REGIONAL ASC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["CODIGO_REGIONAL"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_REGIONAL"]) . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $row["CODIGO_CENTRO"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_CENTRO"]) . "</font></td>";
                                    echo "<td width=\"\"><input type=\"checkbox\" name=\"centro[]\" value=\"$row[ID_PLAN]\" /> </td></tr>";


                                    $numero++;
                                }

                                oci_close($connection);
                                ?>
                            </table>

                        </center><br></br>
                        <input type="submit" value="Siguiente" />
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>