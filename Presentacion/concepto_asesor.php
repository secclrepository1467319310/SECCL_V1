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
    especiales = [8,37,39,46];
 
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
            
            $iddeta = $_GET['iddeta'];
            $plan=$_GET['plan'];
            ?>
        </div>

        <div id="" >

            <form name="f1" accept-charset="UTF-8" method="post" action="guardar_concepto.php?iddeta=<?php echo $iddeta ?>&plan=<?php echo $plan ?>">

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
                            <!--<th>Número Total de Personas a Evaluar (Por Alianza)*</th>-->
                            <th>Número de Evaluaciones (Por Demanda Social)</th>
                            <!--<th>Número Total de Personas a Evaluar (Por Demanda Social)*</th>-->
<!--                            <th>Número de Certificaciones (Funcionarios)*</th>
                            <th>Número Total de Personas a Certificar (Funcionarios)*</th>-->
                            <th>Consolidado TOTAL de Personas a Evaluar</th>
                            <th>Consolidado TOTAL de Evaluaciones</th>
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
                    $query2 = "SELECT * FROM DETALLES_POA where ID_DETA='$iddeta'";
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
//                            echo "<td>$row2[AL_NUM_PERSONAS]*</td>";
//                        } else {
//                            echo "<td>$row2[AL_NUM_PERSONAS]*</td>";
//                        }
                        if ($row2[DS_NUM_CERTIF] == null) {
                            $row2[DS_NUM_CERTIF] = 0;
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        } else {
                            echo "<td>$row2[DS_NUM_CERTIF]</td>";
                        }
//                        if ($row2[DS_NUM_PERSONAS] == null) {
//                            $row2[DS_NUM_PERSONAS] = 0;
//                            echo "<td>$row2[DS_NUM_PERSONAS]*</td>";
//                        } else {
//                            echo "<td>$row2[DS_NUM_PERSONAS]*</td>";
//                        }
//                        if ($row2[FUN_NUM_CERTIF] == null) {
//                            $row2[FUN_NUM_CERTIF] = 0;
//                            echo "<td>$row2[FUN_NUM_CERTIF]*</td>";
//                        } else {
//                            echo "<td>$row2[FUN_NUM_CERTIF]*</td>";
//                        }
//                        if ($row2[FUN_NUM_PERSONAS] == null) {
//                            $row2[FUN_NUM_PERSONAS] = 0;
//                            echo "<td>$row2[FUN_NUM_PERSONAS]*</td>";
//                        } else {
//                            echo "<td>$row2[FUN_NUM_PERSONAS]*</td>";
//                        }
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
                    
                    ?>
                </table>
                <center>
                    <?php
                    
                        $query13 = ("SELECT VALIDACION FROM DETALLES_POA where ID_DETA =  '$iddeta' ");
                        $statement13 = oci_parse($connection2, $query13);
                        $resp13 = oci_execute($statement13);
                        $val = oci_fetch_array($statement13, OCI_BOTH);
                        
                        $query16 = ("SELECT CONCEPTO_ASESOR FROM DETALLES_POA where ID_DETA =  '$iddeta' ");
                        $statement16 = oci_parse($connection2, $query16);
                        $resp16 = oci_execute($statement16);
                        $concepto = oci_fetch_array($statement16, OCI_BOTH);
                        
                       
                    
                    ?>
                    <table>
                        <tr>
                            <th>Validado</th>
                            <th>Concepto Asesor</th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($val[0]==1){
                                ?>
                                <input type="radio" name="validado" value="3">Pend</input><br>
                                <input type="radio" name="validado" value="1" checked>Si</input><br>
                                <input type="radio" name="validado" value="0" >No</input>    
                                <?php
                                }else if ($val[0]==0){
                                ?>
                                <input type="radio" name="validado" value="3">Pend</input><br>
                                <input type="radio" name="validado" value="1" >Si</input><br>
                                <input type="radio" name="validado" value="0" checked>No</input>
                                <?php
                                }else{
                                ?>
                                <input type="radio" name="validado" value="3" checked>Pend</input><br>
                                <input type="radio" name="validado" value="1" >Si</input><br>
                                <input type="radio" name="validado" value="0">No</input>
                                <?php
                                }?>
                            </td>
<!--                            <td><input type="text" name="pasignado" onkeypress="return numeros(event)" value="<?php echo $pasig[0] ?>"></input></td>
                            <td><input type="text" name="pfaltante" onkeypress="return numeros(event)" value="<?php echo $pfal[0]  ?>"></input></td>-->
                            <td><textarea cols="30" rows="3" name="concepto" ><?php echo $concepto[0]?></textarea></td>
                        </tr>
                        <br>
                        </br>
                     </table>
                    <br>
                        <p><label>
                                <input type="submit" onclick="return validarv();" name="Guardar" id="insertar" value="Guardar" accesskey="I" />
                        </label></p>
                </center>
            </form>
            <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
            <br></br>
            <center>
            <table>
                <tr>
                    <th>Validado</th>
                    <th>Concepto Asesor</th>
                    <th>Fecha Registro</th>
                    <th>Asesor quien emite Concepto</th>
                </tr>
                <?php
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                
            $query21 = "SELECT * FROM TRAZABILIDAD_CONCEPTO_ASESOR where ID_DETA='$iddeta'";
            $statement21 = oci_parse($connection, $query21);
            oci_execute($statement21);
            $nume = 0;
            while ($row2 = oci_fetch_array($statement21, OCI_BOTH)) {
                
                            if ($row2[VALIDACION]==0) {
                                $v="No";
                            }else if($row2[VALIDACION]==1){
                                $v="Si";
                            }else{
                                $v="Pendiente";
                            }
                
              $query20 = ("SELECT NOMBRE FROM USUARIO where USUARIO_ID=$row2[ID_ASESOR]");
            $statement20 = oci_parse($connection, $query20);
            $resp20 = oci_execute($statement20);
            $asesor = oci_fetch_array($statement20, OCI_BOTH);
                            
                    echo "<tr><td>$v</td>";
                    echo "<td><textarea cols=\"30\" readonly rows=\"3\">$row2[CONCEPTO_ASESOR]</textarea></td>";
                    echo "<td>$row2[FECHA_REGISTRO]</td>";
                    echo "<td>$asesor[0]</tr>";
                
                $nume++;
                    }
                  oci_close($connection);
                ?>
            </table>
            </center>
        </div>
    </body>
</html>