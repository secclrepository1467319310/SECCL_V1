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
            <div id="contenedor">
                <?php
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);

                $query23 = ("SELECT codigo_centro FROM centro  where id_centro =  '$idc[0]'");
                $statement23 = oci_parse($connection, $query23);
                $resp23 = oci_execute($statement23);
                $cen = oci_fetch_array($statement23, OCI_BOTH);
                ?>
                <center>
                    <form>
                        <a id="cleanfilters" href="#">Limpiar Filtros </a> || <a href="../Presentacion/registrar_actores.php?rr=e">Registrar Nuevo Evaluador</a> || <a href="../Presentacion/actualizar_actores.php">Actualizar Evaluador</a>
                        <br></br>
                        <center>
                            <table id="demotable1">
                                <thead>
                                    <tr>
                                        <th>Código Regional</th>
                                        <th>Regional</th>
                                        <th>Código Centro</th>
                                        <th>Centro</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Email SENA</th>
                                        <th>Asociar Especialidad</th>
                                        <th>Consultar Especialidad</th>
                                        <th>Estado</th>
                                        <th>Actualizar Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <?php
                                $query2 = "SELECT 
                                    regional.codigo_regional,
                                    regional.nombre_regional,
                                    centro.codigo_centro,
                                    centro.nombre_centro,
                                    nombre,
                                    documento,
                                    ip,
                                    email,
                                    email2,
                                    obs,
                                    activo
                                    FROM EVALUADOR join REGIONAL
                                    on evaluador.codigo_regional = regional.codigo_regional
                                    join CENTRO
                                    on evaluador.codigo_centro = centro.codigo_centro
                                    where evaluador.codigo_centro=$cen[0]
                                    order by regional.nombre_regional asc";
                                $statement2 = oci_parse($connection, $query2);
                                oci_execute($statement2);

                                $numero = 0;
                                while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                                    if ($row2["ACTIVO"] == 1) {
                                        $es = "Activo";
                                    } else {
                                        $es = "Inactivo";
                                    }
                                    $query5 = ("select count (*) from evaluador_mesa where id_evaluador='$row2[DOCUMENTO]'");
                                    $statement5 = oci_parse($connection, $query5);
                                    $resp5 = oci_execute($statement5);
                                    $t = oci_fetch_array($statement5, OCI_BOTH);


                                    echo "<tr><td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_REGIONAL"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_CENTRO"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_CENTRO"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["DOCUMENTO"] . "</center></font></td>";
                                    echo "<td><a href=\"mailto: $row2[EMAIL]\"><center>" .
                                    utf8_encode($row2["EMAIL"]) . "</center></a></td>";
//    if ($t[0]==0) {
                                    echo "<td width=\"\"><a href=\"./asociar_mesa_evaluador.php?ideva=" . $row2["DOCUMENTO"] . "\" >
                                        Asociar</a></td>";
//    }else{
                                    echo "<td width=\"\"><a href=\"./consultar_norma_evaluador.php?documento=" . $row2["DOCUMENTO"] . "\" >
                                        Consultar</a></td>";
//    }
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $es . "</center></font></td>";
                                    if ($row2["ACTIVO"] == 1) {
                                        echo "<td width=\"\"><a href=\"./cambio_estado_evaluador.php?es=0&ida=" . $row2["DOCUMENTO"] . "\" >
                                        Inactivar</a></td></tr>";
                                    } else {
                                        echo "<td width=\"\"><a href=\"./cambio_estado_evaluador.php?es=1&ida=" . $row2["DOCUMENTO"] . "\" >
                                        Activar</a></td></tr>";
                                    }


                                    $numero++;
                                }

                                oci_close($connection);
                                ?>

                            </table>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>