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
$_gproyecto = $_GET[proyecto];
$_gfecha = $_GET[fecha];
$_gfecha2 = $_GET[fecha2];
$_gcentro = $_GET[centro];
$_gregional = $_GET[regional];
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>-->
        <!--datepicker y validate-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../jquery/jquery.validate.mod.js"></script>
        <!---->
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link type="text/css" href="../css/encuestaLive.css" rel="stylesheet">
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
            jQuery.validator.addMethod("pattern", function(value, element, param) {
                if (this.optional(element)) {
                    return 'Campo obligatorio';
                }
                if (typeof param === 'string') {
                    param = new RegExp('^(?:' + param + ')$');
                }
                return param.test(value);
            }, "Formato incorrecto");

            jQuery.validator.addMethod("bool", function(value, element, param) {
                return param;
            }, "Formato incorrecto");


            $.validator.messages.date = "Fecha no válida";
            $.validator.messages.bool = function(value, element) {
                return "<br/>La fecha " + $(element).val() + " debe ser mayor " + $("[name='fecha']").val();
            };

            $(document).ready(function() {
                //ajax
                var cargarcentro = function() {

                    $.ajax({
                        method: "POST",
                        url: "ProyectosAuditoresAjax.php",
                        data: {
                            v1: "prueba",
                            regional: $("[name=regional]").val(),
                            currentcentro: "<?= $_gcentro ?>"
                        },
                        success: function(e) {
                            var element = $("[name='centro']");
                            element.text("");
                            element.append("<option value></option>");
                            element.append(e);
                            //console.log(e);
                        }
                    })
                };
                cargarcentro();
                $("[name=regional]").change(function() {
                    cargarcentro()
                });



                var datepickeroption = {
                    dateFormat: 'dd/mm/yy',
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                    changeMonth: true
                };

                $("[name=fecha],[name=fecha2]").each(function() {
                    $(this).datepicker(datepickeroption);
                }
                );


                //FALTA VALIDACION DE QUE SEA MAYOR FECHA 2 A FECHA 1
                $("[name='f1']").validate({
                    rules: {
                        fecha: {
                            required: function() {
                                return $("[name='fecha2'").val().trim() != "";
                            }
                        },
                        fecha2: {
                            required: function() {
                                return $("[name='fecha'").val().trim() != "";
                            },
                            bool: function() {
                                var fecha1 = $("[name='fecha']").val()
                                if (fecha1 != "") {
                                    var d1 = fecha1.substring(0, 2);
                                    var m1 = fecha1.substring(3, 5);
                                    var y1 = fecha1.substring(6, 10);

                                    var fecha2 = $("[name='fecha2']").val();
                                    var d2 = fecha2.substring(0, 2);
                                    var m2 = fecha2.substring(3, 5);
                                    var y2 = fecha2.substring(6, 10);

                                    return new Date(y1 + "/" + m1 + "/" + d1) < new Date(y2 + "/" + m2 + "/" + d2);
                                }
                                return true;

                            }
                        },
                        proyecto: {
                            number: true
                        },
                        centro: {
                            number: true
                        },
                        regional: {
                            number: true
                        }
                    }

                });

                $(function() {
                    $(".impdialogLink,.objdialogLink").click(function() {
                        console.log($("#msj" + $(this).attr("id")));
                        $("#msj" + $(this).attr("id")).dialog("open");

                    })
                    $(".dialogMenu").dialog({
                        autoOpen: false,
                        show: {
                            effect: "blind",
                            duration: 100
                        },
                        hide: {
                            effect: "explode",
                            duration: 100
                        }
                    })


                })
                $("a.btntrash").click(function(ev) {
                    ev.preventDefault();
                    $('[name=fecha],[name=fecha2]').each(function() {
                        $(this).val('')
                    })

                });




            });
        </script>
        <style>


            .icon-trash {
                width: 30px;
                height: 28px;
                position: relative;
                overflow: hidden;
                margin-left: -4px;
                margin-bottom: 2px;
            }

            .icon-trash .trash-lid {
                width: 62%;
                height: 10%;
                position: absolute;
                left: 50%;
                margin-left: -31%;
                top: 10.5%;
                background-color: #000;
                border-top-left-radius: 80%;
                border-top-right-radius: 80%;
                -webkit-transform: rotate(-5deg);
                -moz-transform: rotate(-5deg);
                -ms-transform: rotate(-5deg);
                transform: rotate(-5deg); 
            }

            .icon-trash .trash-lid:after {
                content: "";
                width: 26%;
                height: 100%;
                position: absolute;
                left: 50%;
                margin-left: -13%;
                margin-top: -10%;
                background-color: inherit;
                border-top-left-radius: 30%;
                border-top-right-radius: 30%;
                -webkit-transform: rotate(-1deg);
                -moz-transform: rotate(-1deg);
                -ms-transform: rotate(-1deg);
                transform: rotate(-1deg); 
            }

            .icon-trash .trash-container {
                width: 56%;
                height: 65%;
                position: absolute;
                left: 50%;
                margin-left: -28%;
                bottom: 10%;
                background-color: #000;
                border-bottom-left-radius: 15%;
                border-bottom-right-radius: 15%;
            }

            .icon-trash .trash-container:after {
                content: "";
                width: 110%;
                height: 12%;
                position: absolute;
                left: 50%;
                margin-left: -55%;
                top: 0;
                background-color: inherit;
                border-bottom-left-radius: 45%;
                border-bottom-right-radius: 45%;
            }

            .icon-trash .trash-line-1 {
                width: 4%;
                height: 50%;
                position: absolute;
                left: 38%;
                margin-left: -2%;
                bottom: 17%;
                background-color: #252527;
            }

            .icon-trash .trash-line-2 {
                width: 4%;
                height: 50%;
                position: absolute;
                left: 50%;
                margin-left: -2%;
                bottom: 17%;
                background-color: #252527;
            }

            .icon-trash .trash-line-3 {
                width: 4%;
                height: 50%;
                position: absolute;
                left: 62%;
                margin-left: -2%;
                bottom: 17%;
                background-color: #252527;
            }
        </style>
    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php'); ?>
        <?php
        require_once('../Clase/conectar.php');
        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
        $totalamostrar = 40;
        $limite = $_GET["limit"];
        $limite = $limite != null && $limite != "" && is_numeric($limite) ? ($limite * $totalamostrar) : $totalamostrar;

        $principio = $limite > $totalamostrar ? $limite - $totalamostrar : 0;
        $principio++;



        $link = is_numeric($_gproyecto) ? "&proyecto=$_gproyecto" : "";
        $link.= validateDate($_gfecha, 'd/m/Y') && validateDate($_gfecha2, 'd/m/Y') ? "&fecha=$_gfecha&fecha2=$_gfecha2" : "";
        $link.= is_numeric($_gcentro) ? "&centro=$_gcentro" : "";
        $link.= is_numeric($_gregional) ? "&regional=$_gregional" : "";
        ?>

        <div id="cuerpo">
            <div id="contenedorcito">
                <form method="get" action="" name="f1">
                    <table id="filtro">
                        <tr>
                            <td colspan="7"><b>FILTRO</b></td>
                        </tr>
                        <tr>
                            <th>Radicado de proyecto</th>
                            <th>Código Regional</th>
                            <th>Regional</th>
                            <th>Código Centro</th>
                            <th>Centro</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><input type="text" name="proyecto" value="<?= $_gproyecto ?>"/></td>
                            <td><input style="width:100px" type="text" name="regional" value="<?= $_gregional ?>"/></td>
                            <td>
                                <select name="regional" style="width:210px">
                                    <option value=""></option>

                                    <?php
                                    $regional = "SELECT * FROM REGIONAL";
                                    $sregional = oci_parse($connection, $regional);
                                    oci_execute($sregional);

                                    while ($rregional = oci_fetch_array($sregional, OCI_ASSOC))
                                    {
                                        echo "<option value=\"$rregional[CODIGO_REGIONAL]\"  " . ($rregional[CODIGO_REGIONAL] == $_gregional ? "selected" : "") . ">" . utf8_encode($rregional[NOMBRE_REGIONAL]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input style="width:100px" type="text" name="centro" value="<?= $_gcentro ?>"/></td>
                            <td>
                                <select name="centro" style="width:210px">
                                    <option value=""></option>                                    
                                </select>
                            </td>
                            <td><input type="submit" value="FITRAR"/>   </td>
                        </tr>
                    </table>
                </form>
                <br/>
                <hr/>
                <br/>
                <?php
                $filtro = $_gproyecto != null && $_gproyecto != "" && is_numeric($_gproyecto) ? " AND id_proyecto=" . $_gproyecto : "";
                $filtro.=validateDate($_gfecha, 'd/m/Y') && validateDate($_gfecha2, 'd/m/Y') ? " AND TO_DATE(SUBSTR(FECHA_ELABORACION ,0,10),'DD/MM/YYYY')  BETWEEN '$_gfecha' AND '$_gfecha2'" : "";
                $filtro.=$_gcentro != null && $_gcentro != "" && is_numeric($_gcentro) ? " AND ID_CENTRO=" . $_gcentro : "";
                $filtro.=$_gregional != null && $_gregional != "" && is_numeric($_gregional) ? " AND ID_REGIONAL=" . $_gregional : "";
                $filtro2 = $filtro;
                $filtro = substr($filtro, 0, 4) == " AND" ? substr($filtro, 4) : $filtro;
                $filtro = $filtro == "" ? "" : " WHERE $filtro ";

                function validateDate($date, $format = 'Y-m-d H:i:s')
                {
                    $d = DateTime::createFromFormat($format, $date);
                    return $d && $d->format($format) == $date;
                }
                ?>  

                <table>
                    <tr>
                        <td colspan="11"><b>RESULTADOS</b></td>
                    </tr>
                    <tr>
                        <th>Radicado PROYECTO</th>
                        <th>Fecha y Hora Elaboración</th>
                        <th>Empresa</th>
                        <th>código centro</th>
                        <th>nombre centro</th>
                        <th>código regional</th>
                        <th>nombre regional</th>
                        <th>Objetivo del Proyecto</th>
                        <th>Impacto del Proyecto</th>
                        <?= $_SESSION[rol] == 15 ? "" : "<th>Detalles PROYECTO</th>" ?>
                        <th>observaciones</th>
                    </tr>
                    <?php
                    $fecha = date('Y');
                    $query = "SELECT * FROM (                        
                    SELECT 
                        id_proyecto,
                        FECHA_ELABORACION,
                        NIT_EMPRESA, 
                        ID_PLAN,
                        ID_CENTRO,
                        ID_REGIONAL,
                        NOMBRE_EMPRESA,
                        OBJETIVO,
                        DESCRIPCION,
                        NOMBRE_CENTRO,
                        NOMBRE_REGIONAL,
                        ROWNUM R
                    
                        FROM (
                            SELECT 
                                unique p.id_proyecto,
                                P.FECHA_ELABORACION,
                                P.NIT_EMPRESA, 
                                P.ID_PLAN,
                                P.ID_CENTRO,
                                P.ID_REGIONAL,
                                ES.NOMBRE_EMPRESA,
                                TOP.ID_PROYECTO as OBJETIVO,
                                TIP.ID_PROYECTO as DESCRIPCION,
                                C.NOMBRE_CENTRO,
                                R.NOMBRE_REGIONAL


                                FROM proyecto P 
                               LEFT JOIN T_OBJETIVO_PROYECTO  TOP 
                               ON (P.ID_PROYECTO = TOP.ID_PROYECTO)
                               LEFT JOIN empresas_sistema ES
                               ON(P.NIT_EMPRESA=ES.NIT_EMPRESA)
                               LEFT JOIN T_IMPACTO_PROYECTO TIP
                               ON(TIP.ID_PROYECTO=P.ID_PROYECTO)
                               LEFT JOIN CENTRO C 
                               ON(C.CODIGO_CENTRO=P.ID_CENTRO)
                               LEFT JOIN REGIONAL R
                               ON(R.CODIGO_REGIONAL=P.ID_REGIONAL)

                               where  SUBSTR(P.FECHA_ELABORACION, 7,4) = 2016 
                               )
                               $filtro
                           )

                        WHERE R BETWEEN $principio AND $limite";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    while ($row = oci_fetch_array($statement, OCI_ASSOC))
                    {
                        echo "<tr>";
                        $queryProyetoNac = ("SELECT COUNT(*) AS NUMNAC, PRO.ID_PROYECTO_NACIONAL  
                                        FROM 
                                        ( SELECT 
                                            ProyNaReg.ID_PROYECTO_NACIONAL, 
                                            ProyNaReg.ID_PROYECTO 
                                          FROM T_PROY_NAC_PROY_REG ProyNaReg 
                                          UNION 
                                          SELECT 
                                            ProyNaP.ID_PROYECTO_NACIONAL, 
                                            ProyNaP.ID_PROYECTO 
                                          FROM T_PROY_NAC_PROYECTO ProyNaP) PRO
                                        INNER JOIN T_PROYECTOS_NACIONALES PRON
                                        ON PRO.ID_PROYECTO_NACIONAL = PRON.ID_PROYECTO_NACIONAL
                                        WHERE PRO.ID_PROYECTO =  '$row[ID_PROYECTO]'
                                            AND PRON.ESTADO=1
                                            GROUP BY PRO.ID_PROYECTO_NACIONAL");
                        $statementProyetoNac = oci_parse($connection, $queryProyetoNac);
                        oci_execute($statementProyetoNac);
                        $proyectoNac = oci_fetch_array($statementProyetoNac, OCI_BOTH);


                        if ($proyectoNac['NUMNAC'] > 0)
                        {
                            $proyectoNacional = 'Proyecto Nacional ' . $proyectoNac['ID_PROYECTO_NACIONAL'];
                            $classDivProNac = 'divProNac';
                            $urlProNac = '&proNac=1';
                        }
                        else
                        {
                            $proyectoNacional = '';
                            $classDivProNac = 'ninguna';
                            $urlProNac = '&proNac=0';
                        }
                        if ($row["ID_ESTADO_PROYECTO"] == 1)
                        {
                            echo "<td width=\"15%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                            $fecha . '-' . $row["ID_REGIONAL"] . '-' . $row["ID_CENTRO"] . '-' . $row["ID_PLAN"] . " - " . $proyectoNacional . "</font></td>";
                        }
                        else
                        {
                            echo "<td width=\"15%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                            $fecha . '-' . $row["ID_REGIONAL"] . '-' . $row["ID_CENTRO"] . '-' . $row["ID_PLAN"] . '-P' . $row["ID_PROYECTO"] . " - " . $proyectoNacional . "</font></td>";
                        }

                        if ($row["NIT_EMPRESA"] == null)
                        {
                            $e = "Demanda Social";
                        }
                        else
                        {

                            $e = utf8_encode($row["NOMBRE_EMPRESA"]);
                        }
                        echo "<td width=\"20%\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                        $row["FECHA_ELABORACION"] . "</font></td>";
                        echo "<td width=\"\" class=\"$classDivProNac\"><font face=\"verdana\">" .
                        $e . "</font></td>";

                        echo "<td class=\"$classDivProNac\" width=\"\">$row[ID_CENTRO]</td>";
                        echo "<td class=\"$classDivProNac\" width=\"\">" . utf8_encode($row[NOMBRE_CENTRO]) . "</td>";
                        echo "<td class=\"$classDivProNac\" width=\"\">$row[ID_REGIONAL]</td>";
                        echo "<td class=\"$classDivProNac\" width=\"\">" . utf8_encode($row[NOMBRE_REGIONAL]) . "</td>";
                        ///////////////////////
                        //Esta consulta devuelve el objetivo y descripción del proyecto 
                        //(obteniendo primeramente el objetivo y descripción máximos en sus respectivas tablas)

                        $qobjetivoeimpacto = ("SELECT  IP.DESCRIPCION, OP.OBJETIVO FROM (
                                SELECT 
                                    MAX(TOP.ID_OBJETIVO_PROYECTO) OBJETIVO, 
                                    MAX(TIP.ID_IMPACTO_PROYECTO) IMPACTO 

                                FROM T_IMPACTO_PROYECTO TIP
                                        FULL OUTER JOIN T_OBJETIVO_PROYECTO TOP
                                    ON (TOP.ID_PROYECTO=TIP.ID_PROYECTO)

                                WHERE  
                                    TIP.ID_PROYECTO='$row[ID_PROYECTO]' OR  TOP.ID_PROYECTO='$row[ID_PROYECTO]'
                            ) MAXIMOS

                            LEFT JOIN  T_IMPACTO_PROYECTO IP 
                            ON (MAXIMOS.IMPACTO=IP.ID_IMPACTO_PROYECTO)

                            LEFT JOIN T_OBJETIVO_PROYECTO OP
                            ON(MAXIMOS.OBJETIVO=OP.ID_OBJETIVO_PROYECTO)");

                        $sobjetivoeimpacto = oci_parse($connection, $qobjetivoeimpacto);
                        oci_execute($sobjetivoeimpacto);
                        $robjetivoeimpacto = oci_fetch_array($sobjetivoeimpacto, OCI_ASSOC);


                        echo "<td class=\"$classDivProNac\">";
                        if ($robjetivoeimpacto["OBJETIVO"] != null)
                        {
                            //echo $robjetivoeimpacto["OBJETIVO"];
                            ?>
                            <div class="dialogMenu" id="<?= "msjobjdialog_" . $row["ID_PROYECTO"] ?>">
                                <p>
                                    <?= $robjetivoeimpacto["OBJETIVO"]; ?>
                                </p>                                  
                            </div>
                            <a href="#" class="objdialogLink" id="<?= "objdialog_" . $row["ID_PROYECTO"] ?>">Ver</a>

                        <?php
                        }
                        else
                        {
                            ?>
                            Sin objetivo                              
                            <?php
                        }
                        echo "</td>";
                        echo "<td class=$classDivProNac>";
                        if ($robjetivoeimpacto["DESCRIPCION"] != null)
                        {

                            //echo $robjetivoeimpacto["DESCRIPCION"];
                            ?>
                            <div class="dialogMenu" id="<?= "msjimpdialog_" . $row["ID_PROYECTO"] ?>">
                                <p>
        <?= $robjetivoeimpacto["DESCRIPCION"]; ?>
                                </p>                                  
                            </div>
                            <a href="#" class="impdialogLink" id="<?= "impdialog_" . $row["ID_PROYECTO"] ?>">Ver</a>

                        <?php
                        }
                        else
                        {
                            ?>
                            Sin impacto
                            <?php
                        }
                        echo "</td>";
                        ///////////////////


                        $query123 = "SELECT *
                            FROM T_OBSER_PROY_ASES 
                            WHERE ID_PROYECTO = $row[ID_PROYECTO]";
                        $statement123 = oci_parse($connection, $query123);
                        oci_execute($statement123);
                        $numRows123 = oci_fetch_all($statement123, $rows123);



                        echo $_SESSION[rol] == 15 ? "" : "<td width=\"\" class=\"$classDivProNac\"><a href=\"./verdetalles_proyecto_c_a.php?proyecto=" . $row["ID_PROYECTO"] . "$urlProNac\" >
                        Ver Detalles</a></td>";

                        echo "<td width=\"\" class=\"$classDivProNac\">
                            Observaciones registradas ($numRows123) <br/><br/>
                            <a href=\"./ver_obser_proyecto_asesor.php?proyecto=" . $row["ID_PROYECTO"] . "\" >Ver Observacion</a>
                        </td>";

                        ///
                        echo "</tr>";
                    }
                    ?>

                </table>
                <?php
                $qtotalproyectos = "SELECT COUNT(*) AS TOTAL FROM PROYECTO where  SUBSTR(FECHA_ELABORACION, 7,4) = 2016 $filtro2";
                $stotalproyectos = oci_parse($connection, $qtotalproyectos);
                oci_execute($stotalproyectos);
                $rstotalproyectos = oci_fetch_array($stotalproyectos, OCI_ASSOC);

                $totalpaginador = ceil($rstotalproyectos[TOTAL] / $totalamostrar);
                echo "<a href=\"?limit=1$link\"><button type=\"button\">Inicio</button></a>";
                for ($i = 2; $i <= $totalpaginador; $i++)
                {
                    $current = ($_GET["limit"] == $i);
                    echo "<a href=" . (($current) ? "javascript:void(0)" : "\"?limit=$i$link\" ") . "  ><button " . (($current) ? "style=\"background-color:rgba(0, 0, 255, 0.3)\" " : "") . " type=\"button\">$i</button></a>";
                }
                echo "<a href=\"?limit=$totalpaginador$link\"><button type=\"button\">Fin</button></a>";
                ?>

            </div>
        </div>
<?php include ('layout/pie.php') ?>
    </body>
</html>