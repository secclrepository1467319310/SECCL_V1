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
extract($_GET);
extract($_POST);

$query = "SELECT * FROM T_ACTA WHERE T_ID_ACTA = $id_acta";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$row = oci_fetch_array($statement, OCI_BOTH);
$fechaActa1 = $row['FECHA'];
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluaci�n y Certificaci�n de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="actas.js" type="text/javascript"></script>
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
            <?php
            $query = "SELECT * FROM T_ACTA WHERE T_ID_ACTA = $id_acta";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $acta = oci_fetch_array($statement, OCI_BOTH);
            ?>
            <div id="contenedorcito">
                <center>
                    <?php if ($mensaje == 1) { ?>
                        <div class="mensaje">La actualizaci�n se realizo correctamente</div>
                    <?php } ?>
                    <form action="guardar_acta.php" method="post" id="formActa" name="formActa">
                        <input type="hidden" name="opcion" value="2">
                        <input type="hidden" name="id_acta" value="<?php echo $id_acta ?>">
                        <table>
                            <tr>
                                <th colspan="4">
                                    ACTA No. <?php echo $id_acta ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    NOMBRE DEL COMIT� O DE LA REUNI�N
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input style="width: 99%;" type="text" size="112" name="nombre_comite" id="nombre_comite" value="<?php echo $acta['NOMBRE'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    FECHA
                                </th>
                                <th>
                                    CIUDAD:
                                </th>
                                <th>
                                    HORA DE INICIO:
                                </th>
                                <th>
                                    HORA FIN:
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $fechaActa1 ?>
                                </td>
                                <td>
                                    <?php echo $acta['CIUDAD']; ?>
                                    <input style="width: 99%; " type="text" name="ciudad" id="ciudad" size="28" value="<?php echo $acta['CIUDAD']; ?>" />
                                </td>
                                <td>
                                    <?php
                                    $horaInicio1 = explode(':', $acta['HORA_INICIO']);
                                    $horaInicio2 = explode(' ', $horaInicio1[1]);
                                    ?>
                                    <select name="horaInicioHora">
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <?php
                                            if ($i <= 9) {
                                                $cero = "0";
                                            } else {
                                                $cero = "";
                                            }

                                            if ($horaInicio1[0] == $cero . $i) {
                                                $seleccion = "selected";
                                            } else {
                                                $seleccion = "";
                                            }
                                            ?>
                                            <option <?php echo $seleccion; ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                        <?php } ?>
                                    </select> :
                                    <select name="horaInicioMinutos">
                                        <?php for ($i = 1; $i <= 60; $i++) { ?>
                                            <?php
                                            if ($i <= 9) {
                                                $cero = "0";
                                            } else {
                                                $cero = "";
                                            }

                                            if ($horaInicio2[0] == $cero . $i) {
                                                $seleccion = "selected";
                                            } else {
                                                $seleccion = "";
                                            }
                                            ?>
                                            <option <?php echo $seleccion; ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="horaInicioJornada">
                                        <?php if ($horaInicio2[1] == 'AM' || !$horaInicio2[1]) { ?>
                                            <option selected value="AM" >AM</option>
                                            <option value="PM" >PM</option>
                                        <?php } else { ?>
                                            <option value="AM" >AM</option>
                                            <option selected value="PM" >PM</option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <?php
                                    $horaFin1 = explode(':', $acta['HORA_FIN']);
                                    $horaFin2 = explode(' ', $horaFin1[1]);
                                    ?>
                                    <select name="horaFinHora">
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <?php
                                            if ($i <= 9) {
                                                $cero = "0";
                                            } else {
                                                $cero = "";
                                            }

                                            if ($horaFin1[0] == $cero . $i) {
                                                $seleccion = "selected";
                                            } else {
                                                $seleccion = "";
                                            }
                                            ?>
                                            <option <?php echo $seleccion; ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="horaFinMinutos">
                                        <?php for ($i = 1; $i <= 60; $i++) { ?>
                                            <?php
                                            if ($i <= 9) {
                                                $cero = "0";
                                            } else {
                                                $cero = "";
                                            }

                                            if ($horaFin2[0] == $cero . $i) {
                                                $seleccion = "selected";
                                            } else {
                                                $seleccion = "";
                                            }
                                            ?>
                                            <option <?php echo $seleccion; ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="horaFinJornada">
                                        <?php if ($horaFin2[1] == 'AM' || !$horaFin2[1]) { ?>
                                            <option selected value="AM" >AM</option>
                                            <option value="PM" >PM</option>
                                        <?php } else { ?>
                                            <option value="AM" >AM</option>
                                            <option selected value="PM" >PM</option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>

                                </th>
                                <th colspan="3">
                                    DIRECCI�N GENERAL / REGIONAL / CENTRO
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    LUGAR:
                                </td>
                                <td colspan="3">
                                    <input style="width: 99%;" type="text" name="lugar" id="lugar" size="85" value="<?php echo $acta['LUGAR'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    TEMAS:
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea style="width: 99%; " name="temas" id="temas" cols="85"><?php echo $acta['TEMA'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    OBJETIVOS DE LA REUNI�N:
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea style="width: 99%; " name="objetivos" id="objetivos"><?php echo $acta['OBJETIVO'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    DESARROLLO DE LA REUNI�N:
                                </th>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <textarea name="desarrollo" style="width: 99%; " id="desarrollo"><?php echo $acta['DESARROLLO'] ?></textarea><br><br>
                                    <table style="width: 100%; font-size: 10px;">
                                        <tr>
                                            <th>
                                                CENTRO
                                            </th>
                                            <th>
                                                MESA
                                            </th>
                                        </tr>
                                        <?php
                                        $queryAreas = "SELECT * FROM T_AREAS_CLAVES_ACTAS INNER JOIN AREAS_CLAVES_CENTRO ON T_AREAS_CLAVES_ACTAS.ID_AREA_CENTRO = AREAS_CLAVES_CENTRO.ID_AREAS_CENTRO "
                                                . "INNER JOIN AREAS_CLAVES ON AREAS_CLAVES_CENTRO.ID_AREA_CLAVE = AREAS_CLAVES.ID_AREA_CLAVE "
                                                . "INNER JOIN MESA ON AREAS_CLAVES_CENTRO.ID_MESA = MESA.CODIGO_MESA "
                                                . "INNER JOIN CENTRO ON AREAS_CLAVES.CODIGO_CENTRO = CENTRO.CODIGO_CENTRO "
                                                . "WHERE T_AREAS_CLAVES_ACTAS.ID_ACTA = $id_acta AND AREAS_CLAVES_CENTRO.PERIODO = 2016  ORDER BY NOMBRE_CENTRO ASC";
                                        $statementAreas = oci_parse($connection, $queryAreas);
                                        oci_execute($statementAreas);
                                        $i = 1;
                                        while ($areas = oci_fetch_array($statementAreas, OCI_BOTH)) {
                                            if ($i == 1) {
                                                echo "<strong> AREAS CLAVE ASOCIADAS </strong><br><br>";
                                            }
                                            ?>
                                            <?php
                                            echo "<tr> <td>" . utf8_encode($areas['NOMBRE_CENTRO'] . " </td><td> " . $areas['NOMBRE_MESA']) . "</td></tr>";
                                            ?>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4">
                                    CONCLUSIONES
                                </th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea style="width: 99%; " name="concluciones" id="concluciones" cols="85"><?php echo $acta['CONCLUSIONES'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    COMPROMISOS
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    ACTIVIDAD
                                </th>
                                <th>
                                    RESPONSABLE
                                </th>
                                <th>
                                    FECHA
                                </th>
                                <th>

                                </th>
                            </tr>
                            <?php
                            $queryCompromisos = ("SELECT * FROM T_COMPROMISOS_ACTA WHERE ID_ACTA = $id_acta");
                            $statementCompromisos = oci_parse($connection, $queryCompromisos);
                            oci_execute($statementCompromisos);
                            $compromisos = oci_fetch_array($statementCompromisos, OCI_BOTH);
                            if (!$compromisos) {
                                ?>
                                <tr class="contenedorCompromisos">
                                    <td>
                                        <input type="text" name="actividad[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="responsable[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <!--<input type="text" name="fecha[]" value="<?php // echo $compromisos['FECHA_COMPROMISO']           ?>">-->
                                        Dia:
                                        <select name="fechaDia[]">
                                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                <?php
                                                if ($i <= 9) {
                                                    $cero = "0";
                                                } else {
                                                    $cero = "";
                                                }
                                                ?>
                                                <option value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                            <?php } ?>
                                        </select>
                                        Mes:
                                        <select name="fechaMes[]">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        Año:
                                        <select name="fechaPeriodo[]">
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                                <?php
                            };
                            oci_execute($statementCompromisos);
                            while ($compromisos = oci_fetch_array($statementCompromisos, OCI_BOTH)) {
                                ?>
                                <tr class="contenedorCompromisos">
                                    <td>
                                        <input type="text" name="actividad[]" value="<?php echo $compromisos['ACTIVIDAD'] ?>" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="responsable[]" value="<?php echo $compromisos['RESPONSABLE'] ?>" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <?php
                                        $fechaActa = explode('/', $compromisos['FECHA_COMPROMISO']);
                                        echo $fechaActa[1];
                                        ?>
                                        Dia:
                                        <select name="fechaDia[]">
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                if ($i <= 9) {
                                                    $cero = "0";
                                                } else {
                                                    $cero = "";
                                                }
                                                if ($fechaActa[0] == $i) {
                                                    $seleccion = 'selected';
                                                } else {
                                                    $seleccion = '';
                                                }
                                                ?>
                                                <option <?php echo $seleccion ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                            <?php } ?>
                                        </select>
                                        Mes:
                                        <select name="fechaMes[]">
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                if ($i <= 9) {
                                                    $cero = "0";
                                                } else {
                                                    $cero = "";
                                                }
                                                if ($fechaActa[1] == $i) {
                                                    $seleccion = 'selected';
                                                } else {
                                                    $seleccion = '';
                                                }
                                                ?>
                                                <option <?php echo $seleccion ?> value="<?php echo $cero . $i ?>"><?php echo $cero . $i ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        Año:
                                        <select name="fechaPeriodo[]">
                                            <?php
                                            $periodoActual = date('Y');
                                            for ($i = 2015; $i <= $periodoActual + 1; $i++) {
                                                if ('20' . $fechaActa[2] == $i) {
                                                    $seleccion = 'selected';
                                                } else {
                                                    $seleccion = '';
                                                }
                                                ?>
                                                <option <?php echo $seleccion ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="alinear_derecha">
                                    <input type="button" value="Agregar" id="agregar_compromiso">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4">
                                    ASISTENTES
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    NOMBRE
                                </th>
                                <th>
                                    CARGO/DEPENDENCIA/ENTIDAD
                                </th>
                                <th>
                                    FIRMA
                                </th>
                                <th>

                                </th>
                            </tr>
                            <?php
                            $queryAsistentes = ("SELECT * FROM T_ASISTENTE_ACTA WHERE ID_ACTA = $id_acta");
                            $statementAsistentes = oci_parse($connection, $queryAsistentes);
                            oci_execute($statementAsistentes);
                            $asistentes = oci_fetch_array($statementAsistentes, OCI_BOTH);
                            if (!$asistentes) {
                                ?>
                                <tr class="contenedorAsistentes">
                                    <td>
                                        <input type="text" name="nombre_asistente[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="cargo_asistente[]" style="width: 99%; ">
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                                <?php
                            };
                            oci_execute($statementAsistentes);
                            while ($asistentes = oci_fetch_array($statementAsistentes, OCI_BOTH)) {
                                ?>
                                <tr class="contenedorAsistentes">
                                    <td>
                                        <input type="text" name="nombre_asistente[]" value="<?php echo $asistentes['NOMBRE'] ?>" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="cargo_asistente[]" value="<?php echo $asistentes['CARGO'] ?>" style="width: 99%; ">
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="alinear_derecha">
                                    <input type="button" value="Agregar" id="agregar_asistente">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    INVITADOS (Opcional)
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    NOMBRE
                                </th>
                                <th>
                                    CARGO
                                </th>
                                <th>
                                    ENTIDAD
                                </th>
                                <th>

                                </th>
                            </tr>
                            <?php
                            $queryInvitados = ("SELECT * FROM T_INVITADOS_ACTA WHERE ID_ACTA = $id_acta");
                            $statementInvitados = oci_parse($connection, $queryInvitados);
                            oci_execute($statementInvitados);
                            $invitados = oci_fetch_array($statementInvitados, OCI_BOTH);
                            if (!$invitados) {
                                ?>
                                <tr class="contenedorInvitados">
                                    <td>
                                        <input type="text" name="nombre_invitado[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="cargo_invitado[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="text" name="entidad_invitado[]" style="width: 99%; ">
                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                                <?php
                            };
                            oci_execute($statementInvitados);
                            while ($invitados = oci_fetch_array($statementInvitados, OCI_BOTH)) {
                                ?>
                                <tr class="contenedorInvitados">
                                    <td>
                                        <input type="text" name="nombre_invitado[]" value="<?php echo $invitados['NOMBRE'] ?>" style="width: 99%; "/>
                                    </td>
                                    <td>
                                        <input type="text" name="cargo_invitado[]" value="<?php echo $invitados['CARGO'] ?>" style="width: 99%; "/>
                                    </td>   
                                    <td>
                                        <input type="text" name="entidad_invitado[]" value="<?php echo $invitados['ENTIDAD'] ?>" style="width: 99%; "/>
                                    </td>
                                    <td>
                                        <input type="button" class="eliminar" value="Eliminar">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="alinear_derecha">
                                    <input type="button" value="Agregar" id="agregar_invitado">
                                </td>
                            </tr>
                        </table>
                        <?php
                        $query = "SELECT * FROM T_AREAS_CLAVES_ACTAS WHERE ID_ACTA = $id_acta";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numActa = oci_fetch_all($statement, $rowActa);
                        if ($numActa <= 0) {
                            $value = "Guardar y Agregar Areas Clave";
                        } else {
                            $value = "Guardar";
                        }
                        ?>
                        <input type="submit" value="<?php echo $value ?>">
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>

