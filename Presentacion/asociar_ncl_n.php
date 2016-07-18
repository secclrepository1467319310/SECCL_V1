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
        <script type="text/javascript">

            function comprobar() {

                valor = document.getElementById('but').value;

                if (valor == 1) {

                    document.f2.tp1.disabled = !document.f2.tp1.disabled;
                    document.f2.nit_empresa.disabled = !document.f2.nit_empresa.disabled;


                }
            }
        </script>
        <script type="text/javascript">

            function comprobar2() {

                valor = document.getElementById('but2').value;

                if (valor == 2) {

                    document.f2.tp.disabled = !document.f2.tp.disabled;
                    document.f2.nit_empresa.enabled = !document.f2.nit_empresa.enabled;

                }
            }
        </script>
        <script language="javascript">
            function validarv()
            {
                while (!document.f2.tp.checked && !document.f2.tp1.checked)
                {
                    window.alert("Seleccione un Tipo de Ejecución");
                    return false;
                }
                return true;
            }
        </script>
        <script language="javascript">
            function validar() {
                var key = window.event.keyCode;
                if (key < 48 || key > 57) {
                    window.event.keyCode = 0;
                }
            }
        </script>
        <script language="JavaScript">

            function habilita() {
                document.f2.nit_empresa.disabled = false;
                document.f2.val.disabled = false;
            }
            function deshabilita() {
                document.f2.nit_empresa.disabled = true;
                document.f2.val.disabled = true;
            }

        </script>
        <script type="text/javascript">
            function activa(v) {
                if (v == 1) {
                    document.getElementById("val").disabled = true;
                    document.f2.nit_empresa.disabled = true

                } else {
                    document.getElementById("val").disabled = false;
                    document.f2.nit_empresa.disabled = false

                }
            }
        </script>

    </head>
    <body onload="inicio()">
        <?php

        function restaFechas($dFecIni, $dFecFin) {
            $dFecIni = str_replace("-", "", $dFecIni);
            $dFecIni = str_replace("/", "", $dFecIni);
            $dFecFin = str_replace("-", "", $dFecFin);
            $dFecFin = str_replace("/", "", $dFecFin);

            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

            $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
            $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

            return round(($date2 - $date1) / (60 * 60 * 24));
        }
        ?>

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito" style="height:600px;width:1010px;overflow:scroll;">
                <?php
                $plan = $_GET["plan"];
                $unidad = $_GET["unidad"];

                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);


                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMATO DE REGISTRO DE PROGRAMACIÓN ANUAL PARA EL PROCESO</strong><br></br>
                    <strong> Certificación de Competencias Laborales</strong>
                    <strong>Datos Generales</strong><br></br>


                    <form name="f2" action="guardar_ncl_n.php" method="post" >

                        <table>
                            <tr>
                                <th>Código Plan</th>
                                <td><input name="plan" type="text" size="1" readonly value="<?php echo $plan ?>"></input></td>
                            </tr>
                            <tr>
                                <th>Código Regional</th>
                                <td><input name="reg" type="text" size="1" readonly value="<?php echo "1" ?>"></input></td>
                            </tr>
                            <tr>
                                <th>Código de Centro</th>
                                <td><input name="cen" type="text" size="1" readonly value="<?php echo "17076" ?>"></input></td>
                            </tr>
                            <tr>
                                <th>Línea de Atención</th>
                                <td>
                                    <select name="tp" onclick="activa(this.value)">

                                        <option value="2" >Alianza</option>
                                        <option value="1" >Demanda Social</option>
                                    </select>
                                </td>
                            </tr>
                            </td>
                            <tr>
                                <th>Nit de Empresa</th>
                                <td><input name="nit_empresa" id="nit_empresa" maxlength="9" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["nit"] ?>">
                                    </input>
                                    <input id="val" type="button" value="Validar nit" onkeypress="validar();" class="botones" onClick="window.location = 'validar_nit_n.php?poa=<?php echo $plan ?>&nit=' + document.getElementById('nit_empresa').value"></input>
                                </td>
                            </tr>
                            <tr>
                                <th>Nombre de  la Empresa</th>
                                <td><input name="nombre_empresa" size="80" type="text" readonly value="<?php echo $_GET["empresa"] ?>"></input>
                                    <?php
                                    if ($_GET["empresa"] == 'Empresa no Registrada') {
                                        ?>
                                        <a href="reg_empresa_n.php?nit=<?php echo $_GET["nit"] ?>&plan=<?php echo $plan ?>">Registrar empresa</a>
                                        <?php
                                    } else {
                                        ?>
                                        Empresa Registrada
                                    <?php }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Sigla de  la Empresa</th>
                                <td>
                                    <input name="sigla_empresa" type="text" readonly value="<?php echo $_GET["sigla"] ?>"></input>
                                </td>
                            </tr>
                            <tr>
                                <th>Unidad de Certificación</th>
                                <td>
                                    <select name="unidad" id="unidad" >
                                        <option value="1">Norma</option>
                                        <option value="2">Titulación</option>
                                        <option value="3">Esquema</option>
                                        <option value="4">Perfil Técnico</option>
                                    </select>
                                    <input id="val" type="button" value="Cargar Catálogo" onkeypress="validar();" class="botones" onClick="window.location = 'validar_unidad_n.php?nit=<?php echo $_GET["nit"] ?>&empresa=<?php echo $_GET["empresa"] ?>&sigla=<?php echo $_GET["sigla"] ?>&poa=<?php echo $plan ?>&unidad=' + document.getElementById('unidad').value"></input>
                                </td>
                            </tr>
                        </table>
                        <br>
                        </br>
                        <?php
                        if ($unidad == 1) {
                            ?>
                            <a id="cleanfilters" href="#">Limpiar Filtros</a>
                            <br></br>
                            <center>
                                <table id="demotable1" >
                                    <thead><tr>
                                            <th><strong>Código Mesa</strong></th>
                                            <th><strong>Nombre Mesa</strong></th>
                                            <th><strong>Código Norma</strong></th>
                                            <th><strong>Versión Norma</strong></th>
                                            <th><strong>Título Norma</strong></th>
                                            <th><strong>Fecha Expiración Norma</strong></th>
                                            <th><strong>Seleccionar</strong></th>
                                        </tr></thead>
                                    <tbody>
                                    </tbody>

                                    <?php
                                    $query = "SELECT 
   m.codigo_mesa CODIGO_MESA   ,
   m.nombre_mesa NOMBRE_MESA , 
   n.codigo_norma   CODIGO_NORMA ,
   n.version_norma  VERSION_NORMA ,
   n.titulo_norma TITULO_NORMA ,
   TO_CHAR(n.expiracion_norma,'dd/mm/yyyy') AS EXPIRACION,
   n.id_norma ID_NORMA
FROM norma n
INNER JOIN mesa m ON n.codigo_mesa =  m.codigo_mesa";
                                    $statement = oci_parse($connection, $query);
                                    oci_execute($statement);
                                    $numero = 0;
                                    while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                        echo "<tr><td width=\"\"><font face=\"verdana\">" .
                                        $row["CODIGO_MESA"] . "</font></td>";
                                        echo "<td width=\"\"><font face=\"verdana\">" .
                                        $row["NOMBRE_MESA"] . "</font></td>";
                                        echo "<td width=\"\"><font face=\"verdana\">" .
                                        $row["CODIGO_NORMA"] . "</font></td>";
                                        echo "<td width=\"\"><center><font face=\"verdana\">" .
                                        $row["VERSION_NORMA"] . "</font></center></td>";
                                        echo "<td width=\"\"><font face=\"verdana\">" .
                                        utf8_encode($row["TITULO_NORMA"]) . "</font></td>";
                                        echo "<td width=\"\"><font face=\"verdana\">" .
                                        $row["EXPIRACION"] . "</font></td>";

                                        $date1 = $row["EXPIRACION"];
                                        $date2 = date("d/m/y");

                                        // Compara Fechas

                                        $d = restaFechas($date2, $date1);

                                        if ($d > 240) {
                                            ?>
                                            <td width=""><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                            <input type="hidden" name="usuario" value="<?php echo $login ?>" ></input>
                                            <?php
                                        } else if ($d <= 240) {
                                            ?>
                                            <td width=""><input name="codigo[]" disabled="disabled" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                            <input type="hidden" name="usuario" value="<?php echo $login ?>" ></input>       
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        $numero++;
                                    }
                                    oci_close($connection);
                                    ?>
                                </table>
                                <?php
                            } else if ($unidad == 2) {
                                ?>
                                <a id="cleanfilters" href="#">Limpiar Filtros</a>
                                <br></br>
                                <center>
                                    <table id="demotable1" >
                                        <thead><tr>
                                                <th><strong>Código Mesa</strong></th>
                                                <th><strong>Nombre Mesa</strong></th>
                                                <th><strong>Código Norma</strong></th>
                                                <th><strong>Versión Norma</strong></th>
                                                <th><strong>Título Norma</strong></th>
                                                <th><strong>Fecha Expiración Norma</strong></th>
                                                <th><strong>Seleccionar</strong></th>
                                            </tr></thead>
                                        <tbody>
                                        </tbody>

                                        <?php
                                        $query = "SELECT 
   m.codigo_mesa CODIGO_MESA   ,
   m.nombre_mesa NOMBRE_MESA , 
   t.codigo_titulacion  CODIGO_TITULACION ,
   t.vrs_titulacion  VERSION_TITULACION ,
   t.nombre_titulacion NOMBRE_TITULACION ,
   TO_CHAR(t.expiracion,'dd/mm/yyyy') AS EXPIRACION
FROM titulacion t
INNER JOIN mesa m ON SUBSTR(t.codigo_titulacion,2,5) =  m.codigo_mesa";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);
                                        $numero = 0;
                                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                            echo "<tr><td width=\"\"><font face=\"verdana\">" .
                                            $row["CODIGO_MESA"] . "</font></td>";
                                            echo "<td width=\"\"><font face=\"verdana\">" .
                                            $row["NOMBRE_MESA"] . "</font></td>";
                                            echo "<td width=\"\"><font face=\"verdana\">" .
                                            $row["CODIGO_TITULACION"] . "</font></td>";
                                            echo "<td width=\"\"><center><font face=\"verdana\">" .
                                            $row["VERSION_TITULACION"] . "</font></center></td>";
                                            echo "<td width=\"\"><font face=\"verdana\">" .
                                            utf8_encode($row["NOMBRE_TITULACION"]) . "</font></td>";
                                            echo "<td width=\"\"><font face=\"verdana\">" .
                                            $row["EXPIRACION"] . "</font></td>";

                                            $date1 = $row["EXPIRACION"];
                                            $date2 = date("d/m/y");

                                            // Compara Fechas

                                            $d = restaFechas($date2, $date1);

                                            if ($d > 240) {
                                                ?>
                                                <td width=""><input name="codigo[]" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                                <input type="hidden" name="usuario" value="<?php echo $login ?>" ></input>
                                                <?php
                                            } else if ($d <= 240) {
                                                ?>
                                                <td width=""><input name="codigo[]" disabled="disabled" type="checkbox" value="<?php echo $row["ID_NORMA"]; ?>"><br /></input></td></tr>
                                                <input type="hidden" name="usuario" value="<?php echo $login ?>" ></input>       
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            $numero++;
                                        }
                                        oci_close($connection);
                                        ?>
                                    </table>
                                    <?php
                                } else if ($unidad == 3) {

                                    echo "Catálogo No Disponible";
                                } else if ($unidad == 4) {

                                    echo "Catálogo No Disponible";
                                }
                                ?>
                                <br></br>
                                <p><label>
                                        <input type="submit" onclick="return validarv();" name="insertar" id="insertar" value="Siguiente" accesskey="I" />
                                    </label></p>
                                <br></br>

                                </form>
                            </center>
                            </div>
                            </div>
                            <?php include ('layout/pie.php') ?>
                            </body>
                            </html>