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

                <center><?php echo '<font><strong>Solicitudes Atendidas</strong></font>'; ?></center>

                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>

                <center>
                    <form>
                        <a href="?year=2015">Atendidas 2015</a>|
                        <a href="?year=2016">Atendidas 2016</a>
                        <br><br>
                        <center>
                            Exportar Solicitudes Atendidas <a class="exportacion"  href="ExpSolicitudesBanco.php?tipo=1"><img src="../images/excel.png" width="26" height="26"></img></a>                      </a>
                            <br/>
                            <br/>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th>N°</th>
                                        <th>Solicitud</th>
                                        <th>Radicado Solicitud</th>
                                        <th>Tipo Solicitud</th>
                                        <th>Código Kit</th>
                                        <th>Mesa Regional Centro</th>
                                        <th>Líder</th>
                                        <th>Grupo</th>
                                        <th>Entidad</th>
                                        <th>Fecha Solicitud Fecha Estado</th>
                                        <th>Observaciones</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <?php
                                $year=($_GET[year]=="2015")?"2015":"2016";
                                $num = 0;
                                $sqlSelSolicitudes = "SELECT DISTINCT TES.ID_SOLICITUD 
                                        FROM T_OPERACION_BANCO TOB 
                                        INNER JOIN T_SOLICITUDES_ASIGNADAS SA 
                                            ON TOB.ID_OPERACION = SA.ID_SOLICITUD 
                                        INNER JOIN T_ESTADO_SOLICITUD TES 
                                            ON TOB.ID_OPERACION = TES.ID_SOLICITUD
                                        WHERE SA.ESTADO = '1' and extract(year from  TOB.FECHA_REGISTRO)='$year'
                                        ORDER BY TES.ID_SOLICITUD ASC";

                                $objSelSolicitudes = oci_parse($connection, $sqlSelSolicitudes);
                                oci_execute($objSelSolicitudes);
                                $numrowsSelSolicitudes = oci_fetch_all($objSelSolicitudes, $rowsSelSolicitudes);

                                for ($i = 0; $i < $numrowsSelSolicitudes; $i++) {

                                    $sqlSelIdmax = 'SELECT ID_ESTADO_SOLICITUD
                                        FROM T_ESTADO_SOLICITUD
                                        WHERE ID_ESTADO_SOLICITUD IN (
                                            SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD
                                            FROM T_ESTADO_SOLICITUD TES
                                            WHERE ID_SOLICITUD = ' . $rowsSelSolicitudes[ID_SOLICITUD][$i] . ')
                                            AND ID_TIPO_ESTADO_SOLICITUD = 1';

                                    $objSelIdmax = oci_parse($connection, $sqlSelIdmax);
                                    oci_execute($objSelIdmax);
                                    oci_fetch_all($objSelIdmax, $rowsSelIdmax);

                                    $query = "SELECT P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,TOB.HORA_REGISTRO,SA.ID_SOLICITUD,P.NIT_EMPRESA,TOB.OBSERVACION,USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO,USUA.NOMBRE AS NOMBREA,USUA.PRIMER_APELLIDO AS PRIMER_APELLIDOA,USUA.SEGUNDO_APELLIDO AS SEGUNDO_APELLIDOA,TES.DETALLE,TES.CODIGO_INSTRUMENTO,TB.DESCRIPCION
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN T_SOLICITUDES_ASIGNADAS SA ON TOB.ID_OPERACION = SA.ID_SOLICITUD
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    INNER JOIN T_ESTADO_SOLICITUD TES ON TOB.ID_OPERACION = TES.ID_SOLICITUD
                                                    INNER JOIN USUARIO USU ON TOB.USU_REGISTRO = USU.USUARIO_ID
                                                    INNER JOIN USUARIO USUA ON SA.USUARIO_ASIGNADO = USUA.USUARIO_ID
                                                    INNER JOIN T_TIPO_OPERACION_BANCO TB ON TOB.ID_T_OPERACION = TB.ID_OPERACION
                                                    WHERE TES.ID_ESTADO_SOLICITUD = '" . $rowsSelIdmax[ID_ESTADO_SOLICITUD][0] . "' AND SA.ESTADO = 1
                                                        AND SA.ESTADO = '1'
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

                                        $query222 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $row['ID_SOLICITUD'] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                        $statement222 = oci_parse($connection, $query222);
                                        oci_execute($statement222);
                                        $rows222 = oci_fetch_array($statement222, OCI_BOTH);

                                        $query223 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD =  $row[ID_SOLICITUD] AND (ES.ID_TIPO_ESTADO_SOLICITUD = 2 OR  ES.ID_TIPO_ESTADO_SOLICITUD = 3) ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                        $statement223 = oci_parse($connection, $query223);
                                        oci_execute($statement223, OCI_DEFAULT);
                                        $rowsNum223 = oci_fetch_all($statement223, $rows223);


//                                    var_dump($rows222);
                                        $queryProyecto = "SELECT *
                                                FROM PROYECTO
                                                WHERE ID_PROYECTO = " . $row['ID_PROYECTO'];
                                        $statementProyecto = oci_parse($connection, $queryProyecto);
                                        oci_execute($statementProyecto);
                                        $proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
                                        echo "<tr><td><font face=\"verdana\">" .
                                        ($num + 1) . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        $row["ID_OPERACION"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        'R' . $row["ID_REGIONAL"] . '-' . 'C' . $row ["ID_CENTRO"] . '-P' . $row["ID_PROYECTO"] . '-' . $cnorma[0] . '-' . $row["N_GRUPO"] . '-' . $row["ID_OPERACION"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" . $row["DESCRIPCION"] . "</font></td>";
                                        echo "<td><font face=\"verdana\">" . $row["CODIGO_INSTRUMENTO"] . "</font></td>";
                                        echo "<td><font face=\"verdana\"><a href='datos_centro_mesa_solicitudes.php?rowsSelIdmax=".$row["ID_OPERACION"]."' target='_blank'>ver</a></font></td>";
                                        echo "<td><font face=\"verdana\">" .
                                        utf8_encode($row["NOMBRE"]) . ' ' . utf8_encode($row["PRIMER_APELLIDO"]) . ' ' . utf8_encode($row["SEGUNDO_APELLIDO"]) . "</font></td>";
                                        echo "<td><a href=\"consultar_grupo_b2.php?proyecto=" . $row["ID_PROYECTO"] . "&n=" . $cnorma . "&norma=" . $row[ID_NORMA] . "&grupo=" . $row["N_GRUPO"] . "\" target='_blank'>
                                                        Consultar</a></td>";
//                                        echo "<td><font face=\"verdana\">" . $proyecto['NIT_EMPRESA'] . "</font></td>";
                                        if ($proyecto["NIT_EMPRESA"] == null) {
                                            echo "<td><font face=\"verdana\">Demanda Social</font></td>";
                                        } else {
                                            $queryEmpresa = "SELECT *
                                                FROM EMPRESAS_SISTEMA
                                                WHERE NIT_EMPRESA = " . $proyecto['NIT_EMPRESA'];
                                            $statementEmpresa = oci_parse($connection, $queryEmpresa);
                                            oci_execute($statementEmpresa, OCI_DEFAULT);
                                            $empresa = oci_fetch_all($statementEmpresa, $rowsEmpresa);
                                            echo "<td><font face=\"verdana\">" . utf8_encode($rowsEmpresa['NOMBRE_EMPRESA'][0]) . "</font></td>";
                                        }
                                        echo "<td><font face=\"verdana\"><a href='datos_fecha_registro_solicitudes.php?rowsSelIdmax=".$rowsSelIdmax[ID_ESTADO_SOLICITUD][0]."'>ver</a></font></td>";
                                        echo "<td><font face=\"verdana\"><a href='datos_observaciones_solicitudes.php?rowsSelIdmax=".$rowsSelIdmax[ID_ESTADO_SOLICITUD][0]."'>ver</a></td></tr>";
                                        $anterior = $rowsNum223;
                                        $num++;
                                    }
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