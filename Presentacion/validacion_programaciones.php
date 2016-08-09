<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=PlanValidado.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection2 = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte de PAECCL</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de PAECCL - Validada Corte <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Id Detalle</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nit de Empresa - Convenio (Por Alianza)</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Empresa (Por Alianza)</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código de la Mesa</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre de la Mesa</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código de la Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Vrs Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre de la Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Número de Evaluaciones (Por Alianza)</strong></th>
                <!--<th style="background-color:#006; text-align:center; color:#FFF"><strong>Número Total de Personas a Certificar (Por Alianza)..</strong></th>-->
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Número de Evaluaciones (Por Demanda Social)</strong></th>
                <!--<th style="background-color:#006; text-align:center; color:#FFF"><strong>Número Total de Personas a Certificar (Por Demanda Social)..</strong></th>-->
                <!--<th style="background-color:#006; text-align:center; color:#FFF"><strong>Número de Certificaciones (Funcionarios)..</strong></th>-->
                <!--<th style="background-color:#006; text-align:center; color:#FFF"><strong>Número Total de Personas a Certificar (Funcionarios)..</strong></th>-->
<!--                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Consolidado TOTAL de Personas a Certificar</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Consolidado TOTAL de Certificados</strong></th>-->
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Validación</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Asesor</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha Concepto</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Concepto Asesor</strong></th>


            </tr>
            <?php
// Un proceso repetitivo para imprimir cada uno de los registros.
            
            $query2 = "select 
usu.nombre,
p.id_plan,
p.fecha_concepto,
p.id_deta,
(select id_regional from plan_anual where id_plan=p.id_plan) ID_REGIONAL,
(select NOMBRE_REGIONAL from REGIONAL where CODIGO_REGIONAL=(select id_regional from plan_anual where id_plan=p.id_plan)) NOMBRE_REGIONAL,
(select id_centro from plan_anual where id_plan=p.id_plan) ID_CENTRO,
(select NOMBRE_CENTRO from CENTRO where CODIGO_CENTRO=(select id_centro from plan_anual where id_plan=p.id_plan)) NOMBRE_CENTRO,
p.nit_empresa NIT_EMPRESA,
(select nombre_empresa from EMPRESAS_SISTEMA where nit_empresa=(select nit_empresa from detalles_poa where id_deta=p.id_deta)) EMPRESA,
n.codigo_mesa,
m.nombre_mesa,
n.id_norma ID_NORMA,
n.codigo_norma CODIGO_NORMA ,
n.version_norma VERS_NORMA ,
n.titulo_norma TITULO_NORMA,
to_char(n.expiracion_norma,'dd/mm/yyyy') EXPIRACION_NORMA,
p.al_num_certif CERTIFICADOS_ALIANZA,
p.al_num_personas PERSONAS_ALIANZA,
p.ds_num_certif CERTIFICADOS_DEMANDA,
p.ds_num_personas PERSONAS_DEMANDA,
p.fun_num_certif CERTIFICADOS_FUNCIONARIOS,
p.fun_num_personas PERSONAS_FUNCIONARIOS,
p.validacion VALIDADO,
p.concepto_asesor CONCEPTO
from norma n
inner join detalles_poa p on p.id_norma= n.id_norma
inner join plan_anual pa on p.id_plan= pa.id_plan
inner join mesa m on m.codigo_mesa=n.codigo_mesa
left join usuario usu 
on usu.usuario_id = p.id_asesor 
WHERE SUBSTR(P.FECHA_REGISTRO, 7,4) = 2016";
//where p.validacion=3 or p.validacion=1";
            $statement2 = oci_parse($connection2, $query2);
            oci_execute($statement2);
            $num = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                $totalpersonas = $row2["PERSONAS_ALIANZA"] + $row2["PERSONAS_ALIANZA"] + $row2["PERSONAS_FUNCIONARIOS"];
                $totalcertificados = $row2["CERTIFICADOS_ALIANZA"] + $row2["CERTIFICADOS_DEMANDA"] + $row2["CERTIFICADOS_FUNCIONARIOS"];

                echo "<td>$row2[ID_DETA]</td>";
                echo "<td>$row2[ID_REGIONAL]</td>";
                echo "<td>" . utf8_encode($row2[NOMBRE_REGIONAL]) . "</td>";
                echo "<td>$row2[ID_CENTRO]</td>";
                echo "<td>" . utf8_encode($row2[NOMBRE_CENTRO]) . "</td>";
                if ($row2[NIT_EMPRESA] == NULL || $row2[NIT_EMPRESA] == 0) {
                    $e = "Demanda Social";
                    $ne = "Demanda Social";
                } else {
                    $e = $row2[NIT_EMPRESA];
                    $ne = utf8_encode($row2[EMPRESA]);
                }
                if ($row2[CERTIFICADOS_ALIANZA] == NULL) {
                    $a1 = "0";
                } else {
                    $a1 = $row2[CERTIFICADOS_ALIANZA];
                }
                if ($row2[PERSONAS_ALIANZA] == NULL) {
                    $a2 = "0";
                } else {
                    $a2 = $row2[PERSONAS_ALIANZA];
                }
                if ($row2[CERTIFICADOS_DEMANDA] == NULL) {
                    $a3 = "0";
                } else {
                    $a3 = $row2[CERTIFICADOS_DEMANDA];
                }
                if ($row2[PERSONAS_ALIANZA] == NULL) {
                    $a4 = "0";
                } else {
                    $a4 = $row2[PERSONAS_ALIANZA];
                }
                if ($row2[CERTIFICADOS_FUNCIONARIOS] == NULL) {
                    $a5 = "0..";
                } else {
                    $a5 = $row2[CERTIFICADOS_FUNCIONARIOS]."..";
                }
                if ($row2[PERSONAS_FUNCIONARIOS] == NULL) {
                    $a6 = "0..";
                } else {
                    $a6 = $row2[PERSONAS_FUNCIONARIOS]."..";
                }
                echo "<td>$e</td>";
                echo "<td>$ne</td>";
                echo "<td>$row2[CODIGO_MESA]</td>";
                echo "<td>$row2[NOMBRE_MESA]</td>";
                echo "<td>$row2[CODIGO_NORMA]</td>";
                echo "<td>$row2[VERS_NORMA]</td>";
                echo "<td>" . utf8_encode($row2[TITULO_NORMA]) . "</td>";
                echo "<td>$a1</td>";
//                echo "<td>$a2..</td>";
                echo "<td>$a3</td>";
//                echo "<td>$a4..</td>";
//                echo "<td>$a5</td>";
//                echo "<td>$a6</td>";
//                echo "<td>$totalpersonas</td>";
//                echo "<td>$totalcertificados</td>";
                if ($row2[VALIDADO] == 1) {
                    $v = "Si";
                } else if ($row2[VALIDADO] == 0) {
                    $v = "No";
                }else {
                    $v = "Pendiente";
                }
                echo "<td>$v</td>";
                echo "<td>$row2[NOMBRE]</td>";
                echo "<td>$row2[FECHA_CONCEPTO]</td>";
                echo "<td>$row2[CONCEPTO]</td></tr>";



                $num++;
            }
            oci_close($connection2);
            ?>
        </table>
    </body>
</html>
