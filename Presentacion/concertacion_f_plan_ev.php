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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_concertacion_f_plan_ev.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>

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
	<?php include ('layout/cabecera.php') ?>>
        <div id="contenedorcito" >
            <br>
            <center><h1>Concertación de Fechas</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            include ("calendario/calendario.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];

            
            ?>
            <form class='' name="formmapa" id="f1" action="guardar_concertacion_f_plan_ev.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" >
                <center>
                    <fieldset>
                        <legend><strong>Concertación de Fechas</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th colspan="3">Fecha de Concertación</th>
                                <th colspan="3">Evidencia de Conocimiento</th>
                                <th colspan="3">Oportunidad</th>
                            <tr>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                            </tr>
                            <tr>
                                <td  class='BA'>
                                    <?php
                                    escribe_formulario_fecha_vacio("fp", "formmapa");
                                    ?>
                                </td>
                                <td><input type="text" size="4"  name="horap"></input></td>
                                <td><textarea rows="3" cols="6" name="lugarp"></textarea></td>
                                <td  class='BA'>
                                    <?php
                                    escribe_formulario_fecha_vacio("fc", "formmapa");
                                    ?>
                                </td>
                                <td><input type="text" size="4"  name="horac"></input></td>
                                <td><textarea rows="3" cols="6" name="lugarc"></textarea></td>
                                <td  class='BA'>
                                    <?php
                                    escribe_formulario_fecha_vacio("fo", "formmapa");
                                    ?>
                                </td>
                                <td><input type="text" size="4"  name="horao"></input></td>
                                <td><textarea rows="3" cols="6" name="lugaro"></textarea></td>
                            </tr>
                        </table>
                        <br></br>
                        <p><label>
                                <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                        </label></p>
                        <br>
                        <a href = "listar_emision_ev.php?idplan=<?php echo $plan ?>"><strong>Emisión de Juicio</strong></a>
                        <br>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Concertación de Fechas</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th colspan="3">Primera Vez</th>
                                <th colspan="3">Evidencia de Conocimiento</th>
                                <th colspan="3">Oportunidad</th>
                            <tr>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                                <th width="">Fecha</th>
                                <th width="">Hora</th>
                                <th width="">Lugar</th>
                            </tr>
                            <?php
                            $query = "SELECT * from concertacion_fechas_plan where id_plan='$plan' ";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                ?>
                                <tr>
                                    <td><?php echo $row["P_FECHA"]; ?></td>
                                    <td><?php echo $row["P_HORA"]; ?></td>
                                    <td><?php echo utf8_encode($row["P_LUGAR"]); ?></td>
                                    <td><?php echo $row["EC_FECHA"]; ?></td>
                                    <td><?php echo $row["EC_HORA"]; ?></td>
                                    <td><?php echo utf8_encode($row["EC_LUGAR"]); ?></td>
                                    <td><?php echo $row["OP_FECHA"]; ?></td>
                                    <td><?php echo $row["OP_HORA"]; ?></td>
                                    <td><?php echo utf8_encode($row["OP_LUGAR"]); ?></td>
                                </tr>
                                <?php
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                </center>
            </form>
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