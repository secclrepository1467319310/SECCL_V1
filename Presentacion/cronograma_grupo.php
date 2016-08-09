<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
require_once("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$qFechasInhabiles = "SELECT TO_CHAR(FECHA,'dd/mm/yyyy')FECHA FROM T_FECHAS_INHABILES WHERE ESTADO='1'";
$sFechasInhabiles = oci_parse($connection, $qFechasInhabiles);
oci_execute($sFechasInhabiles);
$nFechasInhabiles = oci_fetch_all($sFechasInhabiles, $rFechasInhabiles);
?>
<!DOCTYPE HTML>
<html lang="es">
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
        <script src="../jquery/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_cronograma_grupo.js"></script>
        <script src="js/val_cronograma_proyecto.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript">
            Date.prototype.getWeekNumber = function() {
                var d = new Date(+this);
                d.setHours(0, 0, 0);
                d.setDate(d.getDate() + 2 - (d.getDay() || 7));
                return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
            };
            function formattedDate(date) {
                var d = new Date(date || Date.now()),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [day, month, year].join('/');
            }
            var unavailableDates = [<?php
for ($i = 0; $i < $nFechasInhabiles; $i++) {

    $fechas1 = preg_replace_callback("/\/[0-9]{2}\//", function($todo) {
        return "-" . intval(str_replace("/", "", $todo[0])) . "-";
    }, $rFechasInhabiles[FECHA][$i]);

    $fechas2 = preg_replace_callback("/^[0-9]{2}\-/", function($todo) {
        return intval(str_replace("-", "", $todo[0])) . "-";
    }, $fechas1);
    echo '"' . $fechas2 . '",';
}
?>];

            function unavailable(date) {
                noWeekends = $.datepicker.noWeekends(date);
                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

                if (!noWeekends[0]) {
                    return noWeekends;
                }
                else {
                    if ($.inArray(dmy, unavailableDates) == -1) {
                        return [true, ""];
                    } else {
                        return [false, "", "Unavailable"];
                    }
                }
            }
            function minDate() {
                var today = new Date();
                var d = new Date(today);
                var diasHabiles = 3;
                var diasContador = diasHabiles + 1 - 1 - 1;
                var contador = 0;

                var diasNoHabilesl = 0;
                var diasContador2 = 0;
                while (diasContador2 <= diasContador) {
                    diasContador2++;
                    contador++;
                    days = contador;

                    fecha = new Date();
                    tiempo = fecha.getTime();
                    milisegundos = parseInt(days * 24 * 60 * 60 * 1000);
                    total = fecha.setTime(tiempo + milisegundos);
                    day = fecha.getDate();
                    month = fecha.getMonth() + 1;
                    year = fecha.getFullYear();
                    d = fecha;
                    var actual = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
                    if ($.datepicker.noWeekends(d)[0] == false || $.inArray(actual, unavailableDates) != -1) {
                        diasContador++;
                        diasNoHabilesl++;

                    } else {
                    }
                }
                return diasNoHabilesl + diasHabiles
            }
            $(document).ready(function() {
                
                var orden=["19","5","6","7","8","9","10","17","20","21","22","11","16","18"];
                var centinela=false;
                for(i=0;i<orden.length;i++){
                    if(!centinela){
                        if($("[value="+orden[i]+"]",$("[name=actividad]")).length){
                            $($("[value="+orden[i]+"]",$("[name=actividad]"))).prop("selected",true);
                            console.info("Hola")
                            console.log($("[value="+orden[i]+"]",$("[name=actividad]")));
                            for(i=i+1;i<orden.length;i++){                                
                                $("[value="+orden[i]+"]",$("[name=actividad]")).prop("disabled",true);
                            }
                            centinela=true;
                        }     
                    }
                }
                $(".datepicker-input").datepicker({
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                    changeMonth: true,
                    dateFormat: "dd/mm/yy",
                    minDate: 0
                })
                var validacion = function() {
                    if ($.inArray($("[name=actividad]").val(), ["8", "9", "10", "20"]) != -1) {
//                        console.info("correcto")
                        $(".datepicker-input").datepicker("option", "minDate", minDate())
//                        $(".datepicker-input").datepicker("option","beforeShowDay",unavailable)
                    } else {
                        $(".datepicker-input").datepicker("destroy")
                        $(".datepicker-input").datepicker({
                            dateFormat: "dd/mm/yy", monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                            changeMonth: true
                        })
//                        $(".datepicker-input").datepicker("option","minDate","0")
//                        console.info("Incorrecto")

                    }
                }
                validacion()
                $("[name=actividad]").on("change", function() {
                    validacion()
                    $("[name=fi]").focus();
                })
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
            function validar()
            {
                while (!document.f2.evaluador.checked)
                {
                    window.alert("Seleccione un Evaluador");
                    return false;
                }

                while (!document.f2.usuario.checked)
                {
                    window.alert("Seleccione Candidatos");
                    return false;
                }

            }
        </script>

    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito" >
            <br>
            <center><h1>Cronograma del Grupo</h1></center>
            <?php
//            require_once("../Clase/conectar.php");
//            include ("calendario/calendario.php");
//            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $idnorma = $_GET['norma'];
            $grupo = $_GET['grupo'];
            $mensaje = $_GET['mensaje'];

            $query1 = ("select * from proyecto where id_proyecto=  '$proyecto'");
            $statement1 = oci_parse($connection, $query1);
            $resp1 = oci_execute($statement1);
            $proy = oci_fetch_array($statement1, OCI_BOTH);


            $queryCroProy = ("select * from cronograma_proyecto where id_proyecto=  '$proyecto' AND id_actividad = 19");
            $statementCroProy = oci_parse($connection, $queryCroProy);
            oci_execute($statementCroProy);
            $croProy = oci_fetch_array($statementCroProy, OCI_BOTH);

            $query3 = ("select count(*) from obs_banco where id_provisional=  '$proy[ID_PROVISIONAL]'");
            $statement3 = oci_parse($connection, $query3);
            $resp3 = oci_execute($statement3);
            $obs = oci_fetch_array($statement3, OCI_BOTH);
            $query34 = ("select codigo_norma from norma where id_norma='$idnorma'");
            $statement34 = oci_parse($connection, $query34);
            $resp34 = oci_execute($statement34);
            $norma = oci_fetch_array($statement34, OCI_BOTH);
            $f = date('d/m/Y');
            ?>
            <form class='proyecto' name="formmapa" action="guardar_cronograma_grupo.php?norma=<?php echo $idnorma ?>" method="post" accept-charset="UTF-8" id="form_cron_grupo" >
                <center>
                    <fieldset>
                        <legend><strong>Información General del Grupo</strong></legend>
                        <table id="demotable1">
                            <tr>
                                <th><strong>Proyecto</strong></th>
                                <td><input name="proyecto" type="text" readonly="readonly" value="<?php echo $proyecto ?>" ></td>
                                <th><strong>Norma</strong></th>
                                <td><input name="norma" type="text" readonly="readonly" value="<?php echo $norma[0] ?>" ></td>
                            </tr>
                            <tr>
                                <th><strong>Fecha</strong></th>
                                <td><input name="fecha" type="text" readonly="readonly" value="<?php echo $f ?>" ></td>
                                <th><strong>Grupo N°</strong></th>
                                <td><input name="grupo" type="text" readonly="readonly" value="<?php echo $grupo ?>" ></td>
                            </tr>
                        </table>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Registrar Cronograma</strong></legend>
                        Las fecha seleccionada deben respetar el rango de fecha de inicio y fin del proyecto que se muestran a continuación. <br><br>
                        <strong>
                            Fecha de inicio del proyecto: <?php echo $croProy['FECHA_INICIO'] ?> <input type="hidden" value="<?php echo $croProy['FECHA_INICIO'] ?>" name="fecha_inicio_proyecto" id="fecha_inicio_proyecto"> <br>
                            Fecha finalización del proyecto: <?php echo $croProy['FECHA_FIN'] ?> <input type="hidden" value="<?php echo $croProy['FECHA_FIN'] ?>" name="fecha_fin_proyecto" id="fecha_fin_proyecto" > <br><br>
                        </strong>

                        <?php
                        if ($mensaje == 1) {
                            ?>
                            <div class="error">
                                La fecha inicio no se encuentra en el rango de fecha de inicio y fin del proyecto.
                            </div>
                            <?php
                        } elseif ($mensaje == 2) {
                            ?>
                            <div class="error">
                                La fecha final no se encuentra en el rango de fecha de inicio y fin del proyecto.
                            </div>
                            <?php
                        } elseif ($mensaje == 3) {
                            ?>
                            <div class="mensaje">
                                Registro guardado correctamente.
                            </div>
                        <?php } ?>
                        <table>
                            <tr>
                                <th>DESCRIPCIÓN DE LAS ACTIVIDADES</th>
                                <th>FECHA INICIO</th>
                                <th>FECHA FINAL</th>
                                <th>RESPONSABLE </th>
                                <th>OBSERVACIONES </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $queryAuto = "SELECT * FROM T_NOVEDADES_GRUPOS WHERE ID_PROYECTO=$proyecto AND N_GRUPO=$grupo AND ID_NORMA=$idnorma AND ESTADO_REGISTRO = 1 AND TIPO_NOVEDAD=1";
                                    $statementAuto = oci_parse($connection, $queryAuto);
                                    oci_execute($statementAuto);
                                    $numAuto = oci_fetch_all($statementAuto, $rowAuto);
//                                    echo "<hr/>";
//                                    var_dump($rowAuto);
//                                    echo "<hr/>";
//echo $queryAuto;
                                    if ($numAuto > 0) {
//                                        $query2 = ("SELECT * FROM ACTIVIDADES ACT"
//                                                . " WHERE (ID_ACTIVIDAD > 4 AND ID_ACTIVIDAD < 27) "
//                                                . " AND  ACT.ID_ACTIVIDAD NOT IN  (SELECT CG.ID_ACTIVIDAD FROM CRONOGRAMA_GRUPO CG WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma')"
//                                                . " ORDER BY DESCRIPCION ASC");
                                        //echo "<hr/>".$query2;
                                        $query1 = " WHERE ((ID_ACTIVIDAD > 4 AND ID_ACTIVIDAD < 27)";
                                    } else {
//                                        $query2 = ("SELECT * FROM ACTIVIDADES ACT"
//                                                . " WHERE (ID_ACTIVIDAD > 4 AND ID_ACTIVIDAD < 23) "
//                                                . " AND  ACT.ID_ACTIVIDAD NOT IN  (SELECT CG.ID_ACTIVIDAD FROM CRONOGRAMA_GRUPO CG WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma')"
//                                                . " ORDER BY DESCRIPCION ASC");
//                                                
                                        //echo "<hr/>".$query2;
                                        $query1 = " WHERE ((ID_ACTIVIDAD > 4 AND ID_ACTIVIDAD < 23) ";
                                    }


                                    $qnovedades3 = "SELECT * FROM T_NOVEDADES_GRUPOS WHERE ID_PROYECTO=$proyecto AND N_GRUPO=$grupo AND ID_NORMA=$idnorma AND ESTADO_REGISTRO = 1 AND TIPO_NOVEDAD=3";
                                    $snovedades3 = oci_parse($connection, $qnovedades3);
                                    oci_execute($snovedades3);
                                    $nnovedades3 = oci_fetch_all($snovedades3, $rnovedades3);
                                    if ($nnovedades3 > 0) {
                                        $query1.=" OR (ID_ACTIVIDAD > 26 AND ID_ACTIVIDAD < 30)";
                                    }
                                     $query2 = ("SELECT * FROM ACTIVIDADES ACT"
                                                . $query1 . " )"
                                            . " AND  ACT.ID_ACTIVIDAD NOT IN  (SELECT CG.ID_ACTIVIDAD FROM CRONOGRAMA_GRUPO CG WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma' AND ESTADO='1' ) AND ESTADO='1'"
                                            . " ORDER BY DESCRIPCION ASC");
//echo $query2;
                                    ?>
                                    <Select Name="actividad" style=" width:150px" >

                                        <?php
                                        $statement2 = oci_parse($connection, $query2);
                                        oci_execute($statement2);

                                        while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                            $id_m = $row["ID_ACTIVIDAD"];
                                            $nombre_m = $row["DESCRIPCION"];

                                            echo "<OPTION value=" . $id_m . ">", utf8_encode($row["DESCRIPCION"]), "</OPTION>";
                                        }
                                        ?>

                                    </Select>
                                </td>
                                <td  class='BA'>

                                    <!--                                    <label for="from">From</label>
                                                                        <input type="text" id="from" name="from">
                                                                        <label for="to">to</label>
                                                                        <input type="text" id="to" name="to">-->
                                    <input type="text" name="fi" readonly="readonly" class="datepicker-input"/>
                                    <?php
//                                    escribe_formulario_fecha_vacio("fi", "formmapa");
                                    ?>
                                </td>
                                <td  class='BA'>
                                    <input type="text" name="fef" readonly="readonly" class="datepicker-input"/>
                                    <?php
//                                    escribe_formulario_fecha_vacio("fef", "formmapa");
                                    ?>

                                </td>
                                <td><input type="text"  name="responsable"></input></td>
                                <td><textarea rows="4" cols="20" name="obs"></textarea></td>
                            </tr>
                        </table>
                        <div id="mensajeErrorProgramacion">

                        </div>
                        <br></br>
                        <center><p><label>
                                    <input type = "submit" name = "insertar" id = "insertar" value = "Guardar" accesskey = "I" />
                                    <br></br>
                                    <a href = "verdetalles_proyecto_c2.php?proyecto=<?php echo $proyecto ?>"> Salir </a>
                                </label></p>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><strong>Cronograma</strong></legend>
                        <table class="tb-cronograma" align = "center" border = "1" cellspacing = 1 cellpadding = 2 style = "font-size: 10pt"><tr>


                                <th><font face = "verdana"><b>ID CRONO</b></font></th>
                                <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                                <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                                <th><font face = "verdana"><b>ELIMINAR</b></font></th>
                            </tr>
                            <?php
                            $query = "SELECT CG.ID_CRONOGRAMA_GRUPO,CG.ID_ACTIVIDAD,CG.FECHA_INICIO,CG.FECHA_FIN,CG.RESPONSABLE,CG.OBSERVACIONES,CG2.ID_ACTIVIDAD AS CGHISTORIAL "
                                    . "FROM CRONOGRAMA_GRUPO CG "
                                    . "LEFT JOIN (SELECT DISTINCT ID_ACTIVIDAD, ID_PROYECTO,ID_NORMA,N_GRUPO FROM CRONOGRAMA_GRUPO WHERE ESTADO='0' )CG2
                                        ON (CG2.ID_ACTIVIDAD=CG.ID_ACTIVIDAD AND CG2.ID_PROYECTO=CG.ID_PROYECTO AND CG2.ID_NORMA=CG.ID_NORMA AND CG2.N_GRUPO=CG.N_GRUPO)"
//                                    . "WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma' AND CG.ESTADO='1' ORDER BY CG.FECHA_INICIO ASC";
                                    . "JOIN ACTIVIDADES A ON (CG.ID_ACTIVIDAD=A.ID_ACTIVIDAD)"
                                    . "WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma' AND CG.ESTADO='1' ORDER BY A.ORDEN ASC";

                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $numero = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {
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
                                    <?php
                                    //para traer las solicitudes....
                                    $query212 = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$_GET[grupo]' AND TOB.ID_T_OPERACION=1  ORDER BY TOB.ID_OPERACION DESC";
                                    $statement212 = oci_parse($connection, $query212);
                                    oci_execute($statement212);
                                    $respSolicitud = oci_fetch_all($statement212, $results);
                                    //echo $query212."<hr/>";
                                    if ($respSolicitud > 0) {
                                        $query222 = "SELECT ES.ID_TIPO_ESTADO_SOLICITUD, ES.CODIGO_INSTRUMENTO, TESS.DETALLE, ES.DETALLE AS OBSERVACION, ES.FECHA_REGISTRO, ES.HORA_REGISTRO "
                                                . "FROM T_ESTADO_SOLICITUD ES "
                                                . "INNER JOIN T_TIPO_ESTADO_SOLICITUD TESS ON ES.ID_TIPO_ESTADO_SOLICITUD = TESS.ID_TIPO_ESTADO_SOLICITUD "
                                                . "WHERE ES.ID_ESTADO_SOLICITUD IN (SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD FROM T_ESTADO_SOLICITUD TES WHERE TES.ID_SOLICITUD = " . $results[ID_OPERACION][0] . ")";
                                        $statement222 = oci_parse($connection, $query222);
                                        $execute222 = oci_execute($statement222, OCI_DEFAULT);
                                        $numRows222 = oci_fetch_all($statement222, $rows222);
                                    }

                                    if ($row['ID_ACTIVIDAD'] == 8 || $row['ID_ACTIVIDAD'] == 9 || $row['ID_ACTIVIDAD'] == 10 || $row['ID_ACTIVIDAD'] == 11) {

                                        if ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0][0] == 4 || $respSolicitud < 1) {
                                            ?>
                                            <td align="right" 1><a href="eliminar_cronograma_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $grupo ?>&id=<?php echo $row["ID_CRONOGRAMA_GRUPO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td align="right" 2>Ya se envio solicitud de instrumentos, no se puede editar la actividad.</td>
                                            <?php
                                        }
                                    } else {


                                        $queryoportu = "SELECT TOB.ID_OPERACION,TTOB.DESCRIPCION,TOB.FECHA_REGISTRO,TES3.ID_TIPO_ESTADO_SOLICITUD
                                                        FROM T_OPERACION_BANCO TOB
                                                        INNER JOIN T_TIPO_OPERACION_BANCO TTOB ON TTOB.ID_OPERACION=TOB.ID_T_OPERACION
                                                        left JOIN 
                                                        ( 
                                                            SELECT TES2.ID_SOLICITUD,TES2.id_tipo_estado_solicitud FROM (
                                                              SELECT MAX(ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD,ID_SOLICITUD 
                                                              FROM T_ESTADO_SOLICITUD 
                                                              GROUP BY ID_SOLICITUD
                                                            ) TES1
                                                            JOIN T_ESTADO_SOLICITUD TES2
                                                            ON (TES1.ID_ESTADO_SOLICITUD=TES2.ID_ESTADO_SOLICITUD)

                                                        ) TES3
                                                        ON (
                                                        TES3.ID_SOLICITUD=TOB.ID_OPERACION
                                                        )
                                                        WHERE TOB.ID_PROYECTO='$proyecto' AND TOB.ID_NORMA='$idnorma' AND TOB.N_GRUPO='$_GET[grupo]' AND TOB.ID_T_OPERACION=2  ORDER BY TOB.ID_OPERACION DESC";
                                        $sueryoportu = oci_parse($connection, $queryoportu);
                                        oci_execute($sueryoportu);
                                        //echo $queryoportu."<hr/>";
                                        $rueryoportu = oci_fetch_array($sueryoportu, OCI_ASSOC);
                                        //var_dump($rueryoportu[ID_TIPO_ESTADO_SOLICITUD]);
                                        //se supone que si es 20,21,22 no debe mostrar si hay una oportunidad.. no muestre el link,(a menos de que sea devuelta)
                                        if ($rueryoportu && ($row['ID_ACTIVIDAD'] == 20 || $row['ID_ACTIVIDAD'] == 21 || $row['ID_ACTIVIDAD'] == 22 || $row['ID_ACTIVIDAD'] == 11)) {
                                            if (($rueryoportu[ID_TIPO_ESTADO_SOLICITUD] == 4)) {
                                                ?>
                                                <td align="right" 3- <?= $row['ID_ACTIVIDAD'] ?>><a href="eliminar_cronograma_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $grupo ?>&id=<?php echo $row["ID_CRONOGRAMA_GRUPO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td align="right" 4>Ya se envio solicitud de oportunidad, no se puede editar la actividad.</td>
                                                <?php
                                            }
                                        } else {
                                            if ($row['ID_ACTIVIDAD'] == 30 || $row['ID_ACTIVIDAD'] == 31) {
                                                ?>
                                                <td>No se puede eliminar, fecha generada automáticamente por el sistema por auditoria</td>

                                                <?php
                                            } else {
                                                ?>
                                                <td align="right" 5- <?= $row['ID_ACTIVIDAD'] ?>><a href="eliminar_cronograma_grupo.php?norma=<?php echo $idnorma ?>&grupo=<?php echo $grupo ?>&id=<?php echo $row["ID_CRONOGRAMA_GRUPO"] ?>&proyecto=<?php echo $proyecto ?>" >Eliminar</a></td>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tr>


                                <?php
                                $numero++;
                            }
                            ?>
                        </table>
                    </fieldset>
                    <br/>
                    <hr/>
                    <br/>
                    <fieldset>
                        <legend>Historial del cronograma</legend>
                        <table>
                            <tr>
                                <th><font face = "verdana"><b>ID CRONO</b></font></th>
                                <th><font face = "verdana"><b>ACTIVIDADES</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INICIO</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE FINALIZACIÓN</b></font></th>
                                <th><font face = "verdana"><b>RESPONSABLE</b></font></th>
                                <th><font face = "verdana"><b>OBSERVACIÓN</b></font></th>
                                <th><font face = "verdana"><b>FECHA DE INACTIVACIÓN</b></font></th>
                            </tr>
                            <?php
                            $qHistorial = "SELECT CG.*,A.DESCRIPCION FROM CRONOGRAMA_GRUPO CG JOIN ACTIVIDADES A ON (A.ID_ACTIVIDAD=CG.ID_ACTIVIDAD)WHERE CG.ID_PROYECTO='$proyecto' AND CG.N_GRUPO='$grupo' AND CG.ID_NORMA='$idnorma' AND CG.ESTADO='0' ORDER BY CG.FECHA_INICIO ASC";
                            $sHistorial = oci_parse($connection, $qHistorial);
                            oci_execute($sHistorial);
                            while ($rHistorial = oci_fetch_array($sHistorial, OCI_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $rHistorial[ID_CRONOGRAMA_GRUPO] ?></td>
                                    <td><?= utf8_encode($rHistorial[DESCRIPCION]) ?></td>
                                    <td><?= $rHistorial[FECHA_INICIO] ?></td>
                                    <td><?= $rHistorial[FECHA_FIN] ?></td>
                                    <td><?= $rHistorial[RESPONSABLE] ?></td>
                                    <td><?= $rHistorial[OBSERVACIONES] ?></td>
                                    <td><?= $rHistorial[FECHA_INACTIVACION] ?></td>

                                </tr>

                                <?PHP
                            }
                            ?>
                        </table>
                    </fieldset>
                </center>
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
