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
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
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

            <?php
            $centro = $_GET['centro'];
            $periodo = $_GET['periodo'];

            $query7 = ("SELECT ID_AREA_CLAVE FROM AREAS_CLAVES WHERE CODIGO_CENTRO='$centro'");
            $statement7 = oci_parse($connection, $query7);
            $resp7 = oci_execute($statement7);
            $idarea = oci_fetch_array($statement7, OCI_BOTH);

            $queryCentro = "SELECT * FROM CENTRO CEN "
                    . "INNER JOIN REGIONAL REG "
                    . "ON CEN.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                    . "WHERE CODIGO_CENTRO='$centro'";
            $statementCentro = oci_parse($connection, $queryCentro);
            oci_execute($statementCentro);
            $centro = oci_fetch_array($statementCentro, OCI_BOTH);
            ?>
            <div> 
                <center>
                    <strong>ÁREAS CLAVES <?php echo $periodo ?> <br> 
                        <?php echo utf8_encode($centro['CODIGO_CENTRO'] . " - " . $centro['NOMBRE_CENTRO']) ?><br>
                        <?php echo utf8_encode($centro['CODIGO_REGIONAL'] . " - " . $centro['NOMBRE_REGIONAL']) ?>
                    </strong>
                </center>
                <center>

                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <a href="cons_areas_a.php"><strong>Volver</strong></a>
                        <table id="demotable1" style="width:1000px">
                            <thead><tr>
                                    <th style="width:2%"><strong>Id</strong></th>
                                    <th style="width:2%"><strong>Código Mesa</strong></th>
                                    <th style="width:10%"><strong>Nombre Mesa</strong></th>
                                    <th style="width:10%"><strong>Estado</strong></th>
                                    <th style="width:50%"><strong>Observaciones Asesor</strong></th>
                                    <th style="width:10%"><strong>Ver acta</strong></th>
                                    <th style="width:8%"><strong>Editar Aprobación</strong></th>
                                    <!--<th style="width:8%"><strong>Normas</strong></th>-->
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $query2 = "select
                                    id_areas_centro,
                                    id_mesa,
                                    nombre_mesa,
                                    aprobado_asesor,
                                    obs_misional,
                                    obs_asesor
                                    from areas_claves_centro ac
                                    inner join mesa m
                                    on ac.id_mesa=m.codigo_mesa
                                    where ac.id_area_clave='$idarea[0]' and periodo = $periodo";

                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);

                            $num = 0;
                            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                                $selectActas = "SELECT ID_ACTA FROM T_AREAS_CLAVES_ACTAS WHERE ID_AREA_CENTRO = '$row2[ID_AREAS_CENTRO]'";
                                $objParseActas = oci_parse($connection, $selectActas);
                                oci_execute($objParseActas);
                                $numRows = oci_fetch_all($objParseActas, $rowsActas);

                                if ($row2["APROBADO_ASESOR"] == 0) {
                                    $estado = "No Aprobado";
                                } else if ($row2["APROBADO_ASESOR"] == 1) {
                                    $estado = "Aprobado";
                                } else if ($row2["APROBADO_ASESOR"] == 2) {
                                    $estado = "Transitoriamente Aprobado";
                                } else {
                                    $estado = "Por Aprobar";
                                }
                                ?>

                                <tr>
                                    <td>
                                <center> 
                                    <?php echo $row2["ID_AREAS_CENTRO"] ?> 
                                </center>
                                </td>
                                <td>
                                <center> 
                                    <?php echo $row2["ID_MESA"] ?>
                                </center>
                                </td>
                                <td>
                                <center>
                                    <?php echo utf8_encode($row2["NOMBRE_MESA"]) ?> 
                                </center>
                                </td>
                                <td>
                                <center>
                                    <?php echo $estado ?>
                                </center>
                                </td>
                                <td>
                                    <textarea readonly  style="resize:none; width:99%; height: 70px"><?php echo utf8_encode($row2[OBS_ASESOR]) ?></textarea>
                                </td>
                                <td>
                                <center>

                                    <?php if ($numRows > 0) { ?>
                                        <form action="ver_actas_asesor.php" method="post" target="_new">
                                            <input type="hidden" name="id_acta" value="<?php echo $rowsActas[ID_ACTA][0]; ?>"/>
                                            <input type="submit" value="Ver"/>
                                        </form>
                                    <?php } else { ?>
                                        No disponible
                                    <?php }; ?>
                                </center>
                                </td>
                                <td>
                                <center>
                                    <a href="aprobar_area_a.php?id_area_centro=<?php echo $row2[ID_AREAS_CENTRO] ?>"><img src="../images/editar.png" alt="20" width="20"></a>
                                </center>
                                </td>
    <!--                                    <td>
                                <center>
                                    <a href="asociar_normas_centro_a.php?id_area_centro=<?php echo $row2[ID_AREAS_CENTRO] ?>">Consultar</a>
                                </center>
                                </td>-->
                                </tr>
                            <?php } ?>
                        </table>
                    </center>

                </center> 
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>