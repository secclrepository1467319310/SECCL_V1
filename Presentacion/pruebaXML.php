<?php

include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);
$queryCertificadosRegional = "SELECT DISTINCT RC.CENTRO_REGIONAL_ID_REGIONAL, REG.NOMBRE_REGIONAL, COUNT(*) AS REG_NUM
FROM CE_REPORTE_CORTE RC LEFT JOIN REGIONAL REG ON RC.CENTRO_REGIONAL_ID_REGIONAL = REG.CODIGO_REGIONAL
GROUP BY CENTRO_REGIONAL_ID_REGIONAL, NOMBRE_REGIONAL";
$statementCertificadosRegional = oci_parse($objConnect, $queryCertificadosRegional);
oci_execute($statementCertificadosRegional);

$xml = new DomDocument('1.0', 'UTF-8');

$documento = $xml->createElement('xsd:schema');
$documentoAtributo = $xml->createAttribute('xmlns:xsd');
$documentoAtributo->value = 'http://www.w3.org/2001/XMLSchema';
$documento->appendChild($documentoAtributo);
$documento = $xml->appendChild($documento);


/******************* Informe por certificaciones ******************************/
$certificados = $xml->createElement('xsd:element');
$certificadosAtributo = $xml->createAttribute('name');
$certificadosAtributo->value = 'normascertificadas';
$certificados->appendChild($certificadosAtributo);
$certificados = $documento->appendChild($certificados);

$complex = $xml->createElement('xsd:complexType');
$complex = $certificados->appendChild($complex);

$sequence = $xml->createElement('xsd:sequence');
$sequence = $complex->appendChild($sequence);

while ($rowCertificadosRegional = oci_fetch_array($statementCertificadosRegional, OCI_BOTH)) {
    $regional = $xml->createElement('xsd:element');
    $regionalAtributo = $xml->createAttribute('name');
    $regionalAtributo->value = 'Regional';
    $regional->appendChild($regionalAtributo);
    $regional = $sequence->appendChild($regional);

    $sequenceRegional = $xml->createElement('xsd:sequence');
    $sequenceRegional = $regional->appendChild($sequenceRegional);

    $regionalNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosRegional['NOMBRE_REGIONAL']));
    $regionalNombreAtributo = $xml->createAttribute('name');
    $regionalNombreAtributo->value = 'nombre';
    $regionalNombre->appendChild($regionalNombreAtributo);
    $regionalNombre = $sequenceRegional->appendChild($regionalNombre);

    $regionalCantidad = $xml->createElement('xsd:element', $rowCertificadosRegional['REG_NUM']);
    $regionalCantidadAtributo = $xml->createAttribute('name');
    $regionalCantidadAtributo->value = 'cantidad';
    $regionalCantidad->appendChild($regionalCantidadAtributo);
    $regionalCantidad = $sequenceRegional->appendChild($regionalCantidad);

    $centro = $xml->createElement('xsd:element');
    $centroAtributo = $xml->createAttribute('name');
    $centroAtributo->value = 'CentrodeFormacion';
    $centro->appendChild($centroAtributo);
    $centro = $sequenceRegional->appendChild($centro);

    $queryCertificadosCentro = "SELECT DISTINCT RC.CENTRO_ID_CENTRO, CE.NOMBRE_CENTRO, COUNT(*) AS CEN_NUM "
            . "FROM CE_REPORTE_CORTE RC LEFT JOIN CENTRO CE ON RC.CENTRO_ID_CENTRO = CE.CODIGO_CENTRO || '00' WHERE CENTRO_REGIONAL_ID_REGIONAL = $rowCertificadosRegional[CENTRO_REGIONAL_ID_REGIONAL] "
            . "GROUP BY NOMBRE_CENTRO, CENTRO_ID_CENTRO";
    $statementCertificadosCentro = oci_parse($objConnect, $queryCertificadosCentro);
    oci_execute($statementCertificadosCentro);

    while ($rowCertificadosCentro = oci_fetch_array($statementCertificadosCentro, OCI_BOTH)) {
        $sequenceCentro = $xml->createElement('xsd:sequence');
        $sequenceCentro = $centro->appendChild($sequenceCentro);

        $centroNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosCentro['NOMBRE_CENTRO']));
        $centroNombreAtributo = $xml->createAttribute('name');
        $centroNombreAtributo->value = 'nombre';
        $centroNombre->appendChild($centroNombreAtributo);
        $centroNombre = $sequenceCentro->appendChild($centroNombre);

        $centroCantidad = $xml->createElement('xsd:element', utf8_encode($rowCertificadosCentro['CEN_NUM']));
        $centroCantidadAtributo = $xml->createAttribute('name');
        $centroCantidadAtributo->value = 'cantidad';
        $centroCantidad->appendChild($centroCantidadAtributo);
        $centroCantidad = $sequenceCentro->appendChild($centroCantidad);
    }
}

