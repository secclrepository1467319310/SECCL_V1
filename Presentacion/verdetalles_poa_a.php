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
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

    <!--        CREDITOS  CREDITS
    Plantilla modificada por: Jhonatan Andres Garnica Paredes
    Requerimiento: Adaptación imagen corporativa.
    Direccion de Sistema - SENA, Dirección General
    última actualización Octubre /2012
    !-->

    <head>
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="./images/iconos/favicon.ico" />
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


    </head>
    <body>
        <div id="">
            <br></br>
            <img src="../images/logos/sena.jpg" align="left" ></img>
            <strong>FORMATO DE PROGRAMACIÓN ANUAL DE EVALUACIÓN Y CERTIFICACIÓN DE COMPETENCIAS LABORALES</strong><br></br>
            <strong> Evaluación y Certificación de Competencias Laborales</strong>
            <strong>Detalles</strong><br></br>

            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $codiplan = $_GET['plan'];
            $f = date('Y');
            $query = "SELECT * from PLAN_ANUAL where ID_PLAN='$codiplan'";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $numero = 0;
            while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                $codiplan2 = $f . "-" . $row["ID_REGIONAL"] . "-" . $row["ID_CENTRO"] . "-" . $row["ID_PLAN"];

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


                <table >

                    <thead><tr><th><strong>Código Regional:</strong></th><td><?php echo $reg[0]; ?></td><th><strong>Nombre Regional:</strong></th><td><?php echo utf8_encode($nomreg[0]) ?></td><th><strong>Fecha Elaboración:</strong></th><td><?php echo $fe[0] ?></td><th><strong>Número Radicado:</strong></th><td><?php echo $codiplan2 ?></td></tr></thead>
                    <thead><tr><th><strong>Código Centro:</strong></th><td><?php echo $cen[0]; ?></td><th><strong>Nombre Centro:</strong></th><td><?php echo utf8_encode($nomcen[0]) ?></td><th><strong>Nombre Subdirector:</strong></th><td></td><th><strong>Nombre Responsable PECCL:</strong></th><td><?php echo utf8_encode($nom) . " " . utf8_encode($ape) ?></td></tr></thead>

                </table></center>

                <?php
                $numero++;
            }
            oci_close($connection);
            ?>

            <br></br><br></br>

        </div>

        <div id="" >
            <center>
                <strong>Señor Líder, con el fin de facilitar la consulta por
                    los diferentes campos que se detallan en el PAECCL, encuentra 
                    en la parte inferior de cada uno de ellos una casilla en 
                    blanco en la cual usted podrá realizar consulta personalizada
                    dependiendo de la necesidad.</strong></center><br></br>
            <center><strong><label style="color: coral">IMPORTANTE:</label></strong> Campo  "CODIGO DE LA NORMA" en la casilla 
                en blanco debe digitar el código de la NCL o parte del mismo,
                así el aplicativo va reduciendo la búsqueda. De igual forma 
                podrá sintetizar la búsqueda por más de un campo simultáneamente.</center><br></br>
            <center><strong><label style="color: coral">IMPORTANTE:</label></strong> Después de haber utilizado el filtro, 
                dar click en “Limpiar Filtros” para evitar que en una nueva 
                consulta se mantenga la informacion filtrada anteriormente.</center><br></br>


            <br></br><br></br>




            <form name="f1" accept-charset="UTF-8" method="post">

                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <table id='demotable1'>

                    <thead>
                        <tr>
                            <th>Código Mesa Sectorial</th>
                            <th>Nombre Mesa Sectorial</th>
                            <th>Código de la Norma</th>
                            <th>Nombre de la Norma</th>
                            <th>Requiere Elaborar Instrumentos</th>
                            <th>Nit de Empresa - Convenio (Por Alianza)</th>
                            <th>Empresa (Por Alianza)</th>
                            <th>Número de Certificaciones (Por Alianza)</th>
                            <th>Número Total de Personas a Certificar (Por Alianza)</th>
                            <th>Número de Certificaciones (Por Demanda Social)</th>
                            <th>Número Total de Personas a Certificar (Por Demanda Social)</th>
                            <th>Número de Certificaciones (Funcionarios)</th>
                            <th>Número Total de Personas a Certificar (Funcionarios)</th>
                            <th>Consolidado TOTAL de Personas a Certificar</th>
                            <th>Consolidado TOTAL de Certificados</th>
                            <th>Número de Evaluadores Requeridos</th>
                            <th>Horas Totales de Evaluadores Requeridas para Emitir los Juicios de las Personas Evaluadas</th>
                            <th>Presupuesto Recursos Humanos</th>
                            <th>Presupuesto Materiales</th>
                            <th>Presupuesto Viáticos</th>
                            <th>Observaciones</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <?php
                    $connection2 = conectar($bd_host, $bd_usuario, $bd_pwd);
                    $query2 = "SELECT * FROM DETALLES_POA where ID_PLAN='$codiplan'";
                    $statement2 = oci_parse($connection2, $query2);
                    oci_execute($statement2);
                    $num = 0;
                    while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                        $query1 = ("SELECT CODIGO_MESA FROM NORMA where ID_NORMA =  '$row2[ID_NORMA]' ");
                        $statement1 = oci_parse($connection2, $query1);
                        $resp1 = oci_execute($statement1);
                        $cmesa = oci_fetch_array($statement1, OCI_BOTH);

                        $query7 = ("SELECT NOMBRE_MESA FROM MESA WHERE CODIGO_MESA =  '$cmesa[0]'");
                        $statement7 = oci_parse($connection2, $query7);
                        $resp7 = oci_execute($statement7);
                        $nom_mesa = oci_fetch_array($statement7, OCI_BOTH);
                        $mesa = utf8_encode($nom_mesa[0]);

                        $query3 = ("SELECT titulo_norma FROM norma where ID_NORMA =  '$row2[ID_NORMA]'");
                        $statement3 = oci_parse($connection2, $query3);
                        $resp3 = oci_execute($statement3);
                        $titulo_norma = oci_fetch_array($statement3, OCI_BOTH);
                        $t = utf8_encode($titulo_norma[0]);

                        $query4 = ("SELECT codigo_norma FROM norma where ID_NORMA =  '$row2[ID_NORMA]'");
                        $statement4 = oci_parse($connection2, $query4);
                        $resp4 = oci_execute($statement4);
                        $c_norma = oci_fetch_array($statement4, OCI_BOTH);

                        $query5 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa = '$row2[NIT_EMPRESA]'");
                        $statement5 = oci_parse($connection2, $query5);
                        $resp5 = oci_execute($statement5);
                        $empresa = oci_fetch_array($statement5, OCI_BOTH);
                        
                        $query6 = ("SELECT count (*) FROM proyecto where id_provisional = '$row2[ID_PROVISIONAL]'");
                        $statement6 = oci_parse($connection2, $query6);
                        $resp6 = oci_execute($statement6);
                        $pro = oci_fetch_array($statement6, OCI_BOTH);



                        $totalpersonas = $row2["AL_NUM_PERSONAS"] + $row2["DS_NUM_PERSONAS"] + $row2["FUN_NUM_PERSONAS"];
                        $totalcertificados = $row2["AL_NUM_CERTIF"] + $row2["DS_NUM_CERTIF"] + $row2["FUN_NUM_CERTIF"];



                        if ($empresa[0] == null) {

                            $e = "Demanda Social";
                        } else {

                            $e = $empresa[0];
                        }
                        echo "<tr><td>$cmesa[0]</td>";
                        echo "<td>$mesa</td>";
                        echo "<td>$c_norma[0]</td>";
                        echo "<td>$t</td>";

                        if ($row2["ELAB_INST"] == 0) {
                            $ei = "No";
                        } else {
                            $ei = "Si";
                        }
                        echo "<td>$ei</td>";
                        if ($row2[NIT_EMPRESA] == null) {
                            $row2[NIT_EMPRESA] = 0;
                            echo "<td>$row2[NIT_EMPRESA]</td>";
                        } else {
                            echo "<td>$row2[NIT_EMPRESA]</td>";
                        }
                        echo "<td>$e</td>";
                        if ($row2[AL_NUM_CERTIF] == null) {
                            $row2[AL_NUM_CERTIF] = 0;
                            echo "<td>$row2[AL_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[AL_NUM_CERTIF]</td>";
                        }
                        if ($row2[AL_NUM_PERSONAS] == null) {
                            $row2[AL_NUM_PERSONAS] = 0;
                            echo "<td>$row2[AL_NUM_PERSONAS]</td>";
                        } else {
                            echo "<td>$row2[AL_NUM_PERSONAS]</td>";
                        }
                        if ($row2[DS_NUM_CERTIF] == null) {
                            $row2[DS_NUM_CERTIF] = 0;
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        }
                        if ($row2[DS_NUM_PERSONAS] == null) {
                            $row2[DS_NUM_PERSONAS] = 0;
                            echo "<td>$row2[DS_NUM_PERSONAS]</td>";
                        } else {
                            echo "<td>$row2[DS_NUM_PERSONAS]</td>";
                        }
                        if ($row2[FUN_NUM_CERTIF] == null) {
                            $row2[FUN_NUM_CERTIF] = 0;
                            echo "<td>$row2[FUN_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[FUN_NUM_CERTIF]</td>";
                        }
                        if ($row2[FUN_NUM_PERSONAS] == null) {
                            $row2[FUN_NUM_PERSONAS] = 0;
                            echo "<td>$row2[FUN_NUM_PERSONAS]</td>";
                        } else {
                            echo "<td>$row2[FUN_NUM_PERSONAS]</td>";
                        }
                        echo "<td>$totalpersonas</td>";
                        echo "<td>$totalcertificados</td>";
                        echo "<td>$row2[EV_NUM_REQUERIDO]</td>";
                        echo "<td>$row2[EV_HORAS_TOTALES]</td>";
                        echo "<td>$ $row2[PRES_REC_HUMANOS]</td>";
                        echo "<td>$ $row2[PRES_MATERIALES]</td>";
                        echo "<td>$ $row2[PRES_VIATICOS]</td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[OBSERVACIONES]</textarea></td></td>";
                        

                        $num++;
                    }
                    oci_close($connection2);
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>
