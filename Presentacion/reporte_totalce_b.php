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
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />


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
            function aMayusculas(obj, id) {
                obj = obj.toUpperCase();
                document.getElementById(id).value = obj;
            }
        </script>

    </head>
    <body onload="inicio()">

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">

                <br>
                <?php
                include("../Clase/Norma.php");
                $ob = New Norma();
                ?>
                <center>
                    <form>
                        <br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>   ||   <a   class="exportacion"   href="ExpTotalesInstCent.php">Exportar a Excel<img src="../images/excel.png" width="26" height="26"></img></a>
                        <br></br>
                        <center>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>N°</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Regional</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Regional</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Centro</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Centro</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Mesa</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Mesa</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Norma</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Versión Norma</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Título Norma</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>Instrumento</strong></th>
                                        <th style="background-color:#006; text-align:center; color:#FFF"><strong>TOTAL</strong></th>

                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <!--round (i.total*100/m.meta,2) Porcentaje-->
                                <?php
// Un proceso repetitivo para imprimir cada uno de los registros.
                                $query2 = "select 
p.id_regional CODIGO_REGIONAL,
r.nombre_regional NOMBRE_REGIONAL,
p.id_centro CODIGO_CENTRO,
ce.nombre_centro NOMBRE_CENTRO,
m.codigo_mesa CODIGO_MESA,
m.nombre_mesa NOMBRE_MESA,
n.codigo_norma CODIGO_NORMA,
n.version_norma VERSION_NORMA,
n.titulo_norma TITULO_NORMA,
ob.respuesta INSTRUMENTO,
COUNT (*) TOTAL
from obs_banco ob
inner join proyecto p
on p.id_proyecto=ob.id_proyecto
inner join regional r
on r.codigo_regional=p.id_regional
inner join centro ce
on ce.codigo_centro=p.id_centro
inner join norma n
on n.id_norma=ob.id_norma
inner join mesa m
on m.codigo_mesa=SUBSTR( n.codigo_norma, 2, 5 )
group by 
p.id_regional,
r.nombre_regional ,
p.id_centro ,
ce.nombre_centro ,
m.codigo_mesa,
m.nombre_mesa,
n.codigo_norma,
n.version_norma,
n.titulo_norma,
ob.respuesta 
ORDER BY r.nombre_regional,ce.nombre_centro ASC";
                                $statement2 = oci_parse($connection, $query2);
                                oci_execute($statement2);

                                $numero = 0;
                                while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {


                                    $s = $numero + 1;

                                    echo "<tr><td><font face=\"verdana\"><center>" .
                                    $s . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_REGIONAL"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_CENTRO"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_CENTRO"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_MESA"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["NOMBRE_MESA"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["CODIGO_NORMA"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["VERSION_NORMA"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    utf8_encode($row2["TITULO_NORMA"]) . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["INSTRUMENTO"] . "</center></font></td>";
                                    echo "<td><font face=\"verdana\"><center>" .
                                    $row2["TOTAL"] . "</center></font></td></tr>";


                                    $numero++;
                                }

                                oci_close($connection);
                                ?>
                            </table>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>

    </body>
</html>