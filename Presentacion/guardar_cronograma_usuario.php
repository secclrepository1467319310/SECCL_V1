<?php
session_start();
extract($_POST);

include("../Clase/conectar.php");
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);
//die($fecha_cronograma);
//var_dump($_POST);
//die("-----");
$fechas= explode(",",$fecha_cronograma);
switch ($tipo) {
	case 'C':
            foreach ($fechas as $fecha_cronograma){
        //var_dump($fecha_cronograma);
            $fecha_cronograma=date("d-m-Y", strtotime($fecha_cronograma));
	$cboolean=true;
		foreach ($usuarios as $key ) {
			$gcronogrupo= "INSERT INTO CRONOGRAMA_USUARIO 
			(FECHA_CRONOGRAMA,ID_USUARIO_REGISTRO,ID_USUARIO_ASIGNADO,OBSERVACION,ESTADO,ID_T_TIPO_OPERACION_BANCO)
			VALUES ('".$fecha_cronograma."', '$_SESSION[USUARIO_ID]',$key,'$observacion',1,'$tipo_operacion')";
			

			$sgcronogrupo= oci_parse($conexion, $gcronogrupo);
			$ecronogrupo=oci_execute($sgcronogrupo,OCI_DEFAULT);
			$cboolean=$cboolean?($ecronogrupo?true:false):false;
		}
		if($cboolean)
		{
			oci_commit($conexion); //*** Commit Transaction ***//
			echo "<script> alert(\"Guardado con éxito\")</script>";
			
		}
		else
		{
			oci_rollback($conexion); //*** RollBack Transaction ***//
			$e = oci_error($sgcronogrupo); 
			echo "<script> alert(\"Error\")</script>";
			echo "--------------";
			var_dump($e);
			echo "-------------------";
			die("Error");
		}
            }
		//die("");
		break;
	case 'M':
            foreach ($fechas as $fecha_cronograma){
        //var_dump($fecha_cronograma);
                $fecha_cronograma=date("d-m-Y", strtotime($fecha_cronograma));
		$activo=$activo=="1"?1:0;
		$usuarios= ($usuarios[0]!=null)?$usuarios[0]:0;
		$ucronogrupo= "UPDATE CRONOGRAMA_USUARIO SET FECHA_CRONOGRAMA='".$fecha_cronograma."', ID_USUARIO_ASIGNADO=$usuarios,OBSERVACION='$observacion', 				ESTADO=$activo, ID_T_TIPO_OPERACION_BANCO='$tipo_operacion'
					WHERE ID_USUARIO_REGISTRO='$_SESSION[USUARIO_ID]' AND ID_CRONOGRAMA_USUARIO=$idcu";		
		$sucronogrupo= oci_parse($conexion, $ucronogrupo);
		$ucronogrupo=oci_execute($sucronogrupo,OCI_DEFAULT);
		

		if($ucronogrupo)
		{
			oci_commit($conexion); //*** Commit Transaction ***//
			echo "<script> alert(\"Modificado con éxito\")</script>";
			
		}
		else
		{
			oci_rollback($conexion); //*** RollBack Transaction ***//
			$e = oci_error($sucronogrupo); 
			echo "<script> alert(\"Error\")</script>";
			die("Error".$e);
		}
            }
		break;	
	
	default:
		echo "<script> alert(\"Hay un error llamar a servicio ténico\")</script>";
		break;
}


header("Location:cronograma_usuario.php");