<?php
//$conn = oci_connect('ADMIN_SECCL', 'ADMIN_SECCL_2014', '//PSNMVBOGGXBD.SENA.RED:1521/orcl.SENA.RED');
$conn = oci_connect('ADMIN_SECCL', 'ADMIN_SECCL_2014', '//172.25.59.164:1521/seccl');
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   echo "Conectado";
}
// Close the Oracle connection
oci_close($conn);
?>