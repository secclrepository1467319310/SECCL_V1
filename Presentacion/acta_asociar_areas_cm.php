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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery.magnificpopup.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/magnificpopup.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                modal();
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

//                $('.demotable').tableFilter(options1);

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
        <script type="text/javascript" language="JavaScript">
            function validar() {
                var form = document.f2;
                var total = 0;
                for (var i = 0; i < form.codigo.length; i++) {
                    //cuento la cantidad de input activos
                    if (form.codigo[i].checked) {
                        total = total + 1;
                    }
                }  //cierre for
                if (total == 12) {
                    for (i = 0; i < form.codigo.length; i++) {
                        //deshabilito el resto de checkbox
                        if (!form.codigo[i].checked) {
                            form.codigo[i].disabled = true;
                        }
                    }
                } else {
                    for (i = 0; i < form.codigo.length; i++) {
                        // habilito los checkbox cuando el total es menor que 3
                        form.codigo[i].disabled = false;
                    }
                }
                return false;
            } //cierre función

            function modal() {
                $('.areasClaves').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    modal: true
                });
                $(document).on('click', '.popup-modal-dismiss', function(e) {
                    e.preventDefault();
                    $.magnificPopup.close();
                });
            }

        </script>

    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div style="width:900px; margin: 0 auto;">
                <?php
                $centro = $_GET['centro'];
                $centro = explode(',', $centro);
                $numActa = $_GET['numActa'];

                $queryActa = ("SELECT NOMBRE, T_ID_ACTA FROM T_ACTA where T_ID_ACTA =  $numActa");
                $statementActa = oci_parse($connection, $queryActa);
                oci_execute($statementActa);
                $acta = oci_fetch_array($statementActa, OCI_BOTH);
                ?>
                <center>
                    <img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>REGISTRO DE ÁREAS CLAVES PARA EL PROCESO</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong><br><br>
                    <strong> Acta N° <?php echo $acta['T_ID_ACTA'] . " - " . $acta['NOMBRE'] ?> </strong>
                </center>

                <form name="f2" action="acta_guardar_areas.php" method="post">
                    <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />
                    <table>
                        <tr>
                            <th>Código de Área</th>
                            <th>Código de Centro</th>
                            <th>Nombre Centro</th>
                            <th>Areas Claves</th>
                        </tr>
                        <?php
                        $nCentro = count($centro);
                        for ($i = 0; $i < $nCentro; $i++) {
                            $query3 = ("SELECT ID_AREA_CLAVE FROM AREAS_CLAVES where CODIGO_CENTRO = $centro[$i]");
                            $statement3 = oci_parse($connection, $query3);
                            $resp3 = oci_execute($statement3);
                            $idareaclave = oci_fetch_array($statement3, OCI_BOTH);

                            $query4 = ("SELECT NOMBRE_CENTRO FROM CENTRO where CODIGO_CENTRO =  $centro[$i]");
                            $statement4 = oci_parse($connection, $query4);
                            $resp4 = oci_execute($statement4);
                            $nomCentro = oci_fetch_array($statement4, OCI_BOTH);
                            ?>
                            <tr>
                                <td><?php echo $idareaclave['ID_AREA_CLAVE'] ?></td>
                                <td><?php echo $centro[$i] ?></td>
                                <td><?php echo utf8_encode($nomCentro['NOMBRE_CENTRO']) ?></td>
                                <td>
                                    <a href="#ventanaEmergente<?php echo $i ?>" class="areasClaves">Añadir Areas Claves</a>
                                    <div id="ventanaEmergente<?php echo $i ?>" class="ventanaEmergenteBlanca mfp-hide">
                                        <a class="popup-modal-dismiss" href="#">Volver</a>
                                        <center>
                                            <strong>Por Favor Seleccione las Áreas Claves a Trabajar en el centro: <br> <?php echo utf8_encode($nomCentro['NOMBRE_CENTRO']) ?></strong>
                                        </center>
                                        </br></br>
                                        <center>
                                            <table class="demotable">
                                                <thead><tr>
                                                        <th><strong>Código Mesa</strong></th>
                                                        <th><strong>Nombre Mesa</strong></th>
                                                        <th><strong>Seleccionar</strong></th>
                                                    </tr></thead>
                                                <tbody>
                                                </tbody>

                                                <?php
                                                $query = "SELECT CODIGO_MESA,NOMBRE_MESA FROM MESA ORDER BY CODIGO_MESA ASC";
                                                $statement = oci_parse($connection, $query);
                                                oci_execute($statement);
                                                $numero = 0;
                                                $periodo = date('Y');
                                                $periodo = $periodo + 1;
                                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                                    $query2 = "SELECT count(*) FROM AREAS_CLAVES_CENTRO WHERE ID_MESA = $row[CODIGO_MESA] AND ID_AREA_CLAVE = $idareaclave[ID_AREA_CLAVE] AND PERIODO = $periodo";
                                                    $statement2 = oci_parse($connection, $query2);
                                                    oci_execute($statement2);
//                                                    oci_error($statement2);
                                                    
                                                    $row2 = oci_fetch_array($statement2, OCI_BOTH);
                                                    if ($row2['COUNT(*)'] < 1) {
                                                        echo "<tr><td width=\"\"><font face=\"verdana\">" .
                                                        $row["CODIGO_MESA"] . "</font></td>";
                                                        echo "<td width=\"\"><font face=\"verdana\">" .
                                                        utf8_encode($row["NOMBRE_MESA"]) . "</font></td>";
                                                        ?>
                                                        <td width=""><input id="codigo" name="codigo[]" type="checkbox" value="<?php echo $idareaclave['ID_AREA_CLAVE'] . "-" . $row["CODIGO_MESA"]; ?>"></input></td></tr>
                                                        <?php
                                                    }
                                                    $numero++;
                                                }
                                                ?>
                                            </table>
                                        </center>
                                        <a class="popup-modal-dismiss" href="#">Volver</a>
                                    </div>
                                </td>
                            </tr>


                            <?php
                        }
                        oci_close($connection);
                        ?>
                        <br></br>
                        <p><label>
                            </label></p>
                    </table>
                    <input type="submit" name="insertar" id="insertar" value="Siguiente" />
                </form>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>