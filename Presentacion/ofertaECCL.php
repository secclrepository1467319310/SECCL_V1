<?php
require_once('../Clase/conectar.php');
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);
//var_dump($_POST);
if (isset($_POST[departamento])) {
//    include_once '../Clase/conectar.php';
    $departamento = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_SPECIAL_CHARS);
    $query = " SELECT r.codigo_regional,r.nombre_regional,c.codigo_centro,c.nombre_centro,m.nombre_municipio,c.direccion,c.persona_contacto,c.telefono_contacto,n.codigo_norma,n.titulo_norma,n.version_norma
    FROM detalles_poa dp 
    JOIN proyecto p 
      ON (p.id_provisional=dp.id_provisional) 
    JOIN norma n 
      ON (n.id_norma=dp.id_norma) 
    JOIN centro c 
      ON (c.codigo_centro=p.id_centro) 
    JOIN regional r 
      ON (r.codigo_regional=c.codigo_regional) 
    JOIN cronograma_proyecto cp 
      ON (p.id_proyecto=cp.id_proyecto) 
    JOIN actividades a 
      ON (a.id_actividad=cp.id_actividad) 
    JOIN municipio m 
      ON (m.id_municipio=c.id_municipio
     AND m.id_departamento=c.id_departamento)
   WHERE m.id_departamento='$departamento'
     AND a.id_actividad='1' 
     AND SYSDATE < cp.fecha_fin 
     AND n.activa='1'
     AND c.codigo_centro!='17076'";
    $query = " SELECT  r.codigo_regional,r.nombre_regional,c.codigo_centro,c.nombre_centro,m.nombre_municipio,c.direccion,c.persona_contacto,c.telefono_contacto,c.email_contacto "
            . "FROM centro c "
            . "JOIN regional r"
            . "  ON r.codigo_regional=c.codigo_regional"
            . " JOIN municipio m "
            . "  ON (m.id_municipio=c.id_municipio
                AND m.id_departamento=c.id_departamento) "
            . "WHERE m.id_departamento='$departamento'";
    $sReturn = oci_parse($conexion, $query);
    oci_execute($sReturn);
    $nReturn = oci_fetch_all($sReturn, $rReturn);
    foreach ($rReturn as $key => $value) {
//        foreach($)
        for ($i = 0; $i < count($value); $i++) {
            $rReturn[$key][$i] = utf8_encode($rReturn[$key][$i]);
        }
//        var_dump($value);
    }
    if ($nReturn == 0) {
        $query = "SELECT r.codigo_regional,r.nombre_regional,c.codigo_centro,c.nombre_centro,m.nombre_municipio,c.direccion,c.persona_contacto,c.telefono_contacto,'-' codigo_norma,'NO SE ENCONTRARON RESULTADOS, FAVOR COMUNICARSE CON EL CENTRO PARA OBTENER INFORMACION' titulo_norma,'-' version_norma
                        FROM centro c
                        JOIN regional r 
                          ON c.codigo_regional=r.codigo_regional
                        JOIN municipio m
                          ON m.id_municipio=c.id_municipio
                         AND m.id_departamento=c.id_departamento
                       WHERE m.id_departamento='$departamento'";
        $sReturn = oci_parse($conexion, $query);
        oci_execute($sReturn);
        $nReturn = oci_fetch_all($sReturn, $rReturn);
        foreach ($rReturn as $key => $value) {
            //        foreach($)
            for ($i = 0; $i < count($value); $i++) {
                $rReturn[$key][$i] = utf8_encode($rReturn[$key][$i]);
            }
        }
    }
    die(json_encode($rReturn));
}
if (isset($_POST[mail])) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $asunto = filter_input(INPUT_POST, 'asunto', FILTER_SANITIZE_SPECIAL_CHARS);
    $mensaje = wordwrap(filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_SPECIAL_CHARS));
    $centro = filter_input(INPUT_POST, 'centro', FILTER_SANITIZE_SPECIAL_CHARS);
    $mailContacto = filter_input(INPUT_POST, 'mailContacto', FILTER_SANITIZE_EMAIL);
    $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_EMAIL);
    if(trim($nombre)=="" ||trim($telefono)=="" ||trim($documento)=="" ||trim($asunto)==""){
        echo "<script>alert('Debe registrar nombre, teléfono, docuento y tema de interés para ser tenido en cuenta');window.location.href=window.location.href;</script>";
        die();
    }


    $qInsertarMaraton = "   INSERT INTO t_maraton (nombre,documento,telefono,email,asunto,mensaje,centro,email_contacto)
                                     VALUES ('$nombre','$documento','$telefono','$email','$asunto','$mensaje','$centro','$mailContacto')";
    $sInsertarMaraton = oci_parse($conexion, $qInsertarMaraton);
    if (oci_execute($sInsertarMaraton)) {
        echo "<script>alert('Registro exitoso')</script>";
    }else{
        
        echo "<script>alert('Ocurrió un error, favor comuníquese directamente con el centro')</script>";
    }
