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
                <br>
                    <center><strong>Información Evaluador</strong></center>
                </br>
                <?php
                require_once("../Clase/conectar.php");
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

                $doc = $_GET['documento'];
                ?>

                <br></br>

                <center><form>
                        <table>
                            <tr>
                                <th>Tipo Documento</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                            </tr>

                            <?php
                            $query2 = "SELECT DISTINCT usuario.tipo_doc, usuario.documento,
usuario.nombre, usuario.primer_apellido,usuario.segundo_apellido,usuario.usuario_id
FROM usuario
WHERE usuario.documento = '$doc'";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            $num = 0;
                            while ($row = oci_fetch_array($statement2, OCI_BOTH)) {

                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["TIPO_DOC"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["DOCUMENTO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["NOMBRE"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["PRIMER_APELLIDO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["SEGUNDO_APELLIDO"] . "</font></td></tr>";

                                $num++;
                            }
                           
                            ?>
                        </table>
                        <br>
                            <strong>Normas en las que puede Evaluar</strong>
                        </br>
                        <br>
                            <table>
                                <tr>
                                    <th>ID NCL</th>
                                    <th>Código NCL</th>
                                    <th>Versión NCL</th>
                                    <th>Título</th>
                                </tr>
                                <?PHP
                                
                                $q = "select
n.id_norma,
n.codigo_norma,
n.version_norma,
n.titulo_norma
from  evaluador_norma ev,norma n
where n.id_norma=ev.id_norma and 
ev.id_evaluador='$doc'";
                                $statement3 = oci_parse($connection, $q);
                                oci_execute($statement3);
                                $numero3 = 0;
                                while ($row = oci_fetch_array($statement3, OCI_BOTH)) {
                                    
                                        echo "<tr><td width=\"5%\"><font face=\"verdana\">" .
                                        $row["ID_NORMA"] . "</font></td>";
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["CODIGO_NORMA"] . "</font></td>";
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["VERSION_NORMA"] . "</font></td>";
                                        echo "<td width=\"25%\"><font face=\"verdana\">" .
                                        utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                        
                                        $numero3++;
                                    }
                                    
                                ?>
                            </table>
                            <br></br>
                    </form>
                </center>
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