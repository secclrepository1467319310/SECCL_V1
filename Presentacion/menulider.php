<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

require_once('../Clase/conectar.php');
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
        <!--<script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>-->
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <link type="text/css" href="../css/encuestaLive.css" rel="stylesheet">


        <script src="../jquery/jquery-1.9.1.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="../jquery/jquery-ui.js"></script>
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
            $(document).ready(function() {
                dialog =  $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 300,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Aceptar": function() {
                            dialog.dialog("close");
                        }
                    },
                    close: function() {
                        dialog.dialog("close");
                    }
                });
                dialog.dialog("open");
            })
        </script>


    </head>
    <body onload="inicio()">

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $qSolicitudesPendientes = "SELECT ttob.descripcion,tob.id_operacion,tob.id_proyecto,tob.id_norma,n.codigo_norma,tob.n_grupo, ttes.detalle, c.codigo_centro,u.usuario_login,u.usuario_password,u.nombre,u.primer_apellido
                    FROM t_operacion_banco tob 
                    JOIN t_tipo_operacion_banco ttob ON (ttob.id_operacion=tob.id_t_operacion)
                    JOIN t_estado_solicitud tes ON (tes.id_solicitud=tob.id_operacion)
                    JOIN (SELECT MAX(ts.id_estado_solicitud) max_id_sol,ts.id_solicitud FROM t_estado_solicitud ts GROUP BY ts.id_solicitud) max_tes ON (max_tes.max_id_sol=tes.id_estado_solicitud)
                    JOIN t_tipo_estado_solicitud ttes ON (ttes.id_tipo_estado_solicitud=tes.id_tipo_estado_solicitud)
                    JOIN proyecto p ON (p.id_proyecto=tob.id_proyecto AND  SUBSTR(p.fecha_elaboracion, 7,4) = 2016)
                    JOIN norma n ON (n.id_norma=tob.id_norma AND n.activa='1')
                    JOIN centro c ON (c.codigo_centro=p.id_centro)
                    JOIN centro_usuario cu ON (cu.id_centro=c.id_centro)
                    JOIN usuario u ON (cu.id_usuario=u.usuario_id AND u.rol_id_rol='4' AND u.estado='1')
                    WHERE tes.id_tipo_estado_solicitud IN ('2')
                    AND  cu.id_usuario='$id'  
                    ORDER BY tob.id_proyecto ASC";
                $sSolicitudePendientes = oci_parse($conexion, $qSolicitudesPendientes);
                oci_execute($sSolicitudePendientes);
                $conSolPendientes = "";
                while ($rSolcicitudesPendientes = oci_fetch_array($sSolicitudePendientes, OCI_ASSOC)) {
                    $conSolPendientes.= "<a style='color:orange' href='http://seccl.sena.edu.co/Presentacion/consultar_grupo.php?proyecto=$rSolcicitudesPendientes[ID_PROYECTO]&n=$rSolcicitudesPendientes[CODIGO_NORMA]&norma=$rSolcicitudesPendientes[ID_NORMA]&fecha".date('d/m/Y')."&grupo=$rSolcicitudesPendientes[N_GRUPO]#f1'>Proyecto: $rSolcicitudesPendientes[ID_PROYECTO], Norma: $rSolcicitudesPendientes[CODIGO_NORMA], Grupo:$rSolcicitudesPendientes[N_GRUPO]</a><br/>";
                }
                if ($conSolPendientes != "") {
                    ?>
                    <div id="dialog-form" class="hidden" title="Solicitudes pendientes">
                        <p class="validateTips">Solicitudes pendientes</p>
                        Señor Líder, se ha detectado que tiene solicitudes pendientes en los siguientes proyectos: <br/><br/>
                        <?= $conSolPendientes ?>
                        <br/>
                        Presione sobre el identificador del proyecto para ver el grupo.
                    </div>
                    <?php
                }
                ?>
                <?php
                echo '<font><strong>Bienvenido (a) : ', utf8_encode($nom), ' ', utf8_encode($ape), ' </strong></font>';
                ?>
                <center>
                    Bienvenidos al Sistema de Evaluación y Certificación de Competencias Laborales - SECCL
                </center>
            </div>
        </div>
<?php include ('layout/pie.php') ?>

    </body>
</html>