$queryCertificadosMesa = "SELECT DISTINCT RC.CODIGO_MESA, ME.NOMBRE_MESA, COUNT(*) AS MES_NUM FROM CE_REPORTE_CORTE RC LEFT JOIN MESA ME ON RC.CODIGO_MESA = ME.CODIGO_MESA
GROUP BY RC.CODIGO_MESA, ME.NOMBRE_MESA";
$statementCertificadosMesa = oci_parse($objConnect, $queryCertificadosMesa);
oci_execute($statementCertificadosMesa);

while ($rowCertificadosMesa = oci_fetch_array($statementCertificadosMesa, OCI_BOTH)) {
    $mesa = $xml->createElement('xsd:element');
    $mesaAtributo = $xml->createAttribute('name');
    $mesaAtributo->value = 'MesaSectorial';
    $mesa->appendChild($mesaAtributo);
    $mesa = $sequence->appendChild($mesa);

    $sequenceMesa = $xml->createElement('xsd:sequence');
    $sequenceMesa = $mesa->appendChild($sequenceMesa);

    $mesaNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosMesa['NOMBRE_MESA']));
    $mesaNombreAtributo = $xml->createAttribute('name');
    $mesaNombreAtributo->value = 'nombre';
    $mesaNombre->appendChild($mesaNombreAtributo);
    $mesaNombre = $sequenceMesa->appendChild($mesaNombre);

    $mesaCantidad = $xml->createElement('xsd:element', $rowCertificadosMesa['MES_NUM']);
    $mesaCantidadAtributo = $xml->createAttribute('name');
    $mesaCantidadAtributo->value = 'cantidad';
    $mesaCantidad->appendChild($mesaCantidadAtributo);
    $mesaCantidad = $sequenceMesa->appendChild($mesaCantidad);
}

$queryCertificadosNorma = "SELECT DISTINCT RC.CLCODIGO, NM.TITULO_NORMA, COUNT(*) AS NOR_NUM 
FROM CE_REPORTE_CORTE RC LEFT JOIN NORMA NM ON RC.CLCODIGO = NM.CODIGO_NORMA
GROUP BY RC.CLCODIGO, NM.TITULO_NORMA";
$statementCertificadosNorma = oci_parse($objConnect, $queryCertificadosNorma);
oci_execute($statementCertificadosNorma);

while ($rowCertificadosNorma = oci_fetch_array($statementCertificadosNorma, OCI_BOTH)) {
    $norma = $xml->createElement('xsd:element');
    $normaAtributo = $xml->createAttribute('name');
    $normaAtributo->value = 'Normadecompetencia';
    $norma->appendChild($normaAtributo);
    $norma = $sequence->appendChild($norma);

    $sequenceNorma = $xml->createElement('xsd:sequence');
    $sequenceNorma = $norma->appendChild($sequenceNorma);

    $normaNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosNorma['TITULO_NORMA']));
    $normaNombreAtributo = $xml->createAttribute('name');
    $normaNombreAtributo->value = 'nombre';
    $normaNombre->appendChild($normaNombreAtributo);
    $normaNombre = $sequenceNorma->appendChild($normaNombre);

    $normaCantidad = $xml->createElement('xsd:element', $rowCertificadosNorma['NOR_NUM']);
    $normaCantidadAtributo = $xml->createAttribute('name');
    $normaCantidadAtributo->value = 'cantidad';
    $normaCantidad->appendChild($normaCantidadAtributo);
    $normaCantidad = $sequenceNorma->appendChild($normaCantidad);
}

