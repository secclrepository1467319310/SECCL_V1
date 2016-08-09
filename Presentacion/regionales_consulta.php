<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

require_once('../Clase/conectar.php');
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
        <link type="text/css" href="../css/encuestaLive.css" rel="stylesheet">
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


    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                ?>
                <br><br>
                <center>
                    <strong>Seleccione la regional a consultar: </strong><br></br>
                </center>

                <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />
                <center>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <table id="demotable1">
                        <thead>
                            <tr>
                                <th>Código Regional</th>
                                <th>Regional</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php
                        //Consulta de una regional en especifico
                        $query = "SELECT NOMBRE_REGIONAL, CODIGO_REGIONAL 
                    FROM REGIONAL ORDER BY NOMBRE_REGIONAL";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        while ($regional = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr>
                                <td><?php echo $regional['CODIGO_REGIONAL'] ?></td>
                                <td><?php echo utf8_encode($regional['NOMBRE_REGIONAL']) ?></td>
                                <td>
                                    <form action="centros_consulta.php" method="POST">
                                        <input type="hidden" name="regional" value="<?php echo $regional['CODIGO_REGIONAL'] ?>" />
                                        <input type="submit" value="Consultar">
                                    </form>
                                </td>
                            </tr>


                            <?php
                        }
                        oci_close($connection);
                        ?>
                    </table>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>