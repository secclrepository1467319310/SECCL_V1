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
                <?php
                $idarea = $_GET['idarea'];
                $centro = $_GET['centro'];
                ?>
                <ul id="tabs">
                    <!--<li><a href="#" title="tab1">Áreas Claves año 2015</a></li>-->
                    <!--<li><a href="#" title="tab2">Soportes</a></li>-->
                </ul>
                <!--style="height:219px;width:920px;overflow:scroll;"-->
                <div> 
                    <div id="tab1">
                        <center>
                            <strong>Áreas Claves año 2016</strong>
                        </center>
                        <center>
                            <form>
<!--                                <br>
                                <a href="agregar_area_cm.php?idarea=<?php echo $idarea ?>"><strong>Adicionar Área</strong></a><br></br>
                                <br>-->
                                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                    <table id="demotable1" >
                                        <thead><tr>
                                                <th><strong>Id</strong></th>
                                                <th><strong>Código Mesa</strong></th>
                                                <th><strong>Nombre Mesa</strong></th>
                                                <th><strong>Aprobado Asesor</strong></th>
                                                <th><strong>Observaciones Coordinador</strong></th>
                                                <th><strong>Observaciones Asesor</strong></th>
                                                <!--<th><strong>Editar Observación Coordinador Misional</strong></th>-->
                                                <th><strong>Eliminar Área</strong></th>
                                            </tr></thead>
                                        <tbody>
                                        </tbody>

                                        <?php
                                        $query2 = "select
                                    id_areas_centro,
                                    id_mesa,
                                    nombre_mesa,
                                    aprobado_asesor,
                                    obs_misional,
                                    obs_asesor
                                    from areas_claves_centro ac
                                    inner join mesa m
                                    on ac.id_mesa=m.codigo_mesa
                                    where ac.id_area_clave='$idarea' AND (PERIODO is null OR PERIODO = 2016)";

                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);

                                        $num = 0;
                                        while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {



                                            if ($row2["APROBADO_ASESOR"] == 0) {
                                                $a = "No Aprobado";
                                            } else if ($row2["APROBADO_ASESOR"] == 1) {
                                                $a = "Si Aprobado";
                                            } else if ($row2["APROBADO_ASESOR"] == 2) {
                                                $a = "Transitoriamente Aprobado";
                                            } else {
                                                $a = "Para Aprobar";
                                            }

                                            echo "<tr><td width=\"%\"><font face=\"verdana\"><center>" .
                                            $row2["ID_AREAS_CENTRO"] . "</center></font></td>";
                                            echo "<td width=\"%\"><font face=\"verdana\"><center>" .
                                            $row2["ID_MESA"] . "</center></font></td>";
                                            echo "<td width=\"%\"><font face=\"verdana\"><center>" .
                                            utf8_encode($row2["NOMBRE_MESA"]) . "</center></font></td>";
                                            echo "<td width=\"%\"><font face=\"verdana\"><center>" .
                                            $a . "</center></font></td>";
                                            echo "<td><textarea cols=\"20\" readonly rows=\"3\">$row2[OBS_MISIONAL]</textarea></td></td>";
                                            echo "<td><textarea cols=\"20\" readonly rows=\"3\">$row2[OBS_ASESOR]</textarea></td></td>";
//                                            if ($row2[OBS_MISIONAL] == "Sin Comentarios") {
//                                                echo "<td><a href=\"editar_areas_cm.php?centro=$centro&idarea=$idarea&iddeta=$row2[ID_AREAS_CENTRO]\"><img src=\"../images/editar.png\" alt=\"20\" width=\"20\"></a></td>";
//                                            } else {
//                                                echo "<td><a href=\"editar_areas_t_cm.php?centro=$centro&idarea=$idarea&iddeta=$row2[ID_AREAS_CENTRO]\"><img src=\"../images/editar.png\" alt=\"20\" width=\"20\"></a></td>";
//                                            }
                                            if ($row2[OBS_ASESOR] == NULL) {
                                                echo "<td><a href=\"eliminar_areas_cm.php?centro=$centro&idarea=$idarea&iddeta=$row2[ID_AREAS_CENTRO]\"><img src=\"../images/roja.png\" alt=\"20\" width=\"20\"></a></td></tr>";
                                            } else {
                                                echo "<td>No disponible</td></tr>";
                                            }

                                            $num++;
                                        }
                                        ?>
                                    </table>
                            </form>
                        </center> 
                    </div>
