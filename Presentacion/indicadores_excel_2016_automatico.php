<?php

//error_reporting(E_ALL);
require './PHPExcel/PHPExcel.php';
//require '../../cuenta2/PHPExcel/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Soporte aplicativo")
        ->setLastModifiedBy("Soporte aplicativo")
        ->setTitle("Indicadores a la fecha")
        ->setSubject("Indicadores a la fecha ")
        ->setDescription("Este reporte se genera automáticamente con corte a la fecha y se envía a los actores que soliciten este servicio. Hora de envío diario 7:00")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("");
//require '../Clase/conectar.php';
require './clases/conexion.php';
$objConexion = new conexion();
$connection = $objConexion->conectar();
//require_once("../Clase/conectar.php");
//$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//date_default_timezone_set('Etc/GMT-7');
date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, "es_CO");

$date = new DateTime();
$date = strftime("%Y%m%d %I%M%S %p",$date->getTimestamp());


//realizamos la consulta
$row = 1;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Código Regional');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, 'Nombre Regional');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $row, 'Código Centro');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', $row, 'Nombre Centro');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', $row, 'Meta Evaluaciones en Competencias Laborales');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', $row, 'Total Evaluaciones en Competencias Laborales');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', $row, 'Meta Personas Evaluadas en Competencias Laborales');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', $row, 'Total Personas Evaluadas en Competencias Laborales');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', $row, 'Meta N° de Certificaciones en Competencias Laborales  Expedidas');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9', $row, 'Total N° de Certificaciones en Competencias Laborales  Expedidas');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10', $row, 'Meta Personas Certificadas en Competencias Laborales  ');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('11', $row, 'Total Personas Certificadas en Competencias Laborales ');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('12', $row, 'Meta Personas Certificadas en Competencias laborales - Colocados');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('13', $row, 'Total Personas Certificadas en Competencias laborales - Colocados');


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
                    LEFT JOIN Evidencias_Candidato EV ON (Ev.Id_Plan=Pe.Id_Plan and EXTRACT (YEAR FROM ev.FECHA_EMISION)='2016' AND EV.ESTADO!='0')
                    LEFT JOIN T_HISTORICO  TH ON (Th.Centro_Regional_Id_Regional=R.CODIGO_REGIONAL AND Th.Centro_Id_Centro=C.CODIGO_CENTRO||'00' AND EXTRACT(YEAR FROM TH.FECHA_REGISTRO)='2016' AND TH.TIPO_CERTIFICADO = 'NC' AND TH.TIPO_ESTADO = 'CERTIFICA')

                  GROUP BY 
                    R.CODIGO_REGIONAL,R.nombre_regional, C.Codigo_Centro,c.nombre_centro,
                    I.Meta_Evaluaciones_Cl,  I.Meta_Pers_Evaluadas_Cl,   I.Meta_Pers_Cert_Colocados_Cl,  I.Meta_Cert_Exp_Cl,  I.Meta_Pers_Cert_Cl";
$sIndicadores = oci_parse($connection, $qIndicadores);
oci_execute($sIndicadores);
//echo "<pre>";
//oci_fetch_all($sIndicadores,$rIndicadores);
//var_dump($rIndicadores);
//die();

$META_EVALUACIONES_CL = 0;
$TOTAL_EVALUACIONES_CL = 0;
$META_PERS_EVALUADAS_CL = 0;
$TOTAL_PERS_EVALUADAS_CL = 0;

$META_CERT_EXP_CL = 0;
$TOTAL__CERT_EXP_CL = 0;
$META_PERS_CERT_CL = 0;
$TOTAL_PERS_CERT_CL = 0;
$META_PERS_CERT_COLOCADOS_CL = 0;
$TOTAL_PERS_CERT_COLOCADOS_CL = 0;
;

