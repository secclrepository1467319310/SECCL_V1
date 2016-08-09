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

                <center><?php echo '<font><strong>Mesa - Regional - Centro</strong></font>'; ?></center>

                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>

                <center>
                    <form><br><br>
                        <center>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th>Mesa</th>
                                        <th>Código Regional</th>
                                        <th>Regional</th>
                                        <th>Código Centro</th>
                                        <th>Centro</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <?php
                                $query = "SELECT TOB.ID_OPERACION, P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,TOB.HORA_REGISTRO,P.NIT_EMPRESA,TOB.OBSERVACION
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    WHERE TOB.ID_OPERACION = '" . $_GET[rowsSelIdmax] . "' 
                                                    ORDER BY TOB.ID_OPERACION ASC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $anterior = 1;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    $query3 = ("SELECT CODIGO_NORMA, NOMBRE_MESA FROM NORMA NOR "
                                            . "INNER JOIN MESA MES "
                                            . "ON NOR.CODIGO_MESA = MES.CODIGO_MESA "
                                            . "WHERE ID_NORMA='$row[ID_NORMA]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $cnorma = oci_fetch_array($statement3, OCI_BOTH);

                                    $queryProyecto = "SELECT *
                                                FROM PROYECTO
                                                WHERE ID_PROYECTO = " . $row['ID_PROYECTO'];
                                    $statementProyecto = oci_parse($connection, $queryProyecto);
                                    oci_execute($statementProyecto);
                                    $proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
                                    echo "<tr><td><font face=\"verdana\">" .
                                        $cnorma[1] . "</font></td>";
                                    echo "<td><font face=\"verdana\">" .
                                    $row["ID_REGIONAL"] . "</font></td>";
                                    echo "<td><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_REGIONAL"]) . "</font></td>";
                                    echo "<td><font face=\"verdana\">" .
                                    $row["ID_CENTRO"] . "</font></td>";
                                    echo "<td><font face=\"verdana\">" .
                                    utf8_encode($row["NOMBRE_CENTRO"]) . "</font></td></tr>";
                                }
                                ?>
                            </table>
                        </center><br></br>
                    </form>                    
                </center>
                <?php
                oci_close($connection);
                ?>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>