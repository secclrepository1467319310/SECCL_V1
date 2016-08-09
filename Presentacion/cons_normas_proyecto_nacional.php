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
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

            $proyecto = $_GET["proyecto"];
            ?>
            <br>
            <center><strong>Normas que Atienden el Proyecto</strong></center>
            </br>

            <form name="formmapa" action="guardar_cons_normas_proyecto_nacional.php" method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
                <input type="hidden" name="hidIdProyecto" value="<?php echo $proyecto; ?>" />
                <center>
                    <table id="demotable1">
                        <thead><tr>
                                <th><strong>Código Mesa</strong></th>
                                <th><strong>Mesa</strong></th>
                                <th><strong>Código Norma</strong></th>
                                <th><strong>Versión</strong></th>
                                <th><strong>Título Norma</strong></th>
                                <th><strong>Seleccionar Normas</strong></th>
                            </tr></thead>
                        <tbody>
                        </tbody>

                        <?php
                        $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                        $statement8 = oci_parse($connection, $query8);
                        $resp8 = oci_execute($statement8);
                        $pro = oci_fetch_array($statement8, OCI_BOTH);

                        $q = "select id_deta,id_norma from detalles_poa where id_provisional='$pro[0]'";
                        $statement3 = oci_parse($connection, $q);
                        oci_execute($statement3);
                        $numero3 = 0;
                        while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {
                            $query = "select mesa.nombre_mesa,norma.codigo_mesa,norma.codigo_norma,norma.version_norma,
                                norma.titulo_norma,norma.id_norma from norma
                                join mesa
                                on mesa.codigo_mesa=norma.codigo_mesa
                                where norma.id_norma='$row3[ID_NORMA]'";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;

                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_MESA"] . "</font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\">" .
                                utf8_encode($row["NOMBRE_MESA"]) . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_NORMA"] . "</font></td>";
                                echo "<td width=\"2%\"><font face=\"verdana\">" .
                                $row["VERSION_NORMA"] . "</font></td>";
                                echo "<td width=\"45%\"><font face=\"verdana\">" .
                                utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                ?>
                                <input type="hidden" name="proyecto" value="<?php echo $proyecto; ?>" />
                                <td><center><input type="checkbox" name="normasProNac[]" value="<?php echo $row3[ID_DETA]; ?>" /></center</td></tr>
                                <?php
                                $numero3++;
                            }
                            $numero++;
                        }
                        ?>
                    </table>
                    <br>
                    <input type="submit" name="btnEnviar" value="Guardar"/>
                </center>
                <br>
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