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
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
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
 function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8,37,39];
 //46 el punto
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}

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

                $query15 = ("SELECT usu_registro FROM plan_anual where id_plan =  '$codiplan'");
                $statement15 = oci_parse($connection, $query15);
                $resp15 = oci_execute($statement15);
                $id = oci_fetch_array($statement15, OCI_BOTH);
                
                $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id[0]'");
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
                
                $query19 = ("select nombre from directorio where codigo_centro='$cen[0]' and t_usuario=3");
                $statement19 = oci_parse($connection, $query19);
                $resp19 = oci_execute($statement19);
                $subdirector = oci_fetch_array($statement19, OCI_BOTH);
                
                ?>


                <table >

                    <thead><tr><th><strong>Código Regional:</strong></th><td><?php echo $reg[0]; ?></td><th><strong>Nombre Regional:</strong></th><td><?php echo utf8_encode($nomreg[0]) ?></td><th><strong>Fecha Elaboración:</strong></th><td><?php echo $fe[0] ?></td><th><strong>Número Radicado:</strong></th><td><?php echo $codiplan2 ?></td></tr></thead>
                    <thead><tr><th><strong>Código Centro:</strong></th><td><?php echo $cen[0]; ?></td><th><strong>Nombre Centro:</strong></th><td><?php echo utf8_encode($nomcen[0]) ?></td><th><strong>Nombre Subdirector:</strong></th><td><?php echo utf8_encode($subdirector[0]) ?></td><th><strong>Nombre Responsable PECCL:</strong></th><td></td></tr></thead>

                </table></center>

                <?php
                $numero++;
            }
            
            ?>

            <br></br>
            <?php
            
                $query9 = ("SELECT concepto_asesor FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement9 = oci_parse($connection, $query9);
                $resp9 = oci_execute($statement9);
                $concepto = oci_fetch_array($statement9, OCI_BOTH);
                
                $query10 = ("SELECT NUM_CERTIF_META FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement10 = oci_parse($connection, $query10);
                $resp10 = oci_execute($statement10);
                $num_certif_meta = oci_fetch_array($statement10, OCI_BOTH);
                
                $query11 = ("SELECT NUM_PERSONAS_CERTIFICADAS FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement11 = oci_parse($connection, $query11);
                $resp11 = oci_execute($statement11);
                $num_personas_certificadas = oci_fetch_array($statement11, OCI_BOTH);
                
                $query12 = ("SELECT PRES_CONTRATACION FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement12 = oci_parse($connection, $query12);
                $resp12 = oci_execute($statement12);
                $pres_contratacion = oci_fetch_array($statement12, OCI_BOTH);
                
                $query13 = ("SELECT PRES_GASTOS FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement13 = oci_parse($connection, $query13);
                $resp13 = oci_execute($statement13);
                $pres_gastos = oci_fetch_array($statement13, OCI_BOTH);
                
                $query14 = ("SELECT PRES_FAL_CONTRATACION FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement14 = oci_parse($connection, $query14);
                $resp14 = oci_execute($statement14);
                $pres_fal_contratacion = oci_fetch_array($statement14, OCI_BOTH);
                
                $query15 = ("SELECT PRES_FAL_GASTOS FROM PLAN_ANUAL where ID_PLAN =  '$codiplan'");
                $statement15 = oci_parse($connection, $query15);
                $resp15 = oci_execute($statement15);
                $pres_fal_gastos = oci_fetch_array($statement15, OCI_BOTH);
                
                $query16 = ("select sum(al_num_certif) from detalles_poa where id_plan='$codiplan' and validacion <>0");
                $statement16 = oci_parse($connection, $query16);
                $resp16 = oci_execute($statement16);
                $al_num_certif = oci_fetch_array($statement16, OCI_BOTH);
                
                $query17 = ("select sum(ds_num_certif) from detalles_poa where id_plan='$codiplan' and validacion <>0");
                $statement17 = oci_parse($connection, $query17);
                $resp17 = oci_execute($statement17);
                $ds_num_certif = oci_fetch_array($statement17, OCI_BOTH);
                
                $query18 = ("select sum(fun_num_certif) from detalles_poa where id_plan='$codiplan' and validacion <>0");
                $statement18 = oci_parse($connection, $query18);
                $resp18 = oci_execute($statement18);
                $fun_num_certif = oci_fetch_array($statement15, OCI_BOTH);
                
                $totalpres=$pres_contratacion[0]+$pres_gastos[0];
                $totalfal=$pres_fal_contratacion[0]+$pres_fal_gastos[0];
                $totalvalidada=$al_num_certif[0]+$ds_num_certif[0]+$fun_num_certif[0];
            
            ?>
            <center>
                <form name="frmconcepto" accept-charset="UTF-8" method="post" action="guardar_concepto_general.php?plan=<?php echo $codiplan ?>">
            <table>
                <tr><th colspan="10" >Metas y Presupuesto</th></tr>
                <tr>
                    <th width="5%">N° de Certificaciones Meta 2015</th>
                    <th width="5%">N° de Personas Certificadas Meta 2015</th>
                    <th width="5%">Validadas 2015</th>
                    <th width="5%">Presupuesto Asignado por Contratación Directa</th>
                    <th width="5%">Presupuesto Asignado por Gastos de Viaje</th>
                    <th width="5%">Presupuesto Asignado TOTAL</th>
                    <th width="5%">Presupuesto Faltante por Contratación directa para cumplir la PAECCL VALIDADA</th>
                    <th width="5%">Presupuesto Faltante por Gastos de viaje para cumplir la PAECCL VALIDADA</th>
                    <th width="5%">PRESUPUESTO FALTANTE TOTAL</th>
                    <th width="5%">Concepto Asesor</th>
                </tr>
                <tr>
                    <td><input type="text" size="3" onkeypress="return numeros(event)" name="num_certif_meta" value="<?php echo $num_certif_meta[0] ?>"></input></td>
                    <td><input type="text" size="3" onkeypress="return numeros(event)" name="num_personas_certificadas" value="<?php echo $num_personas_certificadas[0] ?>"></input></td>
                    <td><?php echo "$ ".$totalvalidada ?></td>
                    <td><input type="text" size="7" onkeypress="return numeros(event)" name="pres_contratacion" value="<?php echo $pres_contratacion[0] ?>"></input></td>
                    <td><input type="text" size="7" onkeypress="return numeros(event)" name="pres_gastos" value="<?php echo $pres_gastos[0] ?>"></input></td>
                    <td><?php echo "$ ".$totalpres ?></td>
                    <td><input type="text" size="7" onkeypress="return numeros(event)" name="pres_fal_contratacion" value="<?php echo $pres_fal_contratacion[0] ?>"></input></td>
                    <td><input type="text" size="7" onkeypress="return numeros(event)" name="pres_fal_gastos" value="<?php echo $pres_fal_gastos[0] ?>"></input></td>
                    <td><?php echo "$ ".$totalfal ?></td>
                    <td><textarea cols="30" name="concepto"  rows="3"><?php echo $concepto[0] ?></textarea></td>
                </tr>
            </table>
                <br>
                  <p><label>
                  <input type="submit" onclick="return validarv();" name="Actualizar" id="insertar" value="Actualizar" accesskey="I" />
                  </label></p>
                </form>
            </center>
            <br></br>

        </div>

        <div id="" >
            
            <form name="f1" accept-charset="UTF-8" method="post">

                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                <table id='demotable1'>

                    <thead>
                        <tr>
                            <th>Id Detalle</th>
                            <th>Código Mesa Sectorial</th>
                            <th>Nombre Mesa Sectorial</th>
                            <th>Código de la Norma</th>
                            <th>Nombre de la Norma</th>
                            <th>Requiere Elaborar Instrumentos</th>
                            <th>Nit de Empresa - Convenio (Por Alianza)</th>
                            <th>Empresa (Por Alianza)</th>
                            <th>Número de Evaluaciones (Por Alianza)</th>
                            <!--<th>Número Total de Personas a Evaluar (Por Alianza)..</th>-->
                            <th>Número de Evaluaciones (Por Demanda Social)</th>
                            <!--<th>Número Total de Personas a Evaluar (Por Demanda Social)..</th>-->
                            <!--<th>Número de Evaluaciones (Funcionarios)..</th>-->
                            <!--<th>Número Total de Personas a Evaluar (Funcionarios)..</th>-->
                            <!--<th>Consolidado TOTAL de Personas a Evaluar..</th>-->
                            <th>Consolidado TOTAL de Evaluaciones</th>
                            <th>Número de Evaluadores Requeridos</th>
                            <th>Horas Totales de Evaluadores Requeridas para Emitir los Juicios de las Personas Evaluadas</th>
                            <th>Presupuesto Recursos Humanos</th>
                            <th>Presupuesto Materiales</th>
                            <th>Presupuesto Viáticos</th>
                            <th>Observaciones</th>
                            <th>Proyectos Productivos</th>
                            <th width="50">Validación</th>
                            <th>Concepto Asesor</th>
                            <th>Modificar Concepto</th>
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
                        echo "<tr><td>$row2[ID_DETA]</td>";
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
                        echo "<td>".utf8_encode($e)."</td>";
                        if ($row2[AL_NUM_CERTIF] == null) {
                            $row2[AL_NUM_CERTIF] = 0;
                            echo "<td>$row2[AL_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[AL_NUM_CERTIF]</td>";
                        }
//                        if ($row2[AL_NUM_PERSONAS] == null) {
//                            $row2[AL_NUM_PERSONAS] = 0;
//                            echo "<td>$row2[AL_NUM_PERSONAS]..</td>";
//                        } else {
//                            echo "<td>$row2[AL_NUM_PERSONAS]..</td>";
//                        }
                        if ($row2[DS_NUM_CERTIF] == null) {
                            $row2[DS_NUM_CERTIF] = 0;
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        }
//                        if ($row2[DS_NUM_PERSONAS] == null) {
//                            $row2[DS_NUM_PERSONAS] = 0;
//                            echo "<td>$row2[DS_NUM_PERSONAS]..</td>";
//                        } else {
//                            echo "<td>$row2[DS_NUM_PERSONAS]..</td>";
//                        }
//                        if ($row2[FUN_NUM_CERTIF] == null) {
//                            $row2[FUN_NUM_CERTIF] = 0;
//                            echo "<td>$row2[FUN_NUM_CERTIF]..</td>";
//                        } else {
//                            echo "<td>$row2[FUN_NUM_CERTIF]..</td>";
//                        }
//                        if ($row2[FUN_NUM_PERSONAS] == null) {
//                            $row2[FUN_NUM_PERSONAS] = 0;
//                            echo "<td>$row2[FUN_NUM_PERSONAS]..</td>";
//                        } else {
//                            echo "<td>$row2[FUN_NUM_PERSONAS]..</td>";
//                        }
//                        echo "<td>$totalpersonas..</td>";
                        echo "<td>$totalcertificados</td>";
                        echo "<td>$row2[EV_NUM_REQUERIDO]</td>";
                        echo "<td>$row2[EV_HORAS_TOTALES]</td>";
                        echo "<td>$ $row2[PRES_REC_HUMANOS]</td>";
                        echo "<td>$ $row2[PRES_MATERIALES]</td>";
                        echo "<td>$ $row2[PRES_VIATICOS]</td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[OBSERVACIONES]</textarea></td></td>";
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[DET_PRO_PRODUCTIVO]</textarea></td></td>";
                        if ($row2[VALIDACION]==0){
//                            echo "<td>Pend<input type=\"checkbox\" disabled value=\"Pendiente\" ></input><br>Si<input type=\"checkbox\" disabled value=\"Si\" ></input><br>No<input type=\"checkbox\" disabled value=\"No\" checked></input> </td>";
                            echo "<td>No</td>";
                        }else if ($row2[VALIDACION]==1){
//                            echo "<td>Pend<input type=\"checkbox\" disabled value=\"Pendiente\" ></input><br>Si<input type=\"checkbox\" disabled value=\"Si\" checked><br>No</input><input type=\"checkbox\" disabled value=\"No\" ></input></td>";
                            echo "<td>Si</td>";
                        }else{
//                            echo "<td>Pend<input type=\"checkbox\" disabled value=\"Pendiente\" checked ></input><br>Si<input type=\"checkbox\" disabled value=\"Si\"><br>No</input><input type=\"checkbox\" disabled value=\"No\" ></input> </td>";
                            echo "<td>Pendiente</td>";
                        }
                        echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[CONCEPTO_ASESOR]</textarea></td></td>";
                        echo "<td><a href=\"concepto_asesor.php?plan=$codiplan&iddeta=$row2[ID_DETA]\"><img src=\"../images/editar.png\" alt=\"40\" width=\"40\"></a></td>";
                        
                        $num++;
                    }
                    oci_close($connection2);
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>
