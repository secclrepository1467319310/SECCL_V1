<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

require_once('../Clase/conectar.php');
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
        <link type="text/css" href="../css/encuestaLive.css" rel="stylesheet">
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
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <b>AREAS CLAVES NACIONALES AÑO 2016</b>
                <br><br>
                <form action="" >
                    <center><table id='demotable1'>

                            <thead><tr>
                                    <th>Código de Regional</th>
                                    <th>Regional</th>
                                    <th>Código de Centro</th>
                                    <th>Centro</th>
                                    <!--<th>Registrar Áreas Claves</th>-->
                                    <th>Consultar Áreas Claves</th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
//Cuando se active el rol general se aplica este querty
//$query = "SELECT CODIGO_CENTRO,NOMBRE_CENTRO FROM CENTRO where CODIGO_REGIONAL='$reg[0]'";

                            $query = "SELECT CENTRO.NOMBRE_CENTRO, CENTRO.CODIGO_CENTRO, "
                                    . "REGIONAL.NOMBRE_REGIONAL, REGIONAL.CODIGO_REGIONAL FROM "
                                    . "REGIONAL INNER JOIN CENTRO ON CENTRO.CODIGO_REGIONAL = REGIONAL.CODIGO_REGIONAL "
                                    . "ORDER BY REGIONAL.NOMBRE_REGIONAL ASC";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                $query6 = ("SELECT COUNT(*) FROM AREAS_CLAVES WHERE CODIGO_CENTRO='$row[CODIGO_CENTRO]'");
                                $statement6 = oci_parse($connection, $query6);
                                $resp6 = oci_execute($statement6);
                                $total = oci_fetch_array($statement6, OCI_BOTH);

                                $query7 = ("SELECT ID_AREA_CLAVE FROM AREAS_CLAVES WHERE CODIGO_CENTRO='$row[CODIGO_CENTRO]'");
                                $statement7 = oci_parse($connection, $query7);
                                $resp7 = oci_execute($statement7);
                                $idarea = oci_fetch_array($statement7, OCI_BOTH);

                                $query63 = ("SELECT nombre_regional FROM regional where CODIGO_REGIONAL =  '$row[CODIGO_REGIONAL]'");
                                $statement63 = oci_parse($connection, $query63);
                                $resp63 = oci_execute($statement63);
                                $nomreg = oci_fetch_array($statement63, OCI_BOTH);


                                echo "<td width=\"\"><font face=\"verdana\">" .
                                $row["CODIGO_REGIONAL"] . "</font></td>";
                                echo "<td width=\"\"><font face=\"verdana\">" .
                                utf8_encode($nomreg[0]) . "</font></td>";
                                echo "<td width=\"\"><font face=\"verdana\">" .
                                $row["CODIGO_CENTRO"] . "</font></td>";
                                echo "<td width=\"\"><font face=\"verdana\">" .
                                utf8_encode($row["NOMBRE_CENTRO"]) . "</font></td>";
//                                    if ($total[0] > 0) {
//                                        echo "<td width=\"\">Ya Registradas</a></td>";
//                                    } else {
//                                        echo "<td width=\"\"><a href=\"./crear_area.php?centro=" . $row["CODIGO_CENTRO"] . "\" >
//                                Registrar</a></td>";
//                                        echo "<td width=\"\">No Disponible</a></td></tr>";
//                                    }
                                echo "<td width=\"\"><a href=\"./consultar_areas.php?centro=$row[CODIGO_CENTRO]&idarea=" . $idarea[0] . "\" TARGET=\"_blank\">
                                Consultar</a></td></tr>";
//    if ($idarea[0]==NULL) {
//    echo "<td width=\"\">No Disponible</a></td></tr>";      
//    }else{
//    echo "<td width=\"\"><a href=\"./consultar_areas.php?centro=$row[CODIGO_CENTRO]&idarea=" . $idarea[0] . "\" TARGET=\"_blank\">
//                                Consultar</a></td></tr>";
//    }



                                $numero++;
                            }
                            oci_close($connection);
                            ?>
                        </table>
                    </center>
                </form>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>