while ($rIndicadores = oci_fetch_array($sIndicadores, OCI_ASSOC)) {
    $row++;
    if ($rIndicadores['CODIGO_CENTRO'] == 9540) {
        $sqlNCCEREva = 'SELECT '
                . ' COUNT(DOCUMENTO) AS TOTAL_EVALUADAS, '
                . ' COUNT(DISTINCT DOCUMENTO) AS PERSONAS_EVALUADAS '
                . 'FROM T_NCCER '
                . "WHERE EVALUADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016'";
        $objNCCEREva = oci_parse($connection, $sqlNCCEREva);
        oci_execute($objNCCEREva);

        $numRegistrosNCCEREva = oci_fetch_all($objNCCEREva, $datosNCCEREva);
        $sqlNCCERCer = 'SELECT '
                . ' COUNT(DOCUMENTO) AS TOTAL_CERTIFICADAS, '
                . ' COUNT(DISTINCT DOCUMENTO) AS PERSONAS_CERTIFICADAS '
                . 'FROM T_NCCER '
                . "WHERE CERTIFICADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016'";
        $objNCCERCer = oci_parse($connection, $sqlNCCERCer);
        oci_execute($objNCCERCer);
        $numRegistrosNCCERCer = oci_fetch_all($objNCCERCer, $datosNCCERCer);
    } else {
        $datosNCCEREva['TOTAL_EVALUADAS'][0] = 0;
        $datosNCCEREva['PERSONAS_EVALUADAS'][0] = 0;
        $datosNCCERCer['TOTAL_CERTIFICADAS'][0] = 0;
        $datosNCCERCer['PERSONAS_CERTIFICADAS'][0] = 0;
    }

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, $rIndicadores["CODIGO_REGIONAL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, utf8_encode($rIndicadores["NOMBRE_REGIONAL"]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $row, $rIndicadores["CODIGO_CENTRO"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', $row, utf8_encode($rIndicadores["NOMBRE_CENTRO"]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', $row, $rIndicadores["META_EVALUACIONES_CL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', $row, $rIndicadores["TOTAL_EVALUACIONES_CL"] + $datosNCCEREva['TOTAL_EVALUADAS'][0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', $row, $rIndicadores["META_PERS_EVALUADAS_CL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', $row, $rIndicadores["TOTAL_PERS_EVALUADAS_CL"] + $datosNCCEREva['PERSONAS_EVALUADAS'][0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', $row, $rIndicadores["META_CERT_EXP_CL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9', $row, $rIndicadores["TOTAL__CERT_EXP_CL"] + $datosNCCERCer['TOTAL_CERTIFICADAS'][0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10', $row, $rIndicadores["META_PERS_CERT_CL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('11', $row, $rIndicadores["TOTAL_PERS_CERT_CL"] + $datosNCCERCer['PERSONAS_CERTIFICADAS'][0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('12', $row, $rIndicadores["META_PERS_CERT_COLOCADOS_CL"]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('13', $row, $rIndicadores["TOTAL_PERS_CERT_COLOCADOS_CL"]);


    $META_EVALUACIONES_CL += $rIndicadores["META_EVALUACIONES_CL"];
    $TOTAL_EVALUACIONES_CL += $rIndicadores["TOTAL_EVALUACIONES_CL"] + $datosNCCEREva['TOTAL_EVALUADAS'][0];
    $META_PERS_EVALUADAS_CL += $rIndicadores["META_PERS_EVALUADAS_CL"];
    $TOTAL_PERS_EVALUADAS_CL += $rIndicadores["TOTAL_PERS_EVALUADAS_CL"] + $datosNCCEREva['PERSONAS_EVALUADAS'][0];
    $META_CERT_EXP_CL += $rIndicadores["META_CERT_EXP_CL"];
    $TOTAL__CERT_EXP_CL += $rIndicadores["TOTAL__CERT_EXP_CL"] + $datosNCCERCer['TOTAL_CERTIFICADAS'][0];
    $META_PERS_CERT_CL += $rIndicadores["META_PERS_CERT_CL"];
    $TOTAL_PERS_CERT_CL += $rIndicadores["TOTAL_PERS_CERT_CL"] + $datosNCCERCer['PERSONAS_CERTIFICADAS'][0];
    $META_PERS_CERT_COLOCADOS_CL += $rIndicadores["META_PERS_CERT_COLOCADOS_CL"];
    $TOTAL_PERS_CERT_COLOCADOS_CL += $rIndicadores["TOTAL_PERS_CERT_COLOCADOS_CL"];
}

$row++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, "");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, "");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $row, "");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', $row, "TOTAL:");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', $row, $META_EVALUACIONES_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', $row, $TOTAL_EVALUACIONES_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', $row, $META_PERS_EVALUADAS_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', $row, $TOTAL_PERS_EVALUADAS_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', $row, $META_CERT_EXP_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9', $row, $TOTAL__CERT_EXP_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10', $row, $META_PERS_CERT_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('11', $row, $TOTAL_PERS_CERT_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('12', $row, $META_PERS_CERT_COLOCADOS_CL);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('13', $row, $TOTAL_PERS_CERT_COLOCADOS_CL);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('reportIndicadores-' . $date . '.xls');
require_once('./PHPMailer-master/class.phpmailer.php');
require_once("./PHPMailer-master/class.smtp.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // Uso SMTP
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->SMTPSecure = "ssl";

$mail->SMTPDebug = 1;
// Autenticación
$mail->SMTPAuth = true;
//Configuración de la cuenta  desde dónde se envía el correo
$mail->Username = "soporaplicativoseccl.noreply@gmail.com";
$mail->Password = "soporaplicativoseccl123";

// Quien envia
$mail->SetFrom("jcaperap@sena.edu.co", "soporaplicativoseccl@sena.edu.co");
// Asunto del email
$mail->Subject = "Indicadores : " . $date;
// En caso de que la vista HTML no esté activida. Esto ya es muy poco probable
$mail->AltBody = "Para ver correctamente este mensaje use la vista de HTML";
// El cuerpo del mensaje. 
//$mail->MsgHTML($mail2);
$mail->Body = "<p> <h1> Saludos</h1> <br/>Este correo se envía automáticamente para la entrega del reporte de indicadores con corte a la fecha </p><br/>"
        . "<table class=\"ecxMsoNormalTable\" border=\"0\" cellpadding=\"0\" width=\"661\" style=\"width:495.9pt;\">
<tbody>
<tr style=\"height:176.8pt;\">
<td width=\"7\" style=\"width:5.05pt;padding:.75pt .75pt .75pt .75pt;height:176.8pt;\">
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\">&nbsp;</span><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
</td>
<td width=\"162\" style=\"width:121.4pt;padding:.75pt .75pt .75pt .75pt;height:176.8pt;\">
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\"><a href=\"http://www.sena.edu.co/\" target=\"_blank\" class=\"\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"155\" height=\"208\" id=\"ecxImagen_x0020_7\" src=\"https://najubastian.files.wordpress.com/2015/04/logo-sena.jpg\" alt=\"Descripción: ENA\"></span></a><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
</td>
<td width=\"12\" style=\"width:9.25pt;padding:.75pt .75pt .75pt .75pt;height:176.8pt;\">
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\">&nbsp;</span><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
</td>
<td width=\"25\" style=\"width:18.55pt;padding:.75pt .75pt .75pt .75pt;height:176.8pt;\">
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\">
<span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"><img border=\"0\" width=\"2\" height=\"247\" id=\"ecxImagen_x0020_6\" src=\"https://snt146.afx.ms/att/GetInline.aspx?messageid=a0771882-db43-11e5-9939-002264c160fe&amp;attindex=2&amp;cp=-1&amp;attdepth=2&amp;imgsrc=cid%3aimage011.png%4001D16F26.7AD49E90&amp;cid=93301d119bb70387&amp;shared=1&amp;hm__login=steven_capera&amp;hm__domain=hotmail.com&amp;ip=10.148.160.8&amp;d=d4281&amp;mf=0&amp;hm__ts=Thu%2c%2014%20Apr%202016%2015%3a12%3a27%20GMT&amp;st=steven_capera&amp;hm__ha=01_d0b381ff0c56ee45eb3fd977550e59e3814f549eda2a7060494c8ad832b81f30&amp;oneredir=1\" alt=\"Descripción: ine\"></span><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
</td>
<td width=\"444\" style=\"width:332.65pt;padding:.75pt .75pt .75pt .75pt;height:176.8pt;\">
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\"><b><span style=\"color:#333333;\">Grupo aplicativo SECCL&nbsp;</span></b><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:#CCCCCC;\"><br>
</span><span style=\"font-size:10.0pt;line-height:115%;color:#333333;\">Grupo Certificación de Competencias Laborales<br>
Dirección General<br>
Calle 54 No 10-34 Tecnoparque Piso 5, Bogotá </span><span style=\"font-size:10.0pt;line-height:115%;color:#333333;\"></span></p>
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\"><span style=\"font-size:10.0pt;line-height:115%;color:#333333;\">Tel.: +57 (1) 5461500 Ext. 12138<br>
</span><span style=\"color:blue;\"><a href=\"mailto:soporaplicativoseccl@sena.edu.co\"><span style=\"font-size:10.0pt;line-height:115%;color:blue;\">soporaplicativoseccl@sena.edu.co</span></a></span><span style=\"font-size:10.0pt;line-height:115%;color:#333333;\">
</span><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
<p class=\"ecxMsoNormal\" style=\"line-height:115%;\">
<a href=\"http://www.sena.edu.co/\" target=\"_blank\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"216\" height=\"27\" id=\"ecxImagen_x0020_5\" src=\"https://mail.sena.edu.co/owa/attachment.ashx?id=RgAAAABie44r9EKrRpce0396OGY4BwCtPn1lRPWTSrKpRimfP7fKAAAAYVOVAACtPn1lRPWTSrKpRimfP7fKAABjO9ecAAAJ&attcnt=1&attid0=BAACAAAA&attcid0=image009.jpg%4001D19578.F1C1A930\" alt=\"Descripción: ortal web SENA\"></span></a><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"><br>
<br>
</span><a href=\"https://www.facebook.com/sena.general\" target=\"_blank\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"34\" height=\"32\" id=\"ecxImagen_x0020_4\" src=\"https://mail.sena.edu.co/owa/attachment.ashx?id=RgAAAABie44r9EKrRpce0396OGY4BwCtPn1lRPWTSrKpRimfP7fKAAAAYVOVAACtPn1lRPWTSrKpRimfP7fKAABjO9ecAAAJ&attcnt=1&attid0=BAADAAAA&attcid0=image010.png%4001D19578.F1C1A930\" alt=\"Descripción: acebook-SENA\"></span></a><a href=\"https://twitter.com/SENAComunica\" target=\"_blank\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"34\" height=\"32\" id=\"ecxImagen_x0020_3\" src=\"https://mail.sena.edu.co/owa/attachment.ashx?id=RgAAAABie44r9EKrRpce0396OGY4BwCtPn1lRPWTSrKpRimfP7fKAAAAYVOVAACtPn1lRPWTSrKpRimfP7fKAABjO9ecAAAJ&attcnt=1&attid0=BAAEAAAA&attcid0=image011.png%4001D19578.F1C1A930\" alt=\"Descripción: witter-SENA\"></span></a><a href=\"http://instagram.com/senacomunica\" target=\"_blank\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"36\" height=\"32\" id=\"ecxImagen_x0020_2\" src=\"https://mail.sena.edu.co/owa/attachment.ashx?id=RgAAAABie44r9EKrRpce0396OGY4BwCtPn1lRPWTSrKpRimfP7fKAAAAYVOVAACtPn1lRPWTSrKpRimfP7fKAABjO9ecAAAJ&attcnt=1&attid0=BAAFAAAA&attcid0=image012.png%4001D19578.F1C1A930\" alt=\"Descripción: nstagram-SENA\"></span></a><a href=\"https://plus.google.com/+senacolombia/\" target=\"_blank\"><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:blue;text-decoration:none;\"><img border=\"0\" width=\"32\" height=\"32\" id=\"ecxImagen_x0020_1\" src=\"https://mail.sena.edu.co/owa/attachment.ashx?id=RgAAAABie44r9EKrRpce0396OGY4BwCtPn1lRPWTSrKpRimfP7fKAAAAYVOVAACtPn1lRPWTSrKpRimfP7fKAABjO9ecAAAJ&attcnt=1&attid0=BAAGAAAA&attcid0=image013.png%4001D19578.F1C1A930\" alt=\"Descripción: oogle-SENA\"></span></a><span style=\"font-size:13.5pt;line-height:115%;font-family:&quot;Times&quot;,&quot;serif&quot;;color:black;\"></span></p>
</td>
</tr>
</tbody>
</table>";

$mail->IsHTML(true);
// Dirección del destinatario
$mail->AddAttachment('reportIndicadores-' . $date . '.xls', 'reportIndicadores-' . $date . '.xls');
//¿A quién le debe llegar?

$mail->AddCC('steven_capera@hotmail.com', 'Steven Capera');
//$mail->AddAddress("fhherrerar@sena.edu.co");
$mail->AddAddress("jcaperap@sena.edu.co");
//$mail->AddAddress("soporaplicativoseccl@sena.edu.co");



if ($mail->Send()) {
    //ok
}
 