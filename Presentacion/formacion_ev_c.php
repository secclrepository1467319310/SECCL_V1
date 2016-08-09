<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/../Clase/conectar.php");
include("../Clase/Norma.php");
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
        <script type="text/javascript" src="js/val_formacion_ev_c.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        <!--<script src="../jquery/jquery-1.6.3.min.js"></script>-->
        <script>
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
<!--<script language="javascript">
            function validar() {
                {
                    var correcto = true;
                    if (document.formmapa.documento.value == "")
                    {
                        window.alert("Digite el Documento");
                        return false;
                    }
                }
            }
        </script>-->
    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $ob = New Norma();
                $query3 = ("SELECT id_centro from centro_usuario where id_usuario=  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $centro = oci_fetch_array($statement3, OCI_BOTH);
                $query4 = ("SELECT codigo_regional from centro where id_centro=  '$centro[0]'");
                $statement4 = oci_parse($connection, $query4);
                $resp4 = oci_execute($statement4);
                $reg = oci_fetch_array($statement4, OCI_BOTH);
                ?>
                <ul id="tabs">
                    <li><a href="#" title="tab1">Solicitud</a></li>
                    <li><a href="#" title="tab2">Consulta</a></li>
                </ul>

                <div id="pestanas"> 
                    <div id="tab1">
                        <center><h2>Formulario de Datos Personales</h2>
                             <br>
                            <h4><label style="color: red">Por Favor registrar el número de cédula original tal cual esta registrada <br>
                                en el documento de identidad sin números extras al final.</label></h4>
                            <br>
                            <form name="formmapa" id="formmapa" action="guardar_sol_formacion.php" 
                                  method="post" onSubmit="return validar()" accept-charset="ISO-8859-1" enctype="multipart/form-data" >

                                <table>
                                    <tr><td><strong><label>Regional</label></strong></td><td><input type="text"  id="documento" readonly="readonly" name="regional" value="<?php echo $reg[0] ?>" ></input></td></td></tr>
                                    <tr><td><strong><label>Centro</label></strong></td><td><input type="text"  id="documento" readonly="readonly" name="centro" value="<?php echo $centro[0] ?>" ></input></td></td></tr>
                                    <tr><td><strong><label>Documento</label></strong></td><td><input type="text"  id="documento" name="documento" onkeypress="return soloLetras(event)"></input></td></tr>
                                    <tr><td><strong><label>Primer Apellido</label></strong></td><td><input type="text" style="text-transform: capitalize;" id="priapellido" name="priapellido"></input></td></tr>
                                    <tr><td><strong><label>Segundo Apellido</label></strong></td><td><input type="text" style="text-transform: capitalize;" id="segapellido" name="segapellido"></input></td></tr>
                                    <tr><td><strong><label>Nombres</label></strong></td><td><input type="text" id="nombres" style="text-transform: capitalize;" name="nombres"></input></td></tr>
                                    <tr><td><strong><label>Email</label></strong></td><td><input type="text" id="email" name="email"></input></td></tr>
                                    <tr><td><strong><label>Password</label></strong></td><td><input type="text" id="pass" name="pass"></input></td></tr>
                                    <tr><td><strong><label>Fecha Nacimiento</label></strong></td><td  class='BA'>
                                            <?php
                                            escribe_formulario_fecha_vacio("fn", "formmapa");
                                            ?>
                                        </td></tr>
                                    <tr><td><strong><label>Lugar Nacimiento</label></strong></td><td><input type="text" style="text-transform: capitalize;" id="lugarn" name="lugarn"></input></td></tr>
                                    <tr><td><strong><label>Fecha Expedido el Documento</label></strong></td><td  class='BA'>
                                            <?php
                                            escribe_formulario_fecha_vacio("fe", "formmapa");
                                            ?>
                                        </td></tr>
                                    <tr><td><strong><label>Lugar donde expide el Documento</label></strong></td><td><input type="text" style="text-transform: capitalize;" id="lugare" name="lugare"></input></td></tr>
                                    <tr><td><strong><label>Cargar Hoja de Vida-Soportes en Archivo<br> .RAR o .Zip (Segun perfil Evaluador)</label></strong></td><td><input type="file" name="archivo"></input></td>
                                    <input type="hidden" name="action" value="upload"></input></tr>
                                    <tr><td><strong><label>Evaluador</label></strong></td>
                                        <td><select name="op">
                                                <option value="1">Interno</option>
                                                <option value="2">Externo</option>
                                            </select></td></tr>
                                </table>
                                <p><label>
                                        <br></br>
                                        <input type = "submit" name = "insertar" id = "insertar" value = "Guardar Mis Datos" accesskey = "I" />
                                    </label></p>
                            </form>
                        </center>
                        <br></br>
                        <center><strong>NOTA IMPORTANTE</strong></center><br>
                        <table>
                            <tr>
                                <td>Selección de Fecha </td><td><img src="../imagess/segunda.jpg" width="350" height="350" ></img></td>
                                <td>Para Validar la Fecha de Nacimiento y Fecha de Expedicion de su Documento, debe seleccionar el mes y año,
                                    ubicado en la parte inferior (como se aprecia en la imagen), y dar clic en ir al mes; y por ultimo, seleccione
                                    el dia correspondiente.
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div>
                    <div id="tab2">
                        <center><h2>Consultar Registro de Información</h2></center>
                        <br>
                        <label>Para consultar si la información fue registrada, por favor digite el Número de Documento con el que hizo el registro, 
                            porteriormente de clic en consultar, automáticamente sabrá si la información efectivamente fue guardada con Éxito.</label>
                        <br><br>
                        <form name="frmConsulta" id="frmConsulta" action="consultar_reg_evaluador_curso.php" method="post"  >
                            <table>
                                <tr>
                                    <td><strong><label>Documento</label></strong></td>
                                    <td><input type="text"  id="documento" name="documento" onkeypress="return soloLetras(event)"></input></td>
                                </tr>
                            </table>
                            <br>
                            <input type = "submit" name = "insertar" id = "insertar" value = "Consultar" accesskey = "I" />
                        </form>
                        <div id="Resultado">
                            <?php
                            $res = $_GET['r'];

                            if ($res == 0) {
                                ?>
                                <h2><label style="color: #cd0a0a">Usuario No Registrado</label></h2>
                                <?php
                            } else if ($res > 0) {
                                ?>
                                <h2><label style="color: #23838b">Usuario Registrado</label></h2>
                                <br><br>
                                <table>
                                    <tr><td>Nombre</td><td><?php echo $_GET['nom']; ?></td></tr>
                                    <tr><td>Primer Apellido</td><td><?php echo $_GET['pape']; ?></td></tr>
                                    <tr><td>Segundo Apellido</td><td><?php echo $_GET['sape']; ?></td></tr>
                                    <tr><td>Email</td><td><?php echo $_GET['ema']; ?></td></tr>
                                    <tr><td>Documento</td><td><?php echo $_GET['docu']; ?></td></tr>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>