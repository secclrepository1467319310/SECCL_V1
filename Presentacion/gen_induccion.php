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
        <div id="">

            <?php
            require_once("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $proyecto = $_GET['proyecto'];
            $f = date("Y");

            $query2 = ("SELECT documento FROM usuario where usuario_id =  '$id'");
            $statement2 = oci_parse($connection, $query2);
            $resp2 = oci_execute($statement2);
            $doceva = oci_fetch_array($statement2, OCI_BOTH);

            $query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
            $statement5 = oci_parse($connection, $query5);
            $resp5 = oci_execute($statement5);
            $idc = oci_fetch_array($statement5, OCI_BOTH);

            $query3 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
            $statement3 = oci_parse($connection, $query3);
            $resp3 = oci_execute($statement3);
            $reg = oci_fetch_array($statement3, OCI_BOTH);

            $query4 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
            $statement4 = oci_parse($connection, $query4);
            $resp4 = oci_execute($statement4);
            $cen = oci_fetch_array($statement4, OCI_BOTH);

            $query7 = ("SELECT nombre_regional FROM regional where codigo_regional =  '$reg[0]'");
            $statement7 = oci_parse($connection, $query7);
            $resp7 = oci_execute($statement7);
            $nomreg = oci_fetch_array($statement7, OCI_BOTH);

            $query8 = ("SELECT nombre_centro FROM centro where codigo_centro =  '$cen[0]'");
            $statement8 = oci_parse($connection, $query8);
            $resp8 = oci_execute($statement8);
            $nomcen = oci_fetch_array($statement8, OCI_BOTH);

            $query9 = ("SELECT id_plan FROM proyecto where id_proyecto =  '$proyecto'");
            $statement9 = oci_parse($connection, $query9);
            $resp9 = oci_execute($statement9);
            $plan = oci_fetch_array($statement9, OCI_BOTH);

            $query91 = ("select count(*) from induccion where id_proyecto='$proyecto'");
            $statement91 = oci_parse($connection, $query91);
            $resp91 = oci_execute($statement91);
            $estadoind = oci_fetch_array($statement91, OCI_BOTH);

            $query10 = ("select fecha_registro from induccion where id_proyecto='$proyecto'");
            $statement10 = oci_parse($connection, $query10);
            $resp10 = oci_execute($statement10);
            $fechaform = oci_fetch_array($statement10, OCI_BOTH);
            
            $query11 = ("select id_induccion from induccion where id_proyecto='$proyecto'");
            $statement11 = oci_parse($connection, $query11);
            $resp11 = oci_execute($statement11);
            $induccion = oci_fetch_array($statement11, OCI_BOTH);
            
            ?>

            <br>
            <form id="asin" name="asin" action="guardar_requisitos_induccion.php" method="post" >
                <br></br>
                <img src="../images/logos/sena.jpg" align="left" ></img>
                <strong>FORMATO REGISTRO DE ASISTENCIA A INDUCCIÓN</strong><br></br>
                <strong> Evaluación y Certificación de Competencias Laborales</strong>
                <br></br>
                <table>
                    <tr>
                        <th>Regional</th><td><?php echo utf8_encode($nomreg[0]); ?></td>
                        <th>Centro</th><td><?php echo utf8_encode($nomcen[0]); ?></td>
                        <th>Proyecto</th><td><?php echo $f . "-" . $reg[0] . "-" . $cen[0] . "-" . $plan[0] . "-P" . $proyecto ?></td>
                        <th>Estado Inducción</th>
                        <?php
                        if ($estadoind[0] == 0) {
                            ?>
                            <td>Sin Formalizar<br><a href="formalizar_induccion.php?proyecto=<?php echo $proyecto ?>">Formalizar Inducción</a></td>
                            <?php
                        } else {
                            ?>
                            <td>Formalizada</td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Código Regional</th><td><?php echo $reg[0]; ?></td>
                        <th>Código Centro</th><td><?php echo $cen[0]; ?></td>
                        <th>Grupo</th><td></td>
                        <th>Fecha de Formalizada</th><td><?php echo $fechaform[0] ?></td>
                    </tr>
                </table>
                <br></br>
                <table>
                    <tr>
                        <th colspan="7">Identificación del Aspirante</th>
                        <th rowspan="2" width="3%">N<br/>°<br/><br/>I<br/>n<br/>t<br/>e<br/>n<br/>t<br/>o</th>
                        <th rowspan="2" width="15%">Inducción a la Norma</th>
                        <th rowspan="2" width="3%">R<br/>e<br/>q<br/>u<br/>i<br/>s<br/>i<br/>t<br/>o<br/>s</th>
                    <tr>
                        <th>N°</th>
                        <th width="10%">Consultar Portafolio</th>
                        <th width="10%">Documento de Identificación</th>
                        <th width="20%">Nombres Y Apellidos</th>
                        <th width="15%">Dirección de Residencia</th>
                        <th width="10%">Teléfono</th>
                        <th width="15%">Email</th>

                        <?php
                        $q2 = "select id_norma from evaluador_proyecto where id_proyecto=$proyecto and id_evaluador=$doceva[0]";
                        $sta2 = oci_parse($connection, $q2);
                        oci_execute($sta2);
                        $num = 0;
                        while ($row2 = oci_fetch_array($sta2, OCI_BOTH)) {


                            $query = "SELECT usuario.tipo_doc, usuario.documento,
usuario.nombre, usuario.primer_apellido,usuario.segundo_apellido,usuario.usuario_id,
usuario.email,usuario.direccion_residencia,
usuario.telefono,norma.codigo_norma,norma.id_norma,ic.estado,ic.id_induccion_candidato
from usuario
inner join induccion_candidato ic
on ic.id_candidato=usuario.usuario_id
inner join norma
on norma.id_norma=ic.id_norma
WHERE ic.id_induccion=$induccion[0] and ic.id_norma='$row2[ID_NORMA]'";
                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);
                            $num = 0;
                            while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                $n=$numero+1;;
                                if ($row["TIPO_DOC"] == 1) {
                                    $e = "TI";
                                } else if ($row["TIPO_DOC"] == 2) {
                                    $e = "CC";
                                } else {
                                    $e = "CE";
                                }

                                $query5 = ("select count(*) from induccion_candidato where id_norma=$row2[ID_NORMA] and id_candidato=$row[USUARIO_ID] and estado=1");
                                $statement5 = oci_parse($connection, $query5);
                                $resp5 = oci_execute($statement5);
                                $intento = oci_fetch_array($statement5, OCI_BOTH);
                                $i = $intento[0] + 1;
                                
                                echo "<tr><td><font face=\"verdana\">" .
                                $n . "</font></td>";
                                echo "<td width=\"\"><a href=\"./portafolio_candidato.php?idc=" . $row["USUARIO_ID"] . "\" TARGET=\"_blank\">
                                Consultar Portafolio</a></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["DOCUMENTO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["NOMBRE"] . " " . $row["PRIMER_APELLIDO"] . " " . $row["SEGUNDO_APELLIDO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["DIRECCION_RESIDENCIA"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["TELEFONO"] . "</font></td>";
                                echo "<td width=\"10%\"><font face=\"verdana\">" .
                                $row["EMAIL"] . "</font></td>";
                                echo "<td>$i</td>";
                                echo "<td width=\"\"><font face=\"verdana\">" .
                                $row["CODIGO_NORMA"] . "</font></td>";
                                if ($row[ESTADO]==0 || $row[ESTADO]==NULL) {
                                    echo "<td><input type=\"checkbox\" name=\"idc[]\" value=\"$row[ID_INDUCCION_CANDIDATO]\"></input>"
                                        . "<input type=\"hidden\" name=\"proyecto\" value=\"$proyecto\" ></input></td></tr>";
                                }else{
                                    echo "<td><input type=\"checkbox\" disabled checked ></input></input></td></tr>";
                                }
                                


                                $numero++;
                            }
                            $num++;
                        }
                        ?>                                  

                </table>
                <br>
                <center>
                    <p><label>
                  <input type="submit" name="Guardar" id="insertar" value="Guardar" accesskey="I" />
                </label></p>
                </center>
                
            </form>
            <br>
        </div>
        <div class="space">&nbsp;</div>
	<?php include ('layout/pie.php') ?>
        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>