/****************** Informe por Personas Certicadas ***************************/
$queryCertificadosRegional = "SELECT DISTINCT RC.CENTRO_REGIONAL_ID_REGIONAL, REG.NOMBRE_REGIONAL, COUNT(UNIQUE (NRO_IDENT)) AS REG_NUM
FROM CE_REPORTE_CORTE RC LEFT JOIN REGIONAL REG ON RC.CENTRO_REGIONAL_ID_REGIONAL = REG.CODIGO_REGIONAL
GROUP BY CENTRO_REGIONAL_ID_REGIONAL, NOMBRE_REGIONAL";
$statementCertificadosRegional = oci_parse($objConnect, $queryCertificadosRegional);
oci_execute($statementCertificadosRegional);

$certificados = $xml->createElement('xsd:element');
$certificadosAtributo = $xml->createAttribute('name');
$certificadosAtributo->value = 'personascertificadas';
$certificados->appendChild($certificadosAtributo);
$certificados = $documento->appendChild($certificados);

$complex = $xml->createElement('xsd:complexType');
$complex = $certificados->appendChild($complex);

$sequence = $xml->createElement('xsd:sequence');
$sequence = $complex->appendChild($sequence);

while ($rowCertificadosRegional = oci_fetch_array($statementCertificadosRegional, OCI_BOTH)) {
    $regional = $xml->createElement('xsd:element');
    $regionalAtributo = $xml->createAttribute('name');
    $regionalAtributo->value = 'Regional';
    $regional->appendChild($regionalAtributo);
    $regional = $sequence->appendChild($regional);

    $sequenceRegional = $xml->createElement('xsd:sequence');
    $sequenceRegional = $regional->appendChild($sequenceRegional);

    $regionalNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosRegional['NOMBRE_REGIONAL']));
    $regionalNombreAtributo = $xml->createAttribute('name');
    $regionalNombreAtributo->value = 'nombre';
    $regionalNombre->appendChild($regionalNombreAtributo);
    $regionalNombre = $sequenceRegional->appendChild($regionalNombre);

    $regionalCantidad = $xml->createElement('xsd:element', $rowCertificadosRegional['REG_NUM']);
    $regionalCantidadAtributo = $xml->createAttribute('name');
    $regionalCantidadAtributo->value = 'cantidad';
    $regionalCantidad->appendChild($regionalCantidadAtributo);
    $regionalCantidad = $sequenceRegional->appendChild($regionalCantidad);

    $centro = $xml->createElement('xsd:element');
    $centroAtributo = $xml->createAttribute('name');
    $centroAtributo->value = 'CentrodeFormacion';
    $centro->appendChild($centroAtributo);
    $centro = $sequenceRegional->appendChild($centro);

    $queryCertificadosCentro = "SELECT DISTINCT RC.CENTRO_ID_CENTRO, CE.NOMBRE_CENTRO, COUNT(UNIQUE (RC.NRO_IDENT)) AS CEN_NUM "
            . "FROM CE_REPORTE_CORTE RC LEFT JOIN CENTRO CE ON RC.CENTRO_ID_CENTRO = CE.CODIGO_CENTRO || '00' WHERE CENTRO_REGIONAL_ID_REGIONAL = $rowCertificadosRegional[CENTRO_REGIONAL_ID_REGIONAL] "
            . "GROUP BY NOMBRE_CENTRO, CENTRO_ID_CENTRO";
    $statementCertificadosCentro = oci_parse($objConnect, $queryCertificadosCentro);
    oci_execute($statementCertificadosCentro);

    while ($rowCertificadosCentro = oci_fetch_array($statementCertificadosCentro, OCI_BOTH)) {
        $sequenceCentro = $xml->createElement('xsd:sequence');
        $sequenceCentro = $centro->appendChild($sequenceCentro);

        $centroNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosCentro['NOMBRE_CENTRO']));
        $centroNombreAtributo = $xml->createAttribute('name');
        $centroNombreAtributo->value = 'nombre';
        $centroNombre->appendChild($centroNombreAtributo);
        $centroNombre = $sequenceCentro->appendChild($centroNombre);

        $centroCantidad = $xml->createElement('xsd:element', utf8_encode($rowCertificadosCentro['CEN_NUM']));
        $centroCantidadAtributo = $xml->createAttribute('name');
        $centroCantidadAtributo->value = 'cantidad';
        $centroCantidad->appendChild($centroCantidadAtributo);
        $centroCantidad = $sequenceCentro->appendChild($centroCantidad);
    }
}

