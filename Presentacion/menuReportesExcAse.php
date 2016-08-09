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
    <head>
        <!--        <meta charset="utf-8"/>-->
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
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
                        <b>Reportes Semanales</b>
                    </legend>
                    <center>
                        <table>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Glosario</b><br/>
                                        <p>
                                            <b>Inscritos:</b> 
                                            Hace referencia a todo candidato al que se le ha formalizado la inscripción
                                        </p>
                                        <p>
                                            <b>Por evaluar:</b> 
                                            Hace referencia a todo candidato al que ya se le formalizo la inscripción y aun no ha sido evaluado (la diferencia entre inscritos y evaluados)
                                        </p>
                                        <p>
                                            <b>Evaluados:</b> 
                                            Hace referencia a todo candidato al que se le ha emitido juicio, sin importar si el juicio emitido fue competente o aun no competente
                                        </p>
                                        <p>
                                            <b>Por certificar:</b> 
                                            Hace referencia a todo candidato al que ya se le emitió juicio y aun no ha sido certificado (la diferencia entre evaluados y certificados)
                                        </p>
                                        <p>
                                            <b>Certificados:</b> 
                                            Hace referencia a todo candidato al que se le ha generado un certificado
                                        </p>
                                        <p>
                                            <b>Total:</b> 
                                            Hace referencia a al número de candidatos total, es decir, repitiendo el número de cédula
                                        </p>
                                        <p>
                                            <b>Personas:</b> 
                                            Hace referencia a al número de candidatos individual, es decir, sin repetir el número de cédula
                                        </p>
                                        <p>
                                            <b>Fechas de Corte:</b> 
                                            Hace referencia a las fechas que se usan para definir el periodo en el cual se sacaran los datos del reporte
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte Inscritos REG-CEN-MES-NOR</b><br/>
                                        <p>
                                            Este reporte contiene el número total de inscritos y el número de personas inscritas que hay en cada Regional, 
                                            Centro, Mesa y Norma. Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo 
                                            del 01/01/2016 hasta la fecha actual.
                                            <br/><br/><a href="reportes/indicadores/inscritos.php"><input type="button" value="Generar Reporte"/></a><br/>
                                        </p>
                                    </div>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte Evaluados REG-CEN-MES-NOR</b><br/>
                                        <p>
                                            Este reporte contiene el número total de evaluados y el número de personas evaluadas que hay en cada Regional, 
                                            Centro, Mesa y Norma. Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el 
                                            periodo del 01/01/2016 hasta la fecha actual.
                                            <br/><br/><a href="reportes/indicadores/evaluados.php"><input type="button" value="Generar Reporte"/></a><br/>
                                        </p>
                                    </div>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte Certificados REG-CEN-MES-NOR</b><br/>
                                        <p>
                                            Este reporte contiene el número total de certificados y el número de personas certificadas que hay en cada Regional,
                                            Centro, Mesa y Norma. Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo 
                                            del 01/01/2016 hasta la fecha actual.
                                            <br/><br/><a href="reportes/indicadores/certificados.php"><input type="button" value="Generar Reporte"/></a><br/>
                                        </p>
                                    </div>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN</b><br/>
                                        <p>
                                            Este reporte contiene el número total de inscritos, por evaluar, evaluados, por certificar y certificados que hay en
                                            cada Regional y Centro. Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo
                                            del 01/01/2016 hasta la fecha actual.
                                            <br/><br/><a href="reportes/indicadores/total.php"><input type="button" value="Generar Reporte"/></a><br/>
                                        </p>
                                    </div>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN</b><br/>
                                        <p>
                                            Este reporte contiene el  número de personas inscritas, por evaluar, evaluadas, por certificar y certificadas que hay
                                            en cada Regional y Centro. Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo
                                            del 01/01/2016 hasta la fecha actual.
                                            <br/><br/><a href="reportes/indicadores/personas.php"><input type="button" value="Generar Reporte"/></a>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="reportes/indicadores/totalCorte.php" method="post">
                                        <br/>
                                        <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                            <br/><b>Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN</b><br/>
                                            <p>
                                                Este reporte contiene el número total de inscritos, por evaluar, evaluados, por certificar y certificados que hay en
                                                cada Regional y Centro que se encuentren entre las fechas seleccionadas.
                                            </p>
                                            Fecha Inicial
                                            <input type="date" name="fInicial"/>
                                            Fecha Final
                                            <input type="date" name="fFinal"/>
                                            <input type="submit" value="Generar"/><br/><br/>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="reportes/indicadores/personasCorte.php" method="post">
                                        <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                            <br/><b>Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN</b><br/>
                                            <p>
                                                Este reporte contiene el número total de inscritos, por evaluar, evaluados, por certificar y certificados que hay en
                                                cada Regional y Centro que se encuentren entre las fechas seleccionadas.
                                            </p>
                                            Fecha Inicial
                                            <input type="date" name="fInicial"/>
                                            Fecha Final
                                            <input type="date" name="fFinal"/>
                                            <input type="submit" value="Generar"/><br/><br/>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </center>
                </fieldset>
                <br>
                <fieldset>
                    <legend>
                        <b>Reportes Disponibles para su Rol</b>
                    </legend><br>
                    <center>
                        <table>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Areas Claves Por Centro</b><br/>
                                        <p>
                                            Este reporte contiene el listado de las Áreas Claves (Mesas Sectoriales) que tiene asignadas cada Centro.
                                            Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <a href="centrosAreasExc.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Gestión De Los Centros</b><br/>
                                        <p>
                                            Este reporte contiene la información de las programaciones y proyectos creados por cada Centro.
                                            Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="reportes_centros.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Proyectos Nacionales Personas</b><br/>
                                        <p>
                                            Este reporte contiene la información de personas inscritas, personas en proceso, personas evaluadas, personas por certificar, personas certificadas en proyectos nacionales.
                                            Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="reportes/nacionales/personas.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Proyectos Nacionales Total</b><br/>
                                        <p>
                                            Este reporte contiene la información de candidatos inscritos, candidatos en proceso, evaluaciones realizadas, evaluados por certificar, certificaciones expedidas en proyectos nacionales.
                                            Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="reportes/nacionales/total.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte observaciones por asesores</b><br/>
                                        <p>
                                            Este reporte contiene las observaciones que los asesores realizan a los proyectos.Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="ExpObservacionesAsesores.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte aprobaciones</b><br/>
                                        <p>
                                            Este reporte señala proyectos aprobados, no aprobados y pedientes a aprobación.Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="ExpAprobaciones.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Indicadores 2016</b><br/>
                                        <p>
                                            Este reporte contiene los indicadores que maneja el grupo de certificación de competencias laborales ya que contiene la meta asignada para cada uno de los centros, donde se muestra por centro la cantidad de personas evaluadas, cantidad de personas certificadas, total certificaciones.Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="indicadores_excel_2015.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Agencia Publica de Empleo</b><br/>
                                        <p>
                                            Este reporte contiene las personas certificadas por Regional y Centro e indica la condición laboral de cada persona.Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="reportes/empleo/certificados.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </center>
                </fieldset>
                <br>
                <fieldset>
                    <legend><b>Reportes Disponibles para Control de auditorias</b></legend><br>
                    <center>
                        <table>
                            <tr>
                                <td>
                                    <div style="padding-left: 30px; padding-right: 30px; text-align: justify">
                                        <br/><b>Reporte Programación de Auditorias y Planes de acción de Mejora</b><br/>
                                        <p>
                                            Este reporte contiene la cantidad de candidatos registratos en los grupos de las normas que están en los proyectos, separados por centros y regionales.Las fechas de corte utilizadas para este reporte son predeterminadas y comprenden el periodo del 01/01/2016 hasta la fecha actual.
                                        </p>
                                        <br/><a href="reportAuditoria1.php"><input type="button" value="Generar Reporte"/></a><br/><br/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </center>
                </fieldset>
                <br>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>