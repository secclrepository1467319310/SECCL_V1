<?php
session_start();
if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="js/val_crear_grupo.js" type="text/javascript"></script>
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
        <div id="contenedorcito" >
            <br>
            <center><h1>Edición de Grupos</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];
            $g = $_GET['grupo'];

            $query34 = ("select codigo_norma from norma where id_norma='$idnorma'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $norma = oci_fetch_array($statement34, OCI_BOTH);
            $f = date('d/m/Y');

            $queryAuto = "SELECT * FROM T_NOVEDADES_GRUPOS WHERE ID_PROYECTO=$proyecto AND N_GRUPO=$g AND ID_NORMA=$idnorma AND ESTADO_REGISTRO = 1 AND TIPO_NOVEDAD=2";
            $statementAuto = oci_parse($connection, $queryAuto);
            oci_execute($statementAuto);
            $numAuto = oci_fetch_all($statementAuto, $rowAuto);
            ?>
            <?php
            if ($_GET['mensaje'] == 1)
            {
                ?>
                <div class="mensaje">La actualización se realizo Correctamente. </div>
                <?php
            }
            elseif ($_GET['mensaje'] == 2)
            {
                if ($numAuto > 0)
                {
                    $minimo = 10;
                }
                else
                {
                    $minimo = 20;
                }
                ?>
                <div style="font-weight: bold; font-size: 16px; color: red">El grupo debe tener como Mínimo <?php echo $minimo ?> candidatos y Máximo 40 </div>
                <?php
            }
            elseif ($_GET['mensaje'] == 3)
            {
                ?>
                <div style="font-weight: bold; font-size: 16px; color: red">Los usuarios con cédula: <?php echo $_GET['candidatos'] ?> ya tiene evidencias registradas, por lo cual es invalido eliminarlos del grupo. </div>
            <?php } ?>
            <div class='proyecto'>
                <center>
                    <form>
                        <fieldset>
                            <legend><strong>Información General del Grupo</strong></legend>
                            <table id="demotable1">
                                <tr>
                                    <th><strong>Proyecto</strong></th>
                                    <td><input name="proyecto" type="text" readonly="readonly" value="<?php echo $proyecto ?>" ></td>
                                    <th><strong>Norma</strong></th>
                                    <td><input name="n" type="text" readonly="readonly" value="<?php echo $norma[0] ?>" ></td>
                                <input type="hidden" name="norma" value="<?php echo $idnorma ?>" ></input>       
                                </tr>
                                <tr>
                                    <th><strong>Fecha</strong></th>
                                    <td><input name="fecha" type="text" readonly="readonly" value="<?php echo $f ?>" ></td>
                                    <th><strong>Grupo N°</strong></th>
                                    <td>
                                        <Select Name="grupo" style=" width:150px" onChange="this.form.submit()" >

                                            <?PHP
                                            $query22 = ("select unique n_grupo from proyecto_grupo where id_proyecto='$proyecto'");

                                            $statement22 = oci_parse($connection, $query22);
                                            oci_execute($statement22);
                                            echo "<OPTION>", "Seleccione", "</OPTION>";
                                            while ($row = oci_fetch_array($statement22, OCI_BOTH))
                                            {
                                                $id_m = $row["N_GRUPO"];
                                                echo "<OPTION value=" . $id_m . ">", $row["N_GRUPO"], "</OPTION>";
                                            }
                                            ?>

                                        </Select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                    <br>
                    <fieldset>
                        <?php ?>
                        <legend><strong>Cronograma del Grupo</strong></legend>
                        <br>
                        <center><a href="cronograma_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">Diligenciar Cronograma</a></center>
                        <br>
                        <table>
                            <tr>
                                <th><font face = "verdana"><b>ID CRONO</b></font></th>
                                <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                                <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                            </tr>
                            <?php
                            $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ESTADO='1'  ORDER BY FECHA_INICIO ASC";
                            $statement21 = oci_parse($connection, $query21);
                            oci_execute($statement21);
                            $numero21 = 0;
                            while ($row = oci_fetch_array($statement21, OCI_BOTH))
                            {
                                ?>
                                <tr>
                                    <?php
                                    $query3 = ("SELECT descripcion from actividades where id_actividad =  '$row[ID_ACTIVIDAD]'");
                                    $statement3 = oci_parse($connection, $query3);
                                    $resp3 = oci_execute($statement3);
                                    $des = oci_fetch_array($statement3, OCI_BOTH);
                                    ?>
                                    <td><?php echo $row["ID_CRONOGRAMA_GRUPO"]; ?></td>
                                    <td><?php echo utf8_encode($des[0]); ?></td>
                                    <td><?php echo $row["FECHA_INICIO"]; ?></td>
                                    <td><?php echo $row["FECHA_FIN"]; ?></td>
                                    <td><?php echo $row["RESPONSABLE"]; ?></td>
                                    <td><?php echo $row["OBSERVACIONES"]; ?></td>
                                </tr>
                                <?php
                                $numero21++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br>

                    <form action="guardar_edicion_grupo.php" method="post" name="f2" id="f2">
                        <input type="hidden" name="auto_grupo" id="auto_grupo" value="<?php echo $numAuto ?>" />
                        <?php
                        if ($_GET['grupo'])
                        {
                            ?>
                            <fieldset>
                                <legend><strong>Evaluador</strong></legend>
                                <table>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Apellido</th>
                                        <th>Segundo Apellido</th>
                                        <th>Nombre</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                    <?php
                                    $query1 = ("select id_evaluador from evaluador_proyecto where id_proyecto='$proyecto' and id_norma='$idnorma'");
                                    $statement1 = oci_parse($connection, $query1);
                                    oci_execute($statement1);
                                    $numero3 = 0;
                                    while ($row3 = oci_fetch_array($statement1, OCI_BOTH))
                                    {
                                        $query2 = "SELECT USUARIO_ID,DOCUMENTO,PRIMER_APELLIDO,SEGUNDO_APELLIDO,NOMBRE FROM USUARIO WHERE DOCUMENTO='$row3[ID_EVALUADOR]'";
                                        $numero3++;

                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);
                                        $numero2 = 0;
                                        while ($row = oci_fetch_array($statement2, OCI_BOTH))
                                        {
                                            ?>

                                            <tr>
                                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                                <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                                <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                                <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                                <?php
                                                $grupoProyecto = $_GET['grupo'];
                                                $query11 = ("SELECT * FROM EVIDENCIAS_CANDIDATO WHERE ESTADO > 0 AND (ID_NORMA,ID_CANDIDATO) IN (
                                                                SELECT ID_NORMA,ID_CANDIDATO FROM PROYECTO_GRUPO WHERE ID_NORMA = '$idnorma' AND ID_PROYECTO = '$proyecto' AND N_GRUPO = '$grupoProyecto')");
                                                $statement11 = oci_parse($connection, $query11);
                                                $resp11 = oci_execute($statement11);
                                                $control = oci_fetch_array($statement11, OCI_BOTH);

                                                $query112 = ("SELECT DISTINCT(ID_EVALUADOR) FROM PROYECTO_GRUPO WHERE ID_NORMA = '$idnorma' AND ID_PROYECTO = '$proyecto' AND N_GRUPO = '$grupoProyecto'");
                                                $statement112 = oci_parse($connection, $query112);
                                                oci_execute($statement112);

                                                if ($control[0] == 0)
                                                {
                                                    ?>
                                                    <td><input name="evaluador" type="radio" value="<?php echo $row["USUARIO_ID"]; ?>" <?php
                                                        while ($rowEvaluador = oci_fetch_array($statement112, OCI_BOTH))
                                                        {
                                                            if ($rowEvaluador['ID_EVALUADOR'] == $row["USUARIO_ID"])
                                                            {
                                                                echo 'checked';
                                                            }
                                                        }
                                                        ?>/><br /></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                    <td><input name="evaluador"  type="hidden" value="<?php echo $row["USUARIO_ID"]; ?>" <?php
                                                        while ($rowEvaluador = oci_fetch_array($statement112, OCI_BOTH))
                                                        {
                                                            if ($rowEvaluador['ID_EVALUADOR'] == $row["USUARIO_ID"])
                                                            {
                                                                echo 'checked';
                                                            }
                                                        }
                                                        ?>/><br /> Ya existen valoraciones registradas,<br> no se puede cambiar el evaluador</td>
                                                        <?php
                                                    }
                                                    ?>
                                            </tr>
                                            <?php
                                            $numero2++;
                                        }
                                    }
                                    ?>
                                </table>
                            <?php } ?>

                        </fieldset>
                        <br>
                        <div style="font-weight: bold; font-size: 16px"><label class='errorVal'></label></div>
                        <fieldset>
                            <legend><strong>Editar Candidatos</strong></legend>
                            <?php
                            if ($_GET['grupo'])
                            {
                                $query212 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$_GET[grupo]' ORDER BY TOB.ID_OPERACION DESC";
                                $statement212 = oci_parse($connection, $query212);
                                oci_execute($statement212);
                                $respSolicitud = oci_fetch_all($statement212, $results);

                                if ($respSolicitud > 0)
                                {
                                    $query222 = "SELECT ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO "
                                            . "FROM T_ESTADO_SOLICITUD ES "
                                            . "INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
                                            . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD = " . $results[ID_OPERACION][0] . ")";
                                    $statement222 = oci_parse($connection, $query222);
                                    $execute222 = oci_execute($statement222, OCI_DEFAULT);
                                    $numRows222 = oci_fetch_all($statement222, $rows222);
                                }



                                if ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 || $respSolicitud < 1)
                                {
                                    ?>

                                    <input type="hidden" name="idnorma" value="<?php echo $idnorma ?>" />
                                    <input type="hidden" name="proyecto" value="<?php echo $proyecto ?>" />
                                    <input type="hidden" name="grupo" value="<?php echo $_GET['grupo'] ?>" />
                                    <table>
                                        <tr>
                                            <th>N°</th>
                                            <th>Documento</th>
                                            <th>Apellido</th>
                                            <th>Segundo Apellido</th>
                                            <th>Nombre</th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        $query = "SELECT DISTINCT usuario.tipo_doc, usuario.documento,
                        usuario.nombre, usuario.primer_apellido,usuario.segundo_apellido,usuario.usuario_id
                        FROM usuario
                        INNER JOIN candidatos_proyecto 
                        ON candidatos_proyecto.id_candidato = usuario.usuario_id
                        WHERE candidatos_proyecto.id_proyecto = '$proyecto' ORDER BY usuario.primer_apellido ASC";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);
                                        $numero = 0;
                                        while ($row = oci_fetch_assoc($statement))
                                        {

                                            $query_asoc_norma = ("select count(*) from proyecto_grupo where id_candidato='$row[USUARIO_ID]' and id_proyecto='$proyecto' and id_norma='$idnorma' and N_GRUPO != $g");
//                                    echo $query_asoc_norma;
                                            $statement_asoc_norma = oci_parse($connection, $query_asoc_norma);
                                            $resp_asoc_norma = oci_execute($statement_asoc_norma);
                                            $control_norma = oci_fetch_assoc($statement_asoc_norma);
                                            if ($control_norma['COUNT(*)'] == 0)
                                            {

                                                $queryasociados = ("select count(*) from proyecto_grupo where id_candidato=$row[USUARIO_ID] and id_proyecto='$proyecto' and id_norma='$idnorma' and N_GRUPO=$g");
                                                $statementasociados = oci_parse($connection, $queryasociados);
                                                $respasociados = oci_execute($statementasociados);
                                                $control = oci_fetch_assoc($statementasociados);
                                                if ($control['COUNT(*)'] == 0)
                                                {
                                                    $respuesta = "<input name='usuario[]' type='checkbox' value='$row[USUARIO_ID]'>";
                                                }
                                                else
                                                {
                                                    $respuesta = "<input name='usuario[]' type='checkbox' value='$row[USUARIO_ID]' checked='checked'>";
                                                }
                                            }
                                            else
                                            {
                                                $respuesta = "Se encuentra en otro grupo con la misma norma";
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $numero + 1; ?></td>
                                                <td><?php echo $row["DOCUMENTO"]; ?></td>
                                                <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                                <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                                <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                                <td><?php echo $respuesta; ?></td>
                                            </tr>
                                            <?php
                                            $numero++;
                                        }
                                        ?>
                                    </table>
                                    <input type="submit" value="Actualizar"/>
                            </form>
                            <?php
                        }
                        else
                        {
                            echo "Ya se envio solicitud de instrumentos, no se puede editar el grupo.";
                        }
                    }
                    ?>
                    </fieldset>
                </center>
            </div>
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