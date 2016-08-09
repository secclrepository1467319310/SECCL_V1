<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
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
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        

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
            <strong>SOLICITUD DE INSTRUMENTOS</strong><br></br>
            <strong> Evaluación y Certificación de Competencias Laborales</strong><br></br>

            <?php
            include("../Clase/conectar.php");
            include ("calendario/calendario.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $f = date('Y');

            $query4 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
            $statement4 = oci_parse($connection, $query4);
            $resp4 = oci_execute($statement4);
            $provisional = oci_fetch_array($statement4, OCI_BOTH);
            ?>
        </div>

        <div id="" >


            <form name="formmapa" 
                      action="guardar_obs_banco.php?provisional=<?php echo $provisional[0] ?>&proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >

                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <table id='demotable1'>

                    <thead>
                        <tr>
                            <th>ID</th>
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
                            <th>Concepto Asesor</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <?php
                    $connection2 = conectar($bd_host, $bd_usuario, $bd_pwd);
                    $query2 = "SELECT * FROM DETALLES_POA where ID_PROVISIONAL='$provisional[0]'";
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
                        echo "<tr><td><input type=\"radio\" name=\"norma\" value=\"$row2[ID_NORMA]\"></input></td></td>";
                        echo "<td>$cmesa[0]</td>";
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
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[CONCEPTO_ASESOR]</textarea></td></td>";


                        $num++;
                    }
                    oci_close($connection2);
                    ?>
                </table>
                <br></br>
                <center>
                    <table>
                        <tr>
                            <th>Solicitud</th>
                            <th>Fecha Solicitud</th>
                            <th>Respuesta (Código de Instrumento)</th>
                            <th>Fecha de Respuesta</th>
                            <th>Observacion Adicional</th>
                        </tr>
                        <tr>
                            <td><textarea cols="30" name="sol" rows="3"></textarea></td>
                        <td  class='BA'>
                                <?php
                                escribe_formulario_fecha_vacio("fi", "formmapa");
                                ?>
                            </td>
                            <td><textarea cols="30" name="resp" rows="3"></textarea></td>
                        <td  class='BA'>
                                <?php
                                escribe_formulario_fecha_vacio("ff", "formmapa");
                                ?>
                            </td>
                        <td><textarea cols="30" name="obs" rows="3"></textarea></td>
                        </tr>
                    </table>
                    <br>
                     <p><label>
                    <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                    </label></p>
                </center>
            </form>
            <br></br>
            <div class="space">&nbsp;</div>
        <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
        <br></br>
        
        <table>
            <tr>
                <th>Norma</th>
                <th>Solicitud</th>
                <th>Fecha Solicitud</th>
                <th>Respuesta</th>
                <th>Fecha Respuesta</th>
                <th>Observaciones</th>
                <th>Usuario Registro</th>
            </tr>
            <?php
            $connection3 = conectar($bd_host, $bd_usuario, $bd_pwd);
            $query23 = "select * from obs_banco where id_proyecto='$proyecto'";
                    $statement23 = oci_parse($connection3, $query23);
                    oci_execute($statement23);
                    $nume = 0;
                    while ($row23 = oci_fetch_array($statement23, OCI_BOTH)) {

                        $query42 = ("SELECT codigo_norma FROM norma where ID_NORMA =  '$row23[ID_NORMA]'");
                        $statement42 = oci_parse($connection3, $query42);
                        $resp42 = oci_execute($statement42);
                        $norma = oci_fetch_array($statement42, OCI_BOTH);

                        $query52 = ("SELECT nombre FROM usuario where usuario_id = '$row23[USU_REGISTRO]'");
                        $statement52 = oci_parse($connection3, $query52);
                        $resp52 = oci_execute($statement52);
                        $usu = oci_fetch_array($statement52, OCI_BOTH);

                        echo "<tr><td>$norma[0]</td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row23[SOLICITUD]</textarea></td></td>";
                        echo "<td>$row23[FECHA_SOLICITUD]</td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row23[RESPUESTA]</textarea></td></td>";
                        echo "<td>$row23[FECHA_RESPUESTA]</td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row23[OBS]</textarea></td></td>";
                        echo "<td>$usu[0]</td></tr>";



                        $nume++;
                    }
                    oci_close($connection3);
                    ?>
            
            
        </table>
        </div>
    </body>
</html>
