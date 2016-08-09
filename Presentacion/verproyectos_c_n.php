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
                <a href="verproyectos_c_n_histo.php">Proyectos año 2015</a> || 
                <a href="verproyectos_c_n.php">Proyectos año 2016</a>
                <?php
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);

                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>

                <center>
                    <br>
                    <center><?php echo '<font><strong>Bienvenido (a) : ', utf8_encode($nom), ' </strong></font>'; ?></center>
                    </br>
                    <form>
                        <br>
                        <center><?php echo '<font><strong> Proyectos 2016</strong></font>'; ?></center>
                        <br>
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br></br>
                        <center>
                            <table id="demotable1" >
                                <thead><tr>
                                        <th>Radicado PROYECTO</th>
                                        <th>Fecha y Hora Elaboración</th>
                                        <th>Empresa</th>
                                        <th>Código de Regional</th>
                                        <th>Regional</th>
                                        <th>Código de Centro</th>
                                        <th>Centro</th>
                                        <!--<th>.Aprobado para Solicitud de Instrumentos</th>-->
                                        <th>Observaciones</th>
                                        <th>Normas que Atiende el Proyecto</th>
                                        <th>Detalles PROYECTO</th>
                                    </tr></thead>
                                <tbody>
                                </tbody>

                                <?php
                                $fecha = date('Y');
                                $query = "SELECT ID_PROYECTO,ID_REGIONAL,ID_CENTRO,FECHA_ELABORACION,NIT_EMPRESA,ID_PLAN,APROBADO_INSTRUMENTOS FROM PROYECTO WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numRows = oci_fetch_all($statement, $row);
                                for ($i = 0;$i < $numRows;$i++) {
                                    
                                    $query4 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa =  '".$row[NIT_EMPRESA][$i]."'");
                                    $statement4 = oci_parse($connection, $query4);
                                    $resp4 = oci_execute($statement4);
                                    $empresa = oci_fetch_array($statement4, OCI_BOTH);
                                    $query5 = ("SELECT COUNT(*) FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='".$row[ID_PROYECTO][$i]."'");
                                    $statement5 = oci_parse($connection, $query5);
                                    $resp5 = oci_execute($statement5);
                                    $tcron = oci_fetch_array($statement5, OCI_BOTH);
                                    $query6 = ("SELECT COUNT(*) FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO='".$row[ID_PROYECTO][$i]."'");
                                    $statement6 = oci_parse($connection, $query6);
                                    $resp6 = oci_execute($statement6);
                                    $teva = oci_fetch_array($statement6, OCI_BOTH);
                                    $query7 = ("SELECT COUNT(*) FROM CANDIDATOS_PROYECTO WHERE ID_PROYECTO='".$row[ID_PROYECTO][$i]."'");
                                    $statement7 = oci_parse($connection, $query7);
                                    $resp7 = oci_execute($statement7);
                                    $tcand = oci_fetch_array($statement7, OCI_BOTH);
                                    $query8 = ("SELECT COUNT(*) FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='".$row[ID_PROYECTO][$i]."'");
                                    $statement8 = oci_parse($connection, $query8);
                                    $resp8 = oci_execute($statement8);
                                    $treq = oci_fetch_array($statement8, OCI_BOTH);
                                    
                                    $queryProyetoNac = ("SELECT COUNT(*) AS NUMNAC, PRO.ID_PROYECTO_NACIONAL  
                                        FROM 
                                        ( SELECT 
                                            ProyNaReg.ID_PROYECTO_NACIONAL, 
                                            ProyNaReg.ID_PROYECTO 
                                          FROM T_PROY_NAC_PROY_REG ProyNaReg 
                                          UNION 
                                          SELECT 
                                            ProyNaP.ID_PROYECTO_NACIONAL, 
                                            ProyNaP.ID_PROYECTO 
                                          FROM T_PROY_NAC_PROYECTO ProyNaP) PRO
                                        INNER JOIN T_PROYECTOS_NACIONALES PRON
                                        ON PRO.ID_PROYECTO_NACIONAL = PRON.ID_PROYECTO_NACIONAL
                                        WHERE PRO.ID_PROYECTO =  '".$row[ID_PROYECTO][$i]."'
                                            AND PRON.ESTADO=1
                                            GROUP BY PRO.ID_PROYECTO_NACIONAL");
                                    $statementProyetoNac = oci_parse($connection, $queryProyetoNac);
                                    oci_execute($statementProyetoNac);
                                    $proyectoNac = oci_fetch_array($statementProyetoNac, OCI_BOTH);
                                    
                                    
                                     if ($proyectoNac['NUMNAC'] > 0) {
                                        $proyectoNacional = ' - Proyecto Nacional ' . $proyectoNac['ID_PROYECTO_NACIONAL'];
                                        $classDivProNac = 'divProNac';
                                    } else {
                                        $proyectoNacional = '';
                                        $classDivProNac = 'ninguna';
                                    }

                                    if ($row["ID_ESTADO_PROYECTO"][$i] == 1) {
                                        echo "<tr class='$classDivProNac'><td width=\"15%\"><font face=\"verdana\">" .
                                        $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"][$i] .  $proyectoNacional . "</font></td>";
                                    } else {
                                        echo "<tr class='$classDivProNac'><td width=\"15%\"><font face=\"verdana\">" .
                                        $fecha . '-' . $row["ID_REGIONAL"][$i] . '-' . $row["ID_CENTRO"][$i] . '-' . $row["ID_PLAN"][$i] . '-P' . $row["ID_PROYECTO"][$i] .  $proyectoNacional . "</font></td>";
                                    }

                                    $query9 = ("SELECT NOMBRE_REGIONAL FROM REGIONAL WHERE CODIGO_REGIONAL='".$row[ID_REGIONAL][$i]."'");
                                    $statement9 = oci_parse($connection, $query9);
                                    $resp9 = oci_execute($statement9);
                                    $nomreg = oci_fetch_array($statement9, OCI_BOTH);
                                    $query10 = ("SELECT NOMBRE_CENTRO FROM CENTRO WHERE CODIGO_CENTRO='".$row[ID_CENTRO][$i]."'");
                                    $statement10 = oci_parse($connection, $query10);
                                    $resp10 = oci_execute($statement10);
                                    $nomcen = oci_fetch_array($statement10, OCI_BOTH);
                                    
                                    

                                    if ($empresa[0] == null) {
                                        $e = "Demanda Social";
                                    } else {
                                        $e = $empresa[0];
                                    }
                                    if ($row[APROBADO_INSTRUMENTOS][$i] == 0) {
                                        $a = "No";
                                    } else {
                                        $a = "Si";
                                    }
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["FECHA_ELABORACION"][$i] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    utf8_encode($e) . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["ID_REGIONAL"][$i] . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    utf8_encode($nomreg[0]) . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["ID_CENTRO"][$i] . "</font></td>";
                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    utf8_encode($nomcen[0]) . "</font></td>";
//                                    echo "<td width=\"\"><font face=\"verdana\">" .
//                                    $a . "..</font></td>";

                                    $query = "SELECT *
                                        FROM T_OBSER_PROY_ASES 
                                        WHERE ID_PROYECTO = ".$row[ID_PROYECTO][$i];
                                    $statement = oci_parse($connection, $query);
                                    oci_execute($statement);
                                    $numRows1 = oci_fetch_all($statement, $rows);

                                    if ($numRows1 == 0) {
                                        echo "<td width=\"\"><a href=\"./registrar_obser_proyecto_asesor.php?proyecto=" . $row["ID_PROYECTO"][$i] . "\" >
                                            Registrar</a></td>";
                                    } else {
                                        echo "<td width=\"\">
                                                Observaciones registradas ($numRows1) <br/><br/>
                                                <a href=\"./registrar_obser_proyecto_asesor.php?proyecto=" . $row["ID_PROYECTO"][$i] . "\" >Registrar nueva observacion</a>
                                            </td>";
                                    }
                                    echo "<td width=\"\"><a href=\"./cons_normas_proyecto_c.php?proyecto=" . $row["ID_PROYECTO"][$i] . "\" >
                                Ver normas</a></td>";
                                    echo "<td width=\"\"><a href=\"./verdetalles_proyecto_c_n2.php?proyecto=" . $row["ID_PROYECTO"][$i] . "\"  TARGET=\"_blank\">
                                Ver Detalles</a></td></tr>";
                                }



                                oci_close($connection);
                                ?>
                            </table>


                        </center><br></br>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>



    </body>
</html>