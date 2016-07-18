
<!--BACKUP DE CONSULTAR GRUPO 05062015-->
﻿<?php
//Consultar_Grupo (lider)
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
Plantilla modificada por: Ing. Jhonatan Andrí©s Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
íºltima actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/jquery.validate.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="js/validar_textarea.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                $('#f1').validate({
                    //ignore: [],
                    rules: {
                        "ddlTipoDescripcion": {
                            required: true,
                            min: 1
                        }
                    },
                    messages: {
                        "ddlTipoDescripcion": {
                            required: 'Campo obligatorio',
                            min: "Debe seleccionar una opción"
                        }
                    }
                });

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
            <center><h1>Consulta de Grupos</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];
            $g = $_GET['grupo'];

            $query34 = ("select codigo_norma, version_norma from norma where id_norma='$idnorma'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $norma = oci_fetch_array($statement34, OCI_BOTH);
            $f = date('d/m/Y');
            ?>
            <div class='proyecto'>
                <center>
                    <form class="grupo">
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
                                    <th><strong>Grupo NÂ°</strong></th>
                                    <td>
                                        <Select Name="grupo" style=" width:150px" onChange="this.form.submit()" >
                                            <option>Seleccione</option>;
                                            <?PHP
                                            $query22 = ("select unique n_grupo from proyecto_grupo where id_proyecto='$proyecto'");

                                            $statement22 = oci_parse($connection, $query22);
                                            oci_execute($statement22);

                                            while ($row = oci_fetch_array($statement22, OCI_BOTH))
                                            {
                                                if ($_GET['grupo'] == $row["N_GRUPO"])
                                                {
                                                    $seleccion = "selected='selected'";
                                                }
                                                else
                                                {
                                                    $seleccion = "";
                                                }
                                                $id_m = $row["N_GRUPO"];
                                                echo "<option value=" . $id_m . " $seleccion >" . $row["N_GRUPO"] . "</option>";
                                            }
                                            ?>

                                        </Select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                    <br>
                    <?php
                    if ($g && $g != 'Seleccione')
                    {
                        ?>
                        <fieldset>
                            <legend><strong>Generar Reportes</strong></legend>
                            <table id="demotable1">
                                <tr>
                                    <th><strong>Tipo de Reporte</strong></th>
                                    <th><strong>Explicación</strong></th>
                                    <th><strong>Generar (dar clic en el icono)</strong></th>
                                </tr>
                                <tr>
                                    <td>Inscritos</td>
                                    <td>Este reporte nos genera el listado completo de personas inscritas en el proyecto, por Norma y por Grupo</td>
                                    <td><a  href="ExpInscritos.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">
                                            <img src="../images/excel.png" width="26" height="26"></img></a></td>
                                </tr>
                                <tr>
                                    <td>Emisión de Juicio</td>
                                    <td>Este reporte nos genera el listado completo de personas con emisión de Juicios y los que están Pendientes de la misma</td>
                                    <td><a  href="ExpJuicios.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">
                                            <img src="../images/excel.png" width="26" height="26"></img></a></td>
                                </tr>
                                <tr>
                                    <td>Certificados</td>
                                    <td>Este reporte nos genera el listado completo de personas Certificadas dentro del proyecto en una norma especí­fica y en un grupo</td>
                                    <td><a  href="ExpCertificados.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">
                                            <img src="../images/excel.png" width="26" height="26"></img></a></td>
                                </tr>
				    <!--Reporte modificado de emisión de juicio-
				    <tr>
                                    <td>Emisión de Juicio</td>
                                    <td>Este reporte es una modificación del reporte "emisión juicio"</td>
                                    <td><a  href="ExpEmJuicios.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">
                                            <img src="../images/excel.png" width="26" height="26"></img></a></td>
                                </tr>
				    <!--Reporte modificado de emisión de juicio-->
                            </table>
                        </fieldset>
                        <br>
                        <fieldset>

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
                                $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ESTADO='1' ORDER BY FECHA_INICIO ASC";
                                $statement21 = oci_parse($connection, $query21);
                                oci_execute($statement21);
                                $numero21 = 0;
//                                $activadoCro = 1;
//                                $mensajeCro = 'Para enviar la solicitud debe diligenciar en el cronograma del grupo las actividades de Valoración de Evidencia de Conocimiento, Valoración de Evidencia de Desempeí±o, Valoración de Evidencia de Producto y Emisión de Juicio';
                                while ($row = oci_fetch_array($statement21, OCI_BOTH))
                                {
//                                    if ($row['ID_ACTIVIDAD'] == 8 || $row['ID_ACTIVIDAD'] == 9 || $row['ID_ACTIVIDAD'] == 10 || $row['ID_ACTIVIDAD'] == 11) {
//                                        $activadoCro = 0;
//                                    }
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
                        <fieldset>
                            <legend><strong>Evaluador Asignado</strong></legend>
                            <?php
                            $query1 = ("select unique id_evaluador from proyecto_grupo where id_proyecto='$proyecto' and id_norma='$idnorma' and n_grupo='$g'");
                            $statement1 = oci_parse($connection, $query1);
                            $resp1 = oci_execute($statement1);
                            $ideva = oci_fetch_array($statement1, OCI_BOTH);
                            $query2 = "SELECT DOCUMENTO,PRIMER_APELLIDO,SEGUNDO_APELLIDO,NOMBRE FROM USUARIO WHERE USUARIO_ID='$ideva[0]'";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            
                            $queryRol = "SELECT ROL_ID_ROL FROM USUARIO WHERE USUARIO_ID='$id'";
                            $statementRol = oci_parse($connection, $queryRol);
                            oci_execute($statementRol);
                            $rowRol = oci_fetch_array($statementRol, OCI_BOTH);
                            $numero2 = 0;
                            while ($row = oci_fetch_array($statement2, OCI_BOTH))
                            {
                                ?>
                                <table>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Apellido</th>
                                        <th>Segundo Apellido</th>
                                        <th>Nombre</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $row["DOCUMENTO"]; ?></td>
                                        <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    </tr>
                                </table>
                                <?php
                                $numero2++;
                            }
                            ?>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><strong>Candidatos Asociados</strong></legend>
                            <table>
                                <tr>
                                    <th>N°</th>
                                    <th>Documento</th>
                                    <th>Apellido</th>
                                    <th>Segundo Apellido</th>
                                    <th>Nombre</th>
                                    <th>Juicio</th>
                                    <th>Ficha de Inscripción</th>
                                    <th>Novedades candidatos</th>
                                </tr>
                                <?php
                                $query = "SELECT ID_PLAN
                                    FROM PLAN_EVIDENCIAS
                                    WHERE ID_PROYECTO='$proyecto' AND ID_NORMA='$idnorma' AND GRUPO='$g'";
                                $statementPlan = oci_parse($connection, $query);
                                oci_execute($statementPlan);
                                oci_fetch_all($statementPlan, $output);

                                $query = "SELECT UNIQUE ID_CANDIDATO,DOCUMENTO,PRIMER_APELLIDO,SEGUNDO_APELLIDO,NOMBRE,USUARIO_ID
                                    FROM USUARIO U
                                    INNER JOIN PROYECTO_GRUPO PY ON PY.ID_CANDIDATO=U.USUARIO_ID
                                    WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma' AND N_GRUPO='$g'
                                    ORDER BY PRIMER_APELLIDO ASC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH))
                                {
                                    $query33 = ("select estado from evidencias_candidato
                                where id_plan='" . $output[ID_PLAN][0] . "' and id_norma='$idnorma' and id_candidato='$row[USUARIO_ID]'");
                                    $statement33 = oci_parse($connection, $query33);
                                    $resp33 = oci_execute($statement33);
                                    $estado = oci_fetch_array($statement33, OCI_BOTH);

                                    if ($estado[0] == 0)
                                    {
                                        $estadoNivel = 'Sin Juicio';
                                    }
                                    elseif ($estado[0] == 1)
                                    {
                                        $estadoNivel = 'Nivel Avanzado';
                                    }
                                    elseif ($estado[0] == 2)
                                    {
                                        $estadoNivel = 'Aun no competente';
                                    }
                                    elseif ($estado[0] == 3)
                                    {
                                        $estadoNivel = 'Nivel Intermedio';
                                    }
                                    elseif ($estado[0] == 4)
                                    {
                                        $estadoNivel = 'Nivel Básico';
                                    }
                                    ?>

                                    <tr>
                                        <td><?php echo $numero + 1; ?></td>
                                        <td><?php echo $row["DOCUMENTO"]; ?></td>
                                        <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                        <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                        <td><?php echo $estadoNivel ?></td>
                                        <td><a href="ficha_inscripcion_l.php?eva=<?php echo $ideva[0] ?>&norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>&idca=<?php echo $row["ID_CANDIDATO"]; ?>">Ver Ficha</a></td>
                                        <td><?php 
                                            $qnovedades_grupo = "SELECT TTN.TIPO_NOVEDAD, ID_T_NOVEDADES_GRUPO FROM T_NOVEDADES_CANDI_GRUP TTG 
                                                  JOIN T_TIPO_NOVEDADES TTN 
                                                  ON(TTG.TIPO_NOVEDAD=TTN.ID_T_TIPO_NOVEDADES)
                                                WHERE NORMA=$idnorma  AND GRUPO=$g  AND PROYECTO=$proyecto  AND USUARIO_CANDIDATO=".$row["ID_CANDIDATO"];
                                            $snovedades_grupo = oci_parse($connection, $qnovedades_grupo);
                                            oci_execute($snovedades_grupo);
                                            $rnovedades_grupo= oci_fetch_array($snovedades_grupo);
                                            if(!$rnovedades_grupo){
                                                ?>
                                                <a href="novedades_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>&idca=<?php echo $row["ID_CANDIDATO"]; ?>" target="_blank">Novedad de candidato</a>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <a href="consultar_novedad.php?id_novedad=<?php echo $rnovedades_grupo["ID_T_NOVEDADES_GRUPO"]; ?>" target="_blank"><?php echo $rnovedades_grupo["TIPO_NOVEDAD"]; ?></a>
                                                <?php
                                            }
                                        ?></td>                                        
                                    </tr>

                                    <?php
                                    $numero++;
                                }
                                ?>
                            </table>
                        </fieldset>
                        <HR/>
                        <fieldset>
                            <legend><strong>INFORMES CUALITATIVOS</strong></legend>
                                <?php 
                                $qparaPlan="SELECT * FROM PLAN_EVIDENCIAS PE
                                JOIN T_INFORME_CUALITATIVO_PROYECTO TICP ON 
                                (TICP.ID_PLAN_EVIDENCIAS=PE.ID_PLAN)
                                WHERE PE.ID_proyecto='$proyecto' AND PE.ID_NORMA='$idnorma' AND PE.grupo='$g'";
                                $sparaPlan=oci_parse($connection, $qparaPlan);
                                oci_execute($sparaPlan);
                                $rparaPlan=oci_fetch_array($sparaPlan,OCI_ASSOC);
                                
                                if(!$rparaPlan): ?>
                                    No disponible
                                <?php else:?>
                                   <a href="consulta_informe_cualitativo.php?id_plan=<?php echo $rparaPlan['ID_PLAN'] ?>" >INFORME</a>
                                   <hr/> 
                                <?php endif;?>
                        </fieldset>

                        <HR/>
                        <?php
                        $queryEvaluador = ("select COUNT(unique id_evaluador) AS NUMEVAL from proyecto_grupo where id_proyecto='$proyecto' and id_norma='$idnorma' and n_grupo='$g'");
                        $statementEvaluador = oci_parse($connection, $queryEvaluador);
                        oci_execute($statementEvaluador);
                        $numEva = oci_fetch_array($statementEvaluador, OCI_BOTH);

                        $queryCandidatos = "SELECT COUNT(UNIQUE ID_CANDIDATO) AS NUMCAND FROM USUARIO U INNER JOIN PROYECTO_GRUPO PY ON PY.ID_CANDIDATO=U.USUARIO_ID WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma' AND N_GRUPO='$g' ";
                        $statementCandidatos = oci_parse($connection, $queryCandidatos);
                        oci_execute($statementCandidatos);
                        $numCandidatos = oci_fetch_array($statementCandidatos, OCI_BOTH);

                        $queryFormalizados = "SELECT USU.DOCUMENTO, USU.NOMBRE, USU.PRIMER_APELLIDO, USU.SEGUNDO_APELLIDO FROM PROYECTO_GRUPO PG 
LEFT JOIN INSCRIPCION INS
ON PG.ID_CANDIDATO = INS.ID_CANDIDATO 
AND PG.ID_NORMA = INS.ID_NORMA 
AND PG.ID_PROYECTO = INS.ID_PROYECTO
AND PG.N_GRUPO = INS.GRUPO
INNER JOIN USUARIO USU
ON PG.ID_CANDIDATO = USU.USUARIO_ID
WHERE ((PG.ID_PROYECTO='$proyecto' AND PG.ID_NORMA='$idnorma' AND PG.N_GRUPO='$g') AND (INS.ESTADO = 0 OR INS.ESTADO IS NULL)) AND  PG.ID_CANDIDATO NOT IN (SELECT NG.USUARIO_CANDIDATO FROM T_NOVEDADES_CANDI_GRUP NG WHERE NG.PROYECTO='$proyecto' AND NG.GRUPO='$g' AND NG.NORMA='$idnorma')";
                        $statementFormalizados = oci_parse($connection, $queryFormalizados);
                        oci_execute($statementFormalizados);
                        $numCandidatosFor = oci_fetch_all($statementFormalizados, $rowCandidatosFor);

                        $queryInstrumentos = "SELECT COUNT(*) NUMINSTRUMENTOS FROM INSTRUMENTOS WHERE ID_NORMA = $norma[CODIGO_NORMA] AND VRS = $norma[VERSION_NORMA] AND OBSERVACIONES LIKE '%SI HAY INSTRUMENTOS%'";
                        $statementInstrumentos = oci_parse($connection, $queryInstrumentos);
                        oci_execute($statementInstrumentos);
                        $numInstrumentos = oci_fetch_array($statementInstrumentos, OCI_BOTH);

                        $queryProyectoC = "SELECT ID_REGIONAL, ID_CENTRO, SUBSTR(FECHA_ELABORACION, 7,4) AS FECHA, ID_PROYECTO FROM PROYECTO WHERE ID_PROYECTO='$proyecto'";
                        $statementProyectoC = oci_parse($connection, $queryProyectoC);
                        oci_execute($statementProyectoC);
                        $proyectoC = oci_fetch_array($statementProyectoC, OCI_BOTH);
                        ?>
                        <form action="generar_solicitud_instrumentos_l.php" method="post" id="f1">
                            <br><br>
                            <b>A partir de la fecha los requerimientos del Banco Nacional de Instrumentos registrados a través del aplicativo fuera de los horarios establecidos de atención, quedarán radicados con fecha y hora del dí­a hábil siguiente</b>
                            <br><br>
                            <fieldset><br>
                                <legend><strong>Solicitudes Banco Instrumentos</strong></legend>
                                <?php
                                $query23 = "SELECT count(*) AS NUMACT FROM CRONOGRAMA_GRUPO WHERE (ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma') AND (ID_ACTIVIDAD = 8 OR ID_ACTIVIDAD = 9 OR ID_ACTIVIDAD = 10 OR ID_ACTIVIDAD = 11)AND ESTADO='1' ";
                                $statement23 = oci_parse($connection, $query23);
                                oci_execute($statement23);
                                $rowActividad = oci_fetch_array($statement23, OCI_BOTH);

                                $queryActOpor = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ID_ACTIVIDAD = 20 AND ESTADO='1' ";
                                $statementActOpor = oci_parse($connection, $queryActOpor);
                                oci_execute($statementActOpor, OCI_DEFAULT);
                                $numActividadOpor = oci_fetch_all($statementActOpor, $rowActividadOpor);

                                $queryOperacionBanco = "SELECT * "
                                        . "FROM T_OPERACION_BANCO TOP "
                                        . "LEFT JOIN T_ESTADO_SOLICITUD TES"
                                        . " ON TOP.ID_OPERACION = TES.ID_SOLICITUD "
                                        . "WHERE TOP.ID_PROYECTO = '$proyecto' AND TOP.ID_NORMA = '$idnorma' AND TOP.N_GRUPO = '$g' ORDER BY TES.ID_ESTADO_SOLICITUD DESC";
                                $statementOperacionBanco = oci_parse($connection, $queryOperacionBanco);
                                oci_execute($statementOperacionBanco);
                                $numRowsOperacionBanco = oci_fetch_all($statementOperacionBanco, $rowsOperacionBanco);

                                $query212 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO, TOB.ID_T_OPERACION
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                                $statement212 = oci_parse($connection, $query212);
                                oci_execute($statement212);
                                $respSolicitud = oci_fetch_all($statement212, $results);
                                $ano = date('Y');
//                                echo '<pre>';
//                                var_dump($rowsOperacionBanco);
//                                echo "tipo ope: ".$rowsOperacionBanco['ID_T_OPERACION'][$numRowsOperacionBanco-1]."<br><br>";
//                                echo $rowsOperacionBanco['ID_T_OPERACION'][0];
//                                
//                                $rowsOperacionBanco['ID_TIPO_ESTADO_SOLICITUD'][0];
                                
                                if($rowRol['ROL_ID_ROL'] != 4){
                                    echo "<b style='color:red; font-size:15px'> Solo el rol lider puede realizar esta accion.</b> <br><br>";
                                }
                                else if (($rowsOperacionBanco['ID_T_OPERACION'][0] != 2 && ($rowsOperacionBanco['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 || $rowsOperacionBanco['ID_TIPO_ESTADO_SOLICITUD'][0] == 4)) || ($rowsOperacionBanco['ID_T_OPERACION'][0] == 2 && $rowsOperacionBanco['ID_TIPO_ESTADO_SOLICITUD'][0] == 4) || ($numRowsOperacionBanco < 1))
                                {
                                   if($numCandidatosFor > 0){
                                        echo "<b style='color:red; font-size:15px'> Debe formalizar la inscripción de los siguientes candidatos antes de enviar la solicitud.</b> <br><br>";
                                        $tabla = "<table>";
                                        $tabla .= "<tr>";
                                        $tabla .= "<th>Documento</th>";
                                        $tabla .= "<th>Nombre Completo</th>";
                                        $tabla .= "</tr>";
                                        for($i=0;$i<$numCandidatosFor;$i++){
                                            $tabla .= "<tr>";
                                            $tabla .= "<td>".$rowCandidatosFor['DOCUMENTO'][$i]."</td>";
                                            $tabla .= "<td>". $rowCandidatosFor['NOMBRE'][$i] . " " . $rowCandidatosFor['PRIMER_APELLIDO'][$i] . " " . $rowCandidatosFor['SEGUNDO_APELLIDO'][$i] ."</td>";
                                            $tabla .= "</tr>";
                                        }
                                        $tabla .= "</table>";
                                        echo $tabla;
                                    }
                                    else if ($proyectoC['FECHA'] == '2015')
                                    {
                                        echo "No puede enviar la solicitud debido a que el proyecto es del 2015";
                                    }
                                    else if ($numEva['NUMEVAL'] < 1)
                                    {
                                        echo "No puede enviar la solicitud sin evaluador asignado al grupo";
                                    }
                                    else if ($rowActividad['NUMACT'] < 4)
                                    {
                                        echo 'Para enviar la solicitud debe diligenciar en el cronograma del grupo las actividades de Valoración de Evidencia de Conocimiento, Valoración de Evidencia de Desempeí±o, Valoración de Evidencia de Producto y Emisión de Juicio';
                                    }
                                    else if ($numCandidatos['NUMCAND'] < 10 || $numCandidatos['NUMCAND'] > 40)
                                    {   
                                        echo "El numero de candidatos asociados al grupo debe ser minimo de 10 y maximo 40";
//                                        if ($numRowsOperacionBanco < 1)
//                                        {
//                                            echo "El numero de candidatos asociados al grupo debe ser minimo de 10 y maximo 40";
//                                        }
//                                        else
//                                        {
                                            /*
                                             * Acá empieza el codigo de validaciones para la generación de solicitudes al banco
                                             */
//                                            $query222 = "SELECT ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO "
//                                                    . "FROM T_ESTADO_SOLICITUD ES "
//                                                    . "INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
//                                                    . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD = " . $results[ID_OPERACION][0] . ")";
//                                            $statement222 = oci_parse($connection, $query222);
//                                            oci_execute($statement222);
//                                            $numRows222 = oci_fetch_all($statement222, $rows222);
//                                            if ($numActividadOpor < 1)
//                                            {
//                                                echo '<div style="color:red; font-weight: bold">Para enviar la solicitud de oportunidad debe diligenciar en el cronograma del grupo la actividad de Valoración de Evidencia de Conocimiento Oportunidad</div><br><br>';
//                                            }
                                            ?>
<!--                                            <center>
                                                <table>
                                                    <tr>
                                                        <th>
                                                            Tipo de Solicitud
                                                        </th>
                                                        <th>
                                                            Observación
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select name="ddlTipoDescripcion">
                                                                <option value="0">Seleccione...</option>-->
                                                                <?php
//                                                                if (($results['ID_T_OPERACION'][0] != 2) && (
//                                                                        ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 1) ||
//                                                                        $respSolicitud < 1))
//                                                                {
//                                                                    $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Solicitud IE\'';
//                                                                    $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
//                                                                    $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
//                                                                    $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);
//
//                                                                    for ($i = 0; $i < $numRowsTipoOperacion; $i++)
//                                                                    {
//                                                                        ?>
                                                                        <!--<option value="//<?php // echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php // echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>-->
                                                                        <?php
//                                                                    }
//                                                                }
//                                                                if (($results['ID_T_OPERACION'][0] != 2) &&
//                                                                        (($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 1) ||
//                                                                        ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 3)))
//                                                                {
//                                                                    $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Contingencia\'';
//                                                                    $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
//                                                                    $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
//                                                                    $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);
//
//                                                                    for ($i = 0; $i < $numRowsTipoOperacion; $i++)
//                                                                    {
//                                                                        ?>
                                                                        <!--<option value="//<?php // echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php // echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>-->
                                                                        <?php
//                                                                    }
//                                                                }
//
//                                                                if (($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 1) ||
//                                                                        ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 2) ||
//                                                                        ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 3) ||
//                                                                        ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 3))
//                                                                {
//
//                                                                    if ($numActividadOpor >= 1)
//                                                                    {
//
//                                                                        $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Oportunidad\'';
//                                                                        $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
//                                                                        $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
//                                                                        $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);
//
//                                                                        for ($i = 0; $i < $numRowsTipoOperacion; $i++)
//                                                                        {
//                                                                            ?>
                                                                            <!--<option value="//<?php // echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php // echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>-->
                                                                            //<?php
//                                                                        }
//                                                                    }
//                                                                }
//                                                                ?>
<!--                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea id="txt" name="txtObservacion" maxlength="250" style=" width: 400px; height: 60px; "></textarea>
                                                            <br/>
                                                            Numero de caracteres: <label id="cantidadImpacto" style="color: red;"></label>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br/>
                                                <input type="submit" name="btnSolicitar" value="Solicitar Instrumentos"/>
                                                <input type="hidden" name="hidNorma" value="//<?php // echo $idnorma ?>"/>
                                                <input type="hidden" name="hidGrupo" value="//<?php // echo $g ?>"/>
                                                <input type="hidden" name="hidProyecto" value="//<?php // echo $proyecto ?>"/>
                                            </center>
                                            <br>-->
                                            <?php
//                                        }
                                    }
                                    else if ($numInstrumentos['NUMINSTRUMENTOS'] < 1)
                                    {
                                        echo "No puede enviar la Solicitud no se encuentran instrumentos disponibles";
                                    }
                                    else
                                    {
                                        $query212 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO, TOB.ID_T_OPERACION
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                                        $statement212 = oci_parse($connection, $query212);
                                        oci_execute($statement212);
                                        $respSolicitud = oci_fetch_all($statement212, $results);
                                        $ano = date('Y');

                                        if ($respSolicitud > 0)
                                        {
                                            $query222 = "SELECT ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO "
                                                    . "FROM T_ESTADO_SOLICITUD ES "
                                                    . "INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
                                                    . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD = " . $results['ID_OPERACION'][0] . ")";
                                            $statement222 = oci_parse($connection, $query222);
                                            oci_execute($statement222);
                                            $numRows222 = oci_fetch_all($statement222, $rows222);
                                        }
                                        if ($numActividadOpor < 1)
                                        {
                                            echo '<div style="color:red; font-weight: bold">Para enviar la solicitud de oportunidad debe diligenciar en el cronograma del grupo la actividad de Valoración de Evidencia de Conocimiento Oportunidad</div><br><br>';
                                        }
                                        ?>
                                        <center>
                                            <table>
                                                <tr>
                                                    <th>
                                                        Tipo de Solicitud
                                                    </th>
                                                    <th>
                                                        Observación
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select name="ddlTipoDescripcion">
                                                            <option value="0">Seleccione...</option>
                                                            <?php
                                                            if (($results['ID_T_OPERACION'][0] != 2) && (
                                                                    ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 1)) ||
                                                                    $respSolicitud < 1)
                                                            {
                                                                $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Solicitud IE\'';
                                                                $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
                                                                $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
                                                                $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);

                                                                for ($i = 0; $i < $numRowsTipoOperacion; $i++)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            if (($results['ID_T_OPERACION'][0] != 2) &&
                                                                    (($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 1) ||
                                                                    ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 3)))
                                                            {
                                                                $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Contingencia\'';
                                                                $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
                                                                $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
                                                                $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);

                                                                for ($i = 0; $i < $numRowsTipoOperacion; $i++)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>
                                                                    <?php
                                                                }
                                                            }

                                                            if (($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 1) ||
                                                                    ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 2) ||
                                                                    ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 4 && $results['ID_T_OPERACION'][0] == 3) ||
                                                                    ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] == 1 && $results['ID_T_OPERACION'][0] == 3))
                                                            {
                                                                if ($numActividadOpor >= 1)
                                                                {
                                                                    $queryTipoOperacion = 'SELECT * FROM T_TIPO_OPERACION_BANCO WHERE DESCRIPCION = \'Oportunidad\'';
                                                                    $statementTipoOperacion = oci_parse($connection, $queryTipoOperacion);
                                                                    $executeTipoOperacion = oci_execute($statementTipoOperacion, OCI_DEFAULT);
                                                                    $numRowsTipoOperacion = oci_fetch_all($statementTipoOperacion, $rowsTipoOperacion);

                                                                    for ($i = 0; $i < $numRowsTipoOperacion; $i++)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $rowsTipoOperacion['ID_OPERACION'][$i]; ?>"><?php echo utf8_encode($rowsTipoOperacion['DESCRIPCION'][$i]); ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea id="txt" name="txtObservacion" maxlength="250" style=" width: 400px; height: 60px; "></textarea>
                                                        <br/>
                                                        Numero de caracteres: <label id="cantidadImpacto" style="color: red;"></label>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br/>
                                            <input type="submit" name="btnSolicitar" value="Solicitar Instrumentos"/>
                                            <input type="hidden" name="hidNorma" value="<?php echo $idnorma ?>"/>
                                            <input type="hidden" name="hidGrupo" value="<?php echo $g ?>"/>
                                            <input type="hidden" name="hidProyecto" value="<?php echo $proyecto ?>"/>
                                        </center>
                                        <br>
                                        <?php
                                    }
                                }
                                if ($respSolicitud >= 1)
                                {

                                    $query217 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                                    $statement217 = oci_parse($connection, $query217);
                                    oci_execute($statement217);
                                    ?>
                                    HISTORIAL DE SOLICITUDES DE ESTE GRUPO
                                    <table>
                                        <tr>
                                            <th><font face = "verdana"><b>Radicado de Solicitud</b></font></th>
                                            <th><font face = "verdana"><b>Tipo de Solicitud</b></font></th>
                                            <th><font face = "verdana"><b>Fecha de Solicitud</b></font></th>
                                            <th><font face = "verdana"><b>Codigo Instrumento</b></font></th>
                                            <th><font face = "verdana"><b>Estado de Solicitud</b></font></th>
                                            <th><font face = "verdana"><b>Observación Respuesta</b></font></th>
                                            <th><font face = "verdana"><b>Fecha respuesta</b></font></th>
                                            <th><font face = "verdana"><b>Hora Respuesta</b></font></th>
                                            <th><font face = "verdana"><b>Fecha Envio Correo</b></font></th>
                                        </tr>
                                        <?php
                                        while ($respSolicitud2 = oci_fetch_array($statement217, OCI_BOTH))
                                        {

                                            $query223 = "SELECT ES.ID_ESTADO_SOLICITUD,ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO "
                                                    . "FROM T_ESTADO_SOLICITUD ES"
                                                    . " INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
                                                    . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD =  $respSolicitud2[ID_OPERACION])";
                                            $statement223 = oci_parse($connection, $query223);
                                            oci_execute($statement223);
                                            $numRows223 = oci_fetch_all($statement223, $rows223);
                                            ?>
                                            <tr>
                                                <td><?php echo 'R' . $proyectoC['ID_REGIONAL'] . '-C' . $proyectoC['ID_CENTRO'] . '-P' . $proyectoC['ID_PROYECTO'] . '-' . $norma[0] . '-' . $g . '-' . $respSolicitud2["ID_OPERACION"]; ?></td>
                                                <td><?php echo $respSolicitud2["DESCRIPCION"]; ?></td>
                                                <td><?php echo $respSolicitud2["FECHA_REGISTRO"]; ?></td>
                                                <?php
                                                if ($numRows223 == 1)
                                                {
                                                    echo "<td>" . $rows223['CODIGO_INSTRUMENTO'][0] . "</td>";
                                                    echo "<td>" . utf8_encode($rows223['DETALLE'][0]) . "</td>";
                                                    echo "<td>" . nl2br($rows223['OBSERVACION'][0]) . "</td>";
                                                    echo "<td>" . $rows223['FECHA_REGISTRO'][0] . "</td>";
                                                    echo "<td>" . $rows223['HORA_REGISTRO'][0] . "</td>";

                                                    $query224 = "SELECT * "
                                                            . "FROM T_FECHA_CORREO_BANCO FCB "
                                                            . "WHERE ID_ESTADO_SOLICITUD = " . $rows223['ID_ESTADO_SOLICITUD'][0];
                                                    $statement224 = oci_parse($connection, $query224);
                                                    oci_execute($statement224);
                                                    $numRows224 = oci_fetch_all($statement224, $rows224);
                                                    if ($numRows224 > 1)
                                                        echo "<td>" . $rows224['FECHA_REGISTRO'][0] . ' ' . $rows224['HORA_REGISTRO'][0] . "</td>";
                                                    else
                                                        echo '<td>Correo aun no enviado</td>';
                                                }
                                                else
                                                {
                                                    echo "<td>No disponible</td>";
                                                    echo "<td>Enviada</td>";
                                                    echo "<td>Aun no disponible</td>";
                                                    echo "<td>Aun no disponible</td>";
                                                    echo "<td>Aun no disponible</td>";
                                                    echo '<td>Correo aun no enviado</td>';
                                                }
                                                ?>
                                            </tr>
                                        <?php } ?>
                                    </table><br>
                                    <?php
                                }
                                ?>
                            </fieldset>
                        </form>
                        <?php
                    }
                    else
                    {
                        echo "Por favor seleccione un grupo";
                    }
                    ?>
                </center>
            </div>
        </div>
        <div class="space">&nbsp;</div>
        <?php include ('layout/pie.php') ?>

        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en lí­nea" title="Pagos en lí­nea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>