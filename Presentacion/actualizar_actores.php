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
include ("calendario/calendario.php");
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
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_actualizar_evaluador.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $("#pestanas div").hide();
                $("#tabs li:first").attr("id", "current");
                $("#pestanas div:first").fadeIn();

                $('#tabs a').click(function(e) {
                    e.preventDefault();
                    $("#pestanas div").hide();
                    $("#tabs li").attr("id", "");
                    $(this).parent().attr("id", "current");
                    $('#' + $(this).attr('title')).fadeIn();
                });
            })();
        </script>
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

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  ' $idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>
                <ul id="tabs">
                    <li><a href="#" title="tab1">Evaluadores</a></li>
                </ul>
                <!--style="height:219px;width:920px;overflow:scroll;"-->
                <div id="pestanas"> 
                    <div id="tab1">
                        <br>
                        <form method="post" id="frmEvaluadores">
                            <?php
                            extract($_POST);

                            if ($txtDocumento != '') {
                                $selectEvaluador = "SELECT * FROM EVALUADOR WHERE DOCUMENTO = '$txtDocumento'";
                                $objParseEvaluador = oci_parse($connection, $selectEvaluador);
                                $objExecuteEvaluador = oci_execute($objParseEvaluador, OCI_DEFAULT);
                                $NumRowsEvaluador = oci_fetch_all($objParseEvaluador, $rowsEvaluador);
                            }
                            ?>
                            <center>
                                <table id='demotable1'>
                                    <tr>
                                        <th>Documento</th>
                                        <td>
                                            <input type="text" name="txtDocumento" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[DOCUMENTO][0] : ''; ?>"/>
                                            <input type="submit" name="btnDocumento" value="Validar" formaction="actualizar_actores.php"/>
                                            <?php echo (isset($NumRowsEvaluador) && $NumRowsEvaluador != 1) ? '<br>Documento no registrado' : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nombres y Apellidos</th>
                                        <td>
                                            <input type="text" name="nombres" size="50" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[NOMBRE][0] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ip</th>
                                        <td>
                                            <input type="text" name="ip" onKeyPress="return validar(event)" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[IP][0] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Celular</th>
                                        <td>
                                            <input type="text" name="celular" onKeyPress="return validar(event)" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[CELULAR][0] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email SENA</th>
                                        <td>
                                            <input type="text" name="email" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[EMAIL][0] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email Personal</th>
                                        <td>
                                            <input type="text" name="email2" value="<?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[EMAIL2][0] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Observación </th>
                                        <td>
                                            <textarea cols="50" name="obs" rows="5"><?php echo($NumRowsEvaluador == 1) ? $rowsEvaluador[OBS][0] : ''; ?></textarea>
                                        </td>
                                    </tr>

                                </table>
                                <br>
                                <input type="submit" name="insertar" id="insertar" value="Guardar" formaction="actualizar_evaluador.php"/>
                            </center>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>