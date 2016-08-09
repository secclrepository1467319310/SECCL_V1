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
        <script>
            function numeros(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toLowerCase();
                letras = " 0123456789";
                especiales = [8, 37, 39];
                //46 el punto
                tecla_especial = false
                for (var i in especiales) {
                    if (key == especiales[i]) {
                        tecla_especial = true;
                        break;
                    }
                }

                if (letras.indexOf(tecla) == -1 && !tecla_especial)
                    return false;
            }

        </script>
    </head>
    <body onload="inicio()">
	<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito" >
            <br>
            <center><h1>Emisión de Juicio</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $plan = $_GET['idplan'];
            $idca = $_GET['idca'];
            $idn = $_GET['norma'];

            //---
            $query23 = ("select n.codigo_norma from norma n where n.id_norma='$idn'");
            $statement23 = oci_parse($connection, $query23);
            $resp23 = oci_execute($statement23);
            $cnorma = oci_fetch_array($statement23, OCI_BOTH);
            //--
            $query24 = ("select nombre from usuario where usuario_id='$idca'");
            $statement24 = oci_parse($connection, $query24);
            $resp24 = oci_execute($statement24);
            $nombre = oci_fetch_array($statement24, OCI_BOTH);
            //--
            $query25 = ("select primer_apellido from usuario where usuario_id='$idca'");
            $statement25 = oci_parse($connection, $query25);
            $resp25 = oci_execute($statement25);
            $apellido = oci_fetch_array($statement25, OCI_BOTH);
            //-
            $query33 = ("select estado from evidencias_candidato
                         where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement33 = oci_parse($connection, $query33);
            $resp33 = oci_execute($statement33);
            $estado = oci_fetch_array($statement33, OCI_BOTH);
            //---
            //--
            $query27 = ("select ec from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement27 = oci_parse($connection, $query27);
            $resp27 = oci_execute($statement27);
            $ec = oci_fetch_array($statement27, OCI_BOTH);
            //--
            //--
            $query28 = ("select opec from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement28 = oci_parse($connection, $query28);
            $resp28 = oci_execute($statement28);
            $opec = oci_fetch_array($statement28, OCI_BOTH);
            //--
            //--
            $query29 = ("select ed from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement29 = oci_parse($connection, $query29);
            $resp29 = oci_execute($statement29);
            $ed = oci_fetch_array($statement29, OCI_BOTH);
            //--
            //--
            $query30 = ("select oped from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement30 = oci_parse($connection, $query30);
            $resp30 = oci_execute($statement30);
            $oped = oci_fetch_array($statement30, OCI_BOTH);
            //--
            //--
            $query31 = ("select ep from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement31 = oci_parse($connection, $query31);
            $resp31 = oci_execute($statement31);
            $ep = oci_fetch_array($statement31, OCI_BOTH);
            //--
            //--
            $query32 = ("select opep from evidencias_candidato where id_plan='$plan' and id_norma='$idn' and id_candidato='$idca'");
            $statement32 = oci_parse($connection, $query32);
            $resp32 = oci_execute($statement32);
            $opep = oci_fetch_array($statement32, OCI_BOTH);

            //--
            $totalec = $ec[0] + $opec[0];
            $totaled = $ed[0] + $oped[0];
            $totalep = $ep[0] + $opep[0];
            ?>
            <!--<form class='proyecto' name="formmapa" action="guardar_juicio_ev.php?norma=<?php // echo $idn   ?>&idca=<?php // echo $idca   ?>&idplan=<?php // echo $plan   ?>" method="post" accept-charset="UTF-8" >-->
            <div id="generalidades" class='proyecto'>   
                <?php if ($_GET['mensaje'] == 1) { ?>
                    <div class="mensaje">El juicio del candidato se emitio correctamente.</div>
                <?php } elseif ($_GET['mensaje'] == 2) { ?>
                    <div class="error">Error durante la actualización</div>
                <?php } elseif ($_GET['mensaje'] == 3) { ?>
                    <div class="error">El total de ninguna evidencia debe superar el 100 %</div>
                <?php } ?>
                <center>
                    <fieldset>
                        <legend><strong>Revisión</strong></legend>
                        </br><b style="color: red;">Usted esta a punto de emitir juicio con las siguientes valoraciones:</b>
                        </br>
                        </br>
                        <table>
                            <tr>
                                <th width="">Nombre Candidato</th>
                                <th width="">Norma</th>
                            </tr>
                            <tr>
                                <td><?php echo $nombre[0] . ' ' . $apellido[0] ?></td>
                                <td><?php echo $cnorma[0] ?></td>
                            </tr>
                        </table>
                        <form name="formmapa" action="guardar_juicio_ev.php?norma=<?php echo $idn ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>&accion=1" method="post" accept-charset="UTF-8" >
                            <table>
                                <tr>
                                    <th>Valoración Inicial</th>
                                    <th>Oportunidad</th>
                                    <th>Ponderación Total</th>
                                </tr>
                                <tr>
                                    <?php if ($estado[0] == 0) { ?>
                                        <?php if ($ec[0] == NULL || $ec[0] == 0) { ?>
                                            <td><label><?php echo $ec[0] ?></label><input type="hidden" onkeypress="return numeros(event)" size="3" name="vic"></td>
                                            <td><label><?php echo $opec[0] ?></label></td>
                                        <?php } else if ($ec[0] < 60) { ?>
                                            <td><label><?php echo $ec[0] ?></label><input type="hidden" value="<?php echo $ec[0] ?>" onkeypress="return numeros(event)" size="3" name="vic"></td>
                                            <td><label><?php echo $opec[0] ?></label></td>
                                        <?php } else if ($ec[0] >= 60 && $opec[0] == 0) { ?>
                                            <td><label><?php echo $ec[0] ?></label><input type="hidden" value="<?php echo $ec[0] ?>" onkeypress="return numeros(event)" size="3" name="vic"></td>
                                            <td><label><?php echo $opec[0] ?></label><input type="hidden" onkeypress="return numeros(event)" value="<?php echo $opec[0] ?>" size="3" name="opc"></td>
                                        <?php } else { ?>
                                            <td><label><?php echo $ec[0] ?></label><input type="hidden"  value="<?php echo $ec[0] ?>" onkeypress="return numeros(event)" size="3" name="vic"></td>
                                            <td><label><?php echo $opec[0] ?></label><input type="hidden"  value="<?php echo $opec[0] ?>" onkeypress="return numeros(event)" size="3" name="opc"></td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <td><label><?php echo $ec[0] ?></label></td>
                                        <td><label><?php echo $opec[0] ?></label></td>
                                    <?php } ?>

                                    <?php if ($totalec < 100) { ?>
                                        <td><strong><label style="color: #cd0a0a"><?php echo $totalec ?></label></strong></td>
                                    <?php } else { ?>
                                        <td><strong><label style="color: #23838b"><?php echo $totalec ?></label></strong></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </form>
                        <form name="formmapa" action="guardar_juicio_ev.php?norma=<?php echo $idn ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>&accion=2" method="post" accept-charset="UTF-8" >
                            <table>
                                <tr>
                                    <th>Valoración Inicial</th>
                                    <th>Oportunidad</th>
                                    <th>Ponderación Total</th>
                                </tr>
                                <tr>
                                    <?php if ($estado[0] == 0) { ?>
                                        <?php if ($ed[0] == NULL || $ed[0] == 0) { ?>
                                            <td><label><?php echo $ed[0] ?></label><input type="hidden" onkeypress="return numeros(event)" size="3" name="vid"></td>
                                            <td><label><?php echo $oped[0] ?></label><?php echo $oped[0] ?></td>
                                        <?php } else if ($ed[0] < 60) { ?>
                                            <td><label><?php echo $ed[0] ?></label><input type="hidden" value="<?php echo $ed[0] ?>" onkeypress="return numeros(event)" size="3" name="vid"></td>
                                            <td><label><?php echo $oped[0] ?></label></td>
                                        <?php } else if ($ed[0] >= 60 && $oped[0] == 0) { ?>
                                            <td><label><?php echo $ed[0] ?></label><input type="hidden" value="<?php echo $ed[0] ?>" onkeypress="return numeros(event)" size="3" name="vid"></td>
                                            <td><label><?php echo $oped[0] ?></label><input type="hidden" onkeypress="return numeros(event)" value="<?php echo $oped[0] ?>" size="3" name="opd"></td>
                                        <?php } else { ?>
                                            <td><label><?php echo $ed[0] ?></label><input type="hidden"  value="<?php echo $ed[0] ?>" onkeypress="return numeros(event)" size="3" name="vid"></td>
                                            <td><label><?php echo $oped[0] ?></label><input type="hidden"  value="<?php echo $oped[0] ?>" onkeypress="return numeros(event)" size="3" name="opd"></td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <td><label><?php echo $ed[0] ?></label><?php echo $ed[0] ?></td>
                                        <td><label><?php echo $oped[0] ?></label></td>
                                    <?php } ?>

                                    <?php if ($totaled < 100) { ?>
                                        <td><strong><label style="color: #cd0a0a"><?php echo $totaled ?></label></strong></td>
                                    <?php } else { ?>
                                        <td><strong><label style="color: #23838b"><?php echo $totaled ?></label></strong></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </form>
                        <form name="formmapa" action="guardar_juicio_ev.php?norma=<?php echo $idn ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>&accion=3" method="post" accept-charset="UTF-8" >
                            <table>
                                <tr>
                                    <th>Valoración Inicial</th>
                                    <th>Oportunidad</th>
                                    <th>Ponderación Total</th>
                                </tr>
                                <tr>
                                    <?php if ($estado[0] == 0) { ?>
                                        <?php if ($ep[0] == NULL || $ep[0] == 0) { ?>
                                            <td><label><?php echo $ep[0] ?></label><input type="hidden" onkeypress="return numeros(event)" size="3" name="vip"></td>
                                            <td><label><?php echo $opep[0] ?></label></td>
                                        <?php } else if ($ep[0] < 60) { ?>
                                            <td><label><?php echo $ep[0] ?></label><input type="hidden" value="<?php echo $ep[0] ?>" onkeypress="return numeros(event)" size="3" name="vip"></td>
                                            <td><label><?php echo $opep[0] ?></label></td>
                                        <?php } else if ($ep[0] >= 60 && $opep[0] == 0) { ?>
                                            <td><label><?php echo $ep[0] ?></label><input type="hidden" value="<?php echo $ep[0] ?>" onkeypress="return numeros(event)" size="3" name="vip"></td>
                                            <td><label><?php echo $opep[0] ?></label><input type="hidden" onkeypress="return numeros(event)" value="<?php echo $opep[0] ?>" size="3" name="opp"></td>
                                        <?php } else { ?>
                                            <td><label><?php echo $ep[0] ?></label><input type="hidden"  value="<?php echo $ep[0] ?>" onkeypress="return numeros(event)" size="3" name="vip"></td>
                                            <td><label><?php echo $opep[0] ?></label><input type="hidden"  value="<?php echo $opep[0] ?>" onkeypress="return numeros(event)" size="3" name="opp"></td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <td><label><?php echo $ep[0] ?></label><?php echo $ep[0] ?></td>
                                        <td><label><?php echo $opep[0] ?></label></td>
                                    <?php } ?>    

                                    <?php if ($totalep < 100) { ?>
                                        <td><strong><label style="color: #cd0a0a"><?php echo $totalep ?></label></strong></td>
                                    <?php } else { ?>
                                        <td><strong><label style="color: #23838b"><?php echo $totalep ?></label></strong></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br></br>
                    <p><label>
                            <?php if ($estado[0] == 0) { ?>
                                <form name="formmapa" action="guardar_juicio_ev.php?norma=<?php echo $idn ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>&accion=4" method="post" accept-charset="UTF-8" onsubmit = "return confirm('¿Esta seguro que desea emitir el juicio?')">
                                    <input type = "submit" name = "insertar" id = "insertar" value = "Emitir Juicio" accesskey = "I" />
                                </form>
                            <?php } ?>
                            <br></br>
                            <a href = "emitir_juicio_ev.php?norma=<?php echo $idn ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>"> Volver </a>
                        </label></p>

                </center>
            </div>
            <!--</form>-->
        </div>
        <div class="space">&nbsp;</div>
	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>