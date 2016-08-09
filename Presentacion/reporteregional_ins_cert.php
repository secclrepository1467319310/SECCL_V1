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
    <!--            
Reporte en donde se consulta el numero de personas inscritas y certificadas de los 
proyetos pertenecientes a la regional asignada al usuario logueado.
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
            ?>
            <center>
                <strong>REPORTE DE PERSONAS INSCRITAS Y CERTIFICADAS EN LA REGIONAL: </strong><br></br>
            </center>

            <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />
            <center>
                <table id="demotable">
                    <tr>
                        <th>Código Regional</th>
                        <th>Regional</th>
                        <th>Certificados</th>
                        <th>Inscritos</th>
                        <th></th>
                    </tr>
                    <?php
                    
                    //Consulta de la regional asignada al usuario
                    $queryRegionalUsuario = "SELECT CODIGO_REGIONAL FROM "
                            . "T_REGIONALES_USUARIOS WHERE ID_USUARIO = $id";
                    $statementRegionalUsuario = oci_parse($connection, $queryRegionalUsuario);
                    oci_execute($statementRegionalUsuario);
                    $regionalUsuario = oci_fetch_array($statementRegionalUsuario, OCI_BOTH);
                    
                    
                    //Consulta de una regional en especifico
                    $query = "SELECT NOMBRE_REGIONAL, CODIGO_REGIONAL 
                    FROM REGIONAL WHERE CODIGO_REGIONAL = $regionalUsuario[CODIGO_REGIONAL]";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);
                    while ($regional = oci_fetch_array($statement, OCI_BOTH)) {
                        
                        /* Consulta para contar el numero de personas 
                        certificadas en los proyectos de la regional */
                        $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS FROM CE_FIRMA_CERTIFICADOS "
                                . "WHERE CENTRO_REGIONAL_ID_REGIONAL = $regional[CODIGO_REGIONAL]");
                        $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                        oci_execute($statementCandidatosCertificados);
                        $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);
                        
                        $queryCandidatosCertificadosGC = ("SELECT SUM(CER.NUMERO_CERTIFICACIONES) AS NUMERO_CERTIFICACIONES FROM CENTRO CE"
                                . " INNER JOIN T_CERTIFICACIONES_2014 CER ON CE.CODIGO_CENTRO = CER.CODIGO_CENTRO "
                                . "WHERE CE.CODIGO_REGIONAL = $regional[CODIGO_REGIONAL]");
                        $statementCandidatosCertificadosGC = oci_parse($connection, $queryCandidatosCertificadosGC);
                        oci_execute($statementCandidatosCertificadosGC);
                        $candidatosCertificadosGC = oci_fetch_array($statementCandidatosCertificadosGC, OCI_BOTH);
                        $candidatosCertificados = $certificados['CERTIFICADOS'] + $candidatosCertificadosGC['NUMERO_CERTIFICACIONES'];

                        /* Consulta para contar el numero de personas 
                        inscritas en los proyectos de esa regional*/
                        $queryCandidatosInscritos = "SELECT COUNT(*) AS INSCRITOS FROM PROYECTO PY "
                                . "INNER JOIN INSCRIPCION INS ON PY.ID_PROYECTO = INS.ID_PROYECTO "
                                . "WHERE PY.ID_REGIONAL = $regional[CODIGO_REGIONAL]";
                        $statementCandidatosInscritos = oci_parse($connection, $queryCandidatosInscritos);
                        oci_execute($statementCandidatosInscritos);
                        $candidatosInscritos = oci_fetch_array($statementCandidatosInscritos, OCI_BOTH);
                        ?>
                        <tr>
                            <td><?php echo $regional['CODIGO_REGIONAL'] ?></td>
                            <td><?php echo utf8_encode($regional['NOMBRE_REGIONAL']) ?></td>
                            <td><?php echo $candidatosCertificados ?></td>
                            <td><?php echo $candidatosInscritos['INSCRITOS'] ?></td>
                            <td>
                                <form action="reporte_cent_ins_cert.php" method="POST">
                                    <input type="hidden" name="regional" value="<?php echo $regional['CODIGO_REGIONAL'] ?>" />
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