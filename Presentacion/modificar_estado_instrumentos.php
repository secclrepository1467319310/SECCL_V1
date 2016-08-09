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
        <script src="js/val_actualizar_instrumentos.js" type="text/javascript"></script>
        <script src="js/cargar_instrumentos.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
    </head>
    <body>
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">
                <?php
                $query3 = ("SELECT cu.id_centro, ce.codigo_centro FROM centro_usuario cu 
                    INNER JOIN centro ce ON cu.id_centro = ce.id_centro
                    where id_usuario =  '$id'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $idc = oci_fetch_array($statement3, OCI_BOTH);


                $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
                $statement1 = oci_parse($connection, $query1);
                $resp1 = oci_execute($statement1);
                $reg = oci_fetch_array($statement1, OCI_BOTH);

                $query2 = ("SELECT codigo_centro FROM centro  where id_centro =  '$idc[0]'");
                $statement2 = oci_parse($connection, $query2);
                $resp2 = oci_execute($statement2);
                $cen = oci_fetch_array($statement2, OCI_BOTH);
                ?>

                <center><img src="../images/logos/sena.jpg" align="left" ></img>
                    <strong>Instrumentos</strong><br></br>
                    <form id="frmProyectoNacional" name="f2" action="actualizar_estado_instrumentos.php" method="post">
                        
                        <a id="cleanfilters" href="#">Limpiar Filtros</a>
                        <br>
                        <div id="divMesas">
                            <table id="demotable1" >
                                <thead>
                                    <tr>
                                        <th><strong>Código Mesa</strong></th>
                                        <th><strong>Nombre Mesa</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr>
                                </thead>
                                <tbody id="tblMesa"></tbody>
                            </table>
                            <div class="valError"></div>
                            <input type="button" name="btnInsertar" id="btnInsertar" value="Siguiente"/>
                        </div>
                        <div id="divNormas">
                            <table id="demotable1" >
                                <thead>
                                    <tr>
                                        <th><strong>Código Norma</strong></th>
                                        <th><strong>Versión Norma</strong></th>
                                        <th><strong>Título Norma</strong></th>
                                        <th><strong>Fecha Expiración Norma</strong></th>
                                        <th><strong>Seleccionar</strong></th>
                                    </tr>
                                </thead>
                                <tbody id="tblNormas"></tbody>
                            </table>
                            <div class="valError"></div>
                            <br>
                            <input type="button" name="btnRegresar" id="btnRegresar" value="Regresar"/>
                            <input type="submit" name="btnGuardar" id="btnGuardar" value="Guardar"/>
                        </div>
                    </form>
                </center>
            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>