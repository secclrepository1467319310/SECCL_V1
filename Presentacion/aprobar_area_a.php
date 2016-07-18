<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
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
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <?php
            require_once("../Clase/conectar.php");

            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            extract($_GET);

            $queryArea = "SELECT * FROM AREAS_CLAVES_CENTRO ACC "
                    . "INNER JOIN AREAS_CLAVES AC "
                    . "ON ACC.ID_AREA_CLAVE = AC.ID_AREA_CLAVE "
                    . "INNER JOIN CENTRO CE "
                    . "ON AC.CODIGO_CENTRO = CE.CODIGO_CENTRO "
                    . "INNER JOIN REGIONAL REG "
                    . "ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                    . "INNER JOIN MESA MS "
                    . "ON ACC.ID_MESA = MS.CODIGO_MESA "
                    . "WHERE ID_AREAS_CENTRO= '$id_area_centro'";
            $statementArea = oci_parse($connection, $queryArea);
            oci_execute($statementArea);
            $area_centro = oci_fetch_array($statementArea, OCI_BOTH);
            ?>

            <center>

                <img src="../images/logos/sena.jpg" align="left" ></img>
                <strong>REGIONAL: <?php echo $area_centro['CODIGO_REGIONAL'] . " - " . utf8_encode($area_centro['NOMBRE_REGIONAL']) ?></strong><br></br>
                <strong><?php echo $area_centro['CODIGO_CENTRO'] . " - " . utf8_encode($area_centro['NOMBRE_CENTRO']) ?> </strong><br><br>
                <strong>AREA CLAVE: <?php echo utf8_encode($area_centro['NOMBRE_MESA']) ?></strong><br></br>
                <br><br>
                <a href="consultar_areas_a.php?centro=<?php echo $area_centro['CODIGO_CENTRO'] ?>&periodo=<?php echo $area_centro['PERIODO'] ?>"><strong>Volver</strong></a>
                <?php if ($mensaje == 1) { ?>
                    <div class="mensaje">La actualización se realizo correctamente</div>
                <?php } ?>
                <fieldset>
                    <legend><h4>Aprobación de area</h4></legend>
                    <form action="guardar_estado_area_a.php" method="post">
                        <input name="idarea" type="hidden" readonly value="<?php echo $area_centro['ID_AREA_CLAVE'] ?>" />
                        <input name="deta" type="hidden" readonly value="<?php echo $id_area_centro ?>" />
                        <table>
                            <tr>
                                <th>Cambiar Estado</th>
                                <td>
                                    <select name="estado">
                                        <option value="0" <?php echo ($area_centro['APROBADO_ASESOR'] == 0) ? "selected='selected'" : ""; ?> >No Aprobado</option>
                                        <option value="1" <?php echo ($area_centro['APROBADO_ASESOR'] == 1) ? "selected='selected'" : ""; ?> >Si Aprobado</option>
                                        <option value="2" <?php echo ($area_centro['APROBADO_ASESOR'] == 2) ? "selected='selected'" : ""; ?> >Transitoriamente Aprobado</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Observaciones</th>
                                <td><textarea name="obs" cols="94" rows="5" style="resize: none;"><?php echo $area_centro['OBS_ASESOR'] ?></textarea></td></td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" value="Guardar" />
                    </form>
                </fieldset>
                <br><br>
                <fieldset>
                    <legend><h4>Historial</h4></legend>
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Observación Asesor</th>
                            <th>Fecha Observación</th>
                        </tr>
                        <?php
                        $query2 = "SELECT ID_HISTORICO,OBS_MISIONAL,FECHA_OBS_MISIONAL,OBS_ASESOR,FECHA_OBS_ASESOR "
                                . "FROM HISTORICO_AREAS_CLAVES "
                                . "WHERE ID_DETA='$id_area_centro' "
                                . "ORDER BY ID_HISTORICO DESC";
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
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
                                <?php echo $row2["ID_HISTORICO"] ?>
                            </center>
                            </td>
                            <td>
                            <center>
                                <?php echo $row2["OBS_ASESOR"] ?> 
                            </center>
                            </td>
                            <td>
                            <center>
                                <?php echo $row2["FECHA_OBS_ASESOR"] ?>
                            </center>
                            </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </fieldset>

            </center>
        </div>
        <div class="space">&nbsp;</div>
	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>