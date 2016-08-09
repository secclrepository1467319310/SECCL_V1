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
                    <center><strong>Información Evaluador del Proyecto</strong></center>
                </br>
                <?php
                require_once("../Clase/conectar.php");
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

                $proyecto = $_GET["proyecto"];
                $doc = $_GET["id"];
                
                $query5 = ("select count(*) from curso_ev where documento='$doc'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $curso = oci_fetch_array($statement5, OCI_BOTH); 
                
                ?>

                <br></br>

                <center><form>
                        <table>
                            <tr>
                                <th>Tipo Documento</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Estado</th>
                                <th>Registrado para el Curso</th>
                            </tr>

                            <?php
                            $query2 = "SELECT DISTINCT T_DOCUMENTO,DOCUMENTO,NOMBRE,ESTADO_EVALUADOR
                                FROM EVALUADOR
                                WHERE DOCUMENTO= '$doc'";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            $num = 0;
                            while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                
                                if ($curso[0]>0) {
                                    
                                    $p="Si";
                                }else{
                                    $p="No";
                                    
                                }
                                
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["T_DOCUMENTO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["DOCUMENTO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["NOMBRE"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["ESTADO_EVALUADOR"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $p . "</font></td></tr>";

                                $num++;
                            }
                           
                            ?>
                        </table>
                        <br>
                        <center>
                            <strong>Estado 0</strong> :&nbsp;Inactivo &nbsp;&nbsp;
                            <strong>Estado 1</strong> :&nbsp;Activo &nbsp;&nbsp;
                            <strong>Estado 3</strong> :&nbsp;Postulado &nbsp;&nbsp;
                            <strong>Estado 5</strong> :&nbsp;En Actualización &nbsp;&nbsp;
                            <strong>Estado 6</strong> :&nbsp;Retirado &nbsp;&nbsp;
                            <strong>Vacío</strong> :&nbsp;Sin estado
                            
                        </center>
                    </br>
                        <br>
                            <strong>Normas Asociadas</strong>
                        </br>
                        <br>
                            <table>
                                <tr>
                                    <th>Código Mesa</th>
                                    <th>Mesa</th>
                                    <th>Código NCL</th>
                                    <th>Versión NCL</th>
                                    <th>Título</th>
                                </tr>
                                <?PHP
                                $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                                $statement8 = oci_parse($connection, $query8);
                                $resp8 = oci_execute($statement8);
                                $pro = oci_fetch_array($statement8, OCI_BOTH);

                                $q = "SELECT DISTINCT ID_NORMA from evaluador_proyecto where id_evaluador = '$doc' and id_proyecto='$proyecto'";
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
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["NOMBRE_MESA"] . "</font></td>";
                                        echo "<td width=\"5%\"><font face=\"verdana\">" .
                                        $row["CODIGO_NORMA"] . "</font></td>";
                                        echo "<td width=\"2%\"><font face=\"verdana\">" .
                                        $row["VERSION_NORMA"] . "</font></td>";
                                        echo "<td width=\"25%\"><font face=\"verdana\">" .
                                        utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                        
                                        $numero3++;
                                    }
                                    $numero++;
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