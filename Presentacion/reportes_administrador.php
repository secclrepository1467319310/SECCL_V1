<?php
session_start();

if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
    echo '<script>window.location = "../index.php"</script>';
}
?>
<!DOCTYPE HTML>
<html>
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
        <style type="text/css">
            .textCenter{
                text-align: center;
            }
            .container {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }
            .divCol1 {
                width: 50%;
            }
            .border{
                border: #DDD 1px;
            }
        </style>
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
                <fieldset>
                    <legend>
                        <b>
                            Reportes Semanales
                        </b>
                    </legend>
                    <center>
                        <table >
                            <tr>
                                <td rowspan="3" class="textCenter">
                                    <div>
                                        <a href="reportes/indicadores/inscritos.php">Reporte Inscritos REG-CEN-MES-NOR</a><br/>
                                    </div>
                                    <div>
                                        <br/><a href="reportes/indicadores/evaluados.php">Reporte Evaluados REG-CEN-MES-NOR</a><br/>
                                    </div>
                                    <div>
                                        <br/><a href="reportes/indicadores/certificados.php">Reporte Certificados REG-CEN-MES-NOR</a><br/>
                                    </div>
                                    <div>
                                        <br/><a href="reportes/indicadores/total.php">Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN</a><br/>
                                    </div>
                                    <div>
                                        <br/><a href="reportes/indicadores/personas.php">Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN</a><br/>
                                    </div>
                                </td>
                                <td class="textCenter">
                                    <form action="reportes/indicadores/totalCorte.php" method="post">
                                        <div colspan="2">
                                            Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN
                                        </div>
                                        <div class="container">
                                            <div class="divCol1">
                                                Fecha Inicial
                                            </div>
                                            <div class="divCol1">
                                                Fecha Final
                                            </div>
                                            <div class="divCol1">
                                                <input min="2016-01-01" type="date" name="fInicial"/>
                                            </div>
                                            <div class="divCol1">
                                                <input type="date" name="fFinal"/>
                                            </div>
                                        </div>
                                        <div colspan="2">
                                            <input type="submit" value="Generar"/>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="textCenter">
                                    <form action="reportes/indicadores/personasCorte.php" method="post">
                                        <div colspan="2">
                                            Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN
                                        </div>
                                        <div class="container">
                                            <div class="divCol1">
                                                Fecha Inicial
                                            </div>
                                            <div class="divCol1">
                                                Fecha Final
                                            </div>
                                            <div class="divCol1">
                                                <input  min="2016-01-01" type="date" name="fInicial"/>
                                            </div>
                                            <div class="divCol1">
                                                <input type="date" name="fFinal"/>
                                            </div>
                                        </div>
                                        <div colspan="2">
                                            <input type="submit" value="Generar"/>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </center>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Areas Claves</b></legend>
                    <a href="centrosAreasExc.php">Areas Claves Por Centro</a>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Centros 2016</b></legend>
                    <a href="reportes_centros.php">Gestión de los centros</a><br/><br/>
                    <a href="indicadores_excel_2015.php">Indicadores 2016</a></br></br>
                    <a href="IndicadoresConCorte.php">Indicadores con corte</a>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Proyectos Nacionales 2016</b></legend>
                    <a href="consult_proyectos_nacionales.php">Proyectos Nacionales</a></br></br>
                    <a href="reportes_proyectos_nacionales.php">Proyectos Nacionales Gestión</a>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Mesas 2016</b></legend>
                    <a href="reporte_mesa.php">Mesa 2016</a></br></br>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Historicos hasta la fecha actual</b></legend>
                    <a href="reporte_mesa_his.php">Mesa Historico</a></br></br>
                    <a href="reporte_top_norma_his.php">Top normas Historico por mesa</a>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Disponibles para Control de auditorias</b></legend><br>
                    <a href="reportAuditoria1.php">Reporte Programación de Auditorias y Planes de acción de Mejora</a> <br/><br/>
                </fieldset>
                <fieldset>
                    <legend><b>Reportes asesores</b></legend>
                    <a href="ExpObservacionesAsesores.php">Reporte observaciones por asesores</a></br></br>
                    <a href="ExpAprobaciones.php">Reporte aprobaciones</a>
                </fieldset>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>