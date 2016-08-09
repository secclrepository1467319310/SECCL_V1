<?php
if(isset($_POST[query])){
    include_once '../Clase/conectar.php';
    $conexion=conectar($bd_host,$bd_usuario,$bd_pwd);
    $columns=$_POST[columns];
    $from=$_POST[from];
    $where=trim($_POST[where])!=""?" WHERE ".$_POST[where]:"";
    $qReturn =" SELECT $columns from $from $where";
    $sReturn = oci_parse($conexion, $qReturn);
    oci_execute($sReturn);
    $nReturn=oci_fetch_all($sReturn,$rReturn);   
    echo json_encode($rReturn,JSON_UNESCAPED_UNICODE);
}