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
        <div id="contenedorcito" >
            <br>
            <center><h1>Informes del centro <?php echo $centro ?></h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            ?>
            <div>
                <center>

                    <table id="demotable2">
                        <thead>
                            <tr>
                                <th><font face = "verdana"><b>PROYECTO</b></font></th>
                                <th><font face = "verdana"><b>CODIGO MESA</b></font></th>
                                <th><font face = "verdana"><b>MESA</b></font></th>
                                <th><font face = "verdana"><b>CODIGO NORMA</b></font></th>
                                <th><font face = "verdana"><b>NORMA</b></font></th>
                                <th><font face = "verdana"><b>GRUPO</b></font></th>
                                <th><font face = "verdana"><b>INFORME</b></font></th>
                            </tr>
                        </thead>
                        <?php
                        $queryInforme = "SELECT PY.ID_PROYECTO, ME.CODIGO_MESA, ME.NOMBRE_MESA, NM.CODIGO_NORMA, NM.TITULO_NORMA, PE.GRUPO, PE.ID_PLAN 
FROM T_INFORME_CUALITATIVO_PROYECTO IC 
INNER JOIN PLAN_EVIDENCIAS PE 
ON PE.ID_PLAN = IC.ID_PLAN_EVIDENCIAS 
INNER JOIN PROYECTO PY 
ON PY.ID_PROYECTO = PE.ID_PROYECTO 
INNER JOIN CENTRO CE 
ON CE.CODIGO_CENTRO = PY.ID_CENTRO 
INNER JOIN REGIONAL REG 
ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL
INNER JOIN NORMA NM
ON PE.ID_NORMA = NM.ID_NORMA
INNER JOIN MESA ME
ON NM.CODIGO_MESA = ME.CODIGO_MESA
WHERE CE.CODIGO_CENTRO = $centro  AND SUBSTR(PY.FECHA_ELABORACION,7,4)='2016'
ORDER BY REG.NOMBRE_REGIONAL ASC";
                        $statementInforme = oci_parse($connection, $queryInforme);
                        oci_execute($statementInforme);
                        while ($informe = oci_fetch_array($statementInforme, OCI_BOTH)) {
                            ?>
                            <tr>
                                <td><?php echo $informe["ID_PROYECTO"]; ?></td>
                                <td><?php echo $informe["CODIGO_MESA"]; ?></td>
                                <td><?php echo utf8_encode($informe["NOMBRE_MESA"]); ?></td>
                                <td><?php echo $informe["CODIGO_NORMA"]; ?></td>
                                <td><?php echo utf8_encode($informe["TITULO_NORMA"]); ?></td>
                                <td><?php echo $informe["GRUPO"]; ?></td>
                                <td><a href="consulta_informe_cualitativo.php?id_plan=<?php echo $informe['ID_PLAN'] ?>" >INFORME</a></td>
                            </tr>
                            <?php
                            $numero21++;
                        }
                        ?>
                    </table>
                    <br>
                </center>
            </div>
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