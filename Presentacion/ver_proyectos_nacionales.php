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
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);

                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>


                <center>
                    <br>
                    <center><?php echo '<font><strong>Proyectos Nacionales Generados</strong></font>'; ?></center>
                    </br>
                    <form>
                        <a href="?year=2015">Proyectos nacionales del  2015</a>|
                        <a href="?year=2016">Proyectos nacionales del  2016</a>
                        <br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <center>
                            <table id="demotable1">
                                <thead>
                                    <tr>
                                        <th>Código del Proyecto</th>
                                        <th>Fecha y Hora Elaboración</th>
                                        <!--<th>Asesor Encargado</th>-->
                                        <th>Empresa</th>
                                        <th>Normas Asociadas</th>
                                        <th>Centros Asociados</th>
                                        <th>Agregar Centros</th>
                                        <th>Agregar Normas</th>
                                        <th>Actualizar Datos</th>
                                        <th>Reporte</th>
                                    </tr>
                                </thead>
                                <?php
                                $year=($_GET[year]=="2015")?"2015":"2016";
                                $selectProyecto = "SELECT ID_PROYECTO_NACIONAL, NOMBRE_PROYECTO
                                    FROM T_PROYECTOS_NACIONALES 
                                    WHERE ESTADO = 1 and  extract(year from  FECHA_REGISTRO)='$year'
                                    ORDER BY ID_PROYECTO_NACIONAL DESC";

                                $objParseSelectProyecto = oci_parse($connection, $selectProyecto);
                                $objExecuteSelectProyecto = oci_execute($objParseSelectProyecto, OCI_DEFAULT);
                                $arraySelectProyecto = oci_fetch_all($objParseSelectProyecto, $rowSelectProyecto);

                                for ($i = 0; $i < $arraySelectProyecto; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $rowSelectProyecto['ID_PROYECTO_NACIONAL'][$i]; ?></td>
                                        <?php
                                        $select = "SELECT P.FECHA_ELABORACION,P.NIT_EMPRESA,P.ID_CENTRO,P.ID_PROYECTO,PN.USU_REGISTRO
                                        FROM T_PROYECTOS_NACIONALES PN 
                                        LEFT JOIN T_PROY_NAC_PROYECTO PNP 
                                        ON PN.ID_PROYECTO_NACIONAL = PNP.ID_PROYECTO_NACIONAL 
                                        LEFT JOIN PROYECTO P 
                                        ON PNP.ID_PROYECTO = P.ID_PROYECTO
                                        WHERE PN.ID_PROYECTO_NACIONAL = " . $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i] . "
                                        ORDER BY PN.ID_PROYECTO_NACIONAL";

                                        $objParseSelect = oci_parse($connection, $select);
                                        $objExecuteSelect = oci_execute($objParseSelect, OCI_DEFAULT);
                                        $arraySelect = oci_fetch_all($objParseSelect, $rowSelect);
                                        
                                        
                                        if ($rowSelectProyecto['NOMBRE_PROYECTO'][$i] == NULL || $rowSelectProyecto['NOMBRE_PROYECTO'][$i] == '')
                                        {
                                            $nombre_proyecto = "";
                                        }
                                        else
                                        {
                                            if ($rowSelect['NIT_EMPRESA'][0] == NULL)
                                            {
                                                $nombre_proyecto = "DEMANDA SOCIAL - " . $rowSelectProyecto['NOMBRE_PROYECTO'][$i];
                                            }
                                            else
                                            {
                                                $nombre_proyecto = " - " . $rowSelectProyecto['NOMBRE_PROYECTO'][$i];
                                            }
                                        }

//                                        echo '<pre>';
//                                        var_dump($rowSelect);
//                                        echo '</pre>';
                                        ?>
                                        <td><?php echo $rowSelect['FECHA_ELABORACION'][0]; ?></td>
<!--                                        <td>
                                            <?php
//                                            $selectUsuario = 'SELECT NOMBRE,PRIMER_APELLIDO,SEGUNDO_APELLIDO
//                                                    FROM USUARIO
//                                                    WHERE USUARIO_ID = ' . $rowSelect['USU_REGISTRO'][0];
//                                            $objParseSelectUsuario = oci_parse($connection, $selectUsuario);
//                                            $objExecuteSelectUsuario = oci_execute($objParseSelectUsuario, OCI_DEFAULT);
//                                            $arraySelectUsuario = oci_fetch_all($objParseSelectUsuario, $rowSelectUsuario);
//                                            echo $rowSelectUsuario['NOMBRE'][0] . ' ' . $rowSelectUsuario['PRIMER_APELLIDO'][0] . ' ' . $rowSelectUsuario['SEGUNDO_APELLIDO'][0];
                                            ?>
                                        </td>-->
                                        <td>
                                            <?php
                                             if ($rowSelect['NIT_EMPRESA'][0] != '')
                                            {
                                                $selectNombreEmpresa = 'SELECT ES.NOMBRE_EMPRESA
                                                    FROM PROYECTO P 
                                                    INNER JOIN EMPRESAS_SISTEMA ES
                                                    ON P.NIT_EMPRESA = ES.NIT_EMPRESA
                                                    WHERE ES.NIT_EMPRESA = ' . $rowSelect['NIT_EMPRESA'][0];

                                                $objParseSelectNombreEmpresa = oci_parse($connection, $selectNombreEmpresa);
                                                $objExecuteSelectNombreEmpresa = oci_execute($objParseSelectNombreEmpresa, OCI_DEFAULT);
                                                $arraySelectNombreEmpresa = oci_fetch_all($objParseSelectNombreEmpresa, $rowSelectNombreEmpresa);
                                            }

                                            echo utf8_encode($rowSelectNombreEmpresa['NOMBRE_EMPRESA'][0]) . $nombre_proyecto;
                                            ?>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="mostrar_normas_proyecto_nacional.php?proNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Mostrar Normas</a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="mostrar_centros_proyecto_nacional.php?proNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Mostrar Centros</a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="agregar_centros_proyecto_nacional.php?proNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Agregar Centros</a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="agregar_normas_proyecto_nacional.php?proNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Agregar Normas</a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="actualizar_datos_proyecto_nacional.php?proNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Actualizar Datos</a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="reportes_proyectos_nacionales.php?pNac=<?php echo $rowSelectProyecto[ID_PROYECTO_NACIONAL][$i]; ?>">Generar reporte</a>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php
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