//    die();
    echo "<script>window.location.href=window.location.href; </script>";
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
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--<script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>-->
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link type="text/css" href="../css/encuestaLive.css" rel="stylesheet">


        <script src="../jquery/jquery-1.9.1.js"></script>
        <script src="../jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <!--        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
                <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="../jquery/jquery-ui.js"></script>
        <script>
            alert("Gracias por su interés, se ha cerrado las inscripciones de la maratón.");
            window.location.href="../index.php";
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
            $(document).ready(function() {
                $("#btnOcultar").on("click", function() {
//                    console.log($(".ocultar").css("display"));


                    if ($(".ocultar").css("display") == "block") {
                        $(".ocultar").hide();
                    } else {
//                        $("#btnOcultar").val("Ocultar selección");
                        $(".ocultar").show();

                    }
                })
                $(".img-cargando").hide();
                //               Initialise Plugin
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

                $("#f1").on("submit", function(ev) {
                    ev.preventDefault();
                    $(".msg-centro").hide();
                    $(".img-cargando").show();
                    //                    var norma = $("[name=txtNorma]").val().toUpperCase();
                    var departamento = $("[name=txtDepartamento]").val();
                    //                    alert(departamento);
                    $.ajax({
                        url: "ofertaECCL.php",
                        type: "POST",
                        data: {
                            departamento: departamento
                                    //                query:true,columns:"*",from:"usuario ",where:"documento like '%1023006157%'"
                        },
                        success: function(s) {
                            document.cookie="demotable1_filters="
                            $(".msg-centro").show();
                            console.info(s)
                            //                            $('#demotable1').tableFilter(options1);
                            //                            $("#demotable1").tableFilter(options1);
                            cadena = (JSON.parse(s));
                            console.log(cadena)
                            tabla = $(".resultados>table");
                            $(".temp-resultados").remove();
                            for (i = 0; i < cadena["CODIGO_REGIONAL"].length; i++) {
                                tabla.append($("<tr class='temp-resultados tmp-sel-correo'>" +
//                                        "<td> <input type='checkbox' " + (cadena["CODIGO_NORMA"][i] == "-" ? " disabled " : "") + "value='" + cadena["CODIGO_NORMA"][i] + "-" + cadena["CODIGO_CENTRO"][i] + "-" + cadena["VERSION_NORMA"][i] + "' name='codigos_normas[]'/></td>" +
                                        "<td email='" + cadena["EMAIL_CONTACTO"][i] + "'>" + cadena["NOMBRE_REGIONAL"][i] + "</td>" +
                                        "<td>" + cadena["CODIGO_CENTRO"][i] + "</td>" +
                                        "<td>" + cadena["NOMBRE_CENTRO"][i] + "</td>" +
                                        "<td>" + cadena["PERSONA_CONTACTO"][i] + "</td>" +
//                                        "<td>" + cadena["TELEFONO_CONTACTO"][i] + "</td>" +
                                        "<td>" + cadena["NOMBRE_MUNICIPIO"][i] + "</td>" +
                                        "<td>" + cadena["DIRECCION"][i] + "</td>" +
                                        //                                        "<td>" + cadena["CODIGO_NORMA"][i] + "</td>" +
//                                        "<td>" + cadena["TITULO_NORMA"][i] + "</td>" +
                                        "</tr>"))
                            }
                            if (i == 0) {
                                tabla.append($("<tr class='temp-resultados'>" +
                                        "<td colspan='6'>No se encontraron resultados.</td>" +
                                        "</tr>"));

                            }
                            if ($(".filters").length > 0) {
                                $(".filters").remove();
                            }
                            $('#demotable1').tableFilter(options1);
                            //                            grid2.tableFilter(options2);
                            //                            setRowCountOnGrid2();
                            $(".img-cargando").hide();

                        },
                        error: function(e) {
                            console.error(e)
                        }
                    })
                })
                ///Capturar las normas seleccionadas y enviarlas al formulario de google forms
//                $("#btnEnviar").on("click", function() {
//                    if($("[name='codigos_normas2[]']").length>0){
//                        
//                        var codigos = "";
//                        $("[name='codigos_normas2[]']").each(function() {
//                            codigos += $(this).val() + ",";
//                        })
//                        window.location.href = 'https://docs.google.com/forms/d/1m18tQ8e1q-WoBl0_4KN-DPDB-LyOXXdHJ59OQiHEIL4/viewform?entry.715277644=' + codigos;
//                    }else{
//                        $("#btnEnviar").val("No ha seleccionado normas");
//                    }
//                })
            })
