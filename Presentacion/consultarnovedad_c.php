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
include("../Clase/Norma.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$ob = New Norma();
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
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
        <!--<script src="../jquery/jquery-1.6.3.min.js"></script>-->
        <script>
            $(document).ready(function() {
                $("#content div").hide();
                $("#tabs li:first").attr("id", "current");
                $("#content div:first").fadeIn();

                $('#tabs a').click(function(e) {
                    e.preventDefault();
                    $("#content div").hide();
                    $("#tabs li").attr("id", "");
                    $(this).parent().attr("id", "current");
                    $('#' + $(this).attr('title')).fadeIn();
                });
            })();
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
                <br></br>
                <?php
                $query3 = ("SELECT id_centro from centro_usuario where id_usuario=  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $centro = oci_fetch_array($statement3, OCI_BOTH);
                ?>
                <center>
                    <strong>Reporte de Novedades</strong>
                </center>
                <br></br>
                <form>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <table id="demotable1" >
                            <thead><tr>
                                    <th><strong>Código Novedad</strong></th>
                                    <th><strong>Tipo Novedad</strong></th>
                                    <th><strong>Fecha Registro</strong></th>
                                    <th><strong>Detalles</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
//                                    $query2 = "select
//                                                id_novedad,
//                                                tipo_novedad,
//                                                fecha_novedad
//                                                from novedad n
//                                                inner join tipo_novedad t
//                                                on n.id_t_novedad=t.id_tipo_novedad
//                                                where id_usuario='$id'";
//
//                                    $statement2 = oci_parse($connection, $query2);
//                                    oci_execute($statement2);
//
//                                    $numero = 0;
//                                    while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
//                                        
//
//                                            echo "<tr><td width=\"%\"><font face=\"verdana\"><center>" .
//                                            'NoV'.$row2["ID_NOVEDAD"] . "</center></font></td>";
//                                            echo "<td width=\"%\"><font face=\"verdana\"><center>" .
//                                            utf8_encode($row2["TIPO_NOVEDAD"]) . "</center></font></td>";
//                                            echo "<td width=\"%\"><font face=\"verdana\"><center>" .
//                                            $row2["FECHA_NOVEDAD"] . "</center></font></td>";
//                                            
//                                            echo "<td width=\"\">No Disponible</td></tr>";
//
////                                            echo "<td width=\"\"><a href=\"./detalles_novedad_c.php?codigo=" . $row2["ID_NOVEDAD"] . "\" TARGET=\"_blank\">
////                                                Ver Detalles</a></td></tr>";
//                                        
//
//                                        $numero++;
//                                    }
                            ?>
                        </table>
                </form>
                </center> 
            </div>
        </div>

    </div>
    <?php include ('layout/pie.php') ?>
</body>
</html>