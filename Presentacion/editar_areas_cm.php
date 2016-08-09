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
            <div id="contenedorcito" style="height:600px;width:1010px;overflow:scroll;">
                <?php
                $idarea = $_GET['idarea'];
                $iddeta = $_GET['iddeta'];
                $centro = $_GET['centro'];
                $query7 = ("SELECT OBS_MISIONAL FROM AREAS_CLAVES_CENTRO WHERE ID_AREAS_CENTRO='$iddeta'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $obs = oci_fetch_array($statement7, OCI_BOTH);
                ?>
                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>REGISTRO DE ÁREAS CLAVESPARA EL PROCESO</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong>
                    <strong>Datos Generales</strong><br></br>


                    <form name="f2" action="guardar_obs_misional.php?centro=<?php echo $centro ?>" method="post">
                        <table>
                            <tr>
                                <th>Código de Área</th>
                                <td><input name="idarea" type="text" size="1" readonly value="<?php echo $idarea ?>"></input></td>
                            </tr>
                            <tr>
                                <th>Id Detalle</th>
                                <td><input name="deta" type="text" size="1" readonly value="<?php echo $iddeta ?>"></input></td>
                            </tr>
                            <tr>
                                <th>Observaciones</th>
                                <td><textarea name="obs" cols="20" rows="3" value=""><?php echo $obs[0] ?></textarea></td></td>
                            </tr>
                        </table>
                        <br></br>
                        <p><label>
                                <input type="submit" name="insertar" id="insertar" value="Siguiente" />
                            </label></p>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>