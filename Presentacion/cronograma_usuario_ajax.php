<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
extract($_POST);
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
//var_dump($_POST);
$qComprobacion="SELECT 
                    COUNT(DISTINCT CU.ID_CRONOGRAMA_USUARIO) CNT1, 
                    COUNT(DISTINCT CU2.ID_CRONOGRAMA_USUARIO)CNT2,
                    COUNT(DISTINCT CU3.ID_CRONOGRAMA_USUARIO) CNT3 
                  FROM CRONOGRAMA_USUARIO CU 
                  LEFT JOIN CRONOGRAMA_USUARIO CU2 
                  ON(CU2.ID_T_TIPO_OPERACION_BANCO=CU.ID_T_TIPO_OPERACION_BANCO 
                    AND CU2.FECHA_CRONOGRAMA=CU.FECHA_CRONOGRAMA 
                    AND CU2.ID_USUARIO_ASIGNADO='$usuario_antiguo' AND  CU.ID_CRONOGRAMA_USUARIO=CU2.ID_CRONOGRAMA_USUARIO
                    AND CU2.ESTADO='1'    
                    ) 
                  LEFT JOIN CRONOGRAMA_USUARIO CU3 
                  ON(CU3.ID_T_TIPO_OPERACION_BANCO =CU.ID_T_TIPO_OPERACION_BANCO 
                    AND CU3.FECHA_CRONOGRAMA=CU.FECHA_CRONOGRAMA 
                    AND CU3.ID_USUARIO_ASIGNADO != CU2.ID_USUARIO_ASIGNADO 
                    AND  CU.ID_CRONOGRAMA_USUARIO=CU2.ID_CRONOGRAMA_USUARIO
                    AND CU3.ESTADO='1'
                    ) 
                  WHERE CU.ID_T_TIPO_OPERACION_BANCO='$operacion' 
                    AND CU.FECHA_CRONOGRAMA='$fecha_cronograma' 
                    AND CU.ESTADO='1'";
//ECHO $qComprobacion;
//die();
$sComprobacion=  oci_parse($connection, $qComprobacion);
oci_execute($sComprobacion);
$rComprobacion=oci_fetch_array($sComprobacion, OCI_ASSOC);
//var_dump($rComprobacion);
if($rComprobacion[CNT2]==1 &&$rComprobacion[CNT3]==0){
    $qActualizarCronograma="UPDATE CRONOGRAMA_USUARIO SET ESTADO='0' WHERE ID_CRONOGRAMA_USUARIO='$id_cronograma_operacion'";
    $sActualizarCronograma=oci_parse($connection, $qActualizarCronograma);
    oci_execute($sActualizarCronograma);
    $nActualizarCronograma= oci_num_rows($sActualizarCronograma);
    if($nActualizarCronograma==1){
        $qInsertarCronograma="INSERT INTO CRONOGRAMA_USUARIO (FECHA_CRONOGRAMA, ID_USUARIO_REGISTRO,ID_USUARIO_ASIGNADO,ESTADO,ID_T_TIPO_OPERACION_BANCO)"
                . "VALUES"
                . "('$fecha_cronograma','$id','$usuario','1','$operacion')";
        $sInsertarCronograma=  oci_parse($connection, $qInsertarCronograma);
        if(oci_execute($sInsertarCronograma)){
            echo "1";
        }else{
            echo "2";
        }
    }else{
        echo "3";
    }
    
    
}else{
   echo "4"; 
   
}

