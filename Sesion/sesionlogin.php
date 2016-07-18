<?php
session_start();

if($_SESSION['logged']!='yes')
{
    require_once('../Clase/conectar.php');
    $connect = conectar($bd_host, $bd_usuario, $bd_pwd);

    //Recibir
    $rol = $_POST['rol'];
    $user = strip_tags($_POST['user']);
    $pass = $_POST['pass'];
    //$pass = strip_tags(sha1($_POST['pass']));

    if ($rol == null)
    {
        $query2 = ("SELECT ROL_ID_ROL FROM USUARIO WHERE USUARIO_LOGIN='$user' AND
        USUARIO_PASSWORD='$pass' AND ESTADO=1");
        $statement2 = oci_parse($connect, $query2);
        $resp2 = oci_execute($statement2);
        $r = oci_fetch_array($statement2, OCI_BOTH);
        $rol = $r[0];
    }

    $query = "SELECT * FROM USUARIO WHERE USUARIO_LOGIN='$user' AND
        USUARIO_PASSWORD='$pass' AND ROL_ID_ROL='$rol' AND ESTADO=1";
    $result = ociparse($connect, $query);
    ociexecute($result);

    while ($row = oci_fetch_array($result, OCI_BOTH))
    {
        $_SESSION['logged'] = 'yes';
        $_SESSION['NOMBRE'] = $row['NOMBRE'];
        $_SESSION['PRIMER_APELLIDO'] = $row['PRIMER_APELLIDO'];
        $_SESSION['USUARIO_ID'] = $row['USUARIO_ID'];
        $_SESSION['rol']=$row["ROL_ID_ROL"];
        if ($row["ROL_ID_ROL"] == 1)    {        
            echo '<script>window.location = "../Presentacion/menuadministrador.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 2)    {        
            echo '<script>window.location = "../Presentacion/menubanco.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 3)    {        
            echo '<script>window.location = "../Presentacion/menuasesor.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 4)    {        
            echo '<script>window.location = "../Presentacion/menulider.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 5)    {        
            echo '<script>window.location = "../Presentacion/menudigeneral.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 6)    {        
            echo '<script>window.location = "../Presentacion/menuauditor.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 7)    {        
            echo '<script>window.location = "../Presentacion/menuevaluador.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 8)    {        
            echo '<script>window.location = "../Presentacion/menumisional.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 9)    {        
            echo '<script>window.location = "../Presentacion/menuempresarial.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 10)    {        
            echo '<script>window.location = "../Presentacion/menucandidato.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 11)    {        
            echo '<script>window.location = "../Presentacion/menuapoyo.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 12)    {        
            echo '<script>window.location = "../Presentacion/menuliregional.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 13)    {        
            echo '<script>window.location = "../Presentacion/menuadministradorbanco.php"</script>';
        }
        else if ($row["ROL_ID_ROL"] == 14)    {        
            echo '<script>window.location = "../Presentacion/menuconsulta.php"</script>';
        }
        else if ($row["ROL_ID_ROL"]  == 15)    {        
            //echo '<script>window.location = "../Presentacion/menuconsulta.php"</script>';
            echo '<script>window.location = "../Presentacion/menuconsultaenlace.php"</script>';
        }
        else
        {
            echo("<SCRIPT>window.alert(\"No registrado o Datos Errados\")</SCRIPT>");
        }
    }
    oci_close($connect);
}
else
{
        if ($_SESSION['rol'] == 1)    {        
            echo '<script>window.location = "../Presentacion/menuadministrador.php"</script>';
        }
        else if ($_SESSION['rol'] == 2)    {        
            echo '<script>window.location = "../Presentacion/menubanco.php"</script>';
        }
        else if ($_SESSION['rol'] == 3)    {        
            echo '<script>window.location = "../Presentacion/menuasesor.php"</script>';
        }
        else if ($_SESSION['rol'] == 4)    {        
            echo '<script>window.location = "../Presentacion/menulider.php"</script>';
        }
        else if ($_SESSION['rol'] == 5)    {        
            echo '<script>window.location = "../Presentacion/menudigeneral.php"</script>';
        }
        else if ($_SESSION['rol'] == 6)    {        
            echo '<script>window.location = "../Presentacion/menuauditor.php"</script>';
        }
        else if ($_SESSION['rol'] == 7)    {        
            echo '<script>window.location = "../Presentacion/menuevaluador.php"</script>';
        }
        else if ($_SESSION['rol'] == 8)    {        
            echo '<script>window.location = "../Presentacion/menumisional.php"</script>';
        }
        else if ($_SESSION['rol'] == 9)    {        
            echo '<script>window.location = "../Presentacion/menuempresarial.php"</script>';
        }
        else if ($_SESSION['rol'] == 10)    {        
            echo '<script>window.location = "../Presentacion/menucandidato.php"</script>';
        }
        else if ($_SESSION['rol'] == 11)    {        
            echo '<script>window.location = "../Presentacion/menuapoyo.php"</script>';
        }
        else if ($_SESSION['rol'] == 12)    {        
            echo '<script>window.location = "../Presentacion/menuliregional.php"</script>';
        }
        else if ($_SESSION['rol'] == 13)    {        
            echo '<script>window.location = "../Presentacion/menuadministradorbanco.php"</script>';
        }
        else if ($_SESSION['rol'] == 14)    {        
            echo '<script>window.location = "../Presentacion/menuconsulta.php"</script>';
        }
        else if ($_SESSION['rol'] == 15)    {        
            echo '<script>window.location = "../Presentacion/menuconsultaenlace.php"</script>';
        }
        else
        {
		session_destroy();
         //   echo("<SCRIPT>window.alert(\"No registrado o Datos Errados\")</SCRIPT>");
        }
}
?>

<script type="text/javascript">
    alert("No registrado o Datos Errados");
    window.location = "/index.php";
</script>