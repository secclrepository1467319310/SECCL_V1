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
extract($_GET);
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
                <?php
                $queryPlan = "SELECT PY.ID_PROYECTO, MS.CODIGO_MESA, MS.NOMBRE_MESA, NM.ID_NORMA, NM.CODIGO_NORMA, NM.TITULO_NORMA, PE.GRUPO, PY.NIT_EMPRESA, ES.NOMBRE_EMPRESA "
                        . "FROM PLAN_EVIDENCIAS PE "
                        . "INNER JOIN NORMA NM ON PE.ID_NORMA = NM.ID_NORMA "
                        . "INNER JOIN MESA MS ON NM.CODIGO_MESA = MS.CODIGO_MESA "
                        . "INNER JOIN PROYECTO PY ON PE.ID_PROYECTO = PY.ID_PROYECTO "
                        . "LEFT JOIN EMPRESAS_SISTEMA ES "
                        . "ON PY.NIT_EMPRESA = ES.NIT_EMPRESA "
                        . "WHERE PE.ID_PLAN = $id_plan";
                $statementPlan = oci_parse($connection, $queryPlan);
                oci_execute($statementPlan);
                $plan = oci_fetch_array($statementPlan, OCI_BOTH);

                $queryCandidatos = "SELECT COUNT(*) AS CANTIDAD "
                        . "FROM PROYECTO_GRUPO PG "
                        . "WHERE PG.ID_NORMA = $plan[ID_NORMA] AND N_GRUPO = $plan[GRUPO] AND ID_PROYECTO= $plan[ID_PROYECTO]";
                $statementCandidatos = oci_parse($connection, $queryCandidatos);
                oci_execute($statementCandidatos);
                $planCandidatos = oci_fetch_array($statementCandidatos, OCI_BOTH);


                $queryInforme = "SELECT * FROM T_INFORME_CUALITATIVO_PROYECTO "
                        . "WHERE ID_PLAN_EVIDENCIAS = $id_plan ";
                $statementInforme = oci_parse($connection, $queryInforme);
                oci_execute($statementInforme);
                $informe = oci_fetch_array($statementInforme, OCI_BOTH)
                ?>
                <center>
                    <strong style="font-size: 20px">INFORME CUALITATIVO DE PROYECTO </strong>
                    <div class="proyecto">
                        <input id="plan" name="plan" type="hidden" value="<?php echo $id_plan ?>" />
                        <fieldset style="text-align: left">
                            <br>
                            <legend><strong>Información General Proyecto</strong></legend>
                            <b> ID PROYECTO: </b> <?php echo $plan['ID_PROYECTO'] ?><br>
                            <?php if ($plan['NIT_EMPRESA'] == NULL) { ?>
                                <b> LINEA DE ATENCIÓN: </b> DEMANDA SOCIAL <br>
                            <?php } else { ?>
                                <b> LINEA DE ATENCIÓN: </b> ALIANZA - <?php echo $plan['NOMBRE_EMPRESA'] ?><br>
                            <?php } ?>
                            <b> CODIGO MESA: </b> <?php echo $plan['CODIGO_MESA'] ?><br>
                            <b> NOMBRE MESA: </b><?php echo utf8_encode($plan['NOMBRE_MESA']) ?><br>
                            <b> CODIGO NORMA: </b> <?php echo $plan['CODIGO_NORMA'] ?><br>
                            <b> NOMBRE NORMA: </b> <?php echo utf8_encode($plan['TITULO_NORMA']) ?><br>
                            <b> GRUPO: </b><?php echo $plan['GRUPO'] ?><br>
                            <b> CANTIDAD CANDIDATOS: </b><?php echo utf8_encode($planCandidatos['CANTIDAD']) ?>
                            <br>

                        </fieldset><br><br>

                        <fieldset style="text-align: left">
                            <legend><strong>Evidencias de conocimiento</strong></legend>
                            <br><br>
                            Fortalezas Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad1" style="color: red;"></label>
                                <textarea name="fort_conocimiento" id="fort_conocimiento" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['FORTALEZAS_CONOCIMIENTO'] ?></textarea>
                            </div>
                            <br><br>
                            Debilidades Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="deb_conocimiento" id="deb_conocimiento" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['DEBILIDADES_CONOCIMIENTO'] ?></textarea>
                            </div>
                        </fieldset><br><br>

                        <fieldset style="text-align: left">
                            <legend><strong>Evidencias de Desempeño</strong></legend>
                            <br><br>
                            Fortalezas Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="fort_desempeno" id="fort_desempeno" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['FORTALEZAS_DESEMPENO'] ?></textarea>
                            </div>
                            <br><br>
                            Debilidades Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="deb_desempeno" id="deb_desempeno" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['DEBILIDADES_DESEMPENO'] ?></textarea>
                            </div>
                        </fieldset><br><br>

                        <fieldset style="text-align: left">
                            <legend><strong>Evidencias de producto</strong></legend>
                            <br><br>
                            Fortalezas Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="fort_producto" id="fort_producto" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['FORTALEZAS_PRODUCTO'] ?></textarea>
                            </div>
                            <br><br>
                            Debilidades Comunes
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="deb_producto" id="deb_producto" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['DEBILIDADES_PRODUCTO'] ?></textarea>
                            </div>
                        </fieldset><br><br>

                        <fieldset style="text-align: left">
                            <legend><strong>Oportunidades de mejora</strong></legend>
                            <br><br>
                            Oportunidades de mejora para el sector productivo
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="opor_mejor_produc" id="opor_mejor_produc" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['OPORT_MEJORA_PRODUCTIVO'] ?></textarea>
                            </div>
                        </fieldset><br><br>

                        <fieldset style="text-align: left">
                            <legend><strong>Aspectos a resaltar.</strong></legend>
                            <br><br>
                            Aspectos a resaltar para el sector productivo
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="asp_resal_produc" id="asp_resal_produc" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['ASPECT_MEJORA_PROC'] ?></textarea>
                            </div>
                        </fieldset><br><br>
                        <fieldset style="text-align: left" id="contenedorHistoria">
                            <legend><strong>Historia de vida</strong></legend>
                            <br><br>
                            Historia de vida de candidato a resaltar
                            <br>
                            <div class="textoValidar">
                                <label class="cantidad" id="cantidad2" style="color: red;"></label>
                                <textarea name="historia_vida" id="historia_vida" style="width:800px; height: 100px" readonly="readonly"><?php echo $informe['HISTORIA_VIDA'] ?></textarea>
                            </div>
                        </fieldset>
                        <br>
                    </div>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>