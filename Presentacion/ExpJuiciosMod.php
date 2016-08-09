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
            /*$query2 = "SELECT DISTINCT
                            U.USUARIO_ID,
                            U.DOCUMENTO,
                            U.PRIMER_APELLIDO,
                            U.SEGUNDO_APELLIDO,
                            U.NOMBRE,
                            EC.ESTADO,
                            EC.FECHA_REGISTRO
                            FROM INSCRIPCION I
                            INNER JOIN PLAN_EVIDENCIAS PE
                            ON I.ID_PROYECTO= PE.ID_PROYECTO
                            INNER JOIN EVIDENCIAS_CANDIDATO EC
                            ON EC.ID_PLAN=PE.ID_PLAN
                            INNER JOIN USUARIO U
                            ON U.USUARIO_ID=EC.ID_CANDIDATO
                            WHERE I.ESTADO=1 AND
                            I.GRUPO='$g' AND
                            I.ID_NORMA='$n' AND 
                            PE.ID_PROYECTO = '$p'
                            ORDER BY U.PRIMER_APELLIDO ASC";*/
            $query2="SELECT  
                distinct U.DOCUMENTO, 
                U.PRIMER_APELLIDO, 
                U.SEGUNDO_APELLIDO, 
                U.NOMBRE , 
                CASE 
                    WHEN EC.ESTADO =0 THEN 'Sin Evaluar' 
                    WHEN EC.ESTADO =1 THEN 'Nivel Avanzado' 
                    WHEN EC.ESTADO =2 THEN 'Aún No Competente' 
                    WHEN EC.ESTADO =3 THEN 'Nivel Intermedio' 
                    WHEN EC.ESTADO =4 THEN 'Nivel Basico' 
                    WHEN EC.ESTADO IS NULL THEN 'Sin registro' 
                END AS ESTADO, 
                EC.FECHA_REGISTRO,
                PG.N_GRUPO, N.CODIGO_NORMA,PG.ID_PROYECTO
            FROM 
                USUARIO U
                JOIN PROYECTO_GRUPO PG
                ON (PG.ID_CANDIDATO=U.USUARIO_ID)
                LEFT JOIN PLAN_EVIDENCIAS PE
                ON (
                PE.ID_PROYECTO=PG.ID_PROYECTO
                AND PE.ID_NORMA=PG.ID_NORMA
                AND PE.GRUPO=PG.N_GRUPO
                )
                LEFT JOIN EVIDENCIAS_CANDIDATO EC
                ON (
                EC.ID_PLAN=PE.ID_PLAN
                AND PE.ID_NORMA=EC.ID_NORMA
                AND EC.ID_CANDIDATO=PG.ID_CANDIDATO
                )
                JOIN NORMA N
                ON(N.ID_NORMA=PG.ID_NORMA)
            WHERE 
                PG.ID_NORMA='$n'
                AND PG.N_GRUPO='$g'
                AND PG.ID_PROYECTO='$p' 
            ORDER BY U.DOCUMENTO ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                //$c=estado
                
                //*--------------
                //$codno lo reemplazo por el codigo_norma 
                

                echo "<tr><td><font face=\"verdana\"><center>" .
                $row2["ID_PROYECTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_NORMA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["N_GRUPO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["DOCUMENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["PRIMER_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["SEGUNDO_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["ESTADO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_REGISTRO"] . "</center></font></td></tr>";

                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>