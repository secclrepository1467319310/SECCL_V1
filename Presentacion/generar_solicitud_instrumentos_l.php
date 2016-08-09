<?php
session_start();

if ($_SESSION['logged'] == 'yes')
{
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
}
else
{
    echo '<script>window.location = "../../index.php"</script>';
}

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$fecha = date('d/m/y');

extract($_POST);
$strSQL1 = "INSERT INTO T_OPERACION_BANCO
        (
        ID_T_OPERACION,
        ID_PROYECTO,
        ID_NORMA,
        N_GRUPO,
        USU_REGISTRO,
        OBSERVACION
        )
        VALUES ('$ddlTipoDescripcion','$hidProyecto','$hidNorma','$hidGrupo','$id','$txtObservacion') returning ID_OPERACION,FECHA_REGISTRO into :id,:fecha_sol  ";


$objParse1 = oci_parse($connection, $strSQL1);
OCIBindByName($objParse1, ":id", $idSolicitud, 32);
OCIBindByName($objParse1, ":fecha_sol", $fechaSolicitud, 32);
$objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
if ($objExecute1)
{
    oci_commit($connection); //*** Commit Transaction ***//



    $queryHis = ("SELECT * FROM T_OPERACION_BANCO OB "
            . "INNER JOIN T_ESTADO_SOLICITUD ES "
            . "ON OB.ID_OPERACION = ES.ID_SOLICITUD "
            . "WHERE OB.ID_PROYECTO = '$hidProyecto' "
            . "AND OB.ID_NORMA = $hidNorma "
//            . "/*AND OB.N_GRUPO = $hidGrupo */"
//            . "/*AND OB.ID_T_OPERACION = $ddlTipoDescripcion */"
//            . "AND ES.ID_TIPO_ESTADO_SOLICITUD = 4 "
            . "ORDER BY OB.ID_OPERACION DESC");
    $statementHis = oci_parse($connection, $queryHis);
    oci_execute($statementHis);
    $num_his = oci_fetch_all($statementHis, $row_his);

//    $queryCronograma = ("select * from CRONOGRAMA_USUARIO where  ESTADO='1' AND FECHA_CRONOGRAMA = '$fechaSolicitud' AND ID_T_TIPO_OPERACION_BANCO = $ddlTipoDescripcion");
//    $statementCronograma = oci_parse($connection, $queryCronograma);
//    oci_execute($statementCronograma);
//    $num_cro = oci_fetch_all($statementCronograma, $row_cronograma);
    
    $revisarUsuarios="SELECT U.USUARIO_ID ,SUM(CASE WHEN TES.ID_SOLICITUD IS NULL AND TOB.ID_OPERACION IS NOT NULL THEN 1 ELSE 0 END ) CNT
        FROM USUARIO U 
        LEFT JOIN T_SOLICITUDES_ASIGNADAS TSA ON (TSA.USUARIO_ASIGNADO=U.USUARIO_ID AND EXTRACT(YEAR FROM tsa.FECHA_REGISTRO) ='2016' AND TSA.ESTADO='1')
        LEFT JOIN T_OPERACION_BANCO TOB ON (TOB.ID_OPERACION=TSA.ID_SOLICITUD)
        
        LEFT JOIN T_ESTADO_SOLICITUD TES ON (TES.ID_SOLICITUD=TSA.ID_SOLICITUD)
        WHERE U.ROL_ID_ROL='2' AND U.ESTADO='1' AND U.USUARIO_ID != '304815'
        GROUP BY U.USUARIO_ID  order by CNT DESC";
    $sRevisarUsuarios=oci_parse($connection, $revisarUsuarios);
    oci_execute($sRevisarUsuarios);
    $nRevisarUsuarios=oci_fetch_all($sRevisarUsuarios, $rRevisarUsuarios);
    $asesor1=0;
    $centinela=0;
//    var_dump($rRevisarUsuarios);
    for($i=0;$i<$nRevisarUsuarios;$i++){
        if($i==0){$asesor1=$rRevisarUsuarios[USUARIO_ID][$i];$centinela=$rRevisarUsuarios[CNT][$i];}
        else{
            if($centinela!=$rRevisarUsuarios[CNT][$i]){
                $asesor1=$rRevisarUsuarios[USUARIO_ID][$i];
                break;
            }
        }
        
        
    }

    if ( $ddlTipoDescripcion==3 ){
        $asesor1 = '304815';
    }

    if($num_his > 0){
        $usuario_asignado = $row_his['USUARIO_ID'][0];
        $observacion = 'Asignada Automaticamente por el sistema Devolución Previa';
    }else{
        $usuario_asignado = $asesor1;
        $observacion = 'Asignada Automaticamente por el sistema';
    }

    if ($nRevisarUsuarios > 0)
    {
        $strSQL2 = "INSERT INTO T_SOLICITUDES_ASIGNADAS
        (
        ID_SOLICITUD,
        USUARIO_ASIGNADO,
        ID_USUARIO_REGISTRO,
        OBSERVACION,
        ESTADO
        )
        VALUES ('$idSolicitud','" . $usuario_asignado . "','$id','$observacion','1')";

//echo $strSQL2;
        $objParse2 = oci_parse($connection, $strSQL2);
        $objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
        if ($objExecute2)
        {
            oci_commit($connection); //*** Commit Transaction ***//
        }
        else
        {
            oci_rollback($connection); //*** RollBack Transaction ***//
            $e = oci_error($objParse2);
            echo "Error Save [" . $e['message'] . "]";
        }
    }
//    if ($num_cro > 0)
//    {
//        $strSQL2 = "INSERT INTO T_SOLICITUDES_ASIGNADAS
//        (
//        ID_SOLICITUD,
//        USUARIO_ASIGNADO,
//        ID_USUARIO_REGISTRO,
//        OBSERVACION,
//        ESTADO
//        )
//        VALUES ('$idSolicitud','" . $usuario_asignado . "','$id','$observacion','1')";
//
//
//        $objParse2 = oci_parse($connection, $strSQL2);
//        $objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
//        if ($objExecute2)
//        {
//            oci_commit($connection); //*** Commit Transaction ***//
//        }
//        else
//        {
//            oci_rollback($connection); //*** RollBack Transaction ***//
//            $e = oci_error($objParse2);
//            echo "Error Save [" . $e['message'] . "]";
//        }
//    }
}
else
{
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse1);
    echo "Error Save [" . $e['message'] . "]";
}

oci_close($connection);

echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
//die();
?>

<script type="text/javascript">
    window.location = "consultar_grupo.php?proyecto=<?php echo $hidProyecto ?>&norma=<?php echo $hidNorma ?>&grupo=<?php echo $hidGrupo ?> ";
</script>