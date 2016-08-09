<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
if ($_GET[tipo] == 1) {
    $repo = ' Solicitudes Atendidas';
} else if ($_GET[tipo] == 2) {
    $repo = ' Solicitudes Pendientes';
} else if ($_GET[tipo] == 4) {
    $repo = ' Solicitudes Devueltas';
}
header("Content-Disposition: attachment; filename=Reporte$repo-ASESOR.$_GET[fechainicial]-$_GET[fechafinal].xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
if($_GET[fechainicial]=="" ||$_GET[fechafinal]=="" ){
    $where="";
}else{
    $where="and TOB.FECHA_REGISTRO BETWEEN '".$_GET[fechainicial]."' AND '".$_GET[fechafinal]."' ";
}
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php
            if ($_GET[tipo] == 1) {
                echo 'Solicitudes Atendidas';
            } else if ($_GET[tipo] == 2) {
                echo 'Solicitudes Pendientes';
            } else if ($_GET[tipo] == 4) {
                echo 'Solicitudes Devueltas';
            }
            ?>
        </title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;">
                        <font size="+2">
                            <?php
                            if ($_GET[tipo] == 1) {
                                echo 'Solicitudes Atendidas ';
                            } else if ($_GET[tipo] == 2) {
                                echo 'Solicitudes Pendientes ';
                            } else if ($_GET[tipo] == 4) {
                                echo 'Solicitudes Devueltas ';
                            }
                            echo $f.".";
                            ?> 
                            Entre: <?=$_GET[fechainicial]?>-<?=$_GET[fechafinal]?>
                            <br />
                        </font>
                    </div>
                </th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr style=' background: gray; color: white;'>
                <th>N°</th>
                <th>Radicado Solicitud</th>
                <th>Tipo Solicitud</th>
                <th>Código Kit</th>
                <th>Mesa</th>
                <th>Código Regional</th>
                <th>Regional</th>
                <th>Código Centro</th>
                <th>Centro</th>
                <th>Líder</th>
                <th>Entidad</th>
                <th>Fecha Solicitud</th>
                <th>Hora Solicitud</th>
                <th>Fecha Estado</th>
                <th>Hora Estado</th>
                <th>Asesor Banco</th>
                <th>Observación Líder</th>
                <th>Observación Asesor</th>
                <th>Correo</th>
                <th>Observación administrador banco</th>
            </tr>
            <?php
            $num = 0;
            
             $sqlSelSolicitudes = "SELECT DISTINCT TES.ID_SOLICITUD 
                                        FROM T_OPERACION_BANCO TOB 
                                        INNER JOIN T_SOLICITUDES_ASIGNADAS SA 
                                            ON TOB.ID_OPERACION = SA.ID_SOLICITUD 
                                        INNER JOIN T_ESTADO_SOLICITUD TES 
                                            ON TOB.ID_OPERACION = TES.ID_SOLICITUD
                                        WHERE SA.USUARIO_ASIGNADO = '$_GET[id]' AND SA.ESTADO = '1'
                                            $where
                                        ORDER BY TES.ID_SOLICITUD ASC";

            $objSelSolicitudes = oci_parse($connection, $sqlSelSolicitudes);
            oci_execute($objSelSolicitudes);
            $numrowsSelSolicitudes = oci_fetch_all($objSelSolicitudes, $rowsSelSolicitudes);
//            var_dump($numrowsSelSolicitudes);
            for ($i = 0; $i < $numrowsSelSolicitudes; $i++) {

                $sqlSelIdmax = 'SELECT ID_ESTADO_SOLICITUD
                                        FROM T_ESTADO_SOLICITUD
                                        WHERE ID_ESTADO_SOLICITUD IN (
                                            SELECT MAX(TES.ID_ESTADO_SOLICITUD) AS ID_ESTADO_SOLICITUD
                                            FROM T_ESTADO_SOLICITUD TES
                                            WHERE ID_SOLICITUD = ' . $rowsSelSolicitudes[ID_SOLICITUD][$i] . ')
                                            AND ID_TIPO_ESTADO_SOLICITUD = ' . $_GET[tipo];

                $objSelIdmax = oci_parse($connection, $sqlSelIdmax);
                oci_execute($objSelIdmax);
                oci_fetch_all($objSelIdmax, $rowsSelIdmax);

                $query = "SELECT P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,TOB.HORA_REGISTRO,SA.ID_SOLICITUD,P.NIT_EMPRESA,TOB.OBSERVACION,USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO,USUA.NOMBRE AS NOMBREA,USUA.PRIMER_APELLIDO AS PRIMER_APELLIDOA,USUA.SEGUNDO_APELLIDO AS SEGUNDO_APELLIDOA,TES.DETALLE,TES.CODIGO_INSTRUMENTO,TB.DESCRIPCION
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN T_SOLICITUDES_ASIGNADAS SA ON TOB.ID_OPERACION = SA.ID_SOLICITUD
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    INNER JOIN T_ESTADO_SOLICITUD TES ON TOB.ID_OPERACION = TES.ID_SOLICITUD
                                                    INNER JOIN USUARIO USU ON TOB.USU_REGISTRO = USU.USUARIO_ID
                                                    INNER JOIN USUARIO USUA ON SA.USUARIO_ASIGNADO = USUA.USUARIO_ID
                                                    INNER JOIN T_TIPO_OPERACION_BANCO TB ON TOB.ID_T_OPERACION = TB.ID_OPERACION
                                                    WHERE TES.ID_ESTADO_SOLICITUD = '" . $rowsSelIdmax[ID_ESTADO_SOLICITUD][0] . "' and sa.estado='1'";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
                $anterior = 1;
                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                    $query3 = ("SELECT CODIGO_NORMA, NOMBRE_MESA FROM NORMA NOR "
                            . "INNER JOIN MESA MES "
                            . "ON NOR.CODIGO_MESA = MES.CODIGO_MESA "
                            . "WHERE ID_NORMA='$row[ID_NORMA]'");
                    $statement3 = oci_parse($connection, $query3);
                    $resp3 = oci_execute($statement3);
                    $cnorma = oci_fetch_array($statement3, OCI_BOTH);

                    $query222 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $row['ID_SOLICITUD'] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                    $statement222 = oci_parse($connection, $query222);
                    oci_execute($statement222);
                    $rows222 = oci_fetch_array($statement222, OCI_BOTH);

                    $query223 = "SELECT ES.ID_SOLICITUD, TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD =  $row[ID_SOLICITUD] AND (ES.ID_TIPO_ESTADO_SOLICITUD = 2 OR  ES.ID_TIPO_ESTADO_SOLICITUD = 3) ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                    $statement223 = oci_parse($connection, $query223);
                    oci_execute($statement223, OCI_DEFAULT);
                    $rowsNum223 = oci_fetch_all($statement223, $rows223);


//                                    var_dump($rows222);
                    $queryProyecto = "SELECT *
                                                FROM PROYECTO
                                                WHERE ID_PROYECTO = " . $row['ID_PROYECTO'];
                    $statementProyecto = oci_parse($connection, $queryProyecto);
                    oci_execute($statementProyecto);
                    $proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
                    echo "<tr><td><font face=\"verdana\">" .
                    ($num + 1) . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    'R' . $row["ID_REGIONAL"] . '-' . 'C' . $row ["ID_CENTRO"] . '-P' . $row["ID_PROYECTO"] . '-' . $cnorma[0] . '-' . $row["N_GRUPO"] . '-' . $row["ID_OPERACION"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" . $row["DESCRIPCION"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" . $row["CODIGO_INSTRUMENTO"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $cnorma[1] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["ID_REGIONAL"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE_REGIONAL"]) . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["ID_CENTRO"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE_CENTRO"]) ."</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE"]) . ' ' . utf8_encode($row["PRIMER_APELLIDO"]) . ' ' . utf8_encode($row["SEGUNDO_APELLIDO"]) . "</font></td>";
//                                        echo "<td><font face=\"verdana\">" . $proyecto['NIT_EMPRESA'] . "</font></td>";
                    if ($proyecto["NIT_EMPRESA"] == null) {
                        echo "<td><font face=\"verdana\">Demanda Social</font></td>";
                    } else {
                        $queryEmpresa = "SELECT *
                                                FROM EMPRESAS_SISTEMA
                                                WHERE NIT_EMPRESA = " . $proyecto['NIT_EMPRESA'];
                        $statementEmpresa = oci_parse($connection, $queryEmpresa);
                        oci_execute($statementEmpresa, OCI_DEFAULT);
                        $empresa = oci_fetch_all($statementEmpresa, $rowsEmpresa);
                        echo "<td><font face=\"verdana\">" . utf8_encode($rowsEmpresa['NOMBRE_EMPRESA'][0]) . "</font></td>";
                    }
                    echo "<td><font face=\"verdana\">" .
                    $row["FECHA_REGISTRO"] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["HORA_REGISTRO"] . "</font></td>";
                    if ($rowsNum223 > 0) {
                        echo "<td>" . $rows222[FECHA_REGISTRO] . "</td>";
                        echo "<td>" . $rows222[HORA_REGISTRO] . "</td>";
                    } else if ($rowsNum223 == 0) {
                        if ($anterior == 0) {
                            echo "<td>No disponible</td><td>No disponible</td>";
                        } else {
                            echo "<td>No disponible</td><td>No disponible</td>";
                        }
                    }
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBREA"]) . ' ' . utf8_encode($row["PRIMER_APELLIDOA"]) . ' ' . utf8_encode($row["SEGUNDO_APELLIDOA"]) . "</font></td>";
                    echo "<td>$row[OBSERVACION]</td>";
                    echo "<td>$row[DETALLE]</td>";
                    echo "<td>";

                    $queryCorreo = 'SELECT * FROM T_FECHA_CORREO_BANCO WHERE ID_ESTADO_SOLICITUD = ' . $rowsSelIdmax[ID_ESTADO_SOLICITUD][0];
                    $objCorreo = oci_parse($connection, $queryCorreo);
                    oci_execute($objCorreo);
                    $numRowsCorreo = oci_fetch_all($objCorreo, $rowsCorreo);

                    if ($numRowsCorreo >= 1) {
                        echo $rowsCorreo[FECHA_REGISTRO][0] . ' ' . $rowsCorreo[HORA_REGISTRO][0];
                    } else {
                        ?>
                        *<input type="checkbox" name="chkCorreo[]" value="<?php echo $rowsSelIdmax[ID_ESTADO_SOLICITUD][0]; ?>"/>
                        <?php
                    }
                    echo "</td>";
                    $qobservacionsolicitudes="  SELECT OBS.*,U.ROL_ID_ROL FROM T_OBSERV_BANCO_SOLIC OBS 
                        inner join  USUARIO U
                        ON (OBS.USUARIO_REGISTRO=U.USUARIO_ID) 
                        WHERE OBS.ID_SOLICITUD='".$row[ID_OPERACION]."'";
                    $Sobservacionsolicitudes = oci_parse($connection, $qobservacionsolicitudes);
                    //die($qobservacionsolicitudes);
                    oci_execute($Sobservacionsolicitudes);

                    $contador=0;
                    $CONTROLADORABANDO=false;
                    $CONTROLADORAASESOR=false;
                    while($Robservacionsolicitudes=oci_fetch_array($Sobservacionsolicitudes,OCI_ASSOC)){

                        if($Robservacionsolicitudes[ROL_ID_ROL]==13){
                            $CONTROLADORABANDO=$Robservacionsolicitudes[OBSERVACION];
                        }
                        if($Robservacionsolicitudes[ROL_ID_ROL]==2){
                            $CONTROLADORAASESOR=$Robservacionsolicitudes[OBSERVACION];
                        }
                        $contador++;
                    }
                    ?>                                            
                        <td>
                            <?=$CONTROLADORABANDO?>                            
                        </td>                    
                    <?php
                    echo "</tr>";
                    $anterior = $rowsNum223;
                    $num++;
                }
            }
            ?>
        </table>
    </body>
</html>