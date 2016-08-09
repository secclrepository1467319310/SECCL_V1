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
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript" src="js/val_registrar_auditores_regionales.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        <!--<script src="../jquery/jquery-1.6.3.min.js"></script>-->
        <script>
            $(document).ready(function() {
                ///validación 5:16 p. m. 13/04/2015 para que cuando le de que si en iso, la fecha sea obligatoria:
                $("[name='iso']").click(function(){
                    //alert($("[name='iso']:checked").val())
                    var el=$("[name='fecha_certificado']");
                    if($("[name='iso']:checked").val()=="0"){
                        el.val("");
                        el.attr("readonly",true);
                    }
                    else{
                        el.attr("readonly",false);
                    }

                });   

                ////////////


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
            })();
        </script>
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
                $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);

                $query1 = ("SELECT RU.CODIGO_REGIONAL, RE.NOMBRE_REGIONAL FROM T_REGIONALES_USUARIOS RU "
                        . "INNER JOIN REGIONAL RE "
                        . "ON RU.CODIGO_REGIONAL = RE.CODIGO_REGIONAL "
                        . "where ID_USUARIO =  '$id'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);
                ?>

                <!--style="height:219px;width:920px;overflow:scroll;"-->
                <div id="tab2">
                    <br>
                    <form name="f2" id="f2" <?php /*onSubmit="return validarau();"*/?> method="post" 
                          action="guardar_auditores_regionales.php" accept-charset="UTF-8">
                        <center><table id='demotable1'>
                                <thead>
                                    <tr><th>Regional</th><td><input type="text" name="regional" size="2" readonly value="<?php echo $reg[0] ?>"/></td></tr>
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