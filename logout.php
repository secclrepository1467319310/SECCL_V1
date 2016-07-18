<?PHP
  session_start();
  unset($_SESSION["USUARIO_LOGIN"]); 
  unset($_SESSION["USUARIO_NOMBRE"]);
  session_destroy();
  header("Location: index.php");
  exit;
?>