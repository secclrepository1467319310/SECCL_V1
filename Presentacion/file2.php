<?php
include("../Clase/conectar.php");
$Conn = conectar($bd_host, $bd_usuario, $bd_pwd);
$id = $_GET["id"];
//$Conn = @OCILogon('certicompetencias', 'Ccompetencias7', '//localhost/orcl.0.16.99');

$query = "select BIN_DATA, FILENAME, FILESIZE, FILETYPE from PORTAFOLIO_PROCESO where ID_PORTAFOLIO_PROCESO=$id";
$stmt = OCIParse($Conn, $query);

$NewData = array();
OCIDefineByName($stmt,"BIN_DATA",$NewData["BIN_DATA"]);
OCIDefineByName($stmt,"FILETYPE",$NewData["FILETYPE"]);

OCIExecute($stmt);
OCIFetch($stmt);

If (is_object($NewData["BIN_DATA"]))
{
$NewData["BIN_DATA"] = $NewData["BIN_DATA"]->load();
}
Header ("Content-type: $NewData[FILETYPE]");
echo $NewData["BIN_DATA"];
OCIFreeStatement($stmt);
?>