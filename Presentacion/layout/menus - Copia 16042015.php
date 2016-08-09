<?php
require_once('../Clase/conectar.php');
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);
$query = "SELECT * FROM USUARIO WHERE USUARIO_ID = $id";
$result = ociparse($conexion, $query);
ociexecute($result);
$row = oci_fetch_array($result, OCI_BOTH);

if ($row["ROL_ID_ROL"] == 1) {
    
} else if ($row["ROL_ID_ROL"] == 2) {
    include("layout/menuBanco.php");
} else if ($row["ROL_ID_ROL"] == 3) {
    include("layout/menuAsesor.php");
} else if ($row["ROL_ID_ROL"] == 4) {
    include("layout/menuLider.php");
} else if ($row["ROL_ID_ROL"] == 5) {
    
} else if ($row["ROL_ID_ROL"] == 6) {
    
} else if ($row["ROL_ID_ROL"] == 7) {
    include("layout/menuEvaluador.php");
} else if ($row["ROL_ID_ROL"] == 8) {
    include("layout/menuMisional.php");
} else if ($row["ROL_ID_ROL"] == 9) {
    
} else if ($row["ROL_ID_ROL"] == 10) {
    include("layout/menuCandidato.php");
} else if ($row["ROL_ID_ROL"] == 11) {
    include("layout/menuApoyo.php");
} else if ($row["ROL_ID_ROL"] == 12) {
    include("layout/menuLiderRegional.php");
}else if ($row["ROL_ID_ROL"] == 13) {
    include("layout/menuadministradorbanco.php");
}else if ($row["ROL_ID_ROL"] == 14) {
    include("layout/menuconsulta.php");
}
?>

