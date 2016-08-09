<?php 
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
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
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

    </head>
    <body onload="inicio()">
	<?php include ('layout/cabecera.php') ?>
        <div id="contenedorcito">
            
            <?php
                require_once("../Clase/conectar.php");
                $idca = $_GET["idca"];
                $norma = $_GET["norma"];
                $grupo = $_GET["grupo"];
                $proyecto = $_GET["proyecto"];
                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                
                //---obtener apellido
$strSQL10 = "select obs_evaluador from observaciones_inscripcion where id_norma=$norma and id_candidato=$idca and id_proyecto=$proyecto and grupo=$grupo";
$statement10 = oci_parse($connection, $strSQL10);
$resp10 = oci_execute($statement10);
$obseva = oci_fetch_array($statement10, OCI_BOTH);
//---obtener apellido
$strSQL11 = "select obs_apoyo from observaciones_inscripcion where id_norma=$norma and id_candidato=$idca and id_proyecto=$proyecto and grupo=$grupo";
$statement11 = oci_parse($connection, $strSQL11);
$resp11 = oci_execute($statement11);
$obsapoyo = oci_fetch_array($statement11, OCI_BOTH);
//---obtener apellido
$strSQL12 = "select obs_lider from observaciones_inscripcion where id_norma=$norma and id_candidato=$idca and id_proyecto=$proyecto and grupo=$grupo";
$statement12 = oci_parse($connection, $strSQL12);
$resp12 = oci_execute($statement12);
$obslider = oci_fetch_array($statement12, OCI_BOTH);
//---obtener apellido
$strSQL13 = "select chek_evaluador from inscripcion where id_proyecto=$proyecto and id_norma=$norma and id_candidato=$idca and grupo=$grupo";
$statement13 = oci_parse($connection, $strSQL13);
$resp13 = oci_execute($statement13);
$chkeva = oci_fetch_array($statement13, OCI_BOTH);
//---obtener apellido
$strSQL14 = "select chek_lider from inscripcion where id_proyecto=$proyecto and id_norma=$norma and id_candidato=$idca and grupo=$grupo";
$statement14 = oci_parse($connection, $strSQL14);
$resp14 = oci_execute($statement14);
$chklider = oci_fetch_array($statement14, OCI_BOTH);
//---obtener apellido
$strSQL15 = "select nombre from usuario where usuario_id='$idca'";
$statement15 = oci_parse($connection, $strSQL15);
$resp15 = oci_execute($statement15);
$ncandidato = oci_fetch_array($statement15, OCI_BOTH);
//---obtener apellido
$strSQL16 = "select primer_apellido from usuario where usuario_id='$idca'";
$statement16 = oci_parse($connection, $strSQL16);
$resp16 = oci_execute($statement16);
$papellido = oci_fetch_array($statement16, OCI_BOTH);
//---obtener apellido
$strSQL17 = "select segundo_apellido from usuario where usuario_id='$idca'";
$statement17 = oci_parse($connection, $strSQL17);
$resp17 = oci_execute($statement17);
$sapellido = oci_fetch_array($statement17, OCI_BOTH);
//---obtener apellido
$strSQL18 = "select codigo_norma from norma where id_norma='$norma'";
$statement18 = oci_parse($connection, $strSQL18);
$resp18 = oci_execute($statement18);
$codigoncl = oci_fetch_array($statement18, OCI_BOTH);
//---obtener apellido
$strSQL19 = "select version_norma from norma where id_norma='$norma'";
$statement19 = oci_parse($connection, $strSQL19);
$resp19 = oci_execute($statement19);
$vrs = oci_fetch_array($statement19, OCI_BOTH);
//---obtener apellido
$strSQL20 = "select titulo_norma from norma where id_norma='$norma'";
$statement20 = oci_parse($connection, $strSQL20);
$resp20 = oci_execute($statement20);
$titulo = oci_fetch_array($statement20, OCI_BOTH);
//---obtener apellido
$strSQL21 = "select estado from inscripcion where id_norma=$norma and id_candidato=$idca and id_proyecto=$proyecto and grupo=$grupo";
$statement21 = oci_parse($connection, $strSQL21);
$resp21= oci_execute($statement21);
$estado = oci_fetch_array($statement21, OCI_BOTH);
//---
$strSQL22 = "select chek_apoyo from inscripcion where id_proyecto=$proyecto and id_norma=$norma and id_candidato=$idca and grupo=$grupo";
$statement22 = oci_parse($connection, $strSQL22);
$resp22 = oci_execute($statement22);
$chklapoyo = oci_fetch_array($statement22, OCI_BOTH);


                ?>
            
            <br>
            <center>
                <form id="frmRegEsquema" name="frmRegEsquema" 
                      action="guardar_inscripcion_a.php?proyecto=<?php echo $proyecto ?>&idca=<?php echo $idca ?>&norma=<?php echo $norma ?>&grupo=<?php echo $grupo?>" enctype="multipart/form-data" method="post">
               <br></br>
                    <img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>FORMALIZAR INSCRIPCIÓN</strong><br></br>
                    <strong> Evaluación y Certificación de Competencias Laborales</strong>
                    <br></br>
                    <table>
                        <tr>
                            <th>Nombre del Candidato</th>
                            <th>Código de Norma</th>
                            <th>Versión de la Norma</th>
                            <th>Título de la Norma</th>
                            <th>Estado Inscripción</th>
                            <th>Consultar Portafolio</th>
                        </tr>
                        <tr>
                            <td><?php echo $ncandidato[0].' '.$papellido[0].' '.$sapellido[0] ?></td>
                            <td><?php echo $codigoncl[0] ?></td>
                            <td><?php echo $vrs[0] ?></td>
                            <td><?php echo utf8_encode($titulo[0]) ?></td>
                            <?php
                            if($estado[0]==0){
                            ?>
                            <td>Sin Formalizar</td>
                            <?php
                            }else{
                            ?>
                            <td>Formalizado</td>
                            <?php
                            }
                            ?>
                            <td><a href="consulta_portafolio_candidato.php?proyecto=<?php echo $proyecto ?>&idca=<?php echo $idca ?>&norma=<?php echo $norma ?>&grupo=<?php echo $grupo?>" target="blank">Consultar</a></td>
                        </tr>
                    </table>
                    <br>
                <table>
                    <tr>
                        <th>Aprobado por el Evaluador</th><td><?php if($chkeva[0]==1){ echo "Si"; }else{ echo "No"; } ?></td>
                        <th>Aprobado por el Líder</th><td><?php if($chklider[0]==1){ echo "Si"; }else{ echo "No"; } ?></td>
                        <?php
                        if($chklider[0]==0){
                        ?>
                        <th>Aprobado por el Apoyo</th><td>No</td>
                        <?php
                        }else if($chklapoyo[0]==1){
                        ?>
                        <th>Aprobado por el Apoyo</th><td>Si</td>
                        <?php
                        }else{
                        ?>
                        <th>Aprobado por el Apoyo</th><td><input name="check_apoyo"  value="1" type="checkbox"></td>
                        <?php } ?>
                    </tr>
                </table>
                    <br>
                    <center><strong>Observaciones</strong></center>
                    <br>
                    <table>
                        <tr>
                        <th>Observaciones Evaluador</th>
                        <th>Observaciones Líder</th>
                        <th>Observaciones Apoyo</th>
                        </tr>
                        <tr>
                            <td><textarea cols="30" rows="3" readonly ><?php echo $obseva[0] ?></textarea></td></td>
                            <td><textarea cols="30" rows="3" readonly ><?php echo $obslider[0] ?></textarea></td></td>
                            <td><textarea cols="30" name="obs_apoyo" rows="3" ><?php echo $obsapoyo[0] ?></textarea></td></td>
                        </tr>
                    </table>
                    <br>
                        <p><label>
                                <input type="submit" name="Guardar" id="insertar" value="Guardar" accesskey="I" />
                        </label></p>
                        <br></br>
            </form>
                </center>
<!--            <center><br>
            <input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
            </center>-->
        </div>
	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>