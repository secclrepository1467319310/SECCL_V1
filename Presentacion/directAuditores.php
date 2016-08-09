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

require_once('../Clase/conectar.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../jquery/jquery.validate.mod.js"></script>
        
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
        }, "Formato no valido");
        
        $(document).ready(function(){
            //Validaciones
            $("[name=f1]").validate({
                rules:{
                    regional:{
                        required:true,
                        number:true
                    },
                    centro:{
                        required:true,
                        number:true
                    },
                    auditor:{
                        required:true,
                        maxlength:255
                    },
                    t_documento:{
                        required:true,
                        number:true,
                        maxlength:1
                        
                    },
                    documento:{
                        required:true,
                        number:true,
                        maxlength:20    
                    },
                    telefono:{
                        required:true,                        
                        maxlength:20    
                        
                    },
                    ip:{
                        required:true,
                        number:true,                        
                        maxlength:10 
                    },
                    telefonomovil:{
                        required:true,
                        number:true,                        
                        maxlength:30                       
                    },
                    t_vinculacion:{
                        required:true,                        
                        maxlength:30 
                    },
                    cargo_grado:{
                        required:true,                        
                        maxlength:100
                    },
                    numero_contrato:{
                        required:true,
                        number:true,                        
                        maxlength:30 
                    },
                    fechacontrato:{
                        required:true
                    },
                    emailsena:{
                        email:true,
                        pattern:".+@sena.edu.co",                        
                        maxlength:100 
                    },
                    emailalterno:{
                        email:true,                        
                        maxlength:100 
                    },
                    ncertificado:{
                        number:true,                        
                        maxlength:100 
                    },
                    fechacertificacion:{
                        
                    },
                    certificadoiso19011:{
                        required:true,                        
                        maxlength:100 
                    },
                    fechacertificadoiso19011:{
                        
                    },
                    entidadcertificadora:{
                        required:true,                        
                        maxlength:100
                    },
                    fechaauditoria:{
                        required:true
                    },
                    fechaauditoria2:{
                        required:true
                    },
                    observaciones:{                                               
                        maxlength:300 
                    }
                },
                messages:{
                    emailsena:{
                        pattern:"El correo debe ser sena "
                    }
                }
            });
            
            ////Configurar campos de fechas 
            $(".datepick").attr("readonly","readonly");
            $(".datepick").datepicker({
                dateFormat:'dd/mm/yy',                      
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                changeMonth:true
            });
            var cargarcentro=function(){
                ///////////////////////obtener centros por regional
                $.ajax({
                    method: "POST",
                    url:"ProyectosAuditoresAjax.php",
                    data:{
                        v1:"prueba",
                        regional:$("[name=regional]").val(),

                    },
                    success:function(e){
                        //console.log(e);
                        var element=$("[name='centro']");
                        element.text("");
                        element.append("<option value></option>");
                        element.append(e);

                    }
                })
            };
            cargarcentro(); 
            $("[name=regional]").change(function(){cargarcentro()});
            
        });
        </script>


    </head>
    <body onload="inicio()">
        <?php 
            //var_dump($_SERVER);
        ?>
