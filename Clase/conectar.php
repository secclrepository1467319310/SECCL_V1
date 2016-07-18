<?php

//$bd_host = "//PSNMVBOGGXBD.SENA.RED:1521/orcl.SENA.RED"; // nombre del servidor
//$bd_usuario = "ADMIN_SECCL";//username de la BD
//$bd_pwd = "ADMIN_SECCL_2014";// password de la BD

$bd_usuario = 'ADMIN_SECCL';
$bd_pwd = 'SECCL_adm_2015';
$bd_host = '(DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST =172.29.11.126)(PORT = 1521))
)
(CONNECT_DATA =
(SID = seccl)
(SERVER = DEDICATED)
)
)';

function conectar($host, $username, $pass) {
    $link = ocilogon($username, $pass, $host);
    if ($link) {

//        echo "<script>alert('Base de datos de prueba, los cambios realizados no se tomaran en SECCL');</script>";
        echo "";
    } else {
        echo "No se pudo completar la conexión al servidor <strong>$servidor</strong>, revise los datos de conexión";
    }
//var_dump($link);
//$e=oci_error();
//var_dump($e);
    return $link;
}


function arreglarTexto($text,$e) {
    
    $text = str_replace("##ID_USUARIO##", $_SESSION[USUARIO_ID], $text);
    $text = str_replace("##ID_ROL##", $_SESSION[rol], $text);
//        ECHO "hola1";
    $text = preg_replace_callback("|##Q[\w\d.\ \=\'\#]*?##|", function($e) {
//        var_dump($e);
        $conexion=conectar('(DESCRIPTION =
            (ADDRESS_LIST =
            (ADDRESS = (PROTOCOL = TCP)(HOST = 172.29.11.126)(PORT = 1521))
            )
            (CONNECT_DATA =
            (SID = seccl)
            (SERVER = DEDICATED)
            )
            )','ADMIN_SECCL','SECCL_adm_2015');
//        var_dump($e);
//        ECHO "<hr/>";
          $tempQuery = preg_replace("(^##Q|##$)", "", $e[0]);
//          var_dump($tempQuery);
//        ECHO "<hr/>";
        $sTempQuery = oci_parse($conexion, 
                $tempQuery);
        oci_execute($sTempQuery);
        $rTempQuery = oci_fetch_array($sTempQuery, OCI_NUM);
//        var_dump($rTempQuery[0]);
        return $rTempQuery[0];
    }, $text);
        
    return $text;
}

?>