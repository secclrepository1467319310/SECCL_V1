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

            $query34 = ("select codigo_norma from norma where id_norma='$idnorma'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $norma = oci_fetch_array($statement34, OCI_BOTH);
            $f = date('d/m/Y');
            ?>
            <form class='proyecto'>
                <center>
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
                                        <OPTION>Seleccione</OPTION>
                                        <?PHP
                                        $query22 = ("select unique n_grupo from proyecto_grupo where id_proyecto='$proyecto' and id_evaluador='$id' ");

                                        $statement22 = oci_parse($connection, $query22);
                                        oci_execute($statement22);

                                        while ($row = oci_fetch_array($statement22, OCI_BOTH)) {
                                            $id_m = $row["N_GRUPO"];
                                            echo "<OPTION name=g value=" . $id_m . " ".($g==$id_m?"selected":"").">", $row["N_GRUPO"], "</OPTION>";
                                        }
                                        ?>

                                    </Select>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <?php if($g!=null && $g!="Seleccione"):?>
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
                                <td>Este reporte nos genera el listado completo de personas Certificadas dentro del proyecto en una norma específica y en un 

grupo</td>
                                <td><a  href="ExpCertificados.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>">
                                        <img src="../images/excel.png" width="26" height="26"></img></a></td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Plan de Evaluación y Ejecución de Evidencias</strong></legend>
                        <table id="demotable1">
                            <?php
                            
                            $query32 = ("select id_plan from plan_evidencias where id_proyecto='$proyecto' and grupo='$g' and id_norma='$idnorma' ");
                            $statement32 = oci_parse($connection, $query32);
                            $resp32 = oci_execute($statement32);
                            $idp = oci_fetch_array($statement32, OCI_BOTH);
                            ?>
                            <tr>
                                <th><font face = "verdana"><b>ID PLAN</b></font></th>
                                <th><font face = "verdana"><b>PROYECTO</b></font></th>
                                <th><font face = "verdana"><b>GRUPO</b></font></th>
                                <th><font face = "verdana"><b>CREAR</b></font></th>
                                <th><font face = "verdana"><b>VER</b></font></th>
                            </tr>
                            <tr>
                                <td><?php echo $idp[0] ?></td>
                                <td><?php echo $proyecto ?></td>
                                <td><?php echo $g ?></td>
                                <?php
                                if($idp[0]==NULL){
                                ?>
                                <td><a href="crear_plan_ev.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto?>">Crear</a></td>
                                <?php
                                }else{
                                ?>
                                <td>No disponible</td>
                                <?php } ?>
                                <?php
                                if($idp[0]==NULL){
                                ?>
                                <td>No disponible</td>
                                <?php
                                }else{
                                ?>
                                <td><a href="consultar_plan_ev.php?idplan=<?php echo $idp[0] ?>">Consultar</a></td>
                                <?php } ?>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Cronograma del Grupo</strong></legend>
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
                            $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ESTADO='1' ORDER BY FECHA_INICIO 

ASC";
                            $statement21 = oci_parse($connection, $query21);
                            oci_execute($statement21);
                            $numero21 = 0;
                            while ($row = oci_fetch_array($statement21, OCI_BOTH)) {
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
                        $numero2 = 0;
                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
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
                                <th>Ficha de Inscripción</th>
                            </tr>
                            <?php
                            $query = "SELECT
                                UNIQUE ID_CANDIDATO,
                                DOCUMENTO,
                                PRIMER_APELLIDO,
                                SEGUNDO_APELLIDO,
                                NOMBRE,
                                USUARIO_ID
                                FROM USUARIO U
                                INNER JOIN PROYECTO_GRUPO PY
                                ON PY.ID_CANDIDATO=U.USUARIO_ID
                                WHERE PY.ID_PROYECTO='$proyecto' AND PY.ID_NORMA='$idnorma' AND N_GRUPO='$g'
                                ORDER BY PRIMER_APELLIDO ASC";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                ?>

                                <tr>
                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                    <td><a href="ficha_inscripcion_ev.php?eva=<?php echo $ideva[0] ?>&norma=<?php echo $idnorma ?>&grupo=<?php echo $g ?>&proyecto=<?php echo $proyecto ?>&idca=<?php echo $row["ID_CANDIDATO"]; ?>">Ver Ficha</a></td>
                                </tr>

    <?php
    $numero++;
}
?>
                        </table>
                    </fieldset>
                <?php else:?>
                    <div style="color:rgb(145, 150, 39); width:50%;background-color:rgba(228, 227, 39, 0.38);border-color:rgb(145, 150, 39); border-style:solid;border-width: 1px;border-radius: 3px;height:33px">
                    <b>Nota:</b><br/>
                        Debe seleccionar un grupo
                    </div><br/><br/>
                <?php endif;?>
                </center>
            </form>
        </div>
        <div class="space">&nbsp;</div>
    <?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en 

línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" 

title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" 

title="Cóntactenos">
        </map>
    </body>
</html>