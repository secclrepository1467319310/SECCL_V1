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
header("Content-Disposition: attachment; filename=Reporte$repo.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
if($_GET[fechainicial] =="" ||$_GET[fechafinal]=="" ){
    $where="";
}else{
    $where="WHERE TOB.FECHA_REGISTRO BETWEEN '".$_GET[fechainicial]."' AND '".$_GET[fechafinal]."'";
}
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Solicitudes
        </title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;">
                        <font size="+2">
                            Solicitudes entre fechas <?=$_GET[fechainicial]?>-<?=$_GET[fechafinal]?>
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
                <th>Código Regional</th>
                <th>Regional</th>
                <th>Código Centro</th>
                <th>Centro</th>
                <th>Líder</th>
                <th>Entidad</th>
                <th>Fecha Solicitud</th>
                <th>Hora Solicitud</th>
                <th>Encargado del Banco Asignado</th>
                <th>Estado</th>
                <th>Fecha Estado</th>
                <th>Hora Estado</th>
                <th>Observaciones</th>
            </tr>
            <?php
            $query = "SELECT P.ID_REGIONAL,R.NOMBRE_REGIONAL,P.ID_CENTRO,CE.NOMBRE_CENTRO,TOB.ID_PROYECTO,TOB.ID_NORMA,TOB.N_GRUPO,TOB.ID_OPERACION,TOB.FECHA_REGISTRO,TOB.HORA_REGISTRO,P.NIT_EMPRESA,TOB.OBSERVACION,USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO,TB.DESCRIPCION
                                                    FROM T_OPERACION_BANCO TOB
                                                    INNER JOIN PROYECTO P ON P.ID_PROYECTO=TOB.ID_PROYECTO 
                                                    INNER JOIN CENTRO CE ON CE.CODIGO_CENTRO=P.ID_CENTRO 
                                                    INNER JOIN REGIONAL R ON R.CODIGO_REGIONAL=CE.CODIGO_REGIONAL
                                                    INNER JOIN USUARIO USU ON TOB.USU_REGISTRO = USU.USUARIO_ID
                                                    INNER JOIN T_TIPO_OPERACION_BANCO TB ON TOB.ID_T_OPERACION = TB.ID_OPERACION
                                                    $where
                                                    ORDER BY TOB.ID_OPERACION ASC";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $numero = 0;
//                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
            $numRow = oci_fetch_all($statement, $row);

            for ($i = 0; $i < $numRow; $i++) {
                $query3 = ("SELECT CODIGO_NORMA FROM NORMA WHERE ID_NORMA=" . $row[ID_NORMA][$i]);
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $cnorma = oci_fetch_array($statement3, OCI_BOTH);

                $query222 = "SELECT TES.DETALLE, ES.ID_TIPO_ESTADO_SOLICITUD, ES.FECHA_REGISTRO, ES.HORA_REGISTRO
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $row['ID_OPERACION'][$i] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                $statement222 = oci_parse($connection, $query222);
                $execute222 = oci_execute($statement222, OCI_DEFAULT);
                $numRows222 = oci_fetch_all($statement222, $rows222);
                if ($rows222['ID_TIPO_ESTADO_SOLICITUD'][0] != 1 && $rows222['ID_TIPO_ESTADO_SOLICITUD'][0] != 4) {
                    echo "<tr><td><font face=\"verdana\">" .
                    $i . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    'R' . $row["ID_REGIONAL"][$i] . '-' . 'C' . $row ["ID_CENTRO"][$i] . '-P' . $row["ID_PROYECTO"][$i] . '-' . $cnorma[0] . '-' . $row["N_GRUPO"][$i] . '-' . $row["ID_OPERACION"][$i] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["DESCRIPCION"][$i] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["ID_REGIONAL"][$i] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE_REGIONAL"][$i]) . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["ID_CENTRO"][$i] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE_CENTRO"][$i]) . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    utf8_encode($row["NOMBRE"][$i]) . ' ' . utf8_encode($row["PRIMER_APELLIDO"][$i]) . ' ' . utf8_encode($row["SEGUNDO_APELLIDO"][$i]) . "</font></td>";
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
                    $row["FECHA_REGISTRO"][$i] . "</font></td>";
                    echo "<td><font face=\"verdana\">" .
                    $row["HORA_REGISTRO"][$i] . "</font></td>";
                    $query = "SELECT USU.NOMBRE,USU.PRIMER_APELLIDO,USU.SEGUNDO_APELLIDO
                                    FROM USUARIO USU 
                                    INNER JOIN T_SOLICITUDES_ASIGNADAS TSA ON USU.USUARIO_ID = TSA.USUARIO_ASIGNADO 
                                    WHERE TSA.ID_SOLICITUD = " . $row[ID_OPERACION][$i];
                    $statement = oci_parse($connection, $query);
                    $execute = oci_execute($statement, OCI_DEFAULT);
                    $numRows = oci_fetch_all($statement, $rows);

                    if ($numRows == 0) {
                        ?>
                        <td><input type="checkbox" name="id_solicitud[]" id="id_solicitud" value="<?php echo $row['ID_OPERACION'][$i] ?>" /></td>
                        <?php
                    } else {
                        echo '<td>' . utf8_encode($rows[NOMBRE][0] . ' ' . $rows[PRIMER_APELLIDO][0] . ' ' . $rows[SEGUNDO_APELLIDO][0]) . '</td>';
                    }

                    if ($numRows222 >= 1 && $numRows > 0) {
                        echo "<td>" . utf8_encode($rows222['DETALLE'][0]) . "</td>";
                        echo "<td>" . $rows222['FECHA_REGISTRO'][0] . "</td>";
                        echo "<td>" . $rows222['HORA_REGISTRO'][0] . "</td>";
                    } else if ($numRows222 < 1 && $numRows >= 1) {
                        echo "<td>Asignada</td>";
                        echo "<td> </td>";
                        echo "<td></td>";
                    } else {
                        echo "<td></td>";
                        echo "<td> </td>";
                        echo "<td></td>";
                    }

                    echo "<td>" . $row[OBSERVACION][$i] . "</td></tr>";

                    $numero++;
                }
            }
            ?>
        </table>
    </body>
</html>