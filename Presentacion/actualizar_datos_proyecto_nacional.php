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
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$centros = $_POST['centro'];

//var_dump($centros);

function restaFechas($dFecIni, $dFecFin) {
    $dFecIni = str_replace("-", "", $dFecIni);
    $dFecIni = str_replace("/", "", $dFecIni);
    $dFecFin = str_replace("-", "", $dFecFin);
    $dFecFin = str_replace("/", "", $dFecFin);

    ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="js/proyecto_nacional.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>

<script src="../jquery/jquery.validate.mod.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/val_actualizar_datos_proyecto_nacional.js"></script>

        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
    </head>
    <body>
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>Actualizar Datos Generales del Proyecto Nacional</strong><br></br>


                    <form id="frmProyectoNacional" name="f2" action="guardar_actualizar_proyecto_nacional.php" method="post">
                        <?php 
                            $select = "SELECT *
                                    FROM T_PROYECTOS_NACIONALES
                                    WHERE ID_PROYECTO_NACIONAL = $_GET[proNac]";
                            
                            $objparse = oci_parse($connection, $select);
                            oci_execute($objparse);
                            $numRows = oci_fetch_all($objparse, $rows);
                        ?>
                        <input name="proNac" type="hidden" value="<?php echo $_GET['proNac']; ?>"/>
                        <table>
                            <tr>
                                <th>Nombre del Contacto</th>
                                <td>
                                    <input name="nombre_contacto" type="text" value="<?php echo $rows[NOMBRE_CONTACTO][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Teléfono del Contacto</th>
                                <td>
                                    <input name="telefono_contacto" type="text" value="<?php echo $rows[TELEFONO_CONTACTO][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Celular del Contacto</th>
                                <td>
                                    <input name="celular_contacto" type="text" value="<?php echo $rows[CECULAR_CONTACTO][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Email del Contacto</th>
                                <td>
                                    <input name="email_contacto" type="text" value="<?php echo $rows[EMAIL_CONTACTO][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Presupuesto SENA</th>
                                <td>
                                    <input name="presupuesto_sena" type="text" value="<?php echo $rows[PRESUPUESTO_SENA][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Presupuesto Entidad Externa</th>
                                <td>
                                    <input name="presupuesto_entidad" type="text" value="<?php echo $rows[PRESUPUESTO_ENTIDAD_EXTERNA][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                                <td>
                                    <textarea name="descripcion" style=" width: 99%;" ><?php echo $rows[DESCRIPCION][0]; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Numero Total de Candidatos</th>
                                <td>
                                    <input name="numero_total_candidatos" type="text" value="<?php echo $rows[NUMERO_TOTAL_CANDIDATOS][0]; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>Descripción Proyecto Regional</th>
                                <td>
                                    <textarea name="desc_pro_regional" style=" width: 99%;" ><?php echo $rows[DESC_PRO_REGIONAL][0]; ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <input type="submit" name="btnGuardar" id="btnGuardar" value="Guardar"/>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>