<!--                    <div id="tab2">
                        <form>
                            <br>
                            <center><strong>Soporte Actas-Áreas Claves</strong></center>
                            <br><a href="cargar_soporte_area.php?idarea=<?php echo $idarea ?>"><strong>Adicionar Acta</strong></a><br></br>
                            <table border="1" id="demotable1"  style="height:350px;width:920px;overflow:scroll;">
                                <thead><tr>
                                        <th><strong>Id</strong></th>
                                        <th><strong>Tipo de Documento</strong></th>
                                        <th><strong>Observaciones</strong></th>
                                        <th><strong>Nombre de Archivo (en el Servidor)</strong></th>
                                        <th><strong>Ver</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <?php
//                                $query = "SELECT 
//    ID_PORTAFOLIO_AREAS,
//    NOMBRE_DOCUMENTO,
//    DESCRIPCION,
//    FILENAME
//    FROM PORTAFOLIO_AREAS P
//    INNER JOIN TIPO_DOC_PORTAFOLIO TP
//    ON P.TIPO_DOCUMENTO=TP.ID_TDOC_PORTAFOLIO
//    WHERE ID_AREA='$idarea'
//    ORDER BY ID_PORTAFOLIO_AREAS DESC";
//                                $statement = oci_parse($connection, $query);
//                                oci_execute($statement);
//
//
//                                $numero = 0;
//                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
//
//
//                                    echo "<tr><td width=\"\"><font face=\"verdana\">" .
//                                    $row["ID_PORTAFOLIO_AREAS"] . "</font></td>";
//                                    echo "<td width=\"\"><font face=\"verdana\">" .
//                                    utf8_encode($row["NOMBRE_DOCUMENTO"]) . "</font></td>";
//                                    echo "<td width=\"\"><font face=\"verdana\">" .
//                                    utf8_encode($row["DESCRIPCION"]) . "</font></td>";
//                                    echo "<td width=\"\"><font face=\"verdana\">" .
//                                    utf8_encode($row["FILENAME"]) . "</font></td>";
//                                    echo "<td width=\"\"><a href=\"file3.php?id=" . $row["ID_PORTAFOLIO_AREAS"] . "\" TARGET=\"_blank\">
//        Ver</a></td></tr>";
//
//
//                                    $numero++;
//                                }
                                ?>
                            </table>
                            <br></br>
                            <center><strong>Respuesta Áreas Claves</strong></center>
                            <br>
                            <table border="1" id="demotable1"  style="height:350px;width:920px;overflow:scroll;">
                                <thead><tr>
                                        <th><strong>Id</strong></th>
                                        <th><strong>Nombre de Documento</strong></th>
                                        <th><strong>Ver</strong></th>
                                    </tr></thead>
                                <tbody>
                                </tbody>
                                <?php
//                                $query3 = "SELECT 
//    ID_RESPUESTA,
//    SOPORTE
//    FROM RESPUESTA_AREAS_CLAVES WHERE ID_AREA='$idarea'";
//                                $statement3 = oci_parse($connection, $query3);
//                                oci_execute($statement3);
//
//
//                                $nume = 0;
//                                while ($row23 = oci_fetch_array($statement3, OCI_BOTH)) {
//
//
//                                    echo "<tr><td width=\"\"><font face=\"verdana\">" .
//                                    $row23["ID_RESPUESTA"] . "</font></td>";
//                                    echo "<td width=\"\"><font face=\"verdana\">" .
//                                    utf8_encode($row23["SOPORTE"]) . "</font></td>";
//                                    echo "<td width=\"\"><a href=\"./descargar_soporte_onbase.php?id=" . $row23["ID_RESPUESTA"] . "\" >
//                                    Descargar</a></td></tr>";
//                                    $nume++;
//                                }
                                ?>
                            </table>
                        </form>
                    </div>-->
                </div>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>