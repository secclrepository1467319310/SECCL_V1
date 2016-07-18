<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
extract($_GET);
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE HTML>
<html>
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
                    <form action="guardar_acta.php" method="post">
                        <input type="hidden" name="opcion" value="1" /> 
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Generar Acta</th>
                                <tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ACTA</td>
                                    <td><input type="submit" value="Generar Acta"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    </br>
                    <center>
                        <?php if ($mensaje == 1) { ?>
                            <div class="mensaje">El acta se agrego correctamente</div>
                        <?php } ?>
                        <table id='demotable1'>

                            <thead><tr>
                                    <th>Código Acta</th>
                                    <th>Nombre del comite o reunión</th>
                                    <th>Ciudad</th>
                                    <th>Lugar</th>
                                    <th>Codigo Regional</th>
                                    <th></th>
                                </tr></thead>
                            <tbody>
                                <?php
                                $SQL_regional = ("SELECT * FROM T_REGIONALES_USUARIOS WHERE ID_USUARIO = $id");
                                $statement = oci_parse($connection, $SQL_regional);
                                oci_execute($statement);
                                $array_regional = oci_fetch_array($statement, OCI_BOTH);

                                $query = "SELECT T_ID_ACTA,NOMBRE,CIUDAD,LUGAR,CODIGO_REGIONAL,FECHA FROM T_ACTA WHERE CODIGO_REGIONAL = '$array_regional[CODIGO_REGIONAL]' ORDER BY T_ID_ACTA DESC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
//                                $fecha = DateTime::createFromFormat('d-m-Y', $row['FECHA']);
//                                $fecha = $myDateTime->format($fecha, 'Y');
                                    $fecha = $row['FECHA'];
                                    $fecha = explode('/', $fecha);
                                    ?>
                                    <tr>
                                        <td><?php echo $row['CODIGO_REGIONAL'] . "-" . $row['T_ID_ACTA'] . "-" . $fecha[2] ?></td>
                                        <td><?php echo $row['NOMBRE'] ?></td>
                                        <td><?php echo $row['CIUDAD'] ?></td>
                                        <td><?php echo $row['LUGAR'] ?></td>
                                        <td><?php echo $row['CODIGO_REGIONAL'] ?></td>
                                        <td>
                                            <form action="agregar_acta.php" method="post"> 
                                                <input type="hidden" value="<?php echo $row['T_ID_ACTA'] ?>" name="id_acta"> 
                                                <input type="submit" value="Ver Detalles"> 
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                oci_close($connection);
                                ?>
                            </tbody>
                        </table>
                    </center><br></br>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>