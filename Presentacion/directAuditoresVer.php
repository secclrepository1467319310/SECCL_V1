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
                
                <table>
                    <tr>
                        <th>REGIONAL</th>
                        <th>CENTRO</th>
                        <th>AUDITOR INTERNO</th>
                        <th>TIPO DOCUMENTO </th>
                        <th>DOCUMENTO AUDITOR</th>
                        <th>TELEFONO</th>
                        <th>IP</th>
                        <th>TELEFONO MOVIL</th>
                        <th>TIPO VINCULACION</th>
                        <th>CARGO GRADO</th>
                        <th>NUMERO CONTRATO</th>
                        <th>FECHA CONTRATO</th>
                        <th>EMAIL SENA</th>
                        <th>EMAIL ALTERNO</th>
                        <th>N° CERTIFICADO</th>
                        <th>FECHA CERTIFICACION</th>
                        <th>CERTIFICADO ISO 19011</th>
                        <th>FECHA CERTIFICACION ISO 19011</th>
                        <th>ENTIDAD CERTIFICADORA</th>
                        <th>FECHA AUDITORIA</th>
                        <th>FECHA AUDITORIA 2</th>
                        <th>OBSERVACIONES</th>
                        <th>FECHA REGISTRO</th>
                        <th>HORA REGISTRO</th>
                    </tr>
                    
                    <?php
                    $qdirectAuditores = "SELECT 
                                    R.CODIGO_REGIONAL ||'-'|| R.NOMBRE_REGIONAL AS NOMBRE_REGIONAL,
                                    C.CODIGO_CENTRO ||'-'|| C.NOMBRE_CENTRO AS NOMBRE_CENTRO,
                                    TDA.AUDITOR_INTERNO,
                                    TD.DESCRIPCION AS TIPO_DOCUMENTO,
                                    TDA.DOCUMENTO_AUDITOR,
                                    TDA.TELEFONO,
                                    TDA.IP,
                                    TDA.TELEFONO_MOVIL,
                                    TDA.TIPO_VINCULACION,
                                    TDA.CARGO_GRADO,
                                    TDA.NUMERO_CONTRATO,
                                    TDA.FECHA_CONTRATO,
                                    TDA.EMAIL_SENA,
                                    TDA.EMAIL_ALTERNO,
                                    TDA.N_CERTIFICADO,
                                    TDA.FECHA_CERTIFICACION,
                                    TDA.CERTIFICADO_ISO19011,
                                    TDA.FECHA_CERTIFICACION_ISO19011,
                                    TDA.ENTIDAD_CERTIFICADORA,
                                    TDA.FECHA_AUDITORIA,
                                    TDA.FECHA_AUDITORIA_2,
                                    TDA.OBSERVACIONES,
                                    TDA.FECHA_REGISTRO,
                                    TDA.HORA_REGISTRO "
                            . "FROM T_DIREC_AUDITORES TDA "
                            . "JOIN CENTRO C "
                            . "ON (TDA.CODIGO_CENTRO=C.CODIGO_CENTRO) "
                            . "JOIN REGIONAL R "
                            . "ON(C.CODIGO_REGIONAL=R.CODIGO_REGIONAL) "
                            . "JOIN TIPO_DOC TD "
                            . "ON (TDA.TIPO_DOCUMENTO=TD.ID_TIPO_DOC)";
                    $sdirectAuditores = oci_parse($connection, $qdirectAuditores);
                    oci_execute($sdirectAuditores);
                    //echo $qdirectAuditores;
                    while ($rdirectAuditores = oci_fetch_array($sdirectAuditores, OCI_ASSOC))
                    {
                        echo "<tr>";
                        echo "<td>$rdirectAuditores[NOMBRE_REGIONAL]</td>";
                        echo "<td>$rdirectAuditores[NOMBRE_CENTRO]</td>";
                        echo "<td>$rdirectAuditores[AUDITOR_INTERNO]</td>";
                        echo "<td>$rdirectAuditores[TIPO_DOCUMENTO]</td>";
                        echo "<td>$rdirectAuditores[DOCUMENTO_AUDITOR]</td>";
                        echo "<td>$rdirectAuditores[TELEFONO]</td>";
                        echo "<td>$rdirectAuditores[IP]</td>";
                        echo "<td>$rdirectAuditores[TELEFONO_MOVIL]</td>";
                        echo "<td>$rdirectAuditores[TIPO_VINCULACION]</td>";
                        echo "<td>$rdirectAuditores[CARGO_GRADO]</td>";
                        echo "<td>$rdirectAuditores[NUMERO_CONTRATO]</td>";
                        echo "<td>$rdirectAuditores[FECHA_CONTRATO]</td>";
                        echo "<td>$rdirectAuditores[EMAIL_SENA]</td>";
                        echo "<td>$rdirectAuditores[EMAIL_ALTERNO]</td>";
                        echo "<td>$rdirectAuditores[N_CERTIFICADO]</td>";
                        echo "<td>$rdirectAuditores[FECHA_CERTIFICACION]</td>";
                        echo "<td>$rdirectAuditores[CERTIFICADO_ISO19011]</td>";
                        echo "<td>$rdirectAuditores[FECHA_CERTIFICACION_ISO19011]</td>";
                        echo "<td>$rdirectAuditores[ENTIDAD_CERTIFICADORA]</td>";
                        echo "<td>$rdirectAuditores[FECHA_AUDITORIA]</td>";
                        echo "<td>$rdirectAuditores[FECHA_AUDITORIA_2]</td>";
                        echo "<td>$rdirectAuditores[OBSERVACIONES]</td>";
                        echo "<td>$rdirectAuditores[FECHA_REGISTRO]</td>";
                        echo "<td>$rdirectAuditores[HORA_REGISTRO]</td>";
                        echo "</tr>";
                    }
                    ?>
                    
                </table>
                
            </div>
        </div>
<?php include ('layout/pie.php') ?>
    </body>
</html>