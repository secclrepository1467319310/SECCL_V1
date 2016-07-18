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
            <center><h1>Creación de Grupos</h1></center>
            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];

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

                                        <?PHP
                                        $query22 = ("select unique n_grupo from proyecto_grupo where id_proyecto='$proyecto'");

                                        $statement22 = oci_parse($connection, $query22);
                                        oci_execute($statement22);

                                        while ($row = oci_fetch_array($statement22, OCI_BOTH)) {
                                            $id_m = $row["N_GRUPO"];
                                            echo "<OPTION>", "Seleccione", "</OPTION>";
                                            echo "<OPTION value=" . $id_m . ">", $row["N_GRUPO"], "</OPTION>";
                                        }
                                        ?>

                                    </Select>
                                </td>
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
                            $g=$_GET['grupo'];
                            $query21 = "SELECT * FROM CRONOGRAMA_GRUPO WHERE ID_PROYECTO='$proyecto' AND N_GRUPO='$g' AND ID_NORMA='$idnorma' AND ESTADO='1' ORDER BY FECHA_INICIO ASC";
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
                                </tr>
                                <tr>
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
                            
                                
                                
                                    <td><?php echo $numero + 1; ?></td>
                                    <td><?php echo $row["DOCUMENTO"]; ?></td>
                                    <td><?php echo utf8_encode($row["PRIMER_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["SEGUNDO_APELLIDO"]); ?></td>
                                    <td><?php echo utf8_encode($row["NOMBRE"]); ?></td>
                                </tr>
                                <?php
                            $numero++;
                        }
                        ?>
                            </table>
                            
                    </fieldset>
                </center>
                <div class='tablas'>
                    <?php 
                    $qHistorial="SELECT TOB.ID_OPERACION, TTOB.DESCRIPCION,TOB.FECHA_REGISTRO, 
                            ES.ID_ESTADO_SOLICITUD, ES.ID_TIPO_ESTADO_SOLICITUD,ES.CODIGO_INSTRUMENTO,TESS.DETALLE,ES.DETALLE OBS, ES.FECHA_REGISTRO,ES.HORA_REGISTRO,
                            FCB.*
                    FROM T_OPERACION_BANCO TOB 
                    JOIN T_TIPO_OPERACION_BANCO TTOB 
                      ON(TTOB.ID_OPERACION=TOB.ID_T_OPERACION)
                    LEFT JOIN (SELECT MAX(ID_ESTADO_SOLICITUD) ID_MAX_ESTADO_SOLICITUD, ID_SOLICITUD FROM T_ESTADO_SOLICITUD GROUP BY ID_SOLICITUD) ES1
                    ON(ES1.ID_SOLICITUD=TOB.ID_OPERACION)
                    LEFT JOIN T_ESTADO_SOLICITUD ES
                    ON(ES.ID_SOLICITUD=ES1.ID_SOLICITUD AND ES.ID_ESTADO_SOLICITUD= ES1.ID_MAX_ESTADO_SOLICITUD)
                    LEFT JOIN T_TIPO_ESTADO_SOLICITUD TESS
                    ON(TESS.ID_TIPO_ESTADO_SOLICITUD=ES.ID_TIPO_ESTADO_SOLICITUD)
                    LEFT JOIN T_FECHA_CORREO_BANCO FCB
                    ON(FCB.ID_ESTADO_SOLICITUD=ES.ID_ESTADO_SOLICITUD)
                    WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                    $sHistorial= oci_parse($connection, $qHistorial);
                    oci_execute($sHistorial);
                    ?>
                    <br/>
                    <br/>
                    HISTORIAL DE SOLICITUDES DE ESTE GRUPO
                    <br/>
                    <br/>
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
                        </tr>


                        <?php
                        $qHistorial="SELECT TOB.ID_OPERACION, TTOB.DESCRIPCION,TOB.FECHA_REGISTRO FECHA_REGISTRO1, 
                            ES.ID_ESTADO_SOLICITUD, ES.ID_TIPO_ESTADO_SOLICITUD,ES.CODIGO_INSTRUMENTO,TESS.DETALLE,ES.DETALLE OBS, ES.FECHA_REGISTRO,ES.HORA_REGISTRO,
                            P.ID_REGIONAL, P.ID_CENTRO, SUBSTR(P.FECHA_ELABORACION, 7,4) AS FECHA, P.ID_PROYECTO 


                            FROM T_OPERACION_BANCO TOB 
                            JOIN T_TIPO_OPERACION_BANCO TTOB 
                              ON(TTOB.ID_OPERACION=TOB.ID_T_OPERACION)
                            LEFT JOIN (SELECT MAX(ID_ESTADO_SOLICITUD) ID_MAX_ESTADO_SOLICITUD, ID_SOLICITUD FROM T_ESTADO_SOLICITUD GROUP BY ID_SOLICITUD) ES1
                            ON(ES1.ID_SOLICITUD=TOB.ID_OPERACION)
                            LEFT JOIN T_ESTADO_SOLICITUD ES
                            ON(ES.ID_SOLICITUD=ES1.ID_SOLICITUD AND ES.ID_ESTADO_SOLICITUD= ES1.ID_MAX_ESTADO_SOLICITUD)
                            LEFT JOIN T_TIPO_ESTADO_SOLICITUD TESS
                            ON(TESS.ID_TIPO_ESTADO_SOLICITUD=ES.ID_TIPO_ESTADO_SOLICITUD)

                            LEFT JOIN PROYECTO P
                            ON(P.ID_PROYECTO=TOB.ID_PROYECTO)

                            WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$g' ORDER BY TOB.ID_OPERACION DESC";
                            $sHistorial= oci_parse($connection, $qHistorial);
                            oci_execute($sHistorial);
    //                        echo $qHistorial;
                            $contador=0;
                            while($rHistorial=  oci_fetch_array($sHistorial,OCI_ASSOC)){
                                $contador++;
                                echo "<tr>";
                                echo "<td>".'R' . $rHistorial['ID_REGIONAL'] . '-C' . $rHistorial['ID_CENTRO'] . '-P' . $rHistorial['ID_PROYECTO'] . '-' . $norma[0] . '-' . $g . '-' . $rHistorial["ID_OPERACION"]."</td>";
                                echo "<td>$rHistorial[DESCRIPCION]</td>";
                                echo "<td>$rHistorial[FECHA_REGISTRO1]</td>";
                                if($rHistorial[ID_ESTADO_SOLICITUD]){


                                    echo "<td>$rHistorial[CODIGO_INSTRUMENTO]</td>";
                                    echo "<td>". utf8_encode($rHistorial[DETALLE])." </td>";
                                    echo "<td>".nl2br($rHistorial['OBS'])."</td>";
                                    echo "<td>$rHistorial[FECHA_REGISTRO]</td>";
                                    echo "<td>$rHistorial[HORA_REGISTRO]</td>";
                                }
                                else{
                                    echo "<td>No disponible</td>";
                                    echo "<td>Enviada</td>";
                                    echo "<td>Aun no disponible</td>";
                                    echo "<td>Aun no disponible</td>";
                                    echo "<td>Aun no disponible</td>";
                                }
                                echo "</tr>";
                            }
                            if($contador==0){
                                echo "<tr><td colspan='8'><font color=red size='4px'> El proyecto '$proyecto' con la norma '$idnorma' en el grupo '$g' no presenta solicitudes.</font></td></tr>";
                            }
                        ?>
                    </table>
                </div>
            </form>
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