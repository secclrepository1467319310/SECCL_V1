<style>
    .message-type{
        border-width: 1px;
        border-style: groove;
    }
    .message-title{
        float: left;
        width: 33%;
    }
    .message-title:hover{
        background-color: grey;
    }
    .messages{
        border-width: 1px;
        border-style: groove;
    }
</style>
<script>
    $(document).ready(function() {

        $(".message-title").each(function() {
            $(this).append("<b>(" + $(".messages-data[tab=" + $(this).attr("tab") + "]>div").length + ")</b>&nbsp;&nbsp;   <br/>   ")

        })
        $(".messages-data[tab=1]>div")

        $("[class*=msg_]").css("display", "none");
        $("[class=msg_1]").css("display", "block");
        $(".message-title").click(function() {
            if ($(this).attr("tab") == "1") {
                $("[class*=msg_]").css("display", "block");
            }
            $(".messages-data").css("display", "none");
            if ($(this).css("background-color") != "rgba(25, 25, 19, 0.2)") {
                $(".messages-data[tab=" + $(this).attr("tab") + "]").css("display", "block")
                $(".message-title").css("background-color", "");
                $(this).css("background-color", "rgba(25, 25, 19, 0.2)");

            } else {
                $(".message-title").css("background-color", "");
            }
        });


    });
</script>
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
        width: 40px;
        height: 45px;
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
</style>

<script>
    $(document).ready(function() {
        cargarCertificaciones = function() {
            console.log("Hola")
            $.ajax({
                url: "contadorCertificaciones.txt",
                success: function(s) {
//                    console.info(s)
//                    var cadena = (JSON.parse(s)).CNT[0];
//                    console.log(cadena)
                    var cadena = s;
                    $("center div", $(".contador")).remove()
                    for (i = 0; i < cadena.length; i++) {
                        $("center", $(".contador")).append("<div>" + cadena[i] + "</div>");
                    }
                },
                error: function(e) {
                    console.error(e)
                }
            })
        }
//        while (true) {
        cargarCertificaciones();
        setInterval('cargarCertificaciones()', 900000);
//        }

    })
</script>
<div id="header" class="bck_lightgray">
    <div class="total">
        <!--<a href="index.php">--><img src="../_img/header.jpg"/><!--</a>-->
        <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
        <div style="display: inline-block">
            <?php include('menus.php') ?> 
            <div class="menuLateral" style="margin-left: 70%">
                <b>TOTAL PERSONAS CERTIFICADAS 2016:</b>
                <div class="contador">
                    <center>

                    </center>
                </div>

            </div>
        </div>
        <div style="display: inline-block">
            <?php include ('layout/sesionActiva.php') ?>
        </div>
        <br/>
        <br/>
        <center><div style="alignment-adjust: central"></div></center>
        <div class="messages">

            <div class="message-title" tab="1">
                <img align="left" src="https://cdn3.iconfinder.com/data/icons/social-productivity-line-art-1/128/message2-128.png" width="30"/>
                &nbsp; Mensajes importantes:
            </div>
            <div class="message-title" tab="2">
                <img align="left"  src="https://cdn3.iconfinder.com/data/icons/social-productivity-line-art-1/128/message2-128.png" width="30"/>
                &nbsp; Mensajes por rol: 
            </div>
            <div  class="message-title"  tab="3">
                <img align="left"  src="https://cdn3.iconfinder.com/data/icons/social-productivity-line-art-1/128/message2-128.png" width="30"/>
                &nbsp; Mensajes para usuario: 
            </div>
            <br/>
            <br/>

            <div class="messages-data" tab="1">
                <?php
                //Mostrar mensajes para usuarios
                //mensajes para todos
                $qMensajesTodos = "SELECT * FROM MENSAJE WHERE DIRIGIDO_A='A' AND ESTADO='1' AND UBICACION='1'";
                $sMensajesTodos = oci_parse($conexion, $qMensajesTodos);
                oci_execute($sMensajesTodos);

                $contadorMensajes1 = 0;
                while ($rMensajesTodos = oci_fetch_array($sMensajesTodos, OCI_ASSOC)) {
                    $contadorMensajes1++;
                    echo "<div class='msg_$contadorMensajes1'  ><br/><div style='border: dotted;border-width: 1px;'>$rMensajesTodos[FECHA_REGISTRO] $rMensajesTodos[HORA_REGISTRO]=>" . utf8_encode(arreglarTexto($rMensajesTodos[TEXTO], $conexion)) . "<br/></div></div>";
                }
                if ($contadorMensajes1 == 0) {
                    echo "<br/>No hay mensajes<br/>";
                }
//                echo "</fieldset>";
                ?>
            </div>
            <div class="messages-data" style="display:none" tab="2">
                <?php
                //mensajes por rol
                $qMensajesRol = "SELECT * FROM MENSAJE WHERE DIRIGIDO_A='R_$_SESSION[rol]' AND ESTADO='1' AND UBICACION='1'";
                $sMensajesRol = oci_parse($conexion, $qMensajesRol);
                oci_execute($sMensajesRol);
                $contadorMensajes2 = 0;
                while ($rMensajesRol = oci_fetch_array($sMensajesRol, OCI_ASSOC)) {
                    $contadorMensajes2++;
                    echo "<br/><div style='border: dotted;border-width: 1px;'>$rMensajesRol[FECHA_REGISTRO] $rMensajesRol[HORA_REGISTRO]=>" . utf8_encode(arreglarTexto($rMensajesRol[TEXTO], $conexion)) . "</div><br/>";
                }
                if ($contadorMensajes2 == 0) {
                    echo "<br/>No hay mensajes<br/>";
                }
                ?>
            </div>
            <div class="messages-data"  style="display:none" tab="3">
                <?php
                //mensajes por usuario
                $qMensajesUsuario = "SELECT * FROM MENSAJE WHERE DIRIGIDO_A='U_$_SESSION[USUARIO_ID]' AND ESTADO='1' AND UBICACION='1'";
                $sMensajesUsuario = oci_parse($conexion, $qMensajesUsuario);
                oci_execute($sMensajesUsuario);
                $contadorMensajes3 = 0;
                while ($rMensajesUsuario = oci_fetch_array($sMensajesUsuario, OCI_ASSOC)) {
                    $contadorMensajes3++;
                    echo "<br/><div style='border: dotted;border-width: 1px;'>$rMensajesUsuario[FECHA_REGISTRO] $rMensajesUsuario[HORA_REGISTRO]=>" . utf8_encode(arreglarTexto($rMensajesUsuario[TEXTO], $conexion)) . "</div><br/>";
                }
                if ($contadorMensajes3 == 0) {
                    echo "<br/>No hay mensajes<br/>";
                }
                ?>

            </div>
            <br/>
        </div>

    </div> 

</div>