//            $(document).on('change', "[name='codigos_normas[]']", function() {
//                $(".ocultar").show();
////                $("#btnOcultar").val("Ocultar selección");
//                if ($(this).prop('checked')) {
//                    $(".seleccionados fieldset").append($("<div><input checked type='checkbox' name='codigos_normas2[]' value='" + $(this).val() + "'/>" + $($("td", $(this).parent().parent())[8]).text() + "<br/></div>"))
//                } else {
//                    var codigoNorma = $(this).val();
//                    $("[name='codigos_normas2[]']").each(function() {
//                        if ($(this).val() == codigoNorma) {
//                            $(this).parent().remove()
//                        }
//                    })
//                }
//            })
//            $(document).on('change', "[name='codigos_normas2[]']", function() {
//                var codigoNorma = $(this).val();
//                if (!$(this).prop('checked')) {
//                    $("[name='codigos_normas[]']").each(function() {
//                        if ($(this).val() == codigoNorma && $(this).prop('checked')) {
//                            $(this).prop('checked', false)
//                        }
//                    })
//                    $(this).parent().remove();
//
//                }
//            })
            $(document).on('click', '.tmp-sel-correo', function() {
//                alert("Hola");
//                console.log(this)
                console.log($($("td", this)))
                var codigoCentro = $($("td", this)[1]).text();
                var emailContacto = $($("td", this)[0]).attr("email");
                $("[name=mailContacto]").val(emailContacto)
//                console.log(codigoCentro);
//                $("#dialog-form").removeAttr("title");
                $(".dialog-msg").text(codigoCentro);

                $("[name=centro]").val(codigoCentro)
                $(".hidden").removeClass("hidden");
                dialog = $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 700,
                    width: 500,
                    modal: true,
                    buttons: {
                        Cancelar: function() {
                            dialog.dialog("close");
                        }
                    }
                })
                dialog.dialog("open");
            })
            $(".tmp-sel-correo td").on("click", function() {

            })


                    ////////////

        </script>


    </head>
    <body onload="inicio()">

        <div id="flotante">
            <input type="button" value="X" onclick="cerrar('flotante')"class="boton_verde2"></input> 
            Se recomienda el uso de Google Chrome para una correcta visualizaci&oacute;n. Para descargarlo haga clic <a href="https://www.google.com/intl/es/chrome/browser/?hl=es" target="_blank">aqu&iacute;</a>
        </div>
        <div id="top">
            <div class="total" style="background:url(../_img/bck.header.jpg) no-repeat; height:40px;">
                <div class="min_space">&nbsp;</div>
                <script>
                            var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                            var f = new Date();
                            document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                </script>
                <div class="float_right" style="margin-right:20px;">
                    <a href="https://twitter.com/senacomunica" rel="external"><img src="../_img/rs.twitter.jpg" alt="SENA en Twiiter" /></a>&nbsp;
                    <a href="http://www.facebook.com/sena.general" rel="external"><img src="../_img/rs.facebook.jpg" alt="SENA en Facebook" /></a>&nbsp;
                    <a href="https://plus.google.com/111618152086006296623/posts" rel="external"><img src="../_img/rs.googleplus.jpg" alt="SENA en Google+" /></a>&nbsp;
                    <a href="http://pinterest.com/SENAComunica/" rel="external"><img src="../_img/rs.pinterest.jpg" alt="SENA en Pinterest" /></a>&nbsp;
                </div>      
            </div>
        </div>
        <style>
            .contador div{
                /*width: 40px;*/
                height: 25px;
                float: left;
                margin-left: 2px;

                color:white;
                font-size: 40px;
                background: linear-gradient( rgba(190,232,114,0.5), rgb(125, 190, 11));
                border-radius: 5px;

                /*font-*/
            }
            .contador center{
                float:right;
            }
            .img-cargando{
                position: absolute;
                top: 0%;
                /*top: 30%;*/
                /*left: 35%;*/
                /*width: 400px; //ancho de la imagen*/
                /*height:160px; //alto de la imagen*/
                /*margin-left: -80px; //mitad del ancho de la imagen*/
                /*margin-top: -80px; //mitad del alto de la imagen*/
            }
            table th{
                width: 20%;
            }
            .total{
                width: 100% !important;
            }
            .img-header{
                /*width: 100%;*/
            }
            /*            label, input { display:block; }
                        input.text { margin-bottom:12px; width:95%; padding: .4em; }
                        fieldset { padding:0; border:0; margin-top:25px; }
                        h1 { font-size: 1.2em; margin: .6em 0; }
                        div#users-contain { width: 350px; margin: 20px 0; }
                        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
                        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
                        .ui-dialog .ui-state-error { padding: .3em; }
                        .validateTips { border: 1px solid transparent; padding: 0.3em; }
                        #dialog-form{
                            background-color: white;
                        }*/
            .hidden{display:none}
            .ui-dialog-titlebar{}
            .temp-resultados{
                cursor: pointer;
            }
        </style>

        <div id="header" class="bck_lightgray" style="width: 100%;position: fixed; top:  0%;z-index: 20">
            <div class="total">
                <div class="">
                    <!--<a href="index.php">--><img src="../_img/header.jpg" class="img-header"/><!--</a>-->
                    <!--<div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;width: 100%"></div>-->
                </div>
                <br/>
                <br/>
                <center><div style="alignment-adjust: central"></div></center>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class='container'>
            <div class="col-md-12">
                <fieldset >
                    <form id="f1" role="form" class="form-inline" >

                        <legend> MARATÓN TU EXPERIENCIA VALE: </legend>
                        <div class="col-md-6">
                            <label for="txtDepartamento"> Seleccione departamento:</label>
                            <?php
                            $qDepartamentos = "SELECT * "
                                    . "        FROM departamento";
                            $sDepartamentos = oci_parse($conexion, $qDepartamentos);
                            oci_execute($sDepartamentos);
                            $nDepartamentos = oci_fetch_all($sDepartamentos, $rDepartamentos);
                            ?>
                            <select id="txtDepartamento" name="txtDepartamento" class="form-control">
                                <?php
                                for ($i = 0; $i < $nDepartamentos; $i++) {
                                    ?>
                                    <option value="<?= $rDepartamentos["ID_DEPARTAMENTO"][$i] ?>"><?= utf8_encode($rDepartamentos["NOMBRE_DEPARTAMENTO"][$i]) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <!--<input class="form-control" id="txtNorma" type="text" name="txtNorma"/>-->
                            <button class="btn" id="btnConsultar" type="submit">                        
                                Buscar
                                <span class="glyphicon glyphicon-search" aria-hidden="true">
                                </span>
                            </button>
                        </div>
                        <!--<input type="button" value="Registrarse" id="btnOcultar"  class="btn btn-success" style="float:right"/>-->
                        <div class="alert alert-warning col-md-6 msg-centro" style="height: 38px;display:none">
                            <span class="glyphicon glyphicon-warning-sign" style="width: 40px" aria-hidden="true"></span>                                

                            <!--<div style="font-size: 14px">-->
                            <font style="font-size: 14px;margin-top: 0;color:red;">
                            <b>Presione clic sobre el centro de su interés.</b>                                 
                            </font>
                        </div>
                        <!--</div>-->
                        <img class='img-cargando' src="http://3.bp.blogspot.com/-JeGYJyA7z2k/VNUMuthhjDI/AAAAAAAAATk/LnNLV4OGz-A/s1600/iconoCargando-1-.gif" width="200" style="z-index: 21;left: 80%"/>
                    </form>

                    <div class="resultados">
                        <br/>
                        <br/>
                        <br/>
                        <input type="button" class="btn btn-success" id="cleanfilters" value="VER TODOS LOS CENTROS DE LA REGIÓN."/>
                        <br/>
                        <br/>
                        <br/>
                        <!--<div class="table-responsive">-->
                        <table  id="demotable1" class="table-striped  col-md-12 " >
                            <thead>                                
                                <tr>
                                    <!--<th>SELECCIONAR NORMAS DESEADAS</th>-->
                                    <th>REGIONAL</th>
                                    <th>CÓDIGO CENTRO</th>
                                    <th>NOMBRE CENTRO</th>
                                    <th>PERSONA CONTACTO</th>
                                    <!--<th>TELÉFONO CONTACTO</th>-->
                                    <th>NOMBRE MUNICIPIO</th>
                                    <th>DIRECCIÓN</th>
                                    <!--<th>CÓDIGO NORMA</th>-->
                                    <!--<th>TÍTULO NORMA</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="temp-resultados">
                                    <td colspan="6">Ingrese tema de interés y presione buscar, para obtener resultados.</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--</div>-->
                    </div>
                </fieldset>
            </div>
            <div id="dialog-form" class="hidden" title="Complete para solicitud de información:">
                <p class="validateTips dialog-msg"></p>

                <form method="POST" id="f2">
                    <input type="hidden" name="mail" value="1"/>
                    <input type="hidden" name="mailContacto" value="0"/>
                    <input type="hidden" name="centro" value="0"/>
                    <fieldset>
                        <label for="nombre">Nombre:</label>
                        <input type="submit" style="float:right">
                        <input type="text" required name="nombre" id="nombre" value="" class="form-control text ui-widget-content ui-corner-all">
                        <br/>
                        <label for="documento">Número de identificación:</label>
                        <input type="text" required name="documento" id="documento" value="" class="form-control text ui-widget-content ui-corner-all">
                        <br/>
                        <label for="telefono">Teléfono:</label>
                        <input type="text" required name="telefono" id="telefono" value="" class="form-control text ui-widget-content ui-corner-all">
                        <br/>
                        <label for="email">Correo electrónico:</label>
                        <input type="email" name="email" id="email" value="" class="form-control text ui-widget-content ui-corner-all">
                        <br/>
                        <label for="asunto">Tema de interés:</label>
                        <input type="text" required name="asunto" id="asunto" value="" class="form-control text ui-widget-content ui-corner-all">
                        <br/>
                        <label for="mensaje">Mensaje:</label>
                        <textarea type="text" form-control  style="margin: 0px; width: 447px; height: 156px;" name="mensaje" id="mensaje" value="" class="text ui-widget-content ui-corner-all">Estoy interesado en recibir información sobre...</textarea>
                        <!-- Allow form submission with keyboard without duplicating the dialog button -->

                    </fieldset>
                </form>

            </div>
            <!--div  style="float: right ; position: fixed; top:  35%;right: 0%;" class="seleccionados col-md-3">
                
                <div class="ocultar" style="display:none;background-color: white" >
                    <fieldset style="overflow: scroll; max-height: 300px;">
                        <input class="btn btn-success" type="button" value="Enviar registro" id="btnEnviar"/>
                        <legend>Registrar normas seleccionadas:</legend>
                    </fieldset>

                </div>
            </div>
        </div-->

<?php include ('layout/pie.php') ?>


    </body>
</html>