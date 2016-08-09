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

            <div id="contenedor">

                <br>

                <?php
                $fecha = date('Y');

                $codiplan = $_GET["plan"];
                $tp = $_GET["tp"];
                $nit = $_GET["nit"];
                $prov = $_GET["provi"];

                $query1 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa =  '$nit'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $empresa = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT sigla_empresa FROM empresas_sistema where nit_empresa =  '$nit'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $sigla = oci_fetch_array($statement2, OCI_BOTH);

                $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement5 = oci_parse($connection, $query5);
                $resp5 = oci_execute($statement5);
                $idc = oci_fetch_array($statement5, OCI_BOTH);

                $query3 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $reg = oci_fetch_array($statement3, OCI_BOTH);

                $query4 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
                $statement4 = oci_parse($connection, $query4);
                $resp4 = oci_execute($statement4);
                $cen = oci_fetch_array($statement4, OCI_BOTH);

                $query6 = ("SELECT fecha_elaboracion FROM plan_anual where id_plan =  '$codiplan'");
                $statement6 = oci_parse($connection, $query6);
                $resp6 = oci_execute($statement6);
                $fe = oci_fetch_array($statement6, OCI_BOTH);

                $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $nomreg = oci_fetch_array($statement7, OCI_BOTH);

                $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $nomcen = oci_fetch_array($statement8, OCI_BOTH);
                ?>
                <br></br>
                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMATO DE PLAN ANUAL DE EVALUACIÓN Y CERTIFICACIÓN DE COMPETENCIAS LABORALES</strong><br></br>
                    <strong> Evaluación y Certificación de Competencias Laborales</strong>
                    <strong>Detalles</strong><br></br>


                    <table id="demotable1">

                        <tr><th><strong>Código Regional:</strong></th><td><?php echo "1" ?></td><th><strong>Nombre Regional:</strong></th><td><?php echo "DIRECCIÓN GENERAL" ?></td><th><strong>Fecha Elaboración:</strong></th><td><?php echo $fe[0] ?></td><th><strong>Número Radicado:</strong></th><td><?php echo $fecha . "-" . "1" . "-" . "17076" . "-" . $codiplan ?></td></tr>
                        <tr><th><strong>Código Centro:</strong></th><td><?php echo "17076" ?></td><th><strong>Nombre Centro:</strong></th><td><?php echo "GRUPO DE EVALUACIÓN Y CERTIFICACIÓN DE COMPETENCIAS LABORALES" ?></td><th><strong>Nombre Subdirector:</strong></th><td></td><th><strong>Nombre Responsable PECCL:</strong></th><td><?php echo $nom . " " . $ape ?></td></tr>

                    </table></center>
            </div>
            <br></br>
            <div id="">