$queryCertificadosMesa = "SELECT DISTINCT RC.CODIGO_MESA, ME.NOMBRE_MESA, COUNT(UNIQUE (RC.NRO_IDENT)) AS MES_NUM FROM CE_REPORTE_CORTE RC LEFT JOIN MESA ME ON RC.CODIGO_MESA = ME.CODIGO_MESA
GROUP BY RC.CODIGO_MESA, ME.NOMBRE_MESA";
$statementCertificadosMesa = oci_parse($objConnect, $queryCertificadosMesa);
oci_execute($statementCertificadosMesa);

while ($rowCertificadosMesa = oci_fetch_array($statementCertificadosMesa, OCI_BOTH)) {
    $mesa = $xml->createElement('xsd:element');
    $mesaAtributo = $xml->createAttribute('name');
    $mesaAtributo->value = 'MesaSectorial';
    $mesa->appendChild($mesaAtributo);
    $mesa = $sequence->appendChild($mesa);

    $sequenceMesa = $xml->createElement('xsd:sequence');
    $sequenceMesa = $mesa->appendChild($sequenceMesa);

    $mesaNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosMesa['NOMBRE_MESA']));
    $mesaNombreAtributo = $xml->createAttribute('name');
    $mesaNombreAtributo->value = 'nombre';
    $mesaNombre->appendChild($mesaNombreAtributo);
    $mesaNombre = $sequenceMesa->appendChild($mesaNombre);

    $mesaCantidad = $xml->createElement('xsd:element', $rowCertificadosMesa['MES_NUM']);
    $mesaCantidadAtributo = $xml->createAttribute('name');
    $mesaCantidadAtributo->value = 'cantidad';
    $mesaCantidad->appendChild($mesaCantidadAtributo);
    $mesaCantidad = $sequenceMesa->appendChild($mesaCantidad);
}

$queryCertificadosNorma = "SELECT DISTINCT RC.CLCODIGO, NM.TITULO_NORMA, COUNT(UNIQUE (RC.NRO_IDENT)) AS NOR_NUM 
FROM CE_REPORTE_CORTE RC LEFT JOIN NORMA NM ON RC.CLCODIGO = NM.CODIGO_NORMA
GROUP BY RC.CLCODIGO, NM.TITULO_NORMA";
$statementCertificadosNorma = oci_parse($objConnect, $queryCertificadosNorma);
oci_execute($statementCertificadosNorma);

while ($rowCertificadosNorma = oci_fetch_array($statementCertificadosNorma, OCI_BOTH)) {
    $norma = $xml->createElement('xsd:element');
    $normaAtributo = $xml->createAttribute('name');
    $normaAtributo->value = 'Normadecompetencia';
    $norma->appendChild($normaAtributo);
    $norma = $sequence->appendChild($norma);

    $sequenceNorma = $xml->createElement('xsd:sequence');
    $sequenceNorma = $norma->appendChild($sequenceNorma);

    $normaNombre = $xml->createElement('xsd:element', utf8_encode($rowCertificadosNorma['TITULO_NORMA']));
    $normaNombreAtributo = $xml->createAttribute('name');
    $normaNombreAtributo->value = 'nombre';
    $normaNombre->appendChild($normaNombreAtributo);
    $normaNombre = $sequenceNorma->appendChild($normaNombre);

    $normaCantidad = $xml->createElement('xsd:element', $rowCertificadosNorma['NOR_NUM']);
    $normaCantidadAtributo = $xml->createAttribute('name');
    $normaCantidadAtributo->value = 'cantidad';
    $normaCantidad->appendChild($normaCantidadAtributo);
    $normaCantidad = $sequenceNorma->appendChild($normaCantidad);
}


$xml->formatOutput = true;

$strings_xml = $xml->saveXML();

$xml->save('XML/prueba.xml');

echo 'Enhorabuena se  creo el XML exitosamente';
