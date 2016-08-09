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
            <div id="contenedorcito">
                <?php
                $proyecto = $_GET["proyecto"];

                $query1 = ("select id_provisional from proyecto where id_proyecto=  '$proyecto'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $prov = oci_fetch_array($statement1, OCI_BOTH);

                $query3 = ("select count(*) from obs_banco where id_provisional=  '$prov[0]'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $obs = oci_fetch_array($statement3, OCI_BOTH);
                ?>
                <br>
                <center><strong>Evaluador(es) del Proyecto</strong></center>
                </br>

                <form name="formmapa" action="guardar_evaluador_c.php?proyecto=<?php echo $proyecto ?>" 
                      method="post" accept-charset="UTF-8" enctype="multipart/form-data" >

                    <center>
                        <table id='demotable1'>
                            <tr>
                                <th><label>ID</label></th>
                                <td><input name="id" type="text" readonly value="<?php echo $_GET["id"] ?>"></input>
                            </tr>

                            <tr>
                                <th>Número de Documento</th>
                                <td><input name="documento" id="documento" maxlength="15" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["documento"] ?>">
                                    </input>
                                    <input type="button" value="Validar doc" onkeypress="validar();" class="botones" onClick="window.location = 'validar_doc_ev.php?proyecto=<?php echo $proyecto ?>&doc=' + document.getElementById('documento').value"></input><br>
                                    <?php
                                    if ($_GET["id"] == null) {
                                        ?>
                                                        <!--<a href="registrar_ev.php?proyecto=<?php echo $proyecto ?>&documento=<?php echo $_GET["documento"] ?>">Registrar Evaluador</a>-->
                                    <?php } else if ($_GET["id"] == null || $_GET["estado"] == 4) {
                                        ?><a>Evaluador Regisrado</a><?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><label>Nombre(s)</label></th>
                                <td><input name="nombre" type="text" readonly value="<?php echo $_GET["nombre"] ?>"></input>
                            </tr>
                            <tr>
                                <th><label>Email</label></th>
                                <td><input name="email" type="text" readonly value="<?php echo $_GET["email"] ?>"></input>
                            </tr>
                            <tr>
                                <th><label>Estado</label></th>
                                <?php if ($_GET["estado"] == 1) { ?>
                                    <td><input name="estado" type="text" readonly value="<?php echo "Activo" ?>"></input></td>
                                <?php } else if ($_GET["estado"] == 0) { ?>
                                    <td><input name="estado" type="text" readonly value="<?php echo "Inactivo" ?>"></input></td>
                                <?php } else if ($_GET["estado"] == 3) { ?>
                                    <td><input name="estado" type="text" readonly value="<?php echo "Postulado" ?>"></input></td>
                                <?php } else if ($_GET["estado"] == 5) { ?>
                                    <td><input name="estado" type="text" readonly value="<?php echo "En Actualización" ?>"></input></td>
                                <?php } else if ($_GET["estado"] == 6) { ?>
                                    <td><input name="estado" type="text" readonly value="<?php echo "Retirado" ?>"></input></td>
                                <?php } ?>
                            </tr>
                        </table>
                    </center>
                    <br></br>
                    <a href = "verproyectos_c.php"> Siguiente </a>
                    <br></br>
                    <?php
                    $d = $_GET["documento"];
                    if ($_GET["documento"] != null) {


                        ///Botón
                        $btnactivado=false;
                        ?>

                        <br>
                        <center><strong>Normas en las que Puede Evaluar Dentro del Proeyecto</strong></center>
                        <br>
                        <table id="demotable1">
                            <thead><tr>
                                    <th><strong>ID</strong></th>
                                    <th><strong>Código Norma</strong></th>
                                    <th><strong>Versión</strong></th>
                                    <th><strong>Título Norma</strong></th>
                                    <th><strong>Seleccionar</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $query8 = ("SELECT ID_PROVISIONAL FROM PROYECTO WHERE ID_PROYECTO='$proyecto'");
                            $statement8 = oci_parse($connection, $query8);
                            $resp8 = oci_execute($statement8);
                            $pro = oci_fetch_array($statement8, OCI_BOTH);

                            $q = "select id_norma from detalles_poa where id_provisional='$pro[0]'";
                            $statement3 = oci_parse($connection, $q);
                            oci_execute($statement3);
                            $numero3 = 0;
                            while ($row3 = oci_fetch_array($statement3, OCI_BOTH)) {

                                $query = "select 
                                        ev.id_norma,codigo_norma,
version_norma,
titulo_norma
from  evaluador_norma ev
inner join norma n
on n.id_norma=ev.id_norma
inner join detalles_poa dp
on dp.id_norma=ev.id_norma
where ev.id_evaluador='$d' and dp.id_provisional='$pro[0]'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                $numero3++;
                            }
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["ID_NORMA"] . "</font></td>";
                                echo "<td width=\"5%\"><font face=\"verdana\">" .
                                $row["CODIGO_NORMA"] . "</font></td>";
                                echo "<td width=\"2%\"><font face=\"verdana\">" .
                                $row["VERSION_NORMA"] . "</font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\">" .
                                utf8_encode($row["TITULO_NORMA"]) . "</font></td>";

                				$qyaasociado="SELECT * FROM EVALUADOR_PROYECTO WHERE ID_EVALUADOR='$_GET[documento]' AND ID_PROYECTO='$proyecto' AND ID_NORMA=$row[ID_NORMA]";
                				$syaasociado=oci_parse($connection,$qyaasociado);
                				oci_execute($syaasociado);
                				$ryaasociado=oci_fetch_array($syaasociado,OCI_NUM);
//                                $btnactivado=!$ryaasociado?true:false;
				if(!$ryaasociado){
                                    $btnactivado=true;
                                }
                                ?>

                                <td width="10%"><?php echo $ryaasociado?'YA ASOCIADA':'<input name="codigo[]" type="checkbox" value="'.$row["ID_NORMA"].'"><br /></input>'?></td></tr>

                                <?php
                                $numero++;
                            }
                            ?>
                        </table>
                        <br></br>
                        <center><input name="send" type="submit" id="send" value="Asociar" <?php echo $btnactivado?'':'disabled'?>></input></center>
                        <br></br>
                        <a href="verproyectos_c.php"> Siguiente     </a>

                    </form>
                    <?php
                } else {
                    echo "No es Posible Asociar Normas";
                }
                ?>

                <br></br>
                <center><strong>Información de Evaluadores</strong></center><br>
                <table align="center" border="1" cellspacing=1 cellpadding=2 style="font-size: 10pt"><tr>


                    <tr>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Email </th>
                        <th>Email Personal</th>
                        <th>Celular</th>
                        <th>Teléfono</th>
                        <th>Certificado como Evaluador</th>
                        <th>Número de Certificado</th>
                        <th>Quitar Evaluador</th>
                        <!--<th>Descargar Hoja de vida</th>-->
                    </tr>
                    <?php
                    $query333 = ("SELECT DISTINCT ID_EVALUADOR FROM EVALUADOR_PROYECTO WHERE ID_PROYECTO =  '$proyecto'");
                    $statement333 = oci_parse($connection, $query333);
                    oci_execute($statement333);
                    $num = 0;
                    while ($row333 = oci_fetch_array($statement333, OCI_BOTH)) {

                        $query = "SELECT * FROM EVALUADOR WHERE DOCUMENTO=$row333[ID_EVALUADOR]";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $numero = 0;
                        while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                            ?>
                            <tr><?php
                                if ($row["T_DOCUMENTO"] == 1) {
                                    $e = "TI";
                                } else if ($row["T_DOCUMENTO"] == 2) {
                                    $e = "CC";
                                } else {
                                    $e = "CE";
                                }

                                if ($row["CERTIFICADO"] == 1) {
                                    $c = "Si";
                                } else {
                                    $c = "No";
                                }
                                ?>

                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                <td><?php echo $row["NOMBRE"]; ?></td>
                                <td><?php echo $row["EMAIL"]; ?></td>
                                <td><?php echo $row["EMAIL2"]; ?></td>
                                <td><?php echo $row["CELULAR"]; ?></td>
                                <td><?php echo $row["IP"]; ?></td>
                                <td><?php echo $c; ?></td>
                                <td><?php echo $row["N_CERTI"]; ?></td>
                                <?php
                                if ($obs[0] == 0) {
                                    ?>
                                    <td align="right"><a href="eliminar_evaluador.php?id=<?php echo $row["DOCUMENTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td align="right"><a href="eliminar_evaluador.php?id=<?php echo $row["DOCUMENTO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                    <!--<td align="right">No Disponible</td>-->
                                    <?php
                                }
                                ?>

                        <!--                                <td><a href="descargar.php?id=<?php echo $row["ID_EVALUADOR"] ?>">Descargar</a></td>-->

                            </tr>


                            <?php
                            $num++;
                        }
                        $numero++;
                    }
                    ?>


                </table>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>