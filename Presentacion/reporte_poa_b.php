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
                    <form name="f1" accept-charset="UTF-8" method="post">

                        <a id="cleanfilters" href="#">Limpiar Filtros</a>   ||   <a class="exportacion"  href="Exppoa.php">Exportar a Excel<img src="../images/excel.png" width="26" height="26"></img></a>
                        <table id='demotable1'>

                            <thead>
                                <tr>
                                    <th>Id Plan</th>
                                    <th>Id Detalle</th>
                                    <th>Código Regional</th>
                                    <th>Regional</th>
                                    <th>Código Centro</th>
                                    <th>Centro</th>
                                    <th>Nit de Empresa - Convenio (Por Alianza)</th>
                                    <th>Empresa (Por Alianza)</th>
                                    <th>Código Mesa</th>
                                    <th>Nombre Mesa</th>
                                    <th>Código de la Norma</th>
                                    <th>Vrs Norma</th>
                                    <th>Nombre de la Norma</th>
                                    <th>Fecha Expiración</th>
                                    <th>Número de Certificaciones (Por Alianza)</th>
                                    <th>Número Total de Personas a Certificar (Por Alianza)</th>
                                    <th>Número de Certificaciones (Por Demanda Social)</th>
                                    <th>Número Total de Personas a Certificar (Por Demanda Social)</th>
                                    <th>Número de Certificaciones (Funcionarios)</th>
                                    <th>Número Total de Personas a Certificar (Funcionarios)</th>
                                    <th>Consolidado TOTAL de Personas a Certificar</th>
                                    <th>Consolidado TOTAL de Certificados</th>
                                    <th>Validación</th>
                                    <th>Concepto Asesor</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <?php
                            $query2 = "select 
p.id_plan,
p.id_deta,
(select id_regional from plan_anual where id_plan=p.id_plan) ID_REGIONAL,
(select NOMBRE_REGIONAL from REGIONAL where CODIGO_REGIONAL=(select id_regional from plan_anual where id_plan=p.id_plan)) NOMBRE_REGIONAL,
(select id_centro from plan_anual where id_plan=p.id_plan) ID_CENTRO,
(select NOMBRE_CENTRO from CENTRO where CODIGO_CENTRO=(select id_centro from plan_anual where id_plan=p.id_plan)) NOMBRE_CENTRO,
p.nit_empresa NIT_EMPRESA,
(select nombre_empresa from EMPRESAS_SISTEMA where nit_empresa=(select nit_empresa from detalles_poa where id_deta=p.id_deta)) EMPRESA,
n.codigo_mesa,
m.nombre_mesa,
n.id_norma ID_NORMA,
n.codigo_norma CODIGO_NORMA ,
n.version_norma VERS_NORMA ,
n.titulo_norma TITULO_NORMA,
to_char(n.expiracion_norma,'dd/mm/yyyy') EXPIRACION_NORMA,
p.al_num_certif CERTIFICADOS_ALIANZA,
p.al_num_personas PERSONAS_ALIANZA,
p.ds_num_certif CERTIFICADOS_DEMANDA,
p.ds_num_personas PERSONAS_DEMANDA,
p.fun_num_certif CERTIFICADOS_FUNCIONARIOS,
p.fun_num_personas PERSONAS_FUNCIONARIOS,
p.validacion VALIDADO,
p.concepto_asesor CONCEPTO
from norma n
inner join detalles_poa p on p.id_norma= n.id_norma
inner join plan_anual pa on p.id_plan= pa.id_plan
inner join mesa m on m.codigo_mesa=n.codigo_mesa";
//where p.validacion=3 or p.validacion=1";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            $num = 0;
                            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                                $totalpersonas = $row2["PERSONAS_ALIANZA"] + $row2["PERSONAS_ALIANZA"] + $row2["PERSONAS_FUNCIONARIOS"];
                                $totalcertificados = $row2["CERTIFICADOS_ALIANZA"] + $row2["CERTIFICADOS_DEMANDA"] + $row2["CERTIFICADOS_FUNCIONARIOS"];



                                echo "<tr><td>$row2[ID_PLAN]</td>";
                                echo "<td>$row2[ID_DETA]</td>";
                                echo "<td>$row2[ID_REGIONAL]</td>";
                                echo "<td>" . utf8_encode($row2[NOMBRE_REGIONAL]) . "</td>";
                                echo "<td>$row2[ID_CENTRO]</td>";
                                echo "<td>" . utf8_encode($row2[NOMBRE_CENTRO]) . "</td>";
                                if ($row2[NIT_EMPRESA] == NULL || $row2[NIT_EMPRESA] == 0) {
                                    $e = "Demanda Social";
                                    $ne = "Demanda Social";
                                } else {
                                    $e = $row2[NIT_EMPRESA];
                                    $ne = utf8_encode($row2[EMPRESA]);
                                }
                                if ($row2[CERTIFICADOS_ALIANZA] == NULL) {
                                    $a1 = "0";
                                } else {
                                    $a1 = $row2[CERTIFICADOS_ALIANZA];
                                }
                                if ($row2[PERSONAS_ALIANZA] == NULL) {
                                    $a2 = "0";
                                } else {
                                    $a2 = $row2[PERSONAS_ALIANZA];
                                }
                                if ($row2[CERTIFICADOS_DEMANDA] == NULL) {
                                    $a3 = "0";
                                } else {
                                    $a3 = $row2[CERTIFICADOS_DEMANDA];
                                }
                                if ($row2[PERSONAS_ALIANZA] == NULL) {
                                    $a4 = "0";
                                } else {
                                    $a4 = $row2[PERSONAS_ALIANZA];
                                }
                                if ($row2[CERTIFICADOS_FUNCIONARIOS] == NULL) {
                                    $a5 = "0";
                                } else {
                                    $a5 = $row2[CERTIFICADOS_FUNCIONARIOS];
                                }
                                if ($row2[PERSONAS_FUNCIONARIOS] == NULL) {
                                    $a6 = "0";
                                } else {
                                    $a6 = $row2[PERSONAS_FUNCIONARIOS];
                                }
                                echo "<td>$e</td>";
                                echo "<td>$ne</td>";
                                echo "<td>$row2[CODIGO_MESA]</td>";
                                echo "<td>$row2[NOMBRE_MESA]</td>";
                                echo "<td>$row2[CODIGO_NORMA]</td>";
                                echo "<td>$row2[VERS_NORMA]</td>";
                                echo "<td>" . utf8_encode($row2[TITULO_NORMA]) . "</td>";
                                echo "<td>$row2[EXPIRACION_NORMA]</td>";
                                echo "<td>$a1</td>";
                                echo "<td>$a2</td>";
                                echo "<td>$a3</td>";
                                echo "<td>$a4</td>";
                                echo "<td>$a5</td>";
                                echo "<td>$a6</td>";
                                echo "<td>$totalpersonas</td>";
                                echo "<td>$totalcertificados</td>";
                                if ($row2[VALIDADO] == 1) {
                                    $v = "Si";
                                } else if ($row2[VALIDADO] == 0) {
                                    $v = "No";
                                } else {
                                    $v = "Pendiente";
                                }
                                echo "<td>$v</td>";
                                echo "<td>$row2[CONCEPTO]</td></tr>";



                                $num++;
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