<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=indicadores.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN�? “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd�?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Centros</title>
    </head>

    <body>
        <table>
            <tr>
                <th  colspan="14">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Indicadores 2016 - Corte <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br><br>
                <table border="1">
                    <tr style="background-color:#006; text-align:center; color:#FFF">
                        <th><strong>Código Regional</strong></th>
                        <th><strong>Nombre Regional</strong></th>
                        <th><strong>Código Centro</strong></th>
                        <th><strong>Nombre Centro</strong></th>
                        <th style="border-color:#006; text-align:center; color:#FFF"><strong>Meta Evaluaciones en Competencias Laborales</strong></th>
                        <th><strong> Total Evaluaciones en Competencias Laborales</strong></th>
                        <th style="border-color:#006; text-align:center; color:#FFF"><strong>Meta Personas Evaluadas en Competencias Laborales</strong></th>
                        <th><strong> Total Personas Evaluadas en Competencias Laborales</strong></th>
                        <th style="border-color:#006; text-align:center; color:#FFF"><strong>Meta Personas Certificadas en Competencias laborales - Colocados</strong></th>
                        <th><strong> Total Personas Certificadas en Competencias laborales - Colocados</strong></th>
                        <th style="border-color:#006; text-align:center; color:#FFF"><strong>Meta N° de Certificaciones en Competencias Laborales  Expedidas </strong></th>
                        <th><strong> Total N° de Certificaciones en Competencias Laborales  Expedidas </strong></th>
                        <th style="border-color:#006; text-align:center; color:#FFF"><strong>Meta Personas Certificadas en Competencias Laborales  </strong></th>
                        <th><strong> Total Personas Certificadas en Competencias Laborales  </strong></th>
                    </tr>
                    <?php
                    $qIndicadores = " SELECT 
                            R.CODIGO_REGIONAL,R.nombre_regional, C.Codigo_Centro,c.nombre_centro,
                            I.Meta_Evaluaciones_Cl,COUNT(DISTINCT EV.ID_EVIDENCIAS)total_Evaluaciones_Cl,
                            I.Meta_Pers_Evaluadas_Cl, COUNT(DISTINCT Ev.Id_Candidato) total_Pers_Evaluadas_Cl ,
                            I.Meta_Pers_Cert_Colocados_Cl,'0' total_Pers_Cert_Colocados_Cl,
                            I.Meta_Cert_Exp_Cl, COUNT(DISTINCT Th.Id_Historico) total__Cert_Exp_Cl,
                            I.Meta_Pers_Cert_Cl,COUNT(DISTINCT Th.Nroident) total_Pers_Cert_Cl

                          FROM 
                            REGIONAL R 
                            JOIN CENTRO C ON (C.CODIGO_REGIONAL=R.CODIGO_REGIONAL)
                            JOIN T_Indicadores I ON (I.Codigo_Regional=R.Codigo_Regional AND I.CODIGO_CENTRO=C.CODIGO_CENTRO AND I.Anyo='2016' AND I.Estado='1')
                            LEFT JOIN PROYECTO P ON (P.Id_Centro=C.CODIGO_CENTRO )
                            LEFT JOIN Plan_Evidencias PE ON (Pe.Id_Proyecto=P.Id_Proyecto)
                            LEFT JOIN Evidencias_Candidato EV ON (Ev.Id_Plan=Pe.Id_Plan and EXTRACT (YEAR FROM ev.FECHA_REGISTRO)='2016' AND EV.ESTADO!='0')
                            LEFT JOIN T_HISTORICO  TH ON (Th.Centro_Regional_Id_Regional=R.CODIGO_REGIONAL AND Th.Centro_Id_Centro=C.CODIGO_CENTRO||'00' AND EXTRACT(YEAR FROM TH.FECHA_REGISTRO)='2016' AND TH.TIPO_CERTIFICADO = 'NC' AND TH.TIPO_ESTADO = 'CERTIFICA')

                          GROUP BY 
                            R.CODIGO_REGIONAL,R.nombre_regional, C.Codigo_Centro,c.nombre_centro,
                            I.Meta_Evaluaciones_Cl,  I.Meta_Pers_Evaluadas_Cl,   I.Meta_Pers_Cert_Colocados_Cl,  I.Meta_Cert_Exp_Cl,  I.Meta_Pers_Cert_Cl";
                    $sIndicadores = oci_parse($connection, $qIndicadores);
                    oci_execute($sIndicadores);

                    while ($rIndicadores = oci_fetch_array($sIndicadores, OCI_ASSOC)) {
                        ?>
                        <tr>
                            <td><?=$rIndicadores["CODIGO_REGIONAL"];?></td>
                            <td><?=$rIndicadores["NOMBRE_REGIONAL"];?></td>
                            <td><?=$rIndicadores["CODIGO_CENTRO"];?></td>
                            <td><?=$rIndicadores["NOMBRE_CENTRO"];?></td>
                            <td><?=$rIndicadores["META_EVALUACIONES_CL"];?></td>
                            <td><?=$rIndicadores["TOTAL_EVALUACIONES_CL"];?></td>
                            <td><?=$rIndicadores["META_PERS_EVALUADAS_CL"];?></td>
                            <td><?=$rIndicadores["TOTAL_PERS_EVALUADAS_CL"];?></td>
                            <td><?=$rIndicadores["META_PERS_CERT_COLOCADOS_CL"];?></td>
                            <td><?=$rIndicadores["TOTAL_PERS_CERT_COLOCADOS_CL"];?></td>
                            <td><?=$rIndicadores["META_CERT_EXP_CL"];?></td>
                            <td><?=$rIndicadores["TOTAL__CERT_EXP_CL"];?></td>
                            <td><?=$rIndicadores["META_PERS_CERT_CL"];?></td>
                            <td><?=$rIndicadores["TOTAL_PERS_CERT_CL"];?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    
                </table>
                </body>
                </html>
