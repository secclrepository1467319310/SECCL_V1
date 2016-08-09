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


    </head>
    <body>
        <div id="">
            <br></br>
            <img src="../images/logos/sena.jpg" align="left" ></img>
            <strong>FORMATO DE SOLICITUD DE PROCESO DE EVALUACIÓN Y CERTIFICACIÓN DE COMPETENCIAS LABORALES</strong><br></br>
            <strong> Evaluación y Certificación de Competencias Laborales</strong>
            <strong>Detalles</strong><br></br>

            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $codigo = $_GET['codigo'];


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

            $query6 = ("SELECT fecha_solicitud FROM solicitud_f where id_solicitud_f =  '$codigo'");
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
            
            $query9 = ("SELECT ID_USUARIO FROM solicitud_f where id_solicitud_f =  '$codigo'");
            $statement9 = oci_parse($connection, $query9);
            $resp9 = oci_execute($statement9);
            $usu = oci_fetch_array($statement9, OCI_BOTH);
            
            ?>

            <center>
                <table>
                    <?php 
                    $query23 = "select * from usuario where usuario_id='$usu[0]'";

                    $statement23 = oci_parse($connection, $query23);
                    oci_execute($statement23);

                    $numero = 0;
                    while ($row23 = oci_fetch_array($statement23, OCI_BOTH)) {
                        ?>

                        <thead>
                            <tr><th><strong>Código Regional</strong></th><th><strong>Nombre Regional</strong></th>
                                <th><strong>Código Centro</strong></th><th><strong>Nombre Centro</strong></th><th><strong>Fecha Solicitud</strong></th>
                            </tr>
                            <tr>
                                <td><?php echo $reg[0]; ?></td><td><?php echo $nomreg[0] ?></td>
                                <td><?php echo $cen[0]; ?></td><td><?php echo $nomcen[0] ?></td><td><?php echo $fe[0] ?></td>
                            </tr>
                            <tr><th><strong>Primer Apellido</strong></th><th><strong>Segundo Apellido </strong></th>
                                <th><strong>Nombres </strong></th><th><strong>Tipo Documento </strong></th><th><strong>N° Documento </strong></th>
                            </tr>
                            <tr>
                                <td><?php echo $row23["PRIMER_APELLIDO"]; ?></td><td><?php echo $row23["SEGUNDO_APELLIDO"] ?></td>
                                <td><?php echo $row23["NOMBRE"]; ?></td><td><?php echo $row23["TIPO_DOC"] ?></td><td><?php echo $row23["DOCUMENTO"] ?></td>
                            </tr>
                            <tr><th><strong>Teléfono 1 </strong></th><th><strong>Teléfono 2 </strong></th>
                                <th><strong>Celular </strong></th><th><strong>Email </strong></th><th><strong>Estrato </strong></th>
                            </tr>
                            <tr>
                                <td><?php echo $row23["TELEFONO"]; ?></td><td><?php echo $row23["TELEFONO"] ?></td>
                                <td><?php echo $row23["CELULAR"]; ?></td><td><?php echo $row23["EMAIL"] ?></td><td><?php echo $row23["ESTRATO"] ?></td>
                            </tr>
                            <tr><th><strong>Departamento Domicilio </strong></th><th><strong>Municipio Domicilio </strong></th>
                                <th><strong>Dirección </strong></th><th><strong>Tipo Población </strong></th><th><strong>Nivel Escolaridad </strong></th>
                            </tr>
                            <tr>
                                <td><?php echo $row23["DEPTO_RESIDENCIA"]; ?></td><td><?php echo $row23["MUNICIPIO_RESIDENCIA"] ?></td>
                                <td><?php echo $row23["DIRECCION_RESIDENCIA"]; ?></td><td><?php echo $row23["ID_TIPO_POBLACION"] ?></td><td><?php echo $row23["ID_ESCOLARIDAD"] ?></td>
                            </tr>
                            <tr><th><strong>Última Inst.Educativa </strong></th><th><strong>Condición Laboral </strong></th>
                                <th><strong>Nombre Empresa </strong></th><th><strong>Discapacidad </strong></th><th><strong>Tipo de Discapacidad </strong></th>
                            </tr>
                            <tr>
                                <td><?php echo $row23[""] ?></td><td><?php echo $row23["CONDICION_LABORAL"] ?></td>
                                <td><?php echo $row23["NIT_EMPRESA"] ?></td><td><?php echo $row23["MUNICIPIO_RESIDENCIA"] ?></td><td><?php echo $row23["MUNICIPIO_RESIDENCIA"] ?></td>
                            </tr>
                        </thead>
                    <?php
                    $numero++;
                    }
                    ?>

                    </table><br>
                        <table>
                            <tr><td>Observaciones</td><td><textarea cols="30" readonly rows="3"></textarea></td></tr>
                        </table>
                </center>



                <br></br><br></br>

            </div>

            <div id="" >
                <center>
                    <form name="f1" accept-charset="UTF-8" method="post">

                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <table id='demotable1'>

                            <thead>
                                <tr>
                                    <th>Código Mesa Sectorial</th>
                                    <th>Nombre Mesa Sectorial</th>
                                    <th>Código de la Norma</th>
                                    <th>Versión de la Norma</th>
                                    <th>Nombre de la Norma</th>
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



                                $totalpersonas = $row2["AL_NUM_PERSONAS"] + $row2["DS_NUM_PERSONAS"] + $row2["FUN_NUM_PERSONAS"];
                                $totalcertificados = $row2["AL_NUM_CERTIF"] + $row2["DS_NUM_CERTIF"] + $row2["FUN_NUM_CERTIF"];

                                echo "<tr><td>$cmesa[0]</td>";
                                echo "<td>$mesa</td>";
                                echo "<td>$c_norma[0]</td>";
                                echo "<td>$t</td>";
                                echo "<td>$totalpersonas</td></tr>";

                                $num++;
                            }
                            oci_close($connection2);
                            ?>
                    </table>
                        <br>
                            <input type="submit" value="Guardar Respuesta"></input>
                        </br>
                </form>
            </center>
        </div>
    </body>
</html>
