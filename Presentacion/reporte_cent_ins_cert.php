<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
extract($_POST);
?>
<!DOCTYPE HTML>
<html>
    <!--            
Reporte en donde se consulta el numero de personas inscritas y certificadas de los 
proyetos pertenecientes a la regional asignada al usuario logueado, discriminada por centros.
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery.magnificpopup.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/magnificpopup.css" />
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

                $('#demotable').tableFilter(options1);

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
        <script type="text/javascript" language="JavaScript">
            function validar() {
                var form = document.f2;
                var total = 0;
                for (var i = 0; i < form.codigo.length; i++) {
                    //cuento la cantidad de input activos
                    if (form.codigo[i].checked) {
                        total = total + 1;
                    }
                }  //cierre for
                if (total == 12) {
                    for (i = 0; i < form.codigo.length; i++) {
                        //deshabilito el resto de checkbox
                        if (!form.codigo[i].checked) {
                            form.codigo[i].disabled = true;
                        }
                    }
                } else {
                    for (i = 0; i < form.codigo.length; i++) {
                        // habilito los checkbox cuando el total es menor que 3
                        form.codigo[i].disabled = false;
                    }
                }
                return false;
            } //cierre función

        </script>

    </head>
    <body onload="inicio()">
	<?php include ('layout/cabecera.php') ?>
        <div class="triple_space">&nbsp;</div>
        <div style="width:900px; margin: 0 auto;">
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

            //Consulta de una regional en especifico
            $query = "SELECT * FROM REGIONAL "
                    . "WHERE CODIGO_REGIONAL = $regional";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $rowRegional = oci_fetch_array($statement, OCI_BOTH);
            ?>

            <center>
                <strong>REPORTE DE PERSONAS INSCRITAS Y CERTIFICADAS POR CENTROS DE LA REGIONAL <?php echo utf8_encode($rowRegional['NOMBRE_REGIONAL']) ?></strong><br></br>
            </center>

            <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />

            <center>
                <br>
                <a href="reporte_cent_ins_cert_xls.php?regional=<?php echo $regional ?>" target="_new"><img src="../images/excel.png" width="26" height="26"><br>Generar Excel</a>
                <br><br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <br></br>
                <table id="demotable">
                    <thead>
                        <tr>
                            <th>Código de Centro</th>
                            <th>Nombre Centro</th>
                            <th>Numero Inscritos</th>
                            <th>Numero Certificados</th>
                            <th>Meta Certificados 2015</th>
                            <th>Proyectos Centro</th>
                        </tr>
                    </thead>
                    <?php
                    //Consulta de los centros asociados a una regional en especifico
                    $query = "SELECT CENTRO.NOMBRE_CENTRO, CENTRO.CODIGO_CENTRO, CENTRO.ID_CENTRO, "
                            . "REGIONAL.NOMBRE_REGIONAL FROM REGIONAL "
                            . "INNER JOIN CENTRO ON REGIONAL.CODIGO_REGIONAL = CENTRO.CODIGO_REGIONAL "
                            . "WHERE REGIONAL.CODIGO_REGIONAL = $regional ORDER BY REGIONAL.NOMBRE_REGIONAL ASC";
                    $statement = oci_parse($connection, $query);
                    $resp = oci_execute($statement);

                    while ($centros = oci_fetch_array($statement, OCI_BOTH)) {
                        /* Consulta para contar el numero de personas 
                          certificadas en los proyectos de un centro */
                       $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS FROM CE_FIRMA_CERTIFICADOS "
                                . "WHERE CENTRO_ID_CENTRO = $centros[CODIGO_CENTRO] || '00'");
                        $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                        oci_execute($statementCandidatosCertificados);
                        $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);
                        
                        $queryCandidatosCertificadosGC = ("SELECT NUMERO_CERTIFICACIONES FROM T_CERTIFICACIONES_2014 "
                                . "WHERE CODIGO_CENTRO = $centros[CODIGO_CENTRO]");
                        $statementCandidatosCertificadosGC = oci_parse($connection, $queryCandidatosCertificadosGC);
                        oci_execute($statementCandidatosCertificadosGC);
                        $candidatosCertificadosGC = oci_fetch_array($statementCandidatosCertificadosGC, OCI_BOTH);
                        
                        $candidatosCertificados = $certificados['CERTIFICADOS'] + $candidatosCertificadosGC['NUMERO_CERTIFICACIONES'];

                        /* Consulta para contar el numero de personas 
                          inscritas en los proyectos de un centro */
                        $queryCandidatosInscritos = "SELECT COUNT(*) AS INSCRITOS FROM PROYECTO PY "
                                . "INNER JOIN INSCRIPCION INS ON PY.ID_PROYECTO = INS.ID_PROYECTO "
                                . "WHERE PY.ID_CENTRO = $centros[CODIGO_CENTRO]";

                        $statementCandidatosInscritos = oci_parse($connection, $queryCandidatosInscritos);
                        oci_execute($statementCandidatosInscritos);
                        $candidatosInscritos = oci_fetch_array($statementCandidatosInscritos, OCI_BOTH);
                        
                        $queryMetaCentro = "SELECT META_CERTIFICADOS FROM INDICADORES "
                                . "WHERE CODIGO_CENTRO = $centros[CODIGO_CENTRO]";
                        $statementMetaCentro = oci_parse($connection, $queryMetaCentro);
                        oci_execute($statementMetaCentro);
                        $metaCentro = oci_fetch_array($statementMetaCentro, OCI_BOTH);
                        ?>
                        <tr>
                            <td><?php echo $centros['CODIGO_CENTRO'] ?></td>
                            <td><?php echo utf8_encode($centros['NOMBRE_CENTRO']) ?></td>
                            <td><?php echo $candidatosInscritos['INSCRITOS'] ?></td>
                            <td><?php echo $candidatosCertificados ?></td>
                            <td><?php echo $metaCentro['META_CERTIFICADOS'] ?></td>
                            <td>
                                <form action="reporte_candidatos_proyecto_a.php" method="POST" target="_new">
                                    <input type="hidden" id="centro" name="centro" value="<?php echo $centros['CODIGO_CENTRO'] ?>" />
                                    <input type="submit" value="Consultar">
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    oci_close($connection);
                    ?>
                </table>
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