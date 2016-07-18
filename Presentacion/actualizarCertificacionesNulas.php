<?php

include("../Clase/conectar.php");
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);

$selectCertificacion = 'SELECT CE.ID_CERTIFICACION, NM.CODIGO_NORMA, USU.DOCUMENTO FROM T_CERTIFICACION_PRUEBA CE
INNER JOIN NORMA NM
ON NM.ID_NORMA = CE.ID_NORMA 
INNER JOIN USUARIO USU
ON USU.USUARIO_ID = CE.ID_CANDIDATO
WHERE CE.FECHA_REGISTRO IS NULL 
ORDER BY CE.ID_CERTIFICACION ASC';
$parseCertificacion = oci_parse($conexion, $selectCertificacion);
oci_execute($parseCertificacion);
$numRowsCertificacion = oci_fetch_all($parseCertificacion, $rowsCertificacion);

if ($numRowsCertificacion > 0) {
    for ($i = 0; $i < $numRowsCertificacion; $i++) {


        $selectRegistroFirma = "SELECT * FROM CE_FIRMA_DIGITAL FD WHERE "
                . " FD.ID_CE_FIRMA_CERTIFICADOS IN (SELECT MIN(ID_CE_FIRMA_CERTIFICADOS) FROM CE_FIRMA_DIGITAL CD WHERE CD.NRO_IDENT = '" . $rowsCertificacion[DOCUMENTO][$i] ."' AND CD.CLCODIGO = '". $rowsCertificacion[CODIGO_NORMA][$i] ."'  AND CD.SISTEMA = 'SECCL')";
        $parseRegistroFirma = oci_parse($conexion, $selectRegistroFirma);
        oci_execute($parseRegistroFirma);
        $numRowsRegistroFirma = oci_fetch_all($parseRegistroFirma, $rowsRegistroFirma);


        $update = "UPDATE T_CERTIFICACION_PRUEBA SET 
                FECHA_REGISTRO = '" . $rowsRegistroFirma[FECHA_CERTIFICACION][0] . "' 
                WHERE ID_CERTIFICACION = '" . $rowsCertificacion[ID_CERTIFICACION][$i] . "'";
        $parseUpdate = oci_parse($conexion, $update);
        $executeUpdate = oci_execute($parseUpdate);

        if ($executeUpdate == 1) {
            oci_commit($conexion);
        } else {
            oci_rollback($conexion);
        }
    }
}

