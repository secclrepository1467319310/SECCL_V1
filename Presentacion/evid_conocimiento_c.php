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
            <strong>FORMATO DE PLAN DE EVALUACIÓN Y EJECUCIÓN DE EVIDENCIAS</strong><br></br>
            <strong> Evaluación y Certificación de Competencias Laborales</strong><br></br>

            <?php
            include("../Clase/conectar.php");
            include ("calendario/calendario.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $codiplan = $_GET['plan'];
            $f = date('Y');
            

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

                $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $nomreg = oci_fetch_array($statement7, OCI_BOTH);

                $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $nomcen = oci_fetch_array($statement8, OCI_BOTH);

               
                ?>

            <div>
                
            <br>
                <input type="submit" name="Guardar" value="Guardar"></input>
            </br>
            </form>
        <br></br>
        <br></br>
        </div>
    </body>
</html>
