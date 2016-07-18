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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_candidatos_proyecto_c.js"></script>
        <script src="ajax.js"></script>
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
                ?>
                <br>
                <center><strong>Información Candidato del Proyecto</strong></center>
                </br>
                <center><strong>NOTA: Solo se pueden asociar aspirantes registrados </strong></center>
                <br>
                <form name="formmapa" id="f1" action="guardar_depto_c.php?proyecto=<?php echo $proyecto ?>" method="post" accept-charset="UTF-8" >
                    <table width="200" border="1" color="#99CCCC" align="center">
                        <th colspan="2">Registrar Nuevo Usuario</th>
                        <tr>
                            <td>ID</td>
                            <?php
                            if ($_GET["id"] == null) {
                                ?>
                                <td><input name="id" type="text" readonly value="NO DISPONIBLE "></input>
                                    <?php
                                } else {
                                    ?>
                                <td><input name="id" type="text" readonly value="<?php echo $_GET["id"] ?>"></input>
                                    <?php
                                }
                                ?>

                        </tr>
                        <tr>
                            <td>Documento o Email</td>
                            <td><input name="documento" id="documento" onKeyPress="return validar(event)" type="text" value="<?php echo $_GET["documento"] ?>">
                                </input>
                                <input type="button" value="Validar Usuario" onkeypress="validar();" class="botones" onClick="window.location = 'validar_doc_c.php?proyecto=<?php echo $proyecto ?>&doc=' + document.getElementById('documento').value"></input><br>
                                <div class="letraRoja">
                                    <?php
                                    if ($_GET["id"] == "") {
                                        echo "El usuario no existe en el sistema.";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Nombre(s)</label></td>
                            <td><input name="nombre" type="text" readonly value="<?php echo utf8_encode($_GET["nombre"]) ?>"></input>
                        </tr>
                        <tr>
                            <td><label>Primer Apellido</label></td>
                            <td><input name="apellido" type="text" readonly value="<?php echo utf8_encode($_GET["apellido"]) ?>"></input>
                        </tr>
                        <tr>
                            <td><label>Segundo Apellido</label></td>
                            <td><input name="apellido2" type="text" readonly value="<?php echo utf8_encode($_GET["apellido2"]) ?>"></input>
                        </tr>
                        <?php
                        $query2 = ("SELECT * FROM DEPARTAMENTO");
                        $statement2 = oci_parse($connection, $query2);
                        oci_execute($statement2);
                        ?>
                        <tr>
                            <td>Departamento en donde labora</td>
                            <td><select id="cont" name="departamento" onchange="load(this.value)">

                                    <option value="">Seleccione</option>

                                    <?php
                                    while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                        ?>

                                        <option value="<?php echo $row[ID_DEPARTAMENTO]; ?>"><?php echo utf8_encode($row[NOMBRE_DEPARTAMENTO]); ?></option>

                                    <?php } ?>

                                </select>


                            </td>
                        </tr>
                        <tr><td>Municipio en donde labora</td><td><div id="myDiv"></div></td></tr>
                        <tr><td></td><td rowspan="2">
                                <?php
                                if ($_GET["nombre"] == 'No Registrado' || $_GET["nombre"] == null || $_GET["id"] == null) {
                                    ?>
                                    <p><label>
                                            <input type="submit" disabled="disabled" onclick="return validarv();" name="Guardar" id="insertar" value="Guardar Ubicación" accesskey="I" />
                                        </label></p></td></tr>
                        <?php } else {
                            ?>
                            <p><label>
                                    <input type="submit" onclick="return validarv();" name="Guardar" id="insertar" value="Guardar Ubicación" accesskey="I" />
                                </label></p></td></tr>
                            <?php
                        }
                        ?>
                    </table>
                    <br></br>

                    <?php
                    if ($_GET["nombre"] == 'No Registrado' || $_GET["nombre"] == null || $_GET["id"] == null) {

                        echo "No Disponible";
                    } else {
                        ?>
                        <a href="../Presentacion/candidatoncl_c.php?id=<?php echo $_GET["id"] ?>&proyecto=<?php echo $proyecto ?>">Asociar Normas</a></center></center>
                        <?php
                    }
                    ?>
                </form>
                <br>
                <center><a href="verproyectos_c.php"> Siguiente     </a></center>
                </br>

                <center><form>
                        <table>
                            <tr>
                                <th>Tipo Documento</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Normas Asociadas</th>
                                <th>Eliminar Candidato</th>
                            </tr>

                            <?php
                            $query = "SELECT DISTINCT u.tipo_doc, u.documento,
                        u.nombre, u.primer_apellido,u.segundo_apellido,u.usuario_id, I.ESTADO
                        FROM usuario u
                        INNER JOIN candidatos_proyecto  cp
                        ON (cp.id_candidato = u.usuario_id)
                        LEFT JOIN INSCRIPCION I
                        ON(I.ID_CANDIDATO=U.USUARIO_ID
                            AND 
                            I.ID_PROYECTO=CP.ID_PROYECTO
                            AND 
                            I.ESTADO='1'
                            
                        )
                        WHERE cp.id_proyecto = '$proyecto' ORDER BY u.primer_apellido ASC";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {


                                if ($row["TIPO_DOC"] == 1) {
                                    $e = "TI";
                                } else if ($row["TIPO_DOC"] == 2) {
                                    $e = "CC";
                                } else {
                                    $e = "CE";
                                }


                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $e . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["DOCUMENTO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                utf8_encode($row["NOMBRE"] ). "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                utf8_encode($row["PRIMER_APELLIDO"] ). "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                utf8_encode($row["SEGUNDO_APELLIDO"] ). "</font></td>";
                                echo "<td width=\"15%\"><a href=\"./candidato_ncl_c.php?proyecto=" . $proyecto . "&documento=" . $row["USUARIO_ID"] . "\" TARGET=\"_blank\">
                                Ver</a></td>";
//                                if ($obs[0] == 0) {
//
//                                    echo "<td width=\"15%\"><a href=\"./eliminar_candidato.php?proyecto=" . $proyecto . "&id=" . $row["USUARIO_ID"] . "\" >
//                                Eliminar</a></td></tr>";
//                                } else {
//
//                                    echo "<td width=\"15%\">No Disponible</td></tr>";
//                                }
                                if ($row[ESTADO] != 1) {

                                    echo "<td width=\"15%\"><a href=\"./eliminar_candidato.php?proyecto=" . $proyecto . "&id=" . $row["USUARIO_ID"] . "\" >
                                Eliminar</a></td></tr>";
                                } else {

                                    echo "<td width=\"15%\">El candidato ya está formalizado no se puede eliminar</td></tr>";
                                }



                                $numero++;
                            }
                            ?>
                        </table><br></br>
                    </form></center>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>