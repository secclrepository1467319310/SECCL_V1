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
        <script type="text/javascript" src="js/val_consultar_plan_ev.js"></script>
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
	<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito" >
            <br>
            <center><h1>Instrumentos Utilizados</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            include ("calendario/calendario.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];

            //-----
            $query34 = ("select n.codigo_norma from norma n 
inner join plan_evidencias pe 
on pe.id_norma=n.id_norma
where pe.id_plan='$plan'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $codnorma = oci_fetch_array($statement34, OCI_BOTH);
            //-----
            $query342 = ("select n.version_norma from norma n 
inner join plan_evidencias pe 
on pe.id_norma=n.id_norma
where pe.id_plan='$plan'");
            $statement342 = oci_parse($connection, $query342);
            $resp342 = oci_execute($statement342);
            $vrsnorma = oci_fetch_array($statement342, OCI_BOTH);
            //-----
            $query343 = ("select n.titulo_norma from norma n 
inner join plan_evidencias pe 
on pe.id_norma=n.id_norma
where pe.id_plan='$plan'");
            $statement343 = oci_parse($connection, $query343);
            $resp343 = oci_execute($statement343);
            $titnorma = oci_fetch_array($statement343, OCI_BOTH);
            ?>
            <form class='proyecto' name="formmapa" id="f1" action="guardar_instrumentos_ev.php?plan=<?php echo $plan ?>" method="post" accept-charset="UTF-8" >
                <center>
                    <fieldset>
                        <legend><strong>Instrumentos de Evaluacion</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th colspan="3">Norma de competencia Laboral</th>
                                <th rowspan="2">Instrumento</th>
                                <th colspan="2">Novedad</th>
                            <tr>
                                <th width="">Código NCL</th>
                                <th width="">Version NCL</th>
                                <th width="">Título NCL</th>
                                <th width="">Novedad</th>
                                <th width="">Fecha</th>
                            </tr>
                            <tr>
                                <td><?php echo $codnorma[0] ?></td>
                                <td><?php echo $vrsnorma[0] ?></td>
                                <td><?php echo utf8_encode($titnorma[0]) ?></td>
                                <td><input type="text"  name="instrumentos"></input></td>
                                <td><textarea rows="4" cols="20" name="novedad"></textarea></td>
                                <td  class='BA'>
                                    <?php
                                    escribe_formulario_fecha_vacio("fi", "formmapa");
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <br></br>
                        <p><label>
                                <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                        </label></p>
                        <br>
                        <a href = "concertacion_f_plan_ev.php?idplan=<?php echo $plan ?>"><strong>Concertación de Fechas</strong></a>
                        <br>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Instrumentos de Evaluacion</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th colspan="3">Norma de competencia Laboral</th>
                                <th rowspan="2">Instrumento</th>
                                <th colspan="2">Novedad</th>
                            <tr>
                                <th width="">Código NCL</th>
                                <th width="">Version NCL</th>
                                <th width="">Título NCL</th>
                                <th width="">Novedad</th>
                                <th width="">Fecha</th>
                            </tr>
                            <?php
                            $query = "SELECT instrumentos,novedad,to_char(fecha_novedad,'dd/mm/YYYY') as FECHA_NOVEDAD from plan_instrumentos where id_plan='$plan' order by fecha_novedad asc";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                ?>
                                <tr>
                                    <td><?php echo $codnorma[0] ?></td>
                                    <td><?php echo $vrsnorma[0] ?></td>
                                    <td><?php echo utf8_encode($titnorma[0]) ?></td>
                                    <td><?php echo $row["INSTRUMENTOS"]; ?></td>
                                    <td><?php echo utf8_encode($row["NOVEDAD"]); ?></td>
                                    <td><?php echo $row["FECHA_NOVEDAD"]; ?></td>
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