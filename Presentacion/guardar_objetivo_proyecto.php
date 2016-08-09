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
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_objetivo_proyecto.js" type="text/javascript"></script>
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
    <body>
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
                    <center><?php echo '<font><strong>Objetivo del Proyecto</strong></font>'; ?></center>
                    </br>
                    <form id="frmFormulario" action="guardar_objetivo_proyecto_2.php" method="post">
                        <br>
                        <br></br>
                        <center>
                            <table>
                                <thead><tr>
                                        <th>Radicado PROYECTO</th>
                                        <th>Fecha y Hora Elaboración</th>
                                        <th>Empresa</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <tr>
                                    <?php
                                    $fecha = date('Y');
                                    $query = "SELECT ID_PROYECTO,FECHA_ELABORACION,NIT_EMPRESA,ID_PLAN
                                        FROM PROYECTO 
                                        where ID_CENTRO='$cen[0]'
                                        AND SUBSTR(FECHA_ELABORACION, 7,4) = 2016
                                        AND ID_PROYECTO = $_GET[proyecto]";
                                    $statement = oci_parse($connection, $query);
                                    oci_execute($statement);
                                    $numero = 0;
                                    while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                        $queryProyetoNac = ("SELECT COUNT(*) AS NUMNAC, ID_PROYECTO_NACIONAL  
                                        FROM T_PROY_NAC_PROYECTO WHERE ID_PROYECTO =  '$row[ID_PROYECTO]'
                                            GROUP BY ID_PROYECTO_NACIONAL");
                                        $statementProyetoNac = oci_parse($connection, $queryProyetoNac);
                                        oci_execute($statementProyetoNac);
                                        $proyectoNac = oci_fetch_array($statementProyetoNac, OCI_BOTH);

                                        $query4 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa =  '$row[NIT_EMPRESA]'");
                                        $statement4 = oci_parse($connection, $query4);
                                        $resp4 = oci_execute($statement4);
                                        $empresa = oci_fetch_array($statement4, OCI_BOTH);
                                        $query5 = ("SELECT COUNT(*) FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                        $statement5 = oci_parse($connection, $query5);
                                        $resp5 = oci_execute($statement5);
                                        $tcron = oci_fetch_array($statement5, OCI_BOTH);
                                        $query6 = ("SELECT COUNT(*) FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                        $statement6 = oci_parse($connection, $query6);
                                        $resp6 = oci_execute($statement6);
                                        $teva = oci_fetch_array($statement6, OCI_BOTH);
                                        $query7 = ("SELECT COUNT(*) FROM CANDIDATOS_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                        $statement7 = oci_parse($connection, $query7);
                                        $resp7 = oci_execute($statement7);
                                        $tcand = oci_fetch_array($statement7, OCI_BOTH);
                                        $query8 = ("SELECT COUNT(*) FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                        $statement8 = oci_parse($connection, $query8);
                                        $resp8 = oci_execute($statement8);
                                        $treq = oci_fetch_array($statement8, OCI_BOTH);
                                        $query9 = ("SELECT ID_ESTADO_PROYECTO FROM PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                        $statement9 = oci_parse($connection, $query9);
                                        $resp9 = oci_execute($statement9);
                                        $estadoProyecto = oci_fetch_array($statement9, OCI_BOTH);

                                        if ($proyectoNac['NUMNAC'] > 0) {
                                            $proyectoNacional = 'Proyecto Nacional ' . $proyectoNac['ID_PROYECTO_NACIONAL'];
                                            $classDivProNac = 'divProNac';
                                            $urlProNac = '&proNac=1';
                                        } else {
                                            $proyectoNacional = '';
                                            $classDivProNac = 'ninguna';
                                            $urlProNac = '&proNac=0';
                                        }

                                        if ($row["ID_ESTADO_PROYECTO"] == 1) {
                                            echo "<td width=\"15%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                                            $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . " - " . $proyectoNacional . "</font></td>";
                                        } else {
                                            echo "<td width=\"15%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                                            $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . '-P' . $row["ID_PROYECTO"] . " - " . $proyectoNacional . "</font></td>";
                                        }

                                        if ($empresa[0] == null) {

                                            $e = "Demanda Social";
                                        } else {

                                            $e = $empresa[0];
                                        }

                                        echo "<td width=\"20%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                                        $row["FECHA_ELABORACION"] . "</font></td>";
                                        echo "<td width=\"\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                                        $e . "</font></td>";
                                        ?>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Objetivo del Proyecto</th>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style=" height: 100px;" class="<?php echo $classDivProNac; ?>">
                                            <textarea id="txtObjetivo" name="txtObjetivo" maxlength="200" style=" width: 99.5%; height: 85%; "></textarea>
                                            Numero de caracteres: <label id="cantidadObjetivo" style="color: red;"></label>
                                            <input type="hidden" name="hidProyecto" value="<?php echo $_GET[proyecto]; ?>"
                                        </td>
                                    </tr>

                                    <?php
                                    $numero++;
                                }
                                oci_close($connection);
                                ?>
                            </table>


                        </center><br>
                        <input type="submit" name="btnGuardar" value="Guardar"/>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>