<?php include ('layout/cabecera.php') ?>
        <?php require_once('../Clase/conectar.php');
        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <center>
                    <form action="guardarDirectAdutores.php" method="post" name="f1">
                        <table>
                            <tr>
                                <td><label for="regional">REGIONAL:</label></td>
                                <td>
                                    <select name="regional" id="regional" style="width:220px">
                                        <option value>SELECCIONE</option>
                                        <?php
                                        $regional = "SELECT * FROM REGIONAL";
                                        $sregional = oci_parse($connection, $regional);
                                        oci_execute($sregional);

                                        while ($rregional = oci_fetch_array($sregional, OCI_ASSOC))
                                        {
                                            echo "<option value=\"$rregional[CODIGO_REGIONAL]\"  " . ($rregional[CODIGO_REGIONAL] == $_gregional ? "selected" : "") . ">$rregional[CODIGO_REGIONAL]-" . utf8_encode($rregional[NOMBRE_REGIONAL]) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label >CENTRO</label></td>
                                <td>                    
                                    <select name="centro"  style="width:220px">
                                        <option value="">SELECCIONE</option>                                    
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>AUDITOR INTERNO</label></td>
                                <td><input type="text" name="auditor"/></td>
                            </tr>
                            <tr>
                                <td><label>TIPO DOCUMENTO</label></td>
                                <td>
                                    <select name="t_documento">
                                        <option value>SELECCIONE</option>
                                        <?php
                                        $qtipodocs = "SELECT * FROM TIPO_DOC";
                                        $stipodocs = oci_parse($connection, $qtipodocs);
                                        oci_execute($stipodocs);

                                        while ($rtipodocs = oci_fetch_array($stipodocs, OCI_ASSOC))
                                        {
                                            echo "<option value=\"$rtipodocs[ID_TIPO_DOC]\" >" . utf8_encode($rtipodocs[DESCRIPCION]) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>DOCUMENTO AUDITOR</label></td>
                                <td><input type="text" name="documento"/></td>
                            </tr>
                            <tr>
                                <td><label>TELEFONO</label></td>
                                <td><input type="text" name="telefono"/></td>
                            </tr>
                            <tr>
                                <td><label>IP</label></td>
                                <td><input type="text" name="ip"/></td>
                            </tr>
                            <tr>
                                <td><label>TELEFONO MÓVIL</label></td>
                                <td><input type="text" name="telefonomovil"/></td>
                            </tr>
                            <tr>
                                <td><label>TIPO DE VINCULACIÓN</label></td>
                                <td>
                                    <select name="t_vinculacion">
                                        <option value>SELECCIONE</option>
                                        <option value="PLANTA">PLANTA</option>
                                        <option value="CONTRATO">CONTRATO</option>
                                        <option value="NOMBRAMIENTO PROVISIONAL">NOMBRAMIENTO PROVISIONAL</option>
                                    </select>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td><label>Cargo grado</label></td>
                                <td><input type="text" name="cargo_grado"/></td>
                            </tr>
                            <tr>
                                <td><label>Número contrato</label></td>
                                <td><input type="text" name="numero_contrato"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha contrato</label></td>
                                <td><input class="datepick" type="text" name="fechacontrato"/></td>
                            </tr>
                            <tr>
                                <td><label>Email SENA</label></td>
                                <td><input type="text" name="emailsena"/></td>
                            </tr>
                            <tr>
                                <td><label>Email alterno</label></td>
                                <td><input type="text" name="emailalterno"/></td>
                            </tr>
                            <tr>
                                <td><label>N° certificado</label></td>
                                <td><input type="text" name="ncertificado"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha certificación</label></td>
                                <td><input class="datepick" type="text" name="fechacertificacion"/></td>
                            </tr>
                            <tr>
                                <td><label>Certificado ISO 19011</label></td>
                                <td><input type="text" name="certificadoiso19011"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha certificado ISO 19011</label></td>
                                <td><input class="datepick" type="text" name="fechacertificadoiso19011"/></td>
                            </tr>
                            <tr>
                                <td><label>Entidad certificadora</label></td>
                                <td><input type="text" name="entidadcertificadora"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha auditoria </label></td>
                                <td><input class="datepick" type="text" name="fechaauditoria"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha auditoria 2</label></td>
                                <td><input class="datepick" type="text" name="fechaauditoria2"/></td>
                            </tr>
                            <tr>
                                <td><label>Observaciones</label></td>
                                <td><textarea type="text" name="observaciones"></textarea></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="guardar"/></td>
                            </tr>
                        </table>
                    </form>
                </center>
            </div>
        </div>
<?php include ('layout/pie.php') ?>
    </body>
</html>