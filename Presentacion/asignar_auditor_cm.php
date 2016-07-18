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
                <center>
                    <form name="formmapa" action="guardar_depto_c.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >
                        <table width="200" border="1" color="#99CCCC" align="center">
                            <th colspan="2">Registrar Nuevo Usuario</th>
                            <tr>
                                <td>ID</td>
                                <?php
                                if ($_GET["id"] == null) {
                                    ?>
                                    <td><input name="id" type="text" readonly value="NO DISPONIBLE "></input>
                                        <?php
                                    } else {
                                        ?>
                                    <td><input name="id" type="text" readonly value="<?php echo $_GET["id"] ?>"></input>
                                        <?php
                                    }
                                    ?>

                            </tr>
                            <tr>
                                <td>Número de Documento</td>
                                <td><input name="documento" id="documento" maxlength="15" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["documento"] ?>">
                                    </input>
                                    <input type="button" value="Validar doc" onkeypress="validar();" class="botones" onClick="window.location = 'validar_doc_aud.php?&doc=' + document.getElementById('documento').value"></input><br>
                                    <?php
                                    if ($_GET["id"] == null) {

                                        ECHO "POR FAVOR REGISTRAR";
                                    }
                                    ?>  
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nombre(s)</label></td>
                                <td><input name="nombre" type="text" readonly value="<?php echo $_GET["nombre"] ?>"></input>
                            </tr>
                            <tr>
                                <td><label>Primer Apellido</label></td>
                                <td><input name="apellido" type="text" readonly value="<?php echo $_GET["apellido"] ?>"></input>
                            </tr>
                            <tr>
                                <td><label>Segundo Apellido</label></td>
                                <td><input name="apellido2" type="text" readonly value="<?php echo $_GET["apellido2"] ?>"></input>
                            </tr>
                        </table>
                        <br></br>

                        <?php
                        if ($_GET["nombre"] == 'No Registrado' || $_GET["nombre"] == null || $_GET["id"] == null) {

                            echo "No Disponible";
                        } else {
                            ?>
                            <a href="../Presentacion/proyecto_auditor_cm.php?id=<?php echo $_GET["id"] ?>">Asociar Proyecto</a></center></center>
                    <?php
                }
                ?>
                </form>
                </center>
                <br></br>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>