<?php
if ($tp == 2 && $nit == "899999034") {
    ?>

                    <form name="f1" id="f1" onSubmit="return validarv();" method="post" 
                          action="guardardetalles_n.php?prov=<?php echo $prov ?>&tp=<?php echo $tp ?>" accept-charset="UTF-8">

                        <center><table id="demotable1">

                                <tr><th><strong>Nit Empresa</strong></th>
                                    <td><input type="text" size="15" value="<?php echo $nit ?>" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Nombre Empresa</strong></th>
                                    <td><input type="text" size="80" value="<?php echo $empresa[0] ?>" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Sigla Empresa</strong></th>
                                    <td><input type="text" size="15" value="<?php echo $sigla[0] ?>" name="" readonly ></input></td>
                                </tr>

                            </table></center>
                        <br>
                        <table border="1">
                            <tr><th colspan="40">DETALLES DE LA PROGRAMACIÓN</th></tr>
                            <tr>
                                <th rowspan="">ID</th>
                                <th rowspan="">IDN</th>
                                <th rowspan="">Código Mesa</th>
                                <th rowspan="">Mesa</th>
                                <th rowspan="">Código NCL</th>
                                <th rowspan="">Versión NCL</th>
                                <th rowspan="">Título NCL</th>
                                <th rowspan="">Elaborar Instrumentos</th>
                                <th rowspan="">Certificaciones por Funcionarios</th>
                                <th rowspan="">Personas por Funcionarios</th>
                                <th rowspan="">N° Evaluadores Requeridos</th>
                                <th rowspan="">Horas Requeridas</th>
                                <th rowspan="">Presupuesto Recurso Humano</th>
                                <th rowspan="">Presupuesto Materiales</th>
                                <th rowspan="">Presupuesto Viaticos</th>
                                <th rowspan="">Observaciones123</th>

                            </tr>
                            <tr>
    <?php
    $query20 = "SELECT * FROM DETALLES_POA WHERE ID_PLAN='$codiplan' and ID_PROVISIONAL='$prov'";
    $statement20 = oci_parse($connection, $query20);
    oci_execute($statement20);

    $numero = 0;
    while ($row20 = oci_fetch_array($statement20, OCI_BOTH)) {

        $query3 = ("SELECT CODIGO_NORMA,TITULO_NORMA,VERSION_NORMA FROM NORMA WHERE ID_NORMA='$row20[ID_NORMA]'");
        $statement3 = oci_parse($connection, $query3);
        oci_execute($statement3);

        while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {

            $codmesa = substr($row3["CODIGO_NORMA"], 1, 5);
            $query9 = ("SELECT nombre_mesa FROM mesa where codigo_mesa =  '$codmesa'");
            $statement9 = oci_parse($connection, $query9);
            $resp9 = oci_execute($statement9);
            $nommesa = oci_fetch_array($statement9, OCI_BOTH);


            echo "<td><input type=\"text\" readonly size=\"5\" name=\"deta[]\" value=\"$row20[ID_DETA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"idn[]\" value=\"$row20[ID_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"codmesa[]\" value=\"$codmesa\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"mesa[]\" value=\"$nommesa[0]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"norma[]\" value=\"$row3[CODIGO_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"2\" name=\"vrsnorma[]\" value=\"$row3[VERSION_NORMA]\"></input></td>";
            echo "<td width=\"10%\"><font face=\"verdana\"><center>" .
            utf8_encode($row3["TITULO_NORMA"]) . "</center></font></td>";
            echo "<td width=\"2%\"><select name=\"elab[]\">"
            . "<option value=\"1\">Si</option><option value=\"0\">No</option>"
            . "</select></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"cert_func[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"per_total_func[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"num_ev_req[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"hor_ev_total[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"pres_rec_hum[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"pres_mat[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"2\" value=\"0\" name=\"pres_viat[]\"></input></td>";
            echo "<td><input type=\"text\" size=\"5\" value=\"0\" name=\"obs[]\"></input></td></tr>";
        }

        $numero++;
    }
    ?>
                        </table>
                        </br>
                        <center>
                            <p><label>
                                    <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I"  />
                                </label></p>
                        </center>
                    </form>
    <?php
} else if ($tp == 1) {
    ?>

                    <form name="f1" id="f1" onSubmit="return validarv();" method="post" 
                          action="guardardetalles_n.php?prov=<?php echo $prov ?>&tp=<?php echo $tp ?>" accept-charset="UTF-8">

                        <center><table id="demotable1">

                                <tr><th><strong>Nit Empresa</strong></th>
                                    <td><input type="text" size="15" value="Demanda Social" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Nombre Empresa</strong></th>
                                    <td><input type="text" size="80" value="<?php echo $empresa[0] ?>" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Sigla Empresa</strong></th>
                                    <td><input type="text" size="15" value="<?php echo $sigla[0] ?>" name="" readonly ></input></td>
                                </tr>

                            </table></center>
                        <br>
                        <table>
                            <tr><th colspan="40">DETALLES DE LA PROGRAMACIÓN</th></tr>
                            <tr>
                                <th rowspan="">ID</th>
                                <th rowspan="">IDN</th>
                                <th rowspan="">Código Mesa</th>
                                <th rowspan="">Mesa</th>
                                <th rowspan="">Código NCL</th>
                                <th rowspan="">Versión NCL</th>
                                <th rowspan="">Título NCL</th>
                                <th rowspan="">Elaborar Instrumentos</th>
                                <th rowspan="">Certificaciones por Demanda Social</th>
                                <th rowspan="">Personas por Demanda Social</th>
                                <th rowspan="">N° Evaluadores Requeridos</th>
                                <th rowspan="">Horas Requeridas</th>
                                <th rowspan="">Presupuesto Recurso Humano</th>
                                <th rowspan="">Presupuesto Materiales</th>
                                <th rowspan="">Presupuesto Viaticos</th>
                                <th rowspan="">Observaciones</th>
                            </tr>
                            <tr>
    <?php
    $query20 = "SELECT * FROM DETALLES_POA WHERE ID_PLAN='$codiplan' and ID_PROVISIONAL='$prov'";
    $statement20 = oci_parse($connection, $query20);
    oci_execute($statement20);

    $numero = 0;
    while ($row20 = oci_fetch_array($statement20, OCI_BOTH)) {

        $query3 = ("SELECT CODIGO_NORMA,TITULO_NORMA,VERSION_NORMA FROM NORMA WHERE ID_NORMA='$row20[ID_NORMA]'");
        $statement3 = oci_parse($connection, $query3);
        oci_execute($statement3);

        while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {

            $codmesa = substr($row3["CODIGO_NORMA"], 1, 5);
            $query9 = ("SELECT nombre_mesa FROM mesa where codigo_mesa =  '$codmesa'");
            $statement9 = oci_parse($connection, $query9);
            $resp9 = oci_execute($statement9);
            $nommesa = oci_fetch_array($statement9, OCI_BOTH);

            echo "<td><input type=\"text\" readonly size=\"5\" name=\"deta[]\" value=\"$row20[ID_DETA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"idn[]\" value=\"$row20[ID_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"codmesa[]\" value=\"$codmesa\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"mesa[]\" value=\"$nommesa[0]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"norma[]\" value=\"$row3[CODIGO_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"2\" name=\"vrsnorma[]\" value=\"$row3[VERSION_NORMA]\"></input></td>";
            echo "<td width=\"10%\"><font face=\"verdana\"><center>" .
            utf8_encode($row3["TITULO_NORMA"]) . "</center></font></td>";
            echo "<td width=\"2%\"><select name=\"elab[]\">"
            . "<option value=\"1\">Si</option><option value=\"0\">No</option>"
            . "</select></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"cert_demsoc[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"per_total_demsoc[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"num_ev_req[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"hor_ev_total[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"pres_rec_hum[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"pres_mat[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"pres_viat[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"obs[]\"></input></td></tr>";
        }

        $numero++;
    }
    ?>
                        </table>
                        </br>
                        <center>
                            <p><label>
                                    <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I"  />
                                </label></p>
                        </center>


                    </form>
    <?php
} else if ($tp == 2) {
    ?>

                    <form name="f1" id="f1" onSubmit="return validarv();" method="post" 
                          action="guardardetalles_n.php?prov=<?php echo $prov ?>&tp=<?php echo $tp ?>" accept-charset="UTF-8">

                        <center><table id="demotable1">

                                <tr><th><strong>Nit Empresa</strong></th>
                                    <td><input type="text" size="15" value="<?php echo $nit ?>" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Nombre Empresa</strong></th>
                                    <td><input type="text" size="80" value="<?php echo $empresa[0] ?>" name="" readonly ></input></td>
                                </tr>
                                <tr><th><strong>Sigla Empresa</strong></th>
                                    <td><input type="text" size="15" value="<?php echo $sigla[0] ?>" name="" readonly ></input></td>
                                </tr>

                            </table></center>
                        <br>
                        <table border="1">
                            <tr><th colspan="32">DETALLES DE LA PROGRAMACIÓN</th></tr>
                            <tr>
                                <th rowspan="">ID</th>
                                <th rowspan="">IDN</th>
                                <th rowspan="">Código Mesa</th>
                                <th rowspan="">Mesa</th>
                                <th rowspan="">Código NCL</th>
                                <th rowspan="">Versión NCL</th>
                                <th rowspan="">Título NCL</th>
                                <th rowspan="">Elaborar Instrumentos</th>
                                <th rowspan="">Certificaciones por Alianza</th>
                                <th rowspan="">Personas por Alianza</th>
                                <th rowspan="">N° Evaluadores Requeridos</th>
                                <th rowspan="">Horas Requeridas</th>
                                <th rowspan="">Presupuesto Recurso Humano</th>
                                <th rowspan="">Presupuesto Materiales</th>
                                <th rowspan="">Presupuesto Viaticos</th>
                                <th rowspan="">Observaciones1234</th>

                            </tr>
                            <tr>
    <?php
    $query20 = "SELECT * FROM DETALLES_POA WHERE ID_PLAN='$codiplan' and ID_PROVISIONAL='$prov'";
    $statement20 = oci_parse($connection, $query20);
    oci_execute($statement20);

    $numero = 0;
    while ($row20 = oci_fetch_array($statement20, OCI_BOTH)) {

        $query3 = ("SELECT CODIGO_NORMA,TITULO_NORMA,VERSION_NORMA FROM NORMA WHERE ID_NORMA='$row20[ID_NORMA]'");
        $statement3 = oci_parse($connection, $query3);
        oci_execute($statement3);

        while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {

            $codmesa = substr($row3["CODIGO_NORMA"], 1, 5);
            $query9 = ("SELECT nombre_mesa FROM mesa where codigo_mesa =  '$codmesa'");
            $statement9 = oci_parse($connection, $query9);
            $resp9 = oci_execute($statement9);
            $nommesa = oci_fetch_array($statement9, OCI_BOTH);

            echo "<td><input type=\"text\" readonly size=\"5\" name=\"deta[]\" value=\"$row20[ID_DETA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"idn[]\" value=\"$row20[ID_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"5\" name=\"codmesa[]\" value=\"$codmesa\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"mesa[]\" value=\"$nommesa[0]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"9\" name=\"norma[]\" value=\"$row3[CODIGO_NORMA]\"></input></td>";
            echo "<td><input type=\"text\" readonly size=\"2\" name=\"vrsnorma[]\" value=\"$row3[VERSION_NORMA]\"></input></td>";
            echo "<td width=\"10%\"><font face=\"verdana\"><center>" .
            utf8_encode($row3["TITULO_NORMA"]) . "</center></font></td>";
            echo "<td width=\"2%\"><select name=\"elab[]\">"
            . "<option value=\"1\">Si</option><option value=\"0\">No</option>"
            . "</select></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"cert_alianza[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"per_total_alianza[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"num_ev_req[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"hor_ev_total[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"pres_rec_hum[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"pres_mat[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"2\" value=\"0\" name=\"pres_viat[]\"></input></td>";
            echo "<td><input type=\"text\"  size=\"5\" value=\"0\" name=\"obs[]\"></input></td></tr>";
        }

        $numero++;
    }
    ?>
                        </table>
                        </br>
                        <center>
                            <p><label>
                                    <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I"  />
                                </label></p>
                        </center>


                    </form>
                                <?php
                            }
                            ?>
            </div>

        </div>
<?php include ('layout/pie.php') ?>
    </body>
</html>