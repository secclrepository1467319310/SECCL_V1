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
                $query2 = ("SELECT codigo_regional FROM T_REGIONALES_USUARIOS where id_usuario = '$id'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>
                <center>
                    <form action="apoyos_regionales_aprobar.php" method="post">
                        <a id="cleanfilters" href="#">Limpiar Filtros </a> || <a href="../Presentacion/registrar_apoyo_regional.php">Registrar Nuevo Apoyo</a>
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
                                        <th>Apellido</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Cambiar Estado</th>
                                        <th>Aprobado</th>
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
                                    primer_apellido,
                                    email,
                                    ESTADO,
                                    DOCUMENTO
                                    FROM APOYOS join REGIONAL
                                    on apoyos.codigo_regional = regional.codigo_regional
                                    join CENTRO
                                    on apoyos.codigo_centro = centro.codigo_centro
                                    where apoyos.codigo_regional=$cen[0]
                                    order by regional.nombre_regional asc";
                                $statement2 = oci_parse($connection, $query2);
                                oci_execute($statement2);
                                $numRows = oci_fetch_all($statement2, $row2);
                                $numero = 0;
                                for ($i = 0;$i < $numRows;$i++) {

                                    echo "<tr><td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_REGIONAL"][$i] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_REGIONAL"][$i]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_CENTRO"][$i] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_CENTRO"][$i]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE"][$i]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["PRIMER_APELLIDO"][$i]) . "</center></font></td>";
                                    echo "<td><a href=\"mailto: ".$row2[EMAIL][$i]."\"><center>" .
                                    utf8_encode($row2["EMAIL"][$i]) . "</center></a></td>";
                                    if ($row2[ESTADO] == 1) {
                                        echo "<td width=\"\">Activo</td>";
                                        echo "<td width=\"\"><a href=\"./cambio_estado_apoyo.php?es=0&ida=" . $row2["DOCUMENTO"][$i] . "\" >
                                        Inactivar</a></td>";
                                    } else {
                                        echo "<td width=\"\">Inactivo</td>";
                                        echo "<td width=\"\"><a href=\"./cambio_estado_apoyo.php?es=1&ida=" . $row2["DOCUMENTO"][$i] . "\" >
                                        Activar</a></td>";
                                    }

                                    $query2 = "SELECT * FROM T_MISIONAL_APOYO_APROB WHERE DOCUMENTO_APOYO = '".$row2[DOCUMENTO][$i]."'";
                                    $statement2 = oci_parse($connection, $query2);
                                    oci_execute($statement2);
                                    $numRowsApoyo = oci_fetch_all($statement2, $rowsApoyo);
                                    if ($numRowsApoyo == 1) {
                                        ?>
                                        <td>Aprobado</td></tr>
                                        <?php
                                    } else {
                                        ?>
                                        <td><input type="checkbox" name="chkAprobado[]" value="<?php echo $row2[DOCUMENTO][$i]; ?>"</td></tr>
                                        <?php
                                    }
                                    $numero++;
                                }

                                oci_close($connection);
                                ?>

                            </table>
                            <br>
                            <br>
                            <input type="submit" value="Guardar"/>
                        </center>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>