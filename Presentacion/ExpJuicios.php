
<?php

//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteJuicios.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Juicios - Proyecto,Norma,Grupo</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Juicios Fecha <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Radicado Proyecto</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Grupo</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Documento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Primer Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Segundo Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Juicio Emitido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha de Juicio</strong></th>
            </tr>
            <?php
            $g = $_GET['grupo'];
            $p = $_GET['proyecto'];
            $n = $_GET['norma'];
// Un proceso repetitivo para imprimir cada uno de los registros.
            $query2 = "SELECT DISTINCT
                            U.USUARIO_ID,
                            U.DOCUMENTO,
                            U.PRIMER_APELLIDO,
                            U.SEGUNDO_APELLIDO,
                            U.NOMBRE,
                            EC.ESTADO,
                            EC.FECHA_REGISTRO,
                            TTN.TIPO_NOVEDAD
                            FROM usuario u
                            JOIN PROYECTO_GRUPO PG 
                            ON(U.USUARIO_ID=PG.ID_CANDIDATO)
                            LEFT JOIN INSCRIPCION I
                            ON (
                             I.ID_PROYECTO=PG.ID_PROYECTO 
                              AND 
                              I.ID_CANDIDATO=PG.ID_CANDIDATO
                              AND 
                              I.ID_NORMA=PG.ID_NORMA
                              AND 
                              I.GRUPO=PG.N_GRUPO
                            )
                            JOIN PLAN_EVIDENCIAS PE
                            ON (
                              I.ID_PROYECTO= PE.ID_PROYECTO
                              AND 
                              I.ID_NORMA=PE.ID_NORMA
                              AND 
                              I.GRUPO=PE.GRUPO
                            )

                            LEFT JOIN EVIDENCIAS_CANDIDATO EC
                              ON (EC.ID_PLAN=PE.ID_PLAN
                                  AND 
                                  EC.ID_NORMA=PE.ID_NORMA
                                  and 
                                  ec.id_candidato= u.usuario_id
                                    )
                            left join T_NOVEDADES_CANDI_GRUP TTG 
                            ON (
                            TTG.NORMA=I.ID_NORMA  AND TTG.GRUPO=I.GRUPO  AND TTG.PROYECTO=PE.ID_PROYECTO  AND TTG.USUARIO_CANDIDATO=U.USUARIO_ID
                            )
                            LEFT JOIN T_TIPO_NOVEDADES TTN 
                            ON(TTG.TIPO_NOVEDAD=TTN.ID_T_TIPO_NOVEDADES)  
                            
                            WHERE I.ESTADO=1 AND
                            I.GRUPO='$g' AND
                            I.ID_NORMA='$n' AND 
                            PE.ID_PROYECTO = '$p'
                            ORDER BY U.PRIMER_APELLIDO ASC";
            
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                $color="#3FF57B";
                if ($row2["ESTADO"] == 0) {
                    $c = "Sin Evaluar";
                    $color="#FFF";
                } else if ($row2["ESTADO"] == 1) {
                    $c = "Nivel Avanzado";
                } else if ($row2["ESTADO"] == 2) {
                    $c = "Aún No Competente";
                } else if ($row2["ESTADO"] == 3) {
                    $c = "Nivel Intermedio";
                } else if ($row2["ESTADO"] == 4) {
                    $c = "Nivel Basico";
                } else {
                    $c = "Sin Registro";
                }
                //*--------------
                $query3 = ("SELECT codigo_norma FROM norma where id_norma='$n'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $codno = oci_fetch_array($statement3, OCI_BOTH);
                if($row2[TIPO_NOVEDAD]!=null){
                    $color="#FFFD51";                    
                }
                echo "<tr style='background-color:$color'><td><font face=\"verdana\"><center>" .
                $p . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $codno[0] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $g . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["DOCUMENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["PRIMER_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["SEGUNDO_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                if($row2[TIPO_NOVEDAD]!=null){
                    echo "<td ><font face=\"verdana\" ><center>" .
                    utf8_encode($row2[TIPO_NOVEDAD]) . "</center></font></td>";
                }else{
                    echo "<td ><font face=\"verdana\"  ><center>" .
                    $c . "</center></font></td>";
                }
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_REGISTRO"] . "</center></font></td></tr>";

                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
        <table>
            <TR><TD></TD></TR>
            <TR><TD></TD></TR>
            <tr>
                <td style="background-color: #FFFD51">PRESENTA NOVEDAD</td>
            </tr>
            <TR>
                <td style="background-color: #3FF57B">JUICIO EMITIDO</td>                
            </TR>
            <TR>
                <td style="background-color: #FFF">PENDIENTE POR EVALUAR</td>                
            </TR>
        </table>
    </body>
</html>