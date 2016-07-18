<?php
session_start();
if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
    echo '<script>window.location = "../index.php"</script>';
}
?>
<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrí©s Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
íºltima actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="js/validar_textarea.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                $('#f1').validate({
                    rules: {
                        "tipo_novedades_grupo": {
                            required: true
                        },
                        "observacion": {
                            maxlength: 100
                        }
                    }
                });

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
        <div id="contenedorcito" >
            <?php
            require_once("../Clase/conectar.php");
            extract($_GET);
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $query = "SELECT TN.TIPO_NOVEDAD, NC.OBSERVACION, NC.FECHA_REGISTRO, NC.HORA_REGISTRO FROM T_NOVEDADES_CANDI_GRUP NC "
                    . "INNER JOIN T_TIPO_NOVEDADES TN "
                    . "ON NC.TIPO_NOVEDAD = TN.ID_T_TIPO_NOVEDADES "
                    . "WHERE ID_T_NOVEDADES_GRUPO = $id_novedad";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $numNov = oci_fetch_all($statement, $row)
            ?>
            <center>
                <table>
                    <tr>
                        <th colspan="2">Detalles de la novedad</th>
                    </tr>
                    <tr>
                        <td>Tipo novedad grupo</td>
                        <td>
                            <?php echo $row['TIPO_NOVEDAD'][0] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Observación</td>
                        <td><?php echo $row['OBSERVACION'][0] ?></td>
                    </tr>
                    <tr>
                        <td>Fecha Novedad</td>
                        <td><?php echo $row['FECHA_REGISTRO'][0] ?></td>
                    </tr>
                    <tr>
                        <td>Hora Novedad</td>
                        <td><?php echo $row['HORA_REGISTRO'][0] ?></td>
                    </tr>
                </table>
            </center>
        </div>
        <div class="space">&nbsp;</div>
        <?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en lí­nea" title="Pagos en lí­nea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>