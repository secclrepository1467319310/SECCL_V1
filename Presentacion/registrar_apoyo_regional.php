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
include ("calendario/calendario.php");
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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_registrar_apoyo_regional.js"></script>
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
        <script language="javascript">
            function validarev() {
                {
                    var correcto = true;
                    if (document.f3.documento.value == "")
                    {
                        window.alert("Digite el Número de Documento");
                        return false;
                    }
                    else if (document.f3.nombres.value == "")
                    {
                        window.alert("Digite el Nombre");
                        return false;
                    }
                    else if (document.f3.ip.value == "")
                    {
                        window.alert("Digite el IP");
                        return false;
                    }
                    else if (document.f3.celular.value == "")
                    {
                        window.alert("Digite el Celular");
                        return false;
                    }
                    else if (document.f3.email.value == "")
                    {
                        window.alert("Ingrese el email");
                        return false;
                    }
                    else if (document.f3.email2.value == "")
                    {
                        window.alert("Digite el Email Personal");
                        return false;
                    }
                    else if (document.f3.em.value == "")
                    {
                        window.alert("Digite empresa");
                        return false;
                    }
//                    else if (document.f3.num_certificado.value == "")
//                    {
//                        window.alert("Indique N° Certificado");
//                        return false;
//                    }
//                    else if (document.f3.fecha_certificado.value == "")
//                    {
//                        window.alert("seleccione la fecha de certificación");
//                        return false;
//                    }
                    else if (document.f3.fecha_proceso.value == "")
                    {
                        window.alert("Seleccione la Fecha del ultimo proceso ");
                        return false;
                    }
                    else if (document.f3.em.value == "")
                    {
                        window.alert("Digite Empresa ");
                        return false;
                    }

                    else if (document.f3.obs.value == "")
                    {
                        window.alert("Ingrese la observación");
                        return false;
                    }
                }
            }
        </script>
        <script language="JavaScript">


            function ac() {
                frm = document.forms['f3'];
                for (i = 0; ele = frm.elements[i]; i++)
                    ele.disabled = false;
            }

            function deshab() {
                frm = document.forms['f3'];
                for (i = 15; ele = frm.elements[i]; i++)
                    ele.disabled = true;
            }


            function habilita1() {
                document.f3.em.disabled = false;
            }

            function deshabilita1() {
                document.f3.em.disabled = true;
                document.f3.em.value = "N.A.";

            }



        </script> 


        <script language="JavaScript" src="calendario/javascripts.js"></script>

    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedor" >
                <?php
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);
                
                
                $query1 = ("SELECT RU.CODIGO_REGIONAL, RE.NOMBRE_REGIONAL FROM T_REGIONALES_USUARIOS RU "
                        . "INNER JOIN REGIONAL RE "
                        . "ON RU.CODIGO_REGIONAL = RE.CODIGO_REGIONAL "
                        . "where ID_USUARIO =  '$id'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);

                $query8 = ("SELECT count(*) from apoyos where codigo_centro='$cen[0]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $t = oci_fetch_array($statement8, OCI_BOTH);
                ?>
                 <form name="f3" id="f3" <?php /*onSubmit="return validarev();"*/?> method="post" 
                      action="guardar_apoyo_regional.php" accept-charset="UTF-8">

                    <center><table id='demotable1'>


                            <tr><th>Codigo Regional</th><td><input type="text" name="regional" size="2" readonly value="<?php echo $reg['CODIGO_REGIONAL'] ?>"/></td></tr>
                            <tr><th>Regional</th><td><?php echo utf8_encode($reg['NOMBRE_REGIONAL']) ?></td></tr>
                            <tr>
                                <th>Centro</th>
                                <td>
                                    <?php 
//                                    echo$query2 = "SELECT * "
//                                                . "FROM CENTRO CTR "
//                                                . "INNER JOIN REGIONAL RG ON CTR.CODIGO_REGIONAL = RG.CODIGO_REGIONAL "
//                                                . "WHERE RG.CODIGO_REGIONAL = $reg[0]";
                                    
                                    ?>
                                    <select name="centro">
                                        <option value="-1">Seleccione</option>
                                        <?php
                                        $query2 = "SELECT * "
                                                . "FROM CENTRO CTR "
                                                . "INNER JOIN REGIONAL RG ON CTR.CODIGO_REGIONAL = RG.CODIGO_REGIONAL "
                                                . "WHERE RG.CODIGO_REGIONAL = $reg[0]";
                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);

                                        $numero = 0;
                                        while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                                            ?>
                                        <option value="<?php echo $row2[CODIGO_CENTRO]; ?>"><?php echo $row2[CODIGO_CENTRO] . ' - ' . utf8_encode($row2[NOMBRE_CENTRO]); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr><th>Tipo documento</th>
                                <td><input type="radio" value="1" name="tdoc"  checked></input>T.I.
                                    <input type="radio" value="2" name="tdoc"></input>C.C.
                                    <input type="radio" value="3" name="tdoc"></input>C.E.</td></tr>
                            <tr><th>Documento</th><td><input type="text" name="documento" onKeyPress="return validar(event)"/></td></tr>
                            <tr><th>Nombres</th><td><input type="text" name="nombres" size="50"  /></td></tr>
                            <tr><th>Primer Apellido</th><td><input type="text" name="papellido" size="50"  /></td></tr>
                            <tr><th>Segundo Apellido</th><td><input type="text" name="sapellido" size="50"  /></td></tr>
                            <tr><th>Email</th><td><input type="text" name="email" size="50" /></td></tr>
                        </table>
                        <br></br>
                        <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I" />
                    </center>
                </form>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>