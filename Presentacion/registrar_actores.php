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
include("../Clase/conectar.php");
include ("calendario/calendario.php");
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
        <script src="../jquery/jquery.validate.mod.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        <!--<script src="../jquery/jquery-1.6.3.min.js"></script>-->
        <script type="text/javascript">
            jQuery.validator.addMethod("pattern", function(value, element, param) {
                if (this.optional(element)) {
                    return 'Campo obligatorio';
                }
                if (typeof param === 'string') {
                    param = new RegExp('^(?:' + param + ')$');
                }
                return param.test(value);
            }, "Formato no valido");

            $(document).ready(function() {
                
                $("#pestanas div").hide();
                $("#tabs li:first").attr("id", "current");
                $("#pestanas div:first").fadeIn();
                $('#tabs a').click(function(e) {
                    e.preventDefault();
                    $("#pestanas div").hide();
                    $("#tabs li").attr("id", "");
                    $(this).parent().attr("id", "current");
                    $('#' + $(this).attr('title')).fadeIn();
                });
                //Ocultar div que no corresponda a la opción seleccionada (evaluadores, auditores)
                //tab1 evaluadores
                //tab2 auditores
                ///
                var rr = $("[name='rr']").val();
                if (rr == "a") {
                    $("#tab1").hide();
                    $("[title='tab1']").hide();
                    $("#tab2").fadeIn();
                    $("[title='tab2']").fadeIn().parent().attr("id", "current");
                }
                else if (rr == "e") {
                    $("#tab2").hide();
                    $("[title='tab2']").hide();
                    $("#tab1").fadeIn();
                    $("[title='tab1']").fadeIn().parent().attr("id", "current");
                }
                else {
                    alert("No se puede registrar");
                }

                $("#f3,#f2").each(function() {
                    $(this).validate({
                        rules: {
                            documento: {
                                required: true
                            },
                            nombres: {
                                required: true
                            },
                            email: {
                                required: function() {
                                    if (rr == "e") {                                        
                                        return !($("[name='te']:checked").val()=="2");                                        
                                    }
                                    return false;
                                },
                                email: true,
                                pattern:".+@sena.edu.co"
                            },
                            email2: {
                                required:function(){
                                    if (rr == "e") {                                        
                                        return ($("[name='te']:checked").val()=="2");                                        
                                    }
                                },
                                email: true
                            }
                        },
                        messages: {
                            email:{
                                pattern:"El email debe ser sena"
                            }
                        }
                    });
                });
            });</script>
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
            });</script>
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
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);

                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  ' $idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>
                <input type="hidden" name="rr" value="<?= $_GET[rr] ?>"/>
                <ul id="tabs">
                    <li><a href="#" title="tab1">Evaluadores</a></li>
                    <li><a href="#" title="tab2">Auditores</a></li>
                </ul>
                <!--style="height:219px;width:920px;overflow:scroll;"-->
                <div id="pestanas"> 
                    <div id="tab1">
                        <br>
                        <form name="f3" id="f3" onSubmit="return validarev();" method="post" 
                              action="guardar_evaluador.php" accept-charset="UTF-8">

                            <center><table id='demotable1'>


                                    <tr><th>Regional</th><td><input type="text" name="regional" size="2" readonly value="<?php echo $reg[0] ?>"/></td></tr>
                                    <tr><th>Centro</th><td><input type="text" name="centro" readonly size="4" value="<?php echo $cen[0] ?>"/></td></tr>
                                    <tr><th>Tipo documento</th>
                                        <td><input type="radio" value="1" name="tdoc"  checked></input>C.C.
                                            <input type="radio" value="2" name="tdoc"></input>C.E.
                                            <input type="radio" value="3" name="tdoc"></input>Pasaporte</td></tr>
                                    <tr><th>Documento</th><td><input type="text" name="documento" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Nombres y Apellidos</th><td><input type="text" name="nombres" size="50"  /></td></tr>
                                    <tr><th>Ip</th><td><input type="text" name="ip" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Celular</th><td><input type="text" name="celular" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Tipo Evaluador</th>
                                        <td><input type="radio" value="1" name="te" onclick="deshabilita1()"></input>Interno
                                            <input type="radio" value="2" name="te" checked onclick="habilita1()"></input>Externo</td>
                                    </tr>
                                    <tr><th>Email SENA</th><td><input type="text" name="email" /></td></tr>
                                    <tr><th>Email Personal</th><td><input type="text" name="email2" size="50"  /></td></tr>
                                    <tr><th>Empresa</th><td><input type="text" name="em" size="50"></input></td></tr>
                                    <tr><th>Certificado como Evaluador</th>
                                        <td><input type="radio" value="1" name="certificado"  checked onclick="" ></input>Si
                                            <input type="radio" value="0" name="certificado"  onclick=""></input>No</td></tr>
                                    <tr><th>Número de Certificado</th>
                                        <td><input type="text" name="num_certificado" size="50"></input></td></tr>
                                    <tr><th>Fecha de Certificación</th>
                                        <td  class='BA'>
                                            <?php
                                            escribe_formulario_fecha_vacio("fecha_certificado", "f3");
                                            ?>

                                        </td></tr>
                                    <tr><th>Activo</th>
                                        <td><input type="radio" value="1" name="activo"  checked></input>Si
                                            <input type="radio" value="0" name="activo"></input>No</td></tr>
                                    <tr><th>Fecha de último proceso</th>
                                        <td  class='BA'>
                                            <?php
                                            escribe_formulario_fecha_vacio("fecha_proceso", "f3");
                                            ?>

                                        </td></tr>
                                    <tr><th>Observación </th><td><textarea cols="50" name="obs" rows="5"></textarea></td></tr>
                        
                            </table>
                        <br></br>
                        <p><label>

                                <input type="submit" name="insertar" id="insertar" value="Guardar" accesskey="I" />
                            </label></p></center>
                    </form>
                    <br>
                </div>
                <div id="tab2">
                    <br>
                    <form name="f2" id="f2" onSubmit="return validarau();" method="post" 
                          action="guardar_auditor.php" accept-charset="UTF-8">

                        <center><table id='demotable1'>

                                <thead>
                                    <tr><th>Regional</th><td><input type="text" name="regional" size="2" readonly value="<?php echo $reg[0] ?>"/></td></tr>
                                    <tr><th>Centro</th><td><input type="text" name="centro" readonly size="4" value="<?php echo $cen[0] ?>"/></td></tr>
                                    <tr><th>Tipo documento</th>
                                        <td><input type="radio" value="1" name="tdoc"  checked></input>C.C.
                                            <input type="radio" value="2" name="tdoc"></input>C.E.
                                            <input type="radio" value="3" name="tdoc"></input>Pasaporte</td></tr>
                                    <tr><th>Documento</th><td><input type="text" name="documento" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Nombres y Apellidos</th><td><input type="text" name="nombres" size="50"  /></td></tr>
                                    <tr><th>IP</th><td><input type="text" name="ip" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Celular</th><td><input type="text" name="celular" onKeyPress="return validar(event)"/></td></tr>
                                    <tr><th>Email SENA</th><td><input type="text" name="email" size="50"  /></td></tr>
                                    <tr><th>Email Personal</th><td><input type="text" name="email2" size="50"  /></td></tr>
                                    <tr><th>Certificado como Auditor SENA</th>
                                        <td><input type="radio" value="1" name="certiaudi" checked onclick="ac()"></input>Si
                                            <input type="radio" value="0" name="certiaudi" onclick="deshab()"></input>No</td></tr>
                                    <tr><th>Número de Certificado (Registro)</th><td><input type="text" name="num_certi" size="50"  /></td></tr>
                                    <tr><th>Fecha Certificación</th><td  class='BA'>
                                                <?php
                                                escribe_formulario_fecha_vacio("fecha_certificado_1", "f2");
                                                ?>

                                        </td></tr>
                                    <tr><th>Activo</th>
                                        <td><input type="radio" value="1" name="activo"  checked></input>Si
                                            <input type="radio" value="0" name="activo"></input>No</td></tr>
                                    <tr><th>Certificado en ISO 19011</th>
                                        <td><input type="radio" value="1" name="iso"  checked onclick="habilita()"></input>Si
                                            <input type="radio" value="0" name="iso" onclick="deshabilita()"></input>No</td></tr>
                                    <tr><th>Fecha Certificación</th><td  class='BA'>
                                                <?php
                                                escribe_formulario_fecha_vacio("fecha_certificado", "f2");
                                                ?> 

                                        </td></tr>
                                    <tr><th>Entidad Certificadora</th><td><input type="text" name="entidad" size="50"  /></td></tr>
                                    <tr><th>Fecha Auditoría 1</th><td  class='BA'>
                                                <?php
                                                escribe_formulario_fecha_vacio("auditoria_1", "f2");
                                                ?>

                                        </td></tr>
                                    <tr><th>Fecha Auditoría 2</th><td  class='BA'>
                                                <?php
                                                escribe_formulario_fecha_vacio("auditoria_2", "f2");
                                                ?>

                                        </td></tr>
                                    <tr><th>Observación (Formación Adicional)</th><td><textarea cols="50" name="observacion" rows="5"></textarea></td></tr>

                                </thead>
                            </table></center>

                        <br></br>
                        <p><label>

                                <input type="submit"  name="insertar1" id="insertar" value="Guardar" accesskey="I" />
                            </label></p>

                    </form>
                    <br>
                </div>
                
            </div>

        </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>