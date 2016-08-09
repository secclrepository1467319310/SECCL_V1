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

                $('.filter').css('width', '100%');
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

                <ul id="tabs">
                    <li><a href="#" title="tab1">Datos Generales</a></li>
                    <li><a href="#" title="tab2">Reporte Candidatos Por Proyecto</a></li>
                    <!--                <li><a href="#" title="tab3">Inscripción</a></li>
                                    <li><a href="#" title="tab4">Juicios</a></li>
                                    <li><a href="#" title="tab5">Otros</a></li>-->
                </ul>
                <div id="content" style="height: auto;"> 
                    <?php
                    $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS, COUNT(UNIQUE(NRO_IDENT)) AS PERSONAS FROM CE_FIRMA_CERTIFICADOS WHERE CENTRO_ID_CENTRO = "
                            . "(SELECT CE.CODIGO_CENTRO FROM CENTRO_USUARIO CU INNER JOIN CENTRO CE ON "
                            . "CU.ID_CENTRO = CE.ID_CENTRO where CU.id_usuario =  $id)|| '00' AND PERIODO = 2016 ");

                    $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                    oci_execute($statementCandidatosCertificados);
                    $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);

                    $queryCentroUsuario = ("SELECT CE.CODIGO_CENTRO FROM CENTRO_USUARIO CU INNER JOIN CENTRO CE ON "
                            . "CU.ID_CENTRO = CE.ID_CENTRO where CU.id_usuario =  $id");

                    $statementCentroUsuario = oci_parse($connection, $queryCentroUsuario);
                    oci_execute($statementCentroUsuario);
                    $centro = oci_fetch_array($statementCentroUsuario, OCI_BOTH);

                    $queryCandidatosInscritos = ("SELECT COUNT(*) AS INSCRITOS FROM PROYECTO PY "
                            . "INNER JOIN INSCRIPCION INS ON PY.ID_PROYECTO = INS.ID_PROYECTO "
                            . "WHERE PY.ID_CENTRO = (SELECT CE.CODIGO_CENTRO FROM CENTRO_USUARIO CU INNER JOIN CENTRO CE ON "
                            . "CU.ID_CENTRO = CE.ID_CENTRO where CU.id_usuario =  $id) AND ESTADO = 1 AND SUBSTR(INS.FECHA_REGISTRO, 7,2) = 16");

                    $statementCandidatosInscritos = oci_parse($connection, $queryCandidatosInscritos);
                    oci_execute($statementCandidatosInscritos);
                    $candidatosInscritos = oci_fetch_array($statementCandidatosInscritos, OCI_BOTH);
                    
                    $queryPersonasEvaluadas = ("SELECT COUNT(UNIQUE(EC.ID_CANDIDATO)) AS PERSONAS_EVALUADAS, COUNT(*) EVALUACIONES FROM PROYECTO PY 
INNER JOIN PLAN_EVIDENCIAS PE ON PE.ID_PROYECTO = PY.ID_PROYECTO
INNER JOIN EVIDENCIAS_CANDIDATO EC ON  PE.ID_PLAN = EC.ID_PLAN 
WHERE PY.ID_CENTRO = (SELECT CE.CODIGO_CENTRO FROM CENTRO_USUARIO CU INNER JOIN CENTRO CE ON 
CU.ID_CENTRO = CE.ID_CENTRO where CU.id_usuario =  $id) AND EC.ESTADO != 0 AND SUBSTR(EC.FECHA_REGISTRO, 7,2) = 16");

                    $statementPersonasEvaluadas = oci_parse($connection, $queryPersonasEvaluadas);
                    oci_execute($statementPersonasEvaluadas);
                    $candidatosPersonasEvaluadas = oci_fetch_array($statementPersonasEvaluadas, OCI_BOTH);


                    $queryCentro = ("SELECT nombre_centro FROM centro where codigo_centro = (SELECT CE.CODIGO_CENTRO "
                            . "FROM CENTRO_USUARIO CU INNER JOIN CENTRO CE ON "
                            . "CU.ID_CENTRO = CE.ID_CENTRO where CU.id_usuario =  $id)");
                    $statementCentro = oci_parse($connection, $queryCentro);
                    oci_execute($statementCentro);
                    $nomcen = oci_fetch_array($statementCentro, OCI_BOTH);
                    ?>
                    <div id="tab1">
                        <br>
                        <form name="f3" id="f3" onSubmit="return validarev();" method="post" 
                              action="guardar_evaluador.php" accept-charset="UTF-8">
                            <center>
                                <table>
                                    <tr>
                                        <th colspan="2">DATOS GENERALES <br> CENTRO <?php echo utf8_encode($nomcen['NOMBRE_CENTRO']); ?></th>
                                    </tr>
                                    <tr>
                                        <th>Número Certificados </th>
                                        <td><?php echo $certificados['CERTIFICADOS'] ?></td>
                                    </tr>
                                     <tr>
                                        <th>Número Personas Certificadas </th>
                                        <td><?php echo $certificados['PERSONAS'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Número Evaluaciones </th>
                                        <td><?php echo $candidatosPersonasEvaluadas['EVALUACIONES'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Número Personas Evaluadas </th>
                                        <td><?php echo $candidatosPersonasEvaluadas['PERSONAS_EVALUADAS'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Número Inscritos Formalizados </th>
                                        <td><?php echo $candidatosInscritos['INSCRITOS'] ?></td>
                                    </tr>
                                </table>
                            </center>
                        </form>
                        <br>
                    </div>

                    <div id="tab2">
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
                            <center><strong> Reporte Candidatos Por Proyecto </strong></center>
                            </br>
                            <form>
                                <br>
                                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                    <table id="demotable1" >
                                        <thead><tr>
                                                <th>Radicado PROYECTO</th>
                                                <th>Fecha y Hora Elaboración</th>
                                                <th>Empresa</th>
                                                <th>Reporte candidatos del Proyecto</th>

                                            </tr></thead>
                                        <tbody>
                                        </tbody>

                                        <?php
                                        $fecha = date('Y');
                                        $query = "SELECT ID_PROYECTO,FECHA_ELABORACION,NIT_EMPRESA,ID_PLAN FROM PROYECTO where ID_CENTRO='$cen[0]' AND SUBSTR(FECHA_ELABORACION, 7,4) = 2016";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);
                                        $numero = 0;
                                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                            $query4 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa =  '$row[NIT_EMPRESA]'");
                                            $statement4 = oci_parse($connection, $query4);
                                            $resp4 = oci_execute($statement4);
                                            $empresa = oci_fetch_array($statement4, OCI_BOTH);
                                            $query5 = ("SELECT COUNT(*) FROM CRONOGRAMA_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                            $statement5 = oci_parse($connection, $query5);
                                            $resp5 = oci_execute($statement5);
                                            $tcron = oci_fetch_array($statement5, OCI_BOTH);
                                            $query6 = ("SELECT COUNT(*) FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                            $statement6 = oci_parse($connection, $query6);
                                            $resp6 = oci_execute($statement6);
                                            $teva = oci_fetch_array($statement6, OCI_BOTH);
                                            $query7 = ("SELECT COUNT(*) FROM CANDIDATOS_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                            $statement7 = oci_parse($connection, $query7);
                                            $resp7 = oci_execute($statement7);
                                            $tcand = oci_fetch_array($statement7, OCI_BOTH);
                                            $query8 = ("SELECT COUNT(*) FROM REQUERIMIENTOS_PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                            $statement8 = oci_parse($connection, $query8);
                                            $resp8 = oci_execute($statement8);
                                            $treq = oci_fetch_array($statement8, OCI_BOTH);
                                            $query9 = ("SELECT ID_ESTADO_PROYECTO FROM PROYECTO WHERE ID_PROYECTO='$row[ID_PROYECTO]'");
                                            $statement9 = oci_parse($connection, $query9);
                                            $resp9 = oci_execute($statement9);
                                            $estadoProyecto = oci_fetch_array($statement9, OCI_BOTH);




                                            if ($row["ID_ESTADO_PROYECTO"] == 1) {
                                                echo "<td width=\"15%\"><font face=\"verdana\">" .
                                                $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . "</font></td>";
                                            } else {
                                                echo "<td width=\"15%\"><font face=\"verdana\">" .
                                                $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . '-P' . $row["ID_PROYECTO"] . "</font></td>";
                                            }

                                            if ($empresa[0] == null) {

                                                $e = "Demanda Social";
                                            } else {

                                                $e = $empresa[0];
                                            }

                                            echo "<td width=\"20%\"><font face=\"verdana\">" .
                                            $row["FECHA_ELABORACION"] . "</font></td>";
                                            echo "<td width=\"\"><font face=\"verdana\">" .
                                            $e . "</font></td>";
                                            echo "<td width=\"\"><a href=\"./reporte_candidatos_proyecto.php?proyecto=" . $row["ID_PROYECTO"] . "\" >
                                <img src='../images/excel.png' width='26' height='26'></a></td></tr>";

                                            $numero++;
                                        }



                                        oci_close($connection);
                                        ?>
                                    </table>
                                    </div>

                                    </div>
                                    </div>
                                    </div>
                                    <?php include ('layout/pie.php') ?>
                                    </body